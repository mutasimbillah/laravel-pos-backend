<?php

namespace App\Http\Controllers;

use App\Filters\OrderFilter;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OrderController extends ApiController {
    public function index(Request $request) {
        $query = OrderFilter::new ()->filters($request->all())->apply();
        $orders = $query->paginate($this->limit());
        return $this->success(OrderResource::collection($orders));
    }

    public function store(OrderRequest $request) {
        $data = $request->validated()['products'];
        $products = Product::findMany(Arr::pluck($data, 'id'));
        $subTotal = 0;
        $item = 0;
        foreach ($products as $product) {
            $subTotal += $product['price'] * $data[$item]['quantity'];
            $item++;
        }

        $state = State::where('id', $request['state_id'])->first();

        $tax = ($subTotal * $state['tax']) / 100;

        $order = Order::create([
            'customer_id' => $request['customer_id'],
            'state_id'    => $request['state_id'],
            'sub_total'   => $subTotal,
            'tax'         => $tax,
            'total'       => $subTotal + $tax,
        ]);

        $item = 0;
        $orderItems = array();
        foreach ($products as $product) {
            array_push($orderItems, OrderItem::create([
                'order_id'   => $order['id'],
                'product_id' => $product['id'],
                'price'      => $product['price'],
                'quantity'   => $data[$item]['quantity'],
            ]));
            $item++;
        }

        $order['order_items'] = $orderItems;
        return $this->success($order, "Order Created");
    }

    public function show(Order $order) {
        return $this->success(OrderResource::make($order));
    }

    public function update(OrderRequest $request, Order $order) {
        $orderItems = OrderItem::where('order_id', $order['id']);
        $orderItems->delete();

        $data = $request->validated()['products'];
        $products = Product::findMany(Arr::pluck($data, 'id'));
        $subTotal = 0;
        $item = 0;
        foreach ($products as $product) {
            $subTotal += $product['price'] * $data[$item]['quantity'];
            $item++;
        }
        $state = State::where('id', $request['state_id'])->first();
        $tax = ($subTotal * $state['tax']) / 100;

        $order['customer_id'] = $request['customer_id'];
        $order['state_id'] = $request['state_id'];
        $order['sub_total'] = $subTotal;
        $order['tax'] = $tax;
        $order['total'] = $subTotal + $tax;
        $order->save();

        $item = 0;
        $orderItems = array();
        foreach ($products as $product) {
            array_push($orderItems, OrderItem::create([
                'order_id'   => $order['id'],
                'product_id' => $product['id'],
                'price'      => $product['price'],
                'quantity'   => $data[$item]['quantity'],
            ]));
            $item++;
        }

        $order['order_items'] = $orderItems;
        return $this->success($order, "Order Updated");
    }

    public function destroy(Order $order) {
        $order->delete();
        return $this->success(null, "Order Deleted");
    }
}

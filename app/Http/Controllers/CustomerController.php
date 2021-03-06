<?php

namespace App\Http\Controllers;

use App\Filters\CustomerFilter;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\State;
use Illuminate\Http\Request;

class CustomerController extends ApiController {
    public function index(Request $request) {
        $query = CustomerFilter::new ()->filters($request->all())->apply();
        $customers = $query->paginate($this->limit());
        return $this->success(CustomerResource::collection($customers));
    }

    public function store(CustomerRequest $request) {
        $data = $request->validated();
        $state = State::find($data['state_id']);
        if (!$state) {
            return $this->failed("No state found with the id", 404);
        }
        $customer = Customer::query()->create($request->validated());
        return $this->success($customer);
    }

    public function show(Customer $customer) {
        return $this->success(CustomerResource::make($customer));
    }

    public function update(CustomerRequest $request, Customer $customer) {
        $data = $request->validated();
        $state = State::find($data['state_id']);
        if (!$state) {
            return $this->failed("No state found with the id", 404);
        }
        $customer->update($data);
        return $this->success(CustomerResource::make($customer));
    }

    public function destroy(Customer $customer) {
        $customer->delete();
        return $this->success(null, "Customer Deleted");
    }
}

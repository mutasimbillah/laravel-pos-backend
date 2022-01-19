<?php

namespace App\Http\Controllers;

use App\Filters\StateFilter;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StateRequest;
use App\Http\Resources\StateResource;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends ApiController
{
    public function index(Request $request)
    {
        $query = StateFilter::new()->filters($request->all())->apply();
        $states = $query->paginate($this->limit());
        return $this->success(StateResource::collection($states));
    }


    public function store(StateRequest $request)
    {
        $state = State::query()->create($request->validated());
        return $this->success($state);
    }

    public function show(State $state)
    {
        return $this->success(StateResource::make($state));
    }

    public function update(StateRequest $request, State $state)
    {
        $data = $request->validated();
        $state->update($data);
        return $this->success(StateResource::make($state));
    }

    public function destroy(State $state)
    {
        $state->delete();
        return $this->success(null, "State Deleted");
    }
}

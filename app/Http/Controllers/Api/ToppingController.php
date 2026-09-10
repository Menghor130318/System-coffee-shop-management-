<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreToppingRequest;
use App\Http\Requests\UpdateToppingRequest;
use App\Http\Resources\ToppingResource;
use App\Services\ToppingService;

class ToppingController extends Controller
{
    protected ToppingService $service;

    public function __construct(ToppingService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return ToppingResource::collection(
            $this->service->index()
        );
    }
    public function all()
    {
        return ToppingResource::collection(
            $this->service->all()
        );
    }
    public function store(
        StoreToppingRequest $request
    ) {
        return new ToppingResource(
            $this->service->create(
                $request->validated()
            )
        );
    }
    public function update(
        UpdateToppingRequest $request,
        $topping
    ) {
        return new ToppingResource(
            $this->service->update(
                $topping,
                $request->validated()
            )
        );
    }
    public function destroy($topping)
    {
        $this->service->delete($topping);

        return response()->json([
            "message" => "Xóa thành công"
        ]);
    }
}

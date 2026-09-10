<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSweetnessLevelRequest;
use App\Http\Requests\UpdateSweetnessLevelRequest;
use App\Http\Resources\SweetnessLevelResource;
use App\Services\SweetnessLevelService;

class SweetnessLevelController extends Controller
{
    protected SweetnessLevelService $service;

    public function __construct(
        SweetnessLevelService $service
    ) {
        $this->service = $service;
    }

    public function index()
    {
        return SweetnessLevelResource::collection(
            $this->service->index()
        );
    }

    public function all()
    {
        return SweetnessLevelResource::collection(
            $this->service->all()
        );
    }

    public function store(
        StoreSweetnessLevelRequest $request
    ) {
        return new SweetnessLevelResource(
            $this->service->create(
                $request->validated()
            )
        );
    }

    public function update(
        UpdateSweetnessLevelRequest $request,
        $sweetnessLevel
    ) {
        return new SweetnessLevelResource(
            $this->service->update(
                $sweetnessLevel,
                $request->validated()
            )
        );
    }

    public function destroy($sweetnessLevel)
    {
        $this->service->delete($sweetnessLevel);

        return response()->json([
            "message" => "Xóa thành công"
        ]);
    }
}

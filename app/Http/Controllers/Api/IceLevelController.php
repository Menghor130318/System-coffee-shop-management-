<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIceLevelRequest;
use App\Http\Requests\UpdateIceLevelRequest;
use App\Http\Resources\IceLevelResource;
use App\Services\IceLevelService;

class IceLevelController extends Controller
{
    protected IceLevelService $service;

    public function __construct(IceLevelService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return IceLevelResource::collection(
            $this->service->index()
        );
    }
    public function all()
    {
        return IceLevelResource::collection(
            $this->service->all()
        );
    }

    public function store(
        StoreIceLevelRequest $request
    ) {
        return new IceLevelResource(
            $this->service->create(
                $request->validated()
            )
        );
    }

    public function update(
        UpdateIceLevelRequest $request,
        $iceLevel
    ) {
        return new IceLevelResource(
            $this->service->update(
                $iceLevel,
                $request->validated()
            )
        );
    }

    public function destroy($iceLevel)
    {
        $this->service->delete($iceLevel);

        return response()->json([
            "message" => "Xóa thành công"
        ]);
    }
}

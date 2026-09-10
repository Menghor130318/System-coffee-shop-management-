<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SizeResource;
use App\Services\SizeService;
use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;

class SizeController extends Controller
{
    protected SizeService $sizeService;

    public function __construct(SizeService $sizeService)
    {
        $this->sizeService = $sizeService;
    }

    public function index()
    {
        return SizeResource::collection(
            $this->sizeService->index()
        );
    }
    public function all()
    {
        return SizeResource::collection(
            $this->sizeService->all()
        );
    }
    public function store(StoreSizeRequest $request)
    {
        return new SizeResource(
            $this->sizeService->create(
                $request->validated()
            )
        );
    }

    public function update(
        UpdateSizeRequest $request,
        $size
    ) {
        return new SizeResource(
            $this->sizeService->update(
                $size,
                $request->validated()
            )
        );
    }

    public function destroy($size)
    {
        $this->sizeService->delete($size);

        return response()->json([
            'message' => 'Xóa thành công'
        ]);
    }
}

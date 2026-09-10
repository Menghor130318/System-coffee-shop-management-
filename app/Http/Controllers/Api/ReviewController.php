<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Services\ReviewService;


class ReviewController extends Controller
{
    protected ReviewService $reviewService;

    public function __construct(
        ReviewService $reviewService
    ) {
        $this->reviewService = $reviewService;
    }

    public function index($id)
    {
        return response()->json(
            $this->reviewService->list($id)
        );
    }

    public function store(StoreReviewRequest $request, $id)
    {
        return response()->json(
            $this->reviewService->store([
                ...$request->validated(),
                'product_id' => $id
            ])
        );
    }
}

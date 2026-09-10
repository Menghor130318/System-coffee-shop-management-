<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Services\ProfileService;
use App\Http\Requests\UpdateAvatarRequest;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show()
    {
        return $this->success(
            $this->profileService->show()
        );
    }

    public function update(UpdateProfileRequest $request)
    {
        return $this->success(
            $this->profileService->update(
                $request->validated()
            ),
            'Cập nhật thông tin thành công.'
        );
    }
    public function me()
    {
        return $this->success(
            $this->profileService->me()
        );
    }
    public function updateAvatar(UpdateAvatarRequest $request)
    {
        return $this->success(
            $this->profileService->updateAvatar(
                $request->file('avatar')
            ),
            'Cập nhật ảnh đại diện thành công.'
        );
    }
}

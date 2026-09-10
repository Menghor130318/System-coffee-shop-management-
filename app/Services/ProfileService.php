<?php

namespace App\Services;

use App\Interfaces\ProfileRepositoryInterface;

class ProfileService
{
    protected ProfileRepositoryInterface $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function show()
    {
        return $this->profileRepository->show();
    }

    public function update(array $data)
    {
        return $this->profileRepository->update($data);
    }
    public function me()
    {
        return $this->profileRepository->me();
    }
    public function updateAvatar($file)
    {
        return $this->profileRepository->updateAvatar($file);
    }
}

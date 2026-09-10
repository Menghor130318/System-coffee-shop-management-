<?php

namespace App\Interfaces;

interface ProfileRepositoryInterface
{
    public function show();

    public function update(array $data);

    public function me();

    public function updateAvatar($file);
}

<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\ProfileRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function show()
    {
        return User::findOrFail(auth()->id());
    }

    public function update(array $data)
    {
        $user = auth()->user();

        $user->update([

            'full_name' => $data['full_name'],

            'phone' => $data['phone'] ?? null,

            'address' => $data['address'] ?? null,

        ]);

        return $user->fresh();
    }
    public function me()
    {
        return Auth::user();
    }

    public function updateAvatar($file)
    {
        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $file->store('avatars', 'public');

        $user->update([
            'avatar' => $path,
        ]);

        return $user->fresh();
    }
}

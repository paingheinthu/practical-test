<?php

namespace App\Services;

use App\Models\User;
use App\Contracts\UserInterface;
use Illuminate\Support\Facades\Hash;

class UserService implements UserInterface
{
    public function __construct(protected User $user)
    {
    }

    public function registerUser(string $name, string $email, string $password): ?User
    {
        return $this->user->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }

    public function getUser(string $email): ?User
    {
        return $this->user
            ->where('email', $email)
            ->first();
    }
}

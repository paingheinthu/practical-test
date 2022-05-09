<?php

namespace App\Contracts;

use App\Models\User;

interface UserInterface
{
    //new register user account
    public function registerUser(string $name, string $email, string $password): ?User;

    //fetch the user object with email
    public function getUser(string $email): ?User;
}

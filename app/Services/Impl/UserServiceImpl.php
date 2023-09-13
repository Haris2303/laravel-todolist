<?php

namespace App\Services\Impl;

use App\Services\UserService;

class UserServiceImpl implements UserService
{
    private array $users = [
        "udinsurudin" => "12345"
    ];

    public function login(string $user, string $password): bool
    {
        if (!isset($this->users[$user])) {
            return false;
        }

        $correctPassword = $this->users[$user];
        return $password == $correctPassword;
    }
}

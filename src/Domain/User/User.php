<?php

declare(strict_types=1);

namespace Domain\User;

class User
{
    public function __construct(private string $username, private string $email)
    {

    }
}
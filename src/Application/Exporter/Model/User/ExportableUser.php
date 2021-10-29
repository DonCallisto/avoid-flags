<?php

declare(strict_types=1);

namespace Application\Exporter\Model\User;

use Domain\User\User;
use JetBrains\PhpStorm\Pure;

class ExportableUser
{
    public function __construct(private User $user)
    {

    }

    #[Pure] public function getUsername(): string
    {
        return $this->user->getUsername();
    }

    #[Pure] public function getEmail(): string
    {
        return $this->user->getEmail();
    }
}
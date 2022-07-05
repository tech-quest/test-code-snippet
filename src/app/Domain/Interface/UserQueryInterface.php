<?php

namespace App\Domain\Interface;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\Email;
use App\Domain\Entity\User;

interface UserQueryInterface
{
    public function findByEmail(Email $email): ?User;
}

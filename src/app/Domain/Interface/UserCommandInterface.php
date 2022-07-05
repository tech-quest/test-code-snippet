<?php

namespace App\Domain\Interface;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Domain\ValueObject\User\NewUser;

interface UserCommandInterface
{
  public function insert(NewUser $user): void;
}

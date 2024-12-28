<?php

namespace App\UseCases\Contracts\User;

use App\DTOs\User\StoreUserDTO;

interface StoreUserUseCaseInterface
{
    public function handle(StoreUserDTO $DTO);
}

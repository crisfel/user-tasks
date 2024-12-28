<?php

namespace App\Repositories\Contracts\User;

use App\DTOs\User\StoreUserDTO;
use App\DTOs\User\UpdateUserDTO;

interface UserRepositoryInterface
{
    public function store(StoreUserDTO $DTO): array;
    public function update(UpdateUserDTO $DTO): array;
    public function getByID(int $id);
    public function getByEmail(string $email);
    public function delete(int $id);
    public function getNotDeleted();
}

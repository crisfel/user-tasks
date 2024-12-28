<?php

namespace App\DTOs\User;

class UpdateUserDTO
{
    public int $id;
    public string $name;
    public string $email;
    public ?string $password;
    public ?array $taskIDs;

    public function __construct(int $id, string $name, string $email, ?string $password, ?array $taskIDs)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->taskIDs = $taskIDs;
    }
}

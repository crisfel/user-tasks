<?php

namespace App\DTOs\User;

class StoreUserDTO
{
    public string $name;
    public string $email;
    public string $password;
    public ?array $taskIDs;

    public function __construct(string $name, string $email, string $password, ?array $taskIDs)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->taskIDs = $taskIDs;
    }
}

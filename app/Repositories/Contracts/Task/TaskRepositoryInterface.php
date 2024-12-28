<?php

namespace App\Repositories\Contracts\Task;

interface TaskRepositoryInterface
{
    public function store(string $title, ?string $detail): array;
    public function getByID(int $id): array;
    public function getNotDeleted();

    public function update(int $id, string $title): array;

    public function delete(int $id);
}

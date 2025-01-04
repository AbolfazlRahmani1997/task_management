<?php

namespace App\Repositories\Interfaces;

use App\Models\Task;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    public function all(array $filters = []): Collection;

    public function findById(int $id, array $filters = []): Task;

    public function create(array $data): Task;

    public function update(Task $task, array $data): Task;

    public function delete(Task $task): bool;
}

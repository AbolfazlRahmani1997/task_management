<?php

namespace App\Services\Interfaces;

use App\Models\Task;
use Illuminate\Support\Collection;

interface TaskServiceInterface
{
    public function getTasks(array $filters = []): Collection;

    public function createTask(array $data): Task;

    public function getTask(int $id): ?Task;

    public function updateTask(int  $task, array $data): Task;

    public function deleteTask(Task $task): bool;

}

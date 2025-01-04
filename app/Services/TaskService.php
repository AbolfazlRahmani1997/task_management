<?php

namespace App\Services;


use App\Events\CreateTaskEvent;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Services\Interfaces\TaskServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TaskService implements TaskServiceInterface
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getTasks(array $filters = []): Collection
    {
        return Cache::remember("tasks_user_" . Auth::user()->id, now()->addMinutes(60), function () use ($filters) {
            return $this->taskRepository->all($filters);
        });

    }

    public function getTask(int $id): ?Task
    {
        $task = $this->taskRepository->findById($id);
        if (Auth::user()->hasRole('admin') || $task->user_id === Auth::user()->id) {
            return $this->taskRepository->findById($id);
        }
        abort(403);

    }

    public function createTask(array $data): Task
    {
        $task = $this->taskRepository->create($data);

        Log::info('Task created', ['task_id' => $task->id, 'user_id' => Auth::id()]);
        event(new CreateTaskEvent($data['user_id']));
        return $task;
    }

    public function updateTask(int $task, array $data): Task
    {
        $task = $this->taskRepository->findById($task);

        if (Auth::user()->hasRole('admin') || $task->user_id === Auth::user()->id) {
            $task = $this->taskRepository->update($task, $data);
            Log::info('Task updated', ['task_id' => $task->id, 'user_id' => Auth::id()]);
            event(new CreateTaskEvent($task->user_id));
            return $task;

        }
        abort(403);


    }

    public function deleteTask(Task $task): bool
    {
        $result = $this->taskRepository->delete($task);

        if ($result) {
            event(new CreateTaskEvent($task->user_id));
            Log::info('Task deleted', ['task_id' => $task->id, 'user_id' => Auth::id()]);
        }

        return $result;
    }
}

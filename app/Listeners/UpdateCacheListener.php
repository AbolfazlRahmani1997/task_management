<?php

namespace App\Listeners;

use App\Events\CreateTaskEvent;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class UpdateCacheListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CreateTaskEvent $event): void
    {

        $tasks = $this->taskRepository->all(['user_id' => $event->id]);
        Cache::put("tasks_user_" . $event->id, $tasks, now()->addMinutes(60));
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseWrapper;
use App\Http\Requests\Api\Task\StoreTaskRequest;
use App\Http\Requests\Api\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\Interfaces\TaskServiceInterface;

class TaskController
{


    public function __construct(private TaskServiceInterface $taskService, private ResponseWrapper $responseWrapper)
    {
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->responseWrapper
            ->setData($this->taskService->getTasks())
            ->setResource(TaskResource::class)
            ->setStatus(200)
            ->generateCollectionResponse();

    }


    public function store(StoreTaskRequest $request): \Illuminate\Http\JsonResponse
    {

        $task = $this->taskService->createTask($request->validated());
        if (!$task) {
            $this->responseWrapper->generateFailedResponse("cant create task");
        }
        return $this->responseWrapper->setData($task)->setResource(TaskResource::class)->setStatus(201)->generateSingleResponse();

    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        return $this->responseWrapper
            ->setData($this
                ->taskService
                ->getTask($id))
            ->setResource(TaskResource::class)
            ->setStatus(200)
            ->generateSingleResponse();
    }

    public function edit($id, UpdateTaskRequest $request): void
    {
        $this->taskService->updateTask($id, $request->validated());
    }
}

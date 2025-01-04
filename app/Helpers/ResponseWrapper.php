<?php

namespace App\Helpers;


use Illuminate\Http\JsonResponse;


class ResponseWrapper
{
    /**
     * api resource namespace
     *
     */
    protected string $resource;

    /**
     * set status for response
     * @var int
     */
    protected int $status;

    /**
     * Set Data for Response
     */
    protected mixed $data;

    /**
     * set message for response
     * @var string
     */
    protected array $message;

    /**
     * set message for wrapper
     * @return string
     */
    public function setMessage(string $message): self
    {
        $this->message['message'] = $message;
        return $this;
    }

    /**
     * set Data for wrapper
     * @return string
     */
    public function setData(mixed $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * set status
     * default Status
     * @param int $status
     * @return ResponseWrapper
     */
    public function setStatus(int $status = 200): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * set resource
     * @param string $resource
     * @return ResponseWrapper
     */
    public function setResource(string $resource): self
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * Generate Collection Data  Single
     * @return  JsonResponse
     */
    public function generateCollectionResponse(): JsonResponse
    {
        if (isset($this->message)) {
            return (new $this->resource)::collection($this->data)->additional($this->message)->response()->setStatusCode($this->status);
        }
        return (new $this->resource($this->data))::collection($this->data)->response()->setStatusCode($this->status);
    }

    /**
     * Generate Data  Single
     *
     */
    public function generateSingleResponse(): JsonResponse
    {
        if (isset($this->message)) {
            return (new $this->resource($this->data))->additional($this->message)->response()->setStatusCode($this->status);
        }

        return (new $this->resource($this->data))->response()->setStatusCode(200);
    }

    /**
     * Generate Failed Message
     * @param string|null $message
     * @return JsonResponse
     */
    public function generateFailedResponse(string $message = null): JsonResponse
    {
        return $this->generateGeneralMessage($message, 500);
    }

    /**
     * Generate Success Response
     * @return void
     */
    public function generateSuccessResponse(string $message = null): JsonResponse
    {
        return $this->generateGeneralMessage($message, 200);
    }

    /**
     * Generate general message for data
     * @param string|null $message
     * @param int|null $code
     * @return JsonResponse
     */
    private function generateGeneralMessage(string $message = null, int $code = null): JsonResponse
    {
        return \Illuminate\Support\Facades\Response::json(["message" => $message])->setStatusCode($code);
    }

    /**
     * Generate general message for data
     * @param string|null $message
     * @param int|null $code
     * @return JsonResponse
     */
    public function generateGeneralLogin(array $message = null, int $code = null): JsonResponse
    {
        return \Illuminate\Support\Facades\Response::json($message)->setStatusCode($code);
    }
}

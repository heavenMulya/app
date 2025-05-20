<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class jsonCustomeResponse
{
   protected bool $success;
    protected mixed $message;
    protected mixed $data;
    protected int $statusCode;

    public function __construct(bool $success,$message, $data, int $statusCode = 200)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    public function response()
    {
        return response()->json([
            'status' => $this->success ? 'success' : 'error',
            'message' => $this->message,
            'data' => $this->success ? $this->data : null,
        ], $this->statusCode);
    }
}

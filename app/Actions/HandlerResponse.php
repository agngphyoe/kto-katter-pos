<?php

namespace App\Actions;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

trait HandlerResponse
{
    public function responseSuccess($data, $status_code = Response::HTTP_OK, string $message = '')
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
            'status' => $status_code,
        ], $status_code);
    }

    public function responseValidationErrors(array $errors = [])
    {
        return response()->json([
            'success' => false,
            'errors' => $errors,
            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function responseUnauthorized($message, $status_code)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'status' => $status_code,
        ], $status_code);
    }

    public function responseCollection($data)
    {
        return response()->json([
            'success' => true,
            'status' => Response::HTTP_OK,
            'data' => $data,
        ], Response::HTTP_OK);
    }

    public function responseCollectionwithgroupby($data, $field_name)
    {
        return response()->json([
            'success' => true,
            'data' => $data->groupBy($field_name),
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function responseSuccessMessage($message, $status_code = Response::HTTP_OK)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'status' => $status_code,
        ], $status_code);
    }

    public function responseUnprocessable($message, $status_code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'status' => $status_code,
        ], $status_code);
    }
}
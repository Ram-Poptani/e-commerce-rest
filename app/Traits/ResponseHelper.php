<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ResponseHelper
{

    private function successResponse(mixed $data, int $code): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, $code);
    }

    protected function reportMultipleErrors(mixed $message, int $code)
    {
        return response()->json([
            'code' => $code,
            'error' => $message,
        ], $code);
    }
    protected function errorResponse(string $message, int $code): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'code' => $code,
            'error' => $message,
        ], $code);
    }

    protected function showAll(Collection $collection, int $code = 200) {
        return $this->successResponse([
            'code' => $code,
            'count' => $collection->count(),
            'data' => $collection
        ], $code);
    }

    protected function showOne(Model $model, int $code = 200) {
        return $this->successResponse([
            'code' => $code,
            'data' => $model
        ], $code);
    }

    protected function showMessage(string $message, int $code = 200) {
        return $this->successResponse(['data' => $message], $code);
    }

}

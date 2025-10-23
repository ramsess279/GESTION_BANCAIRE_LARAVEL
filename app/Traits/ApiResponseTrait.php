<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Retourne une réponse JSON formatée.
     *
     * @param bool $success
     * @param mixed $data
     * @param array $pagination
     * @param array $links
     * @param int $status
     * @return JsonResponse
     */
    public function apiResponse(bool $success, $data = null, array $pagination = [], array $links = [], int $status = 200): JsonResponse
    {
        $response = [
            'success' => $success,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        if (!empty($pagination)) {
            $response['pagination'] = $pagination;
        }

        if (!empty($links)) {
            $response['links'] = $links;
        }

        return response()->json($response, $status);
    }
}
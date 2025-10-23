<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'currentPage' => $this->currentPage(),
            'totalPages' => $this->lastPage(),
            'totalItems' => $this->total(),
            'itemsPerPage' => $this->perPage(),
            'hasNext' => $this->hasMorePages(),
            'hasPrevious' => $this->currentPage() > 1,
        ];
    }
}
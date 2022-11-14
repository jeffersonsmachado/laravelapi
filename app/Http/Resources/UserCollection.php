<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'links' => [
                'first' => 'http =>//example.com/pagination?page=1',
                'last' => 'http =>//example.com/pagination?page=1',
                'prev' => $this->url(1),
                'next' => $this->getUrlRange(1, 1)
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
                'to' => $this->lastItem(),
                'from' => $this->firstItem(),
            ]
        ];
    }
}

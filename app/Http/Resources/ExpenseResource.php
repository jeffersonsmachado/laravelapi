<?php

namespace App\Http\Resources;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'amount' => number_format((float)$this->amount, 2, '.', ''),
            'user' => new UserResource(User::findOrFail($this->user_id)),
            'date' => $this->date->format('d/m/Y H:m:s')
        ];
    }
}

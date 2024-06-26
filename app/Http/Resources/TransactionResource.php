<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'from' => $this->from,
            'amount' => $this->amount,
            'to' => $this->to,
            'result' => $this->result,
            'rate' => $this->rate,
            'created_at' => $this->created_at,
        ];
    }
}

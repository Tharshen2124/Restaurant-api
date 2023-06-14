<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderitemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ([
            'id'=> $this->id,
            'order_id' => $this->order_id,
            'menu_id' => $this->menu_id,
            'quantity' => $this->quantity
        ]);
    }
}

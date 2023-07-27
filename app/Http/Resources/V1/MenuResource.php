<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use App\Http\Resources\V1\CategoryCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ([
            'menu_item' => $this->menu_item,
            'type' => $this->type,
            'price' => number_format($this->price, 2),
            'image' => $this->image,
            /* 'categories' => new CategoryCollection($this->categories) */
        ]);
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Cart extends JsonResource
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
            'product_name' => $this->product->name,
            'quantity' => $this->quantity,
            'price' => number_format($this->variant->price, 2),
            'variant' => [
                'id' => $this->variant->id,
                'name' => $this->variant->name,
                'price' => number_format($this->variant->price, 2),
                'attributes' => $this->variant->attributes, // If the variant has attributes
            ],
        ];
    }
}

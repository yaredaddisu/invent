<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductSell extends JsonResource
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
            'type' => $this->type,
            'user_id' => $this->user_id,
            'question' => $this->question,
            'description' => $this->description,
            'totalPrice' => $this->totalPrice,
            'total_sold' => $this->total_sold,
            'sold_count' => $this->sold_count,
            'product_id' => $this->product_id,
            'total_quantity' => $this->total_quantity,
            'profit' => $this->profit,
            'data' => json_decode($this->data),
        ];   
     }
}

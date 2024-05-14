<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductList extends JsonResource
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
            'productName'=>$this->productName,
            'barCode'=>$this->barCode,
            'image_url' => $this->image ? URL::to($this->image) : null,
            'purchasePrice' => $this->purchasePrice,
            'salesPrice' => $this->salesPrice,
            'quantity' => $this->quantity,
            'created_at' => (new \DateTime($this->created_at))->format('Y/m/d '),
            'updated_at' => (new \DateTime($this->updated_at))->format('D -Y-m-d '),

          ];
    }
}

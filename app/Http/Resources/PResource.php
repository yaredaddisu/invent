<?php

namespace App\Http\Resources;

use \DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class PResource extends JsonResource
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
            'dateOfDelivery' => (new DateTime($this->dateOfDelivery))->format('Y-m-d  '),
            'dateOfPurchase' => (new DateTime($this->dateOfPurchase))->format('Y-m-d '),
            'status' => !!$this->status,
            'warehouse' => $this->getWarehouseAttribute(),
            'note' => $this->note,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'creator' => $this->getCreator(),
            'supplier'=>json_decode($this->supplier),
            'purchases' => json_decode($this->purchases),
            'created_at' => (new DateTime($this->dateOfPurchase))->format('D  Y-m-d '),

        ];
    }
}

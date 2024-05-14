<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class UserBuyReportsResource extends JsonResource
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
            'dateOfDelivery' => (new DateTime($this->dateOfDelivery))->format('D  Y-m-d '),
            'dateOfPurchase' => (new DateTime($this->dateOfPurchase))->format('D  Y-m-d '),
            'status' => !!$this->status,
            'note' => $this->note,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'creator' => $this->getCreator(),
            'warehouse' => $this->getWarehouseAttribute(),

            'supplier' => $this->getSupplier(),
            //'supplier'=>json_decode($this->supplier),
            'purchases' => json_decode($this->purchases),
            'created_at' => (new DateTime($this->dateOfPurchase))->format('D  Y-m-d '),

        ];      }
}

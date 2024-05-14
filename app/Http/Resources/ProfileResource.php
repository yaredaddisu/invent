<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'company' => $this->company,
            'address' => $this->address,
            'Vat' => $this->Vat,
            'Tin' => $this->Tin,
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d '),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d '),
 
        ];
    }
}

<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
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
            'name'=>$this->name,
            'location' => $this->location,
            'description' => $this->description,
            'capacity' => $this->capacity,
             'created_at' => (new DateTime($this->created_at))->format('Y/m/d '),
            'updated_at' => (new \DateTime($this->updated_at))->format('D -Y-m-d '),

         ];    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UpdatePaymentResource extends JsonResource
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
            'name' => $this->name,
            'phone' => $this->phone,
            'is_admin' => $this->is_admin,
            'status' => $this->status,
            'email' => $this->email,
            'plan' => $this->plans()->get(),
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d '),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d '),
          ];
    }
}

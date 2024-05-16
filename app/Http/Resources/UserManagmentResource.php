<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\URL;
 use Illuminate\Http\Resources\Json\JsonResource;

class UserManagmentResource extends JsonResource
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
            'house_id' => $this->house_id,
            'house' => $this->house,
            'phone' => $this->phone,
            'organization' => $this->organization,
            'price' => $this->price,
            'priceUpdate' => $this->priceUpdate,
            'is_admin' => !!$this->is_admin,
            'status' => !!$this->status,
            'is_super_admin' => !!$this->is_super_admin,
            'image_url' => $this->image ? URL::to($this->image) : null,
            'email' => $this->email,
            'profile' => $this->profile,
            'day_left' => $this->day_left,

            'created_at' => (new \DateTime($this->created_at))->format('D M Y-m-d '),
            'updated_at' => (new \DateTime($this->updated_at))->format('D M Y-m-d '),

        ];    }
}

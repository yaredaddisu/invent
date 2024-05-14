<?php

namespace App\Http\Resources;

use Nette\Utils\DateTime;
use Illuminate\Support\Facades\URL;
use App\Http\Resources\PlanResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'company' => $this->company,
            'address' => $this->address,
            'vat' => $this->Vat,
            'tin' => $this->Tin,
            'is_admin' => $this->is_admin,
            'is_super_admin' => $this->is_super_admin,
            'status' => $this->status,
            'image_url' => $this->image ? URL::to($this->image) : null,
            'email' => $this->email,
            'day_left' => $this->day_left,

             'created_at' => (new \DateTime($this->created_at))->format('Y-m-d '),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d '),

        ];
    }
}

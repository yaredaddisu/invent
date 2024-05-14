<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class LogoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $date = Carbon::parse($this->updated_at);

                $date2 = Carbon::parse($this->created_at);
        return [
            'id' => $this->id,
            'image_url' => $this->image ? URL::to($this->image) : null,
            'status' => $this->status,
            'created_at' =>  $date2->diffForHumans(),
            //'created_at' => (new \DateTime($this->created_at))->format('Y-m-d '),
            //'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d '),
            'updated_at' =>  $date->diffForHumans(),

        ];
    }
}

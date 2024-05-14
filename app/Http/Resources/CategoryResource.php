<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //$date2 = Carbon::parse($this->updated_at)->toDayDateTimeString();

        return [
            'id' => $this->id,
            'category'=>$this->category,
            'products_count' => $this->products_count,
            //'products' =>$this->products ? SurveyResource::collection($this->products) : null,
            'created_at' => (new DateTime($this->created_at))->format('Y/m/d '),
            'updated_at' => (new \DateTime($this->updated_at))->format('D -Y-m-d '),

         ];
    }
}

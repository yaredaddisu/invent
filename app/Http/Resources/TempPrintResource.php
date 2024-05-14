<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TempPrintResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'productName' => $this->productName,
            'salesPrice' => $this->salesPrice,
            'quantity' => $this->quantity,
            'survey_id' => $this->survey_id,
            'user_id' => $this->user_id,
            'created_at' => (new DateTime($this->created_at))->format('D M, Y-m-d '),
        ];
    }
}

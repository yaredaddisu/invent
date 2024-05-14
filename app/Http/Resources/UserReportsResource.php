<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class UserReportsResource extends JsonResource
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
            'creator' => $this->getCreator(),
             'productName' => $this->productName,
            'barCode' => $this->barCode,
            'house' => $this->house,
             'purchasePrice' => $this->purchasePrice,
            'salesPrice' => $this->salesPrice,
             'quantity' => $this->quantity,
            'remaining' =>$this->remaining,
            'profit' => $this->profit,
            'totalStockOutPrice' => $this->totalStockOutPrice,
            'Transaction' => $this->Transaction,
            'cart_date' =>Carbon::parse($this->created_at)->toDateString(),
            'updated_at' => (new \DateTime($this->updated_at))->format('D M, Y-m-d '),

          ];    }
}

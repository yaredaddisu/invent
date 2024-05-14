<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\URL;
use App\Http\Resources\StockInResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
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
            'user_id' => $this->user_id,
            'house_id' => $this->getWarehouseAttribute(),
            'creator' => $this->getCreator(),
            'productName'=>$this->productName,
            'barCode'=>$this->barCode,
            'image_url' => $this->image ? URL::to($this->image) : null,
            'purchasePrice' => $this->purchasePrice,
            'productQuatity' => $this->quantity,

            'salesPrice' => $this->salesPrice,
            'category' =>$this->category ? $this->category : null,
           // 'category' => CategoryResource::collection($this->category),
            'quantity' => $this->quantity,
            'status' => $this->status,
            'code' => $this->code,
            'size' => $this->size,
            'color' => $this->color,
            'brand' =>$this->brand,
            'stocks' =>$this->stocks()->orderBy('updated_at','desc')->get() ? StockInResource::collection($this->stocks()->orderBy('updated_at','desc')->get()) : null,
            'products' =>$this->products()->orderBy('updated_at','desc')->get() ? CartResource::collection($this->products()->orderBy('updated_at','desc')->get()) : null,
            'created_at' => (new \DateTime($this->created_at))->format('Y/m/d '),
            'updated_at' => (new \DateTime($this->updated_at))->format('D -Y-m-d '),

          ];
    }
}

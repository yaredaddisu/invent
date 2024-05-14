<?php

namespace App\Http\Resources;

use App\Http\Resources\TempPrintResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailsResource extends JsonResource
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
            'tax'=>$this->tax,
            'shipping'=>$this->shipping,
            'amount' => $this->amount,
            'TotalQuantity'=>$this->TotalQuantity,
            'TotalProduct' => $this->TotalProduct,
            'Reference' => $this->Reference,
            'name' => $this->name,
            'email'=>$this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'address' => $this->address,
            'Tin' => $this->Tin,
            'Vat' => $this->Vat,
            'Due' => $this->Due,
            'Note' => $this->Note,
            'PayedAmount' => $this->PayedAmount,
            'paymentMethod' => $this->paymentMethod,
            'questions' =>$this->questions ? CartResource::collection($this->questions) : null,
            'created_at' => (new \DateTime($this->created_at))->format('Y/m/d '),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y/m/d '),

            
         ];    }
}

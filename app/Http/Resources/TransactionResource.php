<?php

namespace App\Http\Resources;

use App\Models\TransactionDetail;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'customer_id' =>$this->customer_id,
            'payment_method' => $this->payment_method,
            'total' => $this->total,
            'evidence' => $this->evidence,
            'description' => $this->description,
            'month' => TransactionDetailResource::collection(TransactionDetail::where('transaction_id', $this->id)->get()),
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}

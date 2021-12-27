<?php

namespace App\Http\Resources;

use App\Models\FacilityRoomType;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'role' => $this->role,
            'email' => $this->email,
            'id_numer' => $this->customer->id_number,
            'gender' => $this->customer->gender,
            'address' => $this->customer->address,
            'phone_number' => $this->customer->phone_number,
            'whatsapp_number' => $this->customer->whatsapp_number,
            'status' => $this->customer->status,
            'room_id' => $this->customer->room_id,
            'room' => $this->customer->room->name,
            'room_type' => $this->customer->room->roomType->name,
            'price' => 'Rp ' . number_format($this->customer->room->roomType->price, 0, ',', '.'),
            'facility' => $this->customer->room->roomType->facility,
        ];
    }
}

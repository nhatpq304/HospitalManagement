<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'email'=> $this->email,
            'name' => $this->name,
            'address' => $this->address,
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'id_card_number' => $this->id_card_number,
            'medical_card_number'=> $this->medical_card_number,
            'avatar_image'=> $this->media[0]->media_link,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

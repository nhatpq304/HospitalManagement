<?php

namespace App\Http\Resources;

use App\Http\Enum\mediaType;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $avatar = $this->media->where('is_active',1)->firstWhere('media_type', mediaType::$AVATAR);

        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'address' => $this->address,
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'id_card_number' => $this->id_card_number,
            'medical_card_number' => $this->medical_card_number,
            'department' => $this->department,
            'avatar_image' => $avatar,
            'gender'=> $this->gender,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

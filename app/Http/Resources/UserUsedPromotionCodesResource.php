<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserUsedPromotionCodesResource extends JsonResource
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
            'id' => $this->user->id,
            'username' => $this->user->username,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
            'wallet' => [
                'id' => $this->user->wallet->id,
                'user_id' => $this->user->id,
                'balance' => $this->user->wallet->balance,
                'updated_at' => $this->user->wallet->updated_at,
            ]
        ];
    }
}

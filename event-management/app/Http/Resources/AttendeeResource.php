<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $requestData = parent::toArray($request);
        $userDetails = [
            'user_detail' => ''
        ];

//        return [...$requestData,...$userDetails];
        return $requestData;
    }
}

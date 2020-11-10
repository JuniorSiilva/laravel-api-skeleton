<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommonRelationReferenceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->getKey(),
            'name' => $this->name,
        ];
    }
}

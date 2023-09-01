<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'author' => $this->profile->name . ' ' . $this->profile->lastName,
            'content' => $this->content,
            'file' => $this->file,
            'date' => $this->created_at,
        ];
    }
}

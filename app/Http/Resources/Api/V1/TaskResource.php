<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Task;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
                'title' => $this->title,
                'body' => $this->body,
                'status' => Task::find($this->id)->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->when($this->updated_at != $this->created_at, $this->updated_at)
        ];
    }
}

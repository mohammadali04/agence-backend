<?php
namespace Modules\Blog\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class BlogResource extends JsonResource{
    public function toArray($request){
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $this->image_url,
            'thumbnail' => $this->thumbnail_url,
            'body' => $this->body,
            'published_at' => $this->published_at
        ];
    }
}

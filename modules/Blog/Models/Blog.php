<?php
namespace Modules\Blog\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    protected $fillable = ['title','slug','image','thumbnail','body','published_at'];
    public function getImageUrlAttribute(){
        return Storage::url('blogs/images/'.$this->image);
    }
    public function getThumbnailUrlAttribute(){
        return Storage::url('blogs/thumbnails/'.$this->thumbnail);
    }
}

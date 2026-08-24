<?php
namespace Modules\Home\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
class Feature extends Model
{
    use HasFactory;
    protected $table = 'features';
    protected $fillable = ['title','icon'];
}

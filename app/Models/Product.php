<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    //protected $guarded=[];
    protected $fillable = ['name','slug','price','description'];
    //protected $hidden = ['slug']; // dönen değerde bir veri gösterilmek istenmezse

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }
}

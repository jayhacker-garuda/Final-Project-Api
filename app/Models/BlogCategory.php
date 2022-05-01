<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
        protected $guarded =[];

    // protected $fillable = [
    //   'name',
    //   'slug',
    // ];

    public function blog_posts()
    {
        return $this->hasMany(BlogPost::class,'blog_category_id','id');
    }
}
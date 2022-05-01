<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $dates = [
            'created_at',
            'updated_at',
        ];
    // protected $fillable = [
    //     'user_id',
    //     'blog_post_id',
    //     'content'
    // ];

    public function blogger()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function blog_post()
    {
        return $this->belongsTo(BlogPost::class, 'id', 'blog_post_id')
    }
}

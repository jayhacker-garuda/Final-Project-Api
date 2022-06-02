<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
    protected $guarded = [];
    

    // protected $fillable = [
    //     'user_id',
    //     'title',
    //     'content',
    //     'image_name',
    //     'slug',
    //     'days_spent',
    //     'blog_category_id',

    // ];


    public function blog_category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');
    }

    public function blogger()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function blog_comments()
    {
        return $this->hasMany(BlogComment::class,'blog_comment_id','id' );
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getBestComment()
    {
        return BlogComment::find($this->blog_comment_id);
    }

    public function bestComment()
    {
        return $this->belongsTo(BlogComment::class, 'blog_comment_id');
    }

    public function MarkAsBestComment(BlogComment $blog_comment)
    {
        $this->update([
            'blog_comment_id' => $blog_comment->id
        ]);

        if ($blog_comment->blogger->id == $this->blogger->id) {
            return;
        }
    }


    public function scopeFilterByCategory($builder)
    {
        if (request()->query('category')) {
            $category = BlogCategory::where('slug', request()->query('category'))->first();

            if($category)
            {
                return $builder->where('blog_category_id', $category->id);
            }
            return $builder;
        }

        return $builder;
    }

}

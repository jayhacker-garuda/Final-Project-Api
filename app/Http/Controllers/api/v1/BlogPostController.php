<?php

namespace App\Http\Controllers\api\v1;

use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostRequest;
use App\Models\BlogCategory;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the Blog Post.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all_blog_posts()
    {
        $blog_posts = BlogPost::FilterByCategory()->get();

        return response()->json([
           'body' => $blog_posts
        ],200);
    }

    /**
     * Display the specified Blog Post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function blog_post_byID($id)
    {
        $blog_post = BlogPost::find($id);

        if($blog_post){
            return response()->json([
                'body' => $blog_post
            ],200);
        }

        return response()->json([
                'message' => 'No data found'
        ],404);
    }

    /**
     * Store a newly created Blog Post in storage.
     *
     * @param  App\Http\Requests\BlogPostRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function blog_post_save(BlogPostRequest $request)
    {

        if ($request->has('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $request->image->storeAs('blog-images', $filename, 'public');
        }
        auth()->user()->blog_posts()->create([
            'title' => $request->title,
            'content' => $request->content,
            'image_name' => 'blog-images/'.$filename,
            'slug' => Str::slug($request->title),
            'visited_date' => $request->visited,
            'days_spent' => $request->days,
            'blog_category_id' => $request->category,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
        ]);

        return response()->json([
            'message' => 'Blog-Post created'
        ],200);

    }

    public function save_blog_category(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $blog_category = BlogCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);


        return response()->json([
            'message' => 'Category Successfully Created',
        ],200);
    }
    public function edit_blog_category($id)
    {

        // BlogCategory::where('id', $id)->update([
        //     'name' => $request->name,
        //     'slug' => Str::slug($request->name)
        // ]);
        $data = BlogCategory::find($id);

        (!$data)
        ? $error = 'No Data Found'
        : null;


        return response()->json([
            'body' => $data,
            'message' => ($error) ? $error : 'Category Successfully Loaded'
        ],200);
    }
    public function update_blog_category(Request $request, $id)
    {

        BlogCategory::where('id', $id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        // $data = BlogCategory::where('id', $id)->get();


        return response()->json([
            'message' => 'Category Successfully Updated'
        ],200);
    }

    public function delete_blog_category($id)
    {
        BlogCategory::find($id)->delete();

        return response()->json([
            'message' => 'Category Successfully Deleted'
        ],200);
    }

    public function all_blog_category()
    {
        $all_blog_category = BlogCategory::all();

        return response()->json([
            'body' => $all_blog_category
        ]);
    }

}

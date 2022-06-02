<?php

use App\Http\Controllers\api\v1\BlogPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\LoginController;
use App\Http\Controllers\api\v1\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/get-blog-category', [BlogPostController::class, 'all_blog_category']);
Route::get('/all-blog-post', [BlogPostController::class, 'all_blog_posts']);

Route::middleware(['auth:sanctum'])->group( function(){


    Route::post('/logout', function(Request $request) {

        $request->user()->tokens()->delete();


        return response()->json([
            'status' => 200,
            'message' => 'Logout successful'
        ]);

    })->middleware(['ability:admin,user']);


    Route::post('/store-blog-category', [BlogPostController::class, 'save_blog_category'])->middleware(['ability:admin']);
    Route::get('/edit-blog-category/{id}', [BlogPostController::class, 'edit_blog_category'])->middleware(['ability:admin']);
    Route::post('/update-blog-category/{id}', [BlogPostController::class, 'update_blog_category'])->middleware(['ability:admin']);
    Route::post('/delete-blog-category/{id}', [BlogPostController::class, 'delete_blog_category'])->middleware(['ability:admin']);

    Route::get('/get-blog-post/{id}', [BlogPostController::class, 'blog_post_byID']);
    Route::post('/store-blog-post', [BlogPostController::class, 'blog_post_save'])->middleware(['ability:admin']);

}) ;
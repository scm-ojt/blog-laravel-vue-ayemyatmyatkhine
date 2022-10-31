<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function create(PostRequest $request)
    {
        $post = new Post;
        $post->user_id = Auth::user()->id;
        $post->image = $request->image;
        $post->title = $request->title;
        $post->body = $request->description;
        $post->created_at = Date('Y-m-d');
        $post->save();
        $categories = $request->category;
        $post->categories()->attach($categories);
        return response()->json(['successMessage' => 'Post created successfully.']);
    }

    public function getPostList(Request $request)
    {
        $posts = Post::with('user')
                ->with('categories')->get();
        return response()->json($posts);   
    }

    public function delete(Id $id)
    {
        Post::find($id)->delete();
        return response()->json(['successMessage' => 'Post deleted successfully']);
    }
}

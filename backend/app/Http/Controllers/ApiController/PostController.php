<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $validate = $request->validate([
            'image' => 'max:100|mimes:jpeg,png,jpg,gif',
            'title' => 'required|max:100',
            'category_name' => 'required',
            'description' => 'required'
        ]);
        Post::create($request->all());
        return response()->json('success');
    }
}

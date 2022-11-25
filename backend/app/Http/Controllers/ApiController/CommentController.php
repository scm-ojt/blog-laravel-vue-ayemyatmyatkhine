<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        info($request->postId);
        $comment = new Comment;
        $comment->user_id = 1;
        $comment->post_id = $request->postId;
        $comment->body = $request->comment;
        $comment->created_at = Date('Y-m-d');
        $comment->save();
    }
}

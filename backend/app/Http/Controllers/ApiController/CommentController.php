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
        $comment = new Comment;
        $comment->post_id = $request->postId;
        $comment->body = $request->comment;
        $comment->user_id = 1;
        $comment->created_at = Date('Y-m-d');
        $comment->create();
    }
}

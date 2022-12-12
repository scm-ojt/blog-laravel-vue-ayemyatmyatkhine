<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * create post's comment
     * 
     * @param Illuminate/Request $request
     */
    public function create(Request $request)
    {
        $comment = new Comment;
        $comment->user_id = $request->userId;
        $comment->post_id = $request->postId;
        $comment->body = $request->comment;
        $comment->created_at = Date('Y-m-d H:i:s');
        $comment->save();
    }
}

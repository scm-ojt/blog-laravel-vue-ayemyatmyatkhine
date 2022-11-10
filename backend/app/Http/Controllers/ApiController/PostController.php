<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Post;
use App\Models\Category;
use App\Exports\ExportPost;
use App\Imports\ImportPost;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
    public function create(PostRequest $request)
    {
        $post = new Post;
        // $post->user_id = Auth::user()->id;
        $post->user_id = 1;
        $image = $request->file('image');
        Log::debug($image);
        $imageName = uniqid() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/images', $imageName);
        $post->image = $imageName;
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

    public function delete($id)
    {
        Post::where('id' , $id)->delete();
        return response()->json(['successMessage' => 'Post deleted successfully']);
    }

    public function search(Request $request)
    {
        $searchData = $request->searchData;
        Log::debug($searchData);
        $posts = Post::with('user')
        ->with('categories')->where('title' , 'like' , '%'.$searchData.'%')
                ->orWhere('body', 'like', "%" . $searchData . "%")
                ->orWhereHas('user', function ($user) use ($searchData) {
                    $user->where('name', 'like', "%" . $searchData . "%");
        })->get();
        return response()->json($posts);
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'import_file'  => 'required|max:2000|mimes:csv,xlsx'
        ]);
        $path = $request->file('import_file')->getRealPath();
        Excel::import(new ImportPost, $path);
        return response()->json(['message' => "Import Successfully"]);
    }

    public function export(Request $request)
    {
        $searchData = $request->searchData;
        return Excel::download(new ExportPost($searchData), 'posts.csv');
    }
}

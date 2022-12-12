<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Post;
use App\Models\Category;
use App\Exports\ExportPost;
use App\Imports\ImportPost;
use App\Models\CategoryPost;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\PostUpdateRequest;
use File;

class PostController extends Controller
{
    /**
     * create new post
     * 
     * @params Illuminate/Http/PostRequest $request
     * @return response
     */
    public function create(PostRequest $request)
    {
        $post = new Post;
        $post->user_id = $request->user_id;
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $post->image = $imageName;
        }
        else {
            $post->image = $request->image;
        }
        $post->title = $request->title;
        $post->body = $request->description;
        $post->created_at = Date('Y-m-d');
        $post->save();
        //for category
        $categories[] = $request->category;
        foreach($categories as $category){
            $post->categories()->attach($category);
        }

        return response()->json(['successMessage' => 'Post created successfully.']);
    }

    /**
     * get post list
     * 
     * @params Illuminate/Http/Request $request
     * @return Object $posts
     */
    public function getPostList(Request $request)
    {
        $posts = Post::with('user')
                ->with('categories')->orderBy('id' , 'DESC')->paginate(10); 

        return response()->json($posts);   
    }

    /**
     * delete post
     * 
     * @param Object $post
     * @return response
     */
    public function delete(Post $post)
    {
        $post->delete();

        return response()->json(['successMessage' => 'Post deleted successfully']);
    }

    /**
     * search post
     * 
     * @params Illuminate/Http/Request $request
     * @return Object $posts
     */
    public function search(Request $request)
    {
        $searchData = $request->searchData;
        $posts = Post::with('user')
        ->with('categories')->where('title' , 'like' , '%'.$searchData.'%')
                ->orWhere('body', 'like', "%" . $searchData . "%")
                ->orWhereHas('user', function ($user) use ($searchData) {
                    $user->where('name', 'like', "%" . $searchData . "%");
        })->get();

        return response()->json($posts);
    }

    /**
     * import csv file
     */
    public function import(Request $request)
    {
        $this->validate($request, [
            'import_file'  => 'required|max:2000|mimes:csv,xlsx'
        ]);
        $path = $request->file('import_file')->getRealPath();
        Excel::import(new ImportPost, $path);
        return response()->json(['message' => "Import Successfully"]);
    }

    /**
     * export csv file
     */
    public function export(Request $request)
    {
        $searchData = $request->searchData;
        return Excel::download(new ExportPost($searchData), 'posts.csv');
    }

    /**
     * get edit post by id
     * @param int $id
     * return Object $post
     */
    public function edit($id)
    {
        $post = Post::with('user')->with('categories')->where('id' , $id)->first();

        return response()->json($post);
    }

    /**
     * update post
     * 
     * @param Illuminate/Request PostRequest , int $id
     */
    public function update(PostRequest $request , $id)
    {
        $post = Post::with('user')->with('categories')->where('id' , $id)->first();
        if ($request->image) {
            $old_image = $post->image;
            File::delete('storage/images/' . $old_image);
            $image = $request->file('image');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $post->image = $imageName;
        }
        else {
            $post->image = $request->image;
        }
        $post->title = $request->title;
        $post->body = $request->description;
        $post->updated_at = Date('Y-m-d');
        $post->update();
        //for category
        $categories[] = $request->category;
        $categoryPost = CategoryPost::where('post_id' , $id)->get();
        foreach ($categories as $category) {
            $post->categories()->sync($category);
        }

        return response()->json(['successMessage' => 'Update Successfully']);
    }

    /**
     * get post detail
     * 
     * @param int $id
     * @return Object $post
     */
    public function getPostDetail($id)
    {
        $post = Post::where('id' , $id)->with(['user:id,name' , 'categories:id,name' , 'comments' => function($comment){
            $comment->orderBy('id' , 'DESC')->get();
        } , 'comments.user:id,name'])->first()->toArray();

        return response()->json($post);
    }
}

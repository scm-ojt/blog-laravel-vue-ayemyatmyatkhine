<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Post;
use App\Models\Category;
use App\Exports\ExportPost;
use App\Imports\ImportPost;
use App\Models\CategoryPost;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * create post
     */
    public function create(PostRequest $request)
    {
        $post = new Post;
        // $post->user_id = Auth::user()->id;
        $post->user_id = 1;
        if($request->hasFile('image')){
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
        $categories = $request->category;
        foreach($categories as $category){
            $post->categories()->attach($category);
        }
        return response()->json(['successMessage' => 'Post created successfully.']);
    }

    /**
     * get post list
     */
    public function getPostList(Request $request)
    {
        $posts = Post::with('user')
                ->with('categories')->get(); 
        return response()->json($posts);   
    }

    /**
     * delete post by id
     */
    public function delete($id)
    {
        Post::where('id' , $id)->delete();
        return response()->json(['successMessage' => 'Post deleted successfully']);
    }

    /**
     * search post
     */
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

    public function update(Request $request , $id)
    {
        $post = Post::with('user')->with('categories')->where('id' , $id)->first();
        if($request->hasFile('image')){
            Log::debug($request->file('image'));
            $image = $request->file('image');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $post->image = $imageName;
        }
        else {
            Log::debug($request->image);
            $post->image = $request->image;
        }
        $post->title = $request->title;
        $post->body = $request->description;
        $post->updated_at = Date('Y-m-d');
        $post->update();
        $categories = $request->category;
        $categoryPost = CategoryPost::where('post_id' , $id)->get();
        $categoryPosts = [];
        for($i=0; $i<count($categoryPost);$i++){
            array_push($categoryPosts , $categoryPost[$i]->category_id);
        }
        if (count($categoryPost) > count($categories)) {
            foreach($categoryPost as $category) {
                if(!in_array($category->category_id , $categories)){
                    CategoryPost::where('post_id' , $id)->where('category_id' , $category->category_id)->delete();
                }
            }
        }
        elseif (count($categoryPost) < count($categories)) {
            foreach ($categories as $category) {
                if(!in_array($category , $categoryPosts)) {
                    $post->categories()->attach($category);
                }
            }
        }
        return response()->json(['successMessage' => 'Update Successfully']);
    }

    public function getPostDetail($id)
    {
        $post = Post::with('user')->with('categories')->where('id' , $id)->first();
        return response()->json($post);
    }
}

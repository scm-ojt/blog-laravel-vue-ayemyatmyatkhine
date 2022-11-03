<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function create(CategoryRequest $request)
    {
        Log::debug("yes");
        $data = $request->all();
        $category = new Category;
        $category->name = $request->name;
        $category->created_at = Date('Y-m-d');
        $category->save();
        return response()->json(['successMessage' => 'Category created successfully']);
    }

    public function getCategoryList(Request $request)
    {
        $category = Category::get();
        return response()->json($category);
    }

    public function getCategory()
    {
        $category = Category::select('id' , 'name')->get();
        return response()->json($category);
    }

    public function delete(Id $id)
    {
        Category::find($id)->delete();
        return response()->json(['successMessage' => 'Category deleted successfully.']);
    }
}

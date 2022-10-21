<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function create(CategoryRequest $request)
    {
        $data = $request->all();
        $category = new Category;
        $category->name = $request->name;
        $category->created_at = Date('Y-m-d');
        $category->save();
        return response()->json(['successMessage' => 'Category created successfully']);
    }
}

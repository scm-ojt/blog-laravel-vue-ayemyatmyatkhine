<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\ExportCategory;
use App\Imports\ImportCategory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    /**
     * create new category
     */
    public function create(CategoryRequest $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->created_at = Date('Y-m-d');
        $category->save();
        return response()->json(['successMessage' => 'Category created successfully']);
    }

    public function getCategoryList(Request $request)
    {
        $category = Category::orderBy('id' , 'DESC')->paginate(10);

        return response()->json($category);
    }

    public function getCategory()
    {
        $category = Category::select('id as value' , 'name as label')->get();

        return response()->json($category);
    }

    public function delete(Category $category)
    {
        $category->delete();

        return response()->json(['successMessage' => 'Category deleted successfully.']);
    }

    public function search(Request $request)
    {
        $name = $request->category;
        $category = Category::where('name' , 'like' , '%'.$name.'%')->get();

        return response()->json($category);
    }

    public function export(Request $request)
    {
        $searchData = $request->searchData;
        return Excel::download(new ExportCategory($searchData), 'categories.csv');
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'import_file'  => 'required|max:2000|mimes:csv,xlsx'
        ]);
        $path = $request->file('import_file')->getRealPath();
        Excel::import(new ImportCategory, $path);
        return response()->json(['message' => "Import Successfully"]);
    }

    public function update(CategoryUpdateRequest $request , $id)
    {
        $category = Category::find($id);
        $category->name = $request->categoryName;
        $category->updated_at = Date('Y-m-d');
        $category->update();

        return response()->json(['successMessage' => 'Update Successfully']);
    }
}

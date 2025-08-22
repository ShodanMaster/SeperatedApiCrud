<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return response()->json([
            'status' => 200,
            'message' => 'Category fetched successfully',
            'data' => $categories
        ]);
    }

    public function store(Request $request){

        try {
            $request->validate([
                'name' => 'required|unique:categories'
            ]);

            $category = new Category();
            $category->name = $request->name;
            $category->save();

            return response()->json([
                'status' => 201,
                'message' => 'Category created successfully',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while creating the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id){
        try {

            $request->validate([
                'name' => 'required|unique:categories,name,'.$id
            ]);

            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->save();

            return response()->json([
                'status' => 200,
                'message' => 'Category updated successfully',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while updating the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id){
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Category deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while deleting the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function getCategoryProducts($id){
        $category = Category::with('products')->find($id);
        if(!$category){
            return response()->json([
                'status' => 404,
                'message' => 'Category not found'
            ], 404);
        }

        $categoryData = [
            'id' => $category->id,
            'name' => $category->name,
            'products' => $category->products ? $category->products : []
        ];

        return response()->json([
            'status' => 200,
            'message' => 'Category and its products fetched successfully',
            'data' => $categoryData
        ]);
    }
}

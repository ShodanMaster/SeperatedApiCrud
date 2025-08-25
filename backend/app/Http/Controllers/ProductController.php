<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        $products = $products->map(function($product){
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category ? $product->category->name : null,
            ];
        });

        return response()->json([
            'status' => 200,
            'message' => 'Product fetched successfully',
            'data' => $products
        ]);
    }

    public function store(Request $request){
        try{
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|unique:products',
            ]);

            $product = new Product();
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->save();

            return response()->json([
                'status' => 201,
                'message' => 'Product created successfully',
            ]);
        }catch(ValidationException $e){
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }catch(Exception $e){
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while creating the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id){
        try {
            $product = Product::findOrFail($id);
            return response()->json([
                'status' => 200,
                'message' => 'Product fetched successfully',
                'data' => $product
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while fetching the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id){
        try{
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|unique:products,name,'.$id,
            ]);

            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->save();

            return response()->json([
                'status' => 200,
                'message' => 'Product updated successfully',
            ]);
        }catch(ValidationException $e){
            return response()->json([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }catch(Exception $e){
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while updating the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id){
        try{
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Product deleted successfully',
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while deleting the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

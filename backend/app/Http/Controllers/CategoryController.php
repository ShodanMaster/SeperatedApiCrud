<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        return response()->json([
            'status' => 200,
            'message' => 'Category fetched successfully',
            'data' => []
        ]);
    }
}

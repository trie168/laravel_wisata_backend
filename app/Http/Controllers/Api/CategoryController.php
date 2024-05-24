<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //index
    public function index(Request $request)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $categories,
            'message' => 'Data retrieved successfully.'
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //index
    public function index(Request $request)
    {
        $products = Product::with('category')->when($request->status, function($query) use($request){
            $query->where('status', 'like', '%'.$request->status.'%');
        })->orderBy('favourite', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'products' => $products,
            'message' => 'Data retrieved successfully.'
        ], 200);
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
         //   'image' => 'image|file|max:1024',
            'category_id' => 'required|numeric',
            'status' => 'required|string',
            'criteria' => 'required|string',
            'favourite' => 'required|numeric',
        ]);

        // check if product already exists
        $product = Product::find($request->id);
        $status = 200; $message = 'Data updated successfully.';
        if(!$product) {
            $product = new Product();
            $status = 201; $message = 'Data created successfully.';
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->status = $request->status;
        $product->criteria = $request->criteria;
        $product->favourite = $request->favourite;
        $product->save();

        // upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.' . $image->extension());
            $product->image = '/products/' . $product->id . '.' . $image->extension();
            $product->save();
        }

        return response()->json([
            'status' => 'success',
            'product' => $product,
            'message' => $message
        ], $status);
    }

    //show
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found.'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'product' => $product,
            'message' => 'Data retrieved successfully.'
        ], 200);
    }

    //update
    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'image|file|max:1024',
            'category_id' => 'required|numeric',
            'status' => 'required|string',
            'criteria' => 'required|string',
            'favourite' => 'required|numeric',
        ]);

        $product = Product::find($request->id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found.'
            ], 404);
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->status = $request->status;
        $product->criteria = $request->criteria;
        $product->favourite = $request->favourite;

        //update image
        if($request->hasFile('image')){

            //delete old image
            $destination = 'public' . $product->image;
            if(file_exists($destination)){
                unlink($destination);
            }

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.' . $image->extension());
            $product->image = '/products' . $product->id . '.' . $image->extension();

        }

        $product->save();
        return response()->json([
            'status' => 'success',
            'product' => $product,
            'message' => 'Data updated successfully.'
        ], 200);
    }

    //destroy
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found.'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data deleted successfully.'
        ], 200);
    }

}

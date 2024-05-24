<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    //index
    public function index(Request $request)
    {
        $products = Product::when($request->search, function($query) use($request){
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('description', 'like', '%'.$request->search.'%');
        })->orderBy('id', 'desc')->paginate(10);
        return view('pages.products.index', compact('products'));
    }

    //create
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('pages.products.create', compact('categories'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'required',
            'category_id' => 'required',
            'status' => 'required',
            'criteria' => 'required',
            'favourite' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->status = $request->status;
        $product->criteria = $request->criteria;
        $product->favourite = $request->favourite;
        //image
        $image = $request->file('image');
        $image->storeAs('public/products', $product->id . '.' . $image->extension());
        $product->image = '/products' . $product->id . '.' . $image->extension();
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

}

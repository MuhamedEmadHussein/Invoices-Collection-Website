<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:المنتجات', ['only' => ['index']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['update']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        $products = Product::all();
        return view('products.products',compact('categories','products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'Product_name' => 'required|string|unique:products,Product_name,NULL,id,category_id,'.$request->category_id,
            'category_id' => 'required',
        ],[
            'Product_name.required' =>'يرجي ادخال اسم المنتج',
            'category_id.required'=>'يرجي ادخال اسم القسم',
            'Product_name.string' => 'يرجي إدخال نص ',
            'Product_name.unique' =>'اسم المنتج مسجل مسبقا لهذا القسم',
        ]);
        $description = $request->description ?? 'لا يوجد وصف أو ملاحظة';
        Product::create([
            'Product_name' => $request->Product_name,
            'category_id' => $request->category_id,
            'description' => $description
        ]);
        session()->flash('Add','تم إضافة المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->pro_id;
        //
        $validatedData = $request->validate([
            'Product_name' => 'required|string|unique:products,Product_name,'.$id,
        ],[
            'Product_name.required' =>'يرجي ادخال اسم المنتج',
            'Product_name.string' => 'يرجي إدخال نص ',
            'Product_name.unique' =>'اسم المنتج مسجل مسبقا لهذا القسم',
        ]);

        $description = $request->description ?? 'لا يوجد وصف أو ملاحظة';

        $product = Product::find($id);
        $category_id = Category::where('name',$request->category_name)->first('id')['id'];
        $product->update([
            'Product_name' => $request->Product_name,
            'category_id' => $category_id,
            'description' =>  $description
        ]);
        $product->save();
        session()->flash('Update','تم تعديل المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->pro_id;
        $product = Product::find($id);
        $product->delete();
        session()->flash('Delete','تم حذف المنتج بنجاح');
        return redirect('/products');
    }
}
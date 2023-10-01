<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:الاقسام', ['only' => ['index']]);
        $this->middleware('permission:اضافة قسم', ['only' => ['store']]);
        $this->middleware('permission:تعديل قسم', ['only' => ['update']]);
        $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        return view('categories.categories',compact('categories'));
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
            'name'=> 'required|unique:categories',
        ],[

            'name.required' =>'يرجي ادخال اسم القسم',
            'name.unique' =>'اسم القسم مسجل مسبقا',


        ]);
        $description = $request->description ?? 'لا يوجد وصف أو ملاحظة';
        
            Category::create([
                'name' => $request->name,
                'description' =>  $description,
                'created_by' => Auth::user()->name
            ]);

            session()->flash('Add','تم إضافة القسم بنجاح');
            return redirect('/categories');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $validatedData = $request->validate([
            'name'=> 'required|unique:categories,name,'.$id,
            
        ],[

            'name.required' =>'يرجي ادخال اسم القسم',
            'name.unique' =>'اسم القسم مسجل مسبقا',

        ]);
        
        $category = Category::find($id);
        $description = $request->description ?? 'لا يوجد وصف أو ملاحظة';
       
        $category->update([
                    'name'=>$request->name,
                    'description'=> $description
                ]);
        $category->save();
        session()->flash('Update','تم تعديل القسم بنجاح');
        return redirect('/categories');
        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $category = Category::find($id);
        $category->delete();
        session()->flash('Delete','تم حذف القسم بنجاح');
        return redirect('/categories');
    }
}
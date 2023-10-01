<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Invoices;
use Illuminate\Http\Request;

class CustomersReportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:تقرير العملاء', ['only' => ['index','search_customers']]);      
    
    }
    //
    public function index(){
        $categories = Category::all();
        return view('reports.customers_report',compact('categories'));
    }

    public function search_customers(Request $request){
        if($request->Section && $request->product && $request->start_at == '' &&  $request->end_at == ''){
            
           $invoices = Invoices::select('*')->where('category_id','=',$request->Section)->where('product','=',$request->product)->get();
           $categories = Category::all();
           return view('reports.customers_report',compact('categories'))->with('details', $invoices);


        }
        else{

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $invoices = Invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('category_id',$request->Section)->where('product',$request->product)->get();
            $categories = Category::all();
            return view('reports.customers_report',compact('categories','start_at','end_at'))->with('details', $invoices);
            
        }
    }
}
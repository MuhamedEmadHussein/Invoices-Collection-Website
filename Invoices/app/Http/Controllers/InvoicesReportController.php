<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Invoices;
use Illuminate\Http\Request;

class InvoicesReportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:تقرير الفواتير', ['only' => ['index','Search_invoices']]);      
    
    }
    //
    public function index(){
        return view('reports.invoices_reports');

    }
    public function Search_invoices(Request $request){
        $radio_selection = $request->radio;
        if($radio_selection == null){
            $radio_selection = 1; 
        }
       
        if($radio_selection == 1){
           // في حالة عدم تحديد تاريخ
        if ($request->type && $request->start_at =='' && $request->end_at =='') {
            
            $invoices = Invoices::select('*')->where('Value_Status','=',$request->type)->get();
            $type = $request->type;
        
            if($request->type == 1){
                $type = "مدفوعة";
                
              }else if($request->type == 2){
                $type = "غير مدفوعة";

              }else{
               $type = "مدفوعة جزئياً";
              }

            return view('reports.invoices_reports', compact('type'))->with('details', $invoices);
        }
         
         // في حالة تحديد تاريخ استحقاق
         else {
            
           $start_at = date($request->start_at);
           $end_at = date($request->end_at);
           $type = $request->type;
            
           $invoices = Invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('Value_Status','=',$request->type)->get();

           if($request->type == 1){
             $type = "مدفوعة";
           }else if($request->type == 2){
             $type = "غير مدفوعة";
           }else{
            $type = "مدفوعة جزئياً";
           }

           return view('reports.invoices_reports',compact('type','start_at','end_at'))->with('details', $invoices);
           
         }
    }else{
      
        $invoices = Invoices::select('*')->where('invoice_number',$request->invoice_number)->get();
        return view('reports.invoices_reports')->with('details', $invoices);
    }
}
}
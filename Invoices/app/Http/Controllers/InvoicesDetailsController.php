<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Invoices_attachments;
use App\Models\Invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:طباعةالفاتورة', ['only' => ['view_file','download_file']]);
        $this->middleware('permission:حذف المرفق', ['only' => ['destroy']]);
        $this->middleware('permission:الفواتير المدفوعة', ['only' => ['showPaidInvoices']]);
        $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['showPartialPaidInvoices']]);
        $this->middleware('permission:الفواتير الغير مدفوعة', ['only' => ['showUnPaidInvoices']]);  
    }
    /**
     * Display a listing of the resource.
     */
    public function view_file($invoice_number,$file_name){
        $file = public_path('Attachments'.'/'.$invoice_number.'/'.$file_name);
        return response()->file($file);
    }
    public function download_file($invoice_number,$file_name){
        $file = public_path('Attachments'.'/'.$invoice_number.'/'.$file_name);
        return response()->download($file);
    }
    public function index()
    {
        //
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
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $row = Invoices_attachments::findOrFail($request->id_file);
        $row->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('Delete','تم حذف المرفق بنجاح');
        return redirect()->back();
    }

    public function showPaidInvoices(){
        $invoices =  Invoices::where('Value_Status',1)->get();
        $title = 'المدفوعة';
        return view('invoices.payment_status_invoices',compact('invoices','title'));
    }

    public function showUnPaidInvoices(){
        $invoices = Invoices::where('Value_Status',2)->get();
        $title = 'غير المدفوعة';
        return view('invoices.payment_status_invoices',compact('invoices','title'));
        
    }
    public function showPartialPaidInvoices(){
        $invoices = Invoices::where('Value_Status',3)->get();
        $title = 'المدفوعة جزئياً';
        return view('invoices.payment_status_invoices',compact('invoices','title'));
        
    }
}

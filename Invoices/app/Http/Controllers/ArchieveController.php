<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Invoices_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchieveController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ارشفة الفاتورة', ['only' => ['update']]);
        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $invoices = Invoices::onlyTrashed()->get();
        return view('invoices.archieve',compact('invoices'));  
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $id = $request->invoice_id;
        Invoices::withTrashed()
        ->where('id',$id)
        ->restore();
   
        session()->flash('Update', 'تم نقل الفاتورة بنجاح');
        return redirect('/invoices');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->invoice_id;
        $invoice = Invoices::where('id',$id)->first();
        $detail = Invoices_attachments::where('invoice_id',$id)->first();

        if(!empty($detail->invoice_number)){
            Storage::disk('public_uploads')->deleteDirectory($detail->invoice_number);
        }

        Invoices::withTrashed()
        ->where('id',$id)
        ->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/archieve');
        
    }
}
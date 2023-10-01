<?php

namespace App\Http\Controllers;

use App\Models\Invoices_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:اضافة مرفق', ['only' => ['store']]);
    }
    /**
     * Display a listing of the resource.
     */
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
        $request->validate([
            'file_name' => 'required|mimes:jpeg,png,jpg,gif,pdf|max:5000',
        ],[
            'file_name.required' => 'يرجي إدخال مرفق ملف أو صورة',
            'file_name.mimes'=> '(pdf,png,jpg,jpeg,gif)نوع اللف أو الصورة يجب أن يكون',
            'file_name.max' => 'يجب أن لا تتعدي المساحة 5 ميجا بايت'
        ]);
        $fileName = $request->file_name->getClientOriginalName();
        Invoices_attachments::create([
            'file_name' => $fileName,
            'invoice_number' => $request->invoice_number,
            'Created_by' => Auth::user()->name,
            'invoice_id' => $request->invoice_id
        ]);
        $invoice_number = $request->invoice_number;
        $request->file('file_name')->storeAs($invoice_number, $fileName, 'public_uploads');
        session()->flash('Add','تم إضافة المرفق بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoices_attachments $invoices_attachments)
    {
        //
    }
}
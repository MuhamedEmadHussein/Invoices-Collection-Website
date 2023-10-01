<?php

namespace App\Http\Controllers;

use App\Events\RealTimeNotification;
use App\Models\Category;
use App\Models\Invoices;
use App\Models\Invoices_attachments;
use App\Models\Invoices_details;
use App\Models\Product;
use App\Models\User;
use App\Notifications\AddInvoiceNotification;
use App\Notifications\InvoiceAdded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
        $this->middleware('permission:تغير حالة الدفع', ['only' => ['show_payment_status','update_payment_status']]);
        $this->middleware('permission:طباعةالفاتورة', ['only' => ['print_invoice']]);
        $this->middleware('permission:تصدير EXCEL', ['only' => ['export']]);
    
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $invoices = Invoices::all();
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('invoices.add_invoice', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $note = $request->note ?? 'لا يوجد وصف أو ملاحظة';
        Invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'category_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $note,
        ]);

        $invoice_id = invoices::latest()->first()->id;
        Invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'category' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' =>  $note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {
            $request->validate([
                'pic' => 'required|mimes:jpeg,png,jpg,gif,pdf|max:5000',
            ],[
                'pic.required' => 'يرجي إدخال مرفق ملف أو صورة',
                'pic.mimes'=> '(pdf,png,jpg,jpeg,gif)نوع اللف أو الصورة يجب أن يكون',
                'pic.max' => 'يجب أن لا تتعدي المساحة 5 ميجا بايت'
            ]);

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new Invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }
        $id = Auth::user()->id;
        $user = User::find($id);
        Notification::send($user, new InvoiceAdded($invoice_id));
        
        $users = User::where("id","!=",$id)->get();
        $invoice = invoices::latest()->first();
        Notification::send($users,new AddInvoiceNotification($invoice));

        // event(new RealTimeNotification($invoice,now(),$user));
        
        session()->flash('Add','تم إضافة الفاتورة بنجاح');
        return redirect()->back();
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $invoice = Invoices::where('id',$id)->first();
        $invoices_details = Invoices_details::where('id_Invoice',$id)->get();
        $invoices_attachments = Invoices_attachments::where('invoice_id',$id)->get();
        return view('invoices.invoices_details',compact('invoice','invoices_details','invoices_attachments')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $invoice = Invoices::where('id',$id)->first();
        $categories = Category::all();
        return view('invoices.edit_invoice',compact('invoice','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        $invoices = Invoices::findOrFail($id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'category_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->invoice_id;
        $invoice = Invoices::where('id',$id)->first();
        // $details = Invoices_attachments::where('invoice_id',$id)->get();
        $detail = Invoices_attachments::where('invoice_id',$id)->first();
        $id_page = $request->id_page;
        if($id_page!=2){
            if(!empty($detail->invoice_number)){
                Storage::disk('public_uploads')->deleteDirectory($detail->invoice_number);
                // Storage::disk('public_uploads')->delete($detail->invoice_number.'/'.$detail->file_name);
            }
      
        
            $invoice->forceDelete();
            session()->flash('delete_invoice');
            return redirect('/invoices');

        }else{
            $invoice->delete();
            session()->flash('archieve_invoice');
            return redirect('/archieve');
        }
    }
    public function getProducts($id){
        $states = Product::where('category_id',$id)->pluck('Product_name','id');
        return json_encode($states);
    }
    public function show_payment_status($id){
        $invoices = Invoices::where('id',$id)->first();
        return view('invoices.status_update',compact('invoices'));
    }
    public function update_payment_status(Request $request,$id){
        $invoices = invoices::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'category' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'category' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');
    }

    public function print_invoice($id){
        $invoice = Invoices::where('id',$id)->first();
        return view('invoices.print_invoice',compact('invoice'));
    }

    public function export() 
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }
}
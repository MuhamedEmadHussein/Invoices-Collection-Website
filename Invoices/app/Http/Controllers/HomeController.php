<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Invoices_attachments;
use App\Models\Invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index(){
        $all_invoices_count = Invoices::count();
        if($all_invoices_count == 0){
            $all_total_invoices = 0;

        }else{
            $all_total_invoices = number_format(Invoices::sum('Total'), 2);

        }

        $unpaid_invoices_count = Invoices::where('Value_Status', 2)->count();        
        if($unpaid_invoices_count == 0){
            $unpaid_percentage = 0;    
            $unpaid_total_invoices = 0;

        }else{
            $unpaid_percentage = round(($unpaid_invoices_count / $all_invoices_count),2) * 100;
            $unpaid_total_invoices = number_format(Invoices::where('Value_Status', 2)->sum('Total'), 2);

        }
        
        $paid_invoices_count = Invoices::where('Value_Status', 1)->count();
        if($paid_invoices_count == 0){
            $paid_total_invoices = 0;
            $paid_percentage = 0;
        }else{
            $paid_total_invoices = number_format(Invoices::where('Value_Status', 1)->sum('Total'), 2);
            $paid_percentage = round(($paid_invoices_count / $all_invoices_count),2) * 100;

        }

        $partial_paid_invoices_count = Invoices::where('Value_Status', 3)->count();
        if($partial_paid_invoices_count == 0){
            $partial_paid_total_invoices = 0;
            $partial_paid_percentage = 0;
        }else{
            $partial_paid_total_invoices = number_format(Invoices::where('Value_Status', 3)->sum('Total'), 2);
            $partial_paid_percentage = round(($partial_paid_invoices_count / $all_invoices_count),2) * 100;

        }
        
        $chartjs = app()->chartjs
         ->name('barChartTest')
         ->type('bar')
         ->size(['width' => 350, 'height' => 200])
         ->labels(['نسبة الفواتير٪'])
        ->datasets([
             [
                 "label" => "الفواتير الغير مدفوعة٪",
                 'backgroundColor' => ['#f93a5a'],
                 'data' => [$unpaid_percentage]
             ],
             [
                 "label" => "الفواتير المدفوعة جزئياً٪",
                 'backgroundColor' => ['#f76a2d'],
                 'data' => [$partial_paid_percentage]
             ],
             [
                "label" => "الفواتير المدفوعة٪",
                'backgroundColor' => ['#029666'],
                'data' => [$paid_percentage]
            ],
         ])
         ->optionsRaw([          
            'legend' => [
                'display' => true,
                'labels' => [
                    'fontColor' => '#000',
                    'fontFamily' => 'Cairo',
                    'fontSize' => 12
                    // 'fontStyle'=> 'bold'
                  
                ]
            ],
            'scales' => [
                'xAxes' => [
                    [
                        'gridLines' => [
                            'display' => false
                        ]
                    ]
                ]
            ]
        ]);
        $chartjs_2 = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 340, 'height' => 266])
        ->labels(["الفواتير المدفوعة٪","الفواتير المدفوعة جزئياً٪","الفواتير المدفوعة٪"])
        ->datasets([
            [
                'backgroundColor' => ['#f93a5a', '#f76a2d','#029666'],
                'data' => [$unpaid_percentage, $partial_paid_percentage,$paid_percentage]
            ]
        ])
        ->options([]);
        return view('index',compact('all_total_invoices',
                                            'all_invoices_count',
                                            'unpaid_total_invoices',
                                            'unpaid_invoices_count',
                                            'unpaid_percentage',
                                            'paid_total_invoices',
                                            'paid_invoices_count',
                                            'paid_percentage',
                                            'partial_paid_total_invoices',
                                            'partial_paid_invoices_count',
                                            'partial_paid_percentage',
                                            'chartjs',
                                            'chartjs_2'));
    }
    public function markAsReadAll(){
        auth()->user()->unreadNotifications->markAsRead();
	    return redirect()->back();
        
    }
    public function markAsRead($notification_id,$invoice_id){
        $invoice = Invoices::where('id',$invoice_id)->first();
        $invoices_details = Invoices_details::where('id_Invoice',$invoice_id)->get();
        $invoices_attachments = Invoices_attachments::where('invoice_id',$invoice_id)->get();
        $user = Auth::user();

        DB::table('notifications')
        ->where('id', $notification_id)
        ->update(['read_at' => now()]);
        
        return view('invoices.invoices_details',compact('invoice','invoices_details','invoices_attachments'));
    }
}
<?php

namespace App\Exports;

use App\Models\Invoices;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

/**
 * Summary of InvoicesExport
 */
class InvoicesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Select specific columns from the Invoices model
        $selectedColumns = ['invoice_number', 'invoice_Date', 'Due_date', 'product','category_id','Discount','Rate_VAT','Value_VAT','Total','Status','note'];

    
        $invoices = Invoices::select($selectedColumns)->get();

    
        $dataCollection = new Collection();

    
        $dataCollection->push($this->headings());

        foreach ($invoices as $invoice) {
           
            $categoryName = $invoice->category ? $invoice->category->name : null;

            $invoice['category_name'] = $categoryName;

            $dataCollection->push($invoice);

        }

        return $dataCollection;
        // return Invoices::all();
    }
    public function headings(): array
    {
        return [
            'رقم الفاتورة',
            'تاريخ القاتورة',
            'تاريخ الاستحقاق',
            'المنتج',
            'القسم',
            'الخصم',
            'نسبة الضريبة',
            'قيمة الضريبة',
            'الاجمالي',
            'الحالة',
            'ملاحظات',
            'اسم القسم',
            // Add more header columns here
        ];
    }
}

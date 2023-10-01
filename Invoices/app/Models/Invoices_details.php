<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices_details extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function category_data(){
        
        return $this->belongsTo(Category::class);
    
    }
}
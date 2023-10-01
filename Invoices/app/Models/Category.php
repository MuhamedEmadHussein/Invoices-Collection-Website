<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products(){
        
        return $this->hasMany(Product::class);
    
    }

    public function invoices(){
        
        return $this->hasMany(Invoices::class);
    
    }
    public function invoices_details(){
        
        return $this->hasMany(Invoices_details::class);
    
    }
}
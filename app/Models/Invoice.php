<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // set where the invoice is tied to
    public function customer()
    {
        $this->belongsTo(Customer::class);
    }
}

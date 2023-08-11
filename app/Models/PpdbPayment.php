<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbPayment extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_ppdb_payment";
    protected $fillable = [
        'ppdb_id', 'invoice_id', 'ref_id', 'method', 'bill_id', 'name', 'desc','amount', 'status', 'is_notif_invoice', 'is_paid', 'is_notif_paid', 'cby', 'uby',
    ];
}

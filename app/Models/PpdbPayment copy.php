<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PpdbPayment extends Model
{
    // use HasFactory;
    const CREATED_AT = 'con';
    const UPDATED_AT = 'uon';
    protected $table = "aa_ppdb_payment";
    protected $fillable = [
        'ppdb_id', 'invoice_id', 'ref_id', 'method','account', 'bill_id', 'name', 'desc','amount', 'status', 'is_notif_invoice', 'is_paid', 'is_notif_paid', 'cby', 'uby',
    ];

    // public static function getLastId()
    // {
    //     $text = " SELECT MAX(id) AS id FROM aa_ppdb_payment";
    //     $query = DB::select($text);
    //     $resultArray = json_decode(json_encode($query), true);
    //     return $resultArray;
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbCost extends Model
{
    // use HasFactory;
    public $timestamps = false;
    protected $table = "aa_ppdb_cost";
    protected $fillable = [
        'ppdb_id',
        'cost_id',
        'amount',
    ];
}

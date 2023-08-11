<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BayanatMappingDtl extends Model
{
    // use HasFactory;
    public $timestamps = false;
    protected $table = "ep_bayanat_mapping_dtl";
    protected $fillable = [
        'id',
        'hdr_id',
        'pid',
    ];

    public static function getall()
    {
        $text = DB::select('SELECT ed.id, hdr_id, ed.pid, ap.name  FROM ep_bayanat_mapping_dtl AS ed
            LEFT OUTER JOIN aa_person AS ap ON ap.id = ed.pid
            LEFT OUTER JOIN ep_bayanat_mapping as em ON ed.hdr_id = em.id
            WHERE em.ayid = '.config('id_active_academic_year').'
            AND em.tid = '.config('id_active_term'));
        $return = collect($text);
        $return = json_decode(json_encode($return), true);
        return $return;
    }
}

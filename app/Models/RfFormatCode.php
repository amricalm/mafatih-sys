<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfFormatCode extends Model
{
    protected $table = "rf_format_code";
    protected $primaryKey = 'code';
    protected $fillable = [
        'desc'
    ];

    public static function getFormatCode($idprint) {
		switch ($idprint) {
            case '1':
                $return = 0;
                break;
            case '2':
                $return = 1;
                break;
            case '3':
                $return = 2;
                break;
            case 'pts':
                $return = 3;
                break;
            case 'rq':
                $return = 0;
                break;
            default:
                # code...
                break;
        }
		return $return;
	}
}

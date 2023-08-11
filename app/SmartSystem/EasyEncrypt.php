<?php

namespace App\SmartSystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class EasyEncrypt extends Model
{
    public static function encrypt($message)
    {
        $encrypted = Crypt::encryptString($message);
        return $encrypted;
    }

    public static function decrypt($message)
    {
        $encrypted = Crypt::decryptString($message);
        return $encrypted;
    }
}

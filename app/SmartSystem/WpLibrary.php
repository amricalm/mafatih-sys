<?php

namespace App\SmartSystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class WpLibrary extends Model
{
    public static function getLastFeed()
    {
        $request = Http::get('http://www.mahadsyarafulharamain.sch.id/wp-json/wp/v2/posts');
        return json_decode($request);
    }
    public static function getFeatureImage($id)
    {
        $request = Http::get('http://www.mahadsyarafulharamain.sch.id/wp-json/wp/v2/media/'.$id);
        return json_decode($request);
    }
}

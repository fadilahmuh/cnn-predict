<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Session;

trait GeneralFunction
{
    public static function generate_slug($nrp)
    {
        $uniq = $nrp;
        for ($i=0; $i < 3; $i++) { 
            $uniq = $uniq . '-'. self::generate_uniq(9);
            
        }
        return strtoupper($uniq);
    }

    public static function generate_uniq($limit)
    {
        $uniq = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);

        return $uniq;
    }   
}

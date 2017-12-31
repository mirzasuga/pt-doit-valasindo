<?php

namespace App\Http\Controllers\bbsv;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Image;


class BbsvUploadController extends Controller
{
    private static $filename;
    private static $dir;
    function __construct() {
        self::$filename = 'kuit_pembelian'.date('d_m_Y_H_i_s').'.png';
        self::$dir      = public_path().'/images/';
    }

    function upload(Request $request) {
        $image_parts        = explode(";base64,", $request->kuitansi_pembelian);
        $image_type_aux     = explode("image/", $image_parts[0]);
        $image_type         = $image_type_aux[1];
        $image_base64       = base64_decode($image_parts[1]);
        $file               = self::$dir . self::$filename;
        
        $response = [];
        if( $this->move($file,$image_base64) ) {
            $response = [
                'status'    => 200,
                'uploaded'  => self::$filename
            ];
        }
        else {
            $response = [
                'status'    => 401,
                'uploaded'  => ''
            ];
        }
        return response()->json($response);
    }
    private function move($file, $image_base64) {
        return file_put_contents($file, $image_base64);
    }
}

<?php
namespace Teckipro\Admin\Http\Controllers;
class OperationReport{

    public static function report($message,$status,$code=""){
        return array(
            'status'=>$status,
            'message'=>$message,
            'code'=>$code

        );
    }

    public static function httpReport($data){
       return response()->json($data, 200);
    }

}

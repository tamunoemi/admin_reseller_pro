<?php
namespace Teckipro\Admin\Traits;
use Illuminate\Http\Request;

trait EnvTrait
{

    public function setEnv($key, $value,$quote=false)
{
    //$app_name_original = 'APP_NAME="'.env('APP_NAME').'"';
    //$app_name_new = 'APP_NAME="'.$APP_NAME.'"';
    if($quote){
      $to_Replace = ''.$key.'="'.env($key).'"';
      $replace_to = ''.$key.'="'.$value.'"';
    }else{
      $to_Replace = ''.$key.'='.env($key).'';
      $replace_to = ''.$key.'='.$value.'';
    }


    file_put_contents(app()->environmentFilePath(), str_replace(
      $to_Replace,
      $replace_to,
    file_get_contents(app()->environmentFilePath())
    ));
}

}

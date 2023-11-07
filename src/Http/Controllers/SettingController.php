<?php

namespace Teckipro\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Teckipro\Admin\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;
use Teckipro\Admin\Traits\EnvTrait;



class SettingController
{

    use EnvTrait;

public $request;


    /** Mail setting */
   public function mailSettings(){
    return view('teckiproadmin::settings.mail');
   }


   public function updateMailSetting(Request $request){

    $validator = Validator::make($request->all(), [
      'MAIL_HOST' => 'required',
      'MAIL_PORT' => 'required',
      'MAIL_USERNAME' => 'required',
      'MAIL_PASSWORD' => 'required',
      'MAIL_ENCRYPTION'=>'required',
      'MAIL_FROM_ADDRESS'=>'required'
   ]);
   $validated = $validator->validated();

   $MAIL_HOST = $validated['MAIL_HOST'];
   $MAIL_PORT = $validated['MAIL_PORT'];
   $MAIL_USERNAME = $validated['MAIL_USERNAME'];
   $MAIL_PASSWORD = $validated['MAIL_PASSWORD'];
   $MAIL_ENCRYPTION = $validated['MAIL_ENCRYPTION'];
   $MAIL_FROM_ADDRESS = $validated['MAIL_FROM_ADDRESS'];



   //setting the app name
   $this->setEnv("MAIL_HOST",$MAIL_HOST);

   $this->setEnv("MAIL_PORT",$MAIL_PORT);
   $this->setEnv("MAIL_USERNAME",$MAIL_USERNAME);
   $this->setEnv("MAIL_PASSWORD",$MAIL_PASSWORD);
   $this->setEnv("MAIL_ENCRYPTION",$MAIL_ENCRYPTION);
   $this->setEnv("MAIL_FROM_ADDRESS",$MAIL_FROM_ADDRESS);

   return redirect()->route('admin.setting.mail')->withFlashSuccess(__('Mail setting successfully updated.'));


   }



   /** Brand setting */
   public function brandSettings(){
    return view('teckiproadmin::settings.brand');
   }

   public function updatebrandSettings(Request $request){
    $this->request = $request;
    if($this->request->has('favicon')){
      $this->updateFavicon();
    }elseif($this->request->has('general')){
      $this->updateSettingGeneral();
    }elseif($this->request->has('logo')){
      $this->updatelogo();
    }

     return redirect()->route('admin.setting.index')->withFlashSuccess(__('Setting successfully updated.'));

   }



   public function updateSettingGeneral(){

    $validator = Validator::make($this->request->all(), [
      'APP_URL' => 'required|url',
      'APP_NAME' => 'required|string|min:3'
    ]);

   $validated = $validator->validated();

    $APP_URL = $validated['APP_URL'];
    $APP_NAME = $validated['APP_NAME'];

    //setting the app name
    $this->setEnv("APP_NAME",$APP_NAME,true);
    $this->setEnv("APP_URL",$APP_URL,true);

    return true;

   }






  public function updatelogo(){

    $validator = Validator::make($this->request->all(), [
      'logo' =>'required|mimes:png|max:2048',

   ],$messages =[
    'logo.required' => 'Upload app logo',
   ]);

   $validated = $validator->validated();
   $fileName = 'logo.'.$this->request->logo->extension();
   $this->request->logo->move(public_path(), $fileName);

   return true;

   }



   public function updateFavicon(){
    $validator = Validator::make($this->request->all(), [
      'favicon' =>'required|mimes:ico|max:2048',

   ],$messages =[
    'favicon.required' => 'Upload app favicon. It must have .ico as the extension.',
   ]);

   $validated = $validator->validated();
   $fileName = 'favicon.'.$this->request->favicon->extension();
   $this->request->favicon->move(public_path(), $fileName);

   return true;
   }




 /** Database setting */
   public function databaseSettings(){
    return view('teckiproadmin::settings.database');
   }

   public function updateDatabaseSetting(Request $request){

    $validator = Validator::make($request->all(), [
      'DB_HOST' => 'required',
      'DB_PORT' => 'required',
      'DB_DATABASE' => 'required',
      'DB_USERNAME' => 'required',
      'DB_PASSWORD'=>'nullable'
   ]);
   $validated = $validator->validated();

   $DB_HOST = $validated['DB_HOST'];
   $DB_PORT = $validated['DB_PORT'];
   $DB_DATABASE = $validated['DB_DATABASE'];
   $DB_USERNAME = $validated['DB_USERNAME'];
   $DB_PASSWORD = $validated['DB_PASSWORD'];



   //setting the app name
   $this->setEnv("DB_HOST",$DB_HOST);
   $this->setEnv("DB_PORT",$DB_PORT);
   $this->setEnv("DB_DATABASE",$DB_DATABASE);

   $this->setEnv("DB_USERNAME",$DB_USERNAME);
   $this->setEnv("DB_PASSWORD",$DB_PASSWORD);


   return redirect()->route('admin.setting.database')->withFlashSuccess(__('Database setting successfully updated.'));

   }




   public function paymentSettings(){

   }


   public function webhook(){
    return view('teckiproadmin::settings.webhook');
   }


   public function payment(){
    return view('teckiproadmin::settings.payment');
   }


}

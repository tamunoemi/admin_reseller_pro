<?php

namespace Teckipro\Admin\Logging;

use Monolog\Handler\AbstractProcessingHandler;

use Monolog\LogRecord;
use Monolog\Logger;
use Log;
use Illuminate\Support\Facades\URL;
use Http;


class CustomLoggerHandler extends AbstractProcessingHandler
{

    private $webHookUrl;
    private $client;

    public function __construct($level = Logger::DEBUG, $bubble = true, $client = null)
    {
        parent::__construct($level, $bubble);

    }

    public function write(LogRecord $record):void
    {
        $api_endpoint = config('my_config.log_url');
        $host = request()->httpHost();
        $ip = request()->ip();

        $level = "";
        /** https://github.com/Seldaek/monolog/blob/main/doc/01-usage.md */
        switch($record['level']):
            case '100':
                 $level = "debug";
                break;

            case '200':
                $level = "info";
                break;
            case '300':
                $level = "warning";
                break;

            case '400':
                $level = "error";
                break;

            case '500':
                $level = "critical";
                break;

            case '550':
                $level = "alert";
                break;

            case '600':
                $level = "emergency";
                break;
        endswitch;

        $data = [
            'message'=>$record['message'],
            'context'=>$record['context'],
            'level'=>$level,

            'project'=>env('APP_NAME')
        ];
        $data['ip'] = $ip;
        $data['host'] = $host;
        $data['args']=json_encode($data);


        try{
            $verifyssl = env('APP_ENV')=='local' ? false : true;

            $promise = Http::withOptions([
                'debug' => false,
                'verify'=>$verifyssl
            ])->async()->post($api_endpoint, $data);
            $promise->wait();



        }catch(\Exception $e){
            dd($e->getMessage());
        }



    }
}

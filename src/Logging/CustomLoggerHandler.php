<?php

namespace Teckipro\Admin\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use GuzzleHttp\Client;
use Monolog\LogRecord;
use Monolog\Logger;
use Log;


class CustomLoggerHandler extends AbstractProcessingHandler
{

    private $webHookUrl;
    private $client;

    public function __construct($level = Logger::DEBUG, $bubble = true, $client = null)
    {
        parent::__construct($level, $bubble);

        $this->webHookUrl = "";
        $this->client     = ($client) ?: new Client();
    }

    public function write(LogRecord $record):void
    {

        \Log::info("yoyo");
        \Log::info($record['message']);
        \Log::info(json_encode($record));
        \Log::info("yoyo");
    }
}

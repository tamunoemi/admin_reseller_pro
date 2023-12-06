<?php

namespace Teckipro\Admin\Logging;

use Monolog\Logger;
#use Teckipro\Admin\Logging\CustomLoggerHandler;

class CustomLogger
{
    /**
     * Create a custom Monolog instance.
     */
    public function __invoke(array $config): Logger
    {
        return new Logger(
            config('my_config.app_name'),
            [
                new CustomLoggerHandler(),
            ]
        );
    }
}

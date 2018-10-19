<?php

namespace Application;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\ModuleManager\Feature\ConsoleUsageProviderInterface,
    Zend\Console\Adapter\AdapterInterface as Console;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ConsoleUsageProviderInterface
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        /* ... */
    }

    public function getConsoleUsage(Console $console)
    {
        return [
            // Describe available commands
            'user resetpassword [--verbose|-v] EMAIL' => 'Reset password for a user',

            // Describe expected parameters
            [ 'EMAIL',        'Email of the user for a password reset' ],
            [ '--verbose|-v', '(optional) turn on verbose mode'        ],
        ];
    }
}

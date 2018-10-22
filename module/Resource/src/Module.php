<?php

namespace Resource;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ResourceTable::class => function($container) {
                    $tableGateway = $container->get(Model\ResourceTableGateway::class);
                    return new Model\ResourceTable($tableGateway);
                },
                Model\ResourceTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Resource());
                    return new TableGateway('resource', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
}

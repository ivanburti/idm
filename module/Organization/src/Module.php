<?php

namespace Organization;

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
                Model\OrganizationTable::class => function($container) {
                    $tableGateway = $container->get(Model\OrganizationTableGateway::class);
                    return new Model\OrganizationTable($tableGateway);
                },
                Model\OrganizationTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Organization());
                    return new TableGateway('organization', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
}

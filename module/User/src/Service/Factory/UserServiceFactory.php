<?php

namespace User\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Model\UserTable;
use User\Model\UserSourceTable;
use User\Service\UserService;

class UserServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userTable = $container->get(UserTable::class);
        $userSourceTable = $container->get(UserSourceTable::class);

        return new UserService($userTable, $userSourceTable);
    }
}

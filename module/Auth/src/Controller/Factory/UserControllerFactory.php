<?php

namespace Auth\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Auth\Controller\UserController;
use Auth\Service\UserManager;
use Auth\Model\UserTable;

class UserControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userTable = $container->get(UserTable::class);
        $userManager = $container->get(UserManager::class);

        return new UserController($userTable, $userManager);
    }
}

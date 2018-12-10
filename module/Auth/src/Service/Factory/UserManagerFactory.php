<?php

namespace Auth\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Authentication\AuthenticationService;
use Auth\Model\UserTable;
use Auth\Service\UserManager;

class UserManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userTable = $container->get(UserTable::class);
        $authService = $container->get(AuthenticationService::class);

        return new UserManager($userTable, $authService);
    }
}

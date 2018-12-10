<?php

namespace People\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use People\Model\UserTable;
use Organization\Model\OrganizationTable;
use People\Service\UserService;

class UserServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userTable = $container->get(UserTable::class);
        $organizationTable = $container->get(OrganizationTable::class);

        return new UserService($userTable, $organizationTable);
    }
}

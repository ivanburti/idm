<?php

namespace Organization\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Organization\Service\OrganizationService;
use User\Service\UserService;
use Organization\Controller\OrganizationController;

class OrganizationControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $organizationService = $container->get(OrganizationService::class);
        $userService = $container->get(UserService::class);

        return new OrganizationController($organizationService, $userService);
    }
}

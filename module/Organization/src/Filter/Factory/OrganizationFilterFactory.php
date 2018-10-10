<?php

namespace Organization\Filter\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Organization\Service\OrganizationService;
use User\Service\UserService;
use Organization\Filter\OrganizationFilter;

class OrganizationFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $organizationService = $container->get(OrganizationService::class);
        $userService = $container->get(UserService::class);

        return new OrganizationFilter($organizationService, $userService);
    }

    public function createService(ServiceLocatorInterface $inputManager)
    {

    }
}

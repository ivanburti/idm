<?php

namespace User\Filter\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Organization\Service\OrganizationService;
use User\Filter\UserFilter;

class UserFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $organizationService = $container->get(OrganizationService::class);

        return new UserFilter($organizationService);
    }

    public function createService(ServiceLocatorInterface $inputManager)
    {

    }
}

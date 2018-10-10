<?php

namespace Api\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Organization\Service\OrganizationService;
use Api\Controller\OrganizationInternalController;

class OrganizationInternalControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $organizationService = $container->get(OrganizationService::class);

        return new OrganizationInternalController($organizationService);
    }
}

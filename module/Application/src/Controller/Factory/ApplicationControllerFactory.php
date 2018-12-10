<?php

namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Organization\Service\OrganizationService;
use Application\Controller\ApplicationController;

class ApplicationControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $organizationService = $container->get(OrganizationService::class);

        return new ApplicationController($organizationService);
    }
}

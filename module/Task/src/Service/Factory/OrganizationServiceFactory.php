<?php

namespace Organization\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Organization\Model\OrganizationTable;
use Organization\Service\OrganizationService;

class OrganizationServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $organizationTable = $container->get(OrganizationTable::class);

        return new OrganizationService($organizationTable);
    }
}

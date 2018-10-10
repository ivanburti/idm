<?php

namespace Resource\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Resource\Model\ResourceTable;
use Resource\Service\ResourceService;

class ResourceServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $resourceTable = $container->get(ResourceTable::class);

        return new ResourceService($resourceTable);
    }
}

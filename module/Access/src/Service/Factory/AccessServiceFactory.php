<?php

namespace Access\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Access\Model\AccessTable;
use Access\Service\AccessService;

class AccessServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accessTable = $container->get(AccessTable::class);

        return new AccessService($accessTable);
    }
}

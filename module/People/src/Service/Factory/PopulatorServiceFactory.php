<?php

namespace People\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Model\PopulatorTable;
use User\Service\PopulatorService;

class PopulatorServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        /*if (isset($config['access_filter']))
            $config = $config['access_filter'];
        else
            $config = [];
            */

        $populatorTable = $container->get(PopulatorTable::class);

        return new PopulatorService($config, $populatorTable);
    }
}

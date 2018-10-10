<?php

namespace Report\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Report\Service\ReportService;
use Access\Service\AccessService;
use Report\Controller\ReportController;

class ReportControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        //$resourceService = $container->get(ReportService::class);
        //$accessService = $container->get(AccessService::class);

        return new ReportController();
    }
}

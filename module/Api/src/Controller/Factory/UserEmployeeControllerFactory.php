<?php

namespace Api\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Filter\EmployeeFilter;
use User\Service\EmployeeService;
use Organization\Service\InternalService;
use Api\Controller\UserEmployeeController;

class UserEmployeeControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $inputManager = $container->get('InputFilterManager');
        $employeeFilter = $inputManager->get(EmployeeFilter::class);

        $employeeService = $container->get(EmployeeService::class);
        $internalService = $container->get(InternalService::class);

        return new UserEmployeeController($employeeFilter, $employeeService, $internalService);
    }
}

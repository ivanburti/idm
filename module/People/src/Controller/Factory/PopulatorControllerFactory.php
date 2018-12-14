<?php

namespace People\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use People\Service\PopulatorService;
use Organization\Service\OrganizationService;
use People\Filter\UserFilter;
use People\Service\UserService;
use People\Controller\PopulatorController;

class PopulatorControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /*
        $formManager = $container->get('FormElementManager');
        $userForm = $formManager->get(UserForm::class);
        */


        $populatorService = $container->get(PopulatorService::class);
        $organizationService = $container->get(OrganizationService::class);
        $inputManager = $container->get('InputFilterManager');
        $userFilter = $inputManager->get(UserFilter::class);
        $userService = $container->get(UserService::class);

        return new PopulatorController($populatorService, $organizationService, $userFilter, $userService);
    }
}

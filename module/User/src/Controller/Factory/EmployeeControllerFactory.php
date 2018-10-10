<?php

namespace User\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Form\UserForm;
use User\Filter\UserFilter;
use User\Service\UserService;
use Access\Service\AccessService;
use User\Controller\EmployeeController;

class EmployeeControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formManager = $container->get('FormElementManager');
        $userForm = $formManager->get(UserForm::class);

        $inputManager = $container->get('InputFilterManager');
        $userFilter = $inputManager->get(UserFilter::class);

        $userService = $container->get(UserService::class);
        //$organizationService = $container->get(InternalService::class);
        $accessService = $container->get(AccessService::class);

        return new EmployeeController($userForm, $userFilter, $userService, $accessService);
    }
}

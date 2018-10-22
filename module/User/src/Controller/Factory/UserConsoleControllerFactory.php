<?php

namespace User\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Form\UserForm;
use User\Service\UserService;
use Organization\Service\OrganizationService;
use Access\Service\AccessService;
use User\Controller\UserConsoleController;

class UserConsoleControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formManager = $container->get('FormElementManager');
        $userForm = $formManager->get(UserForm::class);

        $userService = $container->get(UserService::class);
        $organizationService = $container->get(OrganizationService::class);
        $accessService = $container->get(AccessService::class);

        return new UserConsoleController($userForm, $userService, $organizationService, $accessService);
    }
}

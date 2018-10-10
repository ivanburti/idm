<?php

namespace User\Form\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Organization\Service\OrganizationService;
use User\Service\UserService;
use User\Form\UserForm;

class UserFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $organizationService = $container->get(OrganizationService::class);
        $userService = $container->get(UserService::class);

        return new UserForm($organizationService, $userService);
    }

    public function createService(ServiceLocatorInterface $formManager)
    {

    }
}

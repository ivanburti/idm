<?php

namespace Organization\Form\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use People\Service\UserService;
use Organization\Form\OrganizationForm;

class OrganizationFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userService = $container->get(UserService::class);

        return new OrganizationForm($userService);
    }

    public function createService(ServiceLocatorInterface $formManager)
    {

    }
}

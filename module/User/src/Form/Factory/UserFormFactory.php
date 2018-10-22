<?php

namespace User\Form\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Organization\Service\OrganizationService;
use User\Form\UserForm;

class UserFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $organizationService = $container->get(OrganizationService::class);

        return new UserForm($organizationService);
    }

    public function createService(ServiceLocatorInterface $formManager)
    {

    }
}

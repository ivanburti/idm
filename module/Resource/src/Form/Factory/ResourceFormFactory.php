<?php

namespace Resource\Form\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Resource\Service\ResourceService;
use User\Service\UserService;
use Resource\Form\ResourceForm;

class ResourceFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $resourceService = $container->get(ResourceService::class);
        $userService = $container->get(UserService::class);

        return new ResourceForm($resourceService, $userService);
    }

    public function createService(ServiceLocatorInterface $formManager)
    {

    }
}

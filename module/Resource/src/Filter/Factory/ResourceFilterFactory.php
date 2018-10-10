<?php

namespace Resource\Filter\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Resource\Service\ResourceService;
use User\Service\UserService;
use Resource\Filter\ResourceFilter;

class ResourceFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $resourceService = $container->get(ResourceService::class);
        $userService = $container->get(UserService::class);

        return new ResourceFilter($resourceService, $userService);
    }

    public function createService(ServiceLocatorInterface $inputManager)
    {

    }
}

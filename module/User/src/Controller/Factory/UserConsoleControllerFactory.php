<?php

namespace User\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Filter\UserFilter;
use User\Service\UserService;
use Organization\Service\OrganizationService;
use Access\Service\AccessService;
use User\Controller\UserConsoleController;

class UserConsoleControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $inputManager = $container->get('InputFilterManager');
        $userFilter = $inputManager->get(UserFilter::class);

        $userService = $container->get(UserService::class);
        $organizationService = $container->get(OrganizationService::class);
        $accessService = $container->get(AccessService::class);

        return new UserConsoleController($userFilter, $userService, $organizationService, $accessService);
    }
}

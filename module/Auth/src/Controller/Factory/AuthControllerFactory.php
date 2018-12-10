<?php

namespace Auth\Controller\Factory;

use Interop\Container\ContainerInterface;
use Auth\Controller\AuthController;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Authentication\AuthenticationService;
use Auth\Service\AuthManager;
use Auth\Service\UserManager;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class AuthControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authManager = $container->get(AuthManager::class);
        $authService = $container->get(AuthenticationService::class);
        $userManager = $container->get(UserManager::class);

        return new AuthController($authManager, $authService, $userManager);
    }
}

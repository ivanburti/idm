<?php

namespace Auth\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Auth\View\Helper\UserIdentity;
use Auth\Service\UserManager;

class UserIdentityFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userManager = $container->get(UserManager::class);

        return new UserIdentity($userManager);
    }
}

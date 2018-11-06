<?php

namespace User\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Controller\SourceController;

class SourceControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /*
        $formManager = $container->get('FormElementManager');
        $userForm = $formManager->get(UserForm::class);

        $inputManager = $container->get('InputFilterManager');
        $userFilter = $inputManager->get(UserFilter::class);

        $userService = $container->get(UserService::class);
        //$organizationService = $container->get(InternalService::class);
        $accessService = $container->get(AccessService::class);
        */

        return new SourceController();
    }
}

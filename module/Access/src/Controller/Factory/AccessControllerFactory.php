<?php

namespace Access\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Access\Form\AccessForm;
use Access\Service\AccessService;
use Resource\Service\ResourceService;
use User\Service\UserService;
use Access\Controller\AccessController;

class AccessControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formManager = $container->get('FormElementManager');
        $accessForm = $formManager->get(AccessForm::class);

        //$inputManager = $container->get('InputFilterManager');
        //$userFilter = $inputManager->get(UserFilter::class);

        $accessService = $container->get(AccessService::class);
        $resourceService = $container->get(ResourceService::class);
        $userService = $container->get(UserService::class);

        return new AccessController($accessForm, $accessService, $resourceService, $userService);
    }
}

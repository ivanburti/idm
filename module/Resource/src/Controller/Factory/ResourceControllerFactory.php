<?php

namespace Resource\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Resource\Form\ResourceForm;
use Resource\Filter\ResourceFilter;
use Resource\Service\ResourceService;
use User\Service\UserService;
use Access\Service\AccessService;
use Resource\Controller\ResourceController;

class ResourceControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formManager = $container->get('FormElementManager');
        $resourceForm = $formManager->get(ResourceForm::class);

        $inputManager = $container->get('InputFilterManager');
        $resourceFilter = $inputManager->get(ResourceFilter::class);

        $resourceService = $container->get(ResourceService::class);
        $userService = $container->get(UserService::class);
        $accessService = $container->get(AccessService::class);

        return new ResourceController($resourceForm, $resourceFilter, $resourceService, $userService, $accessService);
    }
}

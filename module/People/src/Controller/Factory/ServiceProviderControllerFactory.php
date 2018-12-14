<?php

namespace People\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use People\Form\UserForm;
use People\Filter\UserFilter;
use People\Service\UserService;
use Organization\Service\OrganizationService;
use Access\Service\AccessService;
use People\Controller\ServiceProviderController;

class ServiceProviderControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formManager = $container->get('FormElementManager');
        $userForm = $formManager->get(UserForm::class);

        $inputManager = $container->get('InputFilterManager');
        $userFilter = $inputManager->get(UserFilter::class);

        $userService = $container->get(UserService::class);
        $organizationService = $container->get(OrganizationService::class);
        $accessService = $container->get(AccessService::class);

        return new ServiceProviderController($userForm, $userFilter, $userService, $organizationService, $accessService);
    }
}

<?php

namespace Organization\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Organization\Form\OrganizationForm;
use Organization\Service\OrganizationService;
use People\Service\UserService;
use Organization\Controller\OrganizationController;

class OrganizationControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formManager = $container->get('FormElementManager');
        $organizationForm = $formManager->get(OrganizationForm::class);

        $organizationService = $container->get(OrganizationService::class);
        $userService = $container->get(UserService::class);

        return new OrganizationController($organizationForm, $organizationService, $userService);
    }
}

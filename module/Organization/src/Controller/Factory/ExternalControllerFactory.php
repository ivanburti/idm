<?php

namespace Organization\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Organization\Form\OrganizationForm;
use Organization\Service\OrganizationService;
use User\Service\UserService;
use Organization\Controller\ExternalController;

class ExternalControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formManager = $container->get('FormElementManager');
        $organizationForm = $formManager->get(OrganizationForm::class);

        $organizationService = $container->get(OrganizationService::class);
        $userService = $container->get(UserService::class);

        return new ExternalController($organizationForm, $organizationService, $userService);
    }
}

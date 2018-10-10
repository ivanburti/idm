<?php

namespace Organization\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Organization\Form\OrganizationForm;
use Organization\Filter\OrganizationFilter;
use Organization\Service\OrganizationService;
use User\Service\UserService;
use Organization\Controller\ExternalController;

class ExternalControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formManager = $container->get('FormElementManager');
        $serviceProviderForm = $formManager->get(OrganizationForm::class);

        $inputManager = $container->get('InputFilterManager');
        $serviceProviderFilter = $inputManager->get(OrganizationFilter::class);

        $organizationService = $container->get(OrganizationService::class);
        $userService = $container->get(UserService::class);

        return new ExternalController($serviceProviderForm, $serviceProviderFilter, $organizationService, $userService);
    }
}

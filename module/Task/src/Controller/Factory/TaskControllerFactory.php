<?php

namespace Task\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
#use Task\Form\TaskForm;
#use Task\Filter\TaskFilter;
#use Task\Service\TaskService;
#use User\Service\UserService;
use Task\Controller\TaskController;

class TaskControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        //$formManager = $container->get('FormElementManager');
        //$organizationForm = $formManager->get(TaskForm::class);

        //$inputManager = $container->get('InputFilterManager');
        //$organizationFilter = $inputManager->get(TaskFilter::class);

        //$organizationService = $container->get(TaskService::class);
        //$userService = $container->get(UserService::class);

        return new TaskController();
    }
}

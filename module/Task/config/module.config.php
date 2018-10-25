<?php

namespace Task;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'task' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/tasks[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\TaskController::class,
                        'action' => 'search',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\TaskController::class => Controller\Factory\TaskControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\TaskService::class => Service\Factory\TaskServiceFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\TaskForm::class => Form\Factory\TaskFormFactory::class,
        ],
    ],
    'input_filters' => [
        'factories' => [
            Filter\TaskFilter::class => Filter\Factory\TaskFilterFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Tasks',
                'route' => 'task',
            ],
        ],
    ],
];

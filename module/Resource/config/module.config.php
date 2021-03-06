<?php

namespace Resource;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'resource' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/resources[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ResourceController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'connectors' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/resources/connectors[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ConnectorController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ResourceController::class => Controller\Factory\ResourceControllerFactory::class,
            Controller\ConnectorController::class => Controller\Factory\ConnectorControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\ResourceService::class => Service\Factory\ResourceServiceFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\ResourceForm::class => Form\Factory\ResourceFormFactory::class,
        ],
    ],
    'input_filters' => [
        'factories' => [
            Filter\ResourceFilter::class => Filter\Factory\ResourceFilterFactory::class,
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
                'label' => 'Resources',
                'route' => 'resource',
                'pages' => [
                    [
                        'label' => 'Add',
                        'route' => 'resource',
                        'action' => 'add'
                    ],
                    [
                        'label' => 'Edit',
                        'route' => 'resource',
                        'action' => 'edit'
                    ],
                ],
            ],
        ],
    ],
];

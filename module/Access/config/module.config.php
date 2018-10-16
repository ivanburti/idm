<?php

namespace Access;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'access' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/accesses[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AccessController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AccessController::class => Controller\Factory\AccessControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\AccessService::class => Service\Factory\AccessServiceFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\AccessForm::class => Form\Factory\AccessFormFactory::class,
        ],
    ],
    'input_filters' => [
        'factories' => [
            Filter\AccessFilter::class => Filter\Factory\AccessFilterFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'access/table' => __DIR__ . '/../view/partial/table_access.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Accesses',
                'route' => 'access',
            ],
        ],
    ],
];

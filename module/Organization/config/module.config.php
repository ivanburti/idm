<?php

namespace Organization;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'organization' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/organizations',
                    'defaults' => [
                        'controller' => Controller\OrganizationController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'organization' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\OrganizationController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'internal' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/internals[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\InternalController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'external' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/externals[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\ExternalController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                ]
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\OrganizationController::class => Controller\Factory\OrganizationControllerFactory::class,
            Controller\InternalController::class => Controller\Factory\InternalControllerFactory::class,
            Controller\ExternalController::class => Controller\Factory\ExternalControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\OrganizationService::class => Service\Factory\OrganizationServiceFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\OrganizationForm::class => Form\Factory\OrganizationFormFactory::class,
        ],
    ],
    'input_filters' => [
        'factories' => [
            Filter\OrganizationFilter::class => Filter\Factory\OrganizationFilterFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'template_map' => [
            'organization/table' => __DIR__ . '/../view/partial/table-organization.phtml',
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Organizations',
                'route' => 'organization/organization',
            ],
        ],
    ],
];

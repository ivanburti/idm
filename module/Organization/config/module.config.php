<?php

namespace Organization;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'organization' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/organizations[/:action[/:id]]',
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
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\OrganizationController::class => Controller\Factory\OrganizationControllerFactory::class,
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
                'route' => 'organization',
                'pages' => [
                    [
                        'label' => 'Details',
                        'route' => 'organization',
                        'action' => 'details'
                    ],
                    [
                        'label' => 'Disable',
                        'route' => 'organization',
                        'action' => 'disable'
                    ],
                    [
                        'label' => 'Add',
                        'route' => 'organization',
                        'action' => 'add'
                    ],
                    [
                        'label' => 'Add External',
                        'route' => 'organization',
                        'action' => 'add-external'
                    ],
                    [
                        'label' => 'edit',
                        'route' => 'organization',
                        'action' => 'edit'
                    ],
                    [
                        'label' => 'Edit External',
                        'route' => 'organization',
                        'action' => 'edit-external'
                    ],
                ],
            ],
        ],
    ],
];

<?php

namespace User;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'user' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/users[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'source' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/sources[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\SourceController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'user-update-employees' => [
                    'options' => [
                        'route'    => 'users update-employees',
                        'defaults' => [
                            'controller' => Controller\UserConsoleController::class,
                            'action'     => 'update-employees',
                        ],
                    ],
                ],
                'user-disable' => [
                    'options' => [
                        'route'    => 'users disable',
                        'defaults' => [
                            'controller' => Controller\UserConsoleController::class,
                            'action'     => 'disable',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\UserController::class => Controller\Factory\UserControllerFactory::class,
            //Controller\ServiceProviderController::class => Controller\Factory\ServiceProviderControllerFactory::class,
            Controller\SourceController::class => Controller\Factory\SourceControllerFactory::class,
            //Controller\EmployeeController::class => Controller\Factory\EmployeeControllerFactory::class,
            Controller\UserConsoleController::class => Controller\Factory\UserConsoleControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\UserService::class => Service\Factory\UserServiceFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\UserForm::class => Form\Factory\UserFormFactory::class,
        ],
    ],
    'input_filters' => [
        'factories' => [
            Filter\UserFilter::class => Filter\Factory\UserFilterFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'user/table' => __DIR__ . '/../view/partial/table-user.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Users',
                'route' => 'user',
                'pages' => [
                    [
                        'label' => 'Details',
                        'route' => 'user/user',
                        'action' => 'details'
                    ],
                    [
                        'label' => 'Employees',
                        'route' => 'user/employee',
                        'pages' => [
                            [
                                'label' => 'Add',
                                'route' => 'user/employee',
                                'action' => 'add'
                            ],
                            [
                                'label' => 'Edit',
                                'route' => 'user/employee',
                                'action' => 'edit'
                            ],
                        ],
                    ],
                    [
                        'label' => 'Service Providers',
                        'route' => 'user/service-provider',
                        'pages' => [
                            [
                                'label' => 'Add',
                                'route' => 'user/service-provider',
                                'action' => 'add'
                            ],
                            [
                                'label' => 'Edit',
                                'route' => 'user/service-provider',
                                'action' => 'edit'
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];

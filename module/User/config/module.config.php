<?php

namespace User;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'employee' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/employees-update',
                    'defaults' => [
                        'controller' => Controller\UserConsoleController::class,
                        'action'     => 'employees-update',
                    ],
                ],
            ],
            'user' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/users',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'search',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'user' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/[:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\UserController::class,
                                'action' => 'search',
                            ],
                        ],
                    ],
                    'employee' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/employees[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\EmployeeController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'service-provider' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/service-providers[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\ServiceProviderController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                ]
            ]
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'employees-update' => [
                    'options' => [
                        'route'    => 'employees-update',
                        'defaults' => [
                            'controller' => Controller\UserConsoleController::class,
                            'action'     => 'employees-update',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\UserController::class => Controller\Factory\UserControllerFactory::class,
            Controller\EmployeeController::class => Controller\Factory\EmployeeControllerFactory::class,
            Controller\ServiceProviderController::class => Controller\Factory\ServiceProviderControllerFactory::class,
            Controller\UserConsoleController::class => Controller\Factory\UserConsoleControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\UserService::class => Service\Factory\UserServiceFactory::class,
            //Service\EmployeeService::class => Service\Factory\EmployeeServiceFactory::class,
            //Service\ServiceProviderService::class => Service\Factory\ServiceProviderServiceFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\UserForm::class => Form\Factory\UserFormFactory::class,
        ],
    ],
    /*
    'input_filters' => [
        'factories' => [
            Filter\UserFilter::class => Filter\Factory\UserFilterFactory::class,
        ],
    ],*/
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

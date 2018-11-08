<?php

namespace User;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

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
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'servuce-provider' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/servuce-providers[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                 'id' => '[a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\ServiceProviderController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
            'populator' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/populators[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\PopulatorController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'populator-pull' => [
                    'options' => [
                        'route'    => 'populators pull',
                        'defaults' => [
                            'controller' => Controller\PopulatorController::class,
                            'action'     => 'pull',
                        ],
                    ],
                ],
                'populator-push' => [
                    'options' => [
                        'route'    => 'populators pull',
                        'defaults' => [
                            'controller' => Controller\PopulatorController::class,
                            'action'     => 'push',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\UserController::class => Controller\Factory\UserControllerFactory::class,
            Controller\PopulatorController::class => Controller\Factory\PopulatorControllerFactory::class,
            Controller\UserConsoleController::class => Controller\Factory\UserConsoleControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\UserService::class => Service\Factory\UserServiceFactory::class,
            Service\PopulatorService::class => Service\Factory\PopulatorServiceFactory::class,
        ],
        'invokables'=> [
            //Model\CSV::class => Model\CSV::class,
            //Model\CSV::class => InvokableFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\UserForm::class => Form\Factory\UserFormFactory::class,
            //Form\PopulatorForm::class => Form\Factory\PopulatorFormFactory::class,
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
                'label' => 'Populators',
                'route' => 'populator',
            ],
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

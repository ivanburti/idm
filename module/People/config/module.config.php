<?php

namespace People;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'people' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/people',
                    'defaults' => [
                        'controller' => Controller\PeopleController::class,
                        'action' => 'search',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'employee' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/employees[/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                 'id' => '[a-zA-Z0-9_-]+',
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
                                 'id' => '[a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'controller' => Controller\ServiceProviderController::class,
                                'action' => 'index',
                            ],
                        ],
                    ],
                ]
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
            Controller\PeopleController::class => Controller\Factory\PeopleControllerFactory::class,
            Controller\EmployeeController::class => Controller\Factory\EmployeeControllerFactory::class,
            Controller\ServiceProviderController::class => Controller\Factory\ServiceProviderControllerFactory::class,
            Controller\PopulatorController::class => Controller\Factory\PopulatorControllerFactory::class,
            Controller\PeopleConsoleController::class => Controller\Factory\PeopleConsoleControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\UserService::class => Service\Factory\UserServiceFactory::class,
            Service\PopulatorService::class => Service\Factory\PopulatorServiceFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\UserForm::class => Form\Factory\UserFormFormFactory::class,
        ],
    ],
    'input_filters' => [
        'factories' => [
            Filter\UserFormFilter::class => Filter\Factory\UserFormFilterFactory::class,
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
];

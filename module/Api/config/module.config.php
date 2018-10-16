<?php

namespace Api;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\Router\Http\Hostname;

return [
    'router' => [
        'routes' => [
            'api' => [
                'type' => Hostname::class,
                'options' => [
                    'route' => 'api-idm.netshoes.io',
                    'defaults' => [
                        'controller' => Controller\ApiController::class,
                        //'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'=>[
                    'user' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/users',
                            'defaults' => [
                                'controller' => Controller\UserController::class,
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'employee' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/employees[/:id]',
                                    'constraints' => [
                                        'id' => '[0-9]+',
                                    ],
                                    'defaults' => [
                                        'controller' => Controller\UserEmployeeController::class,
                                    ],
                                ],
                            ],
                            'service-provider' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/service-providers[/:id]',
                                    'constraints' => [
                                        'id' => '[0-9]+',
                                    ],
                                    'defaults' => [
                                        'controller' => Controller\UserServiceProviderController::class,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            /*
            'api' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/api',
                    'defaults' => [
                        'controller' => Controller\ApiController::class,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'organization' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/organizations',
                            'defaults' => [
                                'controller' => Controller\OrganizationController::class,
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'internal' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/internals[/:id]',
                                    'constraints' => [
                                        'id' => '[0-9]+',
                                    ],
                                    'defaults' => [
                                        'controller' => Controller\OrganizationInternalController::class,
                                    ],
                                ],
                            ],
                            'service-provider' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/service-providers[/:id]',
                                    'constraints' => [
                                        'id' => '[0-9]+',
                                    ],
                                    'defaults' => [
                                        'controller' => Controller\OrganizationServiceProviderController::class,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'user' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/users',
                            'defaults' => [
                                'controller' => Controller\UserController::class,
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'employee' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/employees[/:id]',
                                    'constraints' => [
                                        'id' => '[0-9]+',
                                    ],
                                    'defaults' => [
                                        'controller' => Controller\UserEmployeeController::class,
                                    ],
                                ],
                            ],
                            'service-provider' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/service-providers[/:id]',
                                    'constraints' => [
                                        'id' => '[0-9]+',
                                    ],
                                    'defaults' => [
                                        'controller' => Controller\UserServiceProviderController::class,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            */

        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ApiController::class => Controller\Factory\ApiControllerFactory::class,
            Controller\OrganizationController::class => Controller\Factory\OrganizationControllerFactory::class,
            Controller\OrganizationInternalController::class => Controller\Factory\OrganizationInternalControllerFactory::class,
            Controller\OrganizationServiceProviderController::class => Controller\Factory\OrganizationServiceProviderControllerFactory::class,
            Controller\UserController::class => Controller\Factory\UserControllerFactory::class,
            Controller\UserEmployeeController::class => Controller\Factory\UserEmployeeControllerFactory::class,
            Controller\UserServiceProviderController::class => Controller\Factory\UserServiceProviderControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];

<?php

namespace Auth;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
            'reset-password' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/reset-password',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'resetPassword',
                    ],
                ],
            ],
            'set-password' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/set-password',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'setPassword',
                    ],
                ],
            ],
            'account' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/account[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller'    => Controller\UserController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => Controller\Factory\AuthControllerFactory::class,
            Controller\UserController::class => Controller\Factory\UserControllerFactory::class,
        ],
    ],
	'access_filter' => [
		'options' => [
			'mode' => 'restrictive'
            //'mode' => 'permissive'
		],
		'controllers' => [
			Controller\UserController::class => [
				['actions' => ['resetPassword', 'message', 'setPassword'], 'allow' => '*'],
				//['actions' => ['index', 'add', 'edit', 'view', 'changePassword'], 'allow' => '@']
			],
		]
	],
	'service_manager' => [
        'factories' => [
            \Zend\Authentication\AuthenticationService::class => Service\Factory\AuthenticationServiceFactory::class,
            Service\AuthAdapter::class => Service\Factory\AuthAdapterFactory::class,
            Service\AuthManager::class => Service\Factory\AuthManagerFactory::class,
            Service\UserManager::class => Service\Factory\UserManagerFactory::class,
        ],
    ],
    'view_manager' => [
		'template_map' => [
			'user/login' => __DIR__ . '/../view/user/auth/login.phtml',
		],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
	'view_helpers' => [
		'factories'=> [
            View\Helper\UserIdentity::class => View\Helper\Factory\UserIdentityFactory::class,
		],
        'aliases' => [
            'UserIdentity' => View\Helper\UserIdentity::class,
        ],
	],
];

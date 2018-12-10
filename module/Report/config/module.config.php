<?php

namespace Report;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'report' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/reports[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ReportController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'audit' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/audit[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AuditController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuditController::class => Controller\Factory\AuditControllerFactory::class,
            Controller\ReportController::class => Controller\Factory\ReportControllerFactory::class,
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
                'label' => 'Reports',
                'route' => 'report',
            ],
        ],
    ],
];

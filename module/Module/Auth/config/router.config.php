<?php

use Zend\Mvc\Router\Http;

return [
    'router' => [
        'routes' => [
            'auth' => [
                'type' => Http\Literal::class,
                'options' => [
                    'route' => '/auth',
                    'defaults' => [
                        '__NAMESPACE__' => 'Module\Auth\Controller',
                        'controller' => 'index',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type' => Http\Segment::class,
                        'options' => [
                            'route' => '/[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            '*' => [
                                'type' => Http\Wildcard::class,
                                'options' => [
                                    'key_value_delimiter' => '/',
                                    'param_delimiter' => '/',
                                ],
                                'may_terminate' => true,
                            ],
                        ]
                    ],
                ],
            ],
        ],
    ],
];
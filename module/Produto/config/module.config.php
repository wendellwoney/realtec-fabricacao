<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Produto;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Produto\Factory\IndexControllerFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../../../Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    'router' => [
        'routes' => [
            'ProdutoLista' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/produto',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'ProdutoCadastro' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/produto/cadastro[/]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'cadastro',
                    ],
                ],
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => IndexControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/produto'           => __DIR__ . '/../../../layout/layout.phtml',
            'produto/index/index' => __DIR__ . '/../view/produto/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];

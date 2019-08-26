<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Insumo;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Insumo\Factory\IndexControllerFactory;
use Insumo\Factory\InsumoEntradaControllerFactory;
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
            'insumoIndex' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/insumo[/][:id]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'insumoCadastro' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/insumo/cadastro[/]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'cadastro',
                    ],
                ],
            ],
            'insumoEditar' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/insumo/editar/:idinsumo[/]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'editar',
                    ],
                ],
            ],
            'EstoqueInsumoLista' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/insumo-entrada[/][:id]',
                    'defaults' => [
                        'controller' => Controller\InsumoEntradaController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'EstoqueInsumoCadastro' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/insumo-entrada/cadastro',
                    'defaults' => [
                        'controller' => Controller\InsumoEntradaController::class,
                        'action'     => 'cadastro',
                    ],
                ],
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => IndexControllerFactory::class,
            Controller\InsumoEntradaController::class => InsumoEntradaControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/insumo'           => __DIR__ . '/../../../layout/layout.phtml',
            'insumo/index/index' => __DIR__ . '/../view/insumo/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];

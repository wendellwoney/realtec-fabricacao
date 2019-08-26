<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Fabricacao;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Fabricacao\Factory\IndexControllerFactory;
use Zend\Router\Http\Segment;

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
            'FabricacaoLista' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/fabricacao[/][:id]',
                    'defaults' => array(
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ),
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => IndexControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/fabricacao' => __DIR__ . '/../../../layout/layout.phtml',
            'fabricacao/index/index' => __DIR__ . '/../view/fabricacao/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];

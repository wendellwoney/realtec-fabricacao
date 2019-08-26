<?php
/**
 * Created by PhpStorm.
 * User: wende
 * Date: 21/08/2019
 * Time: 14:34
 */

namespace Insumo\Factory;

use Doctrine\ORM\EntityManager;
use Insumo\Controller\InsumoEntradaController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class InsumoEntradaControllerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get(EntityManager::class);

        return new InsumoEntradaController($em);
    }
}
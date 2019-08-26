<?php
/**
 * Created by PhpStorm.
 * User: wende
 * Date: 21/08/2019
 * Time: 14:34
 */

namespace Fabricacao\Factory;

use Doctrine\ORM\EntityManager;
use Fabricacao\Controller\IndexController;
use Insumo\Model\InsumoModelo;
use Interop\Container\ContainerInterface;

class IndexControllerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get(EntityManager::class);

        return new IndexController($em);
    }
}
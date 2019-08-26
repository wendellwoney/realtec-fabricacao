<?php
/**
 * Created by PhpStorm.
 * User: wende
 * Date: 21/08/2019
 * Time: 14:34
 */

namespace Produto\Factory;

use Doctrine\ORM\EntityManager;
use Insumo\Model\InsumoModelo;
use Interop\Container\ContainerInterface;
use Produto\Controller\IndexController;
use Produto\Model\ProdutoFormulaModelo;
use Produto\Model\ProdutoModelo;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get(EntityManager::class);

        return new IndexController($em);
    }
}
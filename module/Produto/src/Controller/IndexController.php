<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Produto\Controller;

use Doctrine\ORM\EntityManager;
use Insumo\Model\InsumoModelo;
use Produto\Model\ProdutoFormulaModelo;
use Produto\Model\ProdutoModelo;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $view = new ViewModel();

        $produtoModelo = new ProdutoModelo($this->entityManager);
        $view->setVariable('produtos', $produtoModelo->getList());
        return $view;
    }

    public function cadastroAction()
    {
        $view = new ViewModel();
        $produtoModelo = new ProdutoModelo($this->entityManager);
        $insumoModelo = new InsumoModelo($this->entityManager);

        $view->setVariable('insumos', $insumoModelo->getList());
        return $view;
    }
}

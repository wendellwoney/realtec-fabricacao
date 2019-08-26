<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Fabricacao\Controller;

use Doctrine\ORM\EntityManager;
use Fabricacao\Model\FabricacaoModelo;
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

        $fabricacaoModelo = new FabricacaoModelo($this->entityManager);
        if($this->params()->fromRoute('id')) {
            try{
                $fabricacaoModelo->delete($this->params()->fromRoute('id'));
                $view->setVariable('msgs', 'Fabricação removida!');
            } catch (\Exception $e) {
                $view->setVariable('msge', $e->getMessage());
            }
        }

        $fabricacao = $fabricacaoModelo->getList();
        $view->setVariable('fabricacao', $fabricacao);

        $valorProdutos = [];

        foreach ($fabricacao as $fab) {
            $valorProdutos[$fab->getIdFabricacao()] = $fabricacaoModelo->calculaValordaFabricacao($fab->getIdFabricacao());
        }

        $view->setVariable('valorFabricacao', $valorProdutos);
        return $view;
    }
}

<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Fabricacao\Controller;

use Doctrine\ORM\EntityManager;
use Fabricacao\Model\FabricacaoModelo;
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

        $fabricacaoModelo = new FabricacaoModelo($this->entityManager);
        if ($this->params()->fromRoute('id')) {
            try {
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

    public function cadastroAction()
    {
        $view = new ViewModel();

        $produtoModelo = new ProdutoModelo($this->entityManager);
        $view->setVariable('produtos', $produtoModelo->getList());
        return $view;
    }

    public function infofabricacaoAction()
    {
        $view = new ViewModel();
        $view->setTerminal(true);

        $produtoFormula = (new ProdutoFormulaModelo($this->entityManager))->getProdutoFormula($this->params()->fromRoute('idProduto'));
        $quantidadeDesejada = $this->params()->fromRoute('qtde');

        $formulas = [];

        foreach ($produtoFormula as $formula) {
            $formulas[] = [
                'codigo' => $formula->getInsumo()->getCodigo(),
                'insumo' => $formula->getInsumo()->getNome(),
                'estoqueAtual' => $formula->getInsumo()->getEstoqueGeral(),
                'qtdeUni' => $formula->getQtde(),
                'qtdedesejada' => $quantidadeDesejada,
                'situacao' => (($formula->getQtde() * $quantidadeDesejada) > $formula->getInsumo()->getEstoqueGeral())? '1' : '2',

            ];
        }

        $view->setVariable('infos', $formulas);
        return $view;
    }
}

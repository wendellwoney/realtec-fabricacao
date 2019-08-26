<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Fabricacao\Controller;

use Doctrine\ORM\EntityManager;
use Entity\Fabricacao;
use Entity\FabricacaoFormula;
use Fabricacao\Model\FabricacaoFormulaModelo;
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
            $valorProdutos[$fab->getIdFabricacao()] = $fabricacaoModelo->calculaValordaFabricacao($fab->getIdFabricacao()) * $fab->getQuantidade();
        }

        $view->setVariable('valorFabricacao', $valorProdutos);
        return $view;
    }

    public function cadastroAction()
    {
        $view = new ViewModel();
        $produtoModelo = new ProdutoModelo($this->entityManager);
        $fabricacaoModelo = new FabricacaoModelo($this->entityManager);
        $fabricacaoFormulaModelo = new FabricacaoFormulaModelo($this->entityManager);
        $produtoFormulaModelo = new ProdutoFormulaModelo($this->entityManager);
        $insumoModelo = new InsumoModelo($this->entityManager);

        if ($this->getRequest()->isPost()) {

            //print_r($_POST);exit;

            $fabricacao = new Fabricacao();
            $fabricacao->setIdFabricacao(0);
            $fabricacao->setProduto($produtoModelo->get($this->params()->fromPost('produto')));
            $fabricacao->setAtivo('1');
            $fabricacao->setObservacao($this->params()->fromPost('obsercacao'));
            $fabricacao->setCodigo($this->params()->fromPost('codigo'));
            $fabricacao->setQuantidade($this->params()->fromPost('quantidade'));
            $fabricacao->setDataCadastro(new \DateTime('now'));

            try{
                $fabricacaoModelo->create($fabricacao);
                //Clonar Insumos Fabricacao do principal para a fabricação
                $formulaProduto = $produtoFormulaModelo->getProdutoFormula($this->params()->fromPost('produto'));

                foreach ($formulaProduto as $formulaP) {
                    $fabricacaoFormula = new FabricacaoFormula();
                    $fabricacaoFormula->setIdFabricacaoFormula(0);
                    $fabricacaoFormula->setQtde($formulaP->getQtde());
                    $fabricacaoFormula->setProduto($produtoModelo->get($this->params()->fromPost('produto')));
                    $fabricacaoFormula->setInsumo($formulaP->getInsumo());
                    $fabricacaoFormula->setFabricacao($fabricacaoModelo->get($fabricacao->getIdFabricacao()));
                    $fabricacaoFormula->setValor($formulaP->getInsumo()->getValorMedio());
                    $fabricacaoFormulaModelo->create($fabricacaoFormula);

                    //Dar baixa no estoque
                    $calRemocao = $this->params()->fromPost('quantidade') * $formulaP->getQtde();
                    $insumo = $insumoModelo->get($formulaP->getInsumo()->getidInsumo());
                    $insumo->setEstoqueGeral(($insumo->getEstoqueGeral() - $calRemocao));
                    $insumoModelo->update($insumo);
                }

                $view->setVariable('msgs', 'Produto fabricado!');
            }catch (\Exception $e){
                $view->setVariable('msge', $e->getMessage());
            }
        }


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

<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Produto\Controller;

use Doctrine\ORM\EntityManager;
use Entity\Produto;
use Entity\ProdutoFormula;
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
        $produtos = $produtoModelo->getList();
        $view->setVariable('produtos', $produtos);

        $valorProdutos = [];

        foreach ($produtos as $produto) {
            $valorProdutos[$produto->getIdProduto()] = $produtoModelo->calculaValordoProduto($produto->getIdProduto());
        }


        $view->setVariable('valorFabricacao', $valorProdutos);
        return $view;
    }

    public function cadastroAction()
    {
        $view = new ViewModel();
        $produtoModelo = new ProdutoModelo($this->entityManager);
        $produtoFormulaModelo = new ProdutoFormulaModelo($this->entityManager);
        if ($this->getRequest()->isPost()) {

            //Cadastra o produto e pega o id
            $produto = new Produto();
            $produto->setIdProduto(0);
            $produto->setCodigo($this->params()->fromPost('codigo'));
            $produto->setNome($this->params()->fromPost('nome'));
            $produto->setUnidadeMedida($this->params()->fromPost('unidade_medida'));
            $produto->setDescricao($this->params()->fromPost('descricao'));
            $produto->setAtivo('1');
            $produto->setDataCadastro(new \DateTime('now'));

            try{
                $produtoModelo->create($produto);

                foreach ($this->params()->fromPost('insumo') as $idInsumo) {
                    $produtoFormula = new ProdutoFormula();
                    $produtoFormula->setIdProdutoFormula(0);

                    $insumoModelo = new InsumoModelo($this->entityManager);
                    $produtoFormula->setInsumo($insumoModelo->get($idInsumo));

                    $produtoFormula->setQtde($this->params()->fromPost('quantidade')[$idInsumo]);
                    $produtoFormula->setProduto($produtoModelo->get($produto->getIdProduto()));

                    try{
                        $produtoFormulaModelo->create($produtoFormula);
                    } catch (\Exception $e) {
                        $view->setVariable('msge', $e->getMessage());
                    }
                }
                $view->setVariable('msgs', 'Produto cadastrado!');
            }catch (\Exception $e){
                $view->setVariable('msge', $e->getMessage());
            }
        }

        $insumoModelo = new InsumoModelo($this->entityManager);

        $view->setVariable('insumos', $insumoModelo->getList());
        return $view;
    }

    public function editarAction()
    {
        $view = new ViewModel();
        $produtoModelo = new ProdutoModelo($this->entityManager);
        $produtoFormulaModelo = new ProdutoFormulaModelo($this->entityManager);
        if ($this->getRequest()->isPost()) {
            //Cadastra o produto e pega o id
            $produto = $produtoModelo->get($this->params()->fromPost('idproduto'));
            $produto->setCodigo($this->params()->fromPost('codigo'));
            $produto->setNome($this->params()->fromPost('nome'));
            $produto->setUnidadeMedida($this->params()->fromPost('unidade_medida'));
            $produto->setDescricao($this->params()->fromPost('descricao'));
            $produto->setAtivo('1');
            $produto->setDataAtualizacao(new \DateTime('now'));

            try{
                $produtoModelo->update($produto);

                $produtoFormulaModelo->removeFormulaProduto($this->params()->fromPost('idproduto'));

                foreach ($this->params()->fromPost('insumo') as $idInsumo) {

                    //Remover todos os produtos formulas do produto

                    $produtoFormula = new ProdutoFormula();
                    $produtoFormula->setIdProdutoFormula(0);

                    $insumoModelo = new InsumoModelo($this->entityManager);
                    $produtoFormula->setInsumo($insumoModelo->get($idInsumo));

                    $produtoFormula->setQtde($this->params()->fromPost('quantidade')[$idInsumo]);
                    $produtoFormula->setProduto($produtoModelo->get($produto->getIdProduto()));

                    try{
                        $produtoFormulaModelo->create($produtoFormula);
                    } catch (\Exception $e) {
                        $view->setVariable('msge', $e->getMessage());
                    }
                }
                $view->setVariable('msgs', 'Produto editado!');
            }catch (\Exception $e){
                $view->setVariable('msge', $e->getMessage());
            }
        }

        $insumoModelo = new InsumoModelo($this->entityManager);
        $view->setVariable('insumos', $insumoModelo->getList());
        $view->setVariable('produto', $produtoModelo->get($this->params()->fromRoute('idProduto')));
        $view->setVariable('composicao', $produtoFormulaModelo->getProdutoFormula($this->params()->fromRoute('idProduto')));
        return $view;
    }
}

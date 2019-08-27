<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Insumo\Controller;

use Doctrine\ORM\EntityManager;
use Entity\EntradaInsumo;
use Insumo\Model\InsumoEntradaModelo;
use Insumo\Model\InsumoModelo;
use Util\Funcoes;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class InsumoEntradaController extends AbstractActionController
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $view = new ViewModel();
        $insumoEntradaModelo = new InsumoEntradaModelo($this->entityManager);

        if ($this->params()->fromRoute('id')) {
            try {
                $this->removeEntrada($this->params()->fromRoute('id'));
                $view->setVariable('msgs', 'Entrada removida!');
            } catch (\Exception $e) {
                $view->setVariable('msge', $e->getMessage());
            }
        }

        $view->setVariable('entradas', $insumoEntradaModelo->getList());
        return $view;
    }

    private function removeEntrada($idEntrada)
    {
        $insumoModelo = new InsumoModelo($this->entityManager);
        $entradaInsumoModelo = new InsumoEntradaModelo($this->entityManager);
        $entrada = $entradaInsumoModelo->get($idEntrada);
        $entrada->setAtivo('0');
        $entrada->setDataRemocao(new \DateTime('now'));
        $insumoCorrente = $insumoModelo->get($entrada->getInsumo()->getIdInsumo());

        $estoqueGeral = $insumoCorrente->getEstoqueGeral() - $entrada->getQuantidade();

        $valorProduto = $insumoCorrente->getValorMedio() * $insumoCorrente->getEstoqueGeral();

        $insumoCorrente->setEstoqueGeral($estoqueGeral);
        $valorUnitarioCompra = $entrada->getValor() * $entrada->getQuantidade();
        if ($estoqueGeral == 0) {
            $valorMedio = 0;
        } else {
            $valorMedio = (Funcoes::valorUnitario(($valorProduto - $valorUnitarioCompra), $estoqueGeral));
        }

        $insumoCorrente->setValorMedio($valorMedio);

        //remove entrada
        try {
            $entradaInsumoModelo->update($entrada);
            $insumoModelo->update($insumoCorrente);
        } catch (\Exception $e) {
            throw new \Exception('Erro ao remover a entrada do insumo, por favor tente novamente mais tarde!');
        }
    }


    public function cadastroAction()
    {
        $view = new ViewModel();

        $insumoModelo = new InsumoModelo($this->entityManager);
        $entradaInsumoModelo = new InsumoEntradaModelo($this->entityManager);
        if ($this->getRequest()->isPost()) {
            foreach ($this->params()->fromPost('qtde') as $idInsumo => $qtde) {
                if ($qtde > 0) {
                    $insumoCorrente = $insumoModelo->get($idInsumo);
                    $entradaInsumo = new EntradaInsumo();
                    $entradaInsumo->setDataCadastro(new \DateTime('now'));
                    $entradaInsumo->setDataEntrada(new \DateTime('now'));
                    $entradaInsumo->setValor($this->params()->fromPost('valor')[$idInsumo]);
                    $entradaInsumo->setQuantidade($qtde);
                    $entradaInsumo->setInsumo($insumoCorrente);
                    $entradaInsumo->setAtivo('1');

                    $estoqueGeral = $insumoCorrente->getEstoqueGeral() + $qtde;
                    $valorProduto = $insumoCorrente->getValorMedio() * $insumoCorrente->getEstoqueGeral();
                    $insumoCorrente->setEstoqueGeral($estoqueGeral);
                    $valorUnitarioCompra = Funcoes::valorUnitario($this->params()->fromPost('valor')[$idInsumo], $qtde);

                    $valorMedio = (Funcoes::valorUnitario(($valorProduto + ($valorUnitarioCompra * $qtde)), $estoqueGeral));

                    $insumoCorrente->setValorMedio($valorMedio);

                    //Cadastra nova entrada
                    try {
                        $entradaInsumoModelo->create($entradaInsumo);
                        $insumoModelo->update($insumoCorrente);
                        $view->setVariable('msgs', 'Entrada Cadastrada!');
                    } catch (\Exception $e) {
                        $view->setVariable('msge', $e->getMessage());
                    }
                }
            }

        }

        $insumoModelo = new InsumoModelo($this->entityManager);
        $view->setVariable('insumos', $insumoModelo->getList());
        return $view;
    }
}

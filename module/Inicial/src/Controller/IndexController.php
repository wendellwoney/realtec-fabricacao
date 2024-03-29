<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Inicial\Controller;

use Doctrine\ORM\EntityManager;
use Fabricacao\Model\FabricacaoModelo;
use Insumo\Model\InsumoEntradaModelo;
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

        //Estoque Produtos
        $view->setVariable('estoqueProduto', $this->estoqueProdutos());

        //Grafico Fabricação
        $view->setVariable('gFabricacao', $this->graficoFabricacao());
        //Grafico Insumo
        $view->setVariable('gInsumo', $this->graficoInsumos());
        //Insumos comprados
        $view->setVariable('compraInsumo', $this->compraInsumoMes());
        //fabricação mês
        $view->setVariable('fabricacaoMes', $this->fabricacaoMes());
        //Total produto
        $view->setVariable('totalProduto', $this->totalProdutos());
        //estoque produto
        $view->setVariable('estoqueGeral', $this->estoque());
        return $view;
    }

    private function estoqueProdutos()
    {

        $fabricacaoModelo = new FabricacaoModelo($this->entityManager);
        $fabricacao = $fabricacaoModelo->getList();

        $arrayProdutoEstoque = [];

        foreach ($fabricacao as $fabri) {
            if (@count($arrayProdutoEstoque[$fabri->getProduto()->getIdProduto()]) == 0) {
                $arrayProdutoEstoque[$fabri->getProduto()->getIdProduto()] = [
                    'nome' => $fabri->getProduto()->getNome(),
                    'totalEstoque' => $fabri->getQuantidade(),
                    'valor' => $fabricacaoModelo->calculaValordaFabricacao($fabri->getIdFabricacao()) * $fabri->getQuantidade(),
                ];
            } else {
                $arrayProdutoEstoque[$fabri->getProduto()->getIdProduto()]['totalEstoque'] = $arrayProdutoEstoque[$fabri->getProduto()->getIdProduto()]['totalEstoque'] + $fabri->getQuantidade();
                $arrayProdutoEstoque[$fabri->getProduto()->getIdProduto()]['valor'] = $arrayProdutoEstoque[$fabri->getProduto()->getIdProduto()]['valor'] + $fabricacaoModelo->calculaValordaFabricacao($fabri->getIdFabricacao()) * $fabri->getQuantidade();
            }
        }

        return $arrayProdutoEstoque;
    }

    private function graficoFabricacao()
    {

        $fabricacaoModelo = new FabricacaoModelo($this->entityManager);
        $fabricacao = $fabricacaoModelo->getList();

        $arrayGrafico = [];
        foreach ($fabricacao as $fabri) {
            $ind = $fabri->getDataCadastro()->format('m');
            if (@count($arrayGrafico[$ind]) == 0) {
                $arrayGrafico[$ind] = ceil($fabri->getQuantidade());
            } else {
                $arrayGrafico[$ind] = ceil($arrayGrafico[$ind] + $fabri->getQuantidade());
            }
        }
        ksort($arrayGrafico);
        return $arrayGrafico;
    }

    private function graficoInsumos()
    {
        $insumoEntradaModelo = new InsumoEntradaModelo($this->entityManager);
        $insumosEntrada = $insumoEntradaModelo->getList();

        $arrayGraficoInsumo = [];
        foreach ($insumosEntrada as $entrada) {
            $ind = $entrada->getDataEntrada()->format('m');
            if (@count($arrayGraficoInsumo[$ind]) == 0) {
                $arrayGraficoInsumo[$ind] = ceil($entrada->getValor());
            } else {
                $arrayGraficoInsumo[$ind] = ceil($arrayGraficoInsumo[$ind] + ($entrada->getValor()));
            }
        }
        ksort($arrayGraficoInsumo);
        return $arrayGraficoInsumo;
    }

    private function compraInsumoMes()
    {
        $mes = date('m');
        $mesAnterior = date('m', strtotime('-1 months', strtotime(date('Y-m-d'))));
        $array = $this->graficoInsumos();

        @$mesAtual = ($array[$mes]) ? $array[$mes] : 0;
        @$mesAnteriorT = ($array[$mesAnterior]) ? $array[$mesAnterior] : 0;

        if($mesAtual < $mesAnterior) {
            $arrayReturn = [
              'valor' => $mesAtual,
              'porcentagem' => @round(($mesAtual == 0) ? '100' : (($mesAnteriorT * 100)/$mesAtual),2),
              'tik' => 'dow'
            ];
        }

        if($mesAtual > $mesAnterior) {
            $arrayReturn = [
                'valor' => $mesAtual,
                'porcentagem' => @round(($mesAnteriorT == 0) ? '100' : (($mesAtual * 100)/$mesAnteriorT),2),
                'tik' => 'up'
            ];
        }

        if ($mesAtual == 0 && $mesAnterior == 0){
            $arrayReturn = [
                'valor' => 0,
                'porcentagem' => 0,
                'tik' => 'dow'
            ];
        }

        return $arrayReturn;
    }

    private function totalProdutos()
    {
        $produtoModelo = new ProdutoModelo($this->entityManager);
        return count($produtoModelo->getList());
    }

    private function fabricacaoMes()
    {
        $mes = date('m');
        $mesAnterior = date('m', strtotime('-1 months', strtotime(date('Y-m-d'))));
        $array = $this->graficoFabricacao();



        @$mesAtual = ($array[$mes]) ? $array[$mes] : 0;
        @$mesAnteriorT = ($array[$mesAnterior]) ? $array[$mesAnterior] : 0;

        if($mesAtual < $mesAnterior) {
            $arrayReturn = [
                'valor' => $mesAtual,
                'porcentagem' => @round(($mesAtual == 0) ? '100' : (($mesAnteriorT * 100)/$mesAtual),2),
                'tik' => 'dow'
            ];
        }

        if($mesAtual > $mesAnterior) {
            $arrayReturn = [
                'valor' => $mesAtual,
                'porcentagem' => @round(($mesAnteriorT == 0) ? '100' : (($mesAtual * 100)/$mesAnteriorT), 2),
                'tik' => 'up'
            ];
        }

        if ($mesAtual == 0 && $mesAnterior == 0){
            $arrayReturn = [
                'valor' => 0,
                'porcentagem' => 0,
                'tik' => 'dow'
            ];
        }

        return $arrayReturn;
    }

    private function estoque(){
        $estoques = $this->graficoFabricacao();
        $total = 0;
        foreach ($estoques as $mes => $valor){
            $total += $valor;
        }
        return $total;
    }
}

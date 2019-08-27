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
        $moth = [
          '01' => 'Jan',
          '02' => 'Fev',
          '03' => 'Mar',
          '04' => 'Abr',
          '05' => 'Mai',
          '06' => 'Jun',
          '07' => 'Jul',
          '08' => 'Ago',
          '09' => 'Set',
          '10' => 'Out',
          '11' => 'Nov',
          '12' => 'Dez',
        ];

        $fabricacaoModelo = new FabricacaoModelo($this->entityManager);
        $fabricacao = $fabricacaoModelo->getList();

        $arrayGrafico = [];
        foreach ($fabricacao as $fabri) {
            $ind = $moth[$fabri->getDataCadastro()->format('m')];
            if (@count($arrayGrafico[$ind]) == 0) {
                $arrayGrafico[$ind] =  ceil($fabri->getQuantidade());
            } else {
                $arrayGrafico[$ind] =  ceil($arrayGrafico[$ind] + $fabri->getQuantidade());
            }
        }
        return $arrayGrafico;
    }

    private function graficoInsumos()
    {
        $moth = [
            '01' => 'Jan',
            '02' => 'Fev',
            '03' => 'Mar',
            '04' => 'Abr',
            '05' => 'Mai',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Ago',
            '09' => 'Set',
            '10' => 'Out',
            '11' => 'Nov',
            '12' => 'Dez',
        ];

        $insumoEntradaModelo = new InsumoEntradaModelo($this->entityManager);
        $insumosEntrada = $insumoEntradaModelo->getList();

        $arrayGraficoInsumo = [];
        foreach ($insumosEntrada as $entrada) {
            $ind = $moth[$entrada->getDataEntrada()->format('m')];
            if (@count($arrayGraficoInsumo[$ind]) == 0) {
                $arrayGraficoInsumo[$ind] =  ceil($entrada->getQuantidade());
            } else {
                $arrayGraficoInsumo[$ind] =  ceil($arrayGraficoInsumo[$ind] + $entrada->getQuantidade());
            }
        }
        return $arrayGraficoInsumo;
    }
}

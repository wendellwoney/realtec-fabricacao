<?php
/**
 * Created by PhpStorm.
 * User: wende
 * Date: 21/08/2019
 * Time: 15:42
 */

namespace Fabricacao\Model;

use Doctrine\ORM\EntityManager;
use Entity\Produto;
use Insumo\Model\InsumoModelo;

class ProdutoModelo implements IModel
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getList()
    {
        return $this->entityManager->getRepository(Produto::class)->findBy(
            [
                'ativo' => '1'
            ]
        );
    }

    public function get($id)
    {
        return $this->entityManager->getRepository(Produto::class)->find($id);
    }

    public function create($insumo)
    {
        try {
            $this->entityManager->beginTransaction();
            $this->entityManager->persist($insumo);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($insumo);
            return 'Produto cadastrado com sucesso';
        } catch (\Exception $e) {
            throw new \Exception('Erro no Cadastro do produto, por favor tente novamente mais tarde!');
        }
    }

    public function update($insumo)
    {
        try {
            $this->entityManager->beginTransaction();
            $this->entityManager->merge($insumo);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($insumo);
            return 'Produto editado com sucesso';
        } catch (\Exception $e) {
            throw new \Exception('Erro ao editar o produto, por favor tente novamente mais tarde!');
        }
    }

    public function delete($id)
    {
        try {
            $insumo = $this->get($id);
            $insumo->setAtivo(0);
            $insumo->setDataRemocao(new \DateTime('now'));
            $this->entityManager->beginTransaction();
            $this->entityManager->merge($insumo);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($insumo);
            return 'Produto removido com sucesso';
        } catch (\Exception $e) {
            throw new \Exception('Erro ao remover o produto, por favor tente novamente mais tarde!');
        }
    }

    public function calculaValordoProduto($idProduto){
        $formulaProduto = new ProdutoFormulaModelo($this->entityManager);
        $compostos = $formulaProduto->getProdutoFormula($idProduto);
        $valorTotal = 0;
        foreach ($compostos as $composto) {
            $valorTotal += ($composto->getQtde() * $composto->getInsumo()->getValorMedio());
        }

        return $valorTotal;
    }

}
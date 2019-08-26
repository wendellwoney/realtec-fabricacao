<?php
/**
 * Created by PhpStorm.
 * User: wende
 * Date: 21/08/2019
 * Time: 15:42
 */

namespace Fabricacao\Model;

use Doctrine\ORM\EntityManager;
use Entity\Fabricacao;
use Entity\FabricacaoFormula;
use Entity\Produto;

class FabricacaoModelo implements IModel
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getList()
    {
        return $this->entityManager->getRepository(Fabricacao::class)->findBy(
            [
                'ativo' => '1'
            ]
        );
    }

    public function get($id)
    {
        return $this->entityManager->getRepository(Fabricacao::class)->find($id);
    }

    public function create($insumo)
    {
        try {
            $this->entityManager->beginTransaction();
            $this->entityManager->persist($insumo);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($insumo);
            return 'Fabricação cadastrada!';
        } catch (\Exception $e) {
            throw new \Exception('Erro no Cadastro da fabricação, por favor tente novamente mais tarde!');
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
            return 'Fabricação editada!';
        } catch (\Exception $e) {
            throw new \Exception('Erro ao editar a fabricação, por favor tente novamente mais tarde!');
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
            return 'Fabricação removida!';
        } catch (\Exception $e) {
            throw new \Exception('Erro ao remover a fabricação, por favor tente novamente mais tarde!');
        }
    }

    public function calculaValordaFabricacao($idProduto){
        $formulaFabricacao = new FabricacaoFormulaModelo($this->entityManager);
        $compostos = $formulaFabricacao->getProdutoFormula($idProduto);
        $valorTotal = 0;
        foreach ($compostos as $composto) {
            $valorTotal += ($composto->getQtde() * $composto->getvalor());
        }

        return $valorTotal;
    }

}
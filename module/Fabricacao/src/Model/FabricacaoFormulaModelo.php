<?php
/**
 * Created by PhpStorm.
 * User: wende
 * Date: 21/08/2019
 * Time: 15:42
 */

namespace Fabricacao\Model;

use Doctrine\ORM\EntityManager;
use Entity\FabricacaoFormula;
use Produto\Model\ProdutoModelo;

class FabricacaoFormulaModelo implements IModel
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getList()
    {
        return $this->entityManager->getRepository(FabricacaoFormula::class)->findAll();
    }

    public function getFabricacaoFormula($idFabricacao)
    {
        $fabricacaoModelo = new FabricacaoModelo($this->entityManager);
        $fabricacao = $fabricacaoModelo->get($idFabricacao);
        return $this->entityManager->getRepository(FabricacaoFormula::class)->findBy(
            [
                'fabricacao' => $fabricacao
            ]
        );
    }

    public function create($insumo)
    {
        try {
            $this->entityManager->beginTransaction();
            $this->entityManager->persist($insumo);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($insumo);
            return 'Insumo cadastrado com sucesso';
        } catch (\Exception $e) {
            throw new \Exception('Erro no Cadastro da Fabricação, por favor tente novamente mais tarde!');
        }
    }

    public function update($object)
    {
        // TODO: Implement update() method.
        return false;
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
            return 'Fabricação removida';
        } catch (\Exception $e) {
            throw new \Exception('Erro ao remover a fabricação, por favor tente novamente mais tarde!');
        }
    }

    public function get($id)
    {
        return $this->entityManager->getRepository(FabricacaoFormula::class)->find($id);
    }

    public function removeFormulaFabricacao($idFabricao)
    {
        $fabricacaoFormula = $this->getFabricacaoFormula($idFabricao);
        foreach ($fabricacaoFormula as $fabricacao){
            $this->entityManager->remove($fabricacao);
            $this->entityManager->flush();
        }
    }

}
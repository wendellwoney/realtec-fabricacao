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

    public function create($fabricacao)
    {
        try {
            $this->entityManager->beginTransaction();
            $this->entityManager->persist($fabricacao);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($fabricacao);
            return 'Fabricação cadastrada!';
        } catch (\Exception $e) {
            echo $e->getMessage();exit;
            throw new \Exception('Erro no Cadastro da fabricação, por favor tente novamente mais tarde!');
        }
    }

    public function update($fabricacao)
    {
        try {
            $this->entityManager->beginTransaction();
            $this->entityManager->merge($fabricacao);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($fabricacao);
            return 'Fabricação editada!';
        } catch (\Exception $e) {
            throw new \Exception('Erro ao editar a fabricação, por favor tente novamente mais tarde!');
        }
    }

    public function delete($id)
    {
        try {
            $fabricacao = $this->get($id);
            $fabricacao->setAtivo(0);
            $fabricacao->setDataRemocao(new \DateTime('now'));
            $this->entityManager->beginTransaction();
            $this->entityManager->merge($fabricacao);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($fabricacao);
            return 'Fabricação removida!';
        } catch (\Exception $e) {
            throw new \Exception('Erro ao remover a fabricação, por favor tente novamente mais tarde!');
        }
    }

    public function calculaValordaFabricacao($idFabricacao){
        $formulaFabricacao = new FabricacaoFormulaModelo($this->entityManager);
        $compostos = $formulaFabricacao->getFabricacaoFormula($idFabricacao);
        $valorTotal = 0;
        foreach ($compostos as $composto) {
            $valorTotal += ($composto->getQtde() * $composto->getvalor());
        }

        return $valorTotal;
    }

}
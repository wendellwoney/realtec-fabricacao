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
use Insumo\Model\InsumoModelo;

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

    public function delete($idFabricacao)
    {
        try {
            $fabricacaoFormulaMOdel = new FabricacaoFormulaModelo($this->entityManager);
            $insumoModelo = new InsumoModelo($this->entityManager);
            $fabricacao = $this->get($idFabricacao);

            //Retornar o estoque
            $formulaFabricacao = $fabricacaoFormulaMOdel->getFabricacaoFormula($idFabricacao);
            foreach ($formulaFabricacao as $formula){
                $insumo = $insumoModelo->get($formula->getInsumo()->getIdInsumo());
                $insumo->setEstoqueGeral(($insumo->getEstoqueGeral() + ($fabricacao->getQuantidade() * $formula->getQtde())));
                $insumoModelo->update($insumo);
            }
            //Remover a fabricacao_formula
            $fabricacaoFormulaMOdel->removeFormulaFabricacao($idFabricacao);
            //Remover a fabricacao
            $this->entityManager->remove($fabricacao);
            $this->entityManager->flush();

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
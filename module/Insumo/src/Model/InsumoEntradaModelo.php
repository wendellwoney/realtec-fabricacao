<?php
/**
 * Created by PhpStorm.
 * User: wende
 * Date: 21/08/2019
 * Time: 15:42
 */

namespace Insumo\Model;

use Doctrine\ORM\EntityManager;
use Entity\EntradaInsumo;

class InsumoEntradaModelo implements IModel
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getList()
    {
        return $this->entityManager->getRepository(EntradaInsumo::class)->findBy(
            [
                'ativo' => '1'
            ]
        );
    }

    public function get($id)
    {
        return $this->entityManager->getRepository(EntradaInsumo::class)->find($id);
    }

    public function create($entrada)
    {
        try{
            $this->entityManager->beginTransaction();
            $this->entityManager->persist($entrada);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($entrada);
            return 'Insumo cadastrado com sucesso';
        } catch (\Exception $e) {
            throw new \Exception('Erro no Cadastro da entrada do insumo, por favor tente novamente mais tarde!');
        }
    }

    public function update($entrada)
    {
        try{
            $this->entityManager->beginTransaction();
            $this->entityManager->merge($entrada);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($entrada);
            return 'Insumo editado com sucesso';
        } catch (\Exception $e) {
            throw new \Exception('Erro ao editar a entrada do insumo, por favor tente novamente mais tarde!');
        }
    }

    public function delete($id)
    {
        try{
            $entradaInsumo = $this->get($id);
            $entradaInsumo->setAtivo(0);
            $entradaInsumo->setDataRemocao(new \DateTime('now'));
            $this->entityManager->beginTransaction();
            $this->entityManager->merge($entradaInsumo);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($entradaInsumo);
            return 'Insumo removido com sucesso';
        }catch (\Exception $e){
            throw new \Exception('Erro ao remover a entrada do insumo, por favor tente novamente mais tarde!');
        }
    }

}
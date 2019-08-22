<?php
/**
 * Created by PhpStorm.
 * User: wende
 * Date: 21/08/2019
 * Time: 15:42
 */

namespace Insumo\Model;

use Doctrine\ORM\EntityManager;
use Entity\Insumo;

class InsumoModelo implements IModel
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getList()
    {
        return $this->entityManager->getRepository(Insumo::class)->findBy(
            [
                'ativo' => '1'
            ]
        );
    }

    public function get($id)
    {
        return $this->entityManager->getRepository(Insumo::class)->find($id);
    }

    public function create($insumo)
    {
        try{
            $this->entityManager->beginTransaction();
            $this->entityManager->persist($insumo);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($insumo);
            return 'Insumo cadastrado com sucesso';
        } catch (\Exception $e) {
            throw new \Exception('Erro no Cadastro do insumo, por favor tente novamente mais tarde!');
        }
    }

    public function update($insumo)
    {
        try{
            $this->entityManager->beginTransaction();
            $this->entityManager->merge($insumo);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($insumo);
            return 'Insumo editado com sucesso';
        } catch (\Exception $e) {
            throw new \Exception('Erro ao editar o insumo, por favor tente novamente mais tarde!');
        }
    }

    public function delete($id)
    {
        try{
            $insumo = $this->get($id);
            $insumo->setAtivo(0);
            $insumo->setDataRemocao(new \DateTime('now'));
            $this->entityManager->beginTransaction();
            $this->entityManager->merge($insumo);
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->entityManager->refresh($insumo);
            return 'Insumo removido com sucesso';
        }catch (\Exception $e){
            throw new \Exception('Erro ao remover o insumo, por favor tente novamente mais tarde!');
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: wende
 * Date: 21/08/2019
 * Time: 14:39
 */

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;

/**
 *
 * @ORM\Table(name="insumo_entrada", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class EntradaInsumo implements IEntity
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idEntradaInsumo;

    /**
     * @ORM\Column(name="data_entrada",type="datetime")
     */
    private $dataEntrada;

    /**
     * @ORM\Column(name="valor",type="decimal")
     */
    private $valor;

    /**
     * @ORM\Column(name="quantidade",type="string")
     */
    private $quantidade;

    /**
     * @ORM\Column(type="string")
     */
    private $ativo;

    /**
     * @ORM\Column(name="data_cadastro",type="datetime")
     */
    private $dataCadastro;

    /**
     * @ORM\Column(name="data_atualizacao",type="datetime")
     */
    private $dataAtualizacao;

    /**
     * @ORM\Column(name="data_remocao",type="datetime")
     */
    private $dataRemocao;

    /**
     * @var \Entity\Insumo
     *
     * @ORM\ManyToOne(targetEntity="Entity\Insumo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="insumo_id", referencedColumnName="id")
     * })
     */
    private $insumo;

    /**
     * @return mixed
     */
    public function getIdEntradaInsumo()
    {
        return $this->idEntradaInsumo;
    }

    /**
     * @param mixed $idEntradaInsumo
     */
    public function setIdEntradaInsumo($idEntradaInsumo)
    {
        $this->idEntradaInsumo = $idEntradaInsumo;
    }

    /**
     * @return mixed
     */
    public function getDataEntrada()
    {
        return $this->dataEntrada;
    }

    /**
     * @param mixed $dataEntrada
     */
    public function setDataEntrada($dataEntrada)
    {
        $this->dataEntrada = $dataEntrada;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return mixed
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * @param mixed $quantidade
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    /**
     * @return mixed
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param mixed $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    /**
     * @return mixed
     */
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    /**
     * @param mixed $dataCadastro
     */
    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;
    }

    /**
     * @return mixed
     */
    public function getDataAtualizacao()
    {
        return $this->dataAtualizacao;
    }

    /**
     * @param mixed $dataAtualizacao
     */
    public function setDataAtualizacao($dataAtualizacao)
    {
        $this->dataAtualizacao = $dataAtualizacao;
    }

    /**
     * @return mixed
     */
    public function getDataRemocao()
    {
        return $this->dataRemocao;
    }

    /**
     * @param mixed $dataRemocao
     */
    public function setDataRemocao($dataRemocao)
    {
        $this->dataRemocao = $dataRemocao;
    }

    /**
     * @return Insumo
     */
    public function getInsumo()
    {
        return $this->insumo;
    }

    /**
     * @param Insumo $insumo
     */
    public function setInsumo($insumo)
    {
        $this->insumo = $insumo;
    }

    public function toArray()
    {
        return [
            'idEntradaInsumo' => $this->getIdEntradaInsumo(),
            'dataEntrada'     => $this->getDataEntrada(),
            'valor'           => $this->getValor(),
            'quantidade'      => $this->getQuantidade(),
            'insumo'          => $this->getInsumo()->toArray()
        ];
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


}
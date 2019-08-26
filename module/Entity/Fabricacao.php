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
 * @ORM\Table(name="fabricacao", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Fabricacao implements IEntity
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idFabricacao;

    /**
     * @ORM\Column(type="string")
     */
    private $quantidade;

    /**
     * @ORM\Column(type="string")
     */
    private $codigo;

    /**
     * @ORM\Column(type="text")
     */
    private $observacao;

    /**
     * @ORM\Column(type="string")
     */
    private $ativo;

    /**
     * @ORM\Column(name="data_cadastro",type="datetime")
     */
    private $dataCadastro;

    /**
     * @ORM\Column(name="data_remocao",type="datetime")
     */
    private $dataRemocao;

    /**
     * @var \Entity\Insumo
     *
     * @ORM\ManyToOne(targetEntity="Entity\Produto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produto_id", referencedColumnName="id")
     * })
     */
    private $produto;

    /**
     * @return Insumo
     */
    public function getProduto()
    {
        return $this->produto;
    }

    /**
     * @param Insumo $produto
     */
    public function setProduto($produto)
    {
        $this->produto = $produto;
    }

    public function toArray()
    {
        return [
            'idFabricacao' => $this->getIdFabricacao(),
            'quantidade' => $this->getQuantidade(),
            'codigo' => $this->getCodigo(),
            'observacao' => $this->getObservacao(),
            'ativo' => $this->getAtivo(),
            'dataCadastrp' => $this->getDataCadastro(),
            'dataRemocao' => $this->getDataRemocao()
        ];
    }

    /**
     * @return mixed
     */
    public function getIdFabricacao()
    {
        return $this->idFabricacao;
    }

    /**
     * @param mixed $idFabricacao
     */
    public function setIdFabricacao($idFabricacao)
    {
        $this->idFabricacao = $idFabricacao;
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
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return mixed
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * @param mixed $observacao
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
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

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


}
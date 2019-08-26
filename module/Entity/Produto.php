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
 * @ORM\Table(name="produto", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Produto implements IEntity
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idProduto;

    /**
     * @ORM\Column(type="string")
     */
    private $nome;

    /**
     * @ORM\Column(type="string")
     */
    private $codigo;

    /**
     * @ORM\Column(type="text")
     */
    private $descricao;

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
     * @ORM\Column(name="unidade_medida",type="string")
     */
    private $unidadeMedida;

    /**
     * @return mixed
     */
    public function getUnidadeMedida()
    {
        return $this->unidadeMedida;
    }

    /**
     * @param mixed $unidadeMedida
     */
    public function setUnidadeMedida($unidadeMedida)
    {
        $this->unidadeMedida = $unidadeMedida;
    }

    /**
     * @return mixed
     */
    public function getIdProduto()
    {
        return $this->idProduto;
    }

    /**
     * @param mixed $idProduto
     */
    public function setIdProduto($idProduto)
    {
        $this->idProduto = $idProduto;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
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
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
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


    public function toArray()
    {
        return [
            'idProduto' => $this->getIdProduto(),
            'nome' => $this->getNome(),
            'codigo' => $this->getCodigo(),
            'descricao' => $this->getDescricao(),
            'Unidade' => $this->getUnidadeMedida(),
            'ativo' => $this->getAtivo()
        ];
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


}
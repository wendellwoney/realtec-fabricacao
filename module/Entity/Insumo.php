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

class Insumo implements IEntity
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idInsumo;

    /**
     * @ORM\Column(type="string")
     */
    private $nome;

    /**
     * @ORM\Column(type="string")
     */
    private $codigo;

    /**
     * @ORM\Column(name="unidade_medida",type="string")
     */
    private $unidadeMedida;

    /**
     * @ORM\Column(name="valor_minimo",type="decimal")
     */
    private $alertaValorMinimo;

    /**
     * @ORM\Column(name="estoque",type="decimal")
     */
    private $estoqueGeral;

    /**
     * @ORM\Column(name="valor_medio",type="decimal")
     */
    private $valorMedio;

    /**
     * @ORM\Column(type="text")
     */
    private $observacao;

    /**
     * @ORM\Column(type="string(1)")
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
     * @return mixed
     */
    public function getIdInsumo()
    {
        return $this->idInsumo;
    }

    /**
     * @param mixed $idInsumo
     */
    public function setIdInsumo($idInsumo)
    {
        $this->idInsumo = $idInsumo;
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
    public function getAlertaValorMinimo()
    {
        return $this->alertaValorMinimo;
    }

    /**
     * @param mixed $alertaValorMinimo
     */
    public function setAlertaValorMinimo($alertaValorMinimo)
    {
        $this->alertaValorMinimo = $alertaValorMinimo;
    }

    /**
     * @return mixed
     */
    public function getEstoqueGeral()
    {
        return $this->estoqueGeral;
    }

    /**
     * @param mixed $estoqueGeral
     */
    public function setEstoqueGeral($estoqueGeral)
    {
        $this->estoqueGeral = $estoqueGeral;
    }

    /**
     * @return mixed
     */
    public function getValorMedio()
    {
        return $this->valorMedio;
    }

    /**
     * @param mixed $valorMedio
     */
    public function setValorMedio($valorMedio)
    {
        $this->valorMedio = $valorMedio;
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
            'idInsumo'        => $this->getIdInsumo(),
            'nome'            => $this->getNome(),
            'codigo'          => $this->getCodigo(),
            'unidadeMedida'   => $this->getUnidadeMedida(),
            'valorMinimo'     => $this->getAlertaValorMinimo(),
            'estoque'         => $this->getEstoqueGeral(),
            'valorMedio'      => $this->getValorMedio(),
            'observacao'      => $this->getObservacao(),
            'ativo'           => $this->getAtivo(),
            'dataCadastrp'    => $this->getDataCadastro(),
            'dataAtualizacao' => $this->getDataAtualizacao(),
            'dataRemocao'     => $this->getDataRemocao()
        ];
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


}
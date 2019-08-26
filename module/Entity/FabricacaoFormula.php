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
 * @ORM\Table(name="fabricacao_formula", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class FabricacaoFormula implements IEntity
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idProdutoFormula;

    /**
     * @ORM\Column(name="quantidade",type="decimal")
     */
    private $qtde;

    /**
     * @ORM\Column(name="valor",type="decimal")
     */
    private $valor;

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
     * @var \Entity\Insumo
     *
     * @ORM\ManyToOne(targetEntity="Entity\Produto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produto_id", referencedColumnName="id")
     * })
     */
    private $produto;

    /**
     * @return mixed
     */
    public function getIdProdutoFormula()
    {
        return $this->idProdutoFormula;
    }

    /**
     * @param mixed $idProdutoFormula
     */
    public function setIdProdutoFormula($idProdutoFormula)
    {
        $this->idProdutoFormula = $idProdutoFormula;
    }

    /**
     * @return mixed
     */
    public function getQtde()
    {
        return $this->qtde;
    }

    /**
     * @param mixed $qtde
     */
    public function setQtde($qtde)
    {
        $this->qtde = $qtde;
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


    public function toArray()
    {
        return [
            'idProdutoFormula' => $this->getIdProdutoFormula(),
            'insumo' => $this->getInsumo()->toArray(),
            'quantidade' => $this->getQtde(),
            'valor' => $this->getValor(),
            'produto' => $this->getProduto()->toArray()
        ];
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


}
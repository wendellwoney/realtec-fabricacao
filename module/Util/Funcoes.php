<?php
/**
 * Created by PhpStorm.
 * User: wende
 * Date: 26/08/2019
 * Time: 10:11
 */

namespace Util;


class Funcoes
{
    public static function valorUnitario($valorCompra, $valorQauntidade)
    {
        return ($valorCompra/$valorQauntidade);
    }
}
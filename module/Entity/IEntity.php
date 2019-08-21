<?php
/**
 * Created by PhpStorm.
 * User: wende
 * Date: 06/06/2019
 * Time: 13:24
 */

namespace Entity;


interface IEntity
{
    public function toArray();
    public function getArrayCopy();
}
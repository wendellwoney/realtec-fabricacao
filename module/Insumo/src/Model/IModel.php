<?php
/**
 * Created by PhpStorm.
 * User: wende
 * Date: 06/06/2019
 * Time: 13:42
 */

namespace Insumo\Model;

interface IModel
{
    public function getList();
    public function get($id);
    public function create($object);
    public function update($object);
    public function delete($id);

}
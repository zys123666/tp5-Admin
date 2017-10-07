<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/23
 * Time: 14:40
 */

namespace app\admin\controller;
use think\Controller;

class Product extends Base
{
    public function productBrand ()
    {
        return $this->fetch();
     }
    public function productCategory ()
    {
        return $this->fetch();
    }
    public function productList ()
    {
        return $this->fetch();
    }
    public function productCategoryAdd ()
    {
        return $this->fetch();
    }
}
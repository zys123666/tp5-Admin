<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/22
 * Time: 11:14
 */

namespace app\admin\controller;
use think\Controller;

class Consult extends  Base
{
    public function consultList()
    {
        return $this->fetch();
   }
}
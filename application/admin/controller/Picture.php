<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/23
 * Time: 14:32
 */

namespace app\admin\controller;
use think\Controller;

class Picture extends Base
{
    public function pictureList()
    {
        return $this->fetch();
     }
}
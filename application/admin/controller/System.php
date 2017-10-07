<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/23
 * Time: 16:07
 */

namespace app\admin\controller;
use think\Controller;

class System extends Base
{
    public function systemBase ()
    {
        return $this->fetch();
    }

    public function systemCategory ()
    {
        return $this->fetch();
    }

    public function systemData ()
    {
        return $this->fetch();
    }

    public function systemShield ()
    {
        return $this->fetch();
    }

    public function systemLog ()
    {
        return $this->fetch();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/23
 * Time: 15:15
 */

namespace app\admin\controller;
use think\Controller;

class Member extends Base
{
    public function memberList ()
    {
        return $this->fetch();
    }

    public function memberDel ()
    {
        return $this->fetch();
    }

    public function memberLevel ()
    {
        return $this->fetch();
    }

    public function memberScore ()
    {
        return $this->fetch();
    }

    public function memberRecordBrowse ()
    {
        return $this->fetch();
    }

    public function memberRecordDownload ()
    {
        return $this->fetch();
    }

    public function memberRecordShare ()
    {
        return $this->fetch();
    }
}
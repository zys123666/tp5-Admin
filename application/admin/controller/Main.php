<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/22
 * Time: 9:36
 */
namespace  app\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
class main extends  Base
{
    public  function  index () {
        $act_list = Session::get('prm_list','think');
        $menu_list = getMenuList($act_list);
        $this->assign('menu_list',$menu_list);//view
        $admin_info = getAdminInfo(session('admin_id'));
        $this->assign('admin_info',$admin_info);
        return $this->fetch();
}
    public  function  welcome () {
        return $this->fetch();
    }
}
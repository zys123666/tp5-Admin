<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/7
 * Time: 13:42
 */

namespace app\admin\controller;
use think\Controller;
use think\Page;
use think\Verify;
use think\Db;
use think\Session;
use think\Request;
class Base extends  controller
{
    public function _initialize()
    {
        //过滤不需要登陆的行为
        $request=  \think\Request::instance();
        $controllerName = $request->controller();
        $actionName = $request->action();
        if(in_array($actionName,array('login','logout','vertify')) || in_array($controllerName,array('Ueditor','Uploadify'))){
            //return;
        }else{
            if(Session::get('admin_id','think') > 0 ){
                $this->checkPriv();//检查管理员菜单操作权限
            }else{
                $this->error('请先登录',url('Admin/Index/index'),1);
            }
        }

    }


    public function checkPriv()
    {
        $request=  \think\Request::instance();
        $controllerName = $request->controller();
        $actionName = $request->action();
        $act_list = Session::get('prm_list','think');
        //无需验证的操作
        $uneed_check = array('login','logout','vertifyHandle','vertify','imageUp','upload','login_task');
        if($controllerName == 'Main' || $act_list == 'all'){
            //后台首页控制器无需验证,超级管理员无需验证
            return true;
        }elseif(request()->isAjax() || strpos($actionName,'ajax')!== false || in_array($actionName,$uneed_check)){
            //所有ajax请求不需要验证权限
            return true;
        }else{
            $right = Db::table('tp_prminfo')->where("id", "in", $act_list)->select();
            $role_right = '';
            foreach ($right as $val){
                $role_right .= $val['right'].',';
            }
            $role_right = explode(',', $role_right);
            //检查是否拥有此操作权限
            if(!in_array($controllerName.'@'.$actionName, $role_right)){
                $this->error('您没有操作权限['.($controllerName.'@'.$actionName).'],请联系超级管理员分配权限',url('main/index'));
            }


        }
    }
}
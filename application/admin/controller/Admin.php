<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/23
 * Time: 15:43
 */

namespace app\admin\controller;
use think\Controller;
use think\Page;
use think\Verify;
use think\Db;
use think\Session;
class Admin extends Base
{
    public function adminRole()
    {
        return $this->fetch();
    }

    public function adminRoleAdd()
    {
        $detail = array();
        $right = db::table('tp_prminfo')->order('id')->select();
        foreach ($right as $val){
            if(!empty($detail)){
                $val['enable'] = in_array($val['id'], $detail['prm_list']);
            }
            $modules[$val['group']][] = $val;
        }
        //权限组
        $group = array('system'=>'系统管理','admin'=>'管理员管理','member'=>'会员中心','consult'=>'评论管理',
            'picture'=>'图片管理','product'=>'产品管理');
        $this->assign('group',$group);
        $this->assign('modules',$modules);
        return $this->fetch();
    }

    public function roleEdit()
    {
        $data = input('post.');
        $data['prm_list'] = is_array($data['right']) ? implode(',', $data['right']) : '';
        unset($data['right']);
        if (empty($data['prm_list']))
            $this->error("请选择权限!");
        if (empty($data['role_id'])) {
            $admin_role = Db::table('tp_role')->where(['role_name' => $data['role_name']])->find();
            if ($admin_role) {
                $this->error("已存在相同的角色名称!");
            } else {
                $r = Db::table('tp_role')->insert($data);
            }
        } else {
            $admin_role = Db::table('tp_role')->where(['role_name' => $data['role_name'], 'role_id' => ['<>', $data['role_id']]])->find();
            if ($admin_role) {
                $this->error("已存在相同的角色名称!");
            } else {
                $r = db::table('tp_role')->where('role_id', $data['role_id'])->save($data);
            }
        }
        if ($r) {

            $this->success("操作成功!", ('Admin/Admin/roleEdit'));
        } else {
             $this->error('操作失败');
        }
    }
    public function adminPrm()
    {
        return $this->fetch();
    }

    public function adminPrmAdd()
    {
        $group = array('system'=>'系统管理','admin'=>'管理员管理','member'=>'会员中心','consult'=>'评论管理',
            'picture'=>'图片管理','product'=>'产品管理');
        $this->assign('group',$group);
        $controllerUrl = APP_PATH.'admin/controller';
        $controllerList = array();
        $dirRes = opendir($controllerUrl);
        while ($dir = readdir($dirRes)){
            if (!in_array($dir,array('.','..'))){
                $controllerList[] = basename($dir,'.php');
            }
        }
        $this->assign('controllerList',$controllerList);
        return $this->fetch();
    }

    public function adminList()
    {
        $adminList= Db::table('tp_admin')->select();
        $roleInfo = Db::table('tp_role')->select();
        foreach ($roleInfo as $va){
            $role[$va['role_id']] = $va['role_name'];
        }
        foreach ($adminList as $val){
            $val['role'] =  $role[$val['role_id']];
            $list[] = $val;
        }
        $this ->assign('adminList',$list);
        return $this->fetch();
    }

    public function vertify()
    {
        $config = array(
            'fontSize' => 16,
            'length' => 4,
            'useCurve' => true,
            'useNoise' => false,
            'reset' => false
        );
        $Verify = new Verify($config);
        $Verify->entry("admin_login");
        exit();
    }

    public function ajax_get_action()
    {
        $control = input('get.controller');
        $controllerName = "app\\admin\\controller\\".str_replace('.php','',$control);
        $actList = get_class_methods($controllerName);

        $html = '';
        foreach ($actList as $value){
            $html .= '<option value="'.$value.'">'.$value.'</option>';
        }
        exit($html);
    }

    public function prmEdit()
    {
        $data = input('post.');
        $data['right'] = implode(',',$data['right']);
        if(!empty($data['id'])){
            db::table('tp_prminfo')->where(array('id'=>$data['id']))->update($data);
        }else{
            if(db::table('tp_prminfo')->where(array('name'=>$data['name']))->count()>0){
                $this->error('该权限名称已添加，请检查',url('Admin/right_list'));
            }
            unset($data['id']);
           $res = db::table('tp_prminfo')->insert($data);
        }
        if($res){
            $this->success('操作成功',url('Admin/right_list'));
        }else{
            $this->error('操作失败');
        }

        exit;
    }

}
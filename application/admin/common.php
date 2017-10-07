<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/7
 * Time: 15:05
 */
use think\Db;
function getAdminInfo($admin_id){
    return Db::table('tp_admin')->where("id", $admin_id)->find();
}

function getMenuList($act_list){
    //根据角色权限过滤菜单
    $menu_list = getAllMenu();
    if($act_list != 'all'){
        $right = Db::table('tp_prminfo')->where("id", "in", $act_list)->cache(true)->select();
        $role_right = '';
        foreach ($right as $val){
            $role_right .= $val['right'].',';
        }
        $role_right = explode(',', $role_right);
        foreach($menu_list as $k=>$mrr){
            foreach ($mrr['sub_menu'] as $j=>$v){
                if(!in_array($v['control'].'@'.$v['act'], $role_right)){
                    unset($menu_list[$k]['sub_menu'][$j]);//过滤菜单
                }
            }
        }
    }
    return $menu_list;
}

function getAllMenu(){
    return	array(
        'system' => array('name'=>'系统设置','icon'=>'fa-cog','sub_menu'=>array(
            array('name'=>'网站设置','act'=>'systemBase','control'=>'System'),
            array('name'=>'栏目管理','act'=>'systemCategory','control'=>'System'),
            array('name'=>'数据字典','act'=>'systemData','control'=>'System'),
            array('name'=>'屏蔽词','act'=>'systemShield','control'=>'System'),
            array('name'=>'系统日志','act'=>'systemLog','control'=>'System'),

        )),
        'admin' => array('name' => '管理员管理', 'icon'=>'fa-gears', 'sub_menu' => array(
            array('name' => '管理员列表', 'act'=>'adminList', 'control'=>'Admin'),
            array('name' => '角色管理', 'act'=>'adminRole', 'control'=>'Admin'),
            array('name' => '权限管理', 'act'=>'adminPrm', 'control'=>'Admin'),

        )),
        'member' => array('name'=>'会员管理','icon'=>'fa-user','sub_menu'=>array(
            array('name'=>'会员列表','act'=>'memberList','control'=>'Member'),
            array('name'=>'等级管理','act'=>'memberLevel','control'=>'Member'),
            array('name'=>'积分管理','act'=>'memberScore','control'=>'Member'),
            array('name' => '下载记录', 'act'=>'memberRecordDownload', 'control'=>'Member'),
            array('name' => '浏览记录', 'act'=>'memberRecordBrowse', 'control'=>'Member'),
            array('name'=>'删除的会员','act'=>'memberDel','control'=>'Member'),
        )),
        'consult' => array('name' => '咨询管理', 'icon'=>'fa-book', 'sub_menu' => array(
            array('name' => '咨询列表', 'act'=>'consultList', 'control'=>'Consult'),

        )),
        'product' => array('name' => '产品管理', 'icon'=>'fa-money', 'sub_menu' => array(
            array('name' => '品牌管理', 'act'=>'productBrand', 'control'=>'Product'),
            array('name' => '分类管理', 'act'=>'productCategory', 'control'=>'Product'),
            array('name' => '产品管理', 'act'=>'productList', 'control'=>'Product')
        )),
        'picture' => array('name' => '图片管理', 'icon'=>'fa-flag', 'sub_menu' => array(
            array('name' => '图片列表', 'act'=>'pictureList', 'control'=>'Picture'),

        )),

    );






}
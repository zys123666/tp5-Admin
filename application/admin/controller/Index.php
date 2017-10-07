<?php
namespace app\admin\controller;
use think\Controller;
use think\Verify;
use think\Db;
use think\Session;
use think\Request;
class index extends controller
{
	public function index () {
	   return $this-> fetch();
	}

    public function login()
    {
            $checkCode = input('post.checkCode');
            $check_Code = new Verify();
            if (!$check_Code ->check($checkCode,'admin_login')){
                exit(json_encode(array('status'=>0,'msg'=>'验证码错误')));
            }
            $condition['username'] = input('post.username');
            $condition['password'] = input('post.password');
            if (!empty($condition['username']) && !empty($condition)) {
                $adminInfo= Db::table('tp_admin')->where($condition)->find();
                if (is_array($adminInfo)){
                    Session::set('admin_id',$adminInfo['id']);
                    $role_query['role_id'] = $adminInfo['role_id'];
                    $role = Db::table('tp_role')->where($role_query)->find();
                    Session::set('prm_list',$role['prm_list']);
                    $url = url('admin/main/index');
                    exit(json_encode(array('status'=>1,'url'=>$url)));
                }
            }else {
                exit(json_encode(array('status'=>0,'msg'=>'用户名和账号不能为空')));
            }
        }

	
}
<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller
{
   public function __construct()
   {
       parent::__construct();
       //判断是否登陆
       if (!session('id')){
           $this->error('请先登录',U('Login/index'));
       }

       //所有管理员都有权限进入管理首页
       if (MODULE_NAME=='Admin' && CONTROLLER_NAME=='Index'){ //所有管理员都有权限进入管理首页
           return true;
       }

       //所有管理员都有权限退出登陆
       if (MODULE_NAME=='Admin' && CONTROLLER_NAME=='Admin' && ACTION_NAME=='logout'){
           return true;
       }

       //所有管理员都有权限退出修改自己的密码
           if (MODULE_NAME=='Admin' && CONTROLLER_NAME=='Admin' && ACTION_NAME=='edit' && MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME."/id/"){
               return true;
           }

       //权限验证
       if (session('privilege')!='*' && !in_array(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME,session('privilege'))){
           $this->error('没有权限访问该功能');
       }
   }
}
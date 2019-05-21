<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
        if (IS_POST){
            $admin=D('admin');
            if ($admin->create($_POST,4)){
                if ($admin->login()){
                    $this->success('登陆中....',U('index/index'));
                }else{
                   $this->error('用户名或密码错误');
                }
            }else{
                $this->error($admin->getError());
            }
            return;
        }
        $this->display();
    }

    public function verify(){
        $verify=new \Think\Verify();
        $verify->length=4;
        $verify->entry();
    }
}
<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model
{
    //自动验证
    protected $_validate = array(
        array('username','require','管理员名称不能为空',1),
        array('username','','管理员名称不能重复',1,unique,1),
        array('username','','管理员名称不能重复',1,unique,2),
        array('password','require','密码不能为空',1),
        array('verify','verify','验证码错误',1,'callback',4),//4代表登陆是后验证
    );

    public function getpri($roleid){
        //获取权限
        $role=D('role');
        $pri=D('privilege');
        $role->field('rolename,pri_id_list')->find($roleid); //获取角色
        session('rolename',$role->rolename);
        if ($role->pri_id_list=='*'){
            //超级管理员
            session('privilege','*');
            $menu=$pri->where('parentid=0')->select();//顶级权限
            foreach ($menu as $k=>$v) { //遍历权限
                $menu[$k]['sub']=$pri->where("parentid={$v['id']}")->select();//二级权限
            }
            session('menu',$menu);
        }else{
            //非超级管理员
            //组合成Admin/Admin/add 。。。。
            $pris=$pri->field('id,parentid,pri_name,mname,cname,aname,CONCAT(mname,"/",cname,"/",aname) url')->where("id IN({$role->pri_id_list})")->select();
            $_pris=array();
            foreach ($pris as $k=>$v) {
                $_pris[]=$v['url'];
                if ($v['parentid']==0){ //找出一级权限
                    $menu[]=$v;
                }
            }
            session('privilege',$_pris);//写入session，
            foreach ($menu as $k=>$v) { //取出二级权限
                foreach ($_pris as $k1=>$v1) {
                    if ($v1['parentid']==$v['id']){
                        $menu[$k]['sub'][]=$v1;
                    }
                }
            }
            session('menu',$menu);
        }
    }

    public function login(){
        //验证登陆功能
        $password=$this->password;
        $info=$this->where("username='$this->username'")->find();
        if ($info){
            $id=$info['id'];
            //获取管理员名称，写入session field('b.rolename')->alias('a')->join('LEFT JOIN cs_role b ON a.roleid=b.id')
            //$roles=$this->field('b.rolename')->alias('a')->join('LEFT JOIN cs_role b ON a.roleid=b.id')->where("a.id=$id")->find();
            //$rolename=$roles['rolename'];
            if ($info['password']==md5($password)){
               session('id',$info['id']);
               session('username',$info['username']);
               session('roleid',$info['roleid']);
               //session('rolename',$rolename);
                $this->getpri($info['roleid']);
               return true;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    public function verify($code){
        $verify=new \Think\Verify();
        return $verify->check($code,'');
    }
}
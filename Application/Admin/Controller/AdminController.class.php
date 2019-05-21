<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends CommonController {
    public function lst(){
        $admin=D('admin');
        $where=1;
        if ($kw=I('kw')){
            $where.=' AND username LIKE "%'.$kw.'%"';
        }
        $count=$admin->where($where)->count();
        $Page=new \Think\Page($count,5);//实例化分页
        $show=$Page->show();//分页显示数据
        $list=$admin->field('a.*,b.rolename rolename')->alias('a')->join('LEFT JOIN cs_role b ON a.roleid=b.id')->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }

    public function add()
    {
        $admin=D('admin');
        if (IS_POST)
        {
            if($data=$admin->create())
            {
                $admin->password=md5($admin->password);
                if ($admin->add())
                {$this->success('添加成功', U('lst'));}
                else {$this->error('添加失败',U('lst'));}
            }else
                {
                $this->error($admin->getError());
                }
            return;
        }
        $role=D('role');
        $roles=$role->select();
        $this->assign('roles',$roles);
        $this->display();
    }


    public function edit($id){
        $admin=D('admin');
        $role=D('role');
        if (IS_POST){
            if ($admin->create()){
                $admin->password=md5($admin->password);
                if($admin->save()) {
                    $this->success('修改成功！',U('lst'));
                }else {
                    $this->error('修改失败！');
                }
            }else{
                $this->error($admin->getError());
            }
            return;
        }
        $roles=$role->select();
        $adminres=$admin->find($id);
        $this->assign('adminres',$adminres);
        $this->assign('roles',$roles);
        $this->display();
    }

    public function del($id){
        $admin=D('admin');
        if($admin->delete($id)){
            $this->success('删除成功',U('lst'));
        }else{
            $this->error('删除失败',U('lst'));
        }
    }

    public function bdel(){
        $admin=D('admin');
        $ids=I('ids');
        $ids=implode(',',$ids);
        if ($ids)
        {
            if ($admin->delete($ids))
            {
                $this->success('删除成功',U('lst'));
            }else
            {
                $this->error('删除失败',U('lst'));
            }
        }else
        {
            $this->error('未选择任何内容',U('lst'));
        }
    }

    public function logout(){
        //清除session
        session(null);
        //跳转
        $this->success('退出成功',U('index/login'));
    }
}
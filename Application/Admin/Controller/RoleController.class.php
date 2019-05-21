<?php
namespace Admin\Controller;
use Think\Controller;
class RoleController extends CommonController
{
    public function lst()
    {
        $role=D('role');
        $count=$role->count();//获取记录数
        $Page=new \Think\Page($count,5);//实例化分页
        $show=$Page->show();//分页显示数据
        $list=$role->field('a.*,GROUP_CONCAT(b.pri_name) pri_name')->alias('a')->join('LEFT JOIN cs_privilege b ON FIND_IN_SET(b.id,a.pri_id_list)')->group('a.id')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }

    public function add()
    {
        //添加连接
        $role=D('role');
        if (IS_POST){
            if ($role->create()){ //直接使用表单值
                $role->pri_id_list=implode(',',$role->pri_id_list);
                if ($role->add()){
                    $this->success('添加成功',U('lst'));
                }else{
                    $this->error('添加失败',U('lst'));
                }
            }else{
                $this->error($role->getError());
            }
            return;
        }
        $privilege=D('privilege');
        $pris=$privilege->pritree();
        $this->assign('pris',$pris);
        $this->display();
    }

    public function edit()
    {
        $role=D('role');
        if(IS_POST){
            if ($role->create()){ //直接使用表单值
                $role->pri_id_list=implode(',',$role->pri_id_list);
                if ($role->save()){
                    $this->success('修改成功',U('lst'));
                }else{
                    $this->error('修改失败',U('lst'));
                }
            }else{
                $this->error($role->getError());
            }
            return;
        }
        $id=I('id');
        $privilege=D('privilege');
        $pris=$privilege->select(); //获取权限列表
        $roleres=$role->find($id);
        $this->assign('pris',$pris);
        $this->assign('roleres',$roleres);
        $this->display();
    }

    public function del()
    {
        $role=D('role');
        $id=I('id');
        if ($id==1){
            $this->error('超级管理员不能删除',U('lst'));
        }
        if ($role->delete($id))
        {
            $this->success('删除成功',U('lst'));
        }else{
            $this->error('删除失败',U('lst'));
        }
    }

    public function bdel()
    {
        $role=D('role');
        $ids=I('ids');
        if ($ids)
        {
            //排除管理员
            $key=array_search(1,$ids);
            if ($key!==false){
                unset($ids[$key]);//去除管理员id
            }
            $ids=implode(',',$ids);
            if ($role->delete($ids))
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

}
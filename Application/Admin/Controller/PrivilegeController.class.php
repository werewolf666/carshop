<?php
namespace Admin\Controller;
use Think\Controller;
class PrivilegeController extends CommonController
{
    public function lst()
    {
        $privilege=D('privilege');
        $pris=$privilege->pritree();
        $this->assign('pris',$pris);
        $this->display();
    }

    public function add()
    {
        //添加连接
        $privilege=D('privilege');
        if (IS_POST){
            if ($privilege->create()){ //直接使用表单值
                if ($privilege->add()){
                    $this->success('添加成功',U('lst'));
                }else{
                    $this->error('添加失败',U('lst'));
                }
            }else{
                $this->error($privilege->getError());
            }
            return;
        }
        $pris=$privilege->pritree();
        $this->assign('pris',$pris);
        $this->display();
    }

    public function edit()
    {
        $privilege=D('privilege');
        if(IS_POST){
            if ($privilege->create()){ //直接使用表单值
                if ($privilege->save()){
                    $this->success('修改成功',U('lst'));
                }else{
                    $this->error('修改失败',U('lst'));
                }
            }else{
                $this->error($privilege->getError());
            }
            return;
        }
        $id=I('id');
        $prires=$privilege->find($id);
        $pris=$privilege->pritree();
        $this->assign('pris',$pris);
        $this->assign('prires',$prires);
        $this->display();
    }

    public function del()
    {
        $privilege=D('privilege');
        $id=I('id');
        if ($privilege->delete($id))
        {
            $this->success('删除成功',U('lst'));
        }else{
            $this->error('删除失败',U('lst'));
        }
    }

    public function bdel()
    {
        $privilege=D('privilege');
        $ids=I('ids');
        $ids=implode(',',$ids);
        if ($ids)
        {
            if ($privilege->delete($ids))
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

    public function sortprivilege()
    {
        $privilege=D('privilege');
        foreach ($_POST as $id=>$sort)
        {
            $privilege->where("id=$id")->setField("sort",$sort);
        }
        $this->success('更新成功',U('lst'));
    }
}
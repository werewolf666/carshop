<?php
namespace Admin\Controller;
use Think\Controller;
class LinkController extends CommonController
{
    public function lst()
    {
        $link=D('link');
        $linkres=$link->order('sort asc')->select();
        $this->assign('linkres',$linkres);
        $this->display();
    }

    public function add()
    {
        //添加连接
        $link=D('link');
        if (IS_POST){
            if ($link->create()){ //直接使用表单值
                if ($link->add()){
                    $this->success('添加成功',U('lst'));
                }else{
                    $this->error('添加失败',U('lst'));
                }
            }else{
                $this->error($link->getError());
            }
            return;
        }
        $this->display();
    }

    public function edit()
    {
        $link=D('link');
        if(IS_POST){
            if ($link->create()){ //直接使用表单值
                if ($link->save()){
                    $this->success('修改成功',U('lst'));
                }else{
                    $this->error('修改失败',U('lst'));
                }
            }else{
                $this->error($link->getError());
            }
            return;
        }
        $id=I('id');
        $links=$link->find($id);
        $this->assign('links',$links);
        $this->display();
    }

    public function del()
    {
        $link=D('link');
        $id=I('id');
        if ($link->delete($id))
        {
            $this->success('删除成功',U('lst'));
        }else{
            $this->error('删除失败',U('lst'));
        }
    }

    public function bdel()
    {
        $link=D('link');
        $ids=I('ids');
        $ids=implode(',',$ids);
        if ($ids)
        {
            if ($link->delete($ids))
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

    public function sortlink()
    {
        $link=D('link');
        foreach ($_POST as $id=>$sort)
        {
            $link->where("id=$id")->setField("sort",$sort);
        }
        $this->success('更新成功',U('lst'));
    }
}
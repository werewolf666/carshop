<?php
namespace Admin\Controller;
use Think\Controller;
class JobController extends CommonController
{
    public function lst()
    {
        $job=D('job');
        $count=$job->count();//获取记录数
        $Page=new \Think\Page($count,5);//实例化分页
        $show=$Page->show();//分页显示数据
        $list=$job->field('id,title,name,sex,bplace,education')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }

    public function detail(){
        $id=I('id');
        $job=D('job');
        $jobs=$job->find($id);
        $this->assign('jobs',$jobs);
        $this->display();
    }

    public function del()
    {
        $job=D('job');
        $id=I('id');
        if ($job->delete($id))
        {
            $this->success('删除成功',U('lst'));
        }else{
            $this->error('删除失败',U('lst'));
        }
    }

    public function bdel()
    {
        $job=D('job');
        $ids=I('ids');
        $ids=implode(',',$ids);
        if ($ids)
        {
            if ($job->delete($ids))
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

    public function sortjob()
    {
        $job=D('job');
        foreach ($_POST as $id=>$sort)
        {
            $job->where("id=$id")->setField("sort",$sort);
        }
        $this->success('更新成功',U('lst'));
    }
}
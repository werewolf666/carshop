<?php
namespace Admin\Controller;
use Think\Controller;
class MessageController extends CommonController
{
    public function lst()
    {
        $message=D('message');
        $count=$message->count();//获取记录数
        $Page=new \Think\Page($count,5);//实例化分页
        $show=$Page->show();//分页显示数据
        $list=$message->order('id asc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }


    //留言回复
    public function reply($id)
    {
        $reply=D('reply');
        if (IS_POST){
            $data['mid']=I('mid');
            $data['content']=I('content');
            $data['time']=time();
            if ($reply->create($data)){
                if ($reply->add()){
                    $this->success('回复成功',U('lst'));
                }else{
                    $this->error('回复失败');
                }
            }else{
                $this->error($reply->getError());
            }
            return;
        }
        $message=D('message');
        $replyres=$reply->where('mid='.$id)->select();
        $messages=$message->find($id);
        $this->assign('messages',$messages);
        $this->assign('replyres',$replyres);
        $this->display();
    }


    //留言审核
    public function checked($id){
        $message=D('message');
        if (IS_POST){
            if ($message->create()){
                if ($message->save()){
                    $this->success('审核成功',U('lst'));
                }else{
                    $this->error('审核失败');
                }
            }else{
                $this->error($message->getError());
            }
            return;
        }
        $messages=$message->find($id);
        $this->assign('messages',$messages);
        $this->display();
    }

    //单个删除
    public function del()
    {
        $message=D('message');
        $reply=D('reply');
        $id=I('id');
        if ($message->delete($id))
        {
            //删除该留言对应的所有回复
            $reply->where('mid='.$id)->delete();
            $this->success('删除成功',U('lst'));
        }else{
            $this->error('删除失败',U('lst'));
        }
    }

    //批量删除
    public function bdel()
    {
        $message=D('message');
        $reply=D('reply');
        $ids=I('ids');//需要删除的id
        $ides=$ids;//另存一份
        if ($ids)
        {
            $ids=implode(',',$ids);
            if ($message->delete($ids))
            {
                foreach ($ides as $k=>$v) {
                    $reply->where('mid='.$v)->delete();
                }
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
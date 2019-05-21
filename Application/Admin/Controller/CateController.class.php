<?php
namespace Admin\Controller;
use Think\Controller;
class CateController extends CommonController {
    public function lst()
    {
        $cate=D('cate');
        $cates=$cate->catetree();
        $this->assign('cates',$cates);
        $this->display();
    }

    public function add()
    {
        $cate=D('cate');
        if (IS_POST){
            $data['parentid']=I('parentid');
            $data['name']=I('name');
            $data['type']=I('type');
            $data['keywords']=I('keywords');
            $data['des']=I('des');
            $data['pc']=I('pc');
            $data['class']=I('class');
            $data['content']=I('content');
            if($_FILES['pic']['tmp_name']!='')
            {
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->savePath  =      './Public/Uploads/'; // 设置附件上传目录
                $upload->rootPath='./';
                // 上传文件
                $info=$upload->uploadOne($_FILES['pic']);
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                }else{// 上传成功
                    $data['pic']=$info['savepath'].$info['savename'];
                }
            }

            if($cate->create($data))
            {
                if($cate->add())
                {
                    $this->success('新增栏目成功！',U('lst'));
                }else
                {
                    $this->error('新增栏目失败！');
                }

            }else
            {
                $this->error($cate->getError());
            }

            return;
        }

        $cates=$cate->catetree();
        $this->assign('cates',$cates);
        $this->display();
    }

    public function edit()
    {
        $cate=D('cate');
        if (IS_POST){
            $data['id']=I('id');
            $data['parentid']=I('parentid');
            $data['name']=I('name');
            $data['type']=I('type');
            $data['keywords']=I('keywords');
            $data['des']=I('des');
            $data['pc']=I('pc');
            $data['class']=I('class');
            $data['content']=I('content');
            if($_FILES['pic']['tmp_name']!='')
            {
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->savePath  =      './Public/Uploads/'; // 设置附件上传目录
                $upload->rootPath='./';
                // 上传文件
                $info=$upload->uploadOne($_FILES['pic']);
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                }else{// 上传成功
                    $data['pic']=$info['savepath'].$info['savename'];
                }
            }

            if($cate->create($data))
            {
                if($cate->save())
                {
                    $this->success('修改栏目成功！',U('lst'));
                }else
                {
                    $this->error('修改栏目失败！');
                }

            }else
            {
                $this->error($cate->getError());
            }
            return;
        }
        $cateid=I('id');
        $cateres=$cate->find($cateid);
        $cates=$cate->catetree();
        $this->assign('cates',$cates);
        $this->assign('cateres',$cateres);
        $this->display();
    }

    public function del()
    {
        $cate=D('cate');
        $id=I('id');
        if ($cate->delete($id))
        {
            $this->success('删除成功',U('lst'));
        }else{
            $this->error('删除失败',U('lst'));
        }
    }

    public function bdel(){
        $cate=D('cate');
        $ids=I('ids');
        $ids=implode(',',$ids);
        if ($ids)
        {
            if ($cate->delete($ids))
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

    public function sortcate()
    {
        $cate=D('cate');
        foreach ($_POST as $id=>$sort)
        {
            $cate->where("id=$id")->setField("sort",$sort);
        }
        $this->success('更新成功',U('lst'));
    }
}
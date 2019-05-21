<?php
namespace Admin\Controller;
use Think\Controller;
class ArticleController extends CommonController
{
    public function lst(){
        $article=D('ArticleView');
        $where=1;
        if ($kw=I('kw')){
            $where.=' AND title LIKE "%'.$kw.'%"';//全局文章查询语句
        }
        if ($search=I('search-sort')){
            $where.=' AND cateid='.$search;//限制栏目查询语句
        }
        $count=$article->where($where)->count();//获取记录数
        $Page=new \Think\Page($count,10);//实例化分页
        $show=$Page->show();//分页显示数据
        $list=$article->where($where)->order('id asc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);// 赋值分页输出
        $cate=D('cate');
        $cates=$cate->catetree();
        $this->assign('cates',$cates);
        $this->display();
    }

    public function add(){
        $article=D('article');
        if (IS_POST){
            $data['title']=I('title');
            $data['rizu']=I('rizu');
            $data['num']=I('num');
            $data['atype']=I('atype');
            $data['author']=I('author');
            $data['cateid']=I('cateid');
            $data['keywords']=I('keywords');
            $data['des']=I('des');
            $data['content']=I('content');
            $data['rem']=I('rem');
            $data['time']=time();
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
            if($article->create($data))
            {
                if($article->add())
                {
                    $this->success('新增文章成功！',U('lst'));
                }else
                {
                    $this->error('新增文章失败！');
                }

            }else
            {
                $this->error($article->getError());
            }

            return;
        }
        $cate=D('cate');
        $cates=$cate->catetree();
        $this->assign('cates',$cates);
        $this->display();
    }

    public function edit(){
        $article=D('article');
        if (IS_POST){
            $data['id']=I('id');
            $data['title']=I('title');
            $data['rizu']=I('rizu');
            $data['num']=I('num');
            $data['atype']=I('atype');
            $data['author']=I('author');
            $data['cateid']=I('cateid');
            $data['keywords']=I('keywords');
            $data['des']=I('des');
            $data['content']=I('content');
            $data['rem']=I('rem');
            $data['time']=time();
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

            if($article->create($data))
            {
                if($article->save())
                {
                    $this->success('修改文章成功！',U('lst'));
                }else
                {
                    $this->error('修改文章失败！');
                }

            }else
            {
                $this->error($article->getError());
            }

            return;
        }
        $cate=D('cate');
        $articleid=I('id');
        $articles=$article->find($articleid);
        $cates=$cate->catetree();
        $this->assign('cates',$cates);
        $this->assign('articles',$articles);
        $this->display();

    }

    public function del()
    {
        $article=D('article');
        $id=I('id');
        if ($article->delete($id))
        {
            $this->success('删除成功',U('lst'));
        }else{
            $this->error('删除失败',U('lst'));
        }
    }

    public function bdel(){
        $article=D('article');
        $ids=I('ids');
        $ids=implode(',',$ids);
        if ($ids)
        {
            if ($article->delete($ids))
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
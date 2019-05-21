<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $cateid=I('cateid'); //获取栏目信息,左侧导航使用
        $arid=I('arid');
        if ($arid){
            //如果通过文章arid访问，则找到文章所属的栏目id，然后只执行getcate（）
            $article=D('article');
            $articles=$article->find($arid);//当前文章的所属栏目
            $cateid=$articles['cateid'];
        }
        $this->getcate($cateid,$arid); //栏目id和文章id
        $this->nav();//获取pc端主导航栏目
        $this->link();//调用友情链接
        //获取pc端当前位置栏目
        if ($cateid){$this->selftop($cateid);}
        //获取当前位置连接
        if ($cateid){$this->getparent($cateid);}

    }

    public function getcate($cateid=0,$arid=0){
        //获取栏目信息执行函数
        //如果是通过cateid访问，则执行一下语句
        if ($cateid){
            $cate=D('cate');
            $cates=$cate->find($cateid);
            $soncates=$cate->where('parentid='.$cates['id'])->select();//找出顶级栏目的子栏目
            if ($cates['parentid']==0 && !$soncates){
                //如果没有子栏目，默认展示车辆首页
                $cates=$cate->where('id=68')->find();
                $this->assign('contro',true);//如果该栏目没有子栏目，
            }
            //顶级栏目
            if ($cates['class']==1){
                $son2=$cate->where('parentid='.$cates['id'])->select();//取出所有顶级栏目的二级栏目
                $this->assign('son2',$son2);
                $this->assign('son3',NULL);
                $this->assign('topname',$cates['name']);//获取所有的顶级栏目名称
            }
            //二级栏目
            if ($cates['class']==2){
                $topcates=$cate->where('id='.$cates['parentid'])->find();//获取当前分类的同级栏目
                $son2=$cate->where('parentid='.$topcates['id'])->select();//取出所有同级栏目的二级栏目
                $son3=$cate->where('parentid='.$cates['id'])->select();//找出三级
                $this->assign('son2',$son2);
                $this->assign('son3',$son3);
                $this->assign('topname',$topcates['name']);
            }
            //三级栏目
            if ($cates['class']==3){

                $upercates=$cate->where('id='.$cates['parentid'])->find();//三级栏目对应的二级栏目
                $topcates=$cate->where('id='.$upercates['parentid'])->find();//二级栏目对应的顶级栏目
                $son3=$cate->where('parentid='.$upercates['id'])->select();//三级栏目的同级栏目
                $son2=$cate->where('parentid='.$topcates['id'])->select();//二级栏目的同级栏目
                $this->assign('son2',$son2);
                $this->assign('son3',$son3);
                $this->assign('topname',$topcates['name']);
                $this->assign('son3pid',$upercates['id']);//三级栏目的二级栏目

            }
            return;
        }
    }

    //动态获取主导航url地址,pc端
    public function nav(){
        $cate=D('cate');
        //组合查询
        $where=array(
            'parentid'=>0,
            'pc'=>1
            );
        $navres=$cate->field('id,name,type')->order('sort asc')->where($where)->select();//获取pc端下的主导航栏目
        $this->assign('navres',$navres);
    }

    //当前位置使用
    public function selftop($cateid){
        $cate=D('cate');
        $cates=$cate->find($cateid);
        if ($cates['class']==1){
            $selftop=$cates['name'];
        }
        elseif ($cates['class']==2){
            $cates=$cate->where('id='.$cates['parentid'])->find();//查找二级栏目对应的顶级栏目
            $selftop=$cates['name'];
        }else{
            $cates=$cate->where('id='.$cates['parentid'])->find();//查找三级栏目对应的二级栏目
            $cates=$cate->where('id='.$cates['parentid'])->find();//查找二级栏目对应的顶级栏目 执行两此
            $selftop=$cates['name'];
        }

        $this->assign('selftop',$selftop);
    }

    //当前位置使用
    public function getparent($cateid){
        $res=array();
        $cate=D('cate');
        while ($cateid){
            $cates=$cate->find($cateid);//获取栏目信息
            $res[]=array(
                'id'=>$cates['id'],
                'name'=>$cates['name'],
                'type'=>$cates['type'],
            );
            $cateid=$cates['parentid'];//往上寻找上一级栏目，知道parentid为零
        }
        $pres=array_reverse($res);
        $this->assign('pres',$pres);//将数组倒序存放
        return;
    }

    //友情连接调用
    public function link(){
        $link=D('link');
        $linkres=$link->field('title,url')->select();
        $this->assign('linkres',$linkres);
    }
}
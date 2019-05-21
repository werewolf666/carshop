<?php
namespace Mobile\Controller;
use Think\Controller;
class CommonController extends Controller {
//    public function __construct()
//    {
//        parent::__construct();
//        $this->nav();//获取pc端主导航栏目
//    }
//
//    //动态获取主导航url地址,移动端
//    public function nav(){
//        $cate=D('cate');
//        //组合查询
//        $where=array(
//            'pc'=>0
//            );
//        $cateres=$cate->order('sort asc')->where($where)->select();//获取移动端下的主导航栏目
//        $this->assign('cateres',$cateres);
//    }

    public function __construct(){
        parent::__construct();
        $this->getcate();//获取相应的栏目
        $this->nav();//获取右侧栏目

    }

    public function nav(){
        $cate=D('cate');
        $cateres=$cate->where("pc=0")->order('id asc')->select();
        $this->assign('cateres',$cateres);
    }

    //单页栏目使用
    public function getcate(){
        $cateid=I('cateid');
        $arid=I('arid');
        if($arid){
            //通过文章id找cateid
            $article=D('article');
            $arts=$article->field('cateid')->find($arid);
            $cateid=$arts['cateid'];
        }
        if($cateid){
            //找到栏目的名称
            $cate=D('cate');
            $cates=$cate->field('name')->find($cateid);
            $catename=$cates['name'];
            $this->assign('catename',$catename);
        }
    }
}
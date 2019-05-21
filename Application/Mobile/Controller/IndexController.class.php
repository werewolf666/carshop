<?php
namespace Mobile\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
        $article=D('article');
        //获取主要车型展示
        $cares=$article->field('id,title,rizu,pic')->order('id desc')->where('cateid=93')->limit('4')->select();

        //获取留言
        $msg=D('message');
        $msgres=$msg->order('id desc')->where("type=0")->limit(5)->select();
        $this->assign('cares',$cares);
        $this->assign('msgres',$msgres);
        $this->display();
    }
}
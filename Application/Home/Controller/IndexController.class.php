<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
        $article=D('article');
        $mainres=$article->field('id,title,pic,rizu')->where('cateid=70')->order('id desc')->limit('3')->select();
        $carres=$article->field('id,title,pic,rizu')->where('cateid=68')->order('id desc')->select();
        $aboutres=$article->field('id,title,content')->where('cateid=67')->find();
        $arres=$article->field('id,title,content')->where('cateid=69')->limit('3')->select();
        $this->assign('mainres',$mainres);
        $this->assign('carres',$carres);
        $this->assign('aboutres',$aboutres);
        $this->assign('arres',$arres);
        $this->display();
    }
}
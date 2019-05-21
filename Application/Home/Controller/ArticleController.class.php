<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends CommonController {
    public function index(){
        $arid=I('arid');
        $article=D('article');
        $articles=$article->find($arid);
        $this->assign('articles',$articles); //文章内容展示

        //1 2 3 4 5 6 7
        //上一页
        $front=$article->where('id<'.$arid)->order('id desc')->limit('1')->find();
        if ($front){
            $furl=__CONTROLLER__.'/index/arid/'.$front['id'];//上一页url地址
        }else{
            $furl="javascript:void(0)";//没有下一页，点不动
        }

        //下一页
        $after=$article->where('id>'.$arid)->order('id asc')->limit('1')->find();
        if ($after){
            $aurl=__CONTROLLER__.'/index/arid/'.$after['id'];//上一页url地址
        }else{
            $aurl="javascript:void(0)";//没有下一页，点不动
        }
        $this->assign('furl',$furl);//上一页
        $this->assign('aurl',$aurl);//下一页
        $this->display();
    }

}
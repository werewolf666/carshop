<?php
namespace Mobile\Controller;
use Think\Controller;
class CarlistController extends CommonController {
    public function index(){

        $cateid=I('cateid');
        $article=D('article');
        $count=$article->where('cateid='.$cateid)->count();//获取总记录数
        $this->assign('count',$count);
        $this->display();
    }


    //获取数据分配给前台Ajax调用
    public function getlist($p,$cateid){
        $perpage=2;
        $offset=($p-1)*$perpage;
        $sql="SELECT * FROM cs_article WHERE cateid={$cateid} LIMIT {$offset},{$perpage}";
        $article=D('article');
        $data=$article->query($sql); //获取数据
        echo json_encode($data);//json格式
    }
}
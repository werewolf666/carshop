<?php
namespace Mobile\Controller;
use Think\Controller;
class ArlistController extends CommonController {
    public function index(){
        $this->display();
    }

    //获取数据分配给前台Ajax调用
    public function getlist($p,$cateid){
        $perpage=5;
        $offset=($p-1)*$perpage;
        $sql="SELECT * FROM cs_article WHERE cateid={$cateid} LIMIT {$offset},{$perpage}";
        $article=D('article');
        $data=$article->query($sql); //获取数据
        echo json_encode($data);//json格式
    }
}
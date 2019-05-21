<?php
namespace Mobile\Controller;
use Think\Controller;
class SearchController extends CommonController {
    public function index(){
        $article=D('article');
        $where=1;
        if ($kw=I('kws')){
            $where.=' AND title LIKE "%'.$kw.'%"';//全局文章查询语句
//            $where.=' AND cateid=93';//限制栏目查询语句
        }
        $count=$article->where($where)->count();//获取记录数
        $this->assign('count',$count);
        $this->display();
    }


    //获取数据分配给前台Ajax调用
    public function getlist($p,$kws){
        $perpage=5;
        $offset=($p-1)*$perpage;
//        $sql="SELECT * FROM cs_article WHERE title LIKE '%$kws%' AND cateid=93 LIMIT {$offset},{$perpage}";
        $sql="SELECT * FROM cs_article WHERE title LIKE '%$kws%' LIMIT {$offset},{$perpage}";
        $article=D('article');
        $data=$article->query($sql); //获取数据
        echo json_encode($data);//json格式
    }
}
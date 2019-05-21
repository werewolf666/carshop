<?php
namespace Admin\Model;
use Think\Model;
class ArticleModel extends Model
{
    //自动验证
    protected $_validate = array(
        array('title','require','文章标题不能为空',1),
        array('title','','文章标题不能重复',1,unique,1),
    );

    public function _before_delete($options)
    {

    }
}
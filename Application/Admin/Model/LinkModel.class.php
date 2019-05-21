<?php
namespace Admin\Model;
use Think\Model;
class LinkModel extends Model
{
    //自动验证
    protected $_validate = array(
        array('title','require','链接标题不能为空',1),
        array('title','','链接标题不能重复',1,unique,1),
        array('url','require','链接地址不能为空',1),
    );

    public function _before_delete($options)
    {

    }
}
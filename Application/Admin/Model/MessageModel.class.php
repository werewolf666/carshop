<?php
namespace Admin\Model;
use Think\Model;
class LinkModel extends Model
{
    //自动验证
    protected $_validate = array(
        array('content','require','回复内容不能为空',1),
    );

    public function _before_delete($options)
    {

    }
}
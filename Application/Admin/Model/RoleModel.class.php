<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model
{
    //自动验证
    protected $_validate = array(
        array('rolename','require','角色名称不能为空',1),
        array('rolename','','角色名称不能重复',1,unique),
    );

    public function _before_delete($options)
    {

    }
}
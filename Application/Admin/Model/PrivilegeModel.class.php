<?php
namespace Admin\Model;
use Think\Model;
class PrivilegeModel extends Model
{
    protected $_validate = array(
        array('pri_name','require','权限名称不得为空！',1),  // 都有时间都验证
        array('mname','require','模块名称不得为空！',1),
        array('cname','require','控制器名称不得为空！',1),
        array('aname','require','方法名称不得为空！',1),
        array('pri_name','','权限名称不得重复！',1,unique),
    );

    public function pritree($parentid=0)
    {

        $data=$this->select();
        return $this->resort($data,$parentid);
    }

    public function resort($data,$parentid=0,$level=0)
    {
        static $ret=array();
        foreach ($data as $v)
        {
            if ($v['parentid']==$parentid)
            {
                $v['level']=$level;
                $ret[]=$v;
                $this->resort($data,$v['id'],$level+1);
            }
        }
        return $ret;
    }

    public function getchildid($data,$parentid)
    {
        static $ret=array();
        foreach ($data as $k=>$v)
        {
            if ($v['parentid']==$parentid)
            {
                $ret[]=$v['id'];
                $this->getchildid($data,$v['id']);
            }
        }
        return $ret;
    }

    public function childid($cateid)
    {
        $data=$this->select();
        return $this->getchildid($data,$cateid);
    }

    public function _before_delete($options)
    {
        //批量删除
        if(is_array($options['where']['id'])){
            $arr=explode(',',$options['where']['id'][1]);
            $soncates=array();//存放所有子元素
            foreach ($arr as $k=>$v) {
                $soncates=array_merge($soncates,$this->childid($v));//将所有子栏目元素放在一个数组中
            }
            $soncates=array_unique($soncates);//去除重复的id
            $childrenids=implode(',',$soncates);
            if ($childrenids)
            {
                $this->execute("delete from `cs_privilege` where id in ($childrenids)");
            }
        }else
            {
            //单个删除 单独删除是，id是一个单独的id，主要用来传递批量删除 $options['where']['id'];
            $childrenids=$this->childid($options['where']['id']);
            $childrenids=implode(',',$childrenids);
            if ($childrenids)
            {
                $this->execute("delete from `cs_privilege` where id in ($childrenids)");
            }
        }
    }


}
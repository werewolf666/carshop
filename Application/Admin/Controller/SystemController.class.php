<?php
namespace Admin\Controller;
use Think\Controller;
class SystemController extends CommonController
{
   public function lst(){
       if (IS_POST){
           $file="./Application/Common/Conf/config.php";//导入配置文件
           $config=array_change_key_case($_POST,CASE_UPPER);//将传递过来的数据的键大写
           $new_config= array_merge(include $file,$config);
           $str="<?php\r\nreturn ".var_export($new_config,true).";";//创建文件头
           echo $str;
           if (file_put_contents($file,$str)){
               $this->success('修改成功',U('lst'));
           }else{
               $this->error('修改失败',U('lst'));
           }
           return;
       }
       $this->display();
   }
}
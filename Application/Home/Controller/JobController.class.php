<?php
namespace Home\Controller;
use Monolog\Handler\SyslogUdp\UdpSocket;
use Think\Controller;
class JobController extends CommonController {
    public function index(){
        if (IS_POST){
            $job=D('job');
            if ($job->create()){
                if ($job->add()){
                    $this->success('提交成功','',1);
                }else{
                    $this->error('提交失败，请联系管理员','',1);
                }
            }else
            {
                $this->error($job->getError());
            }
            return;
        }
        $arid=I('arid');
        $article=D('article');
        $articles=$article->field('title')->find($arid);
        $this->assign('title',$articles['title']);
        $this->display();
    }

    public function code(){
        $Verify = new \Think\Verify();
        $Verify->length   = 4;
        $Verify->entry();
    }

}
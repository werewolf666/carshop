<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加文章-后台管理</title>
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_PUC;?>/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_PUC;?>/css/main.css"/>
    <script type="text/javascript" src="<?php echo ADMIN_PUC;?>/js/libs/modernizr.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_PUC;?>/js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/carshop/Public/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/carshop/Public/ueditor/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/carshop/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
<div class="topbar-wrap white">
    <div class="topbar-inner clearfix">
        <div class="topbar-logo-wrap clearfix">
            <h1 class="topbar-logo none"><a href="index.html" class="navbar-brand">后台管理</a></h1>
            <ul class="navbar-list clearfix">
                <li><a class="on" href="index.html">首页</a></li>
                <li><a href="#" target="_blank">网站首页</a></li>
            </ul>
        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <li><a href="/carshop/index.php/Admin/Admin/edit/id/<?php echo session('id');?>">欢迎您，<?php echo session('rolename');?>:<?php echo session('username');?></a></li>
                <li><a href="/carshop/index.php/Admin/Admin/edit/id/<?php echo session('id');?>">修改密码</a></li>
                <li><a href="/carshop/index.php/Admin/Admin/logout">退出</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container clearfix">
    <div class="sidebar-wrap">
        <div class="sidebar-title">
            <h1>菜单</h1>
        </div>
        <div class="sidebar-content">
            <ul class="sidebar-list">
                <!--
                            <?php $menu=session('menu'); foreach ($menu as $k => $v): ?>
                                <li>
                                    <a href="<?php echo U($v['mname'].'/'.$v['cname'].'/'.$v['aname']);?>"><i class="icon-font">&#xe003;</i><?php echo $v['pri_name'];?></a>
                                    <ul class="sub-menu">
                                    <?php foreach ($v['sub'] as $k1 => $v1): ?>
                                        <li><a href="<?php echo U($v1['mname'].'/'.$v1['cname'].'/'.$v1['aname']);?>"><i class="icon-font">&#xe008;</i><?php echo $v1['pri_name'];?></a></li>
                                    <?php endforeach;?>
                                    </ul>
                                </li>
                            <?php endforeach;?>
                                -->

                    <li>
                        <a href="#"><i class="icon-font">&#xe003;</i>常用操作</a>
                        <ul class="sub-menu">
                            <li><a href="/carshop/index.php/Admin/Cate/lst"><i class="icon-font">&#xe008;</i>栏目管理</a></li>
                            <li><a href="/carshop/index.php/Admin/Article/lst"><i class="icon-font">&#xe005;</i>文章管理</a></li>
                            <li><a href="/carshop/index.php/Admin/Message/lst"><i class="icon-font">&#xe004;</i>留言管理</a></li>
                            <li><a href="/carshop/index.php/Admin/Job/lst"><i class="icon-font">&#xe012;</i>求职信息</a></li>
                            <li><a href="/carshop/index.php/Admin/Link/lst"><i class="icon-font">&#xe052;</i>友情链接</a></li>
                            <li><a href="design.html"><i class="icon-font">&#xe033;</i>广告管理</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="icon-font">&#xe018;</i>系统管理</a>
                        <ul class="sub-menu">
                            <li><a href="/carshop/index.php/Admin/System/lst"><i class="icon-font">&#xe017;</i>系统设置</a></li>
                            <li><a href="/carshop/index.php/Admin/Admin/lst"><i class="icon-font">&#xe006;</i>管理员管理</a></li>
                            <li><a href="/carshop/index.php/Admin/Privilege/lst"><i class="icon-font">&#xe037;</i>权限列表</a></li>
                            <li><a href="/carshop/index.php/Admin/Role/lst"><i class="icon-font">&#xe046;</i>角色列表</a></li>
                            <li><a href="system.html"><i class="icon-font">&#xe045;</i>数据还原</a></li>
                        </ul>
                    </li>

            </ul>
    </div>
</div>
    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/carshop/index.php/Admin/index/index">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/carshop/index.php/Admin/Article/lst">文章管理</a><span class="crumb-step">&gt;</span><span>新增文章</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="" method="post" id="myform" name="myform" enctype="multipart/form-data">
                    <table class="insert-tab" width="100%">
                        <tbody><tr>
                            <th width="120"><i class="require-red">*</i>所属栏目：</th>
                            <td>
                                <select name="cateid" id="catid" class="required">
                                    <?php if(is_array($cates)): $i = 0; $__LIST__ = $cates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php if($vo['parentid' != 0]): endif; echo str_repeat('-',$vo['level']*4); echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                            <tr>
                                <th><i class="require-red">*</i>文章标题：</th>
                                <td>
                                    <input class="common-text required" id="title" name="title" size="50" value="" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th>作者：</th>
                                <td>
                                    <input class="common-text required" id="author" name="author" size="50" value="" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th>关键词：</th>
                                <td><input class="common-text" name="keywords" size="50" value="" type="text"></td>
                            </tr>
                            <tr>
                                <th>描述：</th>
                                <td><textarea name="des" class="common-textarea" id="des" cols="30" style="width: 98%;" rows="5"></textarea></td>
                            </tr>
                            <tr>
                                <th>是否推荐：</th>
                                <td>
                                    <input class="common-text" name="rem" size="50" value="1" type="checkbox">推荐
                                </td>
                            </tr>
                            <tr>
                                <th>文章类型：</th>
                                <td>
                                    <div id="atype">
                                        <input class="common-text" name="atype" size="50" value="0" checked="checked" type="radio">列表
                                        <input class="common-text" name="atype" size="50" value="1" type="radio">车型
                                        <input class="common-text" name="atype" size="50" value="2" type="radio">招聘
                                    </div>
                                </td>
                            </tr>
                            <tr class="btype">
                                <th>列表附加选项：</th>
                                <td>
                                    <input class="common-text" name="" size="50" value="1" type="text">列表
                                </td>
                            </tr>
                            <tr class="btype">
                                <th>车型附加选项：</th>
                                <td>
                                    <input class="common-text" name="rizu" size="50" value="1" type="text">元/天（日租价格）
                                </td>
                            </tr>
                            <tr class="btype">
                                <th>招聘附加选项：</th>
                                <td>
                                    <input class="common-text" name="num" size="50" value="1" type="text">人（招聘人数）
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>缩略图：</th>
                                <td><input name="pic" id="" type="file"><!--<input type="submit" onclick="submitForm('/jscss/admin/design/upload')" value="上传图片"/>--></td>
                            </tr>
                            <tr>
                                <th>内容：</th>
                                <td><textarea name="content" class="common-textarea" id="content" cols="30" style="width: 98%;" rows="10"></textarea></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                                    <input class="btn btn6" onclick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                        </tbody></table>
                </form>
            </div>
        </div>

    </div>
    <!--/main-->
</div>
</body>
</html>
<script type="text/javascript">

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    UE.getEditor('content',{initialFrameWidth:1200,initialFrameHeight:400,});
    $('.btype').hide();
    $('.btype').eq(0).show();
    $('#atype input').click(function () {
        var i=$(this).index();//获取选中的索引值
        $(".btype").hide();
        $('.btype').eq(i).show();
    })
</script>
<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="telephone=no" name="format-detection" />
    <meta name="Author" content="0431" />
    <title>这里是您的网站名称1</title>
    <meta name="keywords" content="这里是您的网站名称4" />
    <meta name="description" content="这里是您的网站名称" />

    <link rel="stylesheet" type="text/css" href="/carshop/Public/mobile/style/subpage.css" />

    <script type="text/javascript" src="/carshop/Public/mobile/style/jquery.js"></script>




    <style>
        .head {
            background: #1a2a38;
        }
        .foot {
            background: #132330;
        }
        .nav {
            background: #0152b5 !important
        }
        .nav_color {
            background: #222;
        }
    </style>
    <script type="text/javascript" src="/carshop/Public/mobile/style/nav.js"></script>
    <script type="text/javascript" src="/carshop/Public/mobile/style/cart_icon.js"></script>

</head>

<body>

<ul class="nav">
  <li><a href="/carshop/index.php/mobile" title="首页"><span class="iconfont">&#xe607;</span>首页</a></li>
  <?php if(is_array($cateres)): $i = 0; $__LIST__ = $cateres;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="/carshop/index.php/Mobile/<?php if($vo['type'] == 1): ?>Arlist<?php elseif($vo['type'] == 2): ?>Page<?php elseif($vo['type'] == 3): ?>Message<?php elseif($vo['type'] == 4): ?>Zplist<?php elseif($vo['type'] == 5): ?>Carlist<?php elseif($vo['type'] == 6): ?>Ry<?php elseif($vo['type'] == 7): ?>Job<?php endif; ?>/index/cateid/<?php echo ($vo["id"]); ?>" title="关于我们"><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<div class="allpage">
    <div class="black-fixed iconfont">&#xe60f;</div>
    <div class="header">
    <div class="head">
               <a href="/carshop/index.php/mobile" title="首页" class="home-btn commonfont">&#xe608;</a>        <p class="top-title"><?php echo ($catename); ?></p>
        <div class="class-btn"><span class="commonfont">&#xe60a;</span></div>
        <div class="nav-btn commonfont">&#xe60b;</div>
    </div>
    <div class="type">
        <h1>搜索：</h1>
        <div class="common-pro-search">
            <form action="/carshop/index.php/Mobile/Search/index/" method="get">
                <input type="text" class="common-text" name="kws" placeholder="请输入搜索关键词"/>
                <input type="submit" class="common-submit commonfont" value="&#xe602;"/>
            </form>
        </div>
       
    </div>
</div>  
    <div class="content">
        <div class="about">
            <h1><?php echo ($arts["title"]); ?></h1>
            <?php if($arts["pic"] != ''): ?><center><img src="/carshop/<?php echo ($arts["pic"]); ?>" /></center><?php endif; ?>
            <span class="picContent">
                <p><?php echo htmlspecialchars_decode($arts['content']);?></p>
            </span>
            <a href="<?php echo ($furl); ?>" title="<?php echo ($fname); ?>" class="page">上一条：<?php echo ($fname); ?></a>
            <a href="<?php echo ($aurl); ?>" title="<?php echo ($aname); ?>" class="page">下一条：<?php echo ($aname); ?></a>
        </div>
    </div>
     <div class="footer">
    <div class="foot foot-relative" id="foot">
        <div class="foot-relative">
        <a href="#" title="地图">
                        <span class="commonfont">&#xe605;</span>
                        <h3>地图</h3>
                    </a><a href="tel:+86-0000-96877" title="电话">
                        <span class="commonfont">&#xe604;</span>
                        <h3>电话</h3>
                    </a><a href="sms:+86-0000-96877" title="短信">
                        <span class="commonfont">&#xe601;</span>
                        <h3>短信</h3>
                    </a><a href="#" title="分享">
                        <span class="commonfont">&#xe600;</span>
                        <h3>分享</h3>
                    </a>            
            
        </div>
    </div>
</div>
</div>
</body>
</html>
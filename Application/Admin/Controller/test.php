<?php echo session('menu');
foreach($menu as $k=>$v):

    ?>
    <li>
        <a href="#"><i class="icon-font">&#xe003;</i>常用操作</a>
        <ul class="sub-menu">
            <li><a href="__MODULE__/Cate/lst"><i class="icon-font">&#xe008;</i>栏目管理</a></li>
        </ul>
    </li>
    <li>
    <?php endforeach;?>
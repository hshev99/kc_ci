<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title></title>
    <link href="<?php echo $css?>css/style.css" type="text/css" rel="stylesheet" />
    <script src="<?php echo $css?>js/TouchSlide.1.1.js" type="text/javascript"></script>
    <script src="<?php echo $css?>js/jquery-1.11.2.min.js" type="text/javascript"></script>

</head>

<body class="back">
<div id="header">
    <div class="top">
        <div class="title">
            搜索结果
            <div class="return"><a href="index"><img src="<?php echo $css?>images/top.png"  />&nbsp;</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div class="searchBox">
        <form action="search" method="get">
        <div class="search1">
            <input type="image" src="<?php echo $css?>images/search1.jpg" class="searImg" />
            <input type="text" name="search_name" class="input1" placeholder="请输入要搜索的明星" />
        </div>
        </form>
    </div>
    <div class="content" style="float:left; width:100%;">
        <div class="lists" style="float:left; width:100%;">
            <div class="list5" style="background-color:#fff; margin-top:15px;">
                <ul>
                    <?php if (!empty($search_user)) foreach ($search_user as $val){?>
                    <li class="item">
                        <div class="BasicInfo">
                            <div class="hearImg">
                                <a href="SingerHome?worker_uid=<?php echo $val['uid']?>"><img src="<?php echo $val['img']?>" width="100%" /></a>
                                <div class="posion"><img src="<?php echo $css?>images/singer6.png" /></div>
                            </div>
                            <div class="right">
                                <div class="singerNmae">
                                    <a href="SingerHome?worker_uid=<?php echo $val['uid']?>"><span class="daimio"><?php echo $val['name']?></span>
                                        <span class="intro"><?php echo $val['nick']?></span></a>
                                    <div class="label">
                                        <?php if (!empty($val['style']))foreach ($val['style'] as $v){?>
                                        <em><?php echo $v['name']?></em>
                                        <?php }?>
                                    </div>
                                    <div class="order2">
                                        <a href="submit?worker_uid=<?php echo $val['uid']?>">预约</a>
                                    </div>
                                </div>
                                <div class="Price">
                                    <div class="money">￥<?php echo $val['price']?>万<span>/场</span> <s style="font-size:12px; color:#999;"><?php if (@$val['history_price'] >0) echo '￥'.$val['history_price'].'万/场';?></s></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php }else{?>
                        <div style="padding:10px; box-sizing:border-box;">
                        未搜索到您要找的明星
                        </div>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript" language=JavaScript charset="UTF-8">
    document.onkeydown=function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==13){ // enter 键
            //要做的事情
        }
    };
</script>

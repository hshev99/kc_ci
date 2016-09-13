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
            搜索
            <div class="return"><a href="javascript:history.back(-1);"><img src="<?php echo $css?>images/top.png" width="12" />&nbsp;</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div class="searchBox">
        <form action="search" method="get">
        <div class="search1">
            <input type="image" src="<?php echo $css?>images/search1.jpg" class="searImg" />
            <input type="text" name="search_name" class="input1" placeholder="请输入要搜索的明星" />
        </div></form>
        <div class="history">
            <div class="hisTit">
                <span class="hotSea">热门搜索</span>
            </div>
            <div class="hotUl">
                <ul>
                    <?php if (!empty($hot)) foreach ($hot as $val){?>
                    <li><a href="SingerHome?worker_uid=<?php echo $val['uid']?>"><?php echo $val['name']?></a></li>
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
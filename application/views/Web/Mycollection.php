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
            我的收藏
            <div class="return"><a href="javascript:history.back(-1);"><img src="<?php echo $css?>images/top.png" width="12" /> 返回</a></div>
            
        </div>
    </div>
</div>
<div id="content">
    <div class="list4">
        <ul>
            <?php if (!empty($user)) foreach ($user as $val){?>
            <li>
                <a href="#">
                    <div class="starPhoto"><img src="<?php echo $val['img']?>" width="100%" /></div>
                    <div class="starName1">
                        <?php echo $val['name']?><span><?php echo $val['nick']?></span>
                    </div>
                    <div class="price1">￥<?php echo $val['price']?><span>万/场</span> <s style="font-size:12px; color:#999">￥<?php echo $val['history_price']?>/场</s></div>
                </a>
            </li>
            <?php }?>
        </ul>
    </div>
</div>
</body>
</html>

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
            支付成功
            <div class="return"><a href="UserOrder"><img src="<?php echo $css?>images/top.png" width="12" /> 返回</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div class="payment">
        <div class="table">
            <span><img src="<?php echo $css?>images/payment1.jpg" width="100%" /></span>
            <div class="text1">
                <p>支付成功</p>正在等在歌手接单
            </div>
        </div>
        <div class="table1">
            <a href="index">返回首页</a>
            <a href="accept?order_sn=<?php echo $order_sn?>">查看订单</a>
        </div>
    </div>
</div>
</body>
</html>

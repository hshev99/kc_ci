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
            身份认证
            <?php if (isset($v) && $v ==11){?><div class="return"><a href="../singer"><img src="<?php echo $css?>images/top.png"/> 返回</a></div><?php }else{?>
                <div class="return"><a href="singer"><img src="<?php echo $css?>images/top.png"/> 返回</a></div>
            <?php }?>
            <?php if (isset($v) && $v ==11){?><span style="position:absolute; z-index:11; right:3%; height:50px; line-height:50px; top:0;"><a href="../index" style="color:#fff; font-size:14px;">跳过</a></span><?php }?>
        </div>
    </div>
</div>
<div id="content">
    <div class="apply">
        <span>申请认证：</span>
        <a href="http://www.51huole.cn/Web/singerAuthentication">歌手认证</a>
        <a href="http://www.51huole.cn/Web/enterprise">企业认证</a>
        <a href="http://www.51huole.cn/Web/broker">经纪人/经纪公司认证</a>
    </div>
    <div class="Explanation">
        认证说明：<br />
        <strong>歌手认证：</strong><br />
        可以上传自己的档期和价格让他人邀约，也可以邀约其他艺人。<br />
        <strong>企业认证：</strong><br />
        可以以企业的身份进行艺人邀约合作。<br />
        <strong>经纪人/经济公司认证：</strong><br />
        可以上传自己所签约的艺人的档期和价格让他人邀约，也可以邀约其他艺人。
    </div>
</div>
</body>
</html>

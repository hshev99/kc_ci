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
    <style>
        .list4 li{ margin-top:0; border:0;}
        @media screen and (max-device-width: 355px){
            .list4 li a .price1{ margin-top:15px;}}
    </style>
</head>

<body>
<div id="header">
    <div class="top">
        <div class="title">
            订单详情
            <div class="return"><a href="javascript :;" onClick="javascript :history.back(-1);"><img src="<?php echo $css?>images/top.png" width="12" /> 返回</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div class="number">订单编号：12345678901234</div>
    <div class="state">
        <span>当前状态：等待付款</span>
        <div class="date">剩余：15分00秒</div>
    </div>
    <div class="progressBar">
        <li>
            <div class="garden">
                <span></span>
            </div>
            <div class="promptText">等待付款</div>
        </li>
        <li>
            <div class="garden">
                <span></span>
            </div>
            <div class="promptText">等待接单</div>
        </li>
        <li>
            <div class="garden">
                <span></span>
            </div>
            <div class="promptText">等待歌手到场</div>
        </li>
        <li>
            <div class="garden">
                <span></span>
            </div>
            <div class="promptText">未完成</div>
        </li>
    </div>
    <div class="gray"></div>
    <div class="list4">
        <ul>
            <li>
                <a href="#">
                    <div class="starPhoto"><img src="<?php echo $css?>images/user1.jpg" width="100%" /></div>
                    <div class="starName1">
                        人声兄弟 <span>知名无伴奏组合</span>
                    </div>
                    <div class="price1">￥5万<span>/场</span> <s style="font-size:12px; color:#999">￥5万/场</s>
                        <div class="gold">预约金：<span style="color:#fa424c">￥3000</span></div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="gray"></div>
    <div class="form">
        <dl>
            <dd><span>活动名称</span>
                <div class="text2">呼伦贝尔草原音乐节</div>
            </dd>
            <dd><span>活动地点</span>
                <div class="text2">内蒙古  呼伦贝尔  呼伦贝尔大草原</div>
            </dd>
            <dd>
                <span>联系方式</span>
                <div class="text2">18245692580</div>
            </dd>
            <dd>
                <span>到场时间</span>
                <div class="text2">2016-08-08    15:20</div>
            </dd>
            <dd>
                <span>结束时间</span>
                <div class="text2">2016-08-09    14:00</div>
            </dd>
            <dd>
                <span>行程类别</span>
                <div class="text2">婚礼</div>
            </dd>
            <dd>
                <span>演出场景</span>
                <div class="text2">室外</div>
            </dd>
            <dd>
                <span>演出数量</span>
                <div class="text2">x1  首</div>
            </dd>
            <dd>
                <span>餐标</span>
                <div class="text2">500-1000元/日</div>
            </dd>
            <dd>
                <span>住宿</span>
                <div class="text2">五星级</div>
            </dd>
            <dd>
                <span>出行方式</span>
                <div class="text2">飞机/头等舱</div>
            </dd>
            <dd>
                <span>演出保险</span>
                <div class="text2">有</div>
            </dd>
            <dd>
                <span>备注</span>
                <div class="text2">无</div>
            </dd>
        </dl>
        <div class="gray"></div>
        <form action="" id="" enctype="multipart/form-data" method="post">
            <dl>
                <dd>
                    <span>支付方式</span>
                </dd>
                <dd style="padding:5px 0;">
                    <div class="payMethod">
                        <label>
                            <div class="leftInfo">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td width="50"><img src="<?php echo $css?>images/pay1.jpg" width="35" /></td>
                                        <td><p style="font-size:18px; color:#333333; line-height:30px;">支付宝</p><p style="color:#999999; font-size:14px;">推荐支付宝用户使用</p></td>
                                    </tr>
                                </table>
                            </div>
                            <input type="radio" name="name1" class="radioPay" checked="checked" />
                        </label>
                    </div>
                </dd>
                <dd style="padding:5px 0;">
                    <div class="payMethod">
                        <label>
                            <div class="leftInfo">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td width="50"><img src="<?php echo $css?>images/pay2.jpg" width="35" /></td>
                                        <td><p style="font-size:18px; color:#333333; line-height:30px;">微信支付</p><p style="color:#999999; font-size:14px;">推荐已安装微信客户端的用户使用</p></td>
                                    </tr>
                                </table>
                            </div>
                            <input type="radio" name="name1" class="radioPay" />
                        </label>
                    </div>
                </dd>
            </dl>
        </form>
    </div>
    <div class="gray"></div>
</div>
<div id="footer"></div>
<div class="bookingHref">
    <a href="comUserOrder">取消订单</a>
    <a href="Payment" class="on">继续支付</a>
</div>
</body>
</html>

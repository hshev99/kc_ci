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

<body  onload = "timer()">
<div id="header">
    <div class="top">
        <div class="title">
            订单详情
            <div class="return"><a href="UserOrder"><img src="<?php echo $css?>images/top.png" width="12" /> 返回</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div class="number">订单编号：<?php echo $l['order_sn']?></div>
    <div class="state">
        <span>当前状态：<?php echo $status['status']['now']?></span>

        <div class="date">
        	<span style="float:left; color:#fa424c"></span>
        	<div id="timer" style="float:left;"></div>
        </div>
        
    </div>
<script>
    var ts=<?php echo empty($status['status']['time']) ? -100 : $status['status']['time']?>;
    function timer(){setInterval("tts()",1000);}
function tts(){
if (ts <0){ return '';};
var tss= ts*1000;

var dd = parseInt(tss / 1000 / 60 / 60 / 24, 10);//计算剩余的天数
var hh = parseInt(tss / 1000 / 60 / 60 % 24, 10);//计算剩余的小时数
var mm = parseInt(tss / 1000 / 60 % 60, 10);//计算剩余的分钟数
var ss = parseInt(tss / 1000 % 60, 10);//计算剩余的秒数
document.getElementById("timer").innerHTML = "剩余："+ dd + "天" + hh + "时" + mm + "分" + ss + "秒";
ts--;
}
function checkTime(i)
{
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
</script>
    <div class="progressBar">
        <?php foreach ($status['status']['line'] as $val){?>
        <li class="<?php if($val['status'] =='T') echo 'on';?>">
            <div class="garden">
                <span></span>
            </div>
            <div class="promptText"><?php echo $val['name']?><br /><?php echo $val['time']?></div>
        </li>
        <?php }?>

    </div>
    <div class="gray"></div>
    <div class="list4">
        <ul>
            <li>
                <a href="#">
                    <div class="starPhoto"><img src="<?php echo $l['worker_img']?>" width="100%" /></div>
                    <div class="starName1">
                        <?php echo $l['worker_name']?> <span><?php echo $l['worker_nick']?></span>
                    </div>
                    <div class="price1">￥5万<span>/场</span> <s style="font-size:12px; color:#999">￥5万/场</s>
                        <div class="gold">预约金：<span style="color:#fa424c">￥<?php echo $l['pay_amount']?></span></div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="gray"></div>
    <div class="form">
        <dl>
            <dd><span>活动名称</span>
                <div class="text2"><?php echo $l['performace_name']?></div>
            </dd>
            <dd><span>活动地点</span>
                <div class="text2"><?php echo $l['place']?></div>
            </dd>
            <dd>
                <span>联系方式</span>
                <div class="text2"><?php echo $l['phone']?></div>
            </dd>
            <dd>
                <span>到场时间</span>
                <div class="text2"><?php echo $l['start_time']?></div>
            </dd>
            <dd>
                <span>结束时间</span>
                <div class="text2"><?php echo $l['end_time']?></div>
            </dd>
            <dd>
                <span>行程类别</span>
                <div class="text2"><?php echo $l['cate']?></div>
            </dd>
            <dd>
                <span>演出场景</span>
                <div class="text2"><?php echo $l['scen']?></div>
            </dd>
            <dd>
                <span>演出数量</span>
                <div class="text2"><?php echo $l['per_menber']?>首</div>
            </dd>
            <dd>
                <span>餐标</span>
                <div class="text2"><?php echo $l['meal']?>元/日</div>
            </dd>
            <dd>
                <span>住宿</span>
                <div class="text2"><?php echo $l['live']?></div>
            </dd>
            <dd>
                <span>出行方式</span>
                <div class="text2"><?php echo $l['travel']?></div>
            </dd>
            <dd>
                <span>演出保险</span>
                <div class="text2"><?php echo empty($l['insurance']) ? '无' :$l['insurance']?></div>
            </dd>
            <dd>
                <span>备注</span>
                <div class="text2"><?php echo $l['note']?></div>
            </dd>
        </dl>
    </div>
    <div class="gray"></div>
</div>

<?php if ($l['status'] ==2 && $agreed){?>
    <div id="footer"></div>
    <div class="bookingHref">
        <a onclick="$('#Form1').fadeIn()">拒绝</a>
        <a onclick="$('#Form3').fadeIn()" class="on">接受</a>
    </div>
<?php }?>
<?php if($l['status'] ==4 && $l['boss_uid']==$user_login['uid']){?>
    <div id="footer"></div>
    <div class="bookingHref">
        <a onclick="$('#Form4').fadeIn()" style="width:100%;" class="on">确认歌手到场</a>
    </div>
<?php }elseif($l['status'] == 6){?>
<?php }elseif($l['status'] ==1 && $pay){?>
<div class="form">
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
            <!--<dd style="padding:5px 0;">
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
            </dd>---->
        </dl>
    </form>
</div>
    <div id="footer"></div>
    <div class="gray"></div>
    <div class="bookingHref">
        <a onclick="$('#Form2').fadeIn()">取消订单</a>
        <a href="Payment?order_sn=<?php echo $l['order_sn']?>" class="on">支付</a>
    </div>
<?php }?>

<div class="prompt1" id="Form1" style="display:none;">
                <div class="proBox">
                    <form action="refused_order" method="post">
                    <h5 style="font-size:16px;">拒绝理由</h5><br />
                    <p>
                        <input type="hidden" name="order_sn" value="<?php echo $l['order_sn']?>">
                        <input type="hidden" name="worker_name" value="<?php echo $l['worker_name']?>">
                        <input type="hidden" name="phone" value="<?php echo $l['phone']?>">
                        <textarea name="reason" placeholder="(21字)" style="border:1px solid #ccc; width:100%; height:40px;"></textarea></p>
                    <div>
                        <a href="javascript:;" onclick="$('#Form1').fadeOut()">取消</a>
                        <a href="UserOrderMy"><input type="submit" value="确定" style="float:left; width:100%; text-align:center; border:0; background:none; height:30px; line-height:30px; font-size:14px;" /></a>
                    </div>
                    </form>
                </div>
</div>

<div class="prompt1" id="Form2" style="display:none;">
                <div class="proBox">
                    <h5>温馨提示</h5><br />
                    <p>您确定要取消订单么？</p>
                    <div>
                        <a href="javascript:;" onclick="$('#Form2').fadeOut()">取消</a>
                        <a href="UserOrderMy"><input type="submit" value="确定" style="float:left; width:100%; text-align:center; border:0; background:none; height:30px; line-height:30px; font-size:14px;" /></a>
                    </div>
                </div>
</div>

<div class="prompt1" id="Form3" style="display:none;">
                <div class="proBox">
                    <h5>温馨提示</h5><br />
                    <p>您已接受该订单，我方经纪人将在30分钟内与您联系，请保持电话畅通。</p>
                    <div>
                        <a style="float:left; width:100%;" href="agreed_order?order_sn=<?php echo $l['order_sn']?>"><input type="submit" value="确定" style="float:left; width:100%; text-align:center; border:0; background:none; height:30px; line-height:30px; font-size:14px;" /></a>
                    </div>
                </div>
</div>

<div class="prompt1" id="Form4" style="display:none;">
                <div class="proBox">
                    <h5>温馨提示</h5><br />
                    <p>确认后，定金将直接转到歌手账户，是否现在确认？</p>
                    <div>
                        <a href="Confirm_singer?order_sn=<?php echo $l['order_sn']?>" ><input type="submit" value="是" style="float:left; width:100%; text-align:center; border:0; background:none; height:30px; line-height:30px; font-size:14px;" /></a>
                        <a href="javascript:;" onclick="$('#Form4').fadeOut()">否</a>
                    </div>
                </div>
            </div>
</body>
</html>

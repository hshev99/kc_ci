<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html">
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
    <script src="<?php echo $css?>js/iscroll.js" type="text/javascript"></script>
    
    <style type="text/css" media="all">
        #wrapper {
            position:absolute; z-index:1;
            top:45px; bottom:48px; left:0;
            width:100%;
            overflow:auto;
        }

        #scroller {
            position:relative;
            /*	-webkit-touch-callout:none;*/
            -webkit-tap-highlight-color:rgba(0,0,0,0);

            float:left;
            width:100%;
            padding:0;
        }

        #scroller ul {
            position:relative;
            list-style:none;
            padding:0;
            margin:0;
            width:100%;
            text-align:left;
        }

        #scroller li { float:left;
            padding:10px 3%; box-sizing:border-box; border-bottom:1px solid #e4e4e4; margin-top:15px; border-top:1px solid #e4e4e4;
            background-color:#fff;
            font-size:14px;
        }
        #scroller li:first-child{ margin-top:0;}

        #scroller li > a {
            display:block;
        }

        /**
         *
         * 下拉样式 Pull down styles
         *
         */
        #pullDown, #pullUp {
            background:#fff;
            height:40px;
            line-height:40px;
            padding:5px 10px;
            border-bottom:1px solid #ccc;
            font-weight:bold;
            font-size:14px;
            color:#888;
        }
        #pullDown .pullDownIcon, #pullUp .pullUpIcon  {
            display:block; float:left;
            width:100%; height:40px;
            background:url(<?php echo $css?>images/pull-icon@2x.png) 0 0 no-repeat;
            -webkit-background-size:40px 80px; background-size:40px 80px;
            -webkit-transition-property:-webkit-transform;
            -webkit-transition-duration:250ms;
        }
        #pullDown .pullDownIcon {
            -webkit-transform:rotate(0deg) translateZ(0);
        }
        #pullUp .pullUpIcon  {
            -webkit-transform:rotate(-180deg) translateZ(0);
        }

        #pullDown.flip .pullDownIcon {
            -webkit-transform:rotate(-180deg) translateZ(0);
        }

        #pullUp.flip .pullUpIcon {
            -webkit-transform:rotate(0deg) translateZ(0);
        }

        #pullDown.loading .pullDownIcon, #pullUp.loading .pullUpIcon {
            background-position:0 100%;
            -webkit-transform:rotate(0deg) translateZ(0);
            -webkit-transition-duration:0ms;

            -webkit-animation-name:loading;
            -webkit-animation-duration:2s;
            -webkit-animation-iteration-count:infinite;
            -webkit-animation-timing-function:linear;
        }

        @-webkit-keyframes loading {
            from { -webkit-transform:rotate(0deg) translateZ(0); }
            to { -webkit-transform:rotate(360deg) translateZ(0); }
        }

    </style>
</head>

<body class="back">
<div id="content" style="margin-top:0">
    <div class="topPlay">
        <div class="tabBox">
            <div class="upBut">
                <ul>
                    <?php if ($user_login['type'] == 7 || $user_login['type'] == 5 || $user_login['type'] == 6){?>
                        <li class="on"><a href="UserOrder">我预约的</a></li>
                        <li><a href="UserMy">预约我的</a></li>
                    <?php }else{?>
                        <li style="width: 100%"><a href="UserOrder">我预约的</a></li>
                    <?php }?>

                </ul>
            </div>
            <div id="wrapper">
                <div id="scroller">
                    <!--<div id="pullDown"></div>-->
                    <ul id="thelist">

                        <?php if (!empty($orders))foreach ($orders as $val){?>
                        <li>
                            <div class="time"><span>交易时间：<?php echo $val['trading_time']?></span> <span><?php echo $val['status_name']?></span></div>
                            <div class="orderInfo">
                                <a href="accept?order_sn=<?php echo $val['order_sn']?>">
                                <div class="leftImg"><img src="<?php echo $val['worker_img']?>" width="100%" /></div>
                                <div class="rightTitle">
                                    <div class="tName">
                                        <span><?php echo $val['worker_name']?></span> <?php echo $val['worker_nick']?>
                                    </div>
                                    <div class="timeInfo">
                                        到场时间：<?php echo $val['start_time']?><br />
                                        结束时间：<?php echo $val['end_time']?>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="oredrBut">
                                <span>预约金：<em>￥3000</em></span>

                                <?php switch ($val['status']){
                                //待付款
                                case 1:?>
                                    <a href="accept?order_sn=<?php echo $val['order_sn']?>" >付款</a>
                                <a onclick="$('#Form1').fadeIn()"  class="del">取消订单</a>

                                <?php break;?>

                                    <?php case 2:?>
                                    <?php break;?>


                                    <?php case 3:?>
                                    
                                    <?php break;?>

                                    <?php case 4:?>
                                    <a onclick="$('#Form4').fadeIn()" class="del">确认到场</a>
                                    <?php break;?>

                                    <?php case 5:?>
                                    <?php break;?>

                                    <?php case 6:?>
                                    
                                    <?php break;?>


                                <?php }?>
                                <div class="prompt1" id="Form1" style="display:none;">
                                    <div class="proBox">
                                        <h5>温馨提示</h5><br />
                                        <p>您确定要取消订单么？</p>
                                        <div>
                                            <a href="javascript:;" onclick="$('#Form1').fadeOut()" style="width:50%; border:0; margin:0;">取消</a>
                                            <a href="cancel_order?order_sn=<?php echo $val['order_sn']?>" style="width:50%; border:0; border-left:1px solid #ccc; box-sizing:border-box; border-radius:0;margin:0; "><input type="submit"  value="确定" style="float:left; width:100%; text-align:center; border:0; background:none; height:30px; line-height:30px; font-size:14px;" /></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>

                        <?php }?>
                        <div class="grag1"></div>
                    </ul>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<div class="prompt1" id="Form4" style="display:none;">
                <div class="proBox">
                    <h5>温馨提示</h5><br />
                    <p>确认后，定金将直接转到歌手账户，是否现在确认？</p>
                    <div>
                        <a href="Confirm_singer?order_sn=<?php echo $val['order_sn']?>"><input type="submit" value="是" style="float:left; width:100%; text-align:center; border:0; background:none; height:30px; line-height:30px; font-size:14px;" /></a>
                        <a href="javascript:;" onclick="$('#Form4').fadeOut()">否</a>
                    </div>
                </div>
            </div>
<?php include "foot.ctp";?>

</body>
</html>

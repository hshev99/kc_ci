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
<div id="content" style="margin-top:0">
    <div class="topPlay">
        <div class="tabBox">
            <div class="upBut">
                <ul>
                    <?php if ($user_login['type'] == 7 || $user_login['type'] == 5 || $user_login['type'] == 6){?>
                        <li><a href="UserOrder">我预约的</a></li>
                        <li class="on"><a href="UserMy">预约我的</a></li>
                    <?php }else{?>
                        <li style="width: 100%"><a href="UserOrder">我预约的</a></li>
                    <?php }?>
                  <!--   <li><a href="UserOrder">我预约的</a></li>
                    <li class="on"><a href="UserOrderMy">预约我的</a></li> -->
                </ul>
            </div>
            <div id="leftTabBox" class="list3">
                <div class="hd">
                    <ul>
                        <li><a>待处理</a></li>
                        <li><a>进行中</a></li>
                        <li><a>已完成</a></li>
                        <li><a>已关闭</a></li>
                    </ul>
                </div>
                <div class="bd" id="tabBox1-bd">
                    <div class="con">
                        <ul>
                            <?php if (!empty($waiting))foreach ($waiting as $val){?>
                            <li>
                                <div class="time">
                                    <span>交易时间：<?php echo $val['trading_time']?></span>
                                    <span class="see">待处理</span>
                                </div>
                                <div class="orderInfo treatment">
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
                            </li>
                            <?php }?>
                            <div class="grag1"></div>
                        </ul>
                    </div>
                    <div class="con">
                        <ul>
                            <?php if (!empty($ongoing))foreach ($ongoing as $val){?>
                                <li>
                                    <div class="time">
                                        <span>交易时间：<?php echo $val['trading_time']?></span>
                                        <span class="see">进行中</span>
                                    </div>
                                    <div class="orderInfo treatment">
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
                                </li>
                            <?php }?>
                            <div class="grag1"></div>
                        </ul>
                    </div>
                    <div class="con">
                        <ul>
                            <?php if (!empty($complete))foreach ($complete as $val){?>
                                <li>
                                    <div class="time">
                                        <span>完成时间：<?php echo $val['trading_time']?></span>
                                        <span class="see">已完成</span>
                                    </div>
                                    <div class="orderInfo treatment">
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
                                </li>
                            <?php }?>
                            <div class="grag1"></div>
                        </ul>
                    </div>

                    <div class="con">
                        <ul>
                            <?php if (!empty($shutDown))foreach ($shutDown as $val){?>
                            <li>
                                <div class="time">
                                    <span>关闭时间：<?php echo $val['trading_time']?></span>
                                    <span>交易关闭</span>
                                </div>
                                <div class="orderInfo treatment">
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
                            </li>
                            <?php }?>
                            <div class="grag1"></div>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            TouchSlide( { slideCell:"#leftTabBox",

                endFun:function(i){ //高度自适应
                    var bd = document.getElementById("tabBox1-bd");
                    bd.parentNode.style.height = bd.children[i].children[0].offsetHeight+"px";
                    if(i>0)bd.parentNode.style.transition="200ms";//添加动画效果
                }

            } );</script>
    </div>
</div>
<?php include "foot.ctp";?>
</body>
</html>

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
    <script src="<?php echo $css?>js/PCASClass.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo $css?>js/dateRange.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $css?>css/dateRange.css"/>

</head>

<body>
<div id="header">
    <div class="top">
        <div class="title">
            订单提交
            <div class="return"><a href="javascript:history.back(-1);"><img src="<?php echo $css?>images/top.png" width="12" /> 返回</a></div>
        </div>
    </div>
</div>
<div id="content">
    <div class="info">
        <div class="BasicInfo">
            <div class="hearImg">
                <img src="<?php echo $worker['img']?>" width="100%" />
                <div class="posion"><img src="<?php echo $css?>images/singer6.png" /></div>
            </div>
            <div class="right" style="padding:0">
                <div class="singerNmae">
                    <span style="font-size:16px;"><?php echo $worker['name']?></span>
                    <span style="font-size:12px;"><?php echo $worker['nick']?></span>
                    <div class="label">
                        <?php foreach ($worker['style'] as $val){?><em><?php echo $val['name']?></em><?php }?>
                    </div>
                </div>
                <div class="Price">
                    <div class="money">￥<?php echo $worker['price']?>万<span>/场</span> </div>
                    <div class="company"><?php echo $worker['company']?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="gray"></div>
    <div class="form">
        <form action="" id="" enctype="multipart/form-data" method="post" onSubmit="return activity();">
            <dl>
                <dd><span>活动名称</span>
                    <input type="text" name="performace_name" id="active" placeholder="请输入活动名称" />
                    <input type="hidden" name="worker_uid" value="<?php echo $worker['uid']?>" />
                    <input type="hidden" name="worker_name" value="<?php echo $worker['name']?>" />
                    <input type="hidden" name="worker_nick" value="<?php echo $worker['nick']?>" />
                    <input type="hidden" name="worker_img" value="<?php echo $worker['img']?>" />
                    <input type="hidden" name="pay_amount" value="<?php echo $worker['about_price']?>" />
                </dd>
                <dd><span>活动地点</span>
                    <div style="float:right;">
                        <select style="width:33.333%" name="place_1"></select>
                        <select style="width:33.333%" name="place_2"></select>
                        <select style="width:33.333%" name="place_3"></select>
                    </div>
                </dd>
                <dd>
                    <span>联系方式</span>
                    <input type="text" name="phone" id="phone" placeholder="请输入联系方式" />
                </dd>
                <dd style="padding:5px 3% 5px 0;"><span>活动时间</span>
                	<div class="ta_date" id="div_date1" style="float:left; width:100%; height:50px;">
                        <input type="hidden" name="start_time" id="start_time" value="" />
                        <input type="hidden" name="end_time" id="end_time" value="" />
                        <span class="date_title" id="date1" style="line-height:25px; position:static; margin-top:0; height:auto; float:right;"></span>
                    </div>
                </dd>
<script type="text/javascript">
function getNowFormatDate() {
        var date = new Date();
        var seperator1 = "-";
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var strDate = date.getDate();
        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }
        var currentdate = year + seperator1 + month + seperator1 + strDate;
        return currentdate;
    }
//			var STATS_START_TIME = '4329148800';
	var dateRange1 = new pickerDateRange('date1', {
		aRecent90Days : 'aRecent90Days', //最近90天
//				isTodayValid : true,
		startDate: getNowFormatDate(),
		endDate: getNowFormatDate(),
		needCompare : false,
		defaultText : ' 结束时间：',
		autoSubmit : false,
		inputTrigger : 'input_trigger1',
		theme : 'ta',
        startDateId : 'start_time',
        endDateId : 'end_time',
		//disCertainDates : {'2016':{'7':[25,26],"8":[4,5],"9":[5,8]},'2017':{'1':[7,8]}}
        disCertainDates: <?php echo $order_date?>,
        see:1
        
	});
</script>
                <dd>
                    <span>行程类别</span>
                    <select dir="rtl" name="cate">
                        <option selected="true"  value="婚礼" style="color:#999">婚礼</option>
                        <option selected="true"  value="婚礼" style="color:#999">商业演出</option>
                        <option selected="true"  value="婚礼" style="color:#999">演唱会</option>
                        <option selected="true"  value="婚礼" style="color:#999">婚礼庆典</option>
                        <option selected="true"  value="婚礼" style="color:#999">走秀剪彩</option>
                        <option selected="true"  value="婚礼" style="color:#999">广告代言</option>
                        <option selected="true"  value="婚礼" style="color:#999">嘉宾出席</option>
                        <option selected="true"  value="婚礼" style="color:#999">音乐节</option>
                        <option selected="true"  value="婚礼" style="color:#999">酒吧夜店</option>
                        <option selected="true"  value="婚礼" style="color:#999">其他</option>
                    </select>
                </dd>
                <dd>
                    <span>演出场景</span>
                    <div class="Scenes">
                        <input type="radio" name="scen" value="室内" class="radioPay1" data-labelauty="室内" checked="checked" />
                        <input type="radio" name="scen" value="室外" class="radioPay1 radioPayOut" data-labelauty="室外" />
                    </div>
                </dd>
                <dd>
                    <span>演出数量</span>
                    <select dir="rtl" name="per_menber">
                        <option selected="true"  value="1首">x1  首</option>
                        <option  value="1首">x2  首</option>
                        <option  value="1首">x3  首</option>
                        <option  value="1首">x4  首</option>
                        <option  value="1首">x5  首</option>
                        <option  value="1首">x6  首</option>
                        <option  value="1首">x7  首</option>
                        <option  value="1首">x8  首</option>
                        <option  value="1首">x9  首</option> 
                        <option  value="1首">x10  首</option> 
                        <option  value="1首">x11  首</option>
                        <option  value="1首">x12  首</option>
                        <option  value="1首">x13  首</option>
                        <option  value="1首">x14  首</option>
                        <option  value="1首">x15  首</option>
                        <option  value="1首">x16  首</option>
                        <option  value="1首">x17  首</option>
                        <option  value="1首">x18  首</option>
                        <option  value="1首">x19  首</option>
                        <option  value="1首">x20  首</option>
                        <option  value="1首">x21  首</option>
                        <option  value="1首">x22  首</option>
                        <option  value="1首">x23  首</option>
                        <option  value="1首">x24  首</option>
                        <option  value="1首">x25  首</option>
                        <option  value="1首">x26  首</option>
                        <option  value="1首">x27  首</option> 
                        <option  value="1首">x28  首</option> 
                        <option  value="1首">x29  首</option> 
                        <option  value="1首">x30  首</option>
                        <option  value="1首">x30+  首</option>                     
                  </select>
                </dd>
                <dd>
                    <span>餐标</span>
                    <select dir="rtl" name="meal">
                    	<option selected="true" value="500-元/日">无</option>
                        <option selected="true" value="500-元/日">500元以下/日</option>
                        <option selected="true" value="500-1000元/日">500-1000元/日</option>
                        <option selected="true" value="1000-1500元/日">1000-1500元/日</option>
                        <option selected="true" value="1500-2000元/日">1500-2000元/日</option>
                        <option selected="true" value="2000-2500元/日">2000-2500元/日</option>
                        <option selected="true" value="2500以上/日">2500元以上/日</option>
                    </select>
                </dd>
                <dd>
                    <span>住宿</span>
                    <select dir="rtl" name="live">
                        <option selected="true" value="五星级">五星级</option>
                        <option value="五星级">四星级</option>
                        <option value="五星级">三星级</option>
                        <option value="五星级">二星级</option>
                        <option value="五星以上">五星以上</option>
                    </select>
                </dd>
                <dd>
                    <span>出行方式</span>
                    <select dir="rtl" name="travel">
                        <option selected="true" value="飞机/头等舱">飞机/头等舱</option>
                        <option value="飞机/头等舱">飞机/经济舱</option>
                        <option value="飞机/头等舱">飞机/商务舱</option>
                        <option value="飞机/头等舱">汽车</option>
                        <option value="飞机/头等舱">火车/硬座</option>
                        <option value="飞机/头等舱">火车/硬卧</option>
                        <option value="飞机/头等舱">火车/软卧</option>
                        <option value="飞机/头等舱">高铁/一等座</option>
                        <option value="飞机/头等舱">高铁/二等座</option>
                        <option value="飞机/头等舱">高铁/商务座</option>
                        <option value="飞机/头等舱">轮船/一等舱</option>
                        <option value="飞机/头等舱">轮船/二等舱</option>
                        <option value="飞机/头等舱">轮船/商务舱</option>
                    </select>
                </dd>
                <dd>
                    <span>演出保险</span>
                    <input class='tgl tgl-ios' value="有保险" name="insurance" id='cb2' type='checkbox'>
                    <label class='tgl-btn' for='cb2'></label>
                </dd>
                <dd>
                    <span style="top:0; margin-top:0;">备注</span>
                    <textarea name="note" placeholder="说明文字在30字一下"></textarea>
                </dd>
            </dl>
            <div class="gray"></div>
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
                                        <td><p style="font-size:16px; color:#333333; line-height:25px;">支付宝</p><p style="color:#999999; font-size:12px;">推荐支付宝用户使用</p></td>
                                    </tr>
                                </table>
                            </div>
                            <input type="radio" name="pay_way" value="1" class="radioPay" checked="checked" style="margin:13px 10px" />
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
                                        <td><p style="font-size:16px; color:#333333; line-height:25px;">微信支付</p><p style="color:#999999; font-size:12px;">推荐已安装微信客户端的用户使用</p></td>
                                    </tr>
                                </table>
                            </div>
                            <input type="radio" name="pay_way" value="2" class="radioPay" style="margin:13px 10px" />
                        </label>
                    </div>
                </dd>-->
            </dl>
            <div class="gray"></div>
            <div id="footer"></div>
            <div class="booking">
                <span>预约金：<font>￥<?php echo $worker['about_price']?></font></span>
                <a onclick="activity()">立即支付</a>
            </div>
            <div class="prompt1" id="Form1" style="display:none;">
                <div class="proBox">
                    <h5>温馨提示</h5><br />
                    <p>支付成功后，歌手接单之前，无法取消订单，继续支付？</p>
                    <div>
                        <a href="javascript:;" onclick="$('#Form1').fadeOut()">取消</a>
                        <a><input type="submit" value="确定" style="float:left; width:100%; text-align:center; border:0; background:none; height:30px; line-height:30px; font-size:14px;" /></a>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>

</body>
</html>
<script>
                	function activity(){
						var userName = document.getElementById('active').value;
							if(userName == ''){
								alert('请填写活动名称');
								return false;
								}
							var userPhone = document.getElementById('phone').value;
							 if(!(/^1[3|4|5|7|8]\d{9}$/.test(userPhone))){
								 alert('请填写正确的联系方式');
								 return false;
								 }
							$('#Form1').fadeIn();
						}
						
</script>
<script language="javascript" >
    new PCAS("place_1","place_2","place_3","北京市","北京市","朝阳区");
</script>

$("#fileuploader0").click(function(){
    document.getElementsByClassName("img1")[0].src = "/static/pc/images/loading.gif";
});
$(document).ready(function()
{
    $("#fileuploader0").uploadFile({
        url:"../img/do_upload?uid=1",                 //文件上传url
        fileName:"userfile",
        showDone: false,                     //是否显示"Done"(完成)按钮
        showDelete: false,
        onSuccess: function(files,data,xhr,pd)
        {
            //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
            if(data){
                var strJSON=data;
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
                document.getElementsByClassName("img1")[0].src = obj.results.img;
                document.getElementById('fileuploader0_input').value = obj.results.img;
            }
        }
    })
});

$("#fileuploader1").click(function(){
    document.getElementsByClassName("img1")[1].src = "/static/pc/images/loading.gif";
});
$(document).ready(function()
{
    $("#fileuploader1").uploadFile({
        url:"../img/do_upload?uid=1",                 //文件上传url
        fileName:"userfile",
        showDone: false,                     //是否显示"Done"(完成)按钮
        showDelete: false,
        onSuccess: function(files,data,xhr,pd)
        {
            //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
            if(data){
                var strJSON=data;
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
                document.getElementsByClassName("img1")[1].src = obj.results.img;
                document.getElementById('fileuploader1_input').value = obj.results.img;
            }
        }
    })
});

$("#fileuploader2").click(function(){
    document.getElementsByClassName("img1")[2].src = "/static/pc/images/loading.gif";
});
$(document).ready(function()
{
    $("#fileuploader2").uploadFile({
        url:"../img/do_upload?uid=1",                 //文件上传url
        fileName:"userfile",
        showDone: false,                     //是否显示"Done"(完成)按钮
        showDelete: false,
        onSuccess: function(files,data,xhr,pd)
        {
            //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
            if(data){
                var strJSON=data;
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
                document.getElementsByClassName("img1")[2].src = obj.results.img;
                document.getElementById('fileuploader2_input').value = obj.results.img;
            }
        }
    })
});

$("#fileuploader3").click(function(){
    document.getElementsByClassName("img1")[3].src = "/static/pc/images/loading.gif";
});
$(document).ready(function()
{
    $("#fileuploader3").uploadFile({
        url:"../img/do_upload?uid=1",                 //文件上传url
        fileName:"userfile",
        showDone: false,                     //是否显示"Done"(完成)按钮
        showDelete: false,
        onSuccess: function(files,data,xhr,pd)
        {
            //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
            if(data){
                var strJSON=data;
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
                document.getElementsByClassName("img1")[3].src = obj.results.img;
                document.getElementById('fileuploader3_input').value = obj.results.img;
            }
        }
    })
});

$("#fileuploader4").click(function(){
    document.getElementsByClassName("img1")[4].src = "/static/pc/images/loading.gif";
});
$(document).ready(function()
{
    $("#fileuploader4").uploadFile({
        url:"../img/do_upload?uid=1",                 //文件上传url
        fileName:"userfile",

        showDone: false,                     //是否显示"Done"(完成)按钮
        showDelete: false,
        onSuccess: function(files,data,xhr,pd)
        {
            //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
            if(data){
                var strJSON=data;
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
                document.getElementsByClassName("img1")[4].src = obj.results.img;
                document.getElementById('fileuploader4_input').value = obj.results.img;
            }
        }
    })
});

$("#fileuploader6").click(function(){
    document.getElementsByClassName("img1")[6].src = "/static/pc/images/loading.gif";
});
$(document).ready(function()
{
    $("#fileuploader6").uploadFile({
        url:"../img/do_upload?uid=1",                 //文件上传url
        fileName:"userfile",
        showDone: false,                     //是否显示"Done"(完成)按钮
        showDelete: false,
        onSuccess: function(files,data,xhr,pd)
        {
            //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
            if(data){
                var strJSON=data;
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
                document.getElementsByClassName("img1")[6].src = obj.results.img;
                document.getElementById('fileuploader6_input').value = obj.results.img;
            }
        }
    })
});

$("#fileuploader7").click(function(){
    document.getElementsByClassName("img1")[7].src = "/static/pc/images/loading.gif";
});
$(document).ready(function()
{
    $("#fileuploader7").uploadFile({
        url:"../img/do_upload?uid=1",                 //文件上传url
        fileName:"userfile",
        showDone: false,                     //是否显示"Done"(完成)按钮
        showDelete: false,
        onSuccess: function(files,data,xhr,pd)
        {
            //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
            if(data){
                var strJSON=data;
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
                document.getElementsByClassName("img1")[7].src = obj.results.img;
                document.getElementById('fileuploader7_input').value = obj.results.img;
            }
        }
    })
});

$("#fileuploader5").click(function(){
    document.getElementsByClassName("img1")[5].src = "/static/pc/images/loading.gif";
});
$(document).ready(function()
{
    $("#fileuploader5").uploadFile({
        url:"../img/do_upload?uid=1",                 //文件上传url
        fileName:"userfile",
        showDone: false,                     //是否显示"Done"(完成)按钮
        showDelete: false,
        onSuccess: function(files,data,xhr,pd)
        {
            //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
            if(data){
                var strJSON=data;
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
                document.getElementsByClassName("img1")[5].src = obj.results.img;
                document.getElementById('fileuploader5_input').value = obj.results.img;
            }
        }
    })
});

$("#fileuploader8").click(function(){
    document.getElementsByClassName("img1")[8].src = "/static/pc/images/loading.gif";
});
$(document).ready(function()
{
    $("#fileuploader8").uploadFile({
        url:"../img/do_upload?uid=1",                 //文件上传url
        fileName:"userfile",
        showDone: false,                     //是否显示"Done"(完成)按钮
        showDelete: false,
        onSuccess: function(files,data,xhr,pd)
        {
            //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
            if(data){
                var strJSON=data;
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
                document.getElementsByClassName("img1")[8].src = obj.results.img;
                document.getElementById('fileuploader8_input').value = obj.results.img;
            }
        }
    })
});

$("#fileuploader9").click(function(){
    document.getElementsByClassName("img1")[9].src = "/static/pc/images/loading.gif";
});
$(document).ready(function()
{
    $("#fileuploader9").uploadFile({
        url:"../img/do_upload?uid=1",                 //文件上传url
        fileName:"userfile",
        showDone: false,                     //是否显示"Done"(完成)按钮
        showDelete: false,
        onSuccess: function(files,data,xhr,pd)
        {
            //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
            if(data){
                var strJSON=data;
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
                document.getElementsByClassName("img1")[9].src = obj.results.img;
                document.getElementById('fileuploader9_input').value = obj.results.img;
            }
        }
    })
});

$("#fileuploader10").click(function(){
    document.getElementsByClassName("img1")[10].src = "/static/pc/images/loading.gif";
});
$(document).ready(function()
{
    $("#fileuploader10").uploadFile({
        url:"../img/do_upload?uid=1",                 //文件上传url
        fileName:"userfile",
        showDone: false,                     //是否显示"Done"(完成)按钮
        showDelete: false,
        onSuccess: function(files,data,xhr,pd)
        {
            //上传成功后的回调方法。本例中是将返回的文件名保到一个hidden类开的input中，以便后期数据处理
            if(data){
                var strJSON=data;
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
                document.getElementsByClassName("img1")[10].src = obj.results.img;
                document.getElementById('fileuploader10_input').value = obj.results.img;
            }
        }
    })
});
$(function(){
    $('#sing_sub').click(function(){
        if($('#name_sing').val() == ''){
            alert('请填写姓名');
            document.getElementById('name_sing').focus();
            return false;
        }
        var myNum = /^((1[3-8]{1})+\d{9})$/;
        if($('#phone_sing').val() == ''){
            alert('请填写联系方式');
            document.getElementById('phone_sing').focus();
            return false;
        }else if(!myNum.test($('#phone_sing').val())){
            alert('联系方式格式不正确');
            document.getElementById('phone_sing').focus();
            return false;
        }
        //身份证/护照
        //var card = new RegExp(/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/);
        if($('#id_sing').val() == ''){
            alert('请填写证件号码');
            document.getElementById('id_sing').focus();
            return false;
        }/*else if(!card.test($('#id_sing').val())){
            alert('请填写正确的证件号码');
            document.getElementById('id_sing').focus();
            return false;
        }*/
        if($('#pic_sing').val() == ''){
            alert('请填写出场费');
            document.getElementById('pic_sing').focus();
            return false;
        }
        if($('#fileuploader0_input').val()==''){
            alert('请上传证件图片');
            return false;
        }
        if($('#fileuploader1_input').val()==''){
            alert('请上传证件图片');
            return false;
        }
    });
    $('#enter_sub').click(function(){
        if($('#name_enter').val() == ''){
            alert('请输入企业名称');
            document.getElementById('name_enter').focus();
            return false;
        }
        if($('#phone_enter').val() ==''){
            alert('请输入联系方式');
            document.getElementById('phone_enter').focus();
            return false;
        }else if(!myNum.test($('#phone_enter').val())){
            alert('联系方式格式不正确');
            document.getElementById('phone_enter').focus();
            return false;
        }
        if($('#license_enter')==''){
            alert('请输入营业执照注册号');
            document.getElementById('license_enter').focus();
            return false;
        }
        if($('#app_enter').val()==''){
            alert('请输入联系地址');
            document.getElementById('app_enter').focus();
            return false;
        }
        if($('#per_name_enter').val()==''){
            alert('请输入法人姓名');
            document.getElementById('per_name_enter').focus();
            return false;
        }
        var myNum = /^((1[3-8]{1})+\d{9})$/;
        if($('#per_phone_enter').val() == ''){
            alert('请填写联系方式');
            document.getElementById('per_phone_enter').focus();
            return false;
        }else if(!myNum.test($('#per_phone_enter').val())){
            alert('联系方式格式不正确');
            document.getElementById('per_phone_enter').focus();
            return false;
        }
        if($('#per_id_enter').val()==''){
            alert('请输入证件号码');
            document.getElementById('per_id_enter').focus();
            return false;
        }
        if($('#fileuploader2_input').val()==''){
            alert('请上传企业营业执照');
            return false;
        }
        if($('#fileuploader3_input').val()==''){
            alert('请上传证件图片');
            return false;
        }
        if($('#fileuploader4_input').val()==''){
            alert('请上传证件图片');
            return false;
        }
    });
    $('#broker_sub').click(function(){
        if($('broker_name').val() == ''){
            alert('请输入真实姓名');
            document.getElementById('broker_sub').focus();
            return false;
        }
        var myNum = /^((1[3-8]{1})+\d{9})$/;
        if($('#broker_phone').val() == ''){
            alert('请填写联系方式');
            document.getElementById('broker_phone').focus();
            return false;
        }else if(!myNum.test($('#broker_phone').val())){
            alert('联系方式格式不正确');
            document.getElementById('broker_phone').focus();
            return false;
        }
        if($('#broker_id').val() == ''){
            alert('请输入证件号码');
            document.getElementById('broker_id').focus();
            return false;
        }
        if($('#fileuploader5_input').val()==''){
            alert('请上传经纪人证证件图片');
            return false;
        }
        if($('#fileuploader6_input').val()==''){
            alert('请上传证件图片');
            return false;
        }
        if($('#fileuploader7_input').val()==''){
            alert('请上传证件图片');
            return false;
        }
    });
    $('#agency_sub').click(function(){
        if($('#name_agency').val() == ''){
            alert('请输入企业名称');
            document.getElementById('name_agency').focus();
            return false;
        }
        if($('#phone_agency').val() ==''){
            alert('请输入联系方式');
            document.getElementById('phone_agency').focus();
            return false;
        }else if(!myNum.test($('#phone_agency').val())){
            alert('联系方式格式不正确');
            document.getElementById('phone_agency').focus();
            return false;
        }
        if($('#license_agency')==''){
            alert('请输入营业执照注册号');
            document.getElementById('license_agency').focus();
            return false;
        }
        if($('#app_agency').val()==''){
            alert('请输入联系地址');
            document.getElementById('app_agency').focus();
            return false;
        }
        if($('#per_name_agency').val()==''){
            alert('请输入法人姓名');
            document.getElementById('per_name_agency').focus();
            return false;
        }
        var myNum = /^((1[3-8]{1})+\d{9})$/;
        if($('#per_phone_agency').val() == ''){
            alert('请填写联系方式');
            document.getElementById('per_phone_agency').focus();
            return false;
        }else if(!myNum.test($('#per_phone_agency').val())){
            alert('联系方式格式不正确');
            document.getElementById('per_phone_agency').focus();
            return false;
        }
        if($('#per_id_agency').val()==''){
            alert('请输入证件号码');
            document.getElementById('per_id_agency').focus();
            return false;
        }
        if($('#fileuploader8_input').val()==''){
            alert('请上传企业营业执照');
            return false;
        }
        if($('#fileuploader9_input').val()==''){
            alert('请上传证件图片');
            return false;
        }
        if($('#fileuploader10_input').val()==''){
            alert('请上传证件图片');
            return false;
        }
    });
});
	
	

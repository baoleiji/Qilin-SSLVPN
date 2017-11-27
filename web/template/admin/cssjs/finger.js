var tLFPAPICtrl = document.getElementById("TLFPAPICtrl");
var pluginobj = document.getElementById("pluginobj");
$(function() {
    InitNetSsVerify();
})
//初始化指纹插件
function InitNetSsVerify() {

    if (isIE()) {

        tLFPAPICtrl.Open("1");
        tLFPAPICtrl.SetFPVersion("2");
    } else {
        document.getElementById('pluginobj').focus();

        pluginobj.Open("1");
        pluginobj.SetFPVersion("2");
    }

}

//刷指纹后触发的方法
function hasGotFeatureEvent() {
    $("#errorMsg").html("");
    var tp = "";
    if ($("#username").val().replace(/\ /g, '') == "") {

        $("#errorMsg").html("<b style='color:yellow;font-size:18px'>&nbsp;请输入登录用户名</b>");
        InitNetSsVerify();
        return;
    }
    var name = $("#username").val();

    if (isIE()) {

        tLFPAPICtrl.SetFPPackInfo(name, 1);
        tp = tLFPAPICtrl.GetFingerPrintData();
    } else {
        pluginobj.SetFPPackInfo(name, 1);
        tp = pluginobj.GetFingerPrintData();
    }

    if (fpdataCheck(tp)) {
		
		if(confirm('是否登录？'))
		document.getElementById("doAmsForm").submit();
        //alert(tp);
        /*****在这里发送请求，调用后台Action**********/
        //resetFinger(); //后期如果是改为Action跳转，可以注释
    }

}

//判断刷取指纹是否有效
function fpdataCheck(fp) {
    //var fp = document.getElementById("BiokeePlugin").GetFingerData()
    //if(fp == "" || fp.indexOf("-") >= 0) {
    if (fp == "") {
        $("#errorMsg").html = "<b style='color:yellow'>&nbsp;请刷入指纹</b>";
        return false;
    } else {
        $("#fpdata").val(fp);

        return true;
    }
}
//重置指纹控件，如果Action跳转的方式会刷新页面，所以不需要该方法。如果ajax方式需要用到该方法重置指纹控件
function resetFinger() {
    InitNetSsVerify();
}

//判断浏览器类型,是不是IE浏览器
function isIE() {
    if ( !! window.ActiveXObject || "ActiveXObject" in window) return true;
    else return false;
}
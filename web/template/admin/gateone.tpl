<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<title>{{$host}}</title>
</head>

<body>
<div id="gateone_container" style="position: relative; width: 100%; height: 50em;margin: 0 auto">
    <div id="gateone"></div>
</div>

<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="https://{{$host}}:4433/static/gateone.js"></script>
<script type="text/javascript">
$(document).ready(function(){         
    var ip = "{{$host}}";   // 想办法拿到要登陆的设备的ip地址， 有多种方法， 比如把ip地址放置一个隐藏的input标签内， 或者通过url的参数行获取
    var ssh_url = 'ssh://{{$username}}:{{$password}}@' + ip + ':' + {{$port}};           
    GateOne.init({
     		url:'https://{{$host}}:4433',
            theme:'black',
            goDiv:'#gateone',
            disableTermTransitions:'true',
            autoConnectURL:ssh_url,
    }); 

    GateOne.Base.superSandbox("GateOne.SomePlugin", ["GateOne", "GateOne.Net",  "GateOne.Terminal.Input", "GateOne.Terminal"], function(window, undefined) {
        // this will ensure that modules in superSandbox will load completely first, then execute your code
        // Put your code here
        var location =  ip;              
        GateOne.prefs.autoConnectURL=ssh_url;
        //GateOne.prefs.fontSize="100%";
        GateOne.prefs.scrollback = 10000;  // scrollback buffer up to 10,000 lines
        //GateOne.Terminal.loadFont("Source Code Pro", "150%");
        GateOne.locations; // Holds the state of all current known/open location
        GateOne.Net.setLocation(location); // Change locations in the current tab on-the-fly!这里设置的作用在于记录和保持ssh登陆的状态，只要不logout或者断开session，关闭页面后打开还会回到上次的状态
    });
}); // end of document ready
</script>
</body>
</html>



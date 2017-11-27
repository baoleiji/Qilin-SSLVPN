<html>
<head>
<title>MSTSC Player</title>
</head>
<body>
<h1><center>MSTSC Player</center></h1>
<center>
	<applet
	code = "com.free.mstsc.MstscMonitor",
	name = "Mstsc Player",
	archive = "{{$template_root}}/mstsc.jar",
	width = 0,
	height = 0>
  	<param name="host" value="{{$session.proxy_addr}}"/> 
	  <param name = "port" value="3391"/>
	  <param name = "username" value = "{{$sid}}" />
	  <param name = "bpp" value = "16" />
	  <param name = "password" value = "encoded password" />
	  <param name = "vpnip" value= "{{$vpnip}}" />
	  <param name = "window_size" value = "{{$session.window_size}}" />
	</applet>
</center>		

</body>
</html>



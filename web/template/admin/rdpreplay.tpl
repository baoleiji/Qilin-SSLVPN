<html>
<head>
<title>ProperJavaRdpApplet</title>
</head>
<body>

<center>
	<applet
	code = "net.propero.rdp.applet.RdpApplet",
	name = "ProperJavaRdp",
	archive = "{{$template_root}}/java/proJavaRdpApplet.jar,{{$template_root}}/java/java-getopt-1.0.13.jar,{{$template_root}}/java/log4j-java1.1.jar",
	width = 800,
	height = 600>
     <param name="geometry" value="800x600"/>
     <param name="server" value="{{$ip}}"/> 
	  <param name = "port" value="{{$port}}"/>
	  <param name = "username" value="{{$username}}"/>
	  <param name = "bpp" value = "16" />
	  <param name = "proxy_addr" value= "{{$proxy_addr}}" />
	</applet>
</center>		
	
</body>
</html>



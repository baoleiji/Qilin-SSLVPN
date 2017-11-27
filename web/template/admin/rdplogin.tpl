<html>
<head>
<title>ProperJavaRdpApplet</title>
</head>
<body>
<h1><center>ProperJavaRdp Applet</center></h1>
<center>
	<applet>
	code = "net.propero.rdp.applet.RdpApplet",
	name = "ProperJavaRdp",
	archive = "{{$template_root}}/java/proJavaRdpApplet.jar,{{$template_root}}/java/java-getopt-1.0.13.jar,{{$template_root}}/java/log4j-java1.1.jar",
	width = 800,
	height = 600>
     <param name="geometry" value="800x600"/>
     <param name="server" value="{{$ip}}"/> 
	  <param name = "port" value="{{$port}}"/>
	</applet>
</center>		
	
</body>
</html>



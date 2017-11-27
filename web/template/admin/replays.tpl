<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Replay}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="main_content">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">

			<tr bgcolor="f7f7f7">
				<td>   
				<!--
				<applet CODEBASE="."
					 ARCHIVE="{{$template_root}}/MyZtermApplet.jar"
					 CODE="org.sidchen.rplayUI.RplayApplet1" 
					 WIDTH=1012 HEIGHT=702>
					 <param name="PlayFile.url" value="{{$filename}}">
				 </applet>
				 -->
				 <applet CODEBASE="."
					 ARCHIVE="{{$template_root}}/RplayApplet31.jar"
					 CODE="org.sidchen.rplayUI.RplayApplet" 
					 WIDTH=1012 HEIGHT=702>
					 <param name="PlayFile.url" value="{{$filename}}">
					 <param name="FileServlet.url" value="http://{{$serveradd}}:8080/playback/servlet/org.sidchen.rplayServlet.FileServlet">
					 <!-- make sure, non-java-capable browser get a message: -->
<br><b>Your Browser seems to have no <a href="http://java.sun.com/">Java</a>
support. Please get a new browser or enable Java to see this applet!</b>
<br></applet>
			</td>
			</tr>
		</table>
	</td>
  </tr>
</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



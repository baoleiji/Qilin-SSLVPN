<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>回放</title>
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
				{{if $app_act eq 'applet'}}
				 <applet
	code = "com.free.{{$tool}}Playback",
	name = "PuttyApplet",
	archive = "{{$template_root}}/utilities.jar",
	width = 0,
	height = 0>
	   <param name = "putty_path" value = "c:\freesvr\ssh\putty.exe" />
   <param name="host" value="{{$proxy_addr}}"/> 
   <param name = "monitorport" value="22"/>                  
   <param name = "monitoruser" value = "{{$monitoruser}}--database--{{$dbtype}}" /> 
   <param name = "monitorpassword" value = "{{$random}}" /> 
   <param name = "sid" value= "{{$sid}}" />       
   <param name = "cid" value= "{{$cid}}--2--{{$random}}" />       
	<param name = "proxy_addr" value= "{{$proxy_addr}}" />
	</applet>
	{{else}}
<object classid="clsid:9B63D7FE-1BF8-4888-B5D3-715D5A0E51E2"  codebase="{{$template_root}}/ProgramActiveX.cab#version=1,0,0,1" width="0" height="0" id="Csecurecrtdisplay">

	   <param name = "putty_path" value = "c:\freesvr\ssh\putty.exe" />
   <param name="host" value="{{$proxy_addr}}"/> 
   <param name = "monitorport" value="22"/>                  
   <param name = "monitoruser" value = "{{$monitoruser}}--database--{{$dbtype}}" /> 
   <param name = "monitorpassword" value = "{{$random}}" /> 
   <param name = "sid" value= "{{$sid}}" />       
   <param name = "cid" value= "{{$cid}}--2--{{$random}}" />       
	<param name = "proxy_addr" value= "{{$proxy_addr}}" />
	</object>
	<script type = "text/javascript">
         function securecrtdisplay() 
        {
            if (window.ActiveXObject) 
            {
                try 
                {
					{{if $tool eq 'putty.Putty'}}
						document.getElementById("Csecurecrtdisplay").StartPuttyDisplay();
					{{else}}
						document.getElementById("Csecurecrtdisplay").StartSecureCRTDisplay();
					{{/if}}
                }
                catch (e) 
                {
                    alert(e.description)
                    alert(e.name)
                    alert(e.message)
                }
            }
        }
		securecrtdisplay();
    </script>

	{{/if}}
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




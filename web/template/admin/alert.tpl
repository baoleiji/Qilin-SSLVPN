<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<script language="JavaScript">
window.onload=function(){
obj=new Date();
d=obj.getFullYear()+'-';
d+=(obj.getMonth()+1)<10?'0'+(obj.getMonth()+1):obj.getMonth()+1;
d+='-'+obj.getDate()+' '+obj.getHours()+':'+obj.getMinutes()+':'+obj.getSeconds();
form.dt.value=d;
}
</script>
</head>

<body>
<style type="text/css">
a {
    color: #003499;
    text-decoration: none;
} 
a:hover {
    color: #000000;
    text-decoration: underline;
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="middle" class="hui_bj" >
	<div class="menu">
	<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eventlogs&action=eventconfig">报警规则</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_alert">告警配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 
	</ul>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
	<form name="news_add" method="post" action="admin.php?controller=admin_alert&action=config">

	<table width=100%  class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
					<td colspan="2" align="center">
									<b>修改告警配置</b>
					</td>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
     		<td style="width:40%" align="right">邮件服务器地址：</td>
			<td><input type="text" name="mailserver" size="35" value="{{$config.3.svalue}}"> </td>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
  									<td style="width:40%" align="right">邮件用户名：</td>
									<td><input type="text" name="user" size="35" value="{{$config.5.svalue}}"> </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
 			<td style="width:40%" align="right">认证密码：</td>
			<td><input type="text" name="password" size="35" value="{{$config.4.svalue}}"> </td>
	</tr>
	
		{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td style="width:40%" align="right">告警间隔：</td>
			<td><input type="text" name="alert_interval" size="35" value="{{$config.0.svalue}}">秒</td>
	</tr>
	
			{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td align="right">告警邮件标题：</td>
			<td><input type="text" name="alert_mail_title" size="35" maxlength="255" value="{{$config.2.svalue}}"></td>
	</tr>
	
			{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td align="right">告警邮件内容：</td>
			<td><textarea name="alert_mail_content" style="width:250px;height:120px;"	>{{$config.1.svalue}}</textarea>用$MSG$表示日志的内容</td>
	</tr>
	
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
         <TD  align="center" colSpan=2 >
         	<input name="submit" type="submit" value="保存修改"  class="bnnew2" />
         </TD>

	</tr>

	</table>
</form>
</td>


</tr>
</table>

 <script type="text/javascript">



function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}



</script>
</body>

</html>




<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
</head>
 <SCRIPT language=javascript src="{{$template_root}}/images/selectdate.js"></SCRIPT>
 <SCRIPT type=text/javascript>
var siteUrl = "{{$template_root}}/images/date";
function setappaddress(value){
	if(value=='3'){
		document.getElementById('path').value='{{$IE}}';
		document.getElementById('path').readonly=true;
	}else if(value=='11'){
		document.getElementById('path').value='{{$Radmin}}';
		document.getElementById('path').readonly=true;
	}else if(value=='0'){
		document.getElementById('path').value='{{$Xbrowser}}';
		document.getElementById('path').readonly=true;
	}else if(value=='20'){
		document.getElementById('path').value='{{$PLSQL}}';
		document.getElementById('path').readonly=true;
	}
}
</SCRIPT>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appserver_list">应用发布</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL ne 3}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appprogram_list">应用程序</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appicon_list">应用图标</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul><span class="back_img"><A href="admin.php?controller=admin_config&action=appprogram_list&ip={{$appserverip}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td align="center">
    <form name="f1" method=post action="admin.php?controller=admin_config&action=appprogram_save&id={{$p.id}}" enctype="multipart/form-data">
	<table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
		<tr><th colspan="3" class="list_bg"></th></tr>
	{{assign var="trnumber" value=0}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>应用名称</td>
		<td width="67%"><input type="text" name="name" value="{{$p.name}}" /></td>
	</tr>
	
		{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>程序地址</td>
		<td width="67%"><input type="text" size="100" id="path" name="path" value="{{$p.path}}" /></td>
	  </tr>
	   {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>自动登录</td>
		<td width="67%"><input name="autologin" type="text" value="{{if $p.autologin}}{{$p.autologin}}{{else}}0{{/if}}"></td>
	  </tr>
	   {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>图标</td>
		<td width="67%">
		<img id="iconpath" src="upload/{{$p.icon}}" /><br>
		<select name="icon" onchange="document.getElementById('iconpath').src='upload/'+this.value" >
		<option value="" >请选择</option>
		{{section name=i loop=$icon}}
		<option value="{{$icon[i].path}}" {{if $icon[i].path eq $p.icon}}selected{{/if}} >{{$icon[i].name}}</option>
		{{/section}}
		</select>
		</td>
	  </tr>
	  {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>描述</td>
		<td width="67%"><textarea name="description" cols="50" rows="5">{{$p.description}}</textarea></td>
	  </tr> 
	 	 
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
					<td></td><td><input type="hidden" name="ac" value="new" />
<input type="hidden" name="id" value="{{$p.id}}" />
<input type=submit  value="保存修改" class="an_02"></td></tr>
	</table>
<br>
</form>
	</td>
  </tr>
</table>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




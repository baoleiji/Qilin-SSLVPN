 <html>
<head>
  <title> </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
 <link href="template/admin/all_purpose_style.css" type="text/css" rel="stylesheet">
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >

  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
             <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold">系统阈值列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=snmp_interface_policy">接口阈值列表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=status_thold">主机配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=interface_thold">网络配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=app_thold">应用配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=dns_thold">DNS配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="javascript:history.back();"><IMG src="{{$template_root}}/images/back1.png" width="80" height="25" border="0"></A></span>
</div></td></tr>
<tr><td>
    <form method="post" name="newform" action="admin.php?controller=admin_thold&action=snmp_interface_policy_set_save&id={{$thold.id}}">
    <table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
      <input type="hidden" name="ac" value="update">
 {{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
	  <td width="33%" align="right"  valign=top>{{$thold.name}}</td>
	  <td >
	  <table>
		<tr>
			{{section name=u loop=$servergroup}}
			<td width="150"><input type="checkbox" name='Group[]' value='{{$servergroup[u].id}}' >{{$servergroup[u].groupname}}</td>
			{{if ($smarty.section.u.index +1) % 5 == 0}}</tr><tr>{{/if}}
			{{/section}}
		</tr>
	</table>
	  </td>
	  </tr>
	
{{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td colspan="2" align="center" style="border-bottom: none; padding: 10px;">
      全选:<input type="checkbox" name="select_all" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=document.newform.elements[i];if(e.name=='Group[]')e.checked=document.newform.select_all.checked;}">&nbsp;&nbsp;<input type="button" value="确定" onClick="javascript:document.newform.submit();" class="btn" style="font-size:12px">
      <input type="reset" value="重置" class="btn" style="font-size:12px">
    </td>
  </tr>
</table></td></tr></table>
</form>
</body>
</html>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>服务{{$language.List}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=ifcfgeth">网络配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=config_route">静态路由</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=ping">PING</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
  <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=tracepath">TRACE</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
 <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
			<tr>
				<th class="list_bg"  width="10%">网卡名称</th>                            
				<th class="list_bg"  width="10%">启用</th>
				<th class="list_bg"  width="30%">网卡IP</th>
				<th class="list_bg"  width="20%">掩码</th>
				<th class="list_bg"  width="10%">网关</th>
				<th class="list_bg"  width="10%">状态</th>
				<th class="list_bg"  width="">{{$language.Operate}}</th>
			</tr>
			{{section name=t loop=$files}}
				{{if !$files[t].lo}}
				<tr {{if $files[t].backup}}bgcolor="red"{{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
					<td>{{$files[t].name}}</td>
					<td>{{if $files[t].ONBOOT eq 1}}<font color="green">启用</font>{{else}}禁用{{/if}}</ td>
					<td>{{if $systemversion eq 7}}IP1:{{$files[t].IPADDR0}}&nbsp;&nbsp;IP2:{{$files[t].IPADDR1}}&nbsp;&nbsp;IP3:{{$files[t].IPADDR2}}{{else}}{{$files[t].IPADDR}}{{/if}}</td>
					<td>{{if $systemversion eq 7}}1:{{$files[t].NETMASK0}}&nbsp;&nbsp;2:{{$files[t].NETMASK1}}&nbsp;&nbsp;3:{{$files[t].NETMASK2}}{{else}}{{$files[t].NETMASK}}{{/if}}</td>
					<td>{{$files[t].GATEWAY}}</td>
					<td align="center">{{if $files[t].STATUS eq 'yes'}}<img src="{{$template_root}}/images/Green.gif" >{{else}}<img src="{{$template_root}}/images/hong.gif" >{{/if}}</td>
					<td>
					{{if $files[t].lo ne 1}}<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a {{if $files[t].br0}}onclick="alert('不能修改,已经绑定到bro');return false;" href="#"{{else}}href=" admin.php?controller=admin_eth&action=config_eth&file={{$files[t].file|urlencode}}&name={{$files[t].name}}"{{/if}}>修改</a>
					{{if $files[t].backupfile}}&nbsp;<img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_eth&action=eth_del&file={{$files[t].file|urlencode}}&name={{$files[t].name}}" onclick="return confirm('确定删除？')">{{$language.Delete}}</a>
					{{/if}}
					{{/if}}{{*&nbsp;&nbsp;|&nbsp;&nbsp; 
					<img src='{{$template_root}}/images/chart_organisation.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_eth&action=ifcfg_br&file={{$files[t].file|urlencode}}&name={{$files[t].name}}&filename={{$files[t].filename}}">网卡绑定</a>*}}
					</td>
				</tr>
				{{/if}}
			{{/section}}			
		</table>
	</td>
  </tr>
</table>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



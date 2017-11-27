<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.SessionsList}}</title>
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
<script>
function chk_form(){
return true;
}
function searchit(){
	document.f1.action = "admin.php?controller=admin_config&action=apppub_list&ip={{$appserverip}}";
	document.f1.action += "&device_ip="+document.f1.device_ip.value;
	document.f1.action += "&hostname="+encodeURIComponent(document.f1.hostname.value);
	document.f1.action += "&program="+encodeURIComponent(document.f1.program.value);
	return true;
}
</script>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    {{if $smarty.get.device_ip eq ''}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appserver_list">应用发布</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL ne 3}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appprogram_list">应用程序</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appicon_list">应用图标</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	{{else}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $from eq 'dir'}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{else}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{/if}}
	{{if $from eq 'dir'}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{else}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	{{/if}}
</ul><span class="back_img"><A href="admin.php?controller={{if $smarty.get.device_ip ne ''}}admin_pro&action=dev_index{{else}}admin_config&action=appserver_list{{if $smarty.get.device_ip eq ''}}&ip={{$appserverip}}{{/if}}&device_ip={{$smarty.get.device_ip}}{{/if}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
<TR>
                    <TD >
					<form name ='f1' action='admin.php?controller=admin_config&action=apppub_list&ip={{$appserverip}}' method=post>
					IP<input type="text" class="wbk" name="device_ip">
					&nbsp;&nbsp;主机名<input type="text" class="wbk" name="hostname">
					&nbsp;&nbsp;程序名称<input type="text" class="wbk" name="program">
					&nbsp;&nbsp;<input  type="submit" value=" 搜索 " onclick="return searchit();" class="bnnew2">

					</form>
					</TD>
                  </TR>
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
			<tr>
				<th class="list_bg"  width="3%">#</th>
				<th class="list_bg"  width="15%"><a href="admin.php?controller=admin_config&action=apppub_list&ip={{$appserverip}}&orderby1=name&orderby2={{$orderby2}}" >应用名称</a></th>
				<th class="list_bg"  width="8%"><a href="admin.php?controller=admin_config&action=apppub_list&ip={{$appserverip}}&orderby1=username&orderby2={{$orderby2}}" >用户名</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_config&action=apppub_list&ip={{$appserverip}}&orderby1=device_ip&orderby2={{$orderby2}}" >服务器</a></th>
				<th class="list_bg"  width="20%"><a href="admin.php?controller=admin_config&action=apppub_list&ip={{$appserverip}}&orderby1=path&orderby2={{$orderby2}}" >程序路径</a></th>
				<th class="list_bg"  width="20%"><a href="admin.php?controller=admin_config&action=apppub_list&ip={{$appserverip}}&orderby1=description&orderby2={{$orderby2}}" >描述</a></th>
				<th class="list_bg"  width="30%">{{$language.Operate}}</th>
			</tr>
			<form action='#' method='post' name='member_list' >
			{{section name=t loop=$apppub}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td><input type="checkbox" name="chk_member[]" value="{{$apppub[t].id}}"></td>
				<td>{{$apppub[t].name}}</td>
				<td>{{if $apppub[t].username}}{{$apppub[t].username}}{{else}}空用户{{/if}}</td>
				<td>{{$apppub[t].device_ip}}</td>
				<td>{{$apppub[t].path|escape:"html"}}</td>
				<td>{{$apppub[t].description}}</td>
				<td>
				
			<img src='./template/admin/images/left_dot1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_config&action=apppub_edit&id={{$apppub[t].id}}&appserverip={{$apppub[t].appserverip}}&device_ip={{$smarty.get.device_ip}}'>{{$language.Edit}}</a>	
				&nbsp;|<img src='./template/admin/images/left_dot1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'>{{if $apppub[t].autologinflag eq 3}}<a href='admin.php?controller=admin_app&action=applogin&id={{$apppub[t].appdevicesid}}&appserverip={{$apppub[t].appserverip}}&device_ip={{$smarty.get.device_ip}}'>单点登录</a>{{else}}单点登录{{/if}}	
				&nbsp;|&nbsp;<img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a onclick="if(confirm('确定{{$language.Delete}}吗?')) return true;else return false;" href="admin.php?controller=admin_config&action=apppub_delete&id={{$apppub[t].id}}&device_ip={{$smarty.get.device_ip}}">{{$language.Delete}}</a></td>
			</tr>
			{{/section}}
			<tr>
				<td colspan="5" align="left">
					<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">{{$language.select}}{{$language.this}}{{$language.page}}{{$language.displayed}}的{{$language.All}}{{$language.User}}&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="if(confirm('确定要删除?')) document.member_list.action='admin.php?controller=admin_config&action=apppub_delete&appserverip={{$appserverip}}&device_ip={{$smarty.get.device_ip}}';else return false;" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="location.href='admin.php?controller=admin_config&action=apppub_edit&appserverip={{$appserverip}}&device_ip={{$smarty.get.device_ip}}'"  value="{{$language.Add}}" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button"  value="导入" onClick="javascript: document.location='admin.php?controller=admin_config&action=apppubimport&appserverip={{$appserverip}}&device_ip={{$smarty.get.device_ip}}';" class="an_02">
					&nbsp;&nbsp;<input type="button"  value="导出" onClick="javascript:document.getElementById('hide').src='admin.php?controller=admin_config&action=apppubexport&appserverip={{$appserverip}}';" class="an_02">
				</td>
				<td colspan="5" align="right">
					{{$language.all}}{{$command_num}}{{$language.Command}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_config&action=apppub_list&page='+this.value;">{{$language.page}}
				</td>
			</tr>
			</form>
		</table>
	</td>
  </tr>
</table>


</body>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



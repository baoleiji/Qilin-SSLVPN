<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.PasswordKey}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>
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
<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>	
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
		<form name="member_list" action="admin.php?controller=admin_pro&action=deletepasswordkey" method="post">
					<tr>
						<th class="list_bg" bgcolor="d9ecfa" width="2%">选</td>
						<th class="list_bg"  bgcolor="d9ecfa" width="15%">{{$language.Createdate}}</th>	
						<th class="list_bg"  bgcolor="d9ecfa" width="7%">密码邮件</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="7%">密钥邮件</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="60%">密钥文件</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="7%">操作</th>
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $allsession[t].dangerous > 1}}bgcolor="red"{{elseif $allsession[t].dangerous > 0}}bgcolor="yellow" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><input type="checkbox" name="chk_member[]" value="{{$allsession[t].id}}"></td>
						<td>{{$allsession[t].key_date}}</td>
						<td>{{if $allsession[t].key_email}}成功{{else}}失败{{/if}}</td>
						<td>{{if $allsession[t].zip_email}}成功{{else}}失败{{/if}}</td>
						<td>{{$allsession[t].zip_file}}</td>
						<td>&nbsp;{{*<img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_pro&action=deletepasswordkey&id={{$allsession[t].id}}">{{$language.Delete}}</a>*}}
						<img src="{{$template_root}}/images/ckico.gif" width="16" height="16" align="absmiddle"><a href="#" onclick="window.open ('admin.php?controller=admin_pro&action=showpasswordkey&id={{$allsession[t].id}}', 'newwindow', 'height=150, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;">查看</a>
						</td>
					</tr>
						
					{{/section}}
					<tr><td colspan="3" align="left"><input name="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=document.member_list.elements[i];if(e.name=='chk_member[]')e.checked=document.member_list.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="删除选中" onClick="my_confirm('确定要删除所选密码密钥?');if(chk_form()) document.member_list.action='admin.php?controller=admin_pro&action=deletepasswordkey'; else return false;" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button"  value="添加" onClick="javascript:document.location='admin.php?controller=admin_pro&action=passwordkey_edit';" class="an_02"></td>
						<td colspan="4" align="right">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) {window.location='{{$curr_url}}&page='+this.value;return false;}">{{$language.page}} <!--当前数据表: {{$now_table_name}}--> 
						
						</td>
					</tr>
				</table>
	</td>
  </tr>
</table>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>



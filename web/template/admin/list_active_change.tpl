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
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
		<form name="member_list" action="admin.php?controller=admin_pro&action=lac_save" method="post">
					<tr>	
						<th class="list_bg"  bgcolor="d9ecfa" width="7%">服务器IP</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="7%">主机名</th>	
						<th class="list_bg"  bgcolor="d9ecfa" width="7%">协议</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="7%">用户名</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="7%">新密码</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="7%">即将修改</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="7%">保存修改</th>
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td>{{$allsession[t].device_ip}}</a></td>						
						<td>{{$allsession[t].hostname}}</td>					
						<td>{{$allsession[t].login_method}}</td>				
						<td>{{$allsession[t].username}}</td>				
						<td><input type="text" name="new_password_{{$smarty.section.t.index}}" value="已生成" /></td>				
						<td><input type="checkbox" name="active_change_{{$smarty.section.t.index}}" value="2" {{if $allsession[t].active_change}}checked{{/if}} /></td>
						<td><input type="hidden" name="id_{{$smarty.section.t.index}}" value="{{$allsession[t].id}}" /><input type="submit" name="save_{{$smarty.section.t.index}}" value="保存" onClick="javascript: window.location='admin.php?controller=admin_member&action=memberimport';" class="an_02"></td>
					</tr>
						
					{{/section}}
					<tr><td colspan="2" align="left"><input type="button"  value="修改密码" onClick="javascript: document.location='admin.php?controller=admin_pro&action=lac_save2&cmd={{$cmd}}';" class="an_02"></td>
						<td colspan="8" align="right">
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



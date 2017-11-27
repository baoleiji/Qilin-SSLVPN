<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>路由列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
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
    <li class="me_{{if $smarty.session.RADIUSUSERLIST}}b{{else}}a{{/if}}"><img src="{{$template_root}}/images/an1{{if $smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an3{{if $smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_{{if $smarty.session.RADIUSUSERLIST}}a{{else}}b{{/if}}"><img src="{{$template_root}}/images/an1{{if !$smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an3{{if !$smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul><span class="back_img"><A href="admin.php?controller=admin_member&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
</head>

<body>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
		<tr bgcolor="#F3F8FC">
			<th class="list_bg"  width="3%" align="center" bgcolor="#E0EDF8"><b>序列</b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>用户名</b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>RDP磁盘映射</b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>RDP剪切版</b></th>
			<th class="list_bg"  width="8%" align="center" bgcolor="#E0EDF8"><b>RDP磁盘映射</b></th>
			<th class="list_bg"  width="8%" align="center" bgcolor="#E0EDF8"><b>密码</b></th>
			<th class="list_bg"  width="8%" align="center" bgcolor="#E0EDF8"><b>确认密码</b></th>
			<th class="list_bg"  width="15%" align="center" bgcolor="#E0EDF8"><b>过期时间</b></th>
		</tr>		
		<form name='route' action='admin.php?controller=admin_member&action=batchedit_save' method='post'>
		{{section name=t loop=$users}}
		
		<tr>
			<td width="5%" class="td_line">{{$smarty.section.t.index+1}}<input type="hidden" name="uid[]" value="{{$users[t].uid}}" /><input type="hidden" name="username[]" value="{{$users[t].username}}" /></td>
			<td width="10%" class="td_line">{{$users[t].username}}</td>			
			<td width="5%" class="td_line"><input type="checkbox" name="rdpdiskauth_up_{{$users[t].uid}}" class="" value="1" {{if $users[t].rdpdiskauth_up}}checked{{/if}}></td>
			<td width="5%" class="td_line"><input type="checkbox" name="rdpclipauth_up_{{$users[t].uid}}" class="" value="1" {{if $users[t].rdpclipauth_up}}checked{{/if}}></td>
			<td width="10%" class="td_line"><input type="text" class="wbk" name="rdpdisk[]" value="{{$users[t].rdpdisk}}" size=15 /></td>
			<td width="10%" class="td_line"><input type="password" class="wbk" name="password[]" value="{{$users[t].password}}" size=15 /></td>
			<td width="10%" class="td_line"><input type="password" class="wbk" name="confirm_password[]" value="{{$users[t].password}}" size=15 /></td>
			<td width="10%" class="td_line"><INPUT size=15 value="{{if $users[t].end_time ne '0000-00-00 00:00:00'}}{{$users[t].end_time}}{{/if}}" id="limit_time_{{$users[t].uid}}" name="limit_time[]" onFocus="setday(this)">&nbsp;&nbsp;<input type="button"  id="f_rangeEnd_trigger_{{$users[t].uid}}" name="f_rangeEnd_trigger_{{$users[t].uid}}" value="选择时间" class="wbk"> </td>
		</tr>		
		{{/section}}
		  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true,
	popupDirection:'down'
});
{{section name=m loop=$users}}
cal.manageFields("f_rangeEnd_trigger_{{$users[m].uid}}", "limit_time_{{$users[m].uid}}", "%Y-%m-%d");
{{/section}}


</script>
		 <tr>
			<td colspan="9" align="center" ><input type='submit'  name="batch" value='确定' class="an_02"></td>
		  </tr>
		</form>

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
function change_level(obj, num){
{{if $smarty.session.ADMIN_LEVEL == 3}}
	obj.selectedIndex=0;
{{/if}}
	if(obj.value==11){
		var group = document.getElementById('groupid_'+num);
		var o_value = null;
		for(var i=0; i<group.options.length; i++){
			o_value = group.options[i].text.toLowerCase();
			if(o_value.indexOf("radius")>=0){
				group.options[i].selected = true;
				break;
			}
		}
	}
}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




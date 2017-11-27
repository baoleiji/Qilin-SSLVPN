<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script>
	function my_confirm(str){
		if(!confirm("确认要" + str + "？"))
		{
			window.event.returnValue = false;
		}
	}
	function chk_form(){
		for(var i = 0; i < document.member_list.elements.length;i++){
			var e = document.member_list.elements[i];
			if(e.name == 'chk_member[]' && e.checked == true)
				return true;
		}
		alert("您没有{{$language.select}}任何{{$language.User}}！");
		return false;
	}

	function batchloginlock(){
		document.member_list.action = "admin.php?controller=admin_pro&action=devbatchloginlock";
		document.member_list.submit();
		return true;
	}
</script>
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

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=serverstatus">服务状态</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=latest">系统状态</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup">配置备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting">数据同步</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=upgrade">软件升级</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=cronjob">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=changelogo">图标上传</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=notice">系统通知</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                <TBODY>{{*
			           <td  colspan="6">
		   			<form action="admin.php?controller=admin_pro&action=devpass_index" method="post" >
					{{$language.IPAddress}}<input type="text" class="wbk" name="ip"/>
					{{$language.Username}}<input type="text" class="wbk" name="name"/>
					<input type="submit" class="button" value="{{$language.Search}}">
					</form>
		   </td>*}}
		   		  <form name="member_list" action="admin.php?controller=admin_config&action=notice_del" method="post" >
		   
                  <TR>
                  <th class="list_bg"  width="1%">{{$language.select}}</th>
                    <th class="list_bg" width="20%">广播内容</TD>
                    <th class="list_bg" width="6%">是否关闭</TD>
                    <th class="list_bg" width="10%">过期时间</TD>
                    <th class="list_bg"width="9%">是否全部用户</TD>
					<th class="list_bg" width="20%">广播组</TD>
                    <th class="list_bg" width="20%">广播用户</TD>
					<th class="list_bg" width="15%">{{$language.Operate}}</TD>
                  </TR>

            </tr>
			{{section name=t loop=$notices}}
			<tr>
			<td><input type="checkbox" name="chk_member[]" value="{{$notices[t].id}}"></td>
				<td title="{{$notices[t].content}}">{{$notices[t].content|truncate_cn:"20":"..."}}</td>
				<td>{{if $notices[t].enable}}是{{else}}否{{/if}}</td>
				<td>{{$notices[t].expiretime}}</td>
				<td>{{if $notices[t].all}}是{{else}}否{{/if}}</td>		
				<td title="{{$notices[t].gname}}">{{if $notices[t].all}}所有组{{else}}{{$notices[t].gname|truncate_cn:"20":"..."}}{{/if}}</td>	
				<td title="{{$notices[t].uname}}">{{if $notices[t].all}}所有用户{{else}}{{$notices[t].uname|truncate_cn:"20":"..."}}{{/if}}</td>
				<td>
				{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 4}}
				<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_config&action=notice_edit&id={{$notices[t].id}}'>{{$language.Edit}}</a>

				<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('{{$language.Delete_sure_}}？')) {return false;} else { location.href='admin.php?controller=admin_config&action=notice_del&id={{$notices[t].id}}';}">{{$language.Delete}}</a>
				{{/if}}
				</td> 
			</tr>
			{{/section}}
			<tr>
	           <td  colspan="5" align="left">
				<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="删除" onclick="return my_confirm('确定删除');" class="an_02">
		   &nbsp;<input type="button"  value="添加" onClick="location.href='admin.php?controller=admin_config&action=notice_edit'"  class="an_06">&nbsp;&nbsp;
		   </td><td colspan="5">
		   			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_index&serverid={{$serverid}}&page='+this.value;">{{$language.page}}
		   </td>
		</tr>
		</form>
		</TBODY>
              </TABLE>	</td>
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




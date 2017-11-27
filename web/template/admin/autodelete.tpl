<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.SessionsList}}</title>
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

<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&action=batch_del&backupdb_id={{$backupdb_id}}">日志删除</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&action=autodelete&backupdb_id={{$backupdb_id}}">自动删除</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
 
  <tr>
	<td colspan="2" class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
			<tr>
				<th class="list_bg"  width="20%">操作内容</th>
				<th class="list_bg"  width="40%">自动删除(天以前)</th>
				<th class="list_bg"  width="">操作</th>
			</tr>
			{{section name=t loop=$autodelete}}
			<tr {{if $autodelete[t].dangerlevel eq 2}}bgcolor="red"{{elseif $autodelete[t].dangerlevel eq 3}}bgcolor="yellow"{{elseif $autodelete[t].dangerlevel eq 1}}bgcolor="orange"{{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td>{{$autodelete[t].zhname}}</ td>
				<td>{{$autodelete[t].time}}</td>
				<td><img src='./template/admin/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_session&action=autodelete_edit&id={{$autodelete[t].seq}}'>{{$language.Edit}}</a>	</td>
			</tr>
			{{/section}}
			<tr>
				<td colspan="12" align="right">
					{{$language.all}}{{$command_num}}{{$language.Command}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_session&action=autodelete&sid={{$sid}}&backupdb_id={{$backupdb_id}}&page='+this.value;">{{$language.page}}  
				<!--
				<select  class="wbk"  name="table_name">
				{{section name=t loop=$table_list}}
				<option value="{{$table_list[t]}}" {{if $table_list[t] == $now_table_name}}selected{{/if}}>{{$table_list[t]}}</option>
				{{/section}}
				</select>
				-->
				</td>
			</tr>
		</table>
	</td>
  </tr>
</table>


</body>
<script language="javascript">
function go(url,iid){
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	var hid = document.getElementById('hide');
	document.getElementById(iid).href=url+'&app_act='+app_act;
	//alert(hid.src);
	{{if $logindebug}}
	window.open(document.getElementById(iid).href);
	{{/if}}
	return true;	
}
	{{if $member.default_control eq 0}}
	if(navigator.userAgent.indexOf("MSIE")>0) {
		document.getElementById('app_act').options.selectedIndex = 1;
	}
	{{elseif $member.default_control eq 1}}
		document.getElementById('app_act').options.selectedIndex = 0;
	{{elseif $member.default_control eq 2}}
		document.getElementById('app_act').options.selectedIndex = 1;
{{/if}}
</script>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



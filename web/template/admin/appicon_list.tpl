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
</script>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
   <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appserver_list">应用发布</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL ne 3}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appprogram_list">应用程序</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appicon_list">应用图标</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>

  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
			<tr>
				<th class="list_bg"  width="5%">#</th>
				<th class="list_bg"  width="12%"><a href="admin.php?controller=admin_config&action=appicon_list&ip={{$appserverip}}&orderby1=name&orderby2={{$orderby2}}" >应用名称</a></th>
				<th class="list_bg"  width="40%"><a href="admin.php?controller=admin_config&action=appicon_list&ip={{$appserverip}}&orderby1=name&orderby2={{$orderby2}}" >图标路径</a></th>
				<th class="list_bg"  width="15%">{{$language.Operate}}</th>
			</tr>
			<form action='#' method='post' name='member_list' >
			{{section name=t loop=$appicon}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td><input type="checkbox" name="chk_member[]" value="{{$appicon[t].id}}"></td>
				<td>{{$appicon[t].name}}</td>
				<td>{{$appicon[t].path}}</ td>
				<td>
				
			<img src='./template/admin/images/left_dot1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_config&action=appicon_edit&id={{$appicon[t].id}}&appserverip={{$appicon[t].appserverip}}'>{{$language.Edit}}</a>	
				&nbsp;|&nbsp;<img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a onclick="if(confirm('确定{{$language.Delete}}吗?')) return true;else return false;" href="admin.php?controller=admin_config&action=appicon_delete&id={{$appicon[t].id}}">{{$language.Delete}}</a></td>
			</tr>
			{{/section}}
			<tr>
						<td colspan="9" align="left">
							<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">{{$language.select}}{{$language.this}}{{$language.page}}{{$language.displayed}}的{{$language.All}}{{$language.User}}&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="if(confirm('确定要删除?')) document.member_list.action='admin.php?controller=admin_config&action=appicon_delete&appserverip={{$appserverip}}';else return false;" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="location.href='admin.php?controller=admin_config&action=appicon_edit&appserverip={{$appserverip}}'"  value="{{$language.Add}}" class="an_02">
						</td>
					</tr>
			<tr>
				<td colspan="6" align="right">
					{{$language.all}}{{$command_num}}图标  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_config&action=appicon_list&page='+this.value;">{{$language.page}}
				</td>
			</tr>
			</form>
		</table>
	</td>
  </tr>
</table>

<script type="text/javascript">
window.parent.menu.document.getElementById('devtree').style.display='none';
window.parent.menu.document.getElementById('ldaptree').style.display='none';
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



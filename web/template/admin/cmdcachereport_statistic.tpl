<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Black}}{{$language.group}}{{$language.List}}</title>
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
<script type="text/javascript">
function searchit(){
	document.search.action = "{{$curr_url}}";
	document.search.action += "&usergroup="+document.search.usergroup.value;
	//alert(document.search.action);
	//return false;
	return true;
}
</script>
</script>
<body>



	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="#">命令统计</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=report_search_diy">自定义报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_reports&action={{if $smarty.get.dateinterval eq 'diy'}}report_search_diy{{else}}report_search{{/if}}&back=1"><IMG src="./template/admin/images/back1.png" width="80" height="25" border="0"></A></span>
</div></td></tr>
 <tr>
    <td class="main_content">
<form action="{{$curr_url}}" method="post" name="search" >
运维组：<select name='usergroup' id="usergroup" style="width:150px">
			<option value="">所有组</option>
			{{section name=g loop=$usergroup}}
			<option value="{{$usergroup[g].groupname}}">{{$usergroup[g].groupname}}</option>
			{{/section}}
		</select>
 &nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
</form> 
	  </td>
  </tr>
  <tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
	<form name="ip_list" action="admin.php?controller=admin_reports&action=del_cmdcache" method="post">
			<tr>
				<th class="list_bg"  width="15%"><a href="admin.php?controller=admin_reports&action=cmdcache&orderby1=cmd&gid={{$gid}}&orderby2={{$orderby2}}" >运维用户</a></th>
				<th class="list_bg"  width="15%"><a href="admin.php?controller=admin_reports&action=cmdcache&orderby1=cmd&gid={{$gid}}&orderby2={{$orderby2}}" >别名</a></th>
				<th class="list_bg"  width="15%"><a href="admin.php?controller=admin_reports&action=cmdcache&orderby1=groupname&gid={{$gid}}&orderby2={{$orderby2}}" >运维组</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_reports&action=cmdcache&orderby1=gid&gid={{$gid}}&orderby2={{$orderby2}}" >系统用户</a></th>				
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_reports&action=cmdcache&orderby1=gid&gid={{$gid}}&orderby2={{$orderby2}}" >设备IP</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_reports&action=cmdcache&orderby1=gid&gid={{$gid}}&orderby2={{$orderby2}}" >命令</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_reports&action=cmdcache&orderby1=gid&gid={{$gid}}&orderby2={{$orderby2}}" >命令次数</a></th>
			
			</tr>
			{{section name=t loop=$allcommand}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td>{{$allcommand[t].luser}}</td>
				<td>{{$allcommand[t].realname}}</td>				
				<td>{{$allcommand[t].groupname}}</td>				
				<td>{{$allcommand[t].user}}</td>				
				<td>{{$allcommand[t].addr}}</td>
				<td>{{$allcommand[t].ocmd}}</td>
				<td>{{$allcommand[t].ct}}</td>
			</tr>
			{{/section}}
			
			
			<tr>
			<td align="left" colspan="1">

			<input type="hidden" name="add" value="new" >
			</td>
				<td colspan="6" align="right">
					{{$language.all}}{{$command_num}}{{$language.Command}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_reports&action=cmdcache&page='+this.value;">{{$language.page}}<!--当前数据表: {{$now_table_name}}-->   导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>  <a href="{{$curr_url}}&derive=2" target="hide"><img src="{{$template_root}}/images/html.png" border=0></a>  <a href="{{$curr_url}}&derive=3" target="hide"><img src="{{$template_root}}/images/word.png" border=0></a>  <a href="{{$curr_url}}&derive=4" target="hide"><img src="{{$template_root}}/images/pdf.png" border=0></a> {{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1" target="hide"></a>{{/if}}
				</td>
			</tr>
			</form>
		</table>
	</td>
  </tr>
</table>


</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



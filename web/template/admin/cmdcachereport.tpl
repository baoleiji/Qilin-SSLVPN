<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Black}}{{$language.group}}{{$language.List}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
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
	var url = "admin.php?controller=admin_reports&action=cmdcachereport";
	{{if $_config.LDAP}}
	{{if $_config.TREEMODE}}
	var obj1=document.getElementById('groupiddh');	
	gid=obj1.value;
	{{else}}
	for(var i=1; true; i++){
		var obj=document.getElementById('groupid'+i);
		if(obj!=null&&obj.options.selectedIndex>-1){
			gid=obj.options[obj.options.selectedIndex].value;
			continue;
		}
		break;
	}
	{{/if}}
	url += "&groupid="+gid;
	{{/if}}
	document.search.action=url;
	//alert(document.search.elements.action);
	//return false;
	return true;
}
</script>

<script>

var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();
var alluser = new Array();
var allserver = new Array();
var i=0;

var i=0;
{{section name=au loop=$alluser}}
alluser[i++]={uid:{{$alluser[au].uid}},username:'{{$alluser[au].username}}',realname:'{{$alluser[au].realname}}',groupid:{{$alluser[au].groupid}},level:{{$alluser[au].level}}};
{{/section}}
var i=0;
{{section name=as loop=$allserver}}
allserver[i++]={hostname:'{{$allserver[as].hostname}}',device_ip:'{{$allserver[as].device_ip}}',groupid:{{$allserver[as].groupid}}};
{{/section}}

</script>
<body>



	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=commandreport">命令总计</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cmdcachereport">命令统计</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cmdlistreport">命令列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=appreport&number=2">应用报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=sftpreport&number=3">SFTP{{$language.Command}}{{$language.report}}</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>	
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=ftpreport&number=6">FTP{{$language.Command}}{{$language.report}}</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_reports&action=forbidden_groups_list&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
 <tr>
    <td class="main_content">
<form action="{{$curr_url}}" method="post" name="search" >

		{{include file="select_sgroup_ajax.tpl" }}           
 &nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" height="35" align="middle" onClick="window.location='admin.php?controller=admin_reports&action=cmdcache'" border="0" value=" 添加命令 " class="bnnew2"/>
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
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_reports&action=cmdcache&orderby1=at&gid={{$gid}}&orderby2={{$orderby2}}" >起始时间</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_reports&action=cmdcache&orderby1=at&gid={{$gid}}&orderby2={{$orderby2}}" >结束时间</a></th>
			
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
				<td>{{$allcommand[t].start}}</td>
				<td>{{$allcommand[t].end}}</td>
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

<script>
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



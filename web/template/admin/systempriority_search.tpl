<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.LogList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script>
function setScroll(){
	window.parent.scrollTo(0,0);
}
var member = new Array();
{{section name=m loop=$member}}
member[{{$smarty.section.m.index}}]={'username':'{{$member[m].username}}','realname':'{{$member[m].realname}}'}
{{/section}}
</script>
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
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=systempriority_search">系统权限</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=apppriority_search">应用权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=systemaccount">系统账号</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=appaccount">应用账号</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1 or  $smarty.session.ADMIN_LEVEL eq 2}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=admin_log">变更报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>


  
  <tr>
	<td class="">
<form method="get" name="session_search" action="admin.php?controller=admin_reports&action=systempriority" >
<input type="hidden" name="controller" value="admin_reports" />
<input type="hidden" name="action" value="systempriority" />
<input type="hidden" name="type" value="luser" />
				<table bordercolor="white" cellspacing="0" cellpadding="0" border="0" width="100%"  class="BBtable">
				 <tr>
    <th class="list_bg" colspan="2">{{$language.Man}}：{{$language.Search}}系统权限,留空表示{{$language.no}}限制 </th>
  </tr>
					{{assign var="trnumber" value=0}}
					<tr  {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
					<td class="td_line" width="30%">运维用户：</td>
						<td class="td_line" width="70%">
						<select name='user' id="user">
						</select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" onclick="toRealname();" id="RealNameToId" value="on" >&nbsp;实名</td>
					</tr>
					
					<tr  {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td class="td_line" width="30%">系统用户：</td>
						<td class="td_line" width="70%"><input name="s_user" type="text" class="wbk"></td>
					</tr>

					<tr  {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td class="td_line" width="30%">设备ip：</td>
						<td class="td_line" width="70%"><input name="ip" type="text" class="wbk"></td>
					</tr>
					
					
					<tr bgcolor="f7f7f7">
						<td class="td_line" colspan="2" align="center"><input name="submit" type="submit" onclick="setScroll();"  value="{{$language.Search}}" class="an_02">
					</tr>
				</table>
				
			</form>
	</td>
  </tr>
</table>

<script>
function toRealname(){
	document.getElementById('user').options.length=0;
	document.getElementById('user').options[document.getElementById('user').options.length]= new Option('所有用户','');
	if(document.getElementById('RealNameToId').checked){
		
		for(var i=0; i<member.length; i++){
			document.getElementById('user').options[document.getElementById('user').options.length]= new Option(member[i].realname,member[i].username);
		}
	}else{
		for(var i=0; i<member.length; i++){
			document.getElementById('user').options[document.getElementById('user').options.length]= new Option(member[i].username,member[i].username);
		}
	}
}
toRealname();
</script>


<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
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

</script>
<script>
	function searchit(){
		document.search.action = "admin.php?controller=admin_member&action=login4approve";
		document.search.action += "&username="+document.search.username.value;
		document.search.submit();
		return true;
	}
	
</script>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&backupdb_id={{$backupdb_id}}">Telnet/SSH</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_sftp&backupdb_id={{$backupdb_id}}">SFTP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_scp&backupdb_id={{$backupdb_id}}">SCP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_ftp&backupdb_id={{$backupdb_id}}">FTP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
	{{if $smarty.session.ADMIN_LEVEL ne 0}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_as400&backupdb_id={{$backupdb_id}}">AS400</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
	{{/if}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_rdp&backupdb_id={{$backupdb_id}}">RDP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_vnc&backupdb_id={{$backupdb_id}}">VNC</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $backupdb_id}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_apppub&backupdb_id={{$backupdb_id}}">应用发布</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_x11&backupdb_id={{$backupdb_id}}">X11</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow_approve">流程审批</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
</ul>
</div></td></tr>
<body>
	
 <TR>
<TD >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
<form name ='search' action='admin.php?controller=admin_member' method=post onsubmit="return searchit();">
  <tr>
    <td >
</td>
    <td >	
					用户名：<input type="text" name="username" size="13" class="wbk"/>&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>

					</td>
  </tr>
</form>	
</table>
</TD>
                  </TR>
	  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	<form name="member_list" action="admin.php?controller=admin_member&action=delete_all" method="post">
					<tr>
						<th class="list_bg"  width="3%" >{{$language.select}}</th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_member&action=login4approve&orderby1=webuser&orderby2={{$orderby2}}' >用户名</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_member&action=login4approve&orderby1=ip&orderby2={{$orderby2}}' >服务器IP</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_member&action=login4approve&orderby1=username&orderby2={{$orderby2}}' >系统用户名</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_member&action=login4approve&orderby1=login_method&orderby2={{$orderby2}}' >登录协议</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_member&action=login4approve&orderby1=applytime&orderby2={{$orderby2}}' >申请时间</a></th>
						<th class="list_bg"  width="24%" >{{$language.Operate}}{{$language.Link}}</th>
					</tr>
					{{section name=t loop=$approves}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td>{{if ($smarty.session.ADMIN_LEVEL eq 4 and (!$approves[t].level or $approves[t].level == 3)) or ($smarty.session.ADMIN_LEVEL eq 1) or ($smarty.session.ADMIN_LEVEL eq 3)}}{{if $approves[t].level != 10 and $approves[t].level != 2 and $approves[t].level != 1}}<input type="checkbox" name="chk_member[]" value="{{$approves[t].id}}">{{/if}}{{/if}}</td>			
						<td>{{$approves[t].webuser}}</td>
						<td>{{$approves[t].ip}}</td>
						<td>{{$approves[t].username}}</td>
						<td>{{$approves[t].login_method}}</td>
						<td>{{$approves[t].applytime}}</td>
						<td>
						
						<!--<img src="{{$template_root}}/images/ckico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_dev&action=index&uid={{$approves[t].uid}}">{{$language.Edit}}{{$language.device}}</a> |-->
						<img src="{{$template_root}}/images/list_ico1.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=dologin4approve&id={{$approves[t].id}}">{{if $approves[t].approved }}已{{/if}}批准</a> |
						<img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=dellogin4approve&id={{$approves[t].id}}">删除</a>
						</td>
					</tr>
					{{/section}}
					
					<tr>
						<td colspan="4" align="left">
						<input name="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=document.member_list.elements[i];if(e.name=='chk_member[]')e.checked=document.member_list.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="删除审批" onClick="my_confirm('确定要删除审批?');if(chk_form()) document.member_list.action='admin.php?controller=admin_member&action=dellogin4approve'; else return false;" class="an_02">&nbsp;&nbsp;<input type="submit"  value="批量审批" onClick="my_confirm('确定要批量审批?');if(chk_form()) document.member_list.action='admin.php?controller=admin_member&action=dologin4approve'; else return false;" class="an_02">
						</td></form><form name="pageto" action="#" method="post">
						<td colspan="5" align="right">
							{{$language.all}}{{$total}}个{{$language.User}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}个/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) {window.location='admin.php?controller=admin_member&page='+this.value;return false;}else this.value=this.value;">{{$language.page}}
							
						</td></form>
					</tr>
					
				
		  
					<tr>
						
					</tr>
				</table>
			
	  </table>
		</td>
	  </tr>
	</table>
	<iframe name="hide" height="0" frameborder="0" scrolling="no" id="hide"></iframe>

</body>
</html>



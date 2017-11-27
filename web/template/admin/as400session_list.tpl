<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.SessionsList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function searchit(){
	var url = "admin.php?controller=admin_as400&backupdb_id={{$backupdb_id}}";
	url += "&addr="+document.search.elements.ip.value;
	url += "&user="+document.search.elements.user.value;
	url += "&start1="+document.search.elements.f_rangeStart.value;
	url += "&start2="+document.search.elements.f_rangeEnd.value;
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

function changeStyle(obj,c)
{
	if(c!='o'){
		obj.style.backgroundColor=c;
	}else{
		obj.style.backgroundColor="#FFCC80";
	}
}
</script>

<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#F1F1F1"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&backupdb_id={{$backupdb_id}}">Telnet/SSH</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_sftp&backupdb_id={{$backupdb_id}}">SFTP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_scp&backupdb_id={{$backupdb_id}}">SCP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_ftp&backupdb_id={{$backupdb_id}}">FTP</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
{{if $smarty.session.ADMIN_LEVEL ne 0}}
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_as400&backupdb_id={{$backupdb_id}}">AS400</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 
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

 <tr>
        <td >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content"><form action="admin.php?controller=admin_sqlserver&backupdb_id={{$backupdb_id}}" method="post" name="search" >
  <tr>
    <td></td>
    <td>
{{include file="select_sgroup_ajax.tpl" }}          
&nbsp;设备地址：<input type="text" class="wbk" name="ip"  size="13" />
用户：<input type="text" class="wbk" name="user" size="13" />&nbsp;
	
开始日期：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="" />
 <input type="button" onClick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">

 结束日期：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd" value="" />
 <input type="button" onClick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk">
	  &nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
</td>
  </tr></form> 
</table>
					
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d %H:%M:%S");


</script>
					</td>
  </tr>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
						<th class="list_bg"    width="5%"><a href="admin.php?controller=admin_as400&orderby1=cli_addr&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.SourceAddress}}</a></th>
						<th class="list_bg"    width="5%"><a href="admin.php?controller=admin_as400&orderby1=addr&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.DeviceAddress}}</a></th>
						<th class="list_bg"   width="5%"><a href="admin.php?controller=admin_as400&orderby1=user&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.User}}</a></th>
						<th class="list_bg"   width="7%"><a href="admin.php?controller=admin_as400&orderby1=start&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.StartTime}}</a></th>
						<th class="list_bg"  width="7%"><a href="admin.php?controller=admin_as400&orderby1=end&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.EndTime}}</a></th>
						<th class="list_bg"    width="19%">{{$language.Detail}}</th>
						
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $allsession[t].dangerous > 1}}bgcolor="red"{{elseif $allsession[t].dangerous > 0}}bgcolor="yellow" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}} onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'{{if $allsession[t].dangerous > 1}}red{{elseif $allsession[t].dangerous > 0}}yellow{{elseif $smarty.section.t.index % 2 == 0}}f7f7f7{{/if}}');">
						<td><a href="admin.php?controller=admin_as400&cli_addr={{$allsession[t].cli_addr}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].cli_addr}}</a></td>
						<td><a href="admin.php?controller=admin_as400&addr={{$allsession[t].addr}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].addr}}</a></td>
						<td><a href="admin.php?controller=admin_as400&user={{$allsession[t].user}}&backupdb_id={{$backupdb_id}}">{{$allsession[t].user}}</a></td>
						<td>{{$allsession[t].start}}</ td>
						<td>{{$allsession[t].end}}</td>
						<td style="TEXT-ALIGN: left;"><img src="{{$template_root}}/images/replay.gif" width="16" height="16" align="absmiddle">{{$language.Replay}}(<a href="#" onClick="window.open('admin.php?controller=admin_as400&action=replay&sid={{$allsession[t]['sid']}}','','menubar=no,toolbar=no,resizable=yes,height=700,width=700')">Web</a>|<a href="admin.php?controller=admin_as400&action=replay&sid={{$allsession[t]['sid']}}&tool=putty.Putty" target="hide" >putty</a> | <a href="admin.php?controller=admin_as400&action=replay&sid={{$allsession[t]['sid']}}&tool=securecrt.SecureCRT" target="hide" >securecrt</a>)&nbsp;| <img src="{{$template_root}}/images/file.gif" width="16" height="16" align="absmiddle"><a href="#" onclick=window.open("admin.php?controller=admin_as400&action=download&sid={{$allsession[t]['sid']}}&start_page=1")>{{$language.File}}</a>&nbsp;| <img src="{{$template_root}}/images/cmd.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_as400&action=view&sid={{$allsession[t]['sid']}}&cid={{$allsession[t].sub[g].parent_cmd}}&command={{$command}}&backupdb_id={{$backupdb_id}}">{{$language.View}}</a>
						&nbsp;&nbsp;<img src="{{$template_root}}/images/1-1.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_session&desc={{$allsession[t].desc}}&action=logindesc&type=as400&sessionid={{$allsession[t]['sid']}}" target="hide" ><font style="color:{{if $allsession[t].desc}}red{{else}}black{{/if}}">备注</font></a>
						{{if 0}} &nbsp;|  <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_as400&action=del_session&sid={{$allsession[t]['sid']}}">{{$language.Delete}}</a>{{/if}}
						
						</td>
					</tr>
						{{section name=g loop=$allsession[t].sub}}
							
							<tr {{if $smarty.section.g.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
									<td>子{{$language.Session}}</td>
									<td >{{$allsession[t].sub[g].addr}}</td>
									<td colspan=5>{{$allsession[t].sub[g].type}}</td>
									<td style="TEXT-ALIGN: left;">{{if !$backupdb_id}}<img src="{{$template_root}}/images/ico2.gif" width="16" height="16" align="absmiddle"><a href="#" onClick="window.open('admin.php?controller=admin_as400&action=replay&sid={{$allsession[t]['sid']}}&cid={{$allsession[t].sub[g].parent_cmd}}','','menubar=no,toolbar=no,resizable=yes,height=700,width=700')">{{$language.Replay}}</a>{{/if}}<img src="{{$template_root}}/images/ckico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_as400&action=view&sid={{$allsession[t]['sid']}}&cid={{$allsession[t].sub[g].parent_cmd}}">{{$language.View}}</a>{{if $admin_level == 2}} {{if !$backupdb_id}}| <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_as400&action=del_session&sid={{$allsession[t]['sid']}}">{{$language.Delete}}</a>{{/if}}{{/if}}</td>
								</tr>
						{{/section}}

					{{/section}}
					<tr>
						<td colspan="12" align="right">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">{{$language.page}} <!--当前数据表: {{$now_table_name}}--> 
						
						</td>
					</tr>
				</table>
	</td>
  </tr>
</table>

<script>
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>



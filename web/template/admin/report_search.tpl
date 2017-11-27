<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.LogList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
<script>
function setScroll(){
	window.parent.scrollTo(0,0);
}

function changelevel(val){
	var ldapid2 = document.getElementById('rtype2');
	ldapid2.options.length = 0;
	switch(val){
		case '1':
			ldapid2.options[ldapid2.options.length] = new Option('变更报表', 'admin_log_statistic');
		break;
		case '2':
			ldapid2.options[ldapid2.options.length] = new Option('登录统计报表', 'login_statistic');
			ldapid2.options[ldapid2.options.length] = new Option('授权明细', 'loginacct_statistic');
			ldapid2.options[ldapid2.options.length] = new Option('登录尝试', 'loginfailed_statistic');
			ldapid2.options[ldapid2.options.length] = new Option('系统登录报表', 'devlogin_statistic');
			ldapid2.options[ldapid2.options.length] = new Option('应用登录报表', 'applogin_statistic');
			ldapid2.options[ldapid2.options.length] = new Option('审批报表', 'loginapproved_statistic');
		break;
		case '3':
			ldapid2.options[ldapid2.options.length] = new Option('命令总计', 'command_statistic');
			ldapid2.options[ldapid2.options.length] = new Option('命令统计', 'cmdcache_statistic');
			ldapid2.options[ldapid2.options.length] = new Option('命令列表', 'cmdlist_statistic');
			ldapid2.options[ldapid2.options.length] = new Option('应用报表', 'app_statistic');
			ldapid2.options[ldapid2.options.length] = new Option('SFTP命令报表', 'sftpcmd_statistic');
			ldapid2.options[ldapid2.options.length] = new Option('FTP命令报表', 'ftpcmd_statistic');
		break;
		case '4':
			ldapid2.options[ldapid2.options.length] = new Option('告警统计', 'dangercmd_statistic');
			ldapid2.options[ldapid2.options.length] = new Option('告警操作', 'dangercmdlist_statistic');
		break;
	}
}

function changetype(val){
	var inputs = document.getElementsByTagName('input');
	for(var i=0; i<inputs.length; i++){
		if(inputs[i].type=='radio' && inputs[i].value==val){
			inputs[i].checked = true;
		}
	}
}

var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();
var alluser = new Array();
var allserver = new Array();
var i=0;
{{section name=au loop=$alluser}}
alluser[i++]={uid:{{$alluser[au].uid}},username:'{{$alluser[au].username}}',realname:'{{$alluser[au].realname}}',groupid:{{$alluser[au].groupid}},level:{{$alluser[au].level}}};
{{/section}}
var i=0;
{{section name=as loop=$allserver}}
allserver[i++]={hostname:'{{$allserver[as].hostname}}',device_ip:'{{$allserver[as].device_ip}}',groupid:{{$allserver[as].groupid}}};
{{/section}}

function change_usergroup(val){
	var user = document.getElementById('username');
	user.options.length=0;
	user.options[user.options.length]=new Option('全部', 0);
	for(var i=0; i< alluser.length; i++){
		if(alluser[i].groupid==val){
			user.options[user.options.length] = new Option(alluser[i].username+'('+alluser[i].realname+')', alluser[i].username);
		}
	}
}

function change_servergroup(val){
	var user = document.getElementById('server');
	user.options.length=0;
	user.options[user.options.length]=new Option('全部', 0);
	for(var i=0; i< alluser.length; i++){
		if(alluser[i].groupid==val){
			user.options[user.options.length] = new Option(allserver[i].device_ip+'('+allserver[i].hostname+')', allserver[i].device_ip);
		}
	}
}
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
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=report_search">定期报表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=report_search_diy">自定义报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>  
  <tr>
	<td class="">
<form method="get" name="session_search" action="admin.php?controller=admin_reports&action=doreport_search" >
<input type="hidden" name="controller" value="admin_reports" />
<input type="hidden" name="action" value="doreport_search" />
				<table bordercolor="white" cellspacing="0" cellpadding="0" border="0" width="100%"  class="BBtable">
				 <tr>
    <th class="list_bg" colspan="2"> </th>
  </tr>
					{{assign var="trnumber" value=0}}		
					<tr  {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td class="td_line" width="20%" align="right">报表类型：</td>
						<td class="td_line" width="80%">
						<select width="30"  class="wbk"  name="rtype1" id="rtype1" onchange="changelevel(this.value)" style="width:100px">
							<OPTION VALUE="1">权限报表</option>	
							<OPTION VALUE="2">登录报表</option>
							<OPTION VALUE="3">操作报表</option>
							<OPTION VALUE="4">告警报表</option>
						</select>
						&nbsp;&nbsp;<select width="30" class="wbk"  name="type" id="rtype2" style="width:100px">
						</select>
						</td>
					</tr>
					<tr  {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td class="td_line" width="20%" rowspan="3" align="right" >时间选择：</td>
						<td class="td_line" width="80%">
							按月：<input name="dateinterval" type="radio" class="wbk" checked onclick="changetype('month')" value="month">
							&nbsp;&nbsp;年:<select width="30" class="wbk" onclick="changetype('month')"  name="myear" style="width:100px">
							{{section name=my loop=$years}}
							<option value={{$years[my]}}>{{$years[my]}}</option>
							{{/section}}
							</select>
							&nbsp;&nbsp;月:<select width="30" class="wbk" onclick="changetype('month')"  name="mmonth" style="width:100px">
							{{section name=mm loop=12}}
							<option value={{$smarty.section.mm.index+1}}>{{$smarty.section.mm.index+1}}</option>
							{{/section}}
							</select>
						</td>
					</tr>
					<tr >					
						<td class="td_line" width="80%">
							按周：<input name="dateinterval" type="radio" class="wbk" value="week">
							&nbsp;&nbsp;年:<select width="30" class="wbk" onclick="changetype('week')"  name="wyear" style="width:100px">
							{{section name=wy loop=$years}}
							<option value={{$years[wy]}}>{{$years[wy]}}</option>
							{{/section}}
							</select>
							&nbsp;&nbsp;月:<select width="30" class="wbk" onclick="changetype('week')"  name="wmonth" style="width:100px">
							{{section name=wm loop=12}}
							<option value={{$smarty.section.wm.index+1}}>{{$smarty.section.wm.index+1}}</option>
							{{/section}}
							</select>
							&nbsp;&nbsp;第:<select width="30" class="wbk" onclick="changetype('week')" name="wweek" style="width:100px">
							{{section name=ww loop=5}}
							<option value={{$smarty.section.ww.index+1}}>{{$smarty.section.ww.index+1}}</option>
							{{/section}}
							</select>周
						</td>
					</tr>
					<tr>					
						<td class="td_line" width="80%">
							按日：<input name="dateinterval" type="radio" class="wbk" value="day">
							&nbsp;&nbsp;<input type="text" class="wbk" onclick="changetype('day')" name="dday" size="16" id="f_rangeStart" value="{{$f_rangeStart|date_format:'%Y-%m-%d'}}" />
							<input type="button" onclick="changetype('day')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="{{$language.Edittime}}"  class="wbk">
						</td>
					</tr>
					<tr  {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td class="td_line" width="20%" align="right">用户组/用户：</td>
						<td class="td_line" width="80%">
		{{assign var=select_group_id value='groupid'}}
		{{assign var=changegroup value='change_usergroup(this.value)'}}
		{{include file="select_sgroup_ajax.tpl" }}  
		&nbsp;&nbsp;用户:<select style="width:150px;" class="wbk"  name="username" id="username" >
                        {{if $smarty.session.ADMIN_LEVEL eq 1}}
							<option value="" >无</option>
						{{/if}}
                     	{{section name=u loop=$alluser}}
						<option value="{{$alluser[u].username}}" >{{$alluser[u].username}}</option>
						{{/section}}
              </SELECT>   
						</td>
					</tr>
					<tr  {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td class="td_line" width="20%" align="right">设备组/设备：</td>
						<td class="td_line" width="80%">
		{{assign var=select_group_id value='sgroupid'}}
		{{assign var=changegroup value='change_servergroup(this.value)'}}
		{{include file="select_sgroup_ajax.tpl" }}    
		&nbsp;&nbsp;设备:<select style="width:150px;" class="wbk"  name="server" id="server" >
                        {{if $smarty.session.ADMIN_LEVEL eq 1}}
							<option value="" >无</option>
						{{/if}}
                     	{{section name=s loop=$allserver}}
						<option value="{{$allserver[s].device_ip}}" >{{$allserver[s].device_ip}}</option>
						{{/section}}
              </SELECT> 
						</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" colspan="2" align="center"><input name="submit" type="submit" onclick="setScroll();"  value="{{$language.Search}}" class="an_02">
					</tr>
				</table>
				
			</form>
	</td>
  </tr>
</table>

  <script type="text/javascript">
  
{{if $_config.LDAP}}
{{$changelevelstr}}
{{$schangelevelstr}}
{{/if}}
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: false
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d");
</script>
<script>
changelevel('1');
</script>


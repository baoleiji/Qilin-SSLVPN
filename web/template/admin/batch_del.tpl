<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.LogList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
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
var servergroup = new Array();
var i=0;
{{section name=a loop=$allgroup}}
servergroup[i++]={id:{{$allgroup[a].id}},name:'{{$allgroup[a].groupname}}',ldapid:{{$allgroup[a].ldapid}},level:{{$allgroup[a].level}}};
{{/section}}
var servers = new Array();
var j=0;
{{section name=as loop=$servers}}
servers[j++]={ip:'{{$servers[as].device_ip}}', groupid:{{$servers[as].groupid}}};
{{/section}}

function changelevel(v, d){
	document.getElementById('ldapid2').options.length=0;
	document.getElementById('groupid').options.length=0;
	document.getElementById('ldapid2').options[document.getElementById('ldapid2').options.length]=new Option('无', 0);
	document.getElementById('groupid').options[document.getElementById('groupid').options.length]=new Option('无', 0);
	var found = 0;
	var class2_i = 0;
	var class2 = new Array();
	
	for(var i=0; i<servergroup.length; i++){
		if(servergroup[i].ldapid==v&& servergroup[i].level==2){
			if(d==servergroup[i].id){
				found = 1;
				document.getElementById('ldapid2').options[document.getElementById('ldapid2').options.length]=new Option(servergroup[i].name, servergroup[i].id, true, true);
			}else{				
				document.getElementById('ldapid2').options[document.getElementById('ldapid2').options.length]=new Option(servergroup[i].name, servergroup[i].id);
			}
			class2[class2_i++]=i;
		}
		if(servergroup[i].ldapid==v&& servergroup[i].level==0){
			if(d==servergroup[i].id){
				found = 1;
				document.getElementById('groupid').options[document.getElementById('groupid').options.length]=new Option(servergroup[i].name, servergroup[i].id, true, true);
			}else{				
				document.getElementById('groupid').options[document.getElementById('groupid').options.length]=new Option(servergroup[i].name, servergroup[i].id);
			}
		}
	}	

	var found = 0;
	for(var j=0; j<class2.length; j++){
		for(var i=0; i<servergroup.length; i++){
			if(servergroup[i].ldapid==servergroup[class2[j]].id&& servergroup[i].level==0){
				if(d==servergroup[i].id){
					found = 1;
					document.getElementById('groupid').options[document.getElementById('groupid').options.length]=new Option(servergroup[i].name, servergroup[i].id, true, true);
				}else{				
					document.getElementById('groupid').options[document.getElementById('groupid').options.length]=new Option(servergroup[i].name, servergroup[i].id);
				}
			}
		}
	}
	//changelevel2(found,0);
}

function changelevel2(v, d){
	document.getElementById('groupid').options.length=0;
	document.getElementById('groupid').options[document.getElementById('groupid').options.length]=new Option('无', 0);
	if(v!=0){
		for(var i=0; i<servergroup.length; i++){
			if(servergroup[i].ldapid==v&& servergroup[i].level==0){
				if(d==servergroup[i].id){
					found = 1;
					document.getElementById('groupid').options[document.getElementById('groupid').options.length]=new Option(servergroup[i].name, servergroup[i].id, true, true);
				}else{				
					document.getElementById('groupid').options[document.getElementById('groupid').options.length]=new Option(servergroup[i].name, servergroup[i].id);
				}
			}
		}
	}else{
		changelevel(document.getElementById('ldapid1').options[document.getElementById('ldapid1').options.selectedIndex].value, d);
	}
}

function changegroup(groupid){
	var serverObj = document.getElementById('serverlist');
	serverObj.options.length=0;
	for(var i=0; i<servers.length; i++){
		if(servers[i].groupid==groupid){
			serverObj.options[serverObj.options.length]=new Option(servers[i].ip, servers[i].ip, true, true);
		}
	}
	checkall('serverlist');
}

function checkall(selectID){
	var obj = document.getElementById(selectID);
	var len = obj.options.length;
	for(var i=0; i<len; i++){
		obj.options[i].selected = true;
	}
	return true;
}
</script>
<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&action=batch_del&backupdb_id={{$backupdb_id}}">日志删除</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&action=autodelete&backupdb_id={{$backupdb_id}}">自动删除</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul></div></td></tr>
  <tr>
	<td class="">
		<form method="post" name="session_search" action="admin.php?controller=admin_session&action=batch_del" enctype="multipart/form-data">
			<table bordercolor="white" cellspacing="0" cellpadding="0" border="0" width="98%"  class="BBtable">
				
				<tr bgcolor="f7f7f7"> 
					<td class="td_line" valign="top">{{$language.Search}}{{$language.Session}}{{$language.Content}}</td>
					<td>
						<input type="checkbox" name="ssh" value="admin_session" > telnet/ssh{{$language.Session}}<br />
						<input type="checkbox" name="rdp" value="admin_rdp" > rdp{{$language.Session}}<br />		
						<input type="checkbox" name="ftp" value="admin_ftp" > Ftp{{$language.Session}}<br />
						<input type="checkbox" name="sftp" value="admin_sftp" > SFtp{{$language.Session}}<br />
						<input type="checkbox" name="as400" value="admin_sftp" > AS400{{$language.Session}}<br />
						<input type="checkbox" name="apppub" value="admin_apppub" > 应用{{$language.Session}}<br />
						<input type="checkbox" name="vnc" value="admin_vnc" > VNC{{$language.Session}}<br />
						<input type="checkbox" name="loginacct" value="loginacct" > 登录记录<br /><br />
					</td>
					<td class="td_line" width="70%">
						一级目录:<select width="30"  class="wbk"  name="ldapid1" id="ldapid1" onchange="changelevel(this.value,0)" style="width:100px">
								<OPTION VALUE="0">无</option>
						{{section name=g loop=$allgroup}}
							{{if $sgroup.id ne $allgroup[g].id}}
							{{if $allgroup[g].level eq 1 }}
							<OPTION VALUE="{{$allgroup[g].id}}" {{if $allgroup[g].id == $sgroup.ldapid}}selected{{/if}}>{{$allgroup[g].groupname}}</option>
							{{/if}}
							{{/if}}
						{{/section}}
						</select>
						二级目录<select width="30" class="wbk"  name="ldapid2" id="ldapid2" onchange="changelevel2(this.value,0)" style="width:100px">
						</select>
						设备组		<select  class="wbk"  name="groupid" id="groupid" onchange="changegroup(this.value)"  style="width:150px">
								<option value="0" >所有</option>
						{{section name=g loop=$allgroup}}
						{{if $allgroup[g].ldapid eq 0 and $allgroup[g].level eq 0}}
							<OPTION VALUE="{{$allgroup[g].id}}" {{if $allgroup[g].id == $groupid}}selected{{/if}}>{{$allgroup[g].groupname}}</option>
						{{/if}}
						{{/section}}
						</select><br />
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select  class="wbk"  name="device_ip[]" id="serverlist" size="7" style="width:140px;height:110px;" multiple="multiple">
						{{section name=s loop=$servers}}
						<option value="{{$servers[s].device_ip}}" selected>{{$servers[s].device_ip}}</option>
						{{/section}}
						</select>
					</td>
				</tr>
			
				<tr bgcolor="f7f7f7">
					<td class="td_line" width="10%">{{$language.StartTime}}：</td>
					<td class="td_line" width="70%" colspan="2">{{$language.from}}：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="" class="wbk"/>&nbsp;&nbsp;<input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="bnnew2"> {{$language.to}}<input type="text" class="wbk" name="f_rangeStart2" id="f_rangeStart2" value="" />&nbsp;&nbsp;<input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger2" name="f_rangeStart_trigger2" value="选择时间" class="bnnew2"></td>
				</tr>
				
				<tr>
					<td class="td_line" colspan="3" align="center"><input name="submit" type="submit" class="an_02" onclick="return confirm('确定删除?')" value="删除"></td>
				</tr>
			</table>
			<input type="hidden" name="ac" value="del" />
		</form>
	</td>
  </tr>
</table>
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeStart_trigger2", "f_rangeStart2", "%Y-%m-%d %H:%M:%S");
//checkall('serverlist');
</script>



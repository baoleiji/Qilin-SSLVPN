<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<script language="javascript">
	function check_add_user(){
		return(true);
	}


{{if $_config.LDAP}}
var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();

{{/if}}
{{*
var AllMember = new Array();
i=0;
{{section name=kk loop=$users}}
AllMember[{{$smarty.section.kk.index}}] = new Array();
AllMember[{{$smarty.section.kk.index}}]['username']='{{$users[kk].username}}';
AllMember[{{$smarty.section.kk.index}}]['realname']='{{$users[kk].realname}}';
AllMember[{{$smarty.section.kk.index}}]['uid']='{{$users[kk].uid}}';
AllMember[{{$smarty.section.kk.index}}]['groupid']='{{$users[kk].groupid}}';
AllMember[{{$smarty.section.kk.index}}]['check']='{{$users[kk].check}}';
{{/section}}
*}}
function enablepri(c, item){
	c=!c;//alert(item);
	switch(item){
		case 'usergroup':
			document.getElementById('groupiddh').disabled=c;
			break;
		case 'start_time':
			document.getElementById('start_time').disabled=c;
			document.getElementById('f_rangeStart_trigger').disabled=c;
			break;
		case 'limit_time':
			document.getElementById('limit_time').disabled=c;
			document.getElementById('f_rangeEnd_trigger').disabled=c;
			document.getElementById('nolimit').disabled=c;
			break;
		case 'ipv4':
			document.getElementById('sourceip').disabled=c;
			break;
		case 'ipv6':
			document.getElementById('sourceipv6').disabled=c;
			break;
		case 'enable':
			document.getElementById('enable').disabled=c;
			break;
		case 'weektime':
			document.getElementById('weektime').disabled=c;
			break;
		case 'restrictweb':
			document.getElementById('restrictweb').disabled=c;
			break;
		case 'apphost':
			document.getElementById('apphost').disabled=c;
			break;
		case 'loginauth':
			document.getElementById('localauth').disabled=c;
			document.getElementById('radiusauth').disabled=c;
			document.getElementById('ldapauth').disabled=c;
			document.getElementById('adauth').disabled=c;
			document.getElementById('auth').disabled=c;
			document.getElementById('authtype').disabled=c;
			break;
		case 'rdpclipboard':
			document.getElementById('rdpclipauth_up').disabled=c;
			document.getElementById('rdpclipauth_down').disabled=c;
			break;
		case 'rdpdiskauth_up':
			document.getElementById('rdpdiskauth_up').disabled=c;
			break;
		case 'rdpdisk':
			document.getElementById('rdpdisk').disabled=c;
			break;
		case 'allowchange':
			document.getElementById('allowchange').disabled=c;
			break;
		case 'rdplocal':
			document.getElementById('rdplocal').disabled=c;
			break;
		case 'passwordsave':
			document.getElementById('passwordsave').disabled=c;
			break;
		case 'default_control':
			document.getElementById('default_control').disabled=c;
			break;
		case 'rdplocalcheck':
			document.getElementById('rdplocalcheck').disabled=c;
			break;
		case 'default_appcontrol':
			document.getElementById('default_appcontrol').disabled=c;
			break;
		case 'firstauth':
			document.getElementById('firstauth').disabled=c;
			break;
		case 'apptoadmingroup':
			document.getElementById('apptoadmingroup').disabled=c;
			break;
		case 'apptodisk':
			document.getElementById('apptodisk').disabled=c;
			break;
		case 'webportal':
			document.getElementById('webportal').disabled=c;
			document.getElementById('webportaltime').disabled=c;
			break;
		case 'asyncoutpass':
			document.getElementById('asyncoutpass').disabled=c;
			break;
		case 'tranportauth':
			document.getElementById('tranportauth').disabled=c;
			break;
	}
}


var groupid='{{$servergroup}}';
function filteruser(){	
	var username = document.getElementById('username').value;
	var gid=0;
	{{if $_config.LDAP}}
	{{if $_config.TREEMODE}}
	var obj1=document.getElementById('sgroupid');	
	gid=obj1.value;
	{{else}}
	for(var i=1; true; i++){
		var obj=document.getElementById('sgroupid'+i);
		if(obj!=null&&obj.options.selectedIndex>-1){
			gid=obj.options[obj.options.selectedIndex].value;
			continue;
		}
		break;
	}
	{{/if}}
	{{/if}}
	prefgroupid=gid;
	var url = 'admin.php?controller=admin_member&action=batchpriorityedit&sgroupid='+gid+"&username="+username;
	var checks = document.getElementsByTagName('input');
	for(var i=0; i<checks.length; i++){
		if(checks[i].name=='uid[]'&&checks[i].checked){
			url += '&uid[]='+checks[i].value;
		}
	}
	window.location=url;
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
 <SCRIPT language=javascript src="{{$template_root}}/images/selectdate.js"></SCRIPT>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu" style="width:1100px;">
<ul> 
	
</ul><span class="back_img"><A href="admin.php?controller=admin_member&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td align="center"><form name="f1" method=post action="admin.php?controller=admin_member&action=batchpriorityeditsave&chk_member={{$usersid}}" enctype="multipart/form-data" onsubmit="return confirm('确定操作?');">
	<table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr><td colspan="5" align=center><div style="text-align:left;width:500px;">过滤用户：<input type="text" name="username" id="username" >&nbsp;
		{{assign var=select_group_id value='sgroupid'}}
		{{include file="select_sgroup_ajax.tpl" }} 
		&nbsp;<input type="button" onclick="filteruser();" value="提交" ></div></td></tr>
    {{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="loginmodetr">
		<td width="3%" align="center">
		权限
		</td>
		<td width="97%">
		<table width="100%">
		 <TR bgcolor="#f7f7f7">
            <TD align="left"><input type="checkbox" name="enable[]" value="usergroup" onclick="enablepri(this.checked,'usergroup');" >&nbsp;运维组： </TD>
            <TD >
		{{assign var=select_ladp_id value='ldapid'}}
		{{assign var=select_group_id value='groupid'}}
		{{include file="select_sgroup_ajax.tpl" }}       </TD>
		<td><input type="checkbox" name="enable[]" value="enable" onclick="enablepri(this.checked,'enable');" >&nbsp;启用：</td><td><input type="checkbox" name="_enable" id="enable" value="1" {{if $member.enable || !$member.uid }}checked{{/if}}></td>
           
          </TR>
           <TR bgcolor="">
      <TD align="left"><input type="checkbox" name="enable[]" value="start_time" onclick="enablepri(this.checked,'start_time');" >&nbsp;生效时间： </TD>
      <TD><INPUT value="{{$member.start_time}}" id="start_time" name="start_time" >&nbsp;&nbsp;
<input type="button"  id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">
      </TD>
      <TD align="left"><input type="checkbox" name="enable[]" value="limit_time" onclick="enablepri(this.checked,'limit_time');" >&nbsp;过期时间：</TD>
      <TD><INPUT value="{{if $member.end_time ne '2037-01-01 00:00:00'}}{{$member.end_time}}{{/if}}" id="limit_time" name="limit_time" onFocus="setday(this)">&nbsp;&nbsp;<input type="button"  id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk"> 
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true,
	popupDirection:'down'
});
var cal2 = Calendar.setup({
    onSelect: function(cal2) { cal2.hide() },
    showTime: true,
	popupDirection:'down'
});
cal.manageFields("f_rangeStart_trigger", "start_time", "%Y-%m-%d %H:%M:%S");
cal2.manageFields("f_rangeEnd_trigger", "limit_time", "%Y-%m-%d %H:%M:%S");


</script>
                      {{$language.AlwaysValid}}<INPUT value="1" {{if $member.end_time eq '2037-01-01 00:00:00' or !$member.end_time}} checked {{/if}} onclick="document.getElementById('limit_time').value=''" type=checkbox name="nolimit" id="nolimit"> 
      </TD>
    </TR>
	<TR bgcolor="#f7f7f7" style="display:none">
	 <TD align="left"><input type="checkbox" name="enable[]" value="ipv4" onclick="enablepri(this.checked,'ipv4');" >&nbsp;来源IPv4：</TD>
      <TD><select  class="wbk"  name=sourceip id=sourceip>
                      <OPTION value="">{{$language.no}}</OPTION>
                     	{{section name=t loop=$sourceip}}
						{{if !$sourceip[t].ipv6}}
				<option value="{{$sourceip[t].groupname}}" {{if $sourceip[t].groupname == $member.sourceip}}selected{{/if}}>{{$sourceip[t].groupname}}</option>
						{{/if}}
			{{/section}}
                  </SELECT>  &nbsp;&nbsp;&nbsp;
      </TD>
      <TD align="left"><input type="checkbox" name="enable[]" value="ipv6" onclick="enablepri(this.checked,'ipv6');" >&nbsp;来源IPv6：</TD>
      <TD><select  class="wbk"  name=sourceipv6 id=sourceipv6>
                      <OPTION value="">{{$language.no}}</OPTION>
                     	{{section name=t loop=$sourceip}}
						{{if $sourceip[t].ipv6}}
				<option value="{{$sourceip[t].groupname}}" {{if $sourceip[t].groupname == $member.sourceipv6}}selected{{/if}}>{{$sourceip[t].groupname}}</option>
						{{/if}}
			{{/section}}
                  </SELECT></TD>
     
    </TR>
	<TR bgcolor="" style="display:none">
      <TD align="left"><input type="checkbox" name="enable[]" value="weektime" onclick="enablepri(this.checked,'weektime');" >&nbsp;周组策略：</TD>
      <TD><select  class="wbk" id=weektime name=weektime>
                      <OPTION value="">{{$language.no}}</OPTION>
                     	{{section name=k loop=$weektime}}
				<option value="{{$weektime[k].policyname}}" {{if $weektime[k].policyname == $member.weektime}}selected{{/if}}>{{$weektime[k].policyname}}</option>
			{{/section}}
                  </SELECT> </TD>
				  
      <TD align="left"><input type="checkbox" name="enable[]" value="asyncoutpass" onclick="enablepri(this.checked,'asyncoutpass');" >&nbsp;同步外部密码：</TD>
      <TD><select  class="wbk" id=asyncoutpass name=asyncoutpass>
		<OPTION value="-1" {{if -1 eq $member.asyncoutpass}}selected{{/if}}>关闭</OPTION>
		{{section name=asyn loop=11}}
		<OPTION value="{{$smarty.section.asyn.index}}" {{if $smarty.section.asyn.index eq $member.asyncoutpass}}selected{{/if}}>{{$smarty.section.asyn.index}}</OPTION>
		{{/section}}
                  </SELECT></TD>
    </TR>

	<TR bgcolor="#f7f7f7" style="display:none">
      <TD align="left"><input type="checkbox" name="enable[]" value="apphost" onclick="enablepri(this.checked,'apphost');" >&nbsp;显示应用发布IP：</TD>
      <TD><input type="checkbox" id="apphost" name="apphost" value="1" {{if $member.apphost}}checked{{/if}}></TD>
       <TD align="left"><input type="checkbox" name="enable[]" value="loginauth" onclick="enablepri(this.checked,'loginauth');" >&nbsp;认证方式</TD>
            <TD><input type="checkbox" name="localauth" id="localauth" class="" value="1" {{if $member.localauth}}checked{{/if}}>认证&nbsp;&nbsp;<input type="checkbox" id="radiusauth" name="radiusauth" class="" value="1" {{if $member.radiusauth}}checked{{/if}}>RADIUS&nbsp;&nbsp;<input type="checkbox" name="ldapauth" id="ldapauth" class="" value="1" {{if $member.ldapauth}}checked{{/if}}>LDAP&nbsp;&nbsp;<input type="checkbox" name="adauth" id="adauth" class="" value="1" {{if $member.adauth}}checked{{/if}}>AD&nbsp;&nbsp;<input type="checkbox" name="auth" id="auth" class="" value="2" {{if $member.auth eq 2}}checked{{/if}}>短信&nbsp;&nbsp;<select name="authtype" id="authtype" ><option value="0" {{if !$member.authtype}}selected{{/if}}>单一认证</option><option value="1" {{if $member.authtype}}selected{{/if}}>组合认证</option></select></TD>
    </TR>
     <TR style="display:none">
      <TD align="left" bordercolor="white"><input type="checkbox" name="enable[]" value="rdpclipboard" onclick="enablepri(this.checked,'rdpclipboard');" >&nbsp;RDP剪贴版</TD>
      <TD bordercolor="white">上行：<input type="checkbox" name="rdpclipauth_up" id="rdpclipauth_up" class="" value="1" {{if $member.rdpclipauth_up or !$member.uid}}checked{{/if}}>&nbsp;&nbsp;&nbsp;&nbsp;下行：<input type="checkbox" name="rdpclipauth_down" id="rdpclipauth_down" class="" value="1" {{if $member.rdpclipauth_down or !$member.uid}}checked{{/if}}>
      </TD>
      <TD align="left" bordercolor="white"><input type="checkbox" name="enable[]" value="rdpdiskauth_up" onclick="enablepri(this.checked,'rdpdiskauth_up');" >&nbsp;RDP磁盘：</TD>
      <TD bordercolor="white"><input type="checkbox" name="rdpdiskauth_up" id="rdpdiskauth_up" class="" value="1" {{if $member.rdpdiskauth_up or !$member.uid}}checked{{/if}}>
       </TD>
    </TR>
    <TR bgcolor="#f7f7f7" style="display:none">
      <TD align="left"><input type="checkbox" name="enable[]" value="rdpdisk" onclick="enablepri(this.checked,'rdpdisk');" >&nbsp;RDP磁盘映射：</TD>
      <TD><input type="text" name="rdpdisk" id="rdpdisk" class="input_shorttext" value="{{if !$member.uid}}*{{else}}{{$member.rdpdisk}}{{/if}}">例子C:;D:;E:;</TD>
      <TD align="left"><input type="checkbox" name="enable[]" value="allowchange" onclick="enablepri(this.checked,'allowchange');" >&nbsp;允许改密：</TD>
      <TD><input type="checkbox" id="allowchange" name="allowchange" value="1" {{if $member.allowchange}}checked{{/if}}> </TD>
    </TR>
	 <TR style="display:none">
      <TD align="left"><input type="checkbox" name="enable[]" value="rdplocal" onclick="enablepri(this.checked,'rdplocal');" >&nbsp;rdp本地：</TD>
      <TD><input type="checkbox" name="rdplocal" id="rdplocal" value="1" {{if $member.rdplocal }}checked{{/if}}></TD>
      <TD align="left"><input type="checkbox" name="enable[]" value="passwordsave" onclick="enablepri(this.checked,'passwordsave');" >&nbsp;系统用户名缓存：</TD>
      <TD><input type="checkbox" name="passwordsave" id="passwordsave" value="1" {{if $member.passwordsave}}checked{{/if}}></TD>
    </TR>
    <TR bgcolor="#f7f7f7" style="display:none">
      <TD align="left" bordercolor="white"><input type="checkbox" name="enable[]" value="default_control" onclick="enablepri(this.checked,'default_control');" >&nbsp;默认控件： </TD>
      <TD bordercolor="white"><select  class="wbk"  name=default_control id=default_control>
                     <OPTION value="0" {{if $member.default_control eq 0}}selected{{/if}}>自动检测</OPTION>
                     <OPTION value="1" {{if $member.default_control eq 1}}selected{{/if}}>applet</OPTION>
                     <OPTION value="2" {{if $member.default_control eq 2}}selected{{/if}}>activeX</OPTION>
                  </SELECT> &nbsp;&nbsp;
      </TD>
      <TD align="left" bordercolor="white"> <input type="checkbox" name="enable[]" value="rdplocalcheck" onclick="enablepri(this.checked,'rdplocalcheck');" >&nbsp;默认RDP本地</TD>
      <TD bordercolor="white"><input type="checkbox" id="rdplocalcheck" name="rdplocalcheck" value="1" {{if $member.rdplocalcheck}}checked{{/if}}>
      </TD>
    </TR>
    <TR style="display:none">
	
      <TD align="left"><input type="checkbox" name="enable[]" value="default_appcontrol" onclick="enablepri(this.checked,'default_appcontrol');" >&nbsp;应用发布默认控件：</TD>
      <TD><select  class="wbk"  name=default_appcontrol id="default_appcontrol">
                     <OPTION value="0" {{if $member.default_appcontrol eq 0}}selected{{/if}}>WEB</OPTION>
                     <OPTION value="1" {{if $member.default_appcontrol eq 1}}selected{{/if}}>RDP</OPTION>
                  </SELECT>  &nbsp;&nbsp;&nbsp;
      </TD>
      <TD align="left"><input type="checkbox" name="enable[]" value="restrictweb" onclick="enablepri(this.checked,'restrictweb');" >&nbsp;限制工具登录：</TD>
      <TD><input type="checkbox" name="restrictweb" id="restrictweb" value="1" {{if $member.restrictweb}}checked{{/if}}> 
      </TD>
	   </TR>
	    <TR bgcolor="#f7f7f7" style="display:none">	
      <TD align="left"><input type="checkbox" name="enable[]" value="firstauth" onclick="enablepri(this.checked,'firstauth');" >&nbsp;优先登录方式:</TD>
      <TD>
	<select  class="wbk"  name=firstauth id=firstauth >
                     <OPTION value="localauth" {{if $member.firstauth eq 'localauth'}}selected{{/if}}>本地登录</OPTION>
                     <OPTION value="radiusauth" {{if $member.firstauth eq 'radiusauth'}}selected{{/if}}>RADIUS</OPTION>
{{section name=l loop=$ldaps}}
<option value='ldapauth_{{$ldaps[l].address}}' {{if $member.firstauth eq 'ldapauth_'|cat:$ldaps[l].address}}selected{{/if}}>LDAP {{$ldaps[l].domain}}</option>
{{/section}}
{{section name=a loop=$ads}}
<option value='adauth_{{$ads[a].address}}' {{if $member.firstauth eq 'adauth_'|cat:$ads[a].address}}selected{{/if}}>AD {{$ads[a].domain}}</option>
{{/section}}
                  </SELECT>     
      </TD>
      <TD align="left"><input type="checkbox" name="enable[]" value="apptoadmingroup" onclick="enablepri(this.checked,'apptoadmingroup');" >&nbsp;应用发布用户为管理员:</TD>
      <TD><input type="checkbox" id="apptoadmingroup" name="apptoadmingroup" value="1" {{if $member.apptoadmingroup}}checked{{/if}}>
      </TD>
	   </TR>
	    <TR bgcolor="" style="display:none">	
      <TD align="left"><input type="checkbox" name="enable[]" value="apptodisk" onclick="enablepri(this.checked,'apptodisk');" >&nbsp;应用发布进入桌面:</TD>
      <TD><input type="checkbox" id="apptodisk" name="apptodisk" value="1" {{if $member.apptodisk}}checked{{/if}}>
      </TD>
      <TD align="left"><input type="checkbox" name="enable[]" value="webportal" onclick="enablepri(this.checked,'webportal');" >&nbsp;WEBportal认证：</TD>
      <TD>启用：<input type="checkbox" id="webportal" name="webportal" value="1" {{if $member.webportal}}checked{{/if}}>&nbsp;&nbsp;&nbsp;Webportal超时时间：<input type="text" id="webportaltime" name="webportaltime" class="input_shorttext" value="0" style="width:100px">分钟
      </TD>
	   </TR>
	   <TR bgcolor="#f7f7f7" style="display:none">	
      <TD align="left"><input type="checkbox" name="enable[]" value="tranportauth" onclick="enablepri(this.checked,'tranportauth');" >&nbsp;透明登录:</TD>
      <TD>
	<select  class="wbk"  name=tranportauth id=tranportauth >
                     <OPTION value="1" {{if $member.tranportauth eq '1'}}selected{{/if}}>本地</OPTION>
                     <OPTION value="2" {{if !$member.tranportauth or $member.tranportauth eq '2'}}selected{{/if}}>RADIUS</OPTION>
                     <OPTION value="3" {{if $member.tranportauth eq '3'}}selected{{/if}}>LDAP</OPTION>
                  </SELECT>     
      </TD>
      <TD align="left"></TD>
      <TD>
      </TD>
	   </TR>
		</table>
		
	  </td>
	</tr>
	
	<tr><td colspan="5" align=center>
	
	</td></tr>
		{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="10%"  align="center"  valign=top>
		{{$language.bind}}{{$language.User}}
		<table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;"><input type="button" name='batchselect' class="an_06" value="批量选择" onclick="window.open('admin.php?controller=admin_pro&action=xzuser', 'newwindow','height=650, width=700, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');" ></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">全选<input type="checkbox" value=2 onclick="checkAll(this.checked);"></td></tr>
	  </table>
		</td>
		<td width="90%">
		<table><tr >
		{{section name=g loop=$users}}
		<td width="150"><input type="checkbox" name='uid[]' value='{{$users[g].uid}}'  {{$users[g].check}}>{{$users[g].username}}({{if $users[g].realname}}{{$users[g].realname}}{{else}}未设置{{/if}}){{if $users[g].binded}}</font>{{/if}}</td>{{if ($smarty.section.g.index +1) % 6 == 0}}</tr><tr>{{/if}}
		{{/section}}
		</tr></table>
	  </td>
	  </tr>
	 
	<tr><td colspan="2" align="center"><input type=submit name="submit"  value="批量导出" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name="submit"  value="批量删除" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name="submit"  value="批量锁定" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name="submit"  value="{{$language.Save}}" class="an_02"></td></tr></table>
</form>
	</td>
  </tr>
  <tr><td colspan="2" height="25"></td></tr>
</table>
</body>
<script>
function checkAll(c){
	var targets = document.getElementsByTagName('input');
	for(var j=0; j<targets.length; j++){
		if(targets[j].name.substring(0,3)=='uid'){
			targets[j].checked=c;
		}
	}
}

enablepri(false, 'usergroup');
enablepri(false, 'start_time');
enablepri(false, 'limit_time');
enablepri(false, 'ipv4');
enablepri(false, 'ipv6');
enablepri(false, 'enable');
enablepri(false, 'weektime');
enablepri(false, 'restrictweb');
enablepri(false, 'apphost');
enablepri(false, 'loginauth');
enablepri(false, 'rdpclipboard');
enablepri(false, 'rdpdiskauth_up');
enablepri(false, 'rdpdisk');
enablepri(false, 'allowchange');
enablepri(false, 'rdplocal');
enablepri(false, 'passwordsave');
enablepri(false, 'default_control');
enablepri(false, 'rdplocalcheck');
enablepri(false, 'default_appcontrol');
enablepri(false, 'firstauth');
enablepri(false, 'apptoadmingroup');
enablepri(false, 'apptodisk');
enablepri(false, 'webportal');
enablepri(false, 'asyncoutpass');
enablepri(false, 'tranportauth');
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




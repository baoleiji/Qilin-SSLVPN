<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
 <SCRIPT language=javascript src="{{$template_root}}/images/selectdate.js"></SCRIPT>
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

var siteUrl = "{{$template_root}}/images/date";
	function check_add_user(){
		return(true);
	}


	/**选中的元素向右移动**/
 	function moveRight()
	{
		
			//得到第一个select对象
		var selectElement = document.getElementById("first");
		var optionElements = selectElement.getElementsByTagName("option");
		var len = optionElements.length;
		var selectElement2 = document.getElementById("secend");

		if(!(selectElement.selectedIndex==-1))   //如果没有选择元素，那么selectedIndex就为-1
		{
			
			//得到第二个select对象
			
	
				// 向右移动
				for(var i=0;i<len ;i++)
				{
					if(selectElement.selectedIndex>=0)
					selectElement2.appendChild(optionElements[selectElement.selectedIndex]);
				}
				changed = true;
		} else
		{
			alert("您还没有选择需要移动的元素！");
		}
	}
	

	
	//移动选中的元素到左边
	function moveLeft()
	{
		//首先得到第二个select对象
		var selectElement = document.getElementById("secend");
		
		var optionElement = selectElement.getElementsByTagName("option");
		var len = optionElement.length;
		var firstSelectElement = document.getElementById("first");
		
		
		//再次得到第一个元素
		if(!(selectElement.selectedIndex==-1))
		{
			
			for(i=0;i<len;i++)
			{
				if(selectElement.selectedIndex>=0)
					firstSelectElement.appendChild(optionElement[selectElement.selectedIndex]);//被选中的那个元素的索引
			}
			changed = true;
		}else
		{
			alert("您还没有选中要移动的项目!");
		}
	}

function enablepri(c, item){
	c=!c;//alert(item);
	switch(item){
		case 'l_id':
			document.getElementById('l_id').disabled=c;
			document.getElementById('sftp').disabled=c;
			break;
		case 'port':
			document.getElementById('port').disabled=c;
			break;
		case 'limit_time':
			document.getElementById('limit_time').disabled=c;
			document.getElementById('nolimit').disabled=c;
			break;
		case 'encoding':
			document.getElementById('encoding').disabled=c;
			break;
		case 'commanduser':
			document.getElementById('commanduser').disabled=c;
			break;
		case 'mode':
			document.getElementById('mode').disabled=c;
			break;
		case 'enable':
			document.getElementById('enable').disabled=c;
			break;
		case 'automp':
			document.getElementById('automp').disabled=c;
			break;
		case 'automp2':
			document.getElementById('automp2').disabled=c;
			break;
		case 'su_passwd':
			document.getElementById('su_passwd').disabled=c;
			break;
		case 'entrust_password':
			document.getElementById('entrust_password').disabled=c;
			break;
		case 'logincommit':
			document.getElementById('logincommit').disabled=c;
			break;
		case 'publickey_auth':
			document.getElementById('publickey_auth').disabled=c;
			break;
		case 'ipv6enable':
			document.getElementById('ipv6enable').disabled=c;
			break;
		case 'key_input':
			document.getElementById('key_input').disabled=c;
			break;
		case 'fastpath_input':
			document.getElementById('fastpath_input').disabled=c;
			break;
		case 'fastpath_output':
			document.getElementById('fastpath_output').disabled=c;
			break;
	}
}

var groupid='{{$servergroup}}';
function filteruser(){	
	var username = document.getElementById('username').value;
	var gid=0;
	{{if $_config.LDAP}}
	{{if $_config.TREEMODE}}
	var obj1=document.getElementById('sgroupiddh');	
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
	var url = 'admin.php?controller=admin_pro&action=batchdevicepriorityedit&sgroupid='+gid+"&username="+username;
	var checks = document.getElementById('secend');
	for(var i=0; i<checks.options.length; i++){
		url += '&ip[]='+checks[i].value;
	}
	window.location=url;
}

function checkall(selectID){
	var obj = document.getElementById(selectID);
	var len = obj.options.length;
	for(var i=0; i<len; i++){
		obj.options[i].selected = true;
	}
	return true;
}
function changeport(cp) {
	if(document.getElementById("ssh").selected==true)  {	
		//appset('');
		
		document.getElementById("autotr").style.display='';
		document.getElementById("automutr").style.display='';
		document.getElementById("entrust_password").style.display='';
		document.getElementById("publickey_authtr").style.display='';
		document.getElementById("sftp_tr").style.display='';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = {{$sshport}};
	}
	if(document.getElementById("telnet").selected==true)  {
		//appset('');
		
		document.getElementById("autotr").style.display='';
		document.getElementById("automutr").style.display='';
		document.getElementById("entrust_password").style.display='';
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = {{$telnetport}};
	}
	if(document.getElementById("ftp").selected==true)  {
		//appset('');
		
		document.getElementById("autotr").style.display='none';
		document.getElementById("automutr").style.display='none';
		document.getElementById("entrust_password").style.display='';
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = {{$ftpport}};
	}
	if(document.getElementById("sftp").selected==true)  {
		//appset('');
		
		document.getElementById("autotr").style.display='none';
		document.getElementById("automutr").style.display='none';
		document.getElementById("entrust_password").style.display='block';
		document.getElementById("publickey_authtr").style.display='block';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = {{$sshport}};
	}
	if(document.getElementById("RDP").selected==true)  {
		//appset('');
		
		document.getElementById("autotr").style.display='';
		document.getElementById("rdpmode").style.display='';
		document.getElementById("automutr").style.display='';
		document.getElementById("entrust_password").style.display='';
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		if(cp==1)
		document.getElementById('port').value = {{$rdpport}};
	}
	if(document.getElementById("vnc").selected==true)  {
		//appset('');
		
		document.getElementById("autotr").style.display='';
		document.getElementById("automutr").style.display='';
		document.getElementById("entrust_password").style.display='';
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = '{{$vncport}}';
	}
	if(document.getElementById("X11").selected==true)  {
		//appset('');
		
		document.getElementById("autotr").style.display='';
		document.getElementById("automutr").style.display='';
		document.getElementById("entrust_password").style.display='';
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = {{$x11port}};
	}
	if(document.getElementById("rlogin").selected==true)  {
	//appset('');
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';//alert(document.getElementById("sftp_tr").style.display);
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = {{$rdpport}};
	}
	if(document.getElementById("ssh1").selected==true)  {
		//appset('');
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='block';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = {{$sshport}};
	}
	if(document.getElementById("apppub").selected==true)  {
		//appset('none');
		document.getElementById("publickey_authtr").style.display='none';
		document.getElementById("sftp_tr").style.display='none';
		document.getElementById("rdpmode").style.display='none';
		if(cp==1)
		document.getElementById('port').value = {{$rdpport}};
	}
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
	 <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_{{if $smarty.session.RADIUSUSERLIST}}a{{else}}b{{/if}}"><img src="{{$template_root}}/images/an1{{if !$smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an3{{if !$smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul><span class="back_img"><A href="admin.php?controller=admin_member&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td align="center"><form name="f1" method=post action="admin.php?controller=admin_pro&action=batchdevicepriorityeditsave&chk_member={{$usersid}}" enctype="multipart/form-data" onsubmit="return confirm('确定操作?');checkall('secend');">
	<table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr><td colspan="5" align=center><div style="text-align:left;width:500px;"><select  class="wbk" onchange="window.location='admin.php?controller=admin_pro&action='+this.value">
			<OPTION VALUE="batchserverpriorityedit" {{if $smarty.get.action eq 'batchserverpriorityedit' }}selected{{/if}}>设备</option>
			<OPTION VALUE="batchdevicepriorityedit" {{if $smarty.get.action eq 'batchdevicepriorityedit' }}selected{{/if}}>用户</option>
		</select>&nbsp;&nbsp;用户名：<input type="text" name="username" id="username" value="{{$device_ip}}" >&nbsp;
		{{assign var=select_group_id value='sgroupid'}}
		{{include file="select_sgroup_ajax.tpl" }} 
		&nbsp;<input type="button" onclick="filteruser();" value="提交" >&nbsp;&nbsp;&nbsp;
		</div></td></tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="loginmodetr">
		<td width="100%" align="center" colspan="2">
		<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th class="list_bg">未选设备</th><th class="list_bg"></th><th class="list_bg">已选设备</th></tr>

	<form name="f1" method=post action="admin.php?controller=admin_pro&action=resource_group_save"  enctype="multipart/form-data" >
	  <tr>
	  <td width="45%" align=right>
		<select  class="wbk"  style="width:400;height:400;"  name="first" size="30" id="first" multiple="multiple" ondblclick="moveRight()">
		{{section name=ra loop=$alldevices}}
		<option value="{{$alldevices[ra].id}}" title="{{$alldevices[ra].device_ip}}_{{$alldevices[ra].hostname}}_{{if $alldevices[ra].username eq ''}}空用户{{else}}{{$alldevices[ra].username}}{{/if}}_{{$alldevices[ra].lmethod}}">{{$alldevices[ra].device_ip}}_{{$alldevices[ra].hostname}}_{{if $alldevices[ra].username eq ''}}空用户{{else}}{{$alldevices[ra].username}}{{/if}}_{{$alldevices[ra].lmethod}}</option>
		{{/section}}
		</select>
		</td>
		<td width="10%" align="center">
		<div class="select_move_2">
                <input size="30" type="button" value=" 添加--> " onclick="moveRight()"/><br /><br /><br />
                <input size="30" type="button" value=" <--删除 "  onclick="moveLeft()"/><br />
          </div>
         </td>
         <td>
		<select  class="wbk"   style="width:400;height:400;" size="30" id="secend" name="secend[]" multiple="multiple">
   		</select>
	  </td>
	</tr>
	</table>
		</td>
	</tr>
    {{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="loginmodetr">
		<td width="3%" align="center">
		权限
		</td>
		<td width="97%">
		<table width="100%">
	<TR bgcolor="#f7f7f7">
	 <TD align="left"><input type="checkbox" name="enable[]" value="l_id" onclick="enablepri(this.checked,'l_id');" >&nbsp;{{$language.Loginmode}}：</TD>
      <TD><select  class="wbk"  name="l_id" id="l_id" onchange="changeport(1)">
		{{section name=g loop=$allmethod}}
			<OPTION id ="{{$allmethod[g].login_method}}" VALUE="{{$allmethod[g].id}}" {{if $allmethod[g].id == $l_id}}selected{{/if}}>{{if $allmethod[g].login_method eq 'apppub'}}应用发布{{else}}{{$allmethod[g].login_method}}{{/if}}</option>
		{{/section}}
		</select>
		<span id="sftp_tr">是否支持sftp传输:<INPUT id="sftp" {{if $sftp == 1}} checked {{/if}} type=checkbox name=sftp value="1"> </span>
      </TD>
      <TD align="left"><input type="checkbox" name="enable[]" value="port" onclick="enablepri(this.checked,'port');" >&nbsp;{{$language.port}}：</TD>
      <TD><input type=text name="port" id="port" size=4 value="{{if $port}}{{$port}}{{else}}{{$sshport}}{{/if}}" >
		</TD>
     
    </TR>
	<TR bgcolor="">
      <TD align="left"><input type="checkbox" name="enable[]" value="limit_time" onclick="enablepri(this.checked,'limit_time');" >&nbsp;{{$language.Expiretime}}：</TD>
      <TD><INPUT value="{{$limit_time}}" id="limit_time" name="limit_time">
                      <IMG onClick="getDatePicker('limit_time', event)" 
                                src="{{$template_root}}/images/time.gif"> {{$language.clicktoselectdate}}{{$language.or}}{{$language.select}} {{$language.AlwaysValid}}<INPUT {{if $nolimit == 1}} checked {{/if}} type=checkbox name="nolimit" id="nolimit">  </TD>
				  
      <TD align="left"><input type="checkbox" name="enable[]" value="encoding" onclick="enablepri(this.checked,'encoding');" >&nbsp;用户终端：</TD>
      <TD><select  class="wbk"  name="encoding" id="encoding">
			<OPTION VALUE="0" {{if !$encoding }}selected{{/if}}>默认</option>
			<OPTION VALUE="1" {{if $encoding }}selected{{/if}}>GB2312</option>
		</select></TD>
    </TR>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="commanduser" onclick="enablepri(this.checked,'commanduser');" >&nbsp;命令授权用户：
		</td>
		<td width="35%">
		<select  class="wbk"  name="commanduser" id="commanduser">
		{{section name=m loop=$allmembers}}
		{{if $allmembers[m].username eq 'admin'}}
			<OPTION VALUE="{{$allmembers[m].uid}}" {{if $allmembers[m].uid eq $commanduser }}selected{{/if}}>{{$allmembers[m].username}}</option>
		{{/if}}
		{{/section}}
		</select>
	  </td>
	  <td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="mode" onclick="enablepri(this.checked,'mode');" >&nbsp;RDP加密模式：	
		</td>
		<td width="35%">
		<select  class="wbk"  name="mode" id="mode" >
			<OPTION VALUE="0" {{if !$mode }}selected{{/if}}>自动</option>
			<OPTION VALUE="1" {{if $mode eq 1 }}selected{{/if}}>RDP加密</option>
			<OPTION VALUE="2" {{if $mode eq 2 }}selected{{/if}}>SSL加密</option>
		</select>
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="enable" onclick="enablepri(this.checked,'enable');" >&nbsp;启用：
		</td>
		<td width="35%">
		<INPUT id="enable" {{if $enable == 1}} checked {{/if}} type=checkbox name=enable value="1"> 
	  </td>
	  <td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="automp" onclick="enablepri(this.checked,'automp');" >&nbsp;{{$language.automaticallyeditpassword}}：
		</td>
		<td width="35%">
		<INPUT id="automp" {{if $auto == 1}} checked {{/if}} type=checkbox name=auto value="1">
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="automp2" onclick="enablepri(this.checked,'automp2');" >&nbsp;{{$language.masteraccountforeditingpassword}}：
		</td>
		<td width="35%">
		<INPUT id="automp2" {{if $master_user == 1}} checked {{/if}} type=checkbox name=automu value="1">     
	  </td>
	  <td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="su_passwd" onclick="enablepri(this.checked,'su_passwd');" >&nbsp;改密时su为超级用户：
		</td>
		<td width="35%">
		<INPUT id="su_passwd" {{if $su_passwd == 1}} checked {{/if}} {{if !$id and $su_passwd}}checked{{/if}} type=checkbox name=su_passwd value="1"> 
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="entrust_password" onclick="enablepri(this.checked,'entrust_password');" >&nbsp;自动登录：
		</td>
		<td width="35%">
		<INPUT id="entrust_password" {{if $entrust_password == 1}} checked {{/if}} type=checkbox name=entrust_password value="1">  
	  </td>
	  <td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="logincommit" onclick="enablepri(this.checked,'logincommit');" >&nbsp;操作记录：
		</td>
		<td width="35%">
		<INPUT id="logincommit" {{if $logincommit == 1}} checked {{/if}} type=checkbox name=logincommit value="1">
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="publickey_auth" onclick="enablepri(this.checked,'publickey_auth');" >&nbsp;公钥私钥认证：
		</td>
		<td width="35%">
		<INPUT id="publickey_auth" {{if $publickey_auth == 1}} checked {{/if}} type=checkbox name=publickey_auth value="1">  
	  </td>
	  <td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="ipv6enable" onclick="enablepri(this.checked,'ipv6enable');" >&nbsp;IPV6优先：
		</td>
		<td width="35%">
		<INPUT id="ipv6enable" {{if $ipv6enable == 1}} checked {{/if}} {{if !$id and $dipv6enable}}checked{{/if}} type=checkbox name=ipv6enable value="1">  
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="key_input" onclick="enablepri(this.checked,'key_input');" >&nbsp;键盘记录：
		</td>
		<td width="35%">
		<INPUT id="key_input" {{if $key_input == 1}} checked {{/if}} {{if !$id or $key_input}}checked{{/if}} type=checkbox name=key_input value="1">     
	  </td>
	  <td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="fastpath_input" onclick="enablepri(this.checked,'fastpath_input');" >&nbsp;进向加速：
		</td>
		<td width="35%">
		<INPUT id="fastpath_input" {{if $fastpath_input == 1}} checked {{/if}} {{if !$id and $fastpath_input}}checked{{/if}} type=checkbox name=fastpath_input value="1"> 
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="fastpath_output" onclick="enablepri(this.checked,'fastpath_output');" >&nbsp;出向加速：
		</td>
		<td width="35%">
		<INPUT id="fastpath_output" {{if $fastpath_output == 1}} checked {{/if}} {{if !$id and $fastpath_output}}checked{{/if}} type=checkbox name=fastpath_output value="1">  
	  </td>
	  <td width="15%" align=left>
		</td>
		<td width="35%">
	  </td>
	</tr>
		</table>
		
	  </td>
	</tr>
	
	<tr><td colspan="2" align="center"><input type=submit name="submit"  value="批量导出" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name="submit"  value="批量删除" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name="submit"  value="{{$language.Save}}" class="an_02"></td></tr></table>
</form>
	</td>
  </tr>
  <tr><td colspan="2" height="25"></td></tr>
</table>
</body>
<script>
enablepri(false, 'l_id');
enablepri(false, 'port');
enablepri(false, 'limit_time');
enablepri(false, 'encoding');
enablepri(false, 'commanduser');
enablepri(false, 'mode');
enablepri(false, 'enable');
enablepri(false, 'automp');
enablepri(false, 'automp2');
enablepri(false, 'su_passwd');
enablepri(false, 'entrust_password');
enablepri(false, 'logincommit');
enablepri(false, 'publickey_auth');
enablepri(false, 'ipv6enable');
enablepri(false, 'key_input');
enablepri(false, 'fastpath_input');
enablepri(false, 'fastpath_output');
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




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
var i=0;
i=0;
{{section name=b loop=$usergroup}}
usergroup[i++]={id:{{$usergroup[b].id}},name:'{{$usergroup[b].groupname}}',ldapid:{{$usergroup[b].ldapid}},level:0};
{{/section}}

{{/if}}

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
		case 'usergroup':
			document.getElementById('groupid1pop').disabled=c;
			document.getElementById('groupid1').disabled=c;
			break;
		case 'device_type':
			document.getElementById('device_type').disabled=c;
			break;
		case 'stra_type':
			document.getElementById('stra_type1').disabled=c;
			document.getElementById('stra_type2').disabled=c;
			document.getElementById('stra_type3').disabled=c;
			document.getElementById('freq').disabled=c;
			break;
		case 'superpassword':
			document.getElementById('superpassword').disabled=c;
			document.getElementById('superpassword2').disabled=c;
			break;
		case 'sshport':
			document.getElementById('sshport').disabled=c;
			break;
		case 'telnetport':
			document.getElementById('telnetport').disabled=c;
			break;
		case 'ftpport':
			document.getElementById('ftpport').disabled=c;
			break;
		case 'rdpport':
			document.getElementById('rdpport').disabled=c;
			break;
		case 'vncport':
			document.getElementById('vncport').disabled=c;
			break;
		case 'x11port':
			document.getElementById('x11port').disabled=c;
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
	var url = 'admin.php?controller=admin_pro&action=batchserverpriorityedit&sgroupid='+gid+"&device_ip="+username;
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
            <td align="center"><form name="f1" method=post action="admin.php?controller=admin_pro&action=batchserverpriorityeditsave&chk_member={{$usersid}}" enctype="multipart/form-data" onsubmit="return confirm('确定操作?');checkall('secend');">
	<table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr><td colspan="5" align=center><div style="text-align:left;width:500px;">
		<select  class="wbk" onchange="window.location='admin.php?controller=admin_pro&action='+this.value">
			<OPTION VALUE="batchserverpriorityedit" {{if $smarty.get.action eq 'batchserverpriorityedit' }}selected{{/if}}>设备</option>
			<OPTION VALUE="batchdevicepriorityedit" {{if $smarty.get.action eq 'batchdevicepriorityedit' }}selected{{/if}}>用户</option>
		</select>&nbsp;&nbsp;&nbsp;IP：<input type="text" name="username" id="username" value="{{$device_ip}}" >&nbsp;
		{{assign var=select_group_id value='sgroupid'}}
		{{include file="select_sgroup_ajax.tpl" }} 
		&nbsp;<input type="button" onclick="filteruser();" value="提交" ></div></td></tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="loginmodetr">
		<td width="100%" align="center" colspan="2">
		<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th class="list_bg">未选设备</th><th class="list_bg"></th><th class="list_bg">已选设备</th></tr>

	<form name="f1" method=post action="admin.php?controller=admin_pro&action=resource_group_save"  enctype="multipart/form-data" >
	  <tr>
	  <td width="45%" align=right>
		<select  class="wbk"  style="width:400;height:400;"  name="first" size="30" id="first" multiple="multiple" ondblclick="moveRight()">
		{{section name=ra loop=$allservers}}
		<option value="{{$allservers[ra].device_ip}}" title="{{$allservers[ra].device_ip}}_{{$allservers[ra].hostname}}">{{$allservers[ra].device_ip}}_{{$allservers[ra].hostname}}</option>
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
            <TD align="left"><input type="checkbox" name="enable[]" value="usergroup" onclick="enablepri(this.checked,'usergroup');" >&nbsp;运维组： </TD>
            <TD colspan="3">
		{{assign var=select_group_id value='groupid'}}
		{{include file="select_sgroup_ajax.tpl" }}       </TD>
           
          </TR>
	<TR bgcolor="#f7f7f7">
	 <TD align="left"><input type="checkbox" name="enable[]" value="device_type" onclick="enablepri(this.checked,'device_type');" >&nbsp;设备类型：</TD>
      <TD><select class="wbk"  name=device_type id=device_type>
                      <OPTION value="">{{$language.no}}</OPTION>
                     	{{section name=t loop=$device_types}}
				<option value="{{$device_types[t].id}}" {{if $sourceip[t].groupname == $member.sourceip}}selected{{/if}}>{{$device_types[t].device_type}}</option>
			{{/section}}
                  </SELECT>  &nbsp;&nbsp;&nbsp;
      </TD>
      <TD align="left" style="display: none"><input type="checkbox" name="enable[]" value="stra_type" onclick="enablepri(this.checked,'stra_type');" >&nbsp;改密：</TD>
      <TD style="display: none"><input type='radio' name="stra_type" id="stra_type1" value='mon' {{if $method == 'mon' || $method ==''}}checked{{/if}}>按月
		
		<input type='radio' name="stra_type" id="stra_type2" value='week' {{if $method == 'week'}}checked{{/if}}>每周
		
		<input type='radio' name="stra_type" id="stra_type3" value='custom'{{if $method == 'user'}}checked{{/if}}>自定义<br />
		频率
		<input type=text name="freq" id="freq" size=35 value="{{if $freq}}{{$freq}}{{else}}1{{/if}}" >**
		</TD>
     
    </TR>
	<TR bgcolor="" style="display: none">
      <TD align="left"><input type="checkbox" name="enable[]" value="superpassword" onclick="enablepri(this.checked,'superpassword');" >&nbsp;超级管理员口令:：</TD>
      <TD><input type="password" size=35 name="superpassword" id="superpassword" value="{{$superpassword}}"/></TD>
				  
      <TD align="left">&nbsp;再输一次口令：</TD>
      <TD><input type="password" size=35 name="superpassword2" id="superpassword2" value="{{$superpassword}}"/></TD>
    </TR>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} style="display: none">
		<td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="sshport" onclick="enablepri(this.checked,'sshport');" >&nbsp;SSH默认端口：
		</td>
		<td width="35%">
		<input type=text name="sshport" id="sshport" size=35 value="{{if $id }}{{$sshport}}{{else}}22{{/if}}" >
	  </td>
	  <td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="telnetport" onclick="enablepri(this.checked,'telnetport');" >&nbsp;TELNET默认端口：	
		</td>
		<td width="35%">
		<input type=text name="telnetport" id="telnetport" size=35 value="{{if $id }}{{$telnetport}}{{else}}23{{/if}}" >
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} style="display: none">
		<td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="ftpport" onclick="enablepri(this.checked,'ftpport');" >&nbsp;FTP默认端口：
		</td>
		<td width="35%">
		<input type=text name="ftpport" id="ftpport" size=35 value="{{if $id }}{{$ftpport}}{{else}}21{{/if}}" >
	  </td>
	  <td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="rdpport" onclick="enablepri(this.checked,'rdpport');" >&nbsp;RDP默认端口：
		</td>
		<td width="35%">
		<input type=text name="rdpport" id="rdpport" size=35 value="{{if $id }}{{$rdpport}}{{else}}3389{{/if}}" >
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} style="display: none">
		<td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="vncport" onclick="enablepri(this.checked,'vncport');" >&nbsp;VNC默认端口：
		</td>
		<td width="35%">
		<input type=text name="vncport" id="vncport" size=35 value="{{if $id }}{{$vncport}}{{else}}5900{{/if}}" >
	  </td>
	  <td width="15%" align=left>
		<input type="checkbox" name="enable[]" value="x11port" onclick="enablepri(this.checked,'x11port');" >&nbsp;X11默认端口：
		</td>
		<td width="35%">
		<input type=text name="x11port" id="x11port" size=35 value="{{if $id }}{{$x11port}}{{else}}3389{{/if}}" >
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
enablepri(false, 'usergroup');
enablepri(false, 'device_type');
enablepri(false, 'superpassword');
enablepri(false, 'stra_type');
enablepri(false, 'sshport');
enablepri(false, 'telnetport');
enablepri(false, 'ftpport');
enablepri(false, 'rdpport');
enablepri(false, 'vncport');
enablepri(false, 'x11port');
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




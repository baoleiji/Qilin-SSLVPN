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
<script>

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
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
     <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul><span class="back_img"><A href="admin.php?controller=admin_pro&action=sshkey&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
 <style>
.ul{list-style-type:none; margin:0;width:100%; }
.ul li{ width:80px; float:left;}
</style>
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>

            <td align="center"><form name="f1" method=post OnSubmit='return checkall("secend")' action="admin.php?controller=admin_pro&action=sshkey_list_save&id={{$ginfo.id}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=center colspan="3"><div style="text-align:left;width:700px;">
		SSH私钥:{{$ginfo.sshkeyname}}
		
		{{include file="select_sgroup_ajax.tpl" }}              &nbsp;&nbsp;&nbsp;IP：<input type="text" name="ip" id="ip" >&nbsp;&nbsp;&nbsp;主账号：<input type="text" name="username" id="username" >&nbsp;&nbsp;&nbsp;<input type="button" onclick="searchip();" value="确定" /></div>
	  </td>
	  </tr><tr>
	  <td width="33%" align=center>
		<select  class="wbk"  style="width:400;height:400;"  name="first" size="30" id="first" multiple="multiple" ondblclick="moveRight()">
		{{section name=ra loop=$resource}}
		<option value="{{$resource[ra].devicesid}}_1" title="{{$resource[ra].username}}_{{$resource[ra].uname}}_{{$resource[ra].lmname}}_{{$resource[ra].device_ip}}">{{$resource[ra].username}}_{{$resource[ra].uname}}_{{$resource[ra].lmname}}_{{$resource[ra].device_ip}}</option>
		{{/section}}
		{{*
		{{section name=rr loop=$res}}
		<option value="{{$res[rr].devicesid}}_1" title="{{$res[rr].username}}_{{$res[rr].uname}}_{{$res[rr].lmname}}_{{$res[rr].device_ip}}" move="no">{{$res[rr].username}}_{{$res[rr].lmname}}_{{$res[rr].device_ip}}</option>
		{{/section}}
		*}}
		</select>
		</td>
		<td width="10%">
		<div class="select_move_2">
                <input type="button" value="添加-->" onclick="moveRight()"/><br />
                <input type="button" value="<--删除"  onclick="moveLeft()"/><br />
          </div>
         </td>
         <td>
		<select  class="wbk"   style="width:400;height:400;" size="30" id="secend" name="secend[]" multiple="multiple">
		{{section name=r loop=$res}}
		<option value="{{$res[r].devicesid}}_1" title="{{$res[r].username}}_{{$res[r].uname}}_{{$res[r].lmname}}_{{$res[r].device_ip}}" selected>{{$res[r].username}}_{{$res[r].lmname}}_{{$res[r].device_ip}}</option>
		{{/section}}
   		</select>
	  </td>
	</tr>
	</table>
<br>
<input type="hidden" name="id" value="{{$ginfo.id}}">
<input type="hidden" name="oldgname" value="{{$ginfo.groupname}}">
<input type="submit"  value="保存" class="an_02">
</form>
	</td>
  </tr>
</table>

<script language="javascript">
var changed = false;
function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

function changeport() {
	if(document.getElementById("ssh").selected==true)  {
		f1.port.value = 22;
	}
	if(document.getElementById("telnet").selected==true)  {
		f1.port.value = 23;
	}
}

function changegroup(value){
	if(changed){
		if(confirm('确定要放弃更改?')){
			window.location='admin.php?controller=admin_pro&action=sshkey_list&groupid='+value+'&gname={{$ginfo.groupname}}&id={{$ginfo.id}}';
		}
	}else{
		window.location='admin.php?controller=admin_pro&action=sshkey_list&groupid='+value+'&gname={{$ginfo.groupname}}&id={{$ginfo.id}}';
	}
}

function searchip(){
	var ldapid1=0;
	var ldapid2=0;
	var ldapid3=0;
	var ldapid4=0;
	var ldapid5=0;
	var groupid=0;
	var ip = document.getElementById("ip").value;
	var username = document.getElementById("username").value;
	
	groupid=document.getElementById("groupiddh").value;
	if(changed){
		if(confirm('确定要放弃更改?')){
			window.location='admin.php?controller=admin_pro&action=sshkey_list&'+'&groupid='+groupid+'&gname={{$ginfo.groupname}}&id={{$ginfo.id}}'+'&ip='+ip+'&username='+username;
		}
	}else{
		window.location='admin.php?controller=admin_pro&action=sshkey_list&'+'&groupid='+groupid+'&gname={{$ginfo.groupname}}&id={{$ginfo.id}}'+'&ip='+ip+'&username='+username;
	}
}
</script>
<script type="text/javascript" >

	
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
	
	function checkall(selectID){
		var obj = document.getElementById(selectID);
		var len = obj.options.length;
		for(var i=0; i<len; i++){
			obj.options[i].selected = true;
		}
		return true;
	}

{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



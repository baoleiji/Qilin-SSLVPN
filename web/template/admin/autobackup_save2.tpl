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
    {{if $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 101}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{if $smarty.session.ADMIN_LEVEL eq 10}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
{{else}}
	{{if $smarty.get.type ne 'run'}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list">备份管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>	
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autotemplate">巡检管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{else}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list">备份管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>	
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autotemplate">巡检管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>	
	{{/if}}
	
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=detail_config">巡检检测</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autorun_result">检测结果</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
</ul><span class="back_img"><A href="admin.php?controller=admin_autorun&action=autotemplate&type={{$smarty.get.type}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
 <style>
.ul{list-style-type:none; margin:0;width:100%; }
.ul li{ width:80px; float:left;}
</style>

  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          
 <TR>
<TD >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
  <tr>
   <td >	
	<form name="f1" method=post onsubmit="changegroup();return false;" action="admin.php?controller=admin_autorun&action=autobackup_save&type={{$smarty.get.type}}"  enctype="multipart/form-data" >
		{{include file="select_sgroup_ajax.tpl" }}
		&nbsp;&nbsp;&nbsp;
		IP:<input type=text name="ip" width="8" id="ip" value="{{$ip}}">&nbsp;&nbsp;&nbsp;
		主机名:<input type=text name="hostname" size="8" id="hostname" value="{{$hostname}}">&nbsp;&nbsp;&nbsp;
		用户名:<input type=text name="username" size="8" id="username" value="{{$username}}">&nbsp;&nbsp;&nbsp;
		<select name="lm" id="lm" >
		<option value="0">选择协议</option>
		{{section name=l loop=$allmethod}}
		<option value="{{$allmethod[l].id}}" {{if $allmethod[l].id eq $lm}}selected{{/if}}>{{$allmethod[l].login_method}}</option>
		{{/section}}
		</select>
		<input type='submit' value='确定' onclick='changegroup();' />
		</form>
					</td>
  </tr>
</table>
</TD>
                  </TR>
				  
            <td align="center">
			<form name="f1" method=post action="admin.php?controller=admin_autorun&action=autobackup_dosave&type={{$smarty.get.type}}&id={{$ginfo.id}}"  enctype="multipart/form-data" >
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th class="list_bg">未选设备</th><th class=""></th><th class="list_bg">已选设备</th></tr>
	 	
	  <tr>
	  <td width="45%" align=right>
		<select  class="wbk"  style="width:400;height:400;"  name="first" size="30" id="first" multiple="multiple" ondblclick="moveRight()">
		{{section name=ra loop=$resource}}
		<option value="{{$resource[ra].id}}" title="{{$resource[ra].device_ip}}_{{$resource[ra].hostname}}_{{$resource[ra].lmname}}_{{$resource[ra].port}}_{{$resource[ra].username}}_{{$resource[ra].ep}}">{{$resource[ra].device_ip}}_{{$resource[ra].hostname}}_{{$resource[ra].lmname}}_{{$resource[ra].port}}_{{$resource[ra].username}}_{{$resource[ra].ep}}</option>
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
		{{section name=r loop=$res}}
		<option value="{{$res[r].id}}" title="{{$res[r].device_ip}}_{{$res[r].hostname}}_{{$res[r].lmname}}_{{$res[r].port}}_{{$res[r].username}}_{{$res[r].ep}}" selected>{{$res[r].device_ip}}_{{$res[r].hostname}}_{{$res[r].lmname}}_{{$res[r].port}}_{{$res[r].username}}_{{$res[r].ep}}</option>
		{{/section}}
   		</select>
	  </td>
	</tr>
	</table>
<br>
<input type="hidden" name="id" value="{{$ginfo.id}}">
<input type="hidden" name="oldgname" value="{{$ginfo.name}}">
<input type="submit"  value="保存" onclick="return fsave();" class="an_02">
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

function changegroup(){
	var gid = document.getElementById('groupid').options[document.getElementById('groupid').options.selectedIndex].value;
	var ip = document.getElementById('ip').value;
	var ldapid1 = 0;
	var ldapid2 = 0;
	{{if $_config.LDAP}}
	ldapid1 = document.getElementById('ldapid1').value;
	ldapid2 = document.getElementById('ldapid2').value;
	{{/if}}
	var gname = document.getElementById('gname').value;
	var hostname = document.getElementById('hostname').value;
	var username = document.getElementById('username').value;
	var lm = document.getElementById('lm').options[document.getElementById('lm').options.selectedIndex].value;
	if(changed){
		if(confirm('确定要放弃更改?')){
			window.location='admin.php?controller=admin_autorun&action=autobackup_save&type={{$smarty.get.type}}&groupid='+gid+'&gname='+gname+'&id={{$ginfo.id}}&ip='+ip+'&hostname='+hostname+'&lm='+lm+'&username='+username+'&ldapid1='+ldapid1+'&ldapid2='+ldapid2;
		}
	}else{
		window.location='admin.php?controller=admin_autorun&action=autobackup_save&type={{$smarty.get.type}}&groupid='+gid+'&gname='+gname+'&id={{$ginfo.id}}&ip='+ip+'&hostname='+hostname+'&lm='+lm+'&username='+username+'&ldapid1='+ldapid1+'&ldapid2='+ldapid2;
	}
	return false;
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

	function fsave(){
		//document.getElementById('fgname').value=document.getElementById('gname').value;
		checkall('secend');
		return true;
	}
	
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



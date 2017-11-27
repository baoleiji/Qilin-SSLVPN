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
<script type="text/javascript">

function searchit(){
	var url = "admin.php?controller=admin_member&action=adconfig";
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
	//alert(document.search.elements.action);
	//return false;
	window.location=url;
}

var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();
var alluser = new Array();
var allserver = new Array();
var i=0;
{{section name=a loop=$allsgroup}}
servergroup[i++]={id:{{$allsgroup[a].id}},name:'{{$allsgroup[a].groupname}}',ldapid:{{$allsgroup[a].ldapid}},level:{{$allsgroup[a].level}}};
{{/section}}
var i=0;
{{section name=au loop=$members}}
alluser[i++]={uid:{{$members[au].uid}},username:'{{$members[au].username}}',realname:'{{$members[au].realname}}',groupid:{{$members[au].groupid}}};
{{/section}}

</script>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    {{if $from eq 'dir'}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{else}}
    <li class="me_{{if $smarty.session.RADIUSUSERLIST}}b{{else}}a{{/if}}"><img src="{{$template_root}}/images/an1{{if $smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an3{{if $smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	{{/if}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $from eq 'dir'}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{else}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
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
		</td>
  </tr>
</table>
</TD>
                  </TR>
				  
            <td align="center">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th class="list_bg">所有用户</th><th class="list_bg"></th><th class="list_bg">组内用户</th></tr>
    <tr><td></td><td></td><td>
	<form name="f1" method=post action="admin.php?controller=admin_member&action=adconfig"  enctype="multipart/form-data" >
	
		{{include file="select_sgroup_ajax.tpl" }}    
		<input type='button' value='确定' onclick='return changegroup();' />
		</td></tr>	 
	  <tr>
	  <td width="35%" align=left valign="top">
		<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/dtree.js"></script>
<div class="dtree" >
	<script type="text/javascript">
		ddev = new dTree('ddev');
		ddev.icon['folder'] = 'template/admin/cssjs/img/pcgroup.gif';
		ddev.icon['folderOpen'] = 'template/admin/cssjs/img/pcgroup.gif';
		ddev.icon['node'] = 'template/admin/cssjs/img/pc.gif';
		var i=0;
		ddev.add(0,-1,'AD用户','admin.php?controller=admin_index&action=main&all=1','','main');
		//ddev.add(10000,0,'所有主机','admin.php?controller=admin_pro&action=dev_index','','main');
		{{section name=ag loop=$root}}
		{{section name=ago loop=$root[ag].ous}}
			ddev.add('{{$smarty.section.ag.index}}_{{$smarty.section.ago.index}}','{{$root[ag].ous[ago].pid}}','{{$root[ag].ous[ago].name}}',null,null,ddev.icon.folder,ddev.icon.folderOpen);
		{{/section}}	
		{{section name=agu loop=$root[ag].users}}
			ddev.add('u_{{$smarty.section.ag.index}}_{{$smarty.section.agu.index}}','{{$root[ag].users[agu].pid}}','<input type="checkbox" name="user[]" {{if $g_id eq $root[ag].users[agu].groupid}}checked{{/if}} style="color:red" value="" onclick="checkuser(this.checked,\'{{$root[ag].users[agu].uid}}\',\'{{$root[ag].users[agu].username}}\');">{{if $root[ag].users[agu].groupid}}<font color="red" >{{$root[ag].users[agu].username}}</font>{{else}}{{$root[ag].users[agu].username}}{{/if}}',null,null,ddev.icon.folder,ddev.icon.folderOpen);
		{{/section}}	
		{{/section}}
		document.write(ddev);		
		ddev.s(0);
	</script>
		</td>
		<td width="5%" align="center">
		<div class="select_move_2">
                <input size="30" type="button" value=" <--删除 "  onclick="moveLeft()"/><br />
          </div>
         </td>
         <td>
		<select  class="wbk"   style="width:400;height:400;" size="30" id="secend" name="secend[]" multiple="multiple" ondblclick="checkuser(false, this.value);">
		{{section name=r loop=$members}}
		<option value="{{$members[r].uid}}" title="{{$members[r].username}}" selected>{{$members[r].username}}</option>
		{{/section}}
   		</select>
	  </td>
	</tr>
	</table>
<br>
<input type="submit" name="submit"  value="保存" onclick="return fsave();" class="an_02">
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

function checkuser(check, uid, username){
	if(check){
		document.getElementById('secend').options[document.getElementById('secend').options.length]=new Option( username,uid, true, true);
	}else{
		var a = document.getElementById('secend');
		for(var i=0; i<a.options.length; i++){
			if(a.options[i].value==uid){
				a.options.remove(i);
				break;
			}
		}
	}
}


function moveLeft()
	{
		//首先得到第二个select对象
		var selectElement = document.getElementById("secend");
		
		var optionElement = selectElement.getElementsByTagName("option");
		var len = optionElement.length;
		
		
		//再次得到第一个元素
		if(!(selectElement.selectedIndex==-1))
		{
			
			for(i=0;i<len;i++)
			{
				if(selectElement.selectedIndex>=0)
					selectElement.options.remove(selectElement.selectedIndex);//被选中的那个元素的索引
			}
			changed = true;
		}else
		{
			alert("您还没有选中要移动的项目!");
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
	{{if $_config.LDAP}}
	{{if $_config.TREEMODE}}
	var obj1=document.getElementById('groupid1');	
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
	{{/if}}
	if(changed){
		if(confirm('确定要放弃更改?')){
			window.location='admin.php?controller=admin_member&action=adconfig&g_id='+gid;
		}
	}else{
		window.location='admin.php?controller=admin_member&action=adconfig&g_id='+gid;
	}
	return false;
}


</script>
<script type="text/javascript" >

		
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



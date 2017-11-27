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
{{*
{{if $_config.LDAP}}
var servergroup = new Array();
var i=0;
{{section name=a loop=$allsgroup}}
servergroup[i++]={id:{{$allsgroup[a].id}},name:'{{$allsgroup[a].groupname}}',ldapid:{{$allsgroup[a].ldapid}},level:{{$allsgroup[a].level}}};
{{/section}}
{{/if}}

var foundparent = false;
var AllMember = new Array();
i=0;
{{section name=kk loop=$allmem}}
AllMember[{{$smarty.section.kk.index}}] = new Array();
AllMember[{{$smarty.section.kk.index}}]['username']='{{$allmem[kk].username}}';
AllMember[{{$smarty.section.kk.index}}]['realname']='{{$allmem[kk].realname}}';
AllMember[{{$smarty.section.kk.index}}]['uid']='{{$allmem[kk].uid}}';
AllMember[{{$smarty.section.kk.index}}]['groupid']='{{$allmem[kk].groupid}}';
AllMember[{{$smarty.section.kk.index}}]['check']='{{$allmem[kk].check}}';
{{/section}}
*}}
</script>
<body>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=resource_group">系统用户组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_app&action=app_group">应用用户组</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_priority_search">系统权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=app_priority_search">应用权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_app&action=app_group&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
 <style>
.ul{list-style-type:none; margin:0;width:100%; }
.ul li{ width:80px; float:left;}
</style>
  <TR>
<TD >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
  <tr>
   <td >	<form name="f1" method=post onsubmit="changegroup();return false;" action="admin.php?controller=admin_app&action=app_group_edit&id={{$ginfo.id}}"  enctype="multipart/form-data" >
		应用服务器列表：<select name="appserverip" id="appserverip">
		<option value="0">请选择</option>
		{{section name=a loop=$appserver}}
		<option value="{{$appserver[a].appserverip}}">{{$appserver[a].appserverip}}</option>
		{{/section}}
		</select>&nbsp;
		{{include file="select_sgroup_ajax.tpl" }}
		&nbsp;&nbsp;
		IP:<input type=text name="ip" width="8" id="ip" value="{{$ip}}">&nbsp;&nbsp;&nbsp;
		主机名:<input type=text name="hostname" size="8" id="hostname" value="{{$hostname}}">&nbsp;&nbsp;&nbsp;
		用户名:<input type=text name="username" size="8" id="username" value="{{$username}}">&nbsp;&nbsp;&nbsp;
		<input type='submit' value='确定'  />
		</form>
		</td>
  </tr>
</table>
</TD>
                  </TR>
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>

            <td align="center"><form name="f1" method=post OnSubmit='return checkall("secend")' action="admin.php?controller=admin_app&action=app_group_save&id={{$id}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
<tr><th colspan="3" class="list_bg"></th></tr>
	  <tr bgcolor="f7f7f7">
		<td align=right colspan=1>
		应用用户组:<input type=text size="50" name="gname" id="gname" value="{{$ginfo.appgroupname}}"> </td><td align="left" colspan="2">描述:<input type=text size="50" name="desc" id="desc" value="{{$ginfo.desc}}">
	  {{if $smarty.session.ADMIN_LEVEL eq 1}}&nbsp;&nbsp;用户<select name="createuser" >
  {{section name=g loop=$allmem}}
  {{if $allmem[g].level eq 1 or $allmem[g].level eq 3}}
  <option value="{{$allmem[g].username}}" {{if (!$ginfo&&$allmem[g].username eq $smarty.session.ADMIN_USERNAME) or ($ginfo&&$allmem[g].username eq $ginfo.user)}}selected{{/if}}>{{$allmem[g].username}}({{$allmem[g].realname}})</option>
  {{/if}}
  {{/section}}
  </select>
  {{/if}}
	  </td>
	  </tr>
	  <tr>
	  <td align=center>
		<select  class="wbk"  style="width:400;height:400;"  name="first" size="30" id="first" multiple="multiple" ondblclick="moveRight()">
		{{section name=ra loop=$resource}}
		<option value="{{$resource[ra].id}}">{{$resource[ra].appserverip}}_{{$resource[ra].appprogramname}}_{{$resource[ra].apppubname}}_{{$resource[ra].username}}_{{$resource[ra].device_ip}}</option>
		{{/section}}
		</select>
		</td>
		<td width="10%" align="">
		<div class="select_move_2">
				{{assign var=checkbox value=1}}
				{{assign var=multipleselect value=1}}
                {{assign var=addgroup value=1}}
                {{assign var=popsize value=45}}
				{{assign var=select_group_id value='agroupid'}}
				{{assign var=inputtype value=' 组操作 '}}
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{include file="select_sgroup_ajax.tpl" }}<br /><br /><br />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input size="30" type="button" value=" 添加--> " onclick="moveRight()"/><br /><br /><br />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input size="30" type="button" value=" <--删除 "  onclick="moveLeft()"/><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
          </div>
         </td>
         <td align=center>
		<select class="wbk" style="width:400;height:400;" size="30" id="secend" name="secend[]" multiple="multiple">
		{{section name=r2 loop=$res2}}
		<option value="groupid_{{$res2[r2].groupid}}" title="{{$res2[r2].groupname}}_{{$res2[r2].groupid}}" selected>设备组_{{$res2[r2].groupname}}_{{$res2[r2].groupid}}</option>
		{{/section}}
		{{section name=r loop=$res}}
		<option value="{{$res[r].id}}" selected>{{$res[r].appserverip}}_{{$res[r].appprogramname}}_{{$res[r].apppubname}}_{{$res[r].username}}_{{$res[r].device_ip}}</option>
		{{/section}}
   		</select>
	  </td>
	</tr>
	<tr ><td colspan="3">
<table>
<tr>

	  <td width="10%" align="right" valign=top>{{$language.bind}}{{$language.group}}
	  <table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' {{if $smarty.get.bindgroup eq 1}}checked{{/if}} onclick="reload('bindgroup=1','bindgroup=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' {{if $smarty.get.bindgroup eq 2}}checked{{/if}} onclick="reload('bindgroup=2','bindgroup=0',this.checked);"></td></tr>
	  </table></td>
	  <td >
	  <table>
	  <tr>
	  {{section name=u loop=$usergroup}}
	  {{if !$smarty.get.bindgroup or ($smarty.get.bindgroup eq 2 and $usergroup[u].check eq '') or ($smarty.get.bindgroup eq 1 and $usergroup[u].check eq 'checked')}}
		<td width="180"><input type="checkbox" name='Group{{$smarty.section.u.index}}' value='{{$usergroup[u].id}}'  {{$usergroup[u].check}}><a onclick="window.open ('admin.php?controller=admin_app&action=appresourcegrp_selgroup&gid={{$usergroup[u].id}}&sid={{$id}}&sessionlgroup={{$sessionlgroup}}', 'newwindow', 'height=160, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;"  href="#" target="_blank" >{{$usergroup[u].groupname}}</a></td>{{if ($smarty.section.u.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/if}}
		{{/section}}
		</tr></table>
	  </td>
	  </tr>
	  <tr><td></td><td></td></tr>
		<tr>
		<td align=right valign=top>
		{{$language.bind}}{{$language.User}}
		<table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' {{if $smarty.get.binduser eq 1}}checked{{/if}} value=1 onclick="reload('binduser=1','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' {{if $smarty.get.binduser eq 2}}checked{{/if}} value=2 onclick="reload('binduser=2','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;"><input type="button" name='batchselect' class="an_06" value="批量选择" onclick="window.open('admin.php?controller=admin_pro&action=xzuser', 'newwindow','height=650, width=700, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');" ></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">全选<input type="checkbox" value=2 onclick="checkAll1(this.checked);"></td></tr>
	  </table>
		</td>
		<td>
		<table><tr>
		{{section name=g loop=$allmem}}
		{{if !$smarty.get.binduser or ($smarty.get.binduser eq 2 and $allmem[g].check eq '') or ($smarty.get.binduser eq 1 and $allmem[g].check eq 'checked')}}
		<td width="180"><input type="checkbox" id="uid_{{$allmem[g].uid}}" name='Check{{$smarty.section.g.index}}' value='{{$allmem[g].uid}}'  {{$allmem[g].check}}><a onclick="window.open ('admin.php?controller=admin_app&action=appresourcegrp_seluser&uid={{$allmem[g].uid}}&sid={{$id}}&sessionluser={{$sessionluser}}', 'newwindow', 'height=160, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href="#" target="_blank" >{{$allmem[g].username}}({{if $allmem[g].realname}}{{$allmem[g].realname}}{{else}}未设置{{/if}})</a></td>{{if ($smarty.section.g.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/if}}
		{{/section}}
		</tr></table>
	  </td>
	  </tr>
</table>
	</td>
	</tr>
	</table>
<br>
<input type="hidden" name="sessionlgroup" value="{{$sessionlgroup}}" />
<input type="hidden" name="sessionluser" value="{{$sessionluser}}" />
<input type="hidden" name="id" value="{{$ginfo.id}}">
<input type="hidden" name="oldgname" value="{{$ginfo.appgroupname}}">
<input type="submit"  value="保存" class="an_02">&nbsp;&nbsp;<input type="button" onclick='window.location="admin.php?controller=admin_app&action=app_group&back=1"'  value="退出" class="an_02">
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
</script>
<script type="text/javascript" >
function checkAll1(c){
	var targets = document.getElementsByTagName('input');
	for(var j=0; j<targets.length; j++){
		if(targets[j].name.substring(0,5)=='Check'){
			targets[j].checked=c;
		}
	}
}
function reload(p1,p2,check){
	window.location=window.location+'&'+(check ? p1 : p2);
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
				if(selectElement.selectedIndex>=0){
					if(selectElement.options[selectElement.selectedIndex].value.substring(0,7)=='groupid'){
						selectElement.options.remove(selectElement.selectedIndex);//被选中的那个元素的索引
					}else{
						firstSelectElement.appendChild(optionElement[selectElement.selectedIndex]);//被选中的那个元素的索引
					}
				}
			}
		}else
		{
			alert("您还没有选中要移动的项目!");
		}
	}

	function selectgroup(groupid,groupname){
		checkall("secend");
		deletegroup();
		
		if(groupid>0)
		for(var i=0; i<document.getElementById("secend").options.length; i++){
			if(document.getElementById("secend").options[i].value=='groupid_'+groupid){
				alert('组已经存在');
				return ;
			}
		}
		var inputs = document.getElementsByTagName("input");
		selectedgroup.length=0;
		for(var i=0; i<inputs.length; i++){
			if(inputs[i].name=='agroupidd_group[]'&&inputs[i].checked){
				groupid = inputs[i].getAttribute("gid");
				groupname = inputs[i].getAttribute("gname");
				selectedgroup[selectedgroup.length]=groupid
				var found = 0;
				for(var j=0; j<document.getElementById("secend").options.length; j++){
					if(document.getElementById("secend").options[j].value=='groupid_'+groupid){
						found=1 ;
					}
				}
				if(found==1) continue;
				document.getElementById("secend").options[document.getElementById("secend").options.length]=new Option('设备组'+'_'+groupname+'_'+groupid, 'groupid_'+groupid);
			}
		}
		//document.getElementById("secend").options[document.getElementById("secend").options.length]=new Option('设备组'+'_'+groupname+'_'+groupid+'_'+username, 'groupid_'+groupid+'_'+username);
	}

	function deletegroup(){
		var selectElement = document.getElementById("secend");
		var len = selectElement.options.length;
		
		
		//再次得到第一个元素
		if(!(selectElement.selectedIndex==-1))
		{
			
			for(i=0;i<len;i++)
			{
				if(selectElement.selectedIndex>=0&&selectElement.options[selectElement.selectedIndex].value.substring(0,7)=='groupid')
					selectElement.options.remove(selectElement.selectedIndex);//被选中的那个元素的索引
			}
			changed = true;
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

function changegroup(){
	var ip = document.getElementById('ip').value;
	var ldapid1 = 0;
	var ldapid2 = 0;
	var gid=0;
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
	var appserverip = document.getElementById('appserverip').options[document.getElementById('appserverip').selectedIndex].value;
	var gname = document.getElementById('gname').value;
	var desc = document.getElementById('desc').value;
	var hostname = document.getElementById('hostname').value;
	var username = document.getElementById('username').value;
	if(changed){
		if(confirm('确定要放弃更改?')){
			window.location='admin.php?controller=admin_app&action=app_group_edit&groupid='+gid+'&gname='+gname+'&desc='+desc+'&id={{$ginfo.id}}&ip='+ip+'&hostname='+hostname+'&username='+username;
		}
	}else{
		window.location='admin.php?controller=admin_app&action=app_group_edit&groupid='+gid+'&gname='+gname+'&desc='+desc+'&id={{$ginfo.id}}&ip='+ip+'&hostname='+hostname+'&username='+username;
	}
	return false;
}

{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
var selectedgroup = new Array();
{{section name=i loop=$res2}}
selectedgroup[{{$smarty.section.i.index}}] = {{$res2[i].groupid}};
{{/section}}
function checkS(pre){
	var inputs = document.getElementsByTagName("input");
	for(var i=0; i<inputs.length; i++){
		if(inputs[i].name=='agroupidd_group[]'){
			inputs[i].checked=agroupidd.GetChecked(inputs[i].getAttribute("gid"));
		}
	}
	var selectElement = document.getElementById("secend");
	for(var i=0; i<selectElement.options.length; i++){
		if(selectElement.options[i].value.substring(0,7)=='groupid'){
			var _id = selectElement.options[i].value.split('_');
			if(document.getElementById('group_'+pre+_id[1])!=null){
				document.getElementById('group_'+pre+_id[1]).checked = true;
				agroupidd.SetChecked(_id[1],true);
			}
		}
	}
}
checkS("");
</script>


</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



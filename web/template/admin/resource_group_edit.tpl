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
var usergroup = new Array();
var i=0;
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
	<form name="f1" method=post onsubmit="changegroup();return false;" action="admin.php?controller=admin_pro&action=resource_group_save"  enctype="multipart/form-data" >
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
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th class="list_bg">未选设备</th><th class="list_bg"></th><th class="list_bg">已选设备</th></tr>

	<form name="f1" method=post action="admin.php?controller=admin_pro&action=resource_group_save"  enctype="multipart/form-data" >
<input type="hidden" name="uid" value="{{$uinfo.uid}}">
<input type="hidden" name="oldgname" value="{{$ginfo.groupname}}">
	  <tr>
  <td align="right" colspan="1">
  {{if $smarty.session.ADMIN_LEVEL eq 1}}&nbsp;&nbsp;用户<select name="createuser" >
  {{section name=g loop=$allmem}}
  {{if $allmem[g].level eq 1 or $allmem[g].level eq 3}}
  <option value="{{$allmem[g].username}}" {{if (!$ginfo&&$allmem[g].username eq $smarty.session.ADMIN_USERNAME) or ($ginfo&&$allmem[g].username eq $ginfo.user)}}selected{{/if}}>{{$allmem[g].username}}({{$allmem[g].realname}})</option>
  {{/if}}
  {{/section}}
  </select>
  {{/if}}
  </td>
  <tr>
	  <tr>
	  <td width="45%" align=right>
		<select  class="wbk"  style="width:400;height:400;"  name="first" size="30" id="first" multiple="multiple" ondblclick="moveRight()">
		{{section name=ra loop=$resource}}
		<option value="{{$resource[ra].id}}" title="{{$resource[ra].device_ip}}_{{$resource[ra].hostname}}">{{$resource[ra].device_ip}}_{{$resource[ra].hostname}}</option>
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
         <td>
		<select  class="wbk"   style="width:400;height:400;" size="30" id="secend" name="secend[]" multiple="multiple">
		{{section name=r loop=$res}}
		<option value="{{$res[r].id}}" title="{{$res[r].device_ip}}_{{$res[r].hostname}}_{{$res[r].lmname}}_{{$res[r].port}}_{{$res[r].username}}_{{$res[r].ep}}" selected>{{$res[r].device_ip}}_{{$res[r].hostname}}</option>
		{{/section}}
   		</select>
	  </td>
	</tr>
	
	</table>
<br>
<input type="submit"  value="保存" onclick="return fsave();" class="an_02">&nbsp;&nbsp;<input type="button" onclick='window.location="admin.php?controller=admin_pro&action=resource_group&back=1"'  value="退出" class="an_02">

<input type="hidden" name="sessionlgroup" value="{{$sessionlgroup}}" />
<input type="hidden" name="sessionluser" value="{{$sessionluser}}" />
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
	var ip = document.getElementById('ip').value;
	var ldapid1 = 0;
	var ldapid2 = 0;
	var gid=0;
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
	{{/if}}
	var gname = document.getElementById('gname').value;
	var desc = document.getElementById('desc').value;
	var hostname = document.getElementById('hostname').value;
	var username = document.getElementById('username').value;
	var lm = document.getElementById('lm').options[document.getElementById('lm').options.selectedIndex].value;
	if(changed){
		if(confirm('确定要放弃更改?')){
			window.location='admin.php?controller=admin_pro&action=resource_group_edit&groupid='+gid+'&gname='+gname+'&desc='+desc+'&id={{$ginfo.id}}&ip='+ip+'&hostname='+hostname+'&lm='+lm+'&username='+username+'&ldapid1='+ldapid1+'&ldapid2='+ldapid2;
		}
	}else{
		window.location='admin.php?controller=admin_pro&action=resource_group_edit&groupid='+gid+'&gname='+gname+'&desc='+desc+'&id={{$ginfo.id}}&ip='+ip+'&hostname='+hostname+'&lm='+lm+'&username='+username+'&ldapid1='+ldapid1+'&ldapid2='+ldapid2;
	}
	return false;
}

</script>
<script type="text/javascript" >
function checkAll(c){
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
				if(selectElement.selectedIndex>=0){
					if(selectElement.options[selectElement.selectedIndex].value.substring(0,7)=='groupid'){
						selectElement.options.remove(selectElement.selectedIndex);//被选中的那个元素的索引
					}else{
						firstSelectElement.appendChild(optionElement[selectElement.selectedIndex]);//被选中的那个元素的索引
					}
				}
			}
			changed = true;
		}else
		{
			alert("您还没有选中要移动的项目!");
		}
	}

	function selectgroup(groupid,groupname){
		checkall("secend");
		//deletegroup();
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
		
	}

	function deletegroup(groupid,groupname){
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

	function fsave(){
		//document.getElementById('fgname').value=document.getElementById('gname').value;
		checkall('secend');
		return true;
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



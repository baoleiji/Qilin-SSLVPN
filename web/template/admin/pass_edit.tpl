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
<script language="javascript">
function check_add_user(){
	return(true);
}

var AllMember = new Array();
var i=0;
{{section name=kk loop=$allradiusmem}}
AllMember[{{$smarty.section.kk.index}}] = new Array();
AllMember[{{$smarty.section.kk.index}}]['username']='{{$allradiusmem[kk].username}}';
AllMember[{{$smarty.section.kk.index}}]['realname']='{{$allradiusmem[kk].realname}}';
AllMember[{{$smarty.section.kk.index}}]['uid']='{{$allradiusmem[kk].uid}}';
AllMember[{{$smarty.section.kk.index}}]['groupid']='{{$allradiusmem[kk].groupid}}';
AllMember[{{$smarty.section.kk.index}}]['check']='{{$allradiusmem[kk].check}}';
{{/section}}


function filter(){
	var filterStr = document.getElementById('username').value;
	var usbkeyid = document.getElementById('memberselect');
	usbkeyid.options.length=1;
	for(var i=0; i<AllRadiusMember.length;i++){
		if(filterStr.length==0 || AllRadiusMember[i]['username'].indexOf(filterStr) >= 0){
			usbkeyid.options[usbkeyid.options.length++] = new Option(AllRadiusMember[i]['username'],AllRadiusMember[i]['uid']);
		}
	}
}

function change_for_user_auth(){
}

function usernameselect(){
}
function temptyuser(check){
}

function searchit(){
	var url = "admin.php?controller=admin_pro&action=pass_edit&id={{$id}}&ip={{$ip}}&serverid={{$serverid}}&gid={{$gid}}&from={{$smarty.get.from}}";
	url += "&webuser="+document.f1.elements.webuser.value;
	url += "&webgroup="+document.f1.elements.webgroup.value;
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
	url += "&g_id="+gid;
	{{/if}}
	window.location.href= url;
	return false;
}

{{if $_config.LDAP}}
var foundparent = false;
var servergroup = new Array();
{{/if}}
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

<body onbeforeunload="saveTitle(event)">


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu" style="width:1100px;">
<ul>
</ul><span class="back_img"><A href="admin.php?{{if $smarty.get.from eq 'passview'}}controller=admin_index&action=main{{else}}controller=admin_pro&action={{if $fromdevpriority}}dev_priority_search{{else}}devpass_index&ip={{$ip}}&serverid={{$serverid}}{{/if}}{{/if}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
<tr>
	<td class="">
    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#ffffff" class="BBtable" >
	<TR>
	<TD colspan="3" height="33" class="main_content">
	<form name ='f1' action='admin.php?controller=admin_pro&action=pass_edit' method=post>
	资源组：{{include file="select_sgroup_ajax.tpl" }}&nbsp;&nbsp;&nbsp;&nbsp;运维用户过滤<input type="text" class="wbk" name="webuser" value="{{$webuser}}">
	资源组<input type="text" class="wbk" name="webgroup" value="{{$webgroup}}">
	&nbsp;&nbsp;<input  type="button" value=" 提交 " onClick="return searchit();" class="bnnew2">
	</form>
	</TD>
  </TR>

<form name="f2" method=post action="admin.php?controller=admin_pro&action=pass_save&id={{$id}}&ip={{$ip}}&serverid={{$serverid}}&gid={{$gid}}&from={{$smarty.get.from}}" enctype="multipart/form-data" onsubmit="javascript:saveAccount=false;">
	<input type="password" name="hiddenpassword" id="hiddenpassword" style="display:none"/> {{assign var="trnumber" value=0}}
	
		
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="20%" align=right  valign=top>
		{{$language.User}}
		<table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' {{if $smarty.get.binduser eq 1}}checked{{/if}} value=1 onclick="reload('binduser=1','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' {{if $smarty.get.binduser eq 2}}checked{{/if}} value=2 onclick="reload('binduser=2','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;"><input type="button" name='batchselect' class="an_06" value="批量选择" onclick="window.open('admin.php?controller=admin_pro&action=xzuser', 'newwindow','height=650, width=700, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');" ></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">全选<input type="checkbox" value=2 onclick="checkAll(this.checked);"></td></tr>
	  </table>
		</td>
		<td width="80%">
		<table><tr >
		{{section name=g loop=$allradiusmem}}
		{{if !$smarty.get.binduser or ($smarty.get.binduser eq 2 and $allradiusmem[g].check eq '') or ($smarty.get.binduser eq 1 and $allradiusmem[g].check eq 'checked')}}
		<td width="180"><input type="checkbox" id="uid_{{$allradiusmem[g].uid}}" name='Check{{$smarty.section.g.index}}' value='{{$allradiusmem[g].uid}}'  {{$allradiusmem[g].check}}><a href="#" target="_blank" >{{if $allradiusmem[g].binded}}<font color="red">{{/if}}{{$allradiusmem[g].username}}({{if $allradiusmem[g].realname}}{{$allradiusmem[g].realname}}{{else}}未设置{{/if}}){{if $allradiusmem[g].binded}}</font>{{/if}}</a></td>{{if ($smarty.section.g.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/if}}
		{{/section}}
		</tr></table>
	  </td>
	  </tr>
	 
	<tr><td></td><td><input type=submit  value="{{$language.Save}}" class="an_02" >&nbsp;&nbsp;&nbsp;&nbsp;<input type=button  value="检测" onclick="test_port();" class="an_02"></td></tr></table>
<input type="hidden" name="logtab" value="{{$logtab.id}}" />
<input type="hidden" name="sessionlgroup" value="{{$sessionlgroup}}" />
<input type="hidden" name="sessionluser" value="{{$sessionluser}}" />
</form>
	</td>
  </tr>
  <tr><td colspan="2" height="25"></td></tr>
</table>
 <SCRIPT type=text/javascript>
var siteUrl = "{{$template_root}}/images/date";
function test_port(){
	var port = document.getElementById('port').value;
	if(!/[0-9]+/.test(port)){
		alert('端口请输入数字');
		return ;
	}
	document.getElementById('hide').src='admin.php?controller=admin_pro&action=test_port&ip={{$ip}}&port='+port;
	//alert(document.getElementById('hide').src);
}
function changeport(cp) {
	
}
function appset(enable){
	document.getElementById("usernametr").style.display=enable;
	document.getElementById("originalpasswordtr").style.display=enable;
	document.getElementById("originalpassword2tr").style.display=enable;
	document.getElementById("porttr").style.display=enable;
	document.getElementById("expiretr").style.display=enable;
	document.getElementById("autotr").style.display=enable;
	document.getElementById("automutr").style.display=enable;
	document.getElementById("entrust_passwordtr").style.display=enable;
}

function checkAll(c){
	var targets = document.getElementsByTagName('input');
	for(var j=0; j<targets.length; j++){
		if(targets[j].name.substring(0,5)=='Check'){
			targets[j].checked=c;
		}
	}
}


function privatekey_set(){
}
function changessh(v){
}


var saveAccount = false;
function saveTitle(e){
	if(saveAccount){
		//alert("绑定信息需要点击'保存修改'才能存盘");
		return  e.returnValue='绑定信息需要点击 保存修改 才能存盘,你真的要不保存离开吗？';
		
	}
	return true;
}
function setSave(){
	saveAccount=true;
}
function reload(p1,p2,check){
	window.location=window.location+'&'+(check ? p1 : p2);
}

{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</SCRIPT>
</body>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




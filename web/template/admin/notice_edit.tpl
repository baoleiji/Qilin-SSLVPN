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

function searchit(){
	var url = "admin.php?controller=admin_config&action=notice_edit&id={{$noticeinfo.id}}&ip={{$ip}}&serverid={{$serverid}}&gid={{$gid}}&from={{$smarty.get.from}}";
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
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=serverstatus">服务状态</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=latest">系统状态</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup">配置备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting">数据同步</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=upgrade">软件升级</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=cronjob">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=changelogo">图标上传</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=notice">系统通知</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_config&action=notice&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
<tr>
	<td class="">
    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#ffffff" class="BBtable" >
	<TR>
	<TD colspan="3" height="33" class="main_content">
	<form name ='f1' action='admin.php?controller=admin_config&action=notice_edit' method=post>
	资源组：{{include file="select_sgroup_ajax.tpl" }}&nbsp;&nbsp;&nbsp;&nbsp;运维用户过滤<input type="text" class="wbk" name="webuser" value="{{$webuser}}">
	资源组<input type="text" class="wbk" name="webgroup" value="{{$webgroup}}">
	&nbsp;&nbsp;<input  type="button" value=" 提交 " onClick="return searchit();" class="bnnew2">
	</form>
	</TD>
  </TR>

<form name="f2" method=post action="admin.php?controller=admin_config&action=notice_save&id={{$noticeinfo.id}}" enctype="multipart/form-data" onsubmit="javascript:saveAccount=false;">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="usernametr">
		<td width="20%" align=right>
		广播内容
		</td>
		<td width="80%">
		<textarea name="content" id="content" cols=120 rows=5>{{$noticeinfo.content}}</textarea>
			
	  </td>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} >
		<TD width="20%" align=right>是否广播 </TD>
                  <TD width="80%"><INPUT id="enable" {{if $noticeinfo.enable == 1 or !$noticeinfo.id}} checked {{/if}} type=checkbox name=enable value="1">                  </TD>
                </TR>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} >
		<TD width="20%" align=right>过期时间 </TD>
                  <TD width="80%"><INPUT value="{{if $noticeinfo.expiretime ne '2037-01-01 00:00:00'}}{{$noticeinfo.expiretime}}{{/if}}" id="expiretime" name="expiretime" >&nbsp;&nbsp;<input type="button"  id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk"> 
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true,
	popupDirection:'down'
});
cal.manageFields("f_rangeStart_trigger", "expiretime", "%Y-%m-%d %H:%M:%S");


</script></TD>
                </TR>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} >
		<TD width="20%" align=right>全部用户 </TD>
                  <TD width="80%"><INPUT id="all" {{if $noticeinfo.all == 1}} checked {{/if}} type=checkbox name=all value="1">                  </TD>
                </TR>
	
         {{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
	  <td width="20%" align="right"  valign=top>{{$language.bind}}{{$language.group}}
	  <table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已选择<input type="checkbox" name='showcheckeduser' {{if $smarty.get.bindgroup eq 1}}checked{{/if}} onclick="reload('bindgroup=1','bindgroup=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未选择<input type="checkbox" name='showuncheckeduser' {{if $smarty.get.bindgroup eq 2}}checked{{/if}} onclick="reload('bindgroup=2','bindgroup=0',this.checked);"></td></tr>
	  </table>
	  </td>
	  <td >
	  <table>
	<tr>
		{{section name=u loop=$usergroup}}
		{{if !$smarty.get.bindgroup or ($smarty.get.bindgroup eq 2 and $usergroup[u].check eq '') or ($smarty.get.bindgroup eq 1 and $usergroup[u].check eq 'checked')}}
		<td width="180"><input type="checkbox" name='Group[]' value='{{$usergroup[u].id}}'  {{$usergroup[u].check}}>{{$usergroup[u].groupname}}</td>{{if ($smarty.section.u.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/if}}
		{{/section}}
	</tr></table>
	  </td>
	  </tr>
	  <tr><td></td><td></td></tr>
		{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="20%" align=right  valign=top>
		{{$language.bind}}{{$language.User}}
		<table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已选择<input type="checkbox" name='showcheckeduser' {{if $smarty.get.binduser eq 1}}checked{{/if}} value=1 onclick="reload('binduser=1','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未选择<input type="checkbox" name='showuncheckeduser' {{if $smarty.get.binduser eq 2}}checked{{/if}} value=2 onclick="reload('binduser=2','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;"><input type="button" name='batchselect' class="an_06" value="批量选择" onclick="window.open('admin.php?controller=admin_pro&action=xzuser', 'newwindow','height=650, width=700, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');" ></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">全选<input type="checkbox" value=2 onclick="checkAll(this.checked);"></td></tr>
	  </table>
		</td>
		<td width="80%">
		<table><tr >
		{{section name=g loop=$allmem}}
		{{if !$smarty.get.binduser or ($smarty.get.binduser eq 2 and $allmem[g].check eq '') or ($smarty.get.binduser eq 1 and $allmem[g].check eq 'checked')}}
		<td width="180"><input type="checkbox" name='Check[]' value='{{$allmem[g].uid}}'  {{$allmem[g].check}}>{{if $allmem[g].binded}}<font color="red">{{/if}}{{$allmem[g].username}}({{if $allmem[g].realname}}{{$allmem[g].realname}}{{else}}未设置{{/if}}){{if $allmem[g].binded}}</font>{{/if}}</td>{{if ($smarty.section.g.index +1) % 5 == 0}}</tr><tr>{{/if}}
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

function checkAll(c){
	var targets = document.getElementsByTagName('input');
	for(var j=0; j<targets.length; j++){
		if(targets[j].name.substring(0,5)=='Check'){
			targets[j].checked=c;
		}
	}
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




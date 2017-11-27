<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />

<script language="javascript">
	function check_add_user(){
		return(true);
	}

var AllUsbKey = new Array();
var i=0;
{{section name=kk loop=$allusbkey}}
AllUsbKey[i++]='{{$allusbkey[kk].keyid}}';
{{/section}}
function filter(){
	var filterStr = document.getElementById('filtertext').value;
	var usbkeyid = document.getElementById('usbkeyid');
	usbkeyid.options.length=1;
	for(var i=0; i<AllUsbKey.length;i++){
		if(filterStr.length==0 || AllUsbKey[i].indexOf(filterStr) >= 0){
			usbkeyid.options[usbkeyid.options.length++] = new Option(AllUsbKey[i],AllUsbKey[i]);
		}
	}
}
</script>
<script language=javascript>  
//CharMode函数
//测试某个字符{{$language.Yes}}属于哪一类.  
function CharMode(iN){  
	if (iN>=48 && iN <=57) //数字  
		return 1;  
	if (iN>=65 && iN <=90) //大写字母  
		return 2;  
	if (iN>=97 && iN <=122) //小写  
		return 4;  
	else  
		return 8; //特殊字符  
}  
//bitTotal函数  
//计算出当前{{$language.Password}}当{{$language.normal}}一{{$language.all}}有多少种模式  
function bitTotal(num){  
	modes=0;  
	for (i=0;i<4;i++){  
		if (num & 1) modes++;  
		num>>>=1;  
	}  
	return modes;  
}  
//checkStrong函数  
//返回{{$language.Password}}的{{$language.strong}}度级别  
function checkStrong(sPW){  
	if (sPW.length<=8)  
	return 0; //{{$language.Password}}太短  
	Modes=0;  
	for (i=0;i<sPW.length;i++){  
	//测试每{{$language.one}}字符的类别并统计一{{$language.all}}有多少种模式.  
		Modes|=CharMode(sPW.charCodeAt(i));  
	}  
	return bitTotal(Modes);  
}  
//pwStrength函数  
//当{{$language.User}}放开键盘{{$language.or}}{{$language.Password}}{{$language.Input}}框失去焦点时,根据不同的级别{{$language.displayed}}不同的颜色  
function pwStrength(pwd){  
	O_color="#eeeeee";  
	L_color="#FF0000";  
	M_color="#FF9900";  
	H_color="#33CC00";  
if (pwd==null||pwd==''){  
	Lcolor=Mcolor=Hcolor=O_color;  
}else{  
	S_level=checkStrong(pwd);  
switch(S_level) {  
	case 0:  
	Lcolor=Mcolor=Hcolor=O_color;  
	case 1:  
	Lcolor=L_color;  
	Mcolor=Hcolor=O_color;  
	break;  
	case 2:  
	Lcolor=Mcolor=M_color;  
	Hcolor=O_color;  
	break;  
	default:  
	Lcolor=Mcolor=Hcolor=H_color;  
}  
}
document.getElementById("strength_L").style.background=Lcolor;  
document.getElementById("strength_M").style.background=Mcolor;  
document.getElementById("strength_H").style.background=Hcolor;  
return;  
}  
</script>  
<style>
A {
	COLOR: #000000; TEXT-DECORATION: none
}
#navbar {WIDTH: 98%; 
	
}
#header {
	LINE-HEIGHT: normal; WIDTH: 98%;  FONT-SIZE:12px; 
}
#header UL {
	 LIST-STYLE-TYPE: none; MARGIN: 0px 0px 0px 0px; height:27px;
}
#header LI {
	PADDING-BOTTOM: 0px; PADDING-LEFT: 0px; WIDTH: 109px; PADDING-RIGHT: 0px;  FLOAT: left;  color:#FFFFFF;   background-image:url({{$template_root}}/images/tab_bg2.jpg);height:32px; padding-top:5px;
}

#header A {
	PADDING-BOTTOM: 0px; PADDING-LEFT: 15px; PADDING-RIGHT: 15px; DISPLAY: block; PADDING-TOP: 5px;
}
#header .current {
	  BACKGROUND: #ffffff;   background-image:url({{$template_root}}/images/tab_bg1.jpg);
}
#header .current A {
	PADDING-BOTTOM: 0px; font-weight:bold; color:#FFFFFF;
}
.content {
	MARGIN-TOP: 0px;
}
.content .contentMain {
	TEXT-ALIGN: left
}
</style>
<script>
function change_option(number,index){
 for (var i = 1; i <= number; i++) {
      document.getElementById('current' + i).className = '';
      document.getElementById('content' + i).style.display = 'none';
 }
  document.getElementById('current' + index).className = 'current';
  document.getElementById('content' + index).style.display = 'block';
  return false;
}
</script>
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f1f1f1"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
     <li class="me_{{if $smarty.session.RADIUSUSERLIST}}b{{else}}a{{/if}}"><img src="{{$template_root}}/images/an1{{if $smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an3{{if $smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_{{if $smarty.session.RADIUSUSERLIST}}a{{else}}b{{/if}}"><img src="{{$template_root}}/images/an1{{if !$smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an3{{if !$smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul><span class="back_img"><A href="admin.php?controller=admin_member&action={{if $radiususer}}{{$radiususer}}{{else}}index{{/if}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
	 </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f1f1f1"><tr><td>	
	<form method="post" name="add_user" action="admin.php?controller=admin_member&action=save&uid={{$member.uid}}" onSubmit="javascript: return check_add_user();">
{{if $smarty.session.RADIUSUSERLIST}}
<table bordercolor="white" cellspacing="0" cellpadding="1" border="0" width="100%"  class="BBtable" >
<tr><th colspan="3" class="list_bg"></th></tr>
				{{assign var="trnumber" value=0}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>{{$language.Username}}：</td>
						<td><input type="text" name="username" class="wbk input_shorttext" {{if $member.uid}}readonly{{/if}} value="{{$member.username}}"></td>
					</tr>
				{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>{{$language.Password}}：</td>
						<td>
						<span style="float:left; padding-top:10px;"><input type="password" id="password1" name="password1" value="{{$member.password|escape}}" class="input_shorttext" onKeyUp=pwStrength(this.value) 
onBlur=pwStrength(this.value) > {{$pwdshould}} <input onClick="setrandompwd();" id="autosetpwd" type="checkbox" name="autosetpwd" value="1" />随机密码</span>
 <SPAN class="passwordcss">
                  <TABLE  border=0 cellSpacing=0  cellPadding=0 >
                    <TBODY>
                      <TR align=center bgColor=#F1F1F1>
                        <TD id=strength_L width="33%">弱</TD>
                        <TD id=strength_M width="33%">中</TD>
                        <TD id=strength_H  width="33%">强</TD>
                      </TR>
                    </TBODY>
                  </TABLE>
                </SPAN></td>
					</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>{{$language.Commitpassword}}：</td>
						<td><input type="password"  id="password2" name="password2" value="{{$member.password|escape}}" class="input_shorttext"></td>
						</tr>
					
					
					{{assign var="trnumber" value=$trnumber+1}}
					<tr id="loginleveltr" {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
               
                  <TD  width="33%" align=right>Cisco授权级别： </TD>
                  <TD><select  class="wbk"  name=priv>
                     	{{section name=k loop=16}}
				<option value="{{$smarty.section.k.index}}" {{if $smarty.section.k.index == $priv}}selected{{/if}}>{{$smarty.section.k.index}}</option>
			{{/section}}
                  </SELECT>                  
				  </TD>
                </TR>
				{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		{{$language.effectatdate}}：		</td>
       <TD>
       <INPUT value="{{$member.start_time}}" id="start_time" name="start_time" >&nbsp;&nbsp;
<input type="button"  id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk"></TD>
	</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		{{$language.Expiretime}}：		</td>
       <TD>
       
       <INPUT value="{{if $member.end_time ne '2037-01-01 00:00:00'}}{{$member.end_time}}{{/if}}" id="limit_time" name="limit_time" onFocus="setday(this)">&nbsp;&nbsp;<input type="button"  id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk"> 
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true,
	popupDirection:'up'
});
cal.manageFields("f_rangeStart_trigger", "start_time", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "limit_time", "%Y-%m-%d %H:%M:%S");


</script>
                      {{$language.AlwaysValid}}<INPUT value="1" {{if $member.end_time eq '2037-01-01 00:00:00' or !$member.end_time}} checked {{/if}} type=checkbox name="nolimit">  </TD>
	</tr>
		<tr><td>&nbsp;</td><td align="left"><input type=submit  value="保存修改" class="an_02"></td></tr></table>
		{{else}}
	 <DIV style="WIDTH:98%" id=navbar>
    <DIV id=header>
      <UL>
        <LI id=current1><A onclick="return change_option(2,1); return false;" href="#">基本信息</A> </LI>
        <LI id=current2><A onclick="return change_option(2,2); return false;" href="#">扩展信息</A> </LI>

      </UL>
    </DIV>
				 <div id="content1" class="content">
				   <div class="contentMain">
<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable" >
				{{assign var="trnumber" value=0}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>{{$language.Username}}：</td>
						<td><input type="text" name="username" class="wbk input_shorttext" {{if $member.uid}}readonly{{/if}} value="{{$member.username}}"></td>
					</tr>
				{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>{{$language.Password}}：</td>
						<td>
						<span style="float:left; padding-top:10px;"><input type="password" id="password1" name="password1" value="{{$member.password|escape}}" class="input_shorttext" onKeyUp=pwStrength(this.value) 
onBlur=pwStrength(this.value) > {{$pwdshould}} <input onClick="setrandompwd();" id="autosetpwd" type="checkbox" name="autosetpwd" value="1" />随机密码</span><span style="float:left; padding-left:10px;"><table valign="middle" width="217" border="1" cellspacing="0" cellpadding="1" bordercolor="#ffffff"
 style='display:inline' class="BBtable">  
<tr align="center" bgcolor="#eeeeee">  
<td width="33%" id="strength_L">{{$language.weak}}</td>  
<td width="33%" id="strength_M">{{$language.normal}}</td>  
<td width="33%" id="strength_H">{{$language.strong}}</td>  
</tr>  
</table></span></td>
					</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>{{$language.Commitpassword}}：</td>
						<td><input type="password"  id="password2" name="password2" value="{{$member.password|escape}}" class="input_shorttext"></td>
						</tr>
					
					
					

					<input type="hidden" name="priv" value=0 />
					{{assign var="trnumber" value=$trnumber+1}}
					{{if !$member.uid}}
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>运维审计权限：</td>
						<td><ul class="ul"><li style="width:100">
						<select  class="wbk"  name="level" onchange='changelevel(this.value);' {{if $smarty.session.ADMIN_LEVEL eq 3}}disabled='true'{{/if}}>
							<option value="0" {{if $member.level == 0}}selected{{/if}}>{{$language.common}}{{$language.User}}</option>
							<option value="1" {{if $member.level == 1}}selected{{/if}}>{{$language.Administrator}}</option>
							<option value="3" {{if $member.level == 3}}selected{{/if}}>{{$language.group}}{{$language.Administrator}}</option>
							<option value="2" {{if $member.level == 2}}selected{{/if}}>{{$language.auditadministrator}}</option>
							<option value="10" {{if $member.level == 10}}selected{{/if}}>{{$language.Password}}{{$language.Administrator}}</option>
							<option value="4" {{if $member.level == 4}}selected{{/if}}>配置{{$language.Administrator}}</option>
						</select></li><li id="common_user_pri_div">&nbsp;&nbsp;<input id="common_user_pri" type="checkbox" name="common_user_pri" {{if $member.common_user_pri}}checked{{/if}} value="on" />运维权限</li><li id="passwd_user_pri_div">&nbsp;&nbsp;<input id="passwd_user_pri" type="checkbox" name="passwd_user_pri" {{if $member.passwd_user_pri}}checked{{/if}} value="on" />密码权限</li><li id="audit_user_pri_div">&nbsp;&nbsp;<input id="audit_user_pri" type="checkbox" name="audit_user_pri" {{if $member.audit_user_pri}}checked{{/if}} value="on" />审计权限</li></ul>
						</td>
					</tr>
				{{/if}}
				{{if $member.level}}
				{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>具有运维权限：</td>
						<td>
						<input id="common_user_pri" type="checkbox" name="common_user_pri" {{if $member.common_user_pri}}checked{{/if}} value="on" />
						</td>
					</tr>
				{{/if}}
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>日志运维权限：</td>
						<td>
						<select  class="wbk"  name=log_priority {{if !$smarty.session.LOG_CONFIG_ON }} disabled{{/if}}>                     
							<option value="-1" {{if $member.log_priority eq -1}}selected{{/if}}>无</option>
							<option value="0" {{if $member.log_priority eq 0}}selected{{/if}}>普通用户</option>
							<option value="1" {{if $member.log_priority eq 1}}selected{{/if}}>管理员</option>
						</SELECT> 
						</td>
					</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>数据库运维权限：</td>
						<td>
						<select  class="wbk"  name=db_priority {{if !$smarty.session.DBAUDIT_CONFIG_ON }} disabled{{/if}}>                     
							<option value="-1" {{if !$member.db_priority eq -1}}selected{{/if}}>无</option>
							<option value="1" {{if $member.db_priority eq 1}}selected{{/if}}>管理员</option>
							<option value="2" {{if $member.db_priority eq 2}}selected{{/if}}>审计员</option>
						</SELECT> 
						</td>
					</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>认证方式：</td>
						<td>
						<select  class="wbk"  name=auth>                     
							<option value="0" {{if $member.auth eq 0}}selected{{/if}}>本地认证</option>
							<option value="1" {{if $member.auth eq 1}}selected{{/if}}>外部认证</option>
							<option value="2" {{if $member.auth eq 2}}selected{{/if}}>短信认证</option>
						</SELECT> 
						</td>
					</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>{{$language.Name}}：</td>
						<td><input type="text"  name="realname" class="wbk input_shorttext" value="{{$member.realname}}"></td>
					</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>{{$language.Mailbox}}：</td>
						<td><input type="text" name="email" class="wbk input_shorttext"value="{{$member.email}}"></td>
					</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td align="right" width="33%">手机号码:</td>
						<td>
						<input type="text" name="mobilenum" class="input_shorttext" value="{{$member.mobilenum}}">
						</td>
					</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td align="right" width="33%">工作单位:</td>
						<td>
						<input type="text" name="workcompany" class="input_shorttext" value="{{$member.workcompany}}">
						</td>
					</tr>
					 {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                  <TD  width="33%" align=right>{{$language.UserGroup}}： </TD>
                  <TD><select  class="wbk"  name=groupid id="usergroup">
                            <option value="" >无</option>
                     	{{section name=g loop=$usergroup}}
						<option value="{{$usergroup[g].id}}" {{if $usergroup[g].id == $member.groupid}}selected{{/if}}>{{$usergroup[g].groupname}}</option>
					{{/section}}
                  </SELECT>                  
				  </TD>
                </TR>
				{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="change_passwordtr">
		<TD width="33%" align=right>锁定：</TD>
                  <TD width="67%"><input type="checkbox" name="loginlock" value="on" {{if $member.loginlock}}checked{{/if}}>      </TD>
                </TR>  
                
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		{{$language.effectatdate}}：		</td>
       <TD>
       <INPUT value="{{$member.start_time}}" id="start_time" name="start_time" >&nbsp;&nbsp;
<input type="button"  id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk"></TD>
	</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		{{$language.Expiretime}}：		</td>
       <TD>
       
       <INPUT value="{{if $member.end_time ne '2037-01-01 00:00:00'}}{{$member.end_time}}{{/if}}" id="limit_time" name="limit_time" onFocus="setday(this)">&nbsp;&nbsp;<input type="button"  id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk"> 
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true,
	popupDirection:'up'
});
cal.manageFields("f_rangeStart_trigger", "start_time", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "limit_time", "%Y-%m-%d %H:%M:%S");


</script>
                      {{$language.AlwaysValid}}<INPUT value="1" {{if $member.end_time eq '2037-01-01 00:00:00' or !$member.end_time}} checked {{/if}} type=checkbox name="nolimit">  </TD>
	</tr></table>
				   </div>
				 </div>
				 <div id="content2" class="content" style="display:none">
				   <div class="contentMain"><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable" >
					{{assign var="trnumber" value=0}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                  <TD width="33%" align=right>{{$language.SourceIPGroup}}： </TD>
                  <TD><select  class="wbk"  name=sourceip>
                      <OPTION value="">{{$language.no}}</OPTION>
                     	{{section name=t loop=$sourceip}}
				<option value="{{$sourceip[t].groupname}}" {{if $sourceip[t].groupname == $member.sourceip}}selected{{/if}}>{{$sourceip[t].groupname}}</option>
			{{/section}}
                  </SELECT>                  
				  </TD>
                </TR>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td align="right" width="33%">公司名称:</td>
						<td>
						<input type="text" name="company" class="input_shorttext" value="{{$member.company}}">
						</td>
					</tr>
					{{if $create_log_user}}
					{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="allowviewlogtr">
		<TD width="33%" align=right>允许查看日志：</TD>
                  <TD width="67%"><input type="checkbox" name="allowviewlog" value="on" {{if $allowviewlog}}checked{{/if}}>      </TD>
                </TR>  
				{{/if}}
						{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="change_passwordtr">
		<TD width="33%" align=right>允许改密：</TD>
                  <TD width="67%"><input type="checkbox" name="allowchange" value="on" {{if $member.allowchange}}checked{{/if}}>      </TD>
                </TR>  
				{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="change_passwordtr">
		<TD width="33%" align=right>限制工具登录：</TD>
                  <TD width="67%"><input type="checkbox" name="restrictweb" value="on" {{if $member.restrictweb}}checked{{/if}}>      </TD>
                </TR>  
				{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td align="right" width="33%">RDP磁盘映射：</td>
						<td>
						<input type="checkbox" name="rdpdiskauth" class="" value="1" {{if $member.rdpdiskauth or !$member.uid}}checked{{/if}}>
						</td>
					</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td align="right" width="33%">RDP剪贴版：</td>
						<td>
						<input type="checkbox" name="rdpclipauth" class="" value="1" {{if $member.rdpclipauth or !$member.uid}}checked{{/if}}>
						</td>
					</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td align="right" width="33%">RDP磁盘映射：</td>
						<td>
						<input type="text" name="rdpdisk" class="input_shorttext" value="{{if !$member.uid}}*{{else}}{{$member.rdpdisk}}{{/if}}">例子C:;D:;E:;
						</td>
					</tr>
					
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>网络硬盘：</td>
						<td><input type="text" name="netdisksize" class="wbk input_shorttext" value="{{$member.netdisksize}}"> 
						MB</td>
					</tr>
					
				{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                  <TD  width="33%" align=right>usbkey： </TD>
                  <TD>含有字符<input type="text" class="wbk" size="10" id="filtertext" onChange="filter();" />
                  <select  class="wbk"  name=usbkey id="usbkeyid">
                      <OPTION value="">{{$language.nobind}}</OPTION>
                     	{{section name=k loop=$allusbkey}}
				<option value="{{$allusbkey[k].keyid}}" {{if $allusbkey[k].keyid == $member.usbkey}}selected{{/if}}>{{$allusbkey[k].keyid}}</option>
			{{/section}}
                  </SELECT>       
                  &nbsp;&nbsp;&nbsp;&nbsp;<a href="admin.php?controller=admin_member&action=create_file_usbkey&username={{$member.username}}" target="_blank">{{$language.createfilekey}}</a>           
				  </TD>
                </TR>
				
                {{assign var="trnumber" value=$trnumber+1}}
					<tr id="weektime" {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
               
                  <TD  width="33%" align=right>{{$language.WeekTimepolicy}}： </TD>
                  <TD><select  class="wbk"  name=weektime>
                      <OPTION value="">{{$language.no}}</OPTION>
                     	{{section name=k loop=$weektime}}
				<option value="{{$weektime[k].policyname}}" {{if $weektime[k].policyname == $member.weektime}}selected{{/if}}>{{$weektime[k].policyname}}</option>
			{{/section}}
                  </SELECT>                  
				  </TD>
                </TR>
                {{assign var="trnumber" value=$trnumber+1}}
					<tr id="vpnpool" {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                
                  <TD  width="33%" align=right>VPN IP： </TD>
                  <TD><input type="text" id="vpnip" name="vpnip" class="wbk input_shorttext" value="{{$member.vpnip}}"> &nbsp;&nbsp;&nbsp;&nbsp;  <input type="checkbox" name="vpn" id="vpn"  value="on" onclick="checkvpn(this.checked);"  {{if !$member.vpn}}checked{{/if}}>不允许使用vpn
				  </TD>
                </TR>
				
               
                {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                  <TD  width="33%" align=right>默认控件： </TD>
                  <TD><select  class="wbk"  name=default_control>
                     <OPTION value="0" {{if $member.default_control eq 0}}selected{{/if}}>自动检测</OPTION>
                     <OPTION value="1" {{if $member.default_control eq 1}}selected{{/if}}>applet</OPTION>
                     <OPTION value="2" {{if $member.default_control eq 2}}selected{{/if}}>activeX</OPTION>
                  </SELECT>                  
				  </TD>
                </TR>
				 {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                  <TD  width="33%" align=right>应用发布默认控件： </TD>
                  <TD><select  class="wbk"  name=default_appcontrol>
                     <OPTION value="0" {{if $member.default_appcontrol eq 0}}selected{{/if}}>WEB</OPTION>
                     <OPTION value="1" {{if $member.default_appcontrol eq 1}}selected{{/if}}>RDP</OPTION>
                  </SELECT>                  
				  </TD>
                </TR>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr id="mdevgrp" {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right>
						{{$language.ManagerDeviceGroup}}：						</td>
						<td >
						<select  class="wbk"  name="g_id" id="g_id">
						{{section name=g loop=$allgroup}}
							<OPTION VALUE="{{$allgroup[g].id}}" {{if $allgroup[g].id == $member.mservergroup}}selected{{/if}}>{{$allgroup[g].groupname}}</option>
						{{/section}}
						</select>
					  {{$language.ApplytoManager}}</td>
					</tr>

					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="musergrp">
                  <TD  width="33%" align=right >管理用户组 ：</TD>
                  <TD><select  class="wbk"  name=musergroup>
                     	{{section name=gg loop=$usergroup}}
						<option value="{{$usergroup[gg].id}}" {{if $usergroup[gg].id == $member.musergroup}}selected{{/if}}>{{$usergroup[gg].groupname}}</option>
					{{/section}}
                  </SELECT>{{$language.ApplytoManager}}
				  </TD>
                </TR>					
				</table>
				   </div>
				 </div>
			</div>
				

		</td>
	  </tr><tr><td align="center"><input type=submit  value="保存修改" class="an_02"></td></tr></table>
	  {{/if}}
			</form>
			
	</table>
<script>
function changelevel(iid){
	if(iid!=0){
		document.getElementById('mdevgrp').style.display = 'none';
		document.getElementById('musergrp').style.display = 'none';
		if(iid==3){
			document.getElementById('mdevgrp').style.display = 'block';
			document.getElementById('musergrp').style.display = 'block';			
			document.getElementById('vpnpool').style.display = 'none';
			document.getElementById('passwd_user_pri_div').style.display = '';
			document.getElementById('audit_user_pri_div').style.display = 'none';
			document.getElementById('common_user_pri_div').style.display = '';
		}else if(iid==1||iid==2){			
			document.getElementById('vpnpool').style.display = 'block';
			document.getElementById('passwd_user_pri_div').style.display = '';
			document.getElementById('audit_user_pri_div').style.display = 'none';
			document.getElementById('common_user_pri_div').style.display = '';
		}else if(iid==10){
			document.getElementById('vpnpool').style.display = 'block';
			document.getElementById('passwd_user_pri_div').style.display = 'none';
			document.getElementById('audit_user_pri_div').style.display = 'none';	
			document.getElementById('common_user_pri_div').style.display = 'none';				
		}else if(iid==4){			
			document.getElementById('vpnpool').style.display = 'none';
			document.getElementById('passwd_user_pri_div').style.display = '';
			document.getElementById('audit_user_pri_div').style.display = '';
			document.getElementById('common_user_pri_div').style.display = '';
		}
		document.getElementById('weektime').style.display = 'none';
		document.getElementById('change_passwordtr').style.display = 'none';
		document.getElementById('common_user_pri_div').style.display = '';
	}else{
		document.getElementById('weektime').style.display = 'block';
		document.getElementById('mdevgrp').style.display = 'none';
		document.getElementById('musergrp').style.display = 'none';
		document.getElementById('change_passwordtr').style.display = 'block';
		document.getElementById('passwd_user_pri_div').style.display = 'none';
		document.getElementById('audit_user_pri_div').style.display = 'none';		
		document.getElementById('common_user_pri_div').style.display = 'none';
	}
}
{{if $member.uid and $member.level > 0}}
	document.getElementById('weektime').style.display = 'none';
	
{{/if}}

function setrandompwd(){
	if(document.getElementById('autosetpwd').checked){
		document.getElementById('password1').value='abc123!@#';
		document.getElementById('password2').value='abc123!@#';
	}else{
		document.getElementById('password1').value='';
		document.getElementById('password2').value='';
	}
}

function checkvpn(checked){
	if(document.getElementById('vpn').checked){
		document.getElementById('vpnip').disabled=true;
	}else{
		document.getElementById('vpnip').disabled=false;
	}
}

{{if $member.level ne ''}}
changelevel({{$member.level}});
{{else}}
changelevel(0);
{{/if}}
{{if $smarty.session.ADMIN_LEVEL eq 3 and $smarty.session.ADMIN_MUSERGROUP}}
changelevel(0);
var ug = document.getElementById('usergroup');
for(var i=0; i<ug.options.length; i++){
	if(ug.options[i].value=={{$smarty.session.ADMIN_MUSERGROUP}}){
		ug.selectedIndex=i;
		ug.onchange = function(){ug.selectedIndex=i;}
		break;
	}
}
{{/if}}

checkvpn({{if $member.vpn}}true{{else}}false{{/if}})

</script>
<script>
change_option(2,1);
</script>
</body>
</html>



<html >
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery.csv-0.71.min.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />

<script language="javascript">
	function check_add_user(){
		return(true);
	}

var AllUsbKey = new Array();
var i=0;
{{section name=kk loop=$allusbkey}}
AllUsbKey[i++]={keyid:'{{$allusbkey[kk].keyid}}', type:{{$allusbkey[kk].type}}};
{{/section}}
function filter(){
	var filterStr = document.getElementById('filtertext').value;
	var usbkeyid = document.getElementById('usbkeyid');
	usbkeyid.options.length=1;
	for(var i=0; i<AllUsbKey.length;i++){
		if(filterStr.length==0 || AllUsbKey[i].keyid.indexOf(filterStr) >= 0){
			//if(usbkeytype==AllUsbKey[i].type){
				usbkeyid.options[usbkeyid.options.length++] = new Option(AllUsbKey[i].keyid,AllUsbKey[i].keyid);
			//}
		}
	}
}

function changeusbkeytype(t, v){
	var usbkeyid = document.getElementById('usbkeyid');
	usbkeyid.options[usbkeyid.options.length] = new Option('未绑定','');
	usbkeyid.options.length=1;
	for(var i=0; i<AllUsbKey.length;i++){
		//if(t==AllUsbKey[i].type){
			if(AllUsbKey[i].keyid==v){
				usbkeyid.options[usbkeyid.options.length++] = new Option(AllUsbKey[i].keyid,AllUsbKey[i].keyid, true, true);
			}else{
				usbkeyid.options[usbkeyid.options.length++] = new Option(AllUsbKey[i].keyid,AllUsbKey[i].keyid);
			}
		//}
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

{{if $_config.LDAP}}
var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();
var i=0;
{{section name=a loop=$allsgroup}}
servergroup[i++]={id:{{$allsgroup[a].id}},name:'{{$allsgroup[a].groupname}}',ldapid:{{$allsgroup[a].ldapid}},level:{{$allsgroup[a].level}}};
{{/section}}

{{/if}}

function changefirstauth(c,a){
	var s = document.getElementById('firstauth');
	if(!c)
	for(var i=0; i<s.options.length; i++){
		var at = (s.options[i].value.indexOf('_') > 0 ? s.options[i].value.substring(0, s.options[i].value.indexOf('_')) : s.options[i].value);
		if(at==a){
			s.options.remove(i);
			i--;
		}
	}
	else{
		switch(a){
			case 'ldapauth':
				{{section name=l loop=$ldaps}}
				s.options[s.options.length]=new Option('LDAP {{$ldaps[l].domain}}', 'ldapauth_{{$ldaps[l].address}}');
				{{/section}}
				break;
			case 'adauth':
				{{section name=a loop=$ads}}
				s.options[s.options.length]=new Option('AD {{$ads[a].domain}}', 'adauth_{{$ads[a].address}}');
				{{/section}}
				break;
			case 'localauth':
				s.options[s.options.length]=new Option('本地登录', 'localauth');
				break;
			case 'radiusauth':
				s.options[s.options.length]=new Option('RADIUS', 'radiusauth');
				break;
			case 'fingersecauth':
				s.options[s.options.length]=new Option('指纹认证', 'fingersecauth');
				break;
			case 'localfingersecauth':
				s.options[s.options.length]=new Option('本地+指纹认证', 'localfingersecauth');
				break;
		}
	}
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
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f1f1f1"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    
</ul><span class="back_img"><A href="admin.php?controller=admin_member&action={{if $radiususer}}{{$radiususer}}{{elseif $smarty.get.fromgroup}}groupuser&gid={{$smarty.get.fromgroup}}{{else}}index{{/if}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="25" border="0"></A></span>
</div></td></tr>
	 </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f1f1f1"><tr><TD align="left" >	<FORM onSubmit="javascript: return check_add_user();" method=post 
      name=add_user 
      action=admin.php?controller=admin_member&action=save&uid={{$member.uid}}>
      <input type="password" style="display:none"/> 
      {{if $smarty.session.RADIUSUSERLIST}}
<table bordercolor="white" cellspacing="0" cellpadding="1" border="0" width="100%"  class="BBtable" >
<tr><th colspan="3" class="list_bg"></th></tr>
				{{assign var="trnumber" value=0}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right><font color="red">*</font>{{$language.Username}}：</td>
						<TD align="left" ><input type="text" name="username" class="wbk input_shorttext" {{if $member.uid}}readonly{{/if}} value="{{$member.username}}"></td>
					</tr>
				{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td width="33%" align=right><font color="red">*</font>{{$language.Password}}：</td>
						<TD align="left" >
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
						<td width="33%" align=right><font color="red">*</font>{{$language.Commitpassword}}：</td>
						<TD align="left" ><input type="password"  id="password2" name="password2" value="{{$member.password|escape}}" class="input_shorttext"></td>
						</tr>
					
					
					{{assign var="trnumber" value=$trnumber+1}}
					<tr id="loginleveltr" {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
               
                  <TD  width="33%" align=right>Cisco授权级别： </TD>
                  <TD align="left" ><select  class="wbk"  name=priv>
                     	{{section name=k loop=16}}
				<option value="{{$smarty.section.k.index}}" {{if $smarty.section.k.index == $priv}}selected{{/if}}>{{$smarty.section.k.index}}</option>
			{{/section}}
                  </SELECT>  
                  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;动态口令卡：含有字符<input type="text" class="wbk" size="10" id="filtertext" {{if !$otpenable}}disabled{{/if}} onChange="filter();" />
                  <select  class="wbk"  name=usbkey id="usbkeyid"  {{if !$otpenable}}disabled{{/if}}>
                      <OPTION value="">{{$language.nobind}}</OPTION>
                     	{{section name=k loop=$allusbkey}}
							<option value="{{$allusbkey[k].keyid}}" {{if $allusbkey[k].keyid == $member.usbkey}}selected{{/if}} {{if $allusbkey[k].bind}}style="color:red"{{/if}}>{{$allusbkey[k].keyid}}</option>
						{{/section}}
                  </SELECT>&nbsp;&nbsp;
                 <select name="usbkeystatus" id="usbkeystatus">
                 <option value="11" {{if !$member.uid or $member.usbkeystatus eq 11}}selected{{/if}}>手机未扫描</option>
                 <option value="0" {{if $member.uid and $member.usbkeystatus eq 0}}selected{{/if}}>手机已扫描</option>
                 </select>            
				  </TD>
                </TR>
				{{assign var="trnumber" value=$trnumber+1}}
					<tr id="loginleveltr" {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
               
                  <TD  width="33%" align=right>神码交换机级别： </TD>
                  <TD align="left" ><input type="checkbox" name="shenmapriv" {{if !$member or $shenmapriv}}checked{{/if}} value=6>                  
				  </TD>
                </TR>
				{{assign var="trnumber" value=$trnumber+1}}
					<tr id="loginleveltr" {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
               
                  <TD  width="33%" align=right>华为授权级别： </TD>
                  <TD align="left" ><select  class="wbk"  name=huaweipriv>
                     	{{section name=h loop=16}}
				<option value="{{$smarty.section.h.index}}" {{if $smarty.section.h.index == $huaweipriv}}selected{{/if}}>{{$smarty.section.h.index}}</option>
			{{/section}}
                  </SELECT>                  
				  </TD>
                </TR>
				{{assign var="trnumber" value=$trnumber+1}}
					<tr id="loginleveltr" {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
               
                  <TD  width="33%" align=right>登录协议： </TD>
                  <TD align="left" ><input type="checkbox" name="radiusssh" {{if !$member.uid or $radiusssh}}checked{{/if}} value="1" />SSH&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="radiustelnet"  {{if !$member.uid or $radiustelnet}}checked{{/if}} value="1" />TELNET
				  </TD>
                </TR>
				{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		{{$language.effectatdate}}：		</td>
       <TD align="left" >
       <INPUT value="{{$member.start_time}}" id="start_time" name="start_time" >&nbsp;&nbsp;
<input type="button"  id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk"></TD>
	</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		{{$language.Expiretime}}：		</td>
       <TD align="left" >
       
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
                      {{$language.AlwaysValid}}<INPUT value="1" {{if $member.end_time eq '2037-01-01 00:00:00' or !$member.end_time}} checked {{/if}} onclick="document.getElementById('limit_time').value=''" type=checkbox name="nolimit">  </TD>
	</tr>
		<tr><TD align="left" >&nbsp;</td><td align="left"><input type=submit  value="保存修改" class="an_02"></td></tr></table>
		{{else}}
  <DIV style="WIDTH:98%" id=navbar>
    <DIV  class=content>
        <TABLE width="98%" border="0" align="center" cellpadding="5" 
      cellspacing="0" class="BBtable">
	  <TR>
      <TD height="27" colspan="4" class="tb_t_bg">基本信息</TD>
    </TR>
          <TR bgcolor="#f7f7f7">
            <TD width="14%" align="right"><font color="red">*</font>用户名：</TD>
            <TD width="36%" align="left" ><input type="text" name="username" class="wbk input_shorttext" {{if $member.uid}}readonly{{/if}} value="{{$member.username}}"></TD>
            <TD width="14%" align="right"><font color="red">*</font>真实姓名：</TD>
            <TD align="left" ><input type="text"  name="realname" class="wbk input_shorttext" value="{{$member.realname}}"></TD>
          </TR>
          <TR>
            <TD width="14%" align="right"><font color="red">*</font>密码：</TD>
            <TD width="36%" align="left" ><SPAN style=" padding-top:5px;float: left; width:250px;">
            
	 <input type="password" id="password1" name="password1" value="" class="input_shorttext" onKeyUp=pwStrength(this.value) 
onBlur=pwStrength(this.value) > {{$pwdshould}} <input onClick="setrandompwd();" id="autosetpwd" type="checkbox" name="autosetpwd" value="1" />
              随机密码</SPAN>
              <SPAN class="passwordcss">
                  <TABLE  border=0 cellSpacing=0  cellPadding=0 style="width:50px;">
                    <TBODY>
                      <TR align=center bgColor=#F1F1F1>
                        <TD id=strength_L width="33%">弱</TD>
                        <TD id=strength_M width="33%">中</TD>
                        <TD id=strength_H  width="33%">强</TD>
                      </TR>
                    </TBODY>
                  </TABLE>
                </SPAN></TD>
            <TD align="right"><font color="red">*</font>确认密码：</TD>
            <TD align="left" ><input type="password"  id="password2" name="password2" value="" class="input_shorttext">&nbsp;&nbsp;&nbsp;强制修改密码<input type="checkbox" name="forceeditpassword" value="on" {{if $member.forceeditpassword}}checked{{/if}}></TD>
          </TR>
          <TR bgcolor="#f7f7f7">
            <TD align="right">电子邮件：</TD>
            <TD align="left" ><input type="text" name="email" class="wbk input_shorttext"value="{{$member.email}}"></TD>
            <TD align="right">手机号码：</TD>
            <TD align="left" ><input type="text" name="mobilenum" class="input_shorttext" value="{{$member.mobilenum}}"></TD>
          </TR>
          <INPUT name="priv2" type="hidden" 
        value="0">
          <TR>
            <TD align="right">工作单位：</TD>
            <TD align="left" ><input type="text" name="workcompany" class="input_shorttext" value="{{$member.workcompany}}"> </TD>
            <TD align="right">工作部门：</TD>
            <TD align="left" ><INPUT name="workdepartment" class="input_shorttext" type="text" 
            value="{{$member.workdepartment}}">            </TD>
          </TR>
          <TR bgcolor="#f7f7f7">
            <TD align="right"><font color="red">*</font>运维组： </TD>
            <TD >
			{{include file="select_sgroup_ajax.tpl" }}   </TD>
            <TD align="right">证书CN：</TD>
      <TD align="left" ><input type="text" name="cacn" class="input_shorttext" value="{{$member.cacn}}" style="width:280px"></TD>
          </TR>
           <TR bgcolor="">
      <TD align="right">生效时间： </TD>
      <TD align="left" ><INPUT value="{{$member.start_time}}" id="start_time" name="start_time" >&nbsp;&nbsp;
<input type="button"  id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">
      </TD>
      <TD align="right">过期时间：</TD>
      <TD align="left" ><INPUT value="{{if $member.end_time ne '2037-01-01 00:00:00'}}{{$member.end_time}}{{/if}}" id="limit_time" name="limit_time" onFocus="setday(this)">&nbsp;&nbsp;<input type="button"  id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk"> 
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true,
	popupDirection:'up'
});
var cal2 = Calendar.setup({
    onSelect: function(cal2) { cal2.hide() },
    showTime: true,
	popupDirection:'up'
});
cal.manageFields("f_rangeStart_trigger", "start_time", "%Y-%m-%d %H:%M:%S");
cal2.manageFields("f_rangeEnd_trigger", "limit_time", "%Y-%m-%d %H:%M:%S");


</script>
                      {{$language.AlwaysValid}}<INPUT value="1" {{if $member.end_time eq '2037-01-01 00:00:00' or !$member.end_time}} checked {{/if}} onclick="document.getElementById('limit_time').value=''" type=checkbox name="nolimit"> 
      </TD>
    </TR>
	<TR bgcolor="#f7f7f7">
      <TD align="right">启用：</TD>
      <TD align="left" ><input type="checkbox" name="enable" value="on" {{if $member.enable || !$member.uid }}checked{{/if}}>&nbsp;&nbsp;&nbsp;&nbsp;</TD>
     <TD align="right">VPN ：</TD>
      <TD align="left" ><select  class="wbk"  name=vpn >                     
							<option value="0" {{if $member.vpn eq 0}}selected{{/if}}>不允许</option>
							<option value="1" {{if $member.vpn eq 1 || !$member.uid}}selected{{/if}}>允许</option>
						</SELECT>&nbsp;&nbsp;&nbsp;
						VPN IP<input type="text" name="vpnip" value="{{$member.vpnip}}" />
      </TD>
    </TR>
	
    <TR>
      <TD height="27" colspan="4" class="tb_t_bg">权限信息</TD>
    </TR>
    <TR bgcolor="#f7f7f7">
      <TD align="right">用户权限：</TD>
      <TD colspan="3"><ul style="LIST-STYLE-TYPE: none;"><li style=" float:left;width:100">
						<select  class="wbk"  name="level" onchange='changelevel(this.value);' {{if 0 and $member.uid}}disabled{{/if}}>
							<option value="11" {{if $member.level == 11}}selected{{/if}}>认证{{$language.User}}</option>
							<option value="1" {{if $member.level == 1}}selected{{/if}}>{{$language.Administrator}}</option>
						</select></li></ul>&nbsp;&nbsp;
    
	管理路径：
	{{assign var=checkbox value=1}}
	{{assign var=multipleselect value=1}}
	{{assign var=select_group_id value='mgroupid'}}
	{{include file="select_sgroup_ajax.tpl" }}
	</TD>
    </TR>
	<TR>
     
    </TR>
	
    <TR>
      
      <TD align="right" >动态口令卡： </TD>
      <TD align="left" colspan="3">含有字符<input type="text" class="wbk" size="10" id="filtertext" {{if !$otpenable}}disabled{{/if}} onChange="filter();" />
                  <select  class="wbk"  name=usbkey id="usbkeyid"  {{if !$otpenable}}disabled{{/if}}>
                      <OPTION value="">{{$language.nobind}}</OPTION>
                     	{{section name=k loop=$allusbkey}}
							<option value="{{$allusbkey[k].keyid}}" {{if $allusbkey[k].keyid == $member.usbkey}}selected{{/if}} {{if $allusbkey[k].bind}}style="color:red"{{/if}}>{{$allusbkey[k].keyid}}</option>
						{{/section}}
                  </SELECT>&nbsp;&nbsp;
                 <select name="usbkeystatus" id="usbkeystatus">
                 <option value="11" {{if !$member.uid or $member.usbkeystatus eq 11}}selected{{/if}}>手机未扫描</option>
                 <option value="0" {{if $member.uid and $member.usbkeystatus eq 0}}selected{{/if}}>手机已扫描</option>
                 </select>
                  </TD>
    </TR>
        </TABLE>
        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="60" align="center"> {{*{{if $otpenable}}{{if $member.usbkey eq ''}}<input type="button" onclick="document.getElementById('hide').src='admin.php?controller=admin_member&action=generateqrcode&uid={{$member.uid}}'" value="生成手机令牌" class="an_06">{{elseif $member.usbkey ne '' and $member.usbkeystatus eq 11}}<input type="button" onclick="document.getElementById('hide').src='admin.php?controller=admin_member&action=cancelqrcode&uid={{$member.uid}}'" value="取消手机令牌" class="an_06">{{elseif $member.usbkey ne ''}}<input type="button" onclick="document.getElementById('hide').src='admin.php?controller=admin_member&action=regenerateqrcode&uid={{$member.uid}}'" value="重新生成手机令牌" class="an_06">{{/if}}&nbsp;&nbsp;&nbsp;&nbsp;{{/if}}*}}{{if $member.uid}}<input type="button" onclick="document.getElementById('hide').src='admin.php?controller=admin_member&action=createca&uid={{$member.uid}}'" value="生成证书" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;{{/if}}<input type="submit"  value="保存修改" class="an_02"></td>
          </tr>
        </table>
    </DIV>
  </DIV>


<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
  {{/if}}
  <script>
function changelevel(iid){
	if(iid!=0){
		if(iid==3||iid==21||iid==101){
			{{if $_config.LDAP}}
			document.getElementById('mgroupiddpop').disabled = false;
			{{/if}}
			document.getElementById('passwd_user_pri').disabled = false;
			document.getElementById('audit_user_pri').disabled = true;
			document.getElementById('common_user_pri').disabled = false;
		}else if(iid==1||iid==2){			
			document.getElementById('passwd_user_pri').disabled = false;
			document.getElementById('audit_user_pri').disabled = true;
			document.getElementById('common_user_pri').disabled = false;
		}else if(iid==10){
			document.getElementById('passwd_user_pri').disabled = true;
			document.getElementById('audit_user_pri').disabled = true;
			document.getElementById('common_user_pri').disabled = true;		
		}else if(iid==4){			
			document.getElementById('passwd_user_pri').disabled = false;
			document.getElementById('audit_user_pri').disabled = false;
			document.getElementById('common_user_pri').disabled = false;
		}
		document.getElementById('allowchange').disabled = true;
		document.getElementById('common_user_pri').disabled = false;
	}else{
		{{if $_config.LDAP}}
			document.getElementById('mgroupiddpop').disabled = true;
		{{/if}}
		document.getElementById('allowchange').disabled = false;
		document.getElementById('passwd_user_pri').disabled = true;
		document.getElementById('audit_user_pri').disabled = true;
		document.getElementById('common_user_pri').disabled = true;		
	}
}

function GetRandomNum(Min,Max)
{   
var Range = Max - Min;   
var Rand = Math.random();   
return(Min + Math.round(Rand * Range));   
}   
var num = GetRandomNum(1,10);  

var numbers = ['0','1','2','3','4','5','6','7','8','9'];
var schars = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
var bchars = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
var sschars = ['~','!','@','#','$','%','^','&','*','(',')','<','>','?',':','"','{','}','\'',';','/','.',','];
var chars = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9','~','!','@','#','$','%','^','&','*','(',')','<','>','?',':','"','{','}','\'',';','/','.',','];

function generateMixed() {
	 var banword = '{{$pwdconfig_password_ban_word}}';
     var res = "";
	 for (var i=0; i<{{$pwdconfig_pwdstrong1}}; )
	 {
		var id = Math.ceil(Math.random()*(numbers.length-1));
		if(banword.indexOf(numbers[id])<0){
			res += numbers[id]
			i++;
		}
		
	 }
	 for (var i=0; i<{{$pwdconfig_pwdstrong2}};  )
	 {
		var id = Math.ceil(Math.random()*(schars.length-1));
		if(banword.indexOf(schars[id])<0){
			res += schars[id]
			i++;
		}
		
	 }
	 for (var i=0; i<{{$pwdconfig_pwdstrong3}}; )
	 {
		var id = Math.ceil(Math.random()*(bchars.length-1));
		if(banword.indexOf(bchars[id])<0){
			res += bchars[id]
			i++;
		}
		
	 }
	 for (var i=0; i<{{$pwdconfig_pwdstrong4}};  )
	 {
		var id = Math.ceil(Math.random()*(sschars.length-1));
		if(banword.indexOf(sschars[id])<0){
			res += sschars[id]
			i++;
		}
		
	 }
     for(var i = res.length; i <{{$pwdconfig_login_pwd_length}} ; ) {
		var id = Math.ceil(Math.random()*(chars.length-1));
		if(banword.indexOf(chars[id])<0){
			res += chars[id];
			i++;
		}
     }
     return res;
}

function setrandompwd(){
	if(document.getElementById('autosetpwd').checked){
		var pwd = generateMixed();
		document.getElementById('password1').value=pwd;
		document.getElementById('password2').value=pwd;
	}else{
		document.getElementById('password1').value='';
		document.getElementById('password2').value='';
	}
}

function checkvpn(checked){
	if(document.getElementById('vpn').checked){
		document.getElementById('vpnip').disabled=true;
	}else{
		{{if $vpnenable}}
		document.getElementById('vpnip').disabled = false;
		{{/if}}
	}
}

//checkvpn({{if $member.vpn}}true{{else}}false{{/if}})

{{if $_config.LDAP}}
{{$changelevelstr}}
{{$mchangelevelstr}}
{{/if}}
{{if $member.level ne ''}}
changelevel({{$member.level}});
{{else}}
changelevel(0);
{{/if}}

</script>
</FORM>
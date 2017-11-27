<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>login</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<LINK rel=stylesheet type=text/css href="{{$template_root}}/cssjs/all_purpose_style.css">
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<META name=GENERATOR content="MSHTML 9.00.8112.16470">
</HEAD>
<BODY>
<P>&nbsp;</P>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div style=" margin:0 auto; width:634px;">
<TABLE width="634" border=0 align=center cellPadding=0 cellSpacing=0>
      <FORM name="l" id="doAmsForm" action="admin.php?controller=admin_index&amp;action=chklogin&amp;ref=" 
      method="post" target="_top" >  <TBODY>
  <TR>
    <TD align=center><IMG border=0 src="logo/logo1.jpg" 
      width=634 height=73></TD>
  </TR>
  <TR>
    <TD height=251 align=center valign="top" background="{{$template_root}}/images/bottom_bg.jpg"><table width="60%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="180" align="center" valign="middle"><table width="95%" border="0" cellpadding="5" cellspacing="1" bgcolor="a8c6d8" cellpadding="0">
		{{if $dpwdtime}}
          <tr>
            <td height="32" bgcolor="dae4e4"><strong> &nbsp;欢迎登陆</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> &nbsp;{{$datetime}}</strong></td>
          </tr>
		  {{else}}
		  <tr>
              <td height="35" align="center" background="{{$template_root}}/images/dl_bg.jpg"><font style="font-size:14px; font-weight:bold; color:#005d9d;"> 欢迎登陆</font></td>
            </tr>
		  {{/if}}
          <tr>
            <td bgcolor="ffffff"><TABLE width="100%" border="0" cellspacing="1" 
cellpadding="0">
              <TBODY>
                <TR>
                  <TD width="{{if !$logintype.ldapauth and !$logintype.radiusauth and !$logintype.adauth or !$loginauthtype}}35{{else}}30{{/if}}%" height="{{if $dpwdtime}}30{{else}}40{{/if}}" align="right" bgcolor="#edf6f6">用户名：</TD>
                  <TD width="" id="tdusername">
{{if $Certificate eq 2 or !$Certificate}}
{{if $memberscount eq 0}}
<input type="text" name="username" id="username"  onblur="changeusername(this.value,'u');" {{if $nametype eq 'realname'}}disabled='disabled'{{/if}}  style="width: {{if 1 or !$logintype.ldapauth and !$logintype.radiusauth and !$logintype.adauth and !$logintype.fingersecauth and !$logintype.localfingersecauth or !$loginauthtype or !$loginauthtype}}200{{else}}100{{/if}}px;{{if !$dpwdtime}}height:24px;{{/if}}{{if $nametype eq 'realname'}}display:none{{/if}}">
<input type="text" name="username" id="realname"  onblur="changeusername(this.value,'r');" {{if $nametype eq 'username' or !$nametype}}disabled='disabled'{{/if}}  style="width: {{if 1 or !$logintype.ldapauth and !$logintype.radiusauth and !$logintype.adauth and !$logintype.fingersecauth and !$logintype.localfingersecauth or !$loginauthtype or !$loginauthtype}}200{{else}}100{{/if}}px;{{if !$dpwdtime}}height:24px;{{/if}}{{if $nametype eq 'username'}}display:none{{/if}}">

{{else}}
<select name='username' id="username"  style="width: {{if !$logintype.ldapauth and !$logintype.radiusauth and !$logintype.adauth and !$logintype.fingersecauth and !$logintype.localfingersecauth or !$loginauthtype or !$loginauthtype}}155{{else}}200{{/if}}px;{{if !$dpwdtime}}height:24px;{{/if}}">
{{section name=m loop=$members}}
<option value='{{$members[m].username}}'  {{if $smarty.cookies.username eq $members[m].username}}selected{{/if}}  >{{$members[m].username}}</option>
{{/section}}
</select>
<select name='username' id="realname" disabled style="width: {{if !$logintype.ldapauth and !$logintype.radiusauth and !$logintype.adauth and !$logintype.fingersecauth and !$logintype.localfingersecauth or !$loginauthtype or !$loginauthtype}}155{{else}}200{{/if}}px;{{if !$dpwdtime}}height:24px;{{/if}}display:none">
{{section name=n loop=$members}}
<option value='{{$members[n].realname}}'  {{if $smarty.cookies.username eq $members[m].realname}}selected{{/if}}  >{{$members[n].realname}}</option>
{{/section}}
</select>
{{/if}}
{{if $loginauthtype}}
{{if 1 or !$logintype.ldapauth and !$logintype.radiusauth and !$logintype.adauth and !$logintype.fingersecauth and !$logintype.localfingersecauth}}
<input type="hidden" name="authtype" id="authtype" value="localauth">
{{else}}
<select name='authtype' id="authtype" style="width:95px;{{if !$dpwdtime}}height:24px;{{/if}}" onchange="changeauthtype(this.value);">
<option value='localauth' {{if $authtype eq 'localauth'}}selected{{/if}}>本地认证</option>
{{if $logintype.radiusauth}}
<option value='radiusauth' {{if $authtype eq 'radiusauth'}}selected{{/if}}>RADIUS认证</option>
{{/if}}
{{if $logintype.ldapauth}}
{{section name=l loop=$ldaps}}
<option value='ldapauth_{{$ldaps[l].address}}' {{if $authtype eq 'ldapauth'}}selected{{/if}}>LDAP {{$ldaps[l].domain}}</option>
{{/section}}
{{/if}}
{{if $logintype.adauth}}
{{section name=a loop=$ads}}
<option value='adauth_{{$ads[a].address}}' {{if $authtype eq 'adauth'}}selected{{/if}}>AD {{$ads[a].domain}}</option>
{{/section}}
{{/if}}

{{if $logintype.fingersecauth}}
<option value='fingersecauth' {{if $authtype eq 'fingersecauth'}}selected{{/if}}>指纹认证</option>
{{/if}}
{{if $logintype.localfingersecauth}}
<option value='localfingersecauth' {{if $authtype eq 'localfingersecauth'}}selected{{/if}}>本地+指纹认证</option>
{{/if}}
{{/if}}
</select>
<input type="hidden" name="memberscount" id="memberscountid" value="{{$memberscount}}" />
<input type="hidden" name="cacn" id="cacn" value="{{$cacn}}" />
{{/if}}
{{/if}}
                  </TD>
                </TR>
                <TR id="passwordstr">
                  <TD height="{{if $dpwdtime}}30{{else}}40{{/if}}" align="right" 
                      bgcolor="#edf6f6">口&nbsp;令：</TD>
                  <TD><INPUT name="password" id="textfield2" autocomplete="off" style="width: {{if !$logintype.ldapauth and !$logintype.radiusauth and !$logintype.adauth and !$logintype.fingersecauth and !$logintype.localfingersecauth or !$loginauthtype or !$loginauthtype}}155{{else}}200{{/if}}px;{{if !$dpwdtime}}height:24px;{{/if}}" type="password"></TD>
                </TR>
				{{if $dpwdtime}}
                <TR id="dongtaitr">
                  <TD height="30" align="right" bgcolor="#edf6f6">动态密码：</TD>
                  <TD><INPUT name="dpassword" autocomplete="off" id="textfield22" style="width: {{if !$logintype.ldapauth and !$logintype.radiusauth and !$logintype.adauth and !$logintype.fingersecauth and !$logintype.localfingersecauth or !$loginauthtype or !$loginauthtype}}155{{else}}200{{/if}}px; color: rgb(153, 153, 153);" onFocus="if(value==defaultValue){value='';this.style.color='#000'}" onBlur="if(!value){value=defaultValue;this.style.color='#999'}" type="text" placeholder="令牌用户输入"></TD>
                </TR>
                <TR id="renztr">
                  <TD height="30" align="right" bgcolor="#edf6f6">认证方式：</TD>
                  <TD><INPUT name="nametype" id="radio" onClick="changelogintype('username');" 
                        type="radio" checked="" {{if $nametype eq 'username'}}checked{{/if}} value="username">
                    登录名
                    <INPUT name="nametype" id="radio2" 
                        onclick="changelogintype('realname');" type="radio" {{if $nametype eq 'realname'}}checked{{/if}} 
                        value="realname">
                    别名</TD>
                </TR>
				{{/if}}
				 <tr id="fingertr" style="display:none">
	   <td align='center' colspan="2">
		 <div class="bder" id="fingerDiv">
  <object id='TLFPAPICtrl' name='TLFPAPICtrl' width="98px" height="85px" classid="CLSID:57FA9034-0DC3-4882-A932-DDDA228FEE05" style="padding-top:-40px;" >
	<param name="Token" value="12345678912345678912345678912345" />
	<param name="CtrlType" value="Verify" />
		<embed id="pluginobj" type="application/mozilla-TLFPAPICtrl-plugin" width="98px" height="85px" Token="12345678912345678912345678912345"                  CtrlType="Verify" style="padding-top:-40px;">
		</embed>											
   </object>
</div>
	   </td>
	  </tr>
              </TBODY>
            </TABLE></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="35" align="center">
			<input name="fpdata" type="hidden" id="fpdata" value="" />
		<input name="button" type="submit" class="{{if 0&&$dpwdtime}}dl_btn1{{else}}btn1{{/if}}" id="button" value="登 录"></td>
      </tr>
    </table></TD>
  </TR>
  </FORM></TABLE>
  </div>
   {{if $Certificate eq 1}}
  <OBJECT id="capicom" codeBase="capicom.cab#version=2,0,0,3" classid="clsid:A996E48C-D3DC-4244-89F7-AFA33EC60679" VIEWASTEXT>
</OBJECT>
{{/if}}
  <script >
 /* {{if $memberscount gt 0}}
  Members = new Array();
  var i=0;
  {{section name=n loop=$members}}
  Members[i++]={username: '{{$members[n].username}}', realname: '{{$members[n].realname}}'};
  {{/section}}
  {{/if}}*/
  
 function changeauthtype(atype){
	if(atype=="fingersecauth"||atype=="localfingersecauth"){
		document.getElementById('dongtaitr').style.display='none';
		document.getElementById('renztr').style.display='none';
		document.getElementById('fingertr').style.display='';
		document.getElementById('passwordstr').style.display='';
		if(atype=="fingersecauth"){
			document.getElementById('passwordstr').style.display='none';
		}
	}else{
		document.getElementById('fingertr').style.display='none';
		document.getElementById('passwordstr').style.display='';
		document.getElementById('dongtaitr').style.display='';
		document.getElementById('renztr').style.display='';
	}
  }

 function changelogintype(ltype)
  {
	  {{if $Certificate}}
    if(ltype=='username'){
		document.getElementById('username').style.display='';
		document.getElementById('username').disabled=false;
		document.getElementById('realname').style.display='none';
		document.getElementById('realname').disabled=true;
	}else{
		document.getElementById('username').style.display='none';
		document.getElementById('username').disabled=true;
		document.getElementById('realname').style.display='';
		document.getElementById('realname').disabled=false;
	}
	  {{/if}}
  }
{{if $Certificate eq 1}}
function trimStr(str){return str.replace(/(^\s*)|(\s*$)/g,"");}
function getClientID()
{
	var CAPICOM_CURRENT_USER_STORE = 2;
	var CAPICOM_MY_STORE = "my";//读取的目录名称，如果读取个人证书则应该写入变量"my",如果是根证书则是root
	var CAPICOM_STORE_OPEN_READ_WRITE=1;

	var myStore = new ActiveXObject("CAPICOM.Store");

	myStore.Open(CAPICOM_CURRENT_USER_STORE,CAPICOM_MY_STORE,CAPICOM_STORE_OPEN_READ_WRITE); 
	var myStoreCerts = myStore.Certificates;

	// 获取所有my证书的名字
	var info="";
	for(i = 1; i<= myStoreCerts.Count; i++)
	{  
	   var itmp = myStoreCerts.Item(i).subjectname.split(','); //SerialNumber
	   for(var j=0; j<itmp.length; j++){	  
		   var jtmp = itmp[j].split('=');
		   jtmp[0]=trimStr(jtmp[0]);
		   if(jtmp[0]=='CN'){
			info += trimStr(jtmp[1]) + ";";  
		   }
	   }	  	   
	}
	return info;
}

var url="admin.php?controller=admin_index&action=login_user_field&cacn="+getClientID();//alert(url);
  $.get(url, {Action:"get",Name:"lulu","1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; //在这里this指向的是Ajax请求的选项配置信息，请参考下图
		document.getElementById('tdusername').innerHTML = data;
		memberscount=document.getElementById('memberscountid').value;
	});
{{else}}
changelogintype('{{$nametype}}')
{{/if}}
 function checkdpwd(){
 	var obj = document.getElementById('textfield22');
 	if(obj==null||obj==undefined||obj.value==''||/^[0-9a-z]+$/.test(obj.value)){
 		return true;
 	}
 	alert('动态密码请输入小写字母或数字');
 	return false;
 }
function changeusername(username,t){
var url="admin.php?controller=admin_index&action=get_user_login_fristauth&username="+username+"&t="+t;//alert(url);
  $.get(url, {Action:"get",Name:"lulu","1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; //在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//document.getElementById('authtype').options.selectedIndex=
		if(data=='') return ;
		$("#authtype").val(data);
		changeauthtype(data);
	});
}
changeauthtype(document.getElementById('authtype').options[document.getElementById('authtype').options.selectedIndex].value);
  </script>
<script type="text/javascript" src="{{$template_root}}/cssjs/finger.js"></script>
<script for="TLFPAPICtrl" event="GotFeatureEvent()" language="javascript">hasGotFeatureEvent();</script>
</BODY></HTML>

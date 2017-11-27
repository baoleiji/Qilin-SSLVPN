<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0090)http://114.255.20.254/newradius/admin.php -->
<HTML><HEAD><TITLE>{{$language.Add}}{{$language.User}}</TITLE><LINK rel=stylesheet type=text/css 
href="{{$template_root}}/images/content.css">
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18372">

</HEAD>
<BODY>
<CENTER><BR><BR>
  <table width="95%" border="0" cellpadding="1" cellspacing="1" bgcolor="3c84cc">
    <tr>
      <td class="td_bg"><TABLE border=0 cellSpacing=0 cellPadding=2 width="100%">
        <TBODY>
          <TR vAlign=top align=right>
            <TD class=td_title height=25 width="35%" align=left>{{$language.Add}}{{$language.User}} </TD>
            </TR>
        </TBODY>
      </TABLE>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><FORM onSubmit="return check()" method=post 
                                name=f1 
                                action="admin.php?controller=admin_user&action=user_save&ntype={{$ntype}}&uid={{$uid}}">
              <TABLE border=0 cellSpacing=1 cellPadding=5 
                                width=99% bgColor=#ffffff valign="top">
                <TBODY>
                  <TR>
                    <TD width="25%" align=right class="td_lefttitle">{{$language.Username}} </TD>
                    <TD class="td_line"><INPUT size=35 name=username value="{{$username}}" {{if $ntype == 'old'}}disabled="disabled"{{/if}} >                    </TD>
                  </TR>
                  <TR>
                    <TD align=right class="td_lefttitle">{{$language.Password}} </TD>
                    <TD class="td_line"><INPUT size=35 type=password name=passwd >  {{if $ntype == 'old'}}留空为不{{$language.Edit}}{{/if}}</TD>
                  </TR>
                  
                  <TR>
                    <TD align=right class="td_lefttitle">{{$language.Commitpassword}} </TD>
                    <TD class="td_line"><INPUT size=35 type=password name=repasswd>                    </TD>
                  </TR>

	<input type="hidden" name="newuser" value="{{$ntype}}">
                <TR>
                  <TD align=right class="td_lefttitle">E-mail </TD>
                  <TD class="td_line"><INPUT size=35 name=email value = "{{$email}}">                  </TD>
                </TR>
                <TR>
                  <TD align=right class="td_lefttitle">所在{{$language.group}}</TD>
                  <TD class="td_line"><select  class="wbk"  name=group>
                      <OPTION value=0>非{{$language.group}}成员</OPTION>
		{{section name=g loop=$allgroup}}
			<OPTION VALUE="{{$allgroup[g].name}}" {{if $allgroup[g].name == $gname}}selected{{/if}}>{{$allgroup[g].name}}</option>
		{{/section}}
                  </SELECT>                  </TD>
                </TR>
                <TR>
                  <TD align=right class="td_lefttitle">可访问的{{$language.device}} </TD>
                  <TD class="td_line"><select  class="wbk"  name=objequip>
                      <OPTION
                                value=0>任意</OPTION>
                      	{{section name=obj loop=$allobjequip}}
				<option value="{{$allobjequip[obj].groupname}}" {{if $allobjequip[obj].groupname == $objgname}}selected{{/if}}>{{$allobjequip[obj].groupname}}</option>
			{{/section}}
                  </SELECT>                  </TD>
                </TR>
				{{*
                <TR>
                  <TD align=right class="td_lefttitle">{{$language.bind}}保护{{$language.ServerGroup}} </TD>
                  <TD class="td_line"><select  class="wbk"  name='rserver'>
				                        <OPTION value=0>{{$language.no}}</OPTION>
                      	{{section name=so loop=$allserver}}
				<option value="{{$allserver[so].g_ID}}" {{if $allserver[so].g_ID == $server_id}}selected{{/if}}>{{$allserver[so].g_Name}}</option>
			{{/section}}
                  </SELECT>                  </TD>
                </TR>
				*}}
                <TR>
                  <TD align=right class="td_lefttitle">登陆级别 </TD>
                  <TD class="td_line"><select  class="wbk"  name=priv>
	    {{section name=p loop=16}}
		<option value="{{$smarty.section.p.index}}" {{if $smarty.section.p.index == $priv }}selected{{/if}} >{{$smarty.section.p.index}}</option>
	    {{/section}}                  </SELECT>                  </TD>
                </TR>
                <TR>
                  <TD align=right class="td_lefttitle">提示信息 </TD>
                  <TD class="td_line"><TEXTAREA name=message>{{$message}}</TEXTAREA>                  </TD>
                </TR>
                <TR>
                  <TD align=right class="td_lefttitle">usbkey </TD>
                  <TD class="td_line"><select  class="wbk"  name=usbkey>
                      <OPTION value=0>{{$language.nobind}}</OPTION>
                     	{{section name=k loop=$allusbkey}}
				<option value="{{$allusbkey[k].id}}" {{if $allusbkey[k].id == $ukid}}selected{{/if}}>{{$allusbkey[k].keyid}}</option>
			{{/section}}
                  </SELECT>                  </TD>
                </TR>
                <TR>
                  <TD align=right class="td_lefttitle">wmkey </TD>
                  <TD class="td_line"><select  class="wbk"  name=wmkey>
                      <OPTION 
                                value=0>{{$language.nobind}}</OPTION>
			{{section name=k loop=$allwmkey}}
				<option value="{{$allwmkey[k].id}}" {{if $allwmkey[k].id == $wkid}}selected{{/if}}>{{$allwmkey[k].keyid}}</option>
			{{/section}}
                  </SELECT>                  </TD>
                </TR>
                <TR>
                  <TD align=right class="td_lefttitle">enable </TD>
                  <TD class="td_line"><INPUT {{if $enable == 1}} checked {{/if}} type=checkbox name=enable>                  </TD>
                </TR>
                <TR>
                  <TD align=right class="td_lefttitle">{{$language.Expiretime}} </TD>
                  <TD class="td_line"><INPUT value="{{$lastdate}}" id=startdate readOnly name=startdate>
                      <IMG onClick="getDatePicker('startdate', event)" 
                                src="{{$template_root}}/images/time.gif"> {{$language.clicktoselectdate}} </TD>
                </TR>
                <TR>
                  <TD align=right class="td_lefttitle">发送邮件间隔 </TD>
                  <TD class="td_line"><INPUT name=time value="{{$day}}">                  </TD>
                </TR>
                </TABLE>
              <BR>
              <INPUT class=button value="{{$title}}" type=submit>
              <BR>
              <BR>
            </FORM>
             <SCRIPT language=javascript 
                        src="{{$template_root}}/images/selectdate.js"></SCRIPT>

                        <SCRIPT language=javascript>
<!--
function email(word)
{
  mail=/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
  return mail.test(word);
} 
function check()
{
   if(f1.username.value==""){alert("{{$language.Username}}不能为空!");return false;}
   if(f1.passwd.value!=f1.repasswd.value){alert("{{$language.Passwordunlike}}!");return false;}
   if (f1.passwd.value.length < 6 && f1.newuser.value == 'new') {
   	  alert("{{$language.Password}}{{$language.strong}}度过低,请使用数字大小写字母{{$language.group}}合且{{$language.Password}}不少于六位！");
	  f1.passwd.focus();
	  f1.passwd.select();
	  return false;
   }
   if(email(f1.email.value)==false){alert("email 地址格式不正确!");return false;}
   if(check_date(f1.startdate.value)==false){alert("{{$language.Input}}的{{$language.day}}期格式不正确,正确格式为四位年-月-{{$language.day}}");return false;}
   return true;
}//end check
// -->

function check_date(riqi)
{
  is_date=/^(\d{4})\-(\d{2})\-(\d{2})$/;  
  return is_date.test(riqi);
} 

var siteUrl = "template/images/date/";
</SCRIPT></td>
          </tr>
        </table></td>
    </tr>
  </table>
</body>

</html>



<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>
<script>
function userlogin(aid,tid){
	tid = document.getElementById(tid);
	aid = document.getElementById(aid);
	aid.href=aid.href + "&logintool=" + tid.options[tid.options.selectedIndex].value;
}
</script>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td  class="hui_bj">{{$title}}</td>
          
          
          <td width="2"><img src="{{$template_root}}/images/main_right.gif" width="2" height="31"></td>
        </tr>

      </table></td>
  </tr>
   <tr>
    <td class="main_content">
<form action="{{$curr_url}}" method="post" name="report" >
IP：<input type="text" class="wbk" id="sip" name="sip" value="{{$sip}}" ><input type="submit" name="submit" value="{{$language.Commit}}" />
{{if $admin_level == 0}}
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;负载均衡：<select  class="wbk"  id="lb" name="lb" >
<option value="{{$localip}}">{{$localip}}</option>
{{section name=l loop=$lb}}
<option value="{{$lb[l].ip}}">{{$lb[l].ip}}</option>
{{/section}}
</select><select  class="wbk"  id="app_act" style="display:none"><option value="applet" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'applet'}}selected{{/if}}>applet</option><option value="activeX" {{if $smarty.session.ADMIN_DEFAULT_CONTROL eq 'activeX'}}selected{{/if}}>activeX</option></select>
{{/if}}
</form>
	  </td>
  </tr>
  <tr>
	<td class="main_content">
<TABLE border=0 cellSpacing=1 cellPadding=5 width="100%" bgColor=#ffffff valign="top">
                <TBODY>
				
                  <TR>
                    <th class="list_bg"  width="9%">应用服务器名</TD>
					 <th class="list_bg"  width="6%">应用服务器地址</TD>
                   
                   	<th class="list_bg"  width="30%">{{$language.Operate}}</TD>
                  </TR>
			{{section name=t loop=$alldev}}
			<tr bgcolor='{{if $smarty.section.t.index % 2 == 0}}f7f7f7{{/if}}'>
				<td>{{$alldev[t].name}}</td>
				<td>{{$alldev[t].appserverip}}</td>
			
				<td class="td_line" width="30%">			
				登录(
					<a id="a{{$alldev[t].id}}1" onclick="rdpgo({{$alldev[t].id}});return false;" href='admin.php?controller=admin_index&rdptype=activex&action=appdev_login&id={{$alldev[t].id}}'>{{$language.LocalUser}}</a>
					<select  class="wbk"  name='fenbianlv' id='fenbianlv{{$alldev[t].id}}' > 
					<option value="3">全屏</option>
					<option value="1">800*600</option>
					<option value="2">1024*768</option>
					</select>
					<a id="a{{$alldev[t].id}}2" onclick="rdpgo2({{$alldev[t].id}})" href='#' target="_blank">WEB</a>
					<select  class="wbk"  name='fenbianlv' id='fenbianlv2{{$alldev[t].id}}' >
					<option value="1">全屏</option>
					<option value="3" selected>800*600</option>
					<option value="4">1024*768</option>
					</select>
					)&nbsp;&nbsp;<a onclick="window.open ('admin.php?controller=admin_index&action=apppub_list&appserver={{$alldev[t].appserverip}}&id={{$alldev[t].id}}', 'newwindow', 'height=230, width=200, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href="#" target="_blank" >查看应用</a>
				
				</td> 
			</tr>
			{{/section}}
                <tr>
	           <td  colspan="7">
		   			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_index&action=dev_index&page='+this.value;">{{$language.page}}
		   </td>
		</tr>
		</TBODY>
              </TABLE>
	</td>
  </tr>
</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}
function rdpgo(iid){
	var fenbian = document.getElementById('fenbianlv'+iid).options[document.getElementById('fenbianlv'+iid).selectedIndex].value;
	var hid = document.getElementById('hide');
	var lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	
	hid.src='admin.php?controller=admin_index&action=appdev_login&id='+iid+'&screen='+fenbian+'&selectedip='+lbip+'&app_act='+app_act;
//alert(hid.src);
	{{if $logindebug}}
	window.open(document.getElementById('hide').src);
	{{/if}}
	return false;	
}
function rdpgo2(iid){
	var fenbian = document.getElementById('fenbianlv2'+iid).options[document.getElementById('fenbianlv2'+iid).selectedIndex].value;
	var hid = document.getElementById('hide');
	var lbip = document.getElementById('lb').options[document.getElementById('lb').options.selectedIndex].value;
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	
	document.getElementById('a'+iid+'2').href='admin.php?controller=admin_index&rdptype=activex&action=appdev_login&id='+iid+'&screen='+fenbian+'&selectedip='+lbip+'&app_act='+app_act;
	//alert(hid.src);
{{if $logindebug}}
	window.open(document.getElementById('hide').src);
{{/if}}
	return true;	
}


{{if $member.default_control eq 0}}
if(navigator.userAgent.indexOf("MSIE")>0) {
    document.getElementById('app_act').options.selectedIndex = 1;
}
{{elseif $member.default_control eq 1}}
document.getElementById('app_act').options.selectedIndex = 0;
{{elseif $member.default_control eq 2}}
document.getElementById('app_act').options.selectedIndex = 1;
{{/if}}
</script>
</body>
<iframe id="hide" name="hide" height="0"  frameborder="0" scrolling="no"></iframe>
</html>



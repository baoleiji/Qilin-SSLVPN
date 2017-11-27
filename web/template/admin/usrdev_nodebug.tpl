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
IP：<input type="text" class="wbk" id="sip" name="sip" value="{{$sip}}" ><input type="submit" name="submit" value="提交" />
</form> 
	  </td>
  </tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                <TBODY>
                  <TR>
                    <th class="list_bg"  width="10%">服务器地址</TD>
                    {{if $type ne 'fort'}}
                    <th class="list_bg"  width="7%">登陆用户</TD>
                    {{/if}}
                    <th class="list_bg"  width="10%">主机名</TD>
                    <th class="list_bg"  width="8%">系统</TD>
                    <th class="list_bg"  width="8%">负载均衡</TD>
                   	<th class="list_bg"  width="30%">操作</TD>
                  </TR>
            </tr>
			{{section name=t loop=$alldev}}
			<tr bgcolor='{{if $alldev[t].passwordtry eq 1 or $alldev[t].passwordtry eq 2}}red{{/if}}'>
				<td>{{$alldev[t].device_ip}}</td>
				{{if $type ne 'fort'}}
				<td>{{$alldev[t].username}}</td>
				{{/if}}
				<td>{{$alldev[t].hostname}}</td>
				<td>{{$alldev[t].device_type}}</td>
				<td>
<select  class="wbk"  id="lb{{$alldev[t].id}}" name="lb" >
<option value="{{$localip}}">{{$localip}}</option>
{{section name=l loop=$lb}}
<option value="{{$lb[l].ip}}">{{$lb[l].ip}}</option>
{{/section}}
</select>
</td>
				<td class="td_line" width="30%">
					{{if $admin_level == 0}}
					<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'>
					
					
					{{$alldev[t].login_method}}
					(
					{{if $alldev[t].login_method eq 'ssh' or $alldev[t].login_method eq 'telnet' or $alldev[t].login_method eq 'rlogin'}}
					
					
					<a id="p{{$alldev[t].id}}" href="admin.php?controller=admin_pro&action=dev_login&id={{$alldev[t].id}}&logintool=putty&type={{$type}}" onclick="return goto3(this.id)" target="hide">putty</a> |
			
					 <a id="s{{$alldev[t].id}}" href="admin.php?controller=admin_pro&action=dev_login&id={{$alldev[t].id}}&logintool=securecrt&type={{$type}}" onclick="return goto3(this.id)"  target="hide" >securecrt</a>
					
					{{elseif $alldev[t].login_method eq 'ftp' or $alldev[t].login_method eq 'sftp'}}
					<a id="a{{$alldev[t].id}}" href='admin.php?controller=admin_pro&action=dev_login&logintool=winscp&id={{$alldev[t].id}}'  onclick="return goto3(this.id)" target="hide">登录</a>
					
					{{elseif $alldev[t].login_method eq 'RDP2008' or $alldev[t].login_method eq 'RDP' or $alldev[t].login_method eq 'VNC' or $alldev[t].login_method eq 'Web' or $alldev[t].login_method eq 'Sybase' or $alldev[t].login_method eq 'Oracle' or $alldev[t].login_method eq 'DB2'}}
					
					<a id="a{{$alldev[t].id}}1" onclick="rdpgo({{$alldev[t].id}});return false;" href='#'>本地</a>
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
					{{/if}}
					
					)
					
					
					{{/if}}
				
					{{if $admin_level == 10}}
					<img src='{{$template_root}}/images/list_ico2.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=dev_checkpass&id={{$alldev[t].id}}'>查看密&nbsp;&nbsp;码</a>
					{{/if}}				
{{*
					<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=dev_edit&id={{$alldev[t].id}}'>修改</a>
					<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=bind_user&id={{$alldev[t].id}}'>设置用户</a>
					<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=dev_del&id={{$alldev[t].id}}';}">删除</a>
				*}}</td> 
			</tr>
			{{/section}}
                <tr>
	           <td  colspan="5" align="right">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_index&page='+this.value;">页
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
	var lbip = document.getElementById('lb'+iid).options[document.getElementById('lb'+iid).options.selectedIndex].value;
	
	hid.src='admin.php?controller=admin_pro&action=dev_login&id='+iid+'&screen='+fenbian+'&selectedip='+lbip;
	//alert(hid.src);
	//window.open(document.getElementById('hide').src);
	return false;	
}
function rdpgo2(iid){
	var fenbian = document.getElementById('fenbianlv2'+iid).options[document.getElementById('fenbianlv2'+iid).selectedIndex].value;
	var hid = document.getElementById('hide');
	var lbip = document.getElementById('lb'+iid).options[document.getElementById('lb'+iid).options.selectedIndex].value;
	
	document.getElementById('a'+iid+'2').href='admin.php?controller=admin_pro&rdptype=activex&action=dev_login&id='+iid+'&screen='+fenbian+'&selectedip='+lbip;
	//alert(hid.src);
	//window.open(document.getElementById('hide').src);
	return true;	
}

function goto3(iid){
	var idnumber = iid.substring(1);
	var lbip = document.getElementById('lb'+idnumber).options[document.getElementById('lb'+idnumber).options.selectedIndex].value;
	if(!lbip){
		alert('请选择负载均衡');
		return false;
	}
	document.getElementById(iid).href=document.getElementById(iid).href+'&selectedip='+lbip;
	//window.open(document.getElementById(iid).href);
	return true;
}
</script>
</body>
<iframe id="hide" name="hide" height="0"  frameborder="0" scrolling="no"></iframe>
</html>




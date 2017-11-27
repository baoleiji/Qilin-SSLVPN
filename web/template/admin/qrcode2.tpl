<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
	function check_add_user(){
		return(true);
	}
</script>
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
<body>

	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>

	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=edit_self">手机二维码</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
	  <tr>
		<td class="">
			<form method="post" name="add_user" action="admin.php?controller=admin_member&action=save_self" enctype="multipart/form-data">
				<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
<tr><th colspan="3" class="list_bg"></th></tr>
				{{if $msg}}
					<tr bgcolor="red">
						<td>提示：</td>
						<td>{{$msg}}</td>
					</tr>
				{{/if}}
					<tr bgcolor="f7f7f7">
						<td align="right" width="33%">原密码：</td>
						<td><input type="password" name="oripassword" class="input_shorttext"> {{$pwdshould}}</td>
					</tr>
					<tr>
						<td align="right" width="33%">{{$language.Password}}：</td>
						<td><input type="password" name="password1" class="input_shorttext"></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td align="right" width="33%">{{$language.Commitpassword}}：</td>
						<td><input type="password" name="password2" class="input_shorttext"></td>
					</tr>
					<tr>
						<td align="right" width="33%">{{$language.Mailbox}}：</td>
						<td><input type="text" name="email" class="input_shorttext" value="{{$member.email}}"></td>
					</tr>
					<tr>
						<td align="right" width="33%">密码有效期：</td>
						<td>{{$pwdremain}}</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td align="right" width="33%">登录提示：</td>
						<td><input type="checkbox" name="login_tip" value="1" {{if $member.login_tip}}checked{{/if}}></td>
					</tr>
					<tr>
						<td align="right" width="33%">RDP分辨率：</td>
						<td>
						<select  class="wbk"  name='rdp_screen' id='rdp_screen' > 
					<option value="3" {{if $member.rdp_screen eq 3}}selected{{/if}}>全屏</option>
					<option value="1" {{if $member.rdp_screen eq 1}}selected{{/if}}>800*600</option>
					<option value="2" {{if $member.rdp_screen eq 2}}selected{{/if}}>1024*768</option>
					</select>

						</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td align="right" width="33%">RDP磁盘映射：</td>
						<td>
						<input type="text" name="rdpdisk" class="input_shorttext" value="{{$member.rdpdisk}}">例子C:;D:;E:;
						</td>
					</tr>
					<TR>
                  <TD align="right" width="33%">默认控件 </TD>
                  <TD><select  class="wbk"  name=default_control>
                     <OPTION value="0" {{if $member.default_control eq 0}}selected{{/if}}>自动检测</OPTION>
                     <OPTION value="1" {{if $member.default_control eq 1}}selected{{/if}}>applet</OPTION>
                     <OPTION value="2" {{if $member.default_control eq 2}}selected{{/if}}>activeX</OPTION>
                  </SELECT>                  
				  </TD>
				  <tr bgcolor="f7f7f7">
						<td align="right" width="33%">使用权限缓存：</td>
						<td><input type="checkbox" name="searchcache" value="1" {{if $priority_cache or $member.searchcache}}checked{{/if}} {{if $priority_cache}}onclick="this.checked=true;alert('系统已经设定强制使用缓存，如有问题请联系管理员')"{{/if}}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="window.location='admin.php?controller=admin_index&action=do_devices_cache'" height="35" align="middle" value="更新权限" border="0" class="bnnew2"/></td>
					</tr>
				 <tr bgcolor="f7f7f7">
						<td align="right" width="33%">显示目录：</td>
						<td><input type="checkbox" name="ldap" value="1" {{if $member.ldap}}checked{{/if}}></td>
					</tr>
                </TR>
				<tr bgcolor="">
						<td align="right" width="33%">PLSQL启动延时:</td>
						<td>
						<input type="text" name="appdelay" class="input_shorttext" value="{{$member.appdelay}}">秒
						</td>
					</tr>
					<tr >
						<td  align="center" colspan=2><input  type="submit" value="{{$language.Commit}}" class="an_02"></td>
					</tr>
				</table>
			</form>
			
		</td>
	  </tr>
	</table>
</body>
</html>



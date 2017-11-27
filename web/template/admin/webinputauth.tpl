<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/Calendarandtime.js"></script>
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$title}}</td>
  </tr>
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post enctype="multipart/form-data" action="admin.php?controller=admin_pro&action=doinputauth">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	 <TR bgcolor="">
                  <TD colspan="2" align=center>登录信息 </TD>
                  <td></td>
				   {{if $showusers }}
			  <TR bgcolor="#f7f7f7">
                <TD width="50%" height="32" align="right">用户: </TD>
                <TD>
				<select onchange="changeuser(this.value);">
				<option value="0" >请选择用户</option>
				{{section name=u loop=$users}}
				<option value="{{$users[u].id}}_{{$users[u].username}}.,?{{$users[u].password}}"  {{$users[u].selected}} >{{$users[u].username}}</option>
				{{/section}}
				</select>
				</TD></TR>
              <TR>
			  {{/if}}
                </TR>
     <TR bgcolor="f7f7f7">
                  <TD width="50%" align=right>用户: </TD>
                  <TD>
					<input type="text" name="username" id="username" value="{{$username}}" autocomplete="off"  /> 
				  </TD>
                </TR>
                <TR>
                  <TD width="50%" align=right>密码: </TD>
                  <TD><input type="password" name="password" id="password" value="{{$password}}" autocomplete="off" />               
				  </TD>
                </TR>            
	<tr><td align=right>{{if $showusers }}<INPUT type="hidden" value="{{$passwordsave}}" id="passwordsave" name="passwordsave"><INPUT type="checkbox" {{if $saveedit}}checked{{/if}} value="1" name="saveedit">保存{{/if}}&nbsp;&nbsp;</td><td><input type=submit  value="登录" name="actions" class="an_02">&nbsp;&nbsp;{{if $showusers }}<INPUT type="submit"  class="an_02" value="删除" name="actions">{{/if}}</td></tr></table>
	<input type="hidden" name="rdptype" value="{{$rdptype}}" />
	<input type="hidden" name="url" value="{{$url}}" />
	<input type="hidden" name="id" value="{{$devicesid}}" />
</form>
	</td>
  </tr>
</table>
<script>
function changeuser(u){
	if(u==0){
		document.getElementById('passwordsave').value=-1;
		document.getElementById('username').value='';
		document.getElementById('password').value='';
	}else if(u!=0){
		var u1 = u.substring(0, u.indexOf('_'));
		var u2 = u.substring(u.indexOf('_')+1);
		var username = u2.split('.,?');
		document.getElementById('passwordsave').value=u1;
		document.getElementById('username').value=username[0];
		document.getElementById('password').value=username[1];
	}
}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




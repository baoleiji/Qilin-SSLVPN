<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$title}}</td>
  </tr>
  <tr>
	<td class="main_content">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=apppubedit_selgroup_save">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} >
		<TD width="33%" align=right>用户名</TD>
                  <TD width="67%"><INPUT id="username" type=text name=username  value="{{$appgroup.username}}">                  </TD>
                </TR>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} >
		<TD width="33%" align=right>密码 </TD>
                  <TD width="67%"><INPUT id="password" type=text name=password  value="{{$appgroup.password}}">                  </TD>
                </TR>

	<tr><td></td><td><input type=submit  value="保存修改" class="an_02"></td></tr></table>
<input type="hidden" name="id" value="{{$appgroup.id}}" />
<input type="hidden" name="gid" value="{{$gid}}" />
<input type="hidden" name="appdevice" value="{{$appdevice}}" />
<input type="hidden" name="sessionlgroup" value="{{$sessionlgroup}}" />
</form>
	</td>
  </tr>
</table>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




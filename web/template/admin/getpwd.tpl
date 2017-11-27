<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>


<table width="100%" border="0" cellspacing="0" align="center" cellpadding="5">
  <tr>
    <td valign="top" height="12" background="./template/admin/images/yw_03.jpg"><table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
        <td width="300" valign="top" align="left"><img src="./template/admin/images/02.jpg"></td>
        <td valign="top" align="center">
			
			
					</td>
        <td width="200" valign="top" align="right"></td>
      </tr>
    </tbody></table></td>
  </tr>
  <tr>
    <td  class="hui_bj" >密码找回</td>
  </tr>
  <tr>
	<td class="main_content">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_index&action=getpwd">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		用户名	
		</td>
		<td width="67%">
		<input type=text name="username" id="username" size=35 value="{{$smarty.session.POST.username}}" >
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		电子邮箱	
		</td>
		<td width="67%">
		<input type=text name="email" id="email" size=35 value="{{$smarty.session.POST.email}}" >
	  </td>
	</tr>


	<tr><td></td><td><input type=submit  value=" 提 交 " class="an_02"></td></tr></table>
<input type=hidden name="ac" value="get">
</form>
	</td>
  </tr>
</table>

<script language="javascript">

function check(){
	if(document.getElementById("username")=="" || document.getElementById("email")==""){
		alert("请输入用户名和邮箱"):
	}
}

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




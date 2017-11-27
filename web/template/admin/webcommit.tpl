<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>
<style>
margin-top:0px;
</style>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post enctype="multipart/form-data" action="admin.php?controller=admin_pro&action=docommit">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	 <TR bgcolor="f7f7f7">
                  <TD colspan="2" align=center>填写操作内容 </TD>
                  <td></td>
                </TR>
                <TR>
                  <TD width="33%" align=right> </TD>
                  <TD><textarea cols="40" rows="3" name="prelogincommit" value="" ></textarea>
				  </TD>
                </TR>            
	<tr><td></td><td><input type=submit  value="登录" class="an_02"></td></tr></table>
	<input type="hidden" name="rdptype" value="{{$rdptype}}" />
	<input type="hidden" name="url" value="{{$url}}" />
	<input type="hidden" name="id" value="{{$devicesid}}" />
</form>
	</td>
  </tr>
</table>

</body>
</html>




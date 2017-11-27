<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
</head>

<body>
<script>
function change_option(number,index){
 for (var i = 1; i <= number; i++) {
      document.getElementById('current' + i).className = '';
      document.getElementById('content' + i).style.display = 'none';
 }
  document.getElementById('current' + index).className = 'current';
  document.getElementById('content' + index).style.display = 'block';
  if(index==1){
	document.getElementById('finalsubmit').style.display = 'block';
  }else{
	document.getElementById('finalsubmit').style.display = 'none';
  }
  return false;
}
</script>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td  align="right"><span class="back_img"><A href="admin.php?controller=admin_pro&action=dev_index&gid={{$gid}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post action="admin.php?controller=admin_pro&action=devpassbatch_save&id={{$id}}&appconfigedit={{$appconfigedit}}&appconfigid={{$appconfigid}}">
			
				 <div id="content1" class="content">
				   <div class="contentMain">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="autotr">
		<TD width="33%" align=right>启用 </TD>
                  <TD width="67%"><INPUT id="enable" type=checkbox name=enable value="on">                  </TD>
                </TR>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="autotr">
		<TD width="33%" align=right>{{$language.automaticallyeditpassword}} </TD>
                  <TD width="67%"><INPUT id="automp" type=checkbox name=auto value="on">                  </TD>
                </TR>
				 {{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id="publickey_authtr" >
		<TD width="33%" align=right>公钥私钥认证: </TD>
                  <TD width="67%"><INPUT id="publickey_auth" type=checkbox name=publickey_auth value="on">  
                </TR>    
	</table> </div>
				 </div>

				 </div>
	<tr id="finalsubmit"><td align="center"><input type=submit  value="保存修改" class="an_02"></td></tr></table>
<input type="hidden" name="ips" value="{{$ips}}" />
<input type="hidden" name="username" value="{{$username}}" />
 </form>

	</td>
  </tr>
</table>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




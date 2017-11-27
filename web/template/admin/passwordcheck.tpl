<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function searchit(){
	document.f1.submit();	
	return true;
}
</script>
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 	 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>

	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
   <TR>
                    <TD colspan = "7">
					<form name ='f1' action='admin.php?controller=admin_pro&action=passwordcheck' method=post>
					IP<input type="text" class="wbk" name="ip">
					{{$language.LocalUsername}}<input type="text" class="wbk" name="username">
					检验结果：<select  class="wbk"  name="passwordtry" ><option value="">{{$language.Pleaseselect}}</option><option value="0">登录{{$language.Secuess}}</option><option value="1">{{$language.passwordincorrect}}</option><option value="2">{{$language.cannotjoin}}</option></select>
					&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
					</form>
					</TD>
                  </TR>
  <tr>
  
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
                <TBODY>
                  <TR>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=passwordcheck&orderby1=device_ip&orderby2={{$orderby2}}" >{{$language.IPAddress}}</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=passwordcheck&orderby1=login_method&orderby2={{$orderby2}}" >{{$language.Loginmode}}</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=passwordcheck&orderby1=username&orderby2={{$orderby2}}" >{{$language.LocalUsername}}</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=passwordcheck&orderby1=passwordtry&orderby2={{$orderby2}}" >检验结果</a></TD>
                  </TR>

            </tr>
			{{section name=t loop=$alllog}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
 <td> {{$alllog[t].device_ip}}</td>
				<td>{{$alllog[t].login_method}}</td>
				<td>{{$alllog[t].username}}</td>
				<td>{{$alllog[t].passwordtry}}</td>
			</tr>
			{{/section}}

                <tr>
	           <td  colspan="5" align="right">
		   			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=logs_index&page='+this.value;">{{$language.page}}
		   </td>
		</tr>
		</TBODY>
              </TABLE>	</td>
  </tr>
</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



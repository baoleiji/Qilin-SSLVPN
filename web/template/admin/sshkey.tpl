<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<script>
	function searchit(){
		document.search.action = "admin.php?controller=admin_pro&action=sshkey";
		document.search.action += "&username="+document.search.username.value;
		document.search.action += "&ip="+document.search.ip.value;
		document.search.action += "&dusername="+document.search.dusername.value;
		document.search.submit();
		return true;
	}
	
</script>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
     <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>
	
   <TR>
<TD >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
<form name ='search' action='admin.php?controller=admin_pro&action=sshkey' method=post onsubmit="return searchit();">
  <tr>
    <td >
</td>
    <td >	
					堡垒机用户：<input type="text" name="username" size="13" class="wbk"/>&nbsp;&nbsp; 设备IP：<input type="text" name="ip" size="13" class="wbk"/>&nbsp;&nbsp;系统用户：<input type="text" name="dusername" size="13" class="wbk"/>&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>

					</td>
  </tr>
</form>	
</table>
</TD>
                  </TR>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                <TBODY>
				  
                  <TR>
					<th class="list_bg" width="30">&nbsp;</th>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=sshkey&orderby1=device_ip&orderby2={{$orderby2}}" >名称</a></th>
					<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=sshkey&orderby1=dusername&orderby2={{$orderby2}}" >描述</a></th>					
					<th class="list_bg" >公钥</th>
					<th class="list_bg" >私钥</th>
					<th class="list_bg" >GLOBAL IP</th>
					<th class="list_bg" >私钥MD5</th>
					<th class="list_bg" >操作</th>
                  </TR>

            </tr>
			<form name="a" action="admin.php?controller=admin_pro&action=sshkey_delete" method="POST" >
			{{section name=t loop=$sshdevices}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td width="1%"><input type="checkbox" name="chk_member[]" value="{{$sshdevices[t].id}}"></td>	
				<td> <a href='admin.php?controller=admin_pro&action=sshkey&device_ip={{$sshdevices[t].device_ip}}'>{{$sshdevices[t].sshkeyname}}</a></td>
				<td> <a href='admin.php?controller=admin_pro&action=sshkey&hostname={{$sshdevices[t].hostname}}'>{{$sshdevices[t].desc}}</a></td>
				<td>{{if $sshdevices[t].public_key_file}}已上传{{else}}<font color='red'>未上传</font>{{/if}}</td>	
				<td>{{if $sshdevices[t].private_key_file}}已上传{{else}}<font color='red'>未上传</font>{{/if}}</td>
				<td>{{$sshdevices[t].globalip}}</td>
				<td>{{$sshdevices[t].md5sum}}</td>
				<td> <img src="{{$template_root}}/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href='admin.php?controller=admin_pro&action=sshkey_edit&id={{$sshdevices[t].id}}'>编辑上传</a> | &nbsp;<img src="{{$template_root}}/images/left_dot1.gif" width="16" height="16" align="absmiddle"><a href='admin.php?controller=admin_pro&action=sshkey_list&id={{$sshdevices[t].id}}'>绑定</a> | &nbsp;<img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href='admin.php?controller=admin_pro&action=sshkey_delete&id={{$sshdevices[t].id}}'>删除</a></td>
			</tr>
			{{/section}}
			<tr>
	           <td  colspan="5" align="left">
				<input name="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="删除" onClick="my_confirm('{{$language.DeleteUsers}}');if(chk_form()) document.member_list.action='admin.php?controller=admin_member&action=delete_all'; else return false;" class="an_02">&nbsp;&nbsp;<input type="button" value="添加" onclick="document.location='admin.php?controller=admin_pro&action=sshkey_edit'"  class="an_02" />&nbsp;&nbsp;<input type="button" value="导入" onclick="document.location='admin.php?controller=admin_pro&action=sshkey_import'"  class="an_02" />&nbsp;&nbsp;<input type="button" value="查看所有key" onclick="document.location='admin.php?controller=admin_pro&action=sshkey_new'"  class="an_06" />&nbsp;&nbsp;&nbsp;<input type="button" value="同步" onclick="document.getElementById('hide').src='admin.php?controller=admin_pro&action=sshkey_sync'"  class="an_02" />
		   </td>
               
	           <td  colspan="5" align="right">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=sshkey&page='+this.value;">页
		   </td>
		</tr>
			</form>
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
window.parent.menu.document.getElementById('devtree').style.display='none';
window.parent.menu.document.getElementById('ldaptree').style.display='none';
</script>
</body>
<iframe id="hide" name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



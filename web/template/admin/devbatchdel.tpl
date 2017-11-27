<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>
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
<script>
function searchit(){
	document.f1.action = "admin.php?controller=admin_pro&action=devbatchdel";
	document.f1.action += "&ip="+document.f1.ip.value;
	document.f1.action += "&hostname="+encodeURIComponent(document.f1.hostname.value);
	document.f1.action += "&username="+document.f1.username.value;
	return true;
}
</script>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="" colspan = "7"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

                <TBODY>
				 <TR>
                    <TD >
					<form name ='f1' action='admin.php?controller=admin_pro&action=devbatchdel' method=post>
					IP<input type="text" class="wbk" name="ip" value="{{$ip}}">
					主机名<input type="text" class="wbk" name="hostname" value="{{$hostname}}">
					账号<input type="text" class="wbk" name="username" value="{{$username}}">
					&nbsp;&nbsp;<input  type="submit" value="搜索" onclick="return searchit();" class="bnnew2">
					</form>
					</TD>
                  </TR>
				  </table></td></tr>
                  <TR><td>
				  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
				  <tr>
					<th class="list_bg"  width="3%" >{{$language.select}}</th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=device_ip&orderby2={{$orderby2}}">服务器地址</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=hostname&orderby2={{$orderby2}}">主机名</a></th>
					
                    <th class="list_bg" ><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=device_type&orderby2={{$orderby2}}">系统</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=groupid&orderby2={{$orderby2}}">设备组</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=week&orderby2={{$orderby2}}">修改策略</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=monitor&orderby2={{$orderby2}}">状态监控</a></th>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			<form name ='dev' action='admin.php?controller=admin_pro&action=dodevbatchdel' method=post>
			{{section name=t loop=$alldev}}
			<tr  {{if $alldev[t].ct > 0 or ($alldev[t].asset_warrantdate ne '0000-00-00 00:00:00' && $alldev[t].warrantdays<0) }}bgcolor="red" {{elseif  ($alldev[t].asset_warrantdate ne '0000-00-00 00:00:00' && $alldev[t].warrantdays<30)}}bgcolor="yellow"{{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td><input type="checkbox" name="chk_member[]" value="{{$alldev[t].device_ip}}"></td>
				<td>{{$alldev[t].device_ip}}</td>
				<td><span  title="{{$alldev[t].hostname}}" >{{$alldev[t].hostname}}</span></td>
				
				<td>{{$alldev[t].device_type}}</td>
				<td>{{$alldev[t].groupname}}</td>
				<td>{{$alldev[t].method}}</td>
				<td>{{if $alldev[t].monitor eq 1}}SNMP{{elseif $alldev[t].monitor eq 2}}登录{{else}}关闭{{/if}}</td>
				<td>
				
					{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 4}}
					
					| <img src='{{$template_root}}/images/left_dot1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=devpass_index&ip={{$alldev[t].device_ip}}&serverid={{$alldev[t].id}}&gid={{$gid}}'>用户({{if $alldev[t].userct}}{{$alldev[t].userct}}{{else}}0{{/if}})</a>
					
	
					{{/if}}
				</td> 
			</tr>
			{{/section}}
			
                <tr>

	           <td  colspan="2" align="left">
			  <input name="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=document.dev.elements[i];if(e.name=='chk_member[]')e.checked=document.dev.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="批量删除" onClick="my_confirm('所有选中的主机和主机中的帐号都会被删除,确定要删除?');if(chk_form()) document.dev.action='admin.php?controller=admin_pro&action=dodevbatchdel'; else return false;" class="an_02">

		   </td>
				<td colspan="6" align="right">&nbsp&nbsp;&nbsp;共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_index&page='+this.value;">页</td>
		   
                </tr>
            </form>
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

function batchedit(){
	var ips = new Array();
	var ii=0;
	for(var i=0;i<document.dev.elements.length;i++){
		var e=document.dev.elements[i];
		if(e.name=='chk_member[]'&&e.checked){
			ips[ii++]=e.value;
		}
	}
	window.open('admin.php?controller=admin_pro&action=devbatchedit&ips='+ips.join(','));
}

function batchremove(){
	var ips = new Array();
	var ii=0;
	for(var i=0;i<document.dev.elements.length;i++){
		var e=document.dev.elements[i];
		if(e.name=='chk_member[]'&&e.checked){
			ips[ii++]=e.value;
		}
	}
	window.location='admin.php?controller=admin_pro&action=dodevbatchremove&ips='+ips.join(',');
}

function devpassbatchedit(){
	var ips = new Array();
	var ii=0;
	for(var i=0;i<document.dev.elements.length;i++){
		var e=document.dev.elements[i];
		if(e.name=='chk_member[]'&&e.checked){
			ips[ii++]=e.value;
		}
	}
	window.open('admin.php?controller=admin_pro&action=devpassbatchedit&ips='+ips.join(',')+"&username="+'{{$username}}');
}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




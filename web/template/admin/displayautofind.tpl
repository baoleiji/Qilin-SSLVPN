<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>自动发现结果</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
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
<script type="text/javascript">
{{if $_config.LDAP}}
var foundparent = false;
var servergroup = new Array();

{{/if}}
</script>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
</head>

<body>

		<form name='route' action='admin.php?controller=admin_pro&action=displayautofind_save' method='post'>
 <tr>
	<td class="" colspan = "7">
	<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">
	<TBODY>
	 <TR>
		<TD >
		</TD>
	  </TR>
	  </table>
	  </td>
 </tr>

  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
		<tr bgcolor="#F3F8FC">
			<th class="list_bg"  width="3%" align="center" bgcolor="#E0EDF8"><b>序列</b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>IP</b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>主机名</b></th>
			<th class="list_bg"  width="18%" align="center" bgcolor="#E0EDF8"><b>目录</b></th>
			<th class="list_bg"  width="5%" align="center" bgcolor="#E0EDF8"><b>系统类型</b></th>
			<th class="list_bg"  width="5%" align="center" bgcolor="#E0EDF8"><b>发现时间</b></th>
			<th class="list_bg"  width="5%" align="center" bgcolor="#E0EDF8"><b>添加</b></th>
		</tr>		
		{{section name=t loop=$servers}}
		
		<tr>
			<td class="td_line">{{$smarty.section.t.index+1}}</td>
			<td class="td_line">{{$servers[t].ip}}</td>
			<td class="td_line"><input type="text" class="wbk" name="hostname[]" size="30" value="" /></td>
			<td class="td_line">
		{{assign var=select_group_id value="groupid`$smarty.section.t.index`"}}
		{{include file="select_sgroup_ajax.tpl" }}        
			</td>
			<td class="td_line">{{$servers[t].device_type}}</td>
			<td class="td_line">{{$servers[t].scan_time}}</td>
			<td class="td_line"><input type="checkbox" class="wbk" name="ips[]" size="30" value="{{$servers[t].ip}}" /></td>
		</tr>
		<input type="hidden" class="wbk" name="id[]" size="30" value="{{$servers[t].id}}" />
		{{/section}}
		 <tr>
			<td colspan="9" align="center" ><input type='submit'  name="batch" value='确定' class="an_02"></td>
		  </tr>

		</table>
	</td>
  </tr>

		</form>
</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}
{{if $_config.LDAP}}
function change_group(obj){
	{{if $smarty.session.ADMIN_LEVEL == 3 and $smarty.session.ADMIN_MSERVERGROUP}}
	for(var i=0; i<obj.options.length; i++){
		if(obj.options[i].value=={{$smarty.session.ADMIN_MSERVERGROUP}}){
			obj.selectedIndex=i;
		}		
	}	
	{{/if}}
}
{{/if}}
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
                <TBODY>
				  
                  <TR>
                    <th class="list_bg" width="40%"><a href="admin.php?controller=admin_pro&action=systemtype&orderby1=device_type&orderby2={{$orderby2}}" >系统名称</a></TD>
					 <th class="list_bg" width="40%"><a href="admin.php?controller=admin_pro&action=systemtype&orderby1=sucommand&orderby2={{$orderby2}}" > 超级用户切换命令</a></TD>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			{{section name=t loop=$weektime}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td >{{$weektime[t].device_type}}</td>
				<td >{{$weektime[t].sucommand}}</td>
				<td >
				<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_pro&action=systemtype_edit&id={{$weektime[t].id}}" >修改</a>
				| <img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=delete_systemtype&id={{$weektime[t].id}}';}">删除</a>
				</td> 
			</tr>
			{{/section}}
	           <tr>
						<td colspan="3" align="left">
							<input type="button"  value=" 增加 " onclick="javascript:document.location='admin.php?controller=admin_pro&action=systemtype_edit';" class="an_02">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_group_index&page='+this.value;">页
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



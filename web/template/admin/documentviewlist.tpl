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
	<form name="ip_list" action="admin.php?controller=admin_index&action=documentdel" method="post">
                <TBODY>
                  <TR>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_index&action=documentlist&orderby1=groupname&orderby2={{$orderby2}}" >设备IP</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_index&action=documentlist&orderby1=ipv6&orderby2={{$orderby2}}" >系统类型</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_index&action=documentlist&orderby1=groupname&orderby2={{$orderby2}}" >类型</a></TD>
					<th class="list_bg" >PDF文档</TD>
					<th class="list_bg" >说明</TD>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			{{section name=t loop=$s}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				 <td> {{$s[t].device_ip}}</td>
				 <td> {{$s[t].device_type}}</td>
				 <td> {{$s[t].type}}</td>
				 <td> {{$s[t].pdf}}</td>
				 <td> {{$s[t].desc}}</td>
				<td style="TEXT-ALIGN: left;"><img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_index&action=getdocument&id={{$s[t].id}}&doctype=pdf" >下载</a> 
				</td> 
			</tr>
			{{/section}}
	           
		</TBODY>
              </TABLE></form>	</td>
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



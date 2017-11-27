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
	<TABLE border=0 cellSpacing=1 cellPadding=5 
                                width="100%" bgColor=#ffffff valign="top">
                <TBODY>		
		<tr bgcolor="#F3F8FC">
		
			<td class="list_bg" align="center"  width="30%"><strong>line</strong></td>
			<td class="list_bg" width="30%" align="center" ><b>private key</b></td>
			<td class="list_bg" width="30%" align="center" ><b>操作</b></td>
		</tr>		
		{{section name=t loop=$allkeys}}
		<tr>
			<td class="td_line" width="30%">{{$allkeys[t].line}}</td>
			<td class="td_line" width="30%">{{$allkeys[t].privatekey}}</td>
			<td width="30%" class="td_line">
			<img src="{{$template_root}}/images/delete_ico.gif" width="16" height="16" hspace="5" border="0" align="absmiddle"><a href="#" onClick="if(!confirm('您确定要删除key？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=sshkeys_delete&id={{$allkeys[t].id}}';}">删除</a>
			
			</td>
		</tr>
		{{/section}}

                <tr>
	           <td  colspan="5">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=sshpublickey&page='+this.value;">页
		   </td>
		</tr>
		<form action="admin.php?controller=admin_pro&action=dosshpublickey" method="post" enctype="multipart/form-data" >
		<tr >
			<td width="10%" height="16" align="center" ><b>公钥</b></td>
			<td align="left" width="30%">
			<input type="file" name="publickey" />
			</td>
		</tr>	
		<tr >
			<td width="10%" height="16" align="center" ><b>私钥</b></td>
			<td align="left" width="30%">
			<input type="file" name="privatekey" />
			</td>
		</tr>	
		<tr >
			<td width="10%" height="16" align="center" ></td>
			<td align="left" width="30%">
			<input type="submit" name="submit" value="提交" />
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

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




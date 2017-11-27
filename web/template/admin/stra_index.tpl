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
	<td class="main_content"><TABLE border=0 cellSpacing=1 cellPadding=5 
                                width="100%" bgColor=#ffffff valign="top">
                <TBODY>
								                <tr>
		</tr>
                  <TR>
					<th class="list_bg" >主机</TD>
                    <th class="list_bg" >IP</TD>
					<th class="list_bg" >系统</TD>
					<th class="list_bg" >登录方式</TD>
                    <th class="list_bg" >策略</TD>
					<th class="list_bg" >定时</TD>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			{{section name=t loop=$allstra}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
 <td> {{$allstra[t].hostname}}</td>
				<td>{{$allstra[t].device_ip}}</td>
				<td>{{$allstra[t].device_type}}</td>
				<td>{{$allstra[t].login_method}}</td>
				<td>{{$allstra[t].strategy_name}}</td>
				<td>{{$allstra[t].method}}</td>


				<td>									
				<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=dev_edit&id={{$allstra[t].did}}'>修改</a>
					<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=bind_user&id={{$allstra[t].did}}'>设置</a>
					<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=dev_del&id={{$allstra[t].did}}';}">删除</a>
					{{*<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=stra_edit&id={{$allstra[t]['sid']}}'>策略</a>*}}
					</td> 
			</tr>
			{{/section}}
             <tr>
	           <td  colspan="7">
				
				<input type="button"  value="增加一个新设备" onClick="location.href='admin.php?controller=admin_pro&action=dev_edit'" class="an_02">
		   </td>
                </tr>
                <tr>
	           <td  colspan="5">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=tem_index&page='+this.value;">页
		   </td>
		</tr>
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

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>





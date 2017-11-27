<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<SCRIPT language=javascript src="{{$template_root}}/cssjs/calendar.js"></SCRIPT>
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
                  <TR>
                    <th class="list_bg" >{{$language.IPAddress}}</TD>
                    <th class="list_bg" >{{$language.Username}}</TD>
                    <th class="list_bg" >{{$language.ResultinlastChange}}</TD>
                    <th class="list_bg" >{{$language.Time}}</TD>
                  </TR>

            </tr>
			{{section name=t loop=$alllog}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
 <td> {{$alllog[t].device_ip}}</td>
				<td>{{$alllog[t].username}}</td>
				<td>{{$alllog[t].update_success_flag}}</td>
				<td>{{$alllog[t].time}}</td>
			</tr>
			{{/section}}

                <tr>
	           <td  colspan="5">
		   			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=logs_index&page='+this.value;">{{$language.page}}
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



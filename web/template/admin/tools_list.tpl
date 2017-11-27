<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>
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
<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>

	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=tool_list">工具下载</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
  {{if $usbkeyshow eq 1}}
  <tr>
  	<td class="">
  	
  		<a href="admin.php?controller=admin_index&action=download_usbkeyfile" >口令证书下载</a>
  	
  	</td>
  </tr>
  {{/if}}
  <tr>
	<td class=""><TABLE border=0 cellSpacing=1 cellPadding=5 
                                width="100%" bgColor=#ffffff valign="top" class="BBtable">

                <TBODY>
                  <TR>

					<th class="list_bg" >{{$language.ToolsName}}</TD>
					<th class="list_bg" >{{$language.Operate}}</TD>
                  </TR>

            </tr>
			{{section name=t loop=$allTools}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
 <td> {{$allTools[t].name}}</td>
				<td>									
				<img src='{{$template_root}}/images/down.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_index&action=tool_down&name={{$allTools[t].name|urlencode}}'>{{$language.Download}}</a>{{if $smarty.session.ADMIN_USERNAME eq 'admin'}} | <img src='{{$template_root}}/images/scico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_index&action=tool_delete&name={{$allTools[t].name|urlencode}}'>删除</a>{{/if}}
				</td> 
			</tr>
			{{/section}}
<tr><td  align="left">{{if $smarty.session.ADMIN_USERNAME eq 'admin'}}<input type="button" onclick="window.location='admin.php?controller=admin_index&action=upload_tool'"  name="add" value="上传文件" class="an_02">{{/if}}</td>
		<td  colspan="5" align="right">
			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_member&action=keys_index&page='+this.value;">{{$language.page}}&nbsp;&nbsp;&nbsp;&nbsp;
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




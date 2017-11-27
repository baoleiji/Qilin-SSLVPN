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
    <td  class="hui_bj">{{$language.CommandsManager}}——{{$language.Detail}}</td>
  </tr>
  <tr>
    <td  align="right"><span class="back_img"><A href="admin.php?controller=admin_pro&action=dev_index&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span></td>
  </tr>
  <tr>
	<td class="main_content">
	<TABLE border=0 cellSpacing=1 cellPadding=5 width="100%" bgColor=#ffffff valign="top">
		<TBODY>				 
			<TR>
				<th class="list_bg" >IP</TD>
				<th class="list_bg" >{{$language.Configurefilename}}</TD>
				<th class="list_bg" >{{$language.ChangeTime}}</TD>
				<th class="list_bg" >{{$language.Edit}}</TD>					
			</TR>
            </tr>
            <form name ='f2' action='admin.php?controller=admin_pro&action=dev_index' method=post>
			{{section name=t loop=$alldev}}
			<tr {{if $alldev[t].is_modified}}bgcolor="red"{{/if}}>
				<td><input type='checkbox' name="id[]" value="{{$alldev[t].id}}"></td>
				<td>{{$alldev[t].device_ip}}</td>
				<td>{{$alldev[t].file_path}}</td>
				<td>{{$alldev[t].last_modified_time}}</td>
				<td>
					{{if $smarty.session.ADMIN_LEVEL eq 1}}<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=profilebackup_update&id={{$alldev[t].id}}'>{{$language.UpdateReference}}</a>{{/if}}
					{{if $smarty.session.ADMIN_LEVEL eq 1}}<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_pro&action=profilebackup_delete&id={{$alldev[t].id}}" onClick="if(!confirm('{{$language.Delete_sure_}}？')) {return false;} else { return true;}">{{$language.Delete}}</a>{{/if}}
				</td> 
			</tr>
			{{/section}}
			{{if $smarty.session.ADMIN_LEVEL eq 1}}
	            <tr>
		           	<td  colspan="5">
						<input type="button"  value="{{$language.Add}}" onClick="location.href='admin.php?controller=admin_pro&action=profilebackup_edit&device_id={{$device_id}}'" class="an_02">
						<input type="submit"  value="{{$language.Delete}}" onClick="return batchdel();" class="an_02">

			   		</td>
	            </tr>
            {{/if}}
            </form>
                <tr>
	           		<td  colspan="5">
		   				{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_index&page='+this.value;">{{$language.page}}
		   			</td>
				</tr>
				
		</TBODY>
       </TABLE>
	</td>
  </tr>
</table>

<script language="javascript">

function batchdel(){
	if(confirm('{{$language.Delete}}所{{$language.select}}?')) {
		document.f2.action='admin.php?controller=admin_pro&action=profilebackup_delete';
		return true;
	}else{
		return false;
	}
}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



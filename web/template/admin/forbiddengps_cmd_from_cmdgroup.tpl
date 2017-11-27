<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/Calendarandtime.js"></script>
</head>
<script>
function changcmdgroup(c){
	{{foreach from=$cmdgroup key=kk item=value }}
	document.getElementById('{{$kk}}').style.display='none';
	{{/foreach}}
	document.getElementById(c).style.display='';
}
</script>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post OnSubmit='return check()' enctype="multipart/form-data" action="admin.php?controller=admin_forbidden&action=from_cmdgroup_save">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="3" class="list_bg"></th></tr>
	{{if !$group.black_or_white}}
	 <TR bgcolor="">
                  <TD width="50%" align=right>命令级别: </TD>
				   <TD>
				  
				  <select  class="wbk"  name="level" >
				  	<option value="1" {{if $group.level eq 1}}selected{{/if}}>断开连接</option>
					<option value="0"  {{if $group.level eq 0}}selected{{/if}}>命令阻断</option>
					<option value="2"  {{if $group.level eq 2}}selected{{/if}}>命令监控</option>
					<option value="3"  {{if $group.level eq 3}}selected{{/if}}>命令授权</option>
							</select>
				  </TD>
                </TR>
	{{/if}}
     <TR bgcolor="f7f7f7">
                  <TD width="50%" align=right>命令组 </TD>
                  <TD><select  class="wbk"  name=weektime onchange="changcmdgroup(this.value);">
                      <OPTION value="">无</OPTION>
						{{foreach from=$cmdgroup key=kk item=value }}
				<option value="{{$kk}}">{{$kk}}</option>

						{{/foreach}}
                  </SELECT> 
				  </TD>
                </TR>
				{{foreach from=$cmdgroup key=kk item=value }}
                <TR id="{{$kk}}" style="display:none">
                  <TD colspan="2">
				  {{foreach from=$value key=k2 item=ii }}{{$ii.cmdgroup}}
					  {{$ii.commands}}<input type="checkbox" name="cmd_{{$kk}}_{{$ii.id}}" {{if $ii.cmd}}checked{{/if}} value="{{$ii.id}}" />&nbsp;&nbsp;&nbsp;
				  {{/foreach}}
				  </TD>
                </TR>
				{{/foreach}}
				
	<tr><td></td><td><input type=submit  value="保存修改" class="an_02" onclick="window.opener.location.reload();return true;"></td></tr></table>
<input type="hidden" name="gid" value="{{$group.gname}}" />
</form>
	</td>
  </tr>
</table>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




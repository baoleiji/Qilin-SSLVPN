<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/Calendarandtime.js"></script>
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post enctype="multipart/form-data" action="admin.php?controller=admin_workflow&action=do_workflow_approve&wid={{$wid}}&status={{$status}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	{{if $last}}
	<tr bgcolor="f7f7f7">
                  <TD  width="33%" align=center>操作人： </TD>
				  </tr>
				  <tr>
                  <TD>含有字符<input type="text" class="wbk" size="10" id="filtertext" onchange="filter();" />
                  <select  class="wbk"  name=username id="username" onchange="check_userpriority({{$wf.devicesid}}, this.value)">
                      <OPTION value="">请选择</OPTION>
                     	{{section name=k loop=$members}}
				<option value="{{$members[k].uid}}" {{if $members[k].uid == $member.usbkey}}selected{{/if}}>{{$members[k].username}}</option>
			{{/section}}
                  </SELECT>        
				  </TD>
                </TR>
	{{/if}}
                <TR bgcolor="f7f7f7">
                  <TD width="50%" align=center>备注: </TD>
				  </tr>
				  <tr>
                  <TD><textarea cols=55 rows=5 name="description"></textarea>               
				  </TD>
                </TR>            
	<tr><td align=center><input type=submit onclick="{{if $last}}return cansubmit(){{/if}}"  value="提交" class="an_02"></td></tr></table>
</form>
	</td>
  </tr>
</table>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




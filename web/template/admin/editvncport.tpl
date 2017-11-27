<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TBODY>
  <TR>
    <TD align="center" class="tb_t_bg">选择端口号 </TD>
  </TR>
  <TR>
    <TD>
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
        <TBODY>
        <TR>
          <TD align="center">
          <form name="f1" method=post enctype="multipart/form-data" action="admin.php?controller=admin_pro&action=doeditvncport" {{if $rdptype ne 'activex'}}target="hide"{{/if}}>
            <TABLE width="100%" bgcolor="#ffffff" border="0" cellspacing="1" 
            cellpadding="5" valign="top" height="70">
              <TBODY>
              <TR>
                <TD align="center">
				<select name=vncport >
				<option value="{{$port}}" >{{$port}}</option>
				{{section name=v loop=9}}				
				{{if $port ne "590{{$smarty.section.v.index}}"}}
				<option value="590{{$smarty.section.v.index}}" >590{{$smarty.section.v.index}}</option>
				{{/if}}
				{{/section}}
				</select>
				</TD></TR>
              <TR>
                <TD align="center"><INPUT class="an_02" type="submit" value="确定"></TD></TR></TBODY></TABLE>
           <input type="hidden" name="url" value="{{$url}}" />
	<input type="hidden" name="id" value="{{$devicesid}}" />
      </FORM></TD></TR></TBODY></TABLE></TR></TBODY></TABLE>
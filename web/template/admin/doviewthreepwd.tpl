  
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TBODY>
  <TR>
    <TD align="center" class="tb_t_bg">填写三权密码</TD>
  </TR>
  <TR>
    <TD>
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
        <TBODY>
        <TR>
          <TD align="center">
            <TABLE width="100%" bgcolor="#ffffff" border="0" cellspacing="1" 
            cellpadding="5" valign="top">
				<TR bgcolor="#f7f7f7">
                <TD width="20%" height="32" align="center">日期</TD>
                <TD width="20%" align="center">密码 </TD>
				<td></td>
			  </TR>
              <TBODY>
			  {{section name=i loop=$allpwd}}
              <TR bgcolor="{{if $smarty.section.i.index%2 eq 0}}#f7f7f7{{/if}}">
                <TD width="20%" height="32" align="center">{{$allpwd[i].date}}</TD>
                <TD width="20%" align="center">{{$allpwd[i].password}}</TD>
				<td></td>
			  </TR>
			  {{/section}}
              </TBODY></TABLE>
    </TD></TR></TBODY></TABLE></TR></TBODY></TABLE>




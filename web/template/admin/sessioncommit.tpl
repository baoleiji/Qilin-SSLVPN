<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TBODY>
  <TR>
    <TD align="center" class="tb_t_bg">填写操作内容 </TD>
  </TR>
  <TR>
    <TD>
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
        <TBODY>
        <TR>
          <TD align="center">
          <form name="f1" method=post enctype="multipart/form-data" action="admin.php?controller=admin_session&action=docommit" target="hide">
            <TABLE width="100%" bgcolor="#ffffff" border="0" cellspacing="1" 
            cellpadding="5" valign="top">
              <TBODY>
              <TR>
               <TD align="center">操作前说明</TD><TD align="center"><TEXTAREA name="prelogincommit" rows="5" cols="50" >{{$logininfo.prelogincommit}}</TEXTAREA>                  				   </TD></TR>
			    <TR>
               <TD align="center">操作后说明</TD><TD align="center"><TEXTAREA name="postloggincommit" rows="5" cols="50" >{{$logininfo.postloggincommit}}</TEXTAREA>                  				   </TD></TR>
              <TR><TD align="center" colspan="2"><INPUT type="submit" {{if $logininfo.lock}}value="该说明已经锁定,不能修改" disabled="disabled"{{else}}  class="an_02" value="提交"{{/if}}></TD></TR></TBODY></TABLE>
	<input type="hidden" name="id" value="{{$logininfo.id}}" />
      </FORM></TD></TR></TBODY></TABLE></TR></TBODY></TABLE>
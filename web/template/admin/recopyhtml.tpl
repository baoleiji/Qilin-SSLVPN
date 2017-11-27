  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TBODY>
  <TR>
    <TD align="center" class="tb_t_bg">应用服务器 </TD>
  </TR>
  <TR>
    <TD>
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
        <TBODY>
        <TR>
          <TD align="center">
           <form name="f1" method=post enctype="multipart/form-data" action="admin.php?controller=admin_app&action=recopy&appserverip={{$appserverip}}" target="hide">
            <TABLE width="100%" bgcolor="#ffffff" border="0" cellspacing="1" 
            cellpadding="5" valign="top">
              <TBODY> 
			  
              <TR bgcolor="#f7f7f7">
                <TD width="25%" height="32" align="right">主机名: </TD>
                <TD><INPUT name="newappserverhostname" id="newappserverhostname" type="text" value="{{$username}}" autocomplete="off"></TD></TR>
             
              <TR>
			  <TR bgcolor="">
                <TD width="25%" height="32" align="right">IP: </TD>
                <TD><INPUT name="newappserverip" id="newappserverip" type="text" value="{{$username}}" autocomplete="off"></TD></TR>
             
              <TR>
			  <TR bgcolor="">
                <TD width="25%" height="32" align="right">描述: </TD>
                <TD><textarea name="description" rows=10 cols=30>{{$p.description}}</textarea></TD></TR>
             
              <TR>
                <TD height="32" align="right"></TD>
                <TD><INPUT class="an_02" type="submit" value="提交" name="actions"></TD></TR></TBODY></TABLE>
      </FORM></TD></TR></TBODY></TABLE>
<SCRIPT>
</SCRIPT></TR></TBODY></TABLE>




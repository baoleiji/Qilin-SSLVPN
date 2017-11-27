<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!DOCTYPE html PUBLIC "-//w3c//dtd html 4.0 transitional//en" ""><HTML><HEAD><META 
content="IE=5.0000" http-equiv="X-UA-Compatible">
 <TITLE>修改</TITLE> 
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<META name="GENERATOR" content="MSHTML 11.00.9600.17801"> 
<META name="author" content="nuttycoder"> 
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" /> 
<STYLE type="text/css">
a {
    color: #003499;
    text-decoration: none;
} 
a:hover {
    color: #000000;
    text-decoration: underline;
}
</STYLE>
 
<SCRIPT language="javascript" src="js/selectdate.js"></SCRIPT>
</HEAD>  
<BODY>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <TD colspan="3" class="list_bg"><strong>命令列表</strong></TD>
  </tr>
  
 <FORM name="f2" onSubmit="javascript:saveAccount=false;" action="admin.php?controller=admin_reports&amp;action=docmdlistreport_cmds" 
        enctype="multipart/form-data" method="post">
  <tr>
    <TD height="33" colspan="3"><TABLE width="100%" class="BBtable" bgcolor="#ffffff" border="0" 
      cellspacing="1" cellpadding="5" valign="top">
      <TBODY>
        <TR>
          <TD width="33%"> 输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.0}}">          </TD>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.1}}">          </TD>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.2}}">          </TD>
        </TR>
        <TR>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.3}}">          </TD>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.4}}">          </TD>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.5}}">          </TD>
        </TR>
        <TR>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.6}}">          </TD>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.7}}">          </TD>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.8}}">          </TD>
        </TR>
        <TR>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.9}}">          </TD>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.10}}">          </TD>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.11}}">          </TD>
        </TR>
        <TR>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.12}}">          </TD>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.13}}">          </TD>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.14}}">          </TD>
        </TR>
        <TR>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.15}}">          </TD>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.16}}">          </TD>
          <TD width="33%">输入命令:
              <INPUT name="commands[]" type="text" value="{{$smarty.session.CMDLISTREPORT.cmds.17}}">          </TD>
        </TR>
      </TBODY>
    </TABLE></TD>
  </tr>
  <tr>
    <TD height="33" colspan="3" align="center"><INPUT class="an_02" type="submit" value="确 定"></TD>
  </tr>
  </form>
</table>
<SCRIPT type="text/javascript">
var siteUrl = "./template/admin/images/date";
function privatekey_set(){
}

change_for_user_auth();
usernameselect();
changeport(0);

var saveAccount = false;
function saveTitle(e){
	if(saveAccount){
		//alert("绑定信息需要点击'保存修改'才能存盘");
		return  e.returnValue='绑定信息需要点击 保存修改 才能存盘,你真的要不保存离开吗？';
		
	}
	return true;
}
function setSave(){
	saveAccount=true;
}

</SCRIPT>
</BODY></HTML>

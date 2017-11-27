<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<SCRIPT>
<!--
function doMkdir(form)
{
	if(form.dirname.value=='' || validStr(form.dirname.value))
	{
		alert("请正确输入目录名称, 名称中不能包含!@#$%^&*?><[]{}~|\/ ");
		return false;
	}
	form.action = "admin.php?controller=admin_member&action=userdisk&Cmd=mkdir";
	form.submit();
}

function DelAddr(filename){
	if(confirm("是否删除 " + filename + " ?")){
		document.List.action = "admin.php?controller=admin_member&action=userdisk&Cmd=Del&filename=" + filename;
		document.List.submit();
	}
	else return false;
}

function Deldir(filename){
	if(confirm("是否删除 " + filename + " ?")){
		document.List.action = "admin.php?controller=admin_member&action=userdisk&Cmd=Deldir&dir=" + filename;
		document.List.submit();
	}
	else return false;
}

function doAdd(form){
	str = '';
	if(form.upload.value=='') str += "上传文件\n";
	if(str!=''){
		str = "请填写好以下各项:\n" + str;
		alert(str);
		return false;
	}
	form.action = "admin.php?controller=admin_member&action=userdisk&Cmd=Add&path="+document.getElementById('path');
	form.submit();
}

function doGotoRoot(form, path)
{
	form.action = "admin.php?controller=admin_member&action=userdisk&Cmd=list&path=" + path;
	form.submit();
}

function validStr(str)
{
	invalidstr = '!@#$%^&*?><[]{}~|\/ ';
	for(i=0; i<str.length; i++)
	{
		
		if(invalidstr.indexOf(str.charAt(i)) >= 0) return true;
//		alert(invalidstr.indexOf(str.charAt(i)));
	}
	return false;
}

//-->
</SCRIPT>
<style type="text/css">
<!--
.STYLE1 {color: #000000}
.STYLE2 {color: #000000}
-->
</style>
</head>

<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">其他——网络硬盘</td>
  </tr>
  <TR> 
<TD WIDTH="100%" ALIGN="center" VALIGN="top" class="main_content"><table width="96%" height="22" cellpadding="cellpadding" cellspacing="cellspacing" background="images/listbg.jpg">
  <form method="post" name="head" id="head">
    <tr style="color: #FFFFFF;" align="center">
      <td><span class="STYLE2">当前路径: <U>{{$OUT.pathname}}</U> </span></td>
      <td><span class="STYLE2">总文件数:  <U>{{$OUT.totalfile}}</U> </span></td>
      <td><span class="STYLE2">空间容量: <U>{{$OUT.LANG_FILE_DISK_QUOTA}}MB</U> 已占用空间:</span> <span class="STYLE2"><U>{{$OUT.totalsize}}</U> 剩余空间:</span> <span class="STYLE2"><U>{{$OUT.remain}}</U></span></td>
      <td><span class="STYLE1"></span></td>
      <td><span class="STYLE1"></span></td>
    </tr>
  </form>
</table></TD>
</TR>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <TBODY>
<FORM NAME="List" METHOD="post" ACTION="">
                  <TR>
                   
					 <th class="list_bg" >文件名/下载</th>
      <th class="list_bg" >类型</th>
      <th class="list_bg" >大小</th>
      <th class="list_bg" >日期</th>
      <th class="list_bg"  colspan=2>操作
      <input name="path" type="hidden" id="path" value="{{$OUT.path}}">      </th>
                  </TR>
</form>
			{{$ListOut}}
			
		</TBODY>
              </TABLE>

	</td>
  </tr>
 
</table>
<table>
  <FORM NAME="form1" METHOD="post" ACTION="">
    <TR>
      <TD><input type="button" name="Submit" value="返回根目录" class="myinput" onClick="doGotoRoot(this.form, '');return false">
        <input type="button" name="Submit2" value="返回上级" class="myinput" onClick="doGotoRoot(this.form, '{{$OUT.pre_path}}');return false"></TD>
      <TD><strong> 
        <input name="dirname" type="text" class="wbk" class="myinput2">
        <input type="button" class="myinput" 
              value="新建文件夹" onClick="doMkdir(this.form);return false">
        <input name="path" type="hidden" id="path" value="{{$OUT.path}}">
        </strong></TD>
    </TR>
  </form>
</table>
<TABLE WIDTH="96%" BORDER="0" align="center" CELLPADDING="2" CELLSPACING="2">
<form name="form2" enctype="multipart/form-data" method="post" action="">
  <TR> 
    <TD><div align="center">
<input type=file name="upload" size=40 class="myinput2">
        <input type="button" class="myinput" 
              onClick="doAdd(this.form);return false" value="增加">
        <input name="path" type="hidden" id="path" value="{{$OUT.path}}">
      </div></TD>
  </TR></form>
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

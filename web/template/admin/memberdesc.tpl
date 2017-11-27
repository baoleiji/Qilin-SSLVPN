<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
</ul><span class="back_img"><A href="admin.php?controller=admin_member&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>


  <tr>
	<td class="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
	<form name="ip_list" action="admin.php?controller=admin_member&action=memberdesc_delete&uid={{$uid}}" method="post">
                <TBODY>
                  <TR>
			
                    <th class="list_bg" width="5%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=id&orderby2={{$orderby2}}" >选</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=membername&orderby2={{$orderby2}}" >用户名</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=optime&orderby2={{$orderby2}}" >时间</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=action&orderby2={{$orderby2}}" >动作</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=prideptid&orderby2={{$orderby2}}" >过去部门</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=curdeptid&orderby2={{$orderby2}}" >现在部门</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=pripostid&orderby2={{$orderby2}}" >过去职位</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=curpostid&orderby2={{$orderby2}}" >现在职位</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_member&action=memberdesc&orderby1=desc&orderby2={{$orderby2}}" >描述</a></TD>
					<th class="list_bg" width="10%">操作</TD>
                  </TR>

            </tr>
			{{section name=t loop=$s}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>

				<td width="5%"><input type="checkbox" name="chk_gid[]" value="{{$s[t].id}}"></td>
				 <td> {{$s[t].membername}}</td>
				 <td> {{$s[t].optime}}</td>
				 <td> {{$s[t].action}}</td>
				 <td> {{$s[t].prideptname}}</td>
				 <td> {{$s[t].curdeptname}}</td>
				 <td> {{$s[t].pripostname}}</td>
				 <td> {{$s[t].curpostname}}</td>
				  <td> {{$s[t].desc}}</td>
				<td style="TEXT-ALIGN: left;"><img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_member&action=memberdesc_edit&id={{$s[t].id}}" >编辑</a>
				</td> 
			</tr>
			{{/section}}
	          <tr>
	           <td  colspan="5" align="left">
		          <input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_gid[]')e.checked=this.form.select_all.checked;}" value="checkbox">全选&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="my_confirm('删除所选');if(chk_form()) document.ip_list.action='admin.php?controller=admin_member&action=memberdesc_delete'; else return false;" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp; 
					<input type="button" name="submit" onclick="location='admin.php?controller=admin_member&action=memberdesc_edit&uid={{$uid}}'" value=" 增加 " class="an_02" />
		   		</td>
				<td  colspan="5" align="right">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_member&action=memberdesc&page='+this.value;">页
		   </td>
		   		</tr>
	           
		</TBODY>
              </TABLE></form>	</td>
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



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0090)http://114.255.20.254/newradius/admin.php -->
<HTML><HEAD><TITLE>{{$title}}</TITLE><LINK rel=stylesheet type=text/css 
href="{{$template_root}}/images/content.css">
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18372"></HEAD>
<BODY>
<CENTER><BR><BR>
  <table width="95%" border="0" cellpadding="1" cellspacing="1" bgcolor="3c84cc">
    <tr>
      <td class="td_bg"><TABLE border=0 cellSpacing=0 cellPadding=2 width="100%">
          <TBODY>
            <TR vAlign=top align=right>
              <TD class=td_title height=25 width="35%" align=left>{{$title}}</TD>
            </TR>
          </TBODY>
        </TABLE>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <TBODY>
                  <TR>
   
                    <th class="list_bg" >服务器类型</TD>
                    <th class="list_bg" >登陆方式</TD>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			{{section name=t loop=$alltem}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
 <td> {{$alltem[t].device_type}}</td>
				<td>{{$alltem[t].login_method}}</td>
				<td><img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=tem_del&id={{$alltem[t].id}}';}">删除</a></td> 
			</tr>
			{{/section}}

                <tr>
	           <td  colspan="5" align="right">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=tem_index&page='+this.value;">页
		   </td>
		</tr>
		</TBODY>
              </TABLE></td>

        </table></td>
    </tr>
  </table>





<script language="javascript">

function my_confirm(str){
	if(!confirm("确认要" + str + "？"))
	{
		window.event.returnValue = false;
	}
}

</script>
</body>
</html>




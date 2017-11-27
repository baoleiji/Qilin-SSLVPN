<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
</head>

<body>
<script>
function change_option(number,index){
 for (var i = 1; i <= number; i++) {
      document.getElementById('current' + i).className = '';
      document.getElementById('content' + i).style.display = 'none';
 }
  document.getElementById('current' + index).className = 'current';
  document.getElementById('content' + index).style.display = 'block';
  if(index==1){
	document.getElementById('finalsubmit').style.display = 'block';
  }else{
	document.getElementById('finalsubmit').style.display = 'none';
  }
  return false;
}
</script>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td  align="right">
	<span class="back_img"><A href="admin.php?controller=admin_pro&action=dev_index&gid={{$gid}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
	</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post action="admin.php?controller=admin_pro&action=devbatch_save&id={{$id}}&appconfigedit={{$appconfigedit}}&appconfigid={{$appconfigid}}">
			
				 <div id="content1" class="content">
				   <div class="contentMain">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		修改方式	
		</td>
		<td width="67%">
		<input type='radio' name="stra_type" value='mon' {{if $method == 'mon' || $method ==''}}checked{{/if}}>
		按月
		<input type='radio' name="stra_type" value='week' {{if $method == 'week'}}checked{{/if}}>
		每周
		<input type='radio' name="stra_type" value='custom'{{if $method == 'user'}}checked{{/if}}>
		自定义
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		频率
		</td>
		<td width="67%">
		<input type=text name="freq" size=35 value="{{if $freq}}{{$freq}}{{else}}1{{/if}}" >**
		</td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td colspan='2'>
		**频率的说明：如果修改方式选择每周，这里填写周几（1—7）,如果是按月，填写几号（1—31）,如果是自定义，这里是几日更新一次（大于0的整数）
		</td>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		SSH默认端口	
		</td>
		<td width="67%">
		<input type=text name="sshport" size=35 value="{{if $id }}{{$sshport}}{{else}}22{{/if}}" >
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		TELNET默认端口	
		</td>
		<td width="67%">
		<input type=text name="telnetport" size=35 value="{{if $id }}{{$telnetport}}{{else}}23{{/if}}" >
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		FTP默认端口
		</td>
		<td width="67%">
		<input type=text name="ftpport" size=35 value="{{if $id }}{{$ftpport}}{{else}}21{{/if}}" >
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		RDP默认端口
		</td>
		<td width="67%">
		<input type=text name="rdpport" size=35 value="{{if $id }}{{$rdpport}}{{else}}3389{{/if}}" >
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		VNC默认端口	
		</td>
		<td width="67%">
		<input type=text name="vncport" size=35 value="{{if $id }}{{$vncport}}{{else}}5900{{/if}}" >
	  </td>
	</tr>
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		
		<td width="33%" align=right>
		巡检模式	
		</td>
		
		<td width="67%">
		<select  class="wbk"  name="monitor">		
			<OPTION VALUE="0" {{if $monitor == 0}}selected{{/if}}>关闭</option>
			<OPTION VALUE="1" {{if $monitor == 1}}selected{{/if}}>SNMP</option>
			<OPTION VALUE="2" {{if $monitor == 2}}selected{{/if}}>登录</option>
		<OPTION VALUE="3" {{if $monitor == 3}}selected{{/if}}>上传</option>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;端口监控:<input type=checkbox name="snmpnet" {{if $snmpnet }}checked{{/if}} size=35 value="1" >
		</td></tr>
	
	
	{{assign var="trnumber" value=$trnumber+1}}
	
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		
	<td width="33%" align=right>
		SNMP字符串	
		</td>
		
	<td width="67%">
		<input type=text name="snmpkey" size=35 value="{{$snmpkey}}" >
	  </td>
	
	</tr>
	</table> </div>
				 </div>

				 </div>
	<tr id="finalsubmit"><td align="center"><input type=submit  value="保存修改" class="an_02"></td></tr></table>
<input type="hidden" name="ips" value="{{$ips}}" />
 </form>

	</td>
  </tr>
</table>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>




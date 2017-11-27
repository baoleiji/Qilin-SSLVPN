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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="middle" class="hui_bj" >
	<div class="menu">
	<ul>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_slaveserver">探针管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_system">备份管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
</ul><span class="back_img"><A href="javascript:history.back();"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="25" border="0"></A></span>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
    	<FORM method=post name=edit 
            action=admin.php?controller=admin_slaveserver&action=save>

      <input type='hidden' name='sid' value="{{$result['sid']}}">
      
	<table width=100%  class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>主机名：</TD>
                    <TD align="left" class=main_list_td1>
                   			<input   size=30 type="text" name="hostname"   value="{{$result.hostname}}"/>
                      </TD>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>主机IP：</TD>
                    <TD align="left" class=main_list_td1>
                   			<input   size=30 type="text" name="ip"   value="{{$result.ip}}"/>
                      </TD>
	</tr>
 
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                 <TD align="right" class=main_list_td1>最新更新时间：</TD>
                    <TD align="left" class=main_list_td1>
                        <input  size=30 type="text" name="datetime" id="datetime"   />
 						<input type="button" id="datetime_trigger" name="datetime_trigger" value="选择时间">
                      
                      </TD>
	</tr>

			
     	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>主机描述：</TD>
                    <TD align="left" class=main_list_td1>
                   		<textarea style="width:225px;height:120px;"	 name="desc"  >{{$result.desc}}</textarea>
                   		
                      </TD>
	</tr>
	
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
         <TD  align="center" colSpan=2 >
         <INPUT class=an_02 value=保存修改  type=submit name=submit>
         </TD>

	</tr>

	</table>
</form>
</td>


</tr>
</table>

 <script type="text/javascript">



function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}
				

 				new Calendar({
                          inputField: "datetime",
                          dateFormat: "%Y-%m-%d %H:%M:%S",
                          showTime: true,
                          trigger: "datetime_trigger",
                          bottomBar: true,
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());
                                 
                                  this.hide();
                          }
                  });

document.getElementById('datetime').value='{{$result.datetime}}';

			
</script>
</body>

</html>




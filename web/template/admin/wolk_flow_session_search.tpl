<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.SessionsList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function searchit(){
	document.search.action = "admin.php?controller=admin_session&backupdb_id={{$backupdb_id}}";
	document.search.action += "&addr="+document.search.ip.value;
	document.search.action += "&luser="+document.search.luser.value;
	document.search.action += "&usergroup="+document.search.usergroup.value;
	document.search.action += "&start1="+document.search.f_rangeStart.value;
	document.search.action += "&start2="+document.search.f_rangeEnd.value;
	loadurl(document.search.action, 600)
	//alert(document.search.action);
	//return false;
	return true;
}

</script>

</head>
<body>
<div id="fade" class="black_overlay"></div> 
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
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content"><form action="admin.php?controller=admin_session&backupdb_id={{$backupdb_id}}" method="post" name="search" id="search" >
  <tr>
    <td></td>
    <td>
&nbsp;开始日期：<input type="text"  name="f_rangeStart" size="13" id="f_rangeStart" value="" class="wbk"/> 
<input type="button" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">
&nbsp;结束日期：<input  type="text" name="f_rangeEnd" size="13" id="f_rangeEnd"  value="" class="wbk"/> 
<input type="button" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk"> 
&nbsp;<input type="button" height="35" align="middle" onClick="return search_session();" border="0" value=" 确定 " class="bnnew2"/></td>
  </tr>
  <input type="hidden" name="wid" id="wid" value="{{$wid}}" />
  </form>
</table>	
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d %H:%M:%S");


</script>
	  </td>
  </tr>
  <tr><td>
  <form action="admin.php?controller=admin_workflow&action=workflow_close&backupdb_id={{$backupdb_id}}&wid={{$wid}}" method="post" name="search" id="search" >
  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
					<th class="list_bg"></th>
					<th class="list_bg"><a href="admin.php?controller=admin_session&orderby1=cli_addr&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.SourceAddress}}</a></th>
						<th class="list_bg"><a href="admin.php?controller=admin_session&orderby1=addr&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.DeviceAddress}}</a></th>
						
						<th class="list_bg"><a href="admin.php?controller=admin_session&orderby1=type&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.LoginMethod}}</a></th>
						<th class="list_bg"><a href="admin.php?controller=admin_session&orderby1=user&orderby2={{$orderby2}}&backupdb_id={{$backupdb_id}}">{{$language.LocalUser}}</a></th>
						
					</tr>
					
					{{section name=t loop=$allsession}}
					<tr {{if $allsession[t].cmd_danger eq 2}}bgcolor="red"{{elseif $allsession[t].cmd_danger eq 3}}bgcolor="yellow"{{elseif $allsession[t].cmd_danger eq 4}}bgcolor="#0373BF"{{elseif $allsession[t].cmd_danger eq 1}}bgcolor="orange" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
					<td><input type="radio" name="sessionid" value="{{$allsession[t]['sid']}}" /></td>
												<td>{{$allsession[t].cli_addr}}</td>
						
						<td>{{$allsession[t].addr}}</td>
						<td>{{$allsession[t].type}}</td>
						<td>{{$allsession[t].user}}</td>
					</tr>		

					{{/section}}
					<tr><td colspan="2"><input type="submit" class="an_06" name="submit" value="确定关单" ></td>
						<td height="45" colspan="12" align="right" bgcolor="#FFFFFF">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}
							  <input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;" class="wbk">
							  {{$language.page}}&nbsp;   </td>
					</tr>
					
				</table>
				</form>
<iframe name="hide" height="0" frameborder="0" scrolling="no" id="hide"></iframe>
</body>
</html>



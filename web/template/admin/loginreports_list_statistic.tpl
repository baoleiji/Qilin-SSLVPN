<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.LoingReport}}{{$language.List}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
<script type="text/javascript">
function changetype(sid){
document.getElementById(sid).checked=true;
}
function searchit(){
	document.report.action = "{{$curr_url}}";
	document.report.action += "&f_rangeStart="+document.report.f_rangeStart.value;
	document.report.action += "&f_rangeEnd="+document.report.f_rangeEnd.value;
	document.report.action += "&usergroup="+document.report.usergroup.value;
	document.report.submit();
	return false;
}
</script>
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
{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2 or $smarty.session.ADMIN_LEVEL eq 21 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 101}}	
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="#">登录统计</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=report_search_diy">自定义报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}<span class="back_img"><A href="admin.php?controller=admin_reports&action={{if $smarty.get.dateinterval eq 'diy'}}report_search_diy{{else}}report_search{{/if}}&back=1"><IMG src="./template/admin/images/back1.png" width="80" height="25" border="0"></A></span>
</ul>
</div></td></tr>

 
  <tr>
    <td class="main_content">
<form action="{{$curr_url}}" method="post" name="report" >
运维组：<select name='usergroup' id="usergroup" style="width:150px">
			<option value="">所有组</option>
			{{section name=g loop=$usergroup}}
			<option value="{{$usergroup[g].groupname}}">{{$usergroup[g].groupname}}</option>
			{{/section}}
		</select>
{{$language.Starttime}}：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="{{$f_rangeStart|date_format:'%Y-%m-%d'}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="{{$language.Edittime}}"  class="wbk">


 {{$language.Endtime}}：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd"  value="{{$f_rangeEnd|date_format:'%Y-%m-%d'}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="{{$language.Edittime}}"  class="wbk">
 &nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
     &nbsp;&nbsp;
	 
</form> 
	  </td>
  </tr>
  <script type="text/javascript">
                  new Calendar({
                          inputField: "f_rangeStart",
                          dateFormat: "%Y-%m-%d",
                          trigger: "f_rangeStart_trigger",
                          bottomBar: false,
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());
                                 
                                  this.hide();
                          }
                  });
                  new Calendar({
                      inputField: "f_rangeEnd",
                      dateFormat: "%Y-%m-%d",
                      trigger: "f_rangeEnd_trigger",
                      bottomBar: false,
                      onSelect: function() {
                              var date = Calendar.intToDate(this.selection.get());
                             
                              this.hide();
                      }
              });
                </script>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
						<th class="list_bg"   width="10%">{{$language.Username}}</th>
						<th class="list_bg"   width="10%">别名</th>
						<th class="list_bg"   width="10%">运维组</th>
						<th class="list_bg"   width="5%">ssh</th>
						<th class="list_bg"   width="10%">telnet</th>
						<th class="list_bg"   width="5%">rdp</th>
						<th class="list_bg"   width="5%">应用</th>
						<th class="list_bg"   width="5%">vnc</th>
						<th class="list_bg"   width="5%">ftp</th>
						<th class="list_bg"   width="5%">sftp</th>
						<th class="list_bg"   width="10%">前台</th>
						<th class="list_bg"   width="10%">X11</th>
						<th class="list_bg"   width="15%">{{$language.total}}</th>
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td>{{$allsession[t].username}}</td>
						<td>{{$allsession[t].realname}}</td>
						<td>{{$allsession[t].groupname}}</td>
						<td>{{if !$allsession[t].sct}}0{{else}}{{$allsession[t].sct}}{{/if}}</td>
						<td>{{if !$allsession[t].tct}}0{{else}}{{$allsession[t].tct}}{{/if}}</td>
						<td>{{if !$allsession[t].rct}}0{{else}}{{$allsession[t].rct}}{{/if}}</td>
						<td>{{if !$allsession[t].act}}0{{else}}{{$allsession[t].act}}{{/if}}</td>
						<td>{{if !$allsession[t].vct}}0{{else}}{{$allsession[t].vct}}{{/if}}</td>
						<td>{{if !$allsession[t].fct}}0{{else}}{{$allsession[t].fct}}{{/if}}</td>
						<td>{{if !$allsession[t].sfct}}0{{else}}{{$allsession[t].sfct}}{{/if}}</td>
						<td>{{if !$allsession[t].webct}}0{{else}}{{$allsession[t].webct}}{{/if}}</td>
						<td>{{if !$allsession[t].xct}}0{{else}}{{$allsession[t].xct}}{{/if}}</td>
						<td>{{if !$allsession[t].ct}}0{{else}}{{$allsession[t].ct}}{{/if}}</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="13" align="right">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">{{$language.page}} <!--当前数据表: {{$now_table_name}}-->   导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>  <a href="{{$curr_url}}&derive=2"  target="hide"><img src="{{$template_root}}/images/html.png" border=0></a>  <a href="{{$curr_url}}&derive=3" ><img src="{{$template_root}}/images/word.png" border=0></a>  <a href="{{$curr_url}}&derive=4" ><img src="{{$template_root}}/images/pdf.png" border=0></a> {{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1"></a>{{/if}}
						<!--
						<select  class="wbk"  name="table_name">
						{{section name=t loop=$table_list}}
						<option value="{{$table_list[t]}}" {{if $table_list[t] == $now_table_name}}selected{{/if}}>{{$table_list[t]}}</option>
						{{/section}}
						</select>
						-->
						</td>
					</tr>
				</table>
	</td>
  </tr>
  {{if $data}}
  <tr><td class="main_content"><img src="include/pChart/graphgenerate.php?{{$data}}{{$info}}graphtype=pie"</td></tr>
  <tr><td class="main_content"><img src="include/pChart/graphgenerate.php?{{$data}}{{$info}}graphtype=bar"</td></tr>
  {{/if}}
</table>
<script type="text/javascript">
function loginexport(){
var exportid = document.getElementById("exportid");
exportid.href="{{$curr_url}}&derive=1&f_rangeStart="+document.getElementById('f_rangeStart').value+"&f_rangeEnd="+document.getElementById('f_rangeEnd').value;
return true;
}
</script>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>



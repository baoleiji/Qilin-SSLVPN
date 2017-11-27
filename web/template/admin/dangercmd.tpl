<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.LogList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
<script>
function setScroll(){
	window.parent.scrollTo(0,0);
}
var member = new Array();
{{section name=m loop=$member}}
member[{{$smarty.section.m.index}}]={'username':'{{$member[m].username}}','realname':'{{$member[m].realname}}'}
{{/section}}
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
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=commandreport">命令总计</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cmdcachereport">命令统计</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cmdlistreport">命令列表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=dangercmd">高危命令</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=appreport&number=2">应用报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=sftpreport&number=3">SFTP{{$language.Command}}{{$language.report}}</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>	
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=ftpreport&number=6">FTP{{$language.Command}}{{$language.report}}</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>


  
  <tr>
	<td class="">
<form method="get" name="session_search" action="admin.php?controller=admin_reports&action=dangercmdsearch" >
				<table bordercolor="white" cellspacing="0" cellpadding="0" border="0" width="100%"  class="BBtable">
				 <tr>
    <th class="list_bg" colspan="2">{{$language.Man}}：{{$language.Search}}{{$language.Session}},留空表示{{$language.no}}限制 </th>
  </tr>									
					{{if $admin_level == 1}}
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">运维用户：</td>
						<td class="td_line" width="70%">
						<select name='luser' id="luser">
						<option value="">所有用户</option>
						{{section name=m loop=$member}}
						<option value="{{$member[m].username}}">{{$member[m].username}}</option>
						{{/section}}
						</select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" onclick="toRealname();" id="RealNameToId" value="on" >&nbsp;实名</td>
					</tr>
					<tr>
						<td class="td_line" width="30%">本地用户：</td>
						<td class="td_line" width="70%"><input name="user" type="text" class="wbk"></td>
					</tr>
					{{/if}}
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">{{$language.DeviceAddress}}：</td>
						<td class="td_line" width="70%">
							<input name="addr" id="addr" type="text" class="wbk" /><br />
							<select  class="wbk"  name="fromlist" size="6" style="width:140px;height:110px;" onchange="javascript:document.getElementById('addr').value=this.options[this.selectedIndex].text">
								{{section name=t loop=$alldev}}
								<option name="{{$alldev[t].device_ip}}">{{$alldev[t].device_ip}}</option>
								{{/section}}
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_line" width="30%">{{$language.Sessiontype}}：</td>
						<td class="td_line" width="70%">
						<select  class="wbk"  name="type">
							<option value='all'>{{$language.All}}</option>
							<option value='ssh'>ssh</option>
							<option value='telnet'>telnet</option>
						</select>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">{{$language.StartTime}}：</td>
						<td class="td_line" width="70%"><input name="start1" id="f_rangeStart" type="text" class="wbk">&nbsp;<input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="起始时间"  class="wbk"></td>
					</tr>
					<tr>
						<td class="td_line" width="30%">{{$language.EndTime}}：</td>
						<td class="td_line" width="70%"><input name="end2" id="f_rangeEnd2" type="text" class="wbk">&nbsp;<input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger2" name="f_rangeEnd_trigger2" value="终止时间"  class="wbk"></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">{{$language.Historycommands}}：</td>
						<td class="td_line" width="70%"><input type="text" class="wbk" name="command"></td>
					</tr>
					<tr>
						<td class="td_line" width="30%">{{$language.SourceAddress}}：</td>
						<td class="td_line" width="70%"><input type="text" class="wbk" name="srcaddr"></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" colspan="2" align="center"><input name="submit" type="submit" onclick="setScroll();"  value="{{$language.Search}}" class="an_02">
					</tr>
				</table>
				<script type="text/javascript">
                  new Calendar({
                          inputField: "f_rangeStart",
                          dateFormat: "%Y-%m-%d %H:%M:%S",showTime: true,
                          trigger: "f_rangeStart_trigger",
                          bottomBar: false,
						  popupDirection:'up',
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());
                                 
                                  this.hide();
                          }
                  });
                  new Calendar({
                      inputField: "f_rangeEnd2",
                      dateFormat: "%Y-%m-%d %H:%M:%S",showTime: true,
                      trigger: "f_rangeEnd_trigger2",
                      bottomBar: false,
					  popupDirection:'up',
                      onSelect: function() {
                              var date = Calendar.intToDate(this.selection.get());
                             
                              this.hide();
                      }
              });
                </script>
			</form>
	</td>
  </tr>
</table>

<script>
function toRealname(){
	document.getElementById('luser').options.length=0;
	document.getElementById('luser').options[document.getElementById('luser').options.length]= new Option('所有用户','');
	if(document.getElementById('RealNameToId').checked){
		
		for(var i=0; i<member.length; i++){
			document.getElementById('luser').options[document.getElementById('luser').options.length]= new Option(member[i].realname,member[i].username);
		}
	}else{
		for(var i=0; i<member.length; i++){
			document.getElementById('luser').options[document.getElementById('luser').options.length]= new Option(member[i].username,member[i].username);
		}
	}
}
</script>


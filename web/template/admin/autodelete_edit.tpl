<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
</head>
 <SCRIPT language=javascript src="{{$template_root}}/images/selectdate.js"></SCRIPT>
 <SCRIPT type=text/javascript>
var siteUrl = "{{$template_root}}/images/date";
var apppub = new Array();
{{section name=ap loop=$apppubs}}
apppub[{{$smarty.section.ap.index}}] = new Array();
apppub[{{$smarty.section.ap.index}}]['ip'] = '{{$apppubs[ap].ip}}';
apppub[{{$smarty.section.ap.index}}]['apps']=new Array();
{{section name=ap2 loop=$apppubs[ap].apps}}
apppub[{{$smarty.section.ap.index}}]['apps'][{{$smarty.section.ap2.index}}]=new Array();
apppub[{{$smarty.section.ap.index}}]['apps'][{{$smarty.section.ap2.index}}]['id']='{{$apppubs[ap].apps[ap2].id}}';
apppub[{{$smarty.section.ap.index}}]['apps'][{{$smarty.section.ap2.index}}]['name']='{{$apppubs[ap].apps[ap2].name}}';
apppub[{{$smarty.section.ap.index}}]['apps'][{{$smarty.section.ap2.index}}]['url']='{{$apppubs[ap].apps[ap2].url}}';

{{/section}}
{{/section}}

</SCRIPT>
 <SCRIPT type=text/javascript>
var siteUrl = "{{$template_root}}/images/date";
var appprogram = new Array();
{{section name=pp loop=$appprogram}}
appprogram[{{$appprogram[pp].id}}]='{{$appprogram[pp].path|addslashes}}';
{{/section}}
function setappaddress(value){
	var name = document.getElementById('autologinflag').options[document.getElementById('autologinflag').options.selectedIndex].text.toLowerCase();
	document.getElementById('url').style.display='none';
	document.getElementById('troracle_auth').style.display='none';
	if(name=='ie'){
		document.getElementById('url').style.display='';
	}else if(name=='toad' || name=='plsql'){
		document.getElementById('troracle_auth').style.display='';
	}
	document.getElementById('path').value=appprogram[value];
	document.getElementById('path').readonly=true;
}

var AllServers = new Array();
var i=0;
{{section name=kk loop=$servers}}
AllServers[i++]='{{$servers[kk].device_ip}}';
{{/section}}

function filter(){
	var filterStr = document.getElementById('filtertext').value;
	var appserver = document.getElementById('device_ip');
	appserver.options.length=1;
	for(var i=0; i<AllServers.length;i++){
		if(filterStr.length==0 || AllServers[i].indexOf(filterStr) >= 0){
			appserver.options[appserver.options.length++] = new Option(AllServers[i],AllServers[i]);
		}
	}
}
</SCRIPT>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
     <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&action=batch_del&backupdb_id={{$backupdb_id}}">日志删除</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&action=autodelete&backupdb_id={{$backupdb_id}}">自动删除</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_session&action=autodelete&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0" >
	
          <tr>
            <td align="center">
    <form name="f1" method=post action="admin.php?controller=admin_session&action=autodelete_save&id={{$autodelete.seq}}">
	<table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="3" class="list_bg"></th></tr>
		
	{{assign var="trnumber" value=0}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>名称</td>
		<td width="67%">{{$autodelete.zhname}}:{{$autodelete.name}}</td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>天</td>
		<td width="67%"><input type="text" name="time" value="{{$autodelete.time}}" /></td>
	</tr>
	
			 
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
					<td></td><td><input type="hidden" name="ac" value="new" />
<input type="hidden" name="id" value="{{$p.id}}" />
<input type=submit  value="保存修改" class="an_02"></td></tr>
	</table>
<br>
<input type="hidden" name="sessionlgroup" value="{{$sessionlgroup}}" />
<input type="hidden" name="sessionluser" value="{{$sessionluser}}" />
</form>
	</td>
  </tr>
</table>
<script>
if(document.getElementById('program_IE').selected){
	document.getElementById('url').style.display='';
}
if(document.getElementById('program_TOAD').selected || document.getElementById('program_PLSQL').selected){
	document.getElementById('troracle_auth').style.display='';
}
</script>
</body>

<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.SessionsList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/layer/layer.js"></script>
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

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
	 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>

	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=license">License</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
					<tr>
						<th class="list_bg"  bgcolor="d9ecfa" width="8%"><a href="admin.php?controller=admin_index&action=license&orderby1=deadline&orderby2={{$orderby2}}" >{{$language.deaddate}}</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="8%"><a href="admin.php?controller=admin_index&action=license&orderby1=equipnum&orderby2={{$orderby2}}" >{{$language.devicenumber}}</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="5%"><a href="admin.php?controller=admin_index&action=license&orderby1=company&orderby2={{$orderby2}}" >{{$language.authorizer}}</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="6%"><a href="admin.php?controller=admin_index&action=license&orderby1=key&orderby2={{$orderby2}}" >{{$language.seriesnumber}}</a></th>
					</tr>
					{{section name=l loop=$license}}
<tr {{if $smarty.section.l.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
<td>{{$license[l].deadline}}</td>
<td>{{$license[l].equipnum}}</td>
<td>{{$license[l].company}}</td>
<td>{{$license[l].key}}</td>
</tr>
{{/section}}
	<tr><td  align="left" colspan="3"><input type="button" onclick="window.location='admin.php?controller=admin_index&action=upload_license'"  name="add"  value="上传" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="createlicense();"  name="add"  value="生成" class="an_02"></td>
		<td  colspan="10" align="right">
			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_member&action=keys_index&page='+this.value;">{{$language.page}}&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
	</table>
	</td>
  </tr>
</table>
<script>
function createlicense(){
layer.open({
  type: 2,
  title:'License Key',
  success: function(layero, index){
    layer.iframeAuto(index);
  },
  shadeClose: true,
  shade: 0.01,
  closeBtn:1,
  scrollbar: false,
  area:['520px','500px'],
  offset: '10px',
  content: 'admin.php?controller=admin_index&action=create_license'

}); 
}
</script>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>



<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>程序{{$language.Configure}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">程序{{$language.Configure}}——更改{{$language.Configure}}</td>
  </tr>
  <tr>
	<td class="main_content">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
<tr>
						<th class="list_bg"  bgcolor="d9ecfa" >{{$language.IPAddress}}</th>
						<th class="list_bg"  bgcolor="d9ecfa" >起始标记</th>
						<th class="list_bg"  bgcolor="d9ecfa" >结果标记1</th>
						<th class="list_bg"  bgcolor="d9ecfa" >结果标记2</th>
						<th class="list_bg"  bgcolor="d9ecfa" >结果标记3</th>
						<th class="list_bg"  bgcolor="d9ecfa" >结果标记4</th>
						<th class="list_bg"  bgcolor="d9ecfa" >结果标记5</th>
					</tr>
					<form name="news_add" method="post" action="admin.php?controller=admin_config&action=prompts_save">
					{{section name=t loop=$config}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><input name="id[]" type="hidden" value="{{$config[t].id}}" /><input name="ip[]" type="text" class="wbk" value="{{$config[t].ip}}" /></td>
						<td><input name="start[]" type="text" class="wbk" value="{{$config[t].start}}" /></td>
						<td><input name="end1[]" type="text" class="wbk" value="{{$config[t].end1}}" /></td>
						<td><input name="end2[]" type="text" class="wbk" value="{{$config[t].end2}}" /></td>
						<td><input name="end3[]" type="text" class="wbk" value="{{$config[t].end3}}" /></td>
						<td><input name="end4[]" type="text" class="wbk" value="{{$config[t].end4}}" /></td>
						<td><input name="end5[]" type="text" class="wbk" value="{{$config[t].end5}}" /></td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="7" align="center">
							<input name="submit" type="submit"   value="保存{{$language.Configure}}" />
						</td>
					</tr>
					</form>
					<form name="news_add" method="post" action="admin.php?controller=admin_config&action=prompts_add">
					<tr>
						<th class="list_bg" >{{$language.IPAddress}}</th>
						<th class="list_bg" >起始标记</th>
						<th class="list_bg" >结果标记1</th>
						<th class="list_bg" >结果标记2</th>
						<th class="list_bg" >结果标记3</th>
						<th class="list_bg" >结果标记4</th>
						<th class="list_bg" >结果标记5</th>
					</tr>
					<tr>
						<td><input name="new_ip" type="text" class="wbk" value=""></td>
						<td><input name="new_start" type="text" class="wbk" value="login:"></td>
						<td><input name="new_end1" type="text" class="wbk" value="\[\S+\@[\s\S]+]\#"></td>
						<td><input name="new_end2" type="text" class="wbk" value="\[\S+\@[\s\S]+\]\$"></td>
						<td><input name="new_end3" type="text" class="wbk" value="Audit\-ZJUnicom\#"></td>
						<td><input name="new_end4" type="text" class="wbk" value="Audit\-ZJUnicom\$"></td>
						<td><input name="new_end5" type="text" class="wbk" value=""></td>
					</tr>
					<tr>
						<td colspan="7" align="center">
							<input name="submit" type="submit"  value="{{$language.new}}增{{$language.Configure}}" />
						</td>
					</tr>
					</form>
		</table>
	</td>
  </tr>
</table>

</body>
</html>



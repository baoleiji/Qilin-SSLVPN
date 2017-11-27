<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
</head>
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
<script>
var servergroup = new Array();
var i=0;
{{section name=a loop=$allsgroup}}
{{if $sgroup.id ne $allsgroup[a].id}}
servergroup[i++]={id:{{$allsgroup[a].id}},name:'{{$allsgroup[a].groupname}}',ldapid:{{$allsgroup[a].ldapid}},level:{{$allsgroup[a].level}}};
{{/if}}
{{/section}}
</script>
<body>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
</ul><span class="back_img"><A href="admin.php?controller=admin_pro&action=dev_group&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>

            <td align="center">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_pro&action=dev_group_save&id={{$sgroup.id}}&ldapid={{$ldapid}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="2" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		节点名
		</td>
		<td width="67%">
		<input type = text name="groupname" value="{{$sgroup.groupname}}">
	  </td>
	</tr>
	<tr>
		<td width="33%" align=right>
		负载均衡	
		</td>
		<td width="67%">
				<select  class="wbk"  name="loadbalance">
				<OPTION VALUE="0">无</option>
		{{section name=l loop=$loadbalances}}
			<OPTION VALUE="{{$loadbalances[l]['sid']}}" {{if $loadbalances[l].sid == $sgroup.loadbalance}}selected{{/if}}>{{$loadbalances[l].ip}}</option>
		{{/section}}
		</select>
	  </td>
	</tr>
	<tr>
		<td width="33%" align=right>
		所属目录
		</td>
		<td width="67%">
		{{include file="select_sgroup_ajax.tpl" }}
	  </td>
	</tr>
	<tr bgcolor="f7f7f7" id="attributeid" style="display:none">
		<td width="33%" align=right>
		属性	
		</td>
		<td width="67%">
				<select  class="wbk"  name="attribute">
				<OPTION VALUE="0" {{if !$sgroup.attribute}}selected{{/if}}>全部</option>
				<OPTION VALUE="1" {{if 1 == $sgroup.attribute}}selected{{/if}}>用户</option>
				<OPTION VALUE="2" {{if 2 == $sgroup.attribute}}selected{{/if}}>主机</option>
				</select>
	  </td>
	</tr>
	<tr>
		<td width="33%" align=right valign="top">
		描述
		</td>
		<td width="67%">
		<textarea cols="30" rows="10"  name="description">{{$sgroup.description}}</textarea>
	  </td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit"  value=" 确    认 " class="an_06"></td>
	</tr>
	</table>
<br>
<input type="hidden" name="levelx" id="levelxid" value="{{$sgroup.level}}" />
<input type="hidden" name="ldapid" id="ldapid" value="{{$ldapid}}" />
<input type="hidden" name="ldapid1" id="ldapid1id" value="{{$ldapid1}}" />
<input type="hidden" name="ldapid2" id="ldapid2id" value="{{$ldapid2}}" />
<input type="hidden" name="ldapid3" id="ldapid3id" value="{{$ldapid3}}" />
<input type="hidden" name="ldapid4" id="ldapid4id" value="{{$ldapid4}}" />
<input type="hidden" name="ldapid5" id="ldapid5id" value="{{$ldapid5}}" />
</form>
	</td>
  </tr>
</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}


function check(){
}
{{$changelevelstr}}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



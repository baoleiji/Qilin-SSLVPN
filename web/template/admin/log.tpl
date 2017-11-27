<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script>
	function my_confirm(str){
		if(!confirm("确认要" + str + "？"))
		{
			window.event.returnValue = false;
		}
	}
	function chk_form(){
		for(var i = 0; i < document.member_list.elements.length;i++){
			var e = document.member_list.elements[i];
			if(e.name == 'chk_member[]' && e.checked == true)
				return true;
		}
		alert("您没有{{$language.select}}任何{{$language.User}}！");
		return false;
	}
</script>
<script>
function setScroll(){
	window.parent.scrollTo(0,0);
}
</script>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	{{section name=t loop=$tab}}
	<li class="{{if $tabname ne $tab[t].tabname}}me_b{{else}}me_a{{/if}}"><img src="{{$template_root}}/images/an1{{if $tabname ne $tab[t].tabname}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_lognew&action={{$action}}&module={{$module}}&tabname={{$tab[t].tabname}}">{{$tab[t].title}}</a><img src="{{$template_root}}/images/an3{{if $tabname ne $tab[t].tabname}}3{{/if}}.jpg" align="absmiddle"/></li>
	{{/section}}
</ul>
</div></td></tr>
<body>
	

	
	  <tr>
		<td class="">
			<iframe id="frame_content" src='{{$url}}' width= "100%" scrolling="no" onload="setScroll();this.height=frame_content.document.body.scrollHeight;window.parent.document.getElementById('main').height = document.getElementById('frame_content').height;" frameborder="0" ></iframe>
		</td>
	  </tr>
	</table>
	<script type="text/javascript">
document.ondblclick= function(){
	window.parent.menuhide();
}
document.getElementById("frame_content").contentWindow.document.ondblclick= function(){
	window.parent.menuhide();
}
</script>
</body>
</html>



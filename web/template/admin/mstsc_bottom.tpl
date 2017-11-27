<script language="javascript">
function go(url,iid){
	var app_act = document.getElementById('app_act').options[document.getElementById('app_act').options.selectedIndex].value;
	var hid = document.getElementById('hide');
	document.getElementById(iid).href=url+'&app_act='+app_act;
	//alert(hid.src);
	{{if $logindebug}}
	window.open(document.getElementById(iid).href);
	{{/if}}
	return true;
}
{{if $member.default_control eq 0}}
	if(navigator.userAgent.indexOf("MSIE")>0) {
		document.getElementById('app_act').options.selectedIndex = 1;
	}
	{{elseif $member.default_control eq 1}}
		document.getElementById('app_act').options.selectedIndex = 0;
	{{elseif $member.default_control eq 2}}
		document.getElementById('app_act').options.selectedIndex = 1;
{{/if}}
</script>
<iframe id="hide" name="hide" height="0" frameborder="0" scrolling="no"></iframe>



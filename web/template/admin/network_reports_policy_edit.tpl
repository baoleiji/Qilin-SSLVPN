<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
   <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=network_reports_policy">报表策略</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=network_reports">报表输出</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
 <style>
.ul{list-style-type:none; margin:0;width:100%; }
.ul li{ width:80px; float:left;}
</style>
	  <tr  >
   <td align="right" ><a href="admin.php?controller=admin_reports&action=network_reports_policy&back=1"><img src="{{$template_root}}/images/back.png"  width="50" border=0 width="60" /></a></td>
  </tr>
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>

            <td align="center"><form name="f1" method=post OnSubmit='return checkall("secend")' action="admin.php?controller=admin_reports&action=network_reports_policy_save">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		报表策略<input type = text name="policyname" id="policyname" value="{{$policyinfo.policyname}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;网络设备
		<select name="device_ip" id="device_ip" onchange='changegroup();' >
		<option value="0">所有</option>
		{{section name=g loop=$networks}}
		<option value="{{$networks[g].device_ip}}" {{if $device_ip eq $networks[g].device_ip}}selected{{/if}}>{{$networks[g].device_ip}}</option>
		{{/section}}
		</select>
		</td>
		<td width="67%" colspan='2'>
	  </td>
	  </tr>
	  <td width="33%" align=right>
		<select  class="wbk"  style="width:400;height:400;"  name="first" size="30" id="first" multiple="multiple" ondblclick="moveRight()">
		{{section name=ra loop=$interfaces}}
		<option value="{{$interfaces[ra].id}}" title="{{$interfaces[ra].port_describe}}">{{$interfaces[ra].device_ip}}_{{$interfaces[ra].hostname}}_{{$interfaces[ra].port_describe}}</option>
		{{/section}}
		</select>
		</td>
		<td width="10%">
		<div class="select_move_2">
                <input type="button" value="添加-->" onclick="moveRight()"/><br />
                <input type="button" value="<--删除"  onclick="moveLeft()"/><br />
          </div>
         </td>
         <td>
		<select  class="wbk"   style="width:400;height:400;" size="30" id="secend" name="secend[]" multiple="multiple">
		{{section name=r loop=$sinterfaces}}
		<option value="{{$sinterfaces[r].id}}" title="{{$sinterfaces[r].port_describe}}">{{$sinterfaces[r].device_ip}}_{{$sinterfaces[r].hostname}}_{{$sinterfaces[r].port_describe}}</option>
		{{/section}}
   		</select>
	  </td>
	</tr>
	</table>
<br>
<input type="hidden" name="policyid" value="{{$policyinfo.id}}">
<input type="hidden" name="oldgname" value="{{$policyinfo.policyname}}">
<input type="submit"  value="保存" class="an_02">
</form>
	</td>
  </tr>
</table>

<script language="javascript">
var changed = false;
function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

function changeport() {
	if(document.getElementById("ssh").selected==true)  {
		f1.port.value = 22;
	}
	if(document.getElementById("telnet").selected==true)  {
		f1.port.value = 23;
	}
}

function changegroup(){
	var gid = document.getElementById('device_ip').options[document.getElementById('device_ip').options.selectedIndex].value;
	if(changed){
		if(confirm('确定要放弃更改?')){
			window.location='admin.php?controller=admin_reports&action=network_reports_policy_edit&device_ip='+gid+'&policyname={{$policyinfo.policyname}}&id={{$policyinfo.id}}';
		}
	}else{
		window.location='admin.php?controller=admin_reports&action=network_reports_policy_edit&device_ip='+gid+'&policyname={{$policyinfo.policyname}}&id={{$policyinfo.id}}';
	}
}


</script>
<script type="text/javascript" >

	
	/**选中的元素向右移动**/
 	function moveRight()
	{
		
			//得到第一个select对象
		var selectElement = document.getElementById("first");
		var optionElements = selectElement.getElementsByTagName("option");
		var len = optionElements.length;
		var selectElement2 = document.getElementById("secend");

		if(!(selectElement.selectedIndex==-1))   //如果没有选择元素，那么selectedIndex就为-1
		{
			
			//得到第二个select对象
			
	
				// 向右移动
				for(var i=0;i<len ;i++)
				{
					if(selectElement.selectedIndex>=0)
					selectElement2.appendChild(optionElements[selectElement.selectedIndex]);
				}
				changed = true;
		} else
		{
			alert("您还没有选择需要移动的元素！");
		}
	}
	

	
	//移动选中的元素到左边
	function moveLeft()
	{
		//首先得到第二个select对象
		var selectElement = document.getElementById("secend");
		
		var optionElement = selectElement.getElementsByTagName("option");
		var len = optionElement.length;
		var firstSelectElement = document.getElementById("first");
		
		
		//再次得到第一个元素
		if(!(selectElement.selectedIndex==-1))
		{
			
			for(i=0;i<len;i++)
			{
				if(selectElement.selectedIndex>=0)
					firstSelectElement.appendChild(optionElement[selectElement.selectedIndex]);//被选中的那个元素的索引
			}
			changed = true;
		}else
		{
			alert("您还没有选中要移动的项目!");
		}
	}
	
	function checkall(selectID){
		var obj = document.getElementById(selectID);
		var len = obj.options.length;
		for(var i=0; i<len; i++){
			obj.options[i].selected = true;
		}
		return true;
	}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



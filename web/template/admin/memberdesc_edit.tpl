<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/Calendarandtime.js"></script>
</head>

<body>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
</ul><span class="back_img"><A href="admin.php?controller=admin_member&action=memberdesc&uid={{$uid}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
          <tr>
            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_member&action=memberdesc_save&uid={{$uid}}&id={{$sip.id}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		动作
		</td>
		<td width="67%">
		<select name="action" >
		<option value="入职" {{if $sip.action eq '入职'}}selected{{/if}}>入职</option>
		<option value="转正" {{if $sip.action eq '转正'}}selected{{/if}}>转正</option>
		<option value="转岗" {{if $sip.action eq '转岗'}}selected{{/if}}>转岗</option>
		<option value="离职" {{if $sip.action eq '离职'}}selected{{/if}}>离职</option>
		<option value="其它" {{if $sip.action eq '其它'}}selected{{/if}}>其它</option>
		</section>
	  </td>
	</tr>
	<tr bgcolor="">
		<td width="33%" align=right>
		过去部门
		</td>
		<td width="67%">
		<select name="prideptid" >
		{{section name=pd loop=$workdept}}
		<option value="{{$workdept[pd].id}}" {{if $sip.prideptid eq $workdept[pd].id}}selected{{/if}}>{{$workdept[pd].title}}</option>
		{{/section}}
		</section>
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		现在部门
		</td>
		<td width="67%">
		<select name="curdeptid" >
		{{section name=cd loop=$workdept}}
		<option value="{{$workdept[cd].id}}" {{if $sip.curdeptid eq $workdept[cd].id}}selected{{/if}}>{{$workdept[cd].title}}</option>
		{{/section}}
		</section>
	  </td>
	</tr>
	<tr bgcolor="">
		<td width="33%" align=right>
		过去职位
		</td>
		<td width="67%">
		<select name="pripostid" >
		{{section name=pd loop=$workpost}}
		<option value="{{$workpost[pd].id}}" {{if $sip.pripostid eq $workpost[pd].id}}selected{{/if}}>{{$workpost[pd].title}}</option>
		{{/section}}
		</section>
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		现在职位
		</td>
		<td width="67%">
		<select name="curpostid" >
		{{section name=cd loop=$workpost}}
		<option value="{{$workpost[cd].id}}" {{if $sip.curpostid eq $workpost[cd].id}}selected{{/if}}>{{$workpost[cd].title}}</option>
		{{/section}}
		</section>
	  </td>
	</tr>
	<tr bgcolor="">
	<td width="33%" align=right valign="top">
		描述
		</td>
		<td width="67%">
		<textarea cols="37" rows="10"  name="desc">{{$sip.desc}}</textarea>
	  </td>
	</tr>	
	<tr bgcolor="f7f7f7"><td></td><td><input type=submit  value="{{$language.Save}}" class="an_02"></td></tr></table>

</form>
	</td>
  </tr>
</table>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



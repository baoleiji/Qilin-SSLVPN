{{include file="include/header.tpl"}}
<table border="0" cellpadding="0" cellpadding="0" bordercolor="#FFFFFF">
<tr>
<td bgcolor="#EEEEEE">
<table width="90%" align="center" cellpadding="0">
<tr class="resultsheader">
	<td colspan="3" align="center">
		<b>过滤列表</b>
	</td>
</tr>
<tr>
<tr>
	<td style="width:20%" align="center">
		<b>过滤类型</b>
	</td>
	<td align="center">
		<b>过滤内容</b>
	</td>
	<td align="center">
		<b>修改</b>
	</td>
</tr>
{{section name=t loop=$allfilter}}
<form action="admin.php?controller=admin_filter&action=save&type=edit" method="post">
<input type="hidden" value="{{$allfilter[t].fid}}" name="fid"/>
<tr >
	<td style="width:20%" align="right" bgcolor="#C0C0C0">
							<select name="ftype">
							<option value="host" {{if $allfilter[t].ftype == "host"}}selected{{/if}}>host</option>
							<option value="msg" {{if $allfilter[t].ftype == "msg"}}selected{{/if}}>msg</option>
							<option value="level" {{if $allfilter[t].ftype == "level"}}selected{{/if}}>level</option>
							<option value="facility" {{if $allfilter[t].ftype == "facility"}}selected{{/if}}>facility</option>
							</select>
	</td>
	<td bgcolor="#E0E0E0"><input type="text" name="fvalue" size="100" maxlength="255" value="{{$allfilter[t].fvalue}}"></td>
	<td bgcolor="#C0C0C0"><input name="submit" type="submit" value="保存修改" /></td>
</tr>
</form>
{{/section}}
</table>
</td>
</tr>
<tr>
<td bgcolor="#EEEEEE">
<form name="news_add" method="post" action="admin.php?controller=admin_filter&action=save&type=add">
<table width="90%" align="center">
<tr class="resultsheader">
	<td colspan="2" align="center">
		<b>添加过滤信息</b>
	</td>
					<tr>
						<td style="width:40%" align="right">类型：</td>
						<td>
							<select name="ftype">
							<option value="host">host</option>
							<option value="msg">msg</option>
							<option value="level">level</option>
							<option value="facility">facility</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">过滤内容：</td>
						<td><input type="text" name="fvalue" size="50" maxlength="255"></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<input name="submit" type="submit" value="添加过滤信息" />
						</td>
					</tr>
</table>
</form>

</td></tr>
</table>
{{include file="include/footer.tpl"}}

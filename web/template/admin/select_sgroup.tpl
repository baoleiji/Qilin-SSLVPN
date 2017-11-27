{{if !$select_group_id}}{{assign var=select_group_id value='groupid'}}{{/if}}
{{if !$group_tip}}{{assign var=group_tip value='资源组'}}{{/if}}
{{if !$_config.TREEMODE}}
{{if $_config.LDAP}}
<span>
<select style="width:120px;" class="wbk" style="width:150px;"  name="{{$select_group_id}}1" id="{{$select_group_id}}1" onchange="changelevels(this.value,0, 2, '{{$select_group_id}}',{{$logined_user_level}},'{{$changegroup|replace:'\'':'\\\''}}');{{$changegroup}}">
{{if $smarty.session.ADMIN_LEVEL ne 3 and $smarty.session.ADMIN_LEVEL ne 21 and $smarty.session.ADMIN_LEVEL ne 101}}
<OPTION VALUE="0">请选择</option>
{{/if}}
{{section name=g loop=$allsgroup}}
	{{if $smarty.session.ADMIN_MUSERGROUP eq $allsgroup[g].id}}
	{{if !$allsgroup[g].ldapid }}
	<OPTION VALUE="{{$allsgroup[g].id}}" {{if $allsgroup[g].id == ${{"`$select_group_id`1"}}}}selected{{/if}}>{{$allsgroup[g].groupname}}</option>
	{{/if}}
	{{else}}
	{{if !$allsgroup[g].ldapid }}
	<OPTION VALUE="{{$allsgroup[g].id}}" {{if $allsgroup[g].id == ${{"`$select_group_id`1"}}}}selected{{/if}}>{{$allsgroup[g].groupname}}</option>
	{{/if}}
	{{/if}}
{{/section}}
</select>
</span>
{{/if}}
{{else}}
<link href="{{$template_root}}/cssjs/dtree1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/dtree.js"></script>
<style>
.dtreecob {	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;	font-size: 12px;	color: #666;	white-space: nowrap;	display:none;	border:1px solid #6699cc;		position: absolute; 	z-index: 9999;	background-color:white;	width:378px;}
.dBottom{background-color:#F0F0F0; margin-bottom:0px; text-align:right; height:23px;line-height:23px; }
.dBottom a{	margin-right:5px;color:black;text-decoration: none;	}
</style>
   {{if $inputtype eq 'text'}}{{$group_tip}}：{{/if}}<input type="hidden" id="{{$select_group_id}}1" name="{{$select_group_id}}1" value="0" />
 <input {{if $inputtype eq 'text'}}type="text" class="wbk input_shorttext" {{else}}type="button" value="{{$inputtype}}"{{/if}} {{if $inputwidth}}style="width:{{$inputwidth}}px"{{/if}} id="{{$select_group_id}}1pop" name=""  onClick='showTree(this,"{{$select_group_id}}1")' readonly="readonly" />	
<div id="{{$select_group_id}}1combdtree" class="dtreecob">
		<div class="dtree" style="overflow: auto; width: 100%;">
		<p><a href="javascript: {{$select_group_id}}d.openAll();">全部打开</a> | <a href="javascript: {{$select_group_id}}d.closeAll();">全部折叠</a> | <a href="javascript:{{if $addgroup}}checkS();{{/if}}hiddenDTree('{{$select_group_id}}1');">取消</a>{{if $multipleselect}} | <a href="javascript:{{if $showcheck}}setSrcValue('','','{{$select_group_id}}1',{{if $inputtype eq "text"}}1{{else}}0{{/if}},1,'{{$departmanagersgroupids}}'){{/if}};{{if $addgroup}}selectgroup(0,''){{/if}};hiddenDTree('{{$select_group_id}}1');">保存</a>{{/if}}</p>
		<script type="text/javascript">
<!--
		{{$select_group_id}}d = new dTree('{{$select_group_id}}d');
		{{$select_group_id}}d.add(0,-1,'资源组','javascript:setSrcValue(\'\',0,\'{{$select_group_id}}1\',{{if $inputtype eq "text"}}1{{else}}0{{/if}});hiddenDTree(\'{{$select_group_id}}1\');');
		{{section name=g loop=$allsgroup}}
		{{$select_group_id}}d.add({{$allsgroup[g].id}},{{$allsgroup[g].ldapid}},'{{if $showcheck}}<input type="checkbox"  name="{{$select_group_id}}1_group[]" id="{{$select_group_id}}1_group_{{$allsgroup[g].id}}" gid="{{$allsgroup[g].id}}" onclick="{{if $addgroup}}checkedChild(this.checked, \'{{$select_group_id}}1\', \'{{$allsgroup[g].child}}\')"{{/if}} gname="{{$allsgroup[g].groupname}}" value="{{$allsgroup[g].id}}_{{$allsgroup[g].groupname}}">{{/if}}{{$allsgroup[g].groupname}}','javascript:setSrcValue(\'{{$allsgroup[g].groupname}}\',{{$allsgroup[g].id}},\'{{$select_group_id}}1\',{{if $inputtype eq "text"}}1{{else}}0{{/if}},{{if $multipleselect}}1{{else}}0{{/if}},\'{{$departmanagersgroupids}}\');{{if $addgroup}}selectgroup({{$allsgroup[g].id}},\'{{$allsgroup[g].groupname}}\'){{/if}};{{$changegroup}}');
		{{/section}}
		document.write({{$select_group_id}}d);
		{{$select_group_id}}d.openTo({{$select_group_id}}d.nodeN({{${{"last`$select_group_id`"}}.id}}),true);
		{{$select_group_id}}d.s({{$select_group_id}}d.nodeN({{${{"last`$select_group_id`"}}.id}}));
// -->
</script></div>
		<div class="dBottom"><a href="javascript:hiddenDTree('{{$select_group_id}}1');">关闭</a></div>
		</div>
{{/if}}
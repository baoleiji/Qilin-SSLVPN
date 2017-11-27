{{if !$select_group_id}}{{assign var=select_group_id value='groupid'}}{{/if}}
{{if !$group_tip}}{{assign var=group_tip value='资源组'}}{{/if}}

<style>
.dtreecob {	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;	font-size: 12px;	color: #666;	white-space: nowrap;	display:none;	border:1px solid #6699cc;		position: absolute; 	z-index: 9999;	background-color:white;	width:378px;}
.dBottom{background-color:#F0F0F0; margin-bottom:0px; text-align:right; height:23px;line-height:23px; }
.dBottom a{	margin-right:5px;color:black;text-decoration: none;	}
</style>
   {{if !$inputtype or $inputtype eq 'text'}}{{$group_tip}}：{{/if}}<input type="hidden" id="{{$select_group_id}}dh" name="{{$select_group_id}}" value="0" />
 <input type="{{if !$inputtype or $inputtype eq 'text'}}text{{else}}button{{/if}}" class="wbk input_shorttext"  value="{{if $inputtype and $inputtype ne 'text'}}{{$inputtype}}{{/if}}" style="width:{{if $popsize}}{{$popsize}}{{elseif $checkbox}}500{{else}}150{{/if}}px" id="{{$select_group_id}}dpop" name=""  onClick='showTree(this,"{{$select_group_id}}d"{{if $direction eq "up"}},"up"{{/if}})' readonly="readonly" />	

<div id="{{$select_group_id}}dcombdtree" class="dtreecob">
		<p><a href="javascript: {{$select_group_id}}d.openAll();">全部打开</a> | <a href="javascript: {{$select_group_id}}d.closeAll();">全部折叠</a> | <a href="javascript:{{if $addgroup}}checkS();{{/if}}hiddenDTree('{{$select_group_id}}d');">取消</a>{{if $multipleselect}} | <a href="javascript:{{if  $checkbox}}setSrcValue('','','{{$select_group_id}}d',{{if $addgroup}}0{{else}}1{{/if}},{{if $checkbox}}1{{else}}0{{/if}},'{{$departmanagersgroupids}}'){{/if}};{{if $addgroup}}selectgroup(0,''){{/if}};hiddenDTree('{{$select_group_id}}d');">保存</a>{{/if}}</p>
		<div class="dtree" id="{{$select_group_id}}dtree" style="overflow: auto; width: 100%;">
		<script type="text/javascript">
<!--
departmanagersgroupids = '{{$departmanagersgroupids}}';
		{{$select_group_id}}d = new dTree('{{$select_group_id}}d','{{$select_group_id}}dtree');
		{{if $checkbox}}
		{{$select_group_id}}d.config.checkbox=true;
		{{/if}}
		{{$select_group_id}}d.config.setop={{if $addgroup}}false{{else}}true{{/if}};
		{{$select_group_id}}d.add(0,-1,0,1, '资源组','javascript:setSrcValue(\'\',0,\'{{$select_group_id}}1\',{{if $inputtype eq "text"}}1{{else}}0{{/if}});hiddenDTree(\'{{$select_group_id}}\');');
		{{assign var=allgroups value=${{"`$pre`allsgroup"}}}}
		{{section name=g loop=$allgroups}}
			{{$select_group_id}}d.add({{$allgroups[g].id}},{{$allgroups[g].ldapid}},'',{{$allgroups[g].count}},'{{if $checkbox}}<input type="checkbox" name="{{$select_group_id}}d_group[]" id="group_{{$allgroups[g].id}}" value="{{$allgroups[g].id}}_{{$allgroups[g].groupname}}" gid="{{$allgroups[g].id}}" gname="{{$allgroups[g].groupname}}"  onclick="checkgroup(this.checked,{{$allgroups[g].id}},{{$select_group_id}}d);">{{/if}}{{$allgroups[g].groupname}}','javascript:setSrcValue(\'{{$allgroups[g].groupname}}\',{{$allgroups[g].id}},\'{{$select_group_id}}d\',{{if $addgroup}}0{{else}}1{{/if}},{{if $checkbox}}1{{else}}0{{/if}},\'{{$departmanagersgroupids}}\');','{{$allgroups[g].groupname}}',null,{{$select_group_id}}d.icon.folder);
		{{/section}}
		{{$select_group_id}}d.show();
		//document.write({{$select_group_id}}d);
// -->
</script></div>
		<div class="dBottom"><a href="javascript:hiddenDTree('{{$select_group_id}}d');">关闭</a></div>
		</div>
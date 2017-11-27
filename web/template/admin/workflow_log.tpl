<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>
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
	

	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
                <TBODY>
                  <TR>
			
                    <th class="list_bg" width="20%"><a href="#" >审批人</a></TD>
                    <th class="list_bg"  width="30%"><a href="#" >审批时间</a></TD>
                    <th class="list_bg"  width="50%"><a href="#" >备注</a></TD>
                  </TR>

            </tr>
			{{section name=t loop=$logs}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				 <td> {{$logs[t].username}}</td>
				 <td> {{if !$logs[t].apply_status}}未审批{{else}}{{$logs[t].apply_date}}({{if $logs[t].apply_status eq 1}}同意{{elseif $logs[t].apply_status eq 2}}驳回{{/if}}){{/if}}</td>
				 <td> {{$logs[t].desc}}</td>
			</tr>
			{{/section}}
	        	           
		</TBODY>
              </TABLE>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



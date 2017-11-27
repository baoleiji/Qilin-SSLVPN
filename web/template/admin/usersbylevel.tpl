<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TBODY>
  <TR>
    <TD>
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
        <TBODY>
        <TR>
          <TD align="center">
          <form name="f1" method=post enctype="multipart/form-data" action="admin.php?controller=admin_pro&action=docommit" target="hide">
            <TABLE width="90%" bgcolor="#ffffff" border="0" cellspacing="1" 
            cellpadding="5" valign="top" class="BBtable">
              <TBODY>
			{{section name=m loop=$members}}
              <TR {{if $smarty.section.m.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                <TD align="left" width="35%">
				{{if $members[m].level == 0}}运维{{$language.User}}{{elseif $members[m].level == 1}}{{$language.Administrator}}{{elseif $members[m].level == 3}}部门{{$language.Administrator}}{{elseif $members[m].level == 4}}配置{{$language.Administrator}}{{elseif $members[m].level == 10}}{{$language.Password}}{{$language.Administrator}}{{elseif $members[m].level == 21}}部门审计员{{elseif $members[m].level == 101}}部门密码员{{else}}{{$language.auditadministrator}}{{/if}}
				</TD>
				<td align="left">{{$members[m].count}}</td>
				</TR>
            {{/section}}
			</TBODY></TABLE>
           <input type="hidden" name="url" value="{{$url}}" />
	<input type="hidden" name="id" value="{{$devicesid}}" />
      </FORM></TD></TR></TBODY></TABLE></TR></TBODY></TABLE>
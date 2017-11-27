{{if $memberscount eq 0}}
<input type="text" name="username" id="username"  style="width: {{if !$logintype.ldapauth and !$logintype.radiusauth and !$logintype.adauth}}240{{else}}110{{/if}}px;">
{{else}}
<select name='username' id="username"  style="width: {{if !$logintype.ldapauth and !$logintype.radiusauth and !$logintype.adauth}}240{{else}}110{{/if}}px;">
{{section name=m loop=$members}}
<option value='{{$members[m].username}}' {{if $smarty.cookies.username eq $members[m].username}}selected{{/if}} >{{$members[m].username}}</option>
{{/section}}
</select>
<select name='username' id="realname" disabled style="display:none">
{{section name=n loop=$members}}
<option value='{{$members[n].realname}}' {{if $smarty.cookies.username eq $members[m].realname}}selected{{/if}}>{{$members[n].realname}}</option>
{{/section}}
</select>
{{/if}}

{{if !$logintype.ldapauth and !$logintype.radiusauth and !$logintype.adauth}}
<input type="hidden" name="authtype" value="localauth">
{{else}}
&nbsp;&nbsp;<select name='authtype' style="width:120px;">
<option value='localauth' {{if $authtype eq 'localauth'}}selected{{/if}}>本地认证</option>
{{if $logintype.radiusauth}}
<option value='radiusauth' {{if $authtype eq 'radiusauth'}}selected{{/if}}>RADIUS认证</option>
{{/if}}
{{if $logintype.ldapauth}}
{{section name=l loop=$ldaps}}
<option value='ldapauth_{{$ldaps[l].address}}' {{if $authtype eq 'ldapauth'}}selected{{/if}}>LDAP {{$ldaps[l].domain}}</option>
{{/section}}
{{/if}}
{{if $logintype.adauth}}
{{section name=a loop=$ads}}
<option value='adauth_{{$ads[a].address}}' {{if $authtype eq 'adauth'}}selected{{/if}}>AD {{$ads[a].domain}}</option>
{{/section}}
{{/if}}
{{/if}}
</select>
<input type="hidden" name="memberscount" id="memberscountid" value="{{$memberscount}}" />
<input type="hidden" name="cacn" id="cacn" value="{{$cacn}}" />
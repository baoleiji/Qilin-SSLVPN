<div class="menu">
<ul>
	{{section name=t loop=$page_nav_tabs}}
	<li class="{{if $page_nav_tabs_selected ne $page_nav_tabs[t].tabname}}me_b{{else}}me_a{{/if}}"><img src="{{$template_root}}/images/an1{{if $page_nav_tabs_selected ne $page_nav_tabs[t].tabname}}1{{/if}}.jpg" align="absmiddle"/><a href="{{$page_nav_tabs[t].url}}">{{$page_nav_tabs[t].title}}</a><img src="{{$template_root}}/images/an3{{if $page_nav_tabs_selected ne $page_nav_tabs[t].tabname}}3{{/if}}.jpg" align="absmiddle"/></li>
	{{/section}}
</ul>
</div>
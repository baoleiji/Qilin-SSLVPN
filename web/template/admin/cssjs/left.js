// JavaScript Document
//===============the code below used only in tree-menu and split button=================---(changling)
function init_showMenu()
{
	len = document.all.boughTab.length;
	if(typeof(len) == "undefined")	
	{
		document.all.boughTab.style.display = "none";	
	}
	for(var i=0;i<len;i++)
	{
		document.all.boughTab[i].style.display = "none";
	}
	
	if ( document.all.boughTabSub != null && document.all.boughTabSub != undefined ) {
	    lenSub = document.all.boughTabSub.length;
		if(typeof(lenSub) == "undefined")	
		{
			document.all.boughTabSub.style.display = "none";	
		}
		for(var i=0;i<lenSub;i++)
		{
			document.all.boughTabSub[i].style.display = "none";
		}
	}
	//增加 
	if ( document.all.boughTabSubSub != null && document.all.boughTabSubSub != undefined ) {
	    lenSubSub = document.all.boughTabSubSub.length;
		if(typeof(lenSubSub) == "undefined")	
		{
			document.all.boughTabSubSub.style.display = "none";	
		}
		for(var i=0;i<lenSubSub;i++)
		{
			document.all.boughTabSubSub[i].style.display = "none";
		}
	}	
}
function keepHightlight(e)
{
	if(typeof(e) == "object")
	{
		if(typeof(document.all.leaf.length)=="undefined")
		{
			document.all.leaf.className ="";
			return true;
		}
		for(var i=0;i<document.all.leaf.length;i++)//????????
		{				
			if(document.all.leaf[i].className == "hightlight")
			{
				document.all.leaf[i].className ="";
			}
		}
		eventObj = e.srcElement;
		if(eventObj.tagName.toLowerCase() == "a")
		eventObj.className = "hightlight";
		return true;
	}
	else
	{
		return false;
	}
}
/**
*菜单的收缩或展开控制函数
*点击对象的id = bough
*/
function collapseORexpandMenu()
{	
	var len = document.all.bough.length;
	var flag = -1;
	if(typeof(len) == "undefined")
	{
		if(document.all.bough.style.backgroundImage == 'url(images/q.gif)')
		{
			flag = 1;	
			document.all.boughTab.style.display = 'none';
			document.all.bough.style.backgroundImage = 'url(images/j.gif)';
			return true;	
		}
		else
		{
			flag = 1;						
			document.all.boughTab.style.display = '';
			document.all.bough.style.backgroundImage = 'url(images/q.gif)';
			return true;				
		}	
	}
	for(var i=0;i<len;i++)
	{
		if(window.event.srcElement == bough[i])
		{
			if(document.all.bough[i].style.backgroundImage == 'url(images/q.gif)')
			{
				flag = 1;	
				document.all.boughTab[i].style.display = 'none';
				document.all.bough[i].style.backgroundImage = 'url(images/j.gif)';
				return true;	
			}
			else
			{
				for(var j=0;j<len;j++)
				{	
					document.all.boughTab[j].style.display = 'none';
					document.all.bough[j].style.backgroundImage = 'url(images/j.gif)';
				}
				flag = 1;						
				document.all.boughTab[i].style.display = '';
				document.all.bough[i].style.backgroundImage = 'url(images/q.gif)';
				return true;				
			}					
		}		
	}
	if(!flag)
		alert("原产地证项目的左边菜单的JS出错,联系常玲解决!");
}


/**
*菜单的收缩或展开控制函数
*点击对象的id = boughSub
*/
function collapseORexpandMenuSub()
{	
	var len = document.all.boughSub.length;
	var flag = -1;
	if(typeof(len) == "undefined")
	{
		if(document.all.boughSub.style.backgroundImage == 'url(images/q.gif)')
		{
			flag = 1;	
			document.all.boughTabSub.style.display = 'none';
			document.all.boughSub.style.backgroundImage = 'url(images/j.gif)';
			return true;	
		}
		else
		{
			flag = 1;						
			document.all.boughTabSub.style.display = '';
			document.all.boughSub.style.backgroundImage = 'url(images/q.gif)';
			return true;				
		}	
	}
	for(var i=0;i<len;i++)
	{

		if(window.event.srcElement == boughSub[i])
		{

			if(document.all.boughSub[i].style.backgroundImage == 'url(images/q.gif)')
			{
				
				flag = 1;	
				document.all.boughTabSub[i].style.display = 'none';
				document.all.boughSub[i].style.backgroundImage = 'url(images/j.gif)';
				return true;	
			}
			else
			{
				
				for(var j=0;j<len;j++)
				{	
					
					document.all.boughTabSub[j].style.display = 'none';
					document.all.boughSub[j].style.backgroundImage = 'url(images/j.gif)';
				}
				flag = 1;						
				document.all.boughTabSub[i].style.display = '';
				document.all.boughSub[i].style.backgroundImage = 'url(images/q.gif)';
				return true;				
			}					
		}		
	}
	if(!flag)
		alert("原产地证项目的左边菜单的JS出错,联系常玲解决!");
}

/**
*菜单的收缩或展开控制函数
*点击对象的id = boughSubSub
*/
function collapseORexpandMenuSubSub()
{	
	var len = document.all.boughSubSub.length;
	var flag = -1;
	if(typeof(len) == "undefined")
	{
		if(document.all.boughSubSub.style.backgroundImage == 'url(images/q.gif)')
		{
			flag = 1;	
			document.all.boughTabSubSub.style.display = 'none';
			document.all.boughSubSub.style.backgroundImage = 'url(images/j.gif)';
			return true;	
		}
		else
		{
			flag = 1;						
			document.all.boughTabSubSub.style.display = '';
			document.all.boughSubSub.style.backgroundImage = 'url(images/q.gif)';
			return true;				
		}	
	}
	for(var i=0;i<len;i++)
	{

		if(window.event.srcElement == boughSubSub[i])
		{

			if(document.all.boughSubSub[i].style.backgroundImage == 'url(images/q.gif)')
			{
				
				flag = 1;	
				document.all.boughTabSubSub[i].style.display = 'none';
				document.all.boughSubSub[i].style.backgroundImage = 'url(images/j.gif)';
				return true;	
			}
			else
			{
				
				for(var j=0;j<len;j++)
				{	
					
					document.all.boughTabSubSub[j].style.display = 'none';
					document.all.boughSubSub[j].style.backgroundImage = 'url(images/j.gif)';
				}
				flag = 1;						
				document.all.boughTabSubSub[i].style.display = '';
				document.all.boughSubSub[i].style.backgroundImage = 'url(images/q.gif)';
				return true;				
			}					
		}		
	}
	if(!flag)
		alert("原产地证项目的左边菜单的JS出错,联系常玲解决!");
}
/*
 * TO draw pie.
 * @param url the *.swf path
 * @param id  the swf id on this page
 * @param width 
 * @param height
 * @param xml the full xml string
 */
function addFlash(url, id, width, height, xml) {
	document.write("<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" "+
		" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" "+
		" width=\""+width+"\" height=\""+height+"\" id=\""+id+"\" >"+
		"<param name='movie' value=\""+url+"\" />"+
		"<param name='quality' value='high' />"+
		"<param name='wmode' value='transparent' />"+
		"<param name='FlashVars' value=\"&registerwithjs=1&dataxml="+xml+"\"/>"+
		"</object>");
	}

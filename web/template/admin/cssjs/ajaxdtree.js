/*--------------------------------------------------
	dTree 2.05 | www.destroydrop.com/javascript/tree/

	Rewrited by xiaosilent@gmail.com , xiangdingdang.com

	Last updated at 2007-4-28 16:32:05

	
---------------------------------------------------*/

// Node object
function Node3(id, pid, name, url, title, target, icon, iconOpen, open) {
	this.id = id;
	this.pid = pid;
	this.name = name;
	this.url = url;
	this.title = title;
	this.target = target;
	this.icon = icon;
	this.iconOpen = iconOpen;
	this._io = open || false;
	this._is = false;
	this._ls = false;
	this._hc = false;
	this._ai = 0;
	this._p;
};

/*** dTree  ** Edited by xiaosilent.* * objName: name of dTree object.* targetID: the id of your container,which you used to display the tree* type: which kind of category are you doing with ? It must be one of these  "goods" , "vendor" and "consumer" ,this is just for xiaosilent's Sales Management System.**/
function adTree(objName,targetID,type) {
	
	this.config = {
		
		target				: null,
		
		// xiaosilent changed it to be false.
		folderLinks			: false,
		useSelection		: true,
		useCookies			: true,
		useLines				: true,
		useIcons				: true,
		useStatusText		: false,
		closeSameLevel	: false,
		inOrder				: false
	}
			// xiaosilent changed this to his own path.
	this.icon = {
			
		root				: 'template/admin/cssjs/img/base.gif',
		folder			: 'template/admin/cssjs/img/group.gif',
		folderOpen	: 'template/admin/cssjs/img/groupopen.png',
		node				: 'template/admin/cssjs/img/user.gif',
		empty				: 'template/admin/cssjs/img/empty.gif',
		line				: 'template/admin/cssjs/img/line.gif',
		join				: 'template/admin/cssjs/img/join.gif',
		joinBottom	: 'template/admin/cssjs/img/joinbottom.gif',
		plus				: 'template/admin/cssjs/img/plus.gif',
		plusBottom	: 'template/admin/cssjs/img/plusbottom.gif',
		minus				: 'template/admin/cssjs/img/minus.gif',
		minusBottom	: 'template/admin/cssjs/img/minusbottom.gif',
		nlPlus			: 'template/admin/cssjs/img/nolines_plus.gif',
		nlMinus			: 'template/admin/cssjs/img/nolines_minus.gif'
	};
	
	this.obj = objName;
	this.aNodes = [];
	
	// add by xiaosilent. 
	this.aNodesData=[];	//This array save the original data all the time.
	this.targetID=targetID||'dtree';	// Tree will be displayed in this container.	this.type=type;	// Saves the type of tree  goods/vendor/consumer?
	
	this.aIndent = [];
	this.root = new Node3(-1);
	this.selectedNode = null;
	this.selectedFound = false;
	this.completed = false;
};
// Adds a new node to the node array
adTree.prototype.add = function(id, pid, name, url, title, target, icon, iconOpen, open) {
	
	// Add by xiaosilent.
	this.completed = false;
	
	this.aNodesData[this.aNodesData.length] = new Node3(id, pid, name, url, title, target, icon, iconOpen, open);
};

// Open/close all nodes
adTree.prototype.openAll = function() {
	
	this.oAll(true);
};
	
adTree.prototype.closeAll = function() {	
	this.oAll(false);
};


// Add by xiaosilent .
// get child nodes from web server via AJAX automatically 
// pid : parentID.
adTree.prototype.getChildren = function(pid, gname, ouname, cname, dn){
	var url ="admin.php?controller=admin_config&action=adusersbygroup&groupname="+escape(gname)+"&cname="+escape(cname)+"&ouname="+escape(ouname)+"&dn="+escape(dn)+"&pid="+pid;
	$.get(url, {"1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//var aNodes = $.csv.toArrays(data);
		var aNodes = eval("("+data+")");
		var i=0;
		for(;i<aNodes['cns'].length;i++){
			var name=aNodes['cns'][i]['name'];
			var count=aNodes['cns'][i]['usercount'];
			if(count<=0) continue;
			tree.add(pid+'_'+i, pid, '<input type="checkbox" id="u_'+aNodes['pid']+'_'+i+'" onclick="checkgroupa(this.checked,\''+aNodes['pid']+'_'+i+'\')" name="cns[]" value="'+name+'" >'+name+'('+count+')', "javascript:"+tree.obj+".getChildren(\'"+aNodes['pid']+'_'+i+"\','','',\'"+name+"\',\'"+aNodes['dn']+"\')", name,'',tree.icon.folder);
		}
		for(;i<aNodes['cns'].length+aNodes['ous'].length;i++){
			var name=aNodes['ous'][i-aNodes['cns'].length]['name'];
			var count=aNodes['ous'][i-aNodes['cns'].length]['usercount'];
			if(count<=0) continue;
			tree.add(pid+'_'+i, pid, '<input type="checkbox" id="u_'+aNodes['pid']+'_'+i+'" onclick="checkgroupa(this.checked,\''+aNodes['pid']+'_'+i+'\')" name="ous[]" value="'+name+'" >'+name+'('+count+')', "javascript:"+tree.obj+".getChildren(\'"+aNodes['pid']+'_'+i+"\','',\'"+name+"\','',\'"+aNodes['dn']+"\')", name,'',tree.icon.folder);
			// set different icon for a node, if it has a child set its icon to be a folder image , else default , set to be a file image. And set different link address.
			/*if(childCount>0){
				tree.add(pid+''+i, pid, name, "javascript:"+tree.obj+".getChildren("+id+")", name,'',tree.icon.folder);					
			}else{
				tree.add(pid+''+i, pid, '<input type="checkbox" id="u_'+pid+'_'+i+'" name="username[]" value="'+name+'" >'+name, "#", name);					
			}*/
		}
		for(;i<aNodes['cns'].length+aNodes['ous'].length+aNodes['groups'].length;i++){
			var name=aNodes['groups'][i-aNodes['ous'].length-aNodes['cns'].length]['groupname'];
			var count=aNodes['groups'][i-aNodes['ous'].length-aNodes['cns'].length]['usercount'];
			if(count<=0) continue;
			tree.add(pid+'_'+i, pid, '<input type="checkbox" id="u_'+aNodes['pid']+'_'+i+'" onclick="checkgroupa(this.checked,\''+aNodes['pid']+'_'+i+'\')" name="groups[]" onclick="ddev.o('+pid+''+i+');" value="'+name+'" >'+name+'('+count+')', "javascript:"+tree.obj+".getChildren(\'"+aNodes['pid']+'_'+i+"\',\'"+name+"\','','',\'"+aNodes['dn']+"\')", name,'',tree.icon.folder);
			
		}
		for(;i<aNodes['cns'].length+aNodes['ous'].length+aNodes['groups'].length+aNodes['users'].length;i++){
			var name=aNodes['users'][i-aNodes['ous'].length-aNodes['groups'].length-aNodes['cns'].length]['username'];
			var s = name.indexOf('|');
			var dn="";
			if(s>=0){
				dn = name.substring(s+1);
				name = name.substring(0,s);
			}
			tree.add(pid+''+i, pid, '<input type="checkbox" id="u_'+aNodes['pid']+'_'+i+'" name="username[]" value="'+name+((s>=0) ? '|'+dn : '')+'" >'+(aNodes['users'][i-aNodes['ous'].length-aNodes['groups'].length-aNodes['cns'].length]['exists']==1 ? '<font style="color:red">' : '')+name+(aNodes['users'][i-aNodes['ous'].length-aNodes['groups'].length-aNodes['cns'].length]['exists']==1 ? '</font>' : ''), "#", name,'',tree.icon.node);
			
		}
		tree.show();
		tree.openTo(pid);
	});
	var tree=this;
}

adTree.prototype.showCategory = function(){
}

// Add by xiaosilent.
// Call to show the tree .
adTree.prototype.show = function(){
	// Renew the two array to save original data.
	this.aNodes=new Array();
	this.aIndent=new Array();

	// Dump original data to aNode array.
	for(var i=0 ; i<this.aNodesData.length ; i++){
		
		var oneNode=this.aNodesData[i];

		this.aNodes[i]=new Node3(oneNode.id,oneNode.pid,oneNode.name,oneNode.url,oneNode.title,oneNode.target,oneNode.icon,oneNode.iconOpen,oneNode.open);
	}
	
	this.rewriteHTML();
}

// Outputs the tree to the page , callled by show()
// Changed by xiaosilent.
adTree.prototype.rewriteHTML = function() {
	
	var str = '';
	
	// Added by xiaosilent. 
	var targetDIV;
	targetDIV=document.getElementById(this.targetID);
	
	if(!targetDIV){
		
		alert('adTree can\'t find your specified container to show your tree.\n\n Please check your code!');

		return;
	}
	
	if (this.config.useCookies) this.selectedNode = this.getSelected();
	
	str += this.addNode(this.root);
		

	// Disabled by xiaosilent.
	//	str += '</div>';
	if (!this.selectedFound) this.selectedNode = null;
	this.completed = true;
	
	// Disabled and added by xiaosilent.
	//return str;
	targetDIV.innerHTML=str;
	
};

// Creates the tree structure
adTree.prototype.addNode = function(pNode) {
	
	var str = '';
	var n=0;
	if (this.config.inOrder) n = pNode._ai;
	for (n; n<this.aNodes.length; n++) {
		if (this.aNodes[n].pid == pNode.id) {
			var cn = this.aNodes[n];
			cn._p = pNode;
			cn._ai = n;
			this.setCS(cn);
			if (!cn.target && this.config.target) cn.target = this.config.target;
			if (cn._hc && !cn._io && this.config.useCookies) cn._io = this.isOpen(cn.id);
			if (!this.config.folderLinks && cn._hc) cn.url = null;
			if (this.config.useSelection && cn.id == this.selectedNode && !this.selectedFound) {
					cn._is = true;
					this.selectedNode = n;
					this.selectedFound = true;
			}
			str += this.node(cn, n);
			if (cn._ls) break;
		}
	}
	return str;
};


// Creates the node icon, url and text
adTree.prototype.node = function(node, nodeId) {
	
	var str = '<div class="dTreeNode">' + this.indent(node, nodeId);
	if (this.config.useIcons) {
		if (!node.icon) node.icon = (this.root.id == node.pid) ? this.icon.root : ((node._hc) ? this.icon.folder : this.icon.node);
		if (!node.iconOpen) node.iconOpen = (node._hc) ? this.icon.folderOpen : this.icon.node;
		if (this.root.id == node.pid) {
			node.icon = this.icon.root;
			node.iconOpen = this.icon.root;
		}
		str += '<img id="i' + this.obj + nodeId + '" src="' + ((node._io) ? node.iconOpen : node.icon) + '" alt="" />';
	}
	if (node.url) {
		str += '<a id="s' + this.obj + nodeId + '" class="' + ((this.config.useSelection) ? ((node._is ? 'nodeSel' : 'node')) : 'node') + '" href="' + node.url + '"';
		if (node.title) str += ' title="' + node.title + '"';
		if (node.target) str += ' target="' + node.target + '"';
		if (this.config.useStatusText) str += ' onmouseover="window.status=\'' + node.name + '\';return true;" onmouseout="window.status=\'\';return true;" ';
		if (this.config.useSelection && ((node._hc && this.config.folderLinks) || !node._hc))
			str += ' onclick="javascript: ' + this.obj + '.s(' + nodeId + ');"';
		str += '>';
	}
	else if ((!this.config.folderLinks || !node.url) && node._hc && node.pid != this.root.id)
		str += '<a href="javascript: ' + this.obj + '.o(' + nodeId + ');" class="node">';
	str += node.name;
	if (node.url || ((!this.config.folderLinks || !node.url) && node._hc)) str += '</a>';
	str += '</div>';
	if (node._hc) {
		str += '<div id="d' + this.obj + nodeId + '" class="clip" style="display:' + ((this.root.id == node.pid || node._io) ? 'block' : 'none') + ';">';
		str += this.addNode(node);
		str += '</div>';
	}
	this.aIndent.pop();
	return str;
};


// Adds the empty and line icons
adTree.prototype.indent = function(node, nodeId) {
	
	var str = '';
	if (this.root.id != node.pid) {
		for (var n=0; n<this.aIndent.length; n++)
			str += '<img src="' + ( (this.aIndent[n] == 1 && this.config.useLines) ? this.icon.line : this.icon.empty ) + '" alt="" />';
		(node._ls) ? this.aIndent.push(0) : this.aIndent.push(1);
		if (node._hc) {
			str += '<a href="javascript: ' + this.obj + '.o(' + nodeId + ');"><img id="j' + this.obj + nodeId + '" src="';
			if (!this.config.useLines) str += (node._io) ? this.icon.nlMinus : this.icon.nlPlus;
			else str += ( (node._io) ? ((node._ls && this.config.useLines) ? this.icon.minusBottom : this.icon.minus) : ((node._ls && this.config.useLines) ? this.icon.plusBottom : this.icon.plus ) );
			str += '" alt="" /></a>';
		} else str += '<img src="' + ( (this.config.useLines) ? ((node._ls) ? this.icon.joinBottom : this.icon.join ) : this.icon.empty) + '" alt="" />';
	}
	return str;
};


// Checks if a node has any children and if it is the last sibling
adTree.prototype.setCS = function(node) {

	var lastId;

	for (var n=0; n<this.aNodes.length; n++) {
	
		if (this.aNodes[n].pid == node.id) node._hc = true;
		if (this.aNodes[n].pid == node.pid) lastId = this.aNodes[n].id;
	}

	if (lastId==node.id) node._ls = true;
};


// Returns the selected node
adTree.prototype.getSelected = function() {
	
	var sn = this.getCookie('cs' + this.obj);
	return (sn) ? sn : null;
};

// Highlights the selected node
adTree.prototype.s = function(id) {
	
	if (!this.config.useSelection) return;
	var cn = this.aNodes[id];
	if (cn._hc && !this.config.folderLinks) return;
	
	// Disabled by xiaosilent.
	/*
	if (this.selectedNode != id) {
		if (this.selectedNode || this.selectedNode==0) {
			eOld = document.getElementById("s" + this.obj + this.selectedNode);
			eOld.className = "node";
		}
		eNew = document.getElementById("s" + this.obj + id);
		eNew.className = "nodeSel";
		this.selectedNode = id;
		if (this.config.useCookies) this.setCookie('cs' + this.obj, cn.id);
	}
	*/
};

// Toggle Open or close
adTree.prototype.o = function(id) {
	
	var cn = this.aNodes[id];
	this.nodeStatus(!cn._io, id, cn._ls);
	cn._io = !cn._io;
	if (this.config.closeSameLevel) this.closeLevel(cn);
	if (this.config.useCookies) this.updateCookie();
};

// Open or close all nodes
adTree.prototype.oAll = function(status) {
	
	for (var n=0; n<this.aNodes.length; n++) {
		
		if (this.aNodes[n]._hc && this.aNodes[n].pid != this.root.id) {
			
			this.nodeStatus(status, n, this.aNodes[n]._ls)
			this.aNodes[n]._io = status;
		}
	}
			
	if (this.config.useCookies) this.updateCookie();
};


// Opens the tree to a specific node
adTree.prototype.openTo = function(nId, bSelect, bFirst) {
	
	if (!bFirst) {
		
		for (var n=0; n<this.aNodes.length; n++) {
			
			if (this.aNodes[n].id == nId) {
				
				nId=n;
				break;
			}
		}
	}
				
	var cn=this.aNodes[nId];
	if (cn.pid==this.root.id || !cn._p) return;
	cn._io = true;
	cn._is = bSelect;
	if (this.completed && cn._hc) this.nodeStatus(true, cn._ai, cn._ls);
	if (this.completed && bSelect) this.s(cn._ai);
	else if (bSelect) this._sn=cn._ai;
	this.openTo(cn._p._ai, false, true);
};

				
// Closes all nodes on the same level as certain node
adTree.prototype.closeLevel = function(node) {
	
	for (var n=0; n<this.aNodes.length; n++) {
		
		if (this.aNodes[n].pid == node.pid && this.aNodes[n].id != node.id && this.aNodes[n]._hc) {
			
			this.nodeStatus(false, n, this.aNodes[n]._ls);
			this.aNodes[n]._io = false;
			this.closeAllChildren(this.aNodes[n]);
		}
	}
}

// Closes all children of a node
adTree.prototype.closeAllChildren = function(node) {
	
	for (var n=0; n<this.aNodes.length; n++) {
		
		if (this.aNodes[n].pid == node.id && this.aNodes[n]._hc) {
			
			if (this.aNodes[n]._io) this.nodeStatus(false, n, this.aNodes[n]._ls);
			this.aNodes[n]._io = false;
			this.closeAllChildren(this.aNodes[n]);		
		}
	}
}

// Change the status of a node(open or closed)
adTree.prototype.nodeStatus = function(status, id, bottom) {
	
	eDiv	= document.getElementById('d' + this.obj + id);
	eJoin	= document.getElementById('j' + this.obj + id);
	
	if (this.config.useIcons) {
		
		eIcon	= document.getElementById('i' + this.obj + id);
		eIcon.src = (status) ? this.aNodes[id].iconOpen : this.aNodes[id].icon;
	}
		
	eJoin.src = (this.config.useLines)?
	((status)?((bottom)?this.icon.minusBottom:this.icon.minus):((bottom)?this.icon.plusBottom:this.icon.plus)):
	((status)?this.icon.nlMinus:this.icon.nlPlus);
	eDiv.style.display = (status) ? 'block': 'none';
};


// [Cookie] Clears a cookie
adTree.prototype.clearCookie = function() {
	
	var now = new Date();
	var yesterday = new Date(now.getTime() - 1000 * 60 * 60 * 24);
	this.setCookie('co'+this.obj, 'cookieValue', yesterday);
	this.setCookie('cs'+this.obj, 'cookieValue', yesterday);
};

	
// [Cookie] Sets value in a cookie
adTree.prototype.setCookie = function(cookieName, cookieValue, expires, path, domain, secure) {
	
	document.cookie =
		escape(cookieName) + '=' + escape(cookieValue)
		+ (expires ? '; expires=' + expires.toGMTString() : '')
		+ (path ? '; path=' + path : '')
		+ (domain ? '; domain=' + domain : '')
		+ (secure ? '; secure' : '');
};

	
// [Cookie] Gets a value from a cookie
adTree.prototype.getCookie = function(cookieName) {
	
	var cookieValue = '';
	var posName = document.cookie.indexOf(escape(cookieName) + '=');
	
	if (posName != -1) {
		
		var posValue = posName + (escape(cookieName) + '=').length;
		var endPos = document.cookie.indexOf(';', posValue);
		if (endPos != -1) cookieValue = unescape(document.cookie.substring(posValue, endPos));
		else cookieValue = unescape(document.cookie.substring(posValue));
	}
		
	return (cookieValue);
};


// [Cookie] Returns ids of open nodes as a string
adTree.prototype.updateCookie = function() {
	
	var str = '';
	for (var n=0; n<this.aNodes.length; n++) {
		
		if (this.aNodes[n]._io && this.aNodes[n].pid != this.root.id) {
			if (str) str += '.';
			str += this.aNodes[n].id;
		}
	}
		
	this.setCookie('co' + this.obj, str);
};


// [Cookie] Checks if a node id is in a cookie
adTree.prototype.isOpen = function(id) {
	
	var aOpen = this.getCookie('co' + this.obj).split('.');
	
	for (var n=0; n<aOpen.length; n++)
		if (aOpen[n] == id) return true;
	return false;
};


// If Push and pop is not implemented by the browser
if (!Array.prototype.push) {
	
	Array.prototype.push = function array_push() {
		
		for(var i=0;i<arguments.length;i++)
			this[this.length]=arguments[i];
		return this.length;
	}
};


if (!Array.prototype.pop) {
	
	Array.prototype.pop = function array_pop() {
		
		lastElement = this[this.length-1];
		this.length = Math.max(this.length-1,0);
		return lastElement;
	}
};
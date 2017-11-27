/*--------------------------------------------------
	dTree 2.05 | www.destroydrop.com/javascript/tree/

	Rewrited by xiaosilent@gmail.com , xiangdingdang.com

	Last updated at 2007-4-28 16:32:05

	
---------------------------------------------------*/
function checkgroup(c, g, tr){	var elements = document.getElementsByTagName('input');	var g = g+"";	var thisid = g.substring(g.lastIndexOf('_')+1);	tr.SetChecked(thisid,c);	for(var i=0; i<elements.length; i++){		if(elements[i].type=='checkbox'&&elements[i].id.indexOf('group_'+g+'_')>=0){			document.getElementById(elements[i].id).checked = c;			var thisid = elements[i].id.substring(elements[i].id.lastIndexOf('_')+1);			tr.SetChecked(thisid,c);		}	}	return true;}
// Node object
function Node(id, pid, pre,count, name, url, title, target, icon, iconOpen, open) {
	this.id = id;
	this.pid = pid;
	this.name = name;
	this.url = url;
	this.title = title;
	this.target = target;
	this.icon = icon;
	this.iconOpen = iconOpen;		this.pre = pre;		this.count = count;		this.checked = false;		this.fetch = false;
	this._io = open || false;
	this._is = false;
	this._ls = false;
	this._hc = false;
	this._ai = 0;
	this._p;
};

/*** dTree  ** Edited by xiaosilent.* * objName: name of dTree object.* targetID: the id of your container,which you used to display the tree* type: which kind of category are you doing with ? It must be one of these  "goods" , "vendor" and "consumer" ,this is just for xiaosilent's Sales Management System.**/
function dTree(objName,targetID,type) {
	
	this.config = {
		target				: null,
		
		// xiaosilent changed it to be false.
		folderLinks			: true,
		useSelection		: true,
		useCookies			: false,
		useLines			: true,
		useIcons			: true,
		useStatusText		: false,
		closeSameLevel		: false,
		inOrder				: false,		checkbox			: false,		menu				: 0,		lastOnode			: 0,		setop				: true
	}
			// xiaosilent changed this to his own path.
	this.icon = {
			
		root		: 'template/admin/cssjs/img/base.gif',
		folder		: 'template/admin/cssjs/img/group.gif',
		folderOpen	: 'template/admin/cssjs/img/groupopen.png',
		node		: 'template/admin/cssjs/img/user.gif',
		empty		: 'template/admin/cssjs/img/empty.gif',
		line		: 'template/admin/cssjs/img/line.gif',
		join		: 'template/admin/cssjs/img/join.gif',
		joinBottom	: 'template/admin/cssjs/img/joinbottom.gif',
		plus		: 'template/admin/cssjs/img/plus.gif',
		plusBottom	: 'template/admin/cssjs/img/plusbottom.gif',
		minus		: 'template/admin/cssjs/img/minus.gif',
		minusBottom	: 'template/admin/cssjs/img/minusbottom.gif',
		nlPlus		: 'template/admin/cssjs/img/nolines_plus.gif',
		nlMinus		: 'template/admin/cssjs/img/nolines_minus.gif'
	};
	this.obj = objName;
	this.aNodes = [];	
	// add by xiaosilent. 
	this.aNodesData=[];	//This array save the original data all the time.
	this.targetID=targetID||'dtree';	// Tree will be displayed in this container.	this.type=type;	// Saves the type of tree  goods/vendor/consumer?
	
	this.aIndent = [];
	this.root = new Node(-1);
	this.selectedNode = null;
	this.selectedFound = false;
	this.completed = false;
};
// Adds a new node to the node array
dTree.prototype.add = function(id, pid, pre,count, name, url, title, target, icon, iconOpen, open) {
	
	// Add by xiaosilent.
	this.completed = false;
	this.aNodesData[this.aNodesData.length] = new Node(id, pid, pre,count, name, url, title, target, icon, iconOpen, open);
};
// Open/close all nodes
dTree.prototype.openAll = function() {
	
	this.oAll(true);
};
	
dTree.prototype.closeAll = function() {	
	this.oAll(false);
};


// Add by xiaosilent .
// get child nodes from web server via AJAX automatically 
// pid : parentID.
dTree.prototype.getChildren = function(pid, pre, params){	var nn = this.NodeN(pid);	this.lastOnode = nn;	if(nn<0 || this.aNodesData[nn].fetch) return ; 
	var url ="admin.php?controller=admin_grouptree&action=getchild&groupid="+escape(pid)+"&"+escape(params);	var tree=this;	
	$.get(url, {"1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//var aNodes = $.csv.toArrays(data);
		var _aNodes = eval("("+data+")");
		var i=0;		if(_aNodes['datas']!=null) 
		for(;i<_aNodes['datas'].length;i++){
			var n=_aNodes['datas'][i];			if(tree.config.menu==1||tree.config.menu==2)				tree.add(n.id, pid, pre,(tree.config.menu==1 ? n.mcount : n.count),n.groupname+'('+(tree.config.menu==1 ? n.mcount : n.count)+')',(tree.config.menu==1?'admin.php?controller=admin_member&ldapid=':'admin.php?controller=admin_pro&action=dev_index&gid=')+n.id+'&menu='+tree.config.menu,n.groupname+'('+(tree.config.menu==1 ? n.mcount : n.count)+')','main','template/admin/cssjs/img/servergroup.png','template/admin/cssjs/img/servergroup.png',null);			else if(tree.config.menu==3)				tree.add(n.id, pid, pre,1,n.groupname,'javascript:selectgroup('+n.id+');',n.groupname,'main','template/admin/cssjs/img/group.png','template/admin/cssjs/img/groupopen.png',null);			else
				tree.add(n.id, pid, pre,(tree.config.menu==1 ? n.mcount : n.count), (tree.config.checkbox ? '<input type="checkbox" name="'+tree.obj+'_group[]" value="'+n.id+'_'+n.groupname+'" gid="'+n.id+'" gname="'+n.groupname+'" id="group_'+pre+'_'+n.id+'"  onclick="checkgroup(this.checked,\''+pre+'_'+n.id+'\','+tree.obj+')">' : '')+n.groupname, "javascript:setSrcValue(\'"+n.groupname+"\',"+n.id+",\'"+tree.obj+"\',"+(tree.config.setop ? "1" : "0")+","+(tree.config.checkbox ? "1" : "0")+",\'"+departmanagersgroupids+"\');", n.groupname,'',tree.icon.folder);
		}		tree.aNodesData[nn].fetch=true;
		tree.show();
		tree.openTo(pid);		if(typeof(showNodeCount0)=="function"){						if(window.parent.main.window.document.getElementById('showemptydir')!=null){				show0 = window.parent.main.window.document.getElementById('showemptydir').checked;			}			showNodeCount0(show0);		}		!tree.config.setop&&checkS(pre+"_");		if(window.parent!=null&&window.parent!=undefined)		window.parent.reinitIframe();
	});
}

dTree.prototype.showCategory = function(){
}

// Add by xiaosilent.
// Call to show the tree .
dTree.prototype.show = function(){
	// Renew the two array to save original data.
	this.aNodes=new Array();
	this.aIndent=new Array();

	// Dump original data to aNode array.
	for(var i=0 ; i<this.aNodesData.length ; i++){
		
		var oneNode=this.aNodesData[i];

		this.aNodes[i]=new Node(oneNode.id,oneNode.pid,oneNode.pre, oneNode.count, oneNode.name,oneNode.url,oneNode.title,oneNode.target,oneNode.icon,oneNode.iconOpen,oneNode.open);
	}
	
	this.rewriteHTML();
}

// Outputs the tree to the page , callled by show()
// Changed by xiaosilent.
dTree.prototype.rewriteHTML = function() {
	
	var str = '';
	
	// Added by xiaosilent. 
	var targetDIV;
	targetDIV=document.getElementById(this.targetID);
	
	if(!targetDIV){
		
		alert('dTree can\'t find your specified container to show your tree.\n\n Please check your code!');

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
dTree.prototype.addNode = function(pNode) {
	
	var str = '';
	var n=0;
	if (this.config.inOrder) n = pNode._ai;
	for (n; n<this.aNodes.length; n++) {
		if (this.aNodes[n].pid == pNode.id) {
			var cn = this.aNodes[n];
			cn._p = pNode;
			cn._ai = n;						cn._hc = true;
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
dTree.prototype.node = function(node, nodeId) {
	
	var str = '<div class="dTreeNode" count='+node.count+'>' + this.indent(node, nodeId);
	if (this.config.useIcons) {
		if (!node.icon) node.icon = (this.root.id == node.pid) ? this.icon.root : ((node._hc) ? this.icon.folder : this.icon.node);
		if (!node.iconOpen) node.iconOpen = (node._hc) ? this.icon.folderOpen : this.icon.node;
		if (this.root.id == node.pid) {
			node.icon = this.icon.root;
			node.iconOpen = this.icon.root;
		}
		str += '<img onclick="'+this.obj+'.getChildren('+node.id+',\''+(node.pre!='' ? node.pre+'_' : '')+node.id+'\')" id="i' + this.obj + nodeId + '" src="' + ((node._io) ? node.iconOpen : node.icon) + '" alt="" />';
	}
	if (node.url) {		var urljs ="";		if(node.url.substring(0,10)=='javascript'){			urljs = node.url.substring(11);			node.url = "javascript:void(0);";		}
		str += '<a id="s' + this.obj + nodeId + '" class="' + ((this.config.useSelection) ? ((node._is ? 'nodeSel' : 'node')) : 'node') + '" href="' + node.url + '"';
		if (node.title) str += ' title="' + node.title + '"';
		if (node.target) str += ' target="' + node.target + '"';
		if (this.config.useStatusText) str += ' onmouseover="window.status=\'' + node.title + '\';return true;" onmouseout="window.status=\'\';return true;" ';
		if (this.config.useSelection && ((node._hc && this.config.folderLinks) || !node._hc))
			str += ' onclick="javascript: ' + this.obj + '.s(' + nodeId + ');'+urljs+'"';
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
dTree.prototype.indent = function(node, nodeId) {
	
	var str = '';
	if (this.root.id != node.pid) {
		for (var n=0; n<this.aIndent.length; n++)
			str += '<img src="' + ( (this.aIndent[n] == 1 && this.config.useLines) ? this.icon.line : this.icon.empty ) + '" alt="" />';
		(node._ls) ? this.aIndent.push(0) : this.aIndent.push(1);
		if (node._hc) {
			str += '<a href="javascript: ' + this.obj + '.o(' + nodeId + ');"><img onclick="'+this.obj+'.getChildren('+node.id+',\''+(node.pre!='' ? node.pre+'_' : '')+node.id+'\')" id="j' + this.obj + nodeId + '" src="';
			if (!this.config.useLines) str += (node._io) ? this.icon.nlMinus : this.icon.nlPlus;
			else str += ( (node._io) ? ((node._ls && this.config.useLines) ? this.icon.minusBottom : this.icon.minus) : ((node._ls && this.config.useLines) ? this.icon.plusBottom : this.icon.plus ) );
			str += '" alt="" /></a>';
		} else str += '<img src="' + ( (this.config.useLines) ? ((node._ls) ? this.icon.joinBottom : this.icon.join ) : this.icon.empty) + '" alt="" />';
	}
	return str;
};


// Checks if a node has any children and if it is the last sibling
dTree.prototype.setCS = function(node) {

	var lastId;

	for (var n=0; n<this.aNodes.length; n++) {
	
		if (this.aNodes[n].pid == node.id) node._hc = true;
		if (this.aNodes[n].pid == node.pid) lastId = this.aNodes[n].id;
	}

	if (lastId==node.id) node._ls = true;
};


// Returns the selected node
dTree.prototype.getSelected = function() {
	
	var sn = this.getCookie('cs' + this.obj);
	return (sn) ? sn : null;
};

// Highlights the selected node
dTree.prototype.s = function(id) {
	
	if (!this.config.useSelection) return;
	var cn = this.aNodes[id];
	if (cn._hc && !this.config.folderLinks) return;
	
	// Disabled by xiaosilent.
	
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
	
};

// Toggle Open or close
dTree.prototype.o = function(id) {
		
	var cn = this.aNodes[id];
	this.nodeStatus(!cn._io, id, cn._ls);
	cn._io = !cn._io;
	if (this.config.closeSameLevel) this.closeLevel(cn);
	if (this.config.useCookies) this.updateCookie();	if(window.parent!=null&&window.parent!=undefined)	window.parent.reinitIframe();
};

// Open or close all nodes
dTree.prototype.oAll = function(status) {
	
	for (var n=0; n<this.aNodes.length; n++) {
		
		if (this.aNodes[n]._hc && this.aNodes[n].pid != this.root.id) {
			
			this.nodeStatus(status, n, this.aNodes[n]._ls)
			this.aNodes[n]._io = status;
		}
	}
			
	if (this.config.useCookies) this.updateCookie();	if(window.parent!=null&&window.parent!=undefined)	window.parent.reinitIframe();
};


// Opens the tree to a specific node
dTree.prototype.openTo = function(nId, bSelect, bFirst) {
	
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
dTree.prototype.closeLevel = function(node) {
	
	for (var n=0; n<this.aNodes.length; n++) {
		
		if (this.aNodes[n].pid == node.pid && this.aNodes[n].id != node.id && this.aNodes[n]._hc) {
			
			this.nodeStatus(false, n, this.aNodes[n]._ls);
			this.aNodes[n]._io = false;
			this.closeAllChildren(this.aNodes[n]);
		}
	}
}

// Closes all children of a node
dTree.prototype.closeAllChildren = function(node) {
	
	for (var n=0; n<this.aNodes.length; n++) {
		
		if (this.aNodes[n].pid == node.id && this.aNodes[n]._hc) {
			
			if (this.aNodes[n]._io) this.nodeStatus(false, n, this.aNodes[n]._ls);
			this.aNodes[n]._io = false;
			this.closeAllChildren(this.aNodes[n]);		
		}
	}
}

// Change the status of a node(open or closed)
dTree.prototype.nodeStatus = function(status, id, bottom) {
	
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
dTree.prototype.clearCookie = function() {
	
	var now = new Date();
	var yesterday = new Date(now.getTime() - 1000 * 60 * 60 * 24);
	this.setCookie('co'+this.obj, 'cookieValue', yesterday);
	this.setCookie('cs'+this.obj, 'cookieValue', yesterday);
};

	
// [Cookie] Sets value in a cookie
dTree.prototype.setCookie = function(cookieName, cookieValue, expires, path, domain, secure) {
	
	document.cookie =
		escape(cookieName) + '=' + escape(cookieValue)
		+ (expires ? '; expires=' + expires.toGMTString() : '')
		+ (path ? '; path=' + path : '')
		+ (domain ? '; domain=' + domain : '')
		+ (secure ? '; secure' : '');
};

	
// [Cookie] Gets a value from a cookie
dTree.prototype.getCookie = function(cookieName) {
	
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
dTree.prototype.updateCookie = function() {
	
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
dTree.prototype.isOpen = function(id) {
	
	var aOpen = this.getCookie('co' + this.obj).split('.');
	
	for (var n=0; n<aOpen.length; n++)
		if (aOpen[n] == id) return true;
	return false;
};
dTree.prototype.NodeN = function(id) {		for (var n=0; n<this.aNodes.length; n++)		if (this.aNodes[n].id == id) return n;	return -1;};dTree.prototype.SetChecked = function(id,c) {	this.aNodesData[this.NodeN(id)].checked = c;};dTree.prototype.GetChecked = function(id) {	 return this.aNodesData[this.NodeN(id)].checked;};

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
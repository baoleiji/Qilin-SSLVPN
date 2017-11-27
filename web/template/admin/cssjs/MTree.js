 <!--
/*---------------------------------------------------------------------------*\
|  Subject:       Web TreeView Class                                          |
|  Version:       1.0                                                         |
|  Author:        黄方荣【meizz】【梅花雪】                                   |
|  FileName:      MzTreeView.js                                               |
|  Created:       2004-10-18                                                  |
|  LastModified:  2005-03-10                                                  |
|  Download:      http://www.meizz.com/Web/Download/MzTreeView10.rar          |
|  Explain:       http://www.meizz.com/Web/Article.asp?id=436                 |
|  Demo:          http://www.meizz.com/Web/Demo/MzTreeView10.htm              |
|                                                                             |
|                 You may use this code on your item                          |
|                 this entire copyright notice appears unchanged              |
|                 and you clearly display a link to http://www.meizz.com/     |
|                                                                             |
|-----------------------------------------------------------------------------|
|  MSN: huangfr@msn.com   QQ: 112889082   http://www.meizz.com                |
|  CSDN Community ID: meizz      Copyright (c) 2004-2005 meizz                |
\*---------------------------------------------------------------------------*/
/*
注:树节点中不要用"<td>"标签，"%", "$"
*/

//MzTreeView1.0网页树类, 在实例化的时候请把实例名作参数传递进来
var treename;
function MTree(imagePath)
{
  if(typeof(imagePath) != "string" || imagePath == "")
    throw(new Error(-1, 'imagePath is null！'));
  
  //【property】
  //是否自动加载
  this.autoreload=true;
  //加载节点多时的提示信息
  this.loadPromptInfo="Loading...";
  //动态加载节点数超过多少个出现提示信息
  this.nodecountToPrompt=200;
  //提示信息
  this.timeoutToPrompt=1;
  //节点的url
  this.url      = "#";
  this.target   = "_self";
  //树的名称
  this.name     = "";
  this.imagePath="";
  //是否用线代替图片
  this.wordLine = false;
  // 是否用checkbox联动
  this.isCheckLink=true;
  this.currentNode = null;
  this.useArrow = true;
  this.nodes = {};
  this.node  = {};
  this.names = "";
  this._d    = "\x0f";
  this.index = 0;
  this.divider   = "%";
  this.separator="@"; // yeqw 避免和正则表达式或其他语言冲突，使用两个符号分割
  this.treehtml="";
  this.rootId="";
  this.node["0"] =
  {
    "id": "0",
    "path": "0",
    "isLoad": false,
    "childNodes": [],
    "childAppend": "",
    "sourceIndex": "0"
  };

  this.colors   =
  {
    "highLight" : "#0A246A",
    "highLightText" : "#FFFFFF",
    "mouseOverBgColor" : "#D4D0C8"
  };
  this.icons    = {
    L0        : 'L0.gif',  //┏
    L1        : 'L1.gif',  //┣
    L2        : 'L2.gif',  //┗
    L3        : 'L3.gif',  //━
    L4        : 'L4.gif',  //┃
    PM0       : 'P0_P.gif',  //＋┏
    PM1       : 'P1_P.gif',  //＋┣
    PM2       : 'P2_P.gif',  //＋┗
    PM3       : 'P3_P.gif',  //＋━
// 原版立体图片
//    PM0       : 'P0.gif',  //＋┏
//    PM1       : 'P1.gif',  //＋┣
//    PM2       : 'P2.gif',  //＋┗
//    PM3       : 'P3.gif',  //＋━
    empty     : 'L5.gif',     //空白图
    root      : 'root.gif',   //缺省的根节点图标
    folder    : 'folder.gif', //缺省的文件夹图标
    file      : 'file.gif',   //缺省的文件图标
    exit      : 'exit.gif'
  };
  this.iconsExpand = {  //存放节点图片在展开时的对应图片

// 原版立体图片  
//    PM0       : 'M0.gif',     //－┏
//    PM1       : 'M1.gif',     //－┣
//    PM2       : 'M2.gif',     //－┗
//    PM3       : 'M3.gif',     //－━
    
    PM0       : 'M0_P.gif',     //－┏
    PM1       : 'M1_P.gif',     //－┣
    PM2       : 'M2_P.gif',     //－┗
    PM3       : 'M3_P.gif',     //－━
    
    folder    : 'folderopen.gif',

    exit      : 'exit.gif'
  };

	//初始化图片地址
   this.imagePath=imagePath+"/";
   this.setIconPath(imagePath+"/");

  //扩展 document.getElementById(id) 多浏览器兼容性
  //id 要查找的对象 id
  this.getElementById = function(id)
  {	
    if (typeof(id) != "string" || id == "") return null;
    if (document.getElementById) return document.getElementById(id);
    if (document.all) return document.all(id);
    try {return eval(id);} catch(e){ return null;}
  }

  this.onkeydown= function(e)
  {
    e = window.event || e; var key = e.keyCode || e.which;
    if(treename){
    switch(key)
    {
      //case 37 : eval(treename).upperNode(); break;  //Arrow left, shrink child node
      //case 38 : eval(treename).pervNode();  break;  //Arrow up
      //case 39 : eval(treename).lowerNode(); break;  //Arrow right, expand child node
      //case 40 : eval(treename).nextNode();  break;  //Arrow down
    }}
  };
  /**
  *生成树html
  */
  this.getTreeHtml =  function(){
	  var str="";
	  if(this.autoreload){
		 
			str=  this.getTreeHtmlAutoLoad();
		}else{
			str=  this.getTreeHtmlDynamic();
		}
		checkradio(); // yeqw 如果有radio把它的子节点全部设置成disable
		return str;
	};
  
}
//将树的属性克隆给另一个树
MTree.prototype.clone = function(tree){
	tree.setTreeName(this.name);
	tree.setPromptInfo(this.loadPromptInfo);
	tree.setAutoReload(this.autoreload);
	tree.names=this.names;
	tree.node=this.node;
	tree.nodes=this.nodes;
	return tree;
	
};
/**
*为了保证原来MTree调用此方法时不报错加的，没有意义
*/
MTree.prototype.formatBG =function (){

}
 /**
  *加载时只生成根节点和一级节点 其他动态加载
  */
   MTree.prototype.getTreeHtmlDynamic = function()
  {
    this.browserCheck();
    this.dataFormat();
    //this.setStyle();报没有权限错误
    this.load("0");
    var rootCN = this.node["0"].childNodes;
    var str = "<A id='"+ this.name +"_RootLink' href='#' style='DISPLAY: none'></A>";
    
    if(rootCN.length>0)
    {
      this.node["0"].hasChild = true;
      for(var i=0; i<rootCN.length; i++){
        str += this.nodeToHTML(rootCN[i], i==rootCN.length-1);
		 this.load(rootCN[i].id);
		var child=rootCN[i].childNodes;
	
		if(child !=null && child.length>0){
			for(var j=0;j<child.length;j++){
					str += this.nodeToHTML(child[j], j==child.length-1);
			}
		}
	  }
	  
       this.focusClientNode(rootCN[0].id ); 
	   this.atRootIsEmpty();
	
	  
    }
	 if (this.useArrow)  //使用方向键控制跳转到上级下级父级子级节点
    {
      if (document.attachEvent)
          document.attachEvent("onkeydown", this.onkeydown);
      else if (document.addEventListener)
          document.addEventListener('keydown', this.onkeydown, false);
    }
	// yeqw 
	    return "<DIV id='"+ this.name +"' class='MzTreeView' "+
      "onclick='"+ this.name +".clickHandle(event)' "+
      "ondblclick='"+ this.name +".dblClickHandle(event)' "+
      ">"+ str +"</DIV>";

/* // 原版
    return "<DIV class='MzTreeView' "+
      "onclick='"+ this.name +".clickHandle(event)' "+
      "ondblclick='"+ this.name +".dblClickHandle(event)' "+
      ">"+ str +"</DIV>";
*/
  };
 /**
  * 加载之前生成html
  */
 MTree.prototype.getTreeHtmlAutoLoad = function()
  {
    this.browserCheck();
    this.dataFormat();
   // this.setStyle();报没有权限错误
	this.treehtml="";
	
    this.getNodesHtml("0");

	 this.node["0"].hasChild = true;
	this.focusClientNode("0"); 
	 this.atRootIsEmpty();
	    if (this.useArrow)  //使用方向键控制跳转到上级下级父级子级节点
    {
      if (document.attachEvent)
          document.attachEvent("onkeydown", this.onkeydown);
      else if (document.addEventListener)
          document.addEventListener('keydown', this.onkeydown, false);
    }
	// yeqw
	return "<A id='"+ this.name +"_RootLink' href='#' style='DISPLAY: none'></A><DIV id='"+ this.name +"' class='MzTreeView' "+
      "onclick='"+ this.name +".clickHandle(event)' "+
      "ondblclick='"+ this.name +".dblClickHandle(event)' "+
      ">"+ this.treehtml +"</DIV>";

/* //原版
	return "<A id='"+ this.name +"_RootLink' href='#' style='DISPLAY: none'></A><DIV class='MzTreeView' "+
      "onclick='"+ this.name +".clickHandle(event)' "+
      "ondblclick='"+ this.name +".dblClickHandle(event)' "+
      ">"+ this.treehtml +"</DIV>";
*/
  };
/**
*生成节点html包括子节点
*/
 MTree.prototype.getNodesHtml = function(id){

		this.load(id);
		var node=this.node[id];
		var child=this.node[id].childNodes;
		this.treehtml += "\r\n<SPAN id='"+this.name +"_tree_"+ id +"' >";
		if(node.id == "0" || node.parentId=="0" ){
			this.treehtml +="<SPAN style='DISPLAY: block'>";
		}else{
			this.treehtml +="<SPAN style='DISPLAY: none'>";
		}
		if(child !=null && child.length>0)
		 {	
			for(var i=0; i<child.length; i++){
				this.treehtml += this.nodeToHTMLShow(child[i], i==child.length-1);
				if (child[i].hasChild){
					this.getNodesHtml(child[i].id);
				}
			
			}
		 }
		 this.treehtml +="</SPAN></SPAN>";
	
	};

//删除节点
MTree.prototype.deleteNode = function(nId) {
	
	for (var id in this.nodes){
		var temp=id.split(this.divider);
		if(temp !=null && temp.length==2){
			if(temp[1]==nId ){
				this.nodes[id]=null;
			}
		}
		
	}
	
}
//清空树
MTree.prototype.clear = function (){
	this.nodes={};
	this.names="";
	this.node={};
	this.node["0"] =
	{
	 "id": "0",
	 "path": "0",
	 "isLoad": false,
		"childNodes": [],
		"childAppend": "",
		"sourceIndex": "0"
	 };
};

//模拟点击节点，循环展开父节点2006-05-18
MTree.prototype.clickDemo =function(id){
	this.focus(id);
 
};

/** 
 * 添加根节点对象 
 * @param  root  根节点
*/
 MTree.prototype.addRoot= function(root) {
	 this.rootId=root.id;
	 if(root.text==null){
	 	this.nodes["0%"+root.id]="text:&nbsp;";
	 }else {
	 	this.nodes["0%"+root.id]="text:"+root.text;
	 }
	
};
/** 为树的节点组nodes[]添加一个新的节点 */
MTree.prototype.addNode= function(node) {
	// yeqw 
	if("checkbox" == node.cText || "radio" == node.cText ) {
		this.nodes[node.parentId+"%"+node.id]="cfunciton:"+node.cfunciton+this.separator+"pimg:"+node.pImg+this.separator+"text:"+node.pText+this.separator+"ctext:"+node.cText+this.separator+"cid:"+node.cId+this.separator+"cname:"+node.cName+this.separator+"cvalue:"+node.cValue;
	} else {
		this.nodes[node.parentId+"%"+node.id]="cfunciton:"+node.cfunciton+this.separator+"pimg:"+node.pImg+this.separator+"text:"+node.pText;
	}
};

// --------------------yeqw-------------------------

// 选中或取消全部子节点或取消本节点的所有父节点
function radioCheckboxDiabled(currcheckbox) {
	var aReturn=document.body.getElementsByTagName("INPUT"); // 全部的checkbox
	for(var i=0; i<aReturn.length; i++) {
		// 判断type是否是checkbox
		if ("checkbox" == aReturn[i].type && aReturn[i].treename != undefined)
		{
			var str  = aReturn[i].nodelength; 
			var s = str.indexOf(currcheckbox.nodelength);
			
			var num = str.indexOf(currcheckbox.nodelength) + currcheckbox.nodelength.length
			var next_char = (str.substring(num,num+1)); // 匹配后的下一个字符，防止 0%15 与0%1这种情况匹配出错
			
			
			// 选中或取消全部子节点
			if (0 == s && "%" == next_char && currcheckbox.treename == aReturn[i].treename)
			{
				if(true == currcheckbox.checked)
					aReturn[i].checked=true;
				else
					aReturn[i].checked=false;
			}
		}
	}
}

// 设置本树内全部节点的checkbox为选中
function checkradio() {
	var aReturn=document.body.getElementsByTagName("INPUT"); // 全部的checkbox
	for(var i=0; i<aReturn.length; i++) {
		// 判断type是否是radio
		if ("radio" == aReturn[i].type && aReturn[i].treename != undefined)
		{
			clearcheckall(aReturn[i]);
		}
	}
}
// 检查所有的radio
function clearcheckall(currcheckbox) {
	var aReturn=document.body.getElementsByTagName("INPUT"); // 全部的checkbox
	for(var i=0; i<aReturn.length; i++) {
		// 判断type是否是checkbox
		if ("checkbox" == aReturn[i].type && aReturn[i].treename != undefined)
		{
			var str  = aReturn[i].nodelength; 
			var s = str.indexOf(currcheckbox.nodelength);
			
			var num = str.indexOf(currcheckbox.nodelength) + currcheckbox.nodelength.length
			var next_char = (str.substring(num,num+1)); // 匹配后的下一个字符，防止 0%15 与0%1这种情况匹配出错
			
			// 选中或取消全部子节点
			if (currcheckbox.treename == aReturn[i].treename)
			{
				if(0 == s && "%" == next_char) {
					aReturn[i].disabled=true;
				} 
			}
		}
	}
}

// 点击radio取消本树内其他非本节点的子节点的checkbox
function radioclear(currcheckbox) {
	// 参数
	var parmstr0 = currcheckbox.id;
	var parmstr1 = currcheckbox.name;
	var parmstr2 = currcheckbox.value;
	var parmstr3 = currcheckbox.nodelength;
	
	var aReturn=document.body.getElementsByTagName("INPUT"); // 全部的checkbox
	for(var i=0; i<aReturn.length; i++) {
		// 判断type是否是checkbox

		if ("checkbox" == aReturn[i].type && aReturn[i].treename != undefined)
		{
			var str  = aReturn[i].nodelength; 
			var s = str.indexOf(currcheckbox.nodelength);
			// 选中或取消全部子节点
			if (currcheckbox.treename == aReturn[i].treename)
			{
				//if(true == currcheckbox.checked)
				//	aReturn[i].checked=true;
				//else
				if(0 != s) {
					aReturn[i].checked=false;
					aReturn[i].disabled=true;
				} else
					aReturn[i].disabled=false;
				
			}
		}
	}

	try{
		eval(currcheckbox.cfunciton+"('"+parmstr0+"','"+parmstr1+"','"+parmstr2+"','"+parmstr3+"',currcheckbox)");
	}catch(err){

	} 	
}

// 选中或取消全部子节点或取消本节点的所有父节点
function checkall(currcheckbox) {
	
	// 参数
	var parmstr0 = currcheckbox.id;
	var parmstr1 = currcheckbox.name;
	var parmstr2 = currcheckbox.value;
	var parmstr3 = currcheckbox.nodelength;




	var aReturn=document.body.getElementsByTagName("INPUT"); // 全部的checkbox
	for(var i=0; i<aReturn.length; i++) {
		// 判断type是否是checkbox

		if ("checkbox" == aReturn[i].type && aReturn[i].treename != undefined)
		{
			var str  = aReturn[i].nodelength; 
			//alert(aReturn[i].type+";"+aReturn[i].id+";"+aReturn[i].name+";"+aReturn[i].value);
			var s = str.indexOf(currcheckbox.nodelength);
			
			var num = str.indexOf(currcheckbox.nodelength) + currcheckbox.nodelength.length
			var next_char = (str.substring(num,num+1)); // 匹配后的下一个字符，防止 0%15 与0%1这种情况匹配出错
			
			// 选中或取消全部子节点
			if (0 == s && "%" == next_char && currcheckbox.treename == aReturn[i].treename)
			{
				if(true == currcheckbox.checked)
					aReturn[i].checked=true;
				else
					aReturn[i].checked=false;
			}

			// 取消本节点的所有父节点
			if (false == currcheckbox.checked && currcheckbox.treename == aReturn[i].treename)
			{
					var currpath = currcheckbox.nodelength;
					while (true)
					{
						currpath  =currpath.substring(0,currpath.lastIndexOf('%')); //当前节点的父节点
						if(currpath == '0')
						break;
						if (str == currpath)
						{
							aReturn[i].checked=false;
						}
					}
			}

		}
	}
	
		//var cfunciton = this.getAttribute(source, "cfunciton"); // yeqw 用户自定义函数属性
		try{
			eval(currcheckbox.cfunciton+"('"+parmstr0+"','"+parmstr1+"','"+parmstr2+"','"+parmstr3+"',currcheckbox)");
		}catch(err){
			
		} 

}
// --------------------yeqw-------------------------


/*2006-05-18*/
/** 
 * 根节点对象 
 * @param  id  根节点ID
 * @param  htmText  根节点HTML属性 
*/
function MTreeRoot(id,htmlText) {
	this.id = id; 
	this.text = htmlText;
}


/**
 * 节点对象
 * @param id int 节点ID号
 * @param parentId String 父节点的ID号，一级节点父节点为根节点
 * @param imgOpen	String 打开时标志图片，没有为null
 * @param imgClose	String 闭合时标志图片，没有为null
 * @param fHtmlText String 树节点前的HTML属性 (暂时无用)
 * @param pHtmlText String 树节点后的HTML属性
 * @param pHtmlImg String 树节点后的图片的HTML属性
 * @param cHtmlText String 树节点后的checkbox或radio属性
 * @param cHtmlID String 树节点后的checkbox或radio的ID属性
 * @param cHtmlName String 树节点后的checkbox或radio的Name属性
 * @param cHtmlValue String 树节点后的checkbox或radio的Value属性
 * @param cFunciton String 用户自定义函数属性
*///~~
function MTreeNode(id,parentId,imgOpen,imgClose,fHtmlText,pHtmlText,pHtmlImg,cHtmlText,cHtmlID,cHtmlName,cHtmlValue,cFunciton) {
	this.id = id;
	this.parentId = parentId;
		
	this.imgOpen=imgOpen;
	this.imgClose=imgClose;
	
	this.fText=fHtmlText;
	this.pText=pHtmlText;

	//yeqw
	this.pImg=pHtmlImg;
	this.cText=cHtmlText;
	this.cId=cHtmlID;
	this.cName=cHtmlName;
	this.cValue=cHtmlValue;
	this.cfunciton=cFunciton

}

//浏览器类型及版本检测
MTree.prototype.browserCheck = function()
{
  var ua = window.navigator.userAgent.toLowerCase(), bname;
  if(/msie/i.test(ua))
  {
    this.navigator = /opera/i.test(ua) ? "opera" : "";
    if(!this.navigator) this.navigator = "msie";
  }
  else if(/gecko/i.test(ua))
  {
    var vendor = window.navigator.vendor.toLowerCase();
    if(vendor == "firefox") this.navigator = "firefox";
    else if(vendor == "netscape") this.navigator = "netscape";
    else if(vendor == "") this.navigator = "mozilla";
  }
  else this.navigator = "msie";
  if(window.opera) this.wordLine = false;
};

//给 TreeView 树加上样式设置
MTree.prototype.setStyle = function()
{
  /*
    width: 16px; \
    height: 16px; \
    width: 20px; \
    height: 20px; \
  */
  var style = "<style>"+
  "DIV.MzTreeView DIV IMG{border: 0px solid #FFFFFF;}"+
  "DIV.MzTreeView DIV SPAN IMG{border: 0px solid #FFFFFF;}";
  if(this.wordLine)
  {
    style +="\
    DIV.MzTreeView DIV\
    {\
      height: 20px;"+
      (this.navigator=="firefox" ? "line-height: 20px;" : "" ) +
      (this.navigator=="netscape" ? "" : "overflow: hidden;" ) +"\
    }\
    DIV.MzTreeView DIV SPAN\
    {\
      vertical-align: middle; font-size: 21px; height: 20px; color: #D4D0C8; cursor: default;\
    }\
    DIV.MzTreeView DIV SPAN.pm\
    {\
      width: "+ (this.navigator=="msie"||this.navigator=="opera" ? "11" : "9") +"px;\
      height: "+ (this.navigator=="netscape"?"9":(this.navigator=="firefox"?"10":"11")) +"px;\
      font-size: 7pt;\
      overflow: hidden;\
      margin-left: -16px;\
      margin-right: 5px;\
      color: #000080; \
      vertical-align: middle;\
      border: 1px solid #D4D0C8;\
      cursor: "+ (this.navigator=="msie" ? "hand" : "pointer") +";\
      padding: 0 2px 0 2px;\
      text-align: center;\
      background-color: #F0F0F0;\
    }";
  }
  style += "<\/style>";
  document.write(style);
};

//当根节点为空的时候做的处理
MTree.prototype.atRootIsEmpty = function()
{	
  var RCN = this.node["0"].childNodes;
  for(var i=0; i<RCN.length; i++)
  {
    if(!RCN[i].isLoad) this.expand(RCN[i].id);
    if (RCN[i].text=="")
    {
      var node = RCN[i].childNodes[0], HCN  = node.hasChild;
      if(this.wordLine)
      {
        var span = this.getElementById(this.name +"_tree_"+ node.id);
        span = span.childNodes[0].childNodes[0].childNodes[0];
        span.innerHTML = RCN[i].childNodes.length>1 ? "┌" : "─";
      }
      else
      {
       node.iconExpand  =  RCN[i].childNodes.length>1 ? HCN ? "PM0" : "L0" : HCN ? "PM3" : "L3"
	   this.getElementById(this.name +"_expand_"+ node.id).src = this.icons[node.iconExpand].src;
      }
    }
  }
};

//初始化数据源里的数据以便后面的快速检索
MTree.prototype.dataFormat = function()
{
  var a = new Array();
  for (var id in this.nodes){
	 if(this.nodes[id] !=null && this.nodes[id] !="")
	  a[a.length] = id;
  }
  this.names = a.join(this._d + this._d);
  this.totalNode = a.length; a = null;
};

//在数据源检索所需的数据节点
//id  客户端节点对应的id
MTree.prototype.load = function(id)
{	
  var node = this.node[id], d = this.divider, _d = this._d;
  var sid = node.sourceIndex.substr(node.sourceIndex.indexOf(d) + d.length);
  var reg = new RegExp("(^|"+_d+")"+ sid +d+"[^"+_d+d +"]+("+_d+"|$)", "g");
  
  var cns = this.names.match(reg), tcn = this.node[id].childNodes;
  if (cns){
	reg = new RegExp(_d, "g");
	for (var i=0; i<cns.length; i++){
		tcn[tcn.length] = this.nodeInit(cns[i].replace(reg, ""), id);
		
	}
  }
  
  
	 node.isLoad = true;
};

//初始化节点信息, 根据 this.nodes 数据源生成节点的详细信息
//sourceIndex 数据源中的父子节点组合的字符串 0_1
//parentId    当前树节点在客户端的父节点的 id
MTree.prototype.nodeInit = function(sourceIndex, parentId)
{
  this.index++;
  var source= this.nodes[sourceIndex], d = this.divider;
  var text  = this.getAttribute(source, "text");
  var hint  = this.getAttribute(source, "hint");
  var ctext = this.getAttribute(source, "ctext"); // yeqw checkbox或radio属性
  var cid = this.getAttribute(source, "cid"); // yeqw checkbox或radio的id属性
  var cname = this.getAttribute(source, "cname"); // yeqw checkbox或radio的name属性
  var cvalue = this.getAttribute(source, "cvalue"); // yeqw checkbox或radio的value属性
  var pimg = this.getAttribute(source, "pimg"); // yeqw 图片属性
  var cfunciton = this.getAttribute(source, "cfunciton"); // yeqw 用户自定义函数属性
  var sid   = sourceIndex.substr(sourceIndex.indexOf(d) + d.length);
  this.node[this.index] =
  {
    "id"    : this.index,
    "text"  : text,
	"ctext" : ctext,
	"cid"   : cid,
	"cname" : cname,
	"cvalue": cvalue,
	"pimg"   : pimg,
	"cfunciton"   : cfunciton,
    "hint"  : hint ? hint : text,
    "icon"  : this.getAttribute(source, "icon"),
    "path"  : this.node[parentId].path + d + this.index,
    "isLoad": false,
    "isExpand": false,
    "parentId": parentId,
    "parentNode": this.node[parentId],
    "sourceIndex" : sourceIndex,
    "childAppend" : ""
  };
     this.nodes[sourceIndex] = "index:"+ this.index +this.separator+ source;
     this.node[this.index].hasChild = this.names.indexOf(this._d + sid + d)>-1;
  if(this.node[this.index].hasChild)  this.node[this.index].childNodes = [];
  return this.node[this.index];
};

//从XML格式字符串里提取信息
//source 数据源里的节点信息字符串(以后可以扩展对XML的支持)
//name   要提取的属性名
MTree.prototype.getAttribute = function(source, name)
{
  var reg = new RegExp("(^|"+this.separator+"|\\s)"+ name +"\\s*:\\s*([^"+this.separator+"]*)(\\s|"+this.separator+"|$)", "i");
  if (reg.test(source)) return RegExp.$2.replace(/[\x0f]/g, this.separator); return "";
};

//根据节点的详细信息生成HTML 全部加载
//node   树在客户端的节点对象
//AtEnd  布尔值  当前要转换的这个节点是否为父节点的子节点集中的最后一项
MTree.prototype.nodeToHTML = function(node, AtEnd)
{
  var source = this.nodes[node.sourceIndex];
  var target = this.getAttribute(source, "target");
  var data = this.getAttribute(source, "data");
  var url  = this.getAttribute(source, "url");
  if(!url) url = this.url;
  if(data) url += (url.indexOf("?")==-1?"?":"&") + data;
  if(!target) target = this.target;

  var id   = node.id;
  var HCN  = node.hasChild, isRoot = node.parentId=="0";
  // if(isRoot && node.icon=="") node.icon = "root";
  //不设置节点图片时不要默认图片
  if(node.icon !=null && node.icon !="" ){
	if(node.icon=="" || typeof(this.icons[node.icon])=="undefined")
	 node.icon = HCN ? "folder" : "file";
  }
  node.iconExpand  = AtEnd ? "└" : "├";

  var HTML = "<DIV noWrap='True'><NOBR>";
  if(!isRoot)
  {
    node.childAppend = node.parentNode.childAppend + (AtEnd ? "　" : "│");
    if(this.wordLine)
    {
      HTML += "<SPAN>"+ node.parentNode.childAppend + (AtEnd ? "└" : "├") +"</SPAN>";
      if(HCN) HTML += "<SPAN class='pm' id='"+ this.name +"_expand_"+ id +"'>+</SPAN>";
    }
    else
    {
      node.iconExpand  = HCN ? AtEnd ? "PM2" : "PM1" : AtEnd ? "L2" : "L1";
      HTML += "<SPAN>"+ this.word2image(node.parentNode.childAppend) +"<IMG "+
        "align='absmiddle' id='"+ this.name +"_expand_"+ id +"' "+
        "src='"+ this.icons[node.iconExpand].src +"' style='cursor: "+ (!node.hasChild ? "":
        (this.navigator=="msie"||this.navigator=="opera"? "hand" : "pointer")) +"'></SPAN>";
    }
  }
  if(node.icon !=null && node.icon !="")
  if(typeof(this.icons[node.icon])!="undefined"){
  HTML += "<IMG "+
    "align='absMiddle' "+
    "id='"+ this.name +"_icon_"+ id +"' "+
    "src='"+ this.icons[node.icon].src +"'>"
  }

  // yeqw  加note.path
  var ctext = this.getAttribute(source, "ctext"); // yeqw checkbox属性
  var cid = this.getAttribute(source, "cid"); // yeqw checkbox或radio的id属性
  var cname = this.getAttribute(source, "cname"); // yeqw checkbox或radio的name属性
  var cvalue = this.getAttribute(source, "cvalue"); // yeqw checkbox或radio的value属性
  var pimg = this.getAttribute(source, "pimg"); // yeqw 图片属性
  var cfunciton = this.getAttribute(source, "cfunciton"); // yeqw 用户自定义函数属性
  
  var checkAction = "";
  if(this.isCheckLink) {
  	checkAction = "onclick='checkall(this)'";
  }
  
	if("checkbox" == ctext) {	
		  HTML +="<span "+
			"class='MzTreeview' hideFocus "+
			"id='"+ this.name +"_link_"+ id +"' "+
			">"+ "<INPUT TYPE='checkbox' id='"+node.cid+"' NAME='"+node.cname+"' " + checkAction +  " value='"+node.cvalue+"' nodelength='"+node.path+"' treename='"+this.name+"' cfunciton='"+node.cfunciton+"'>"+pimg+node.text + 
		  "</span></NOBR></DIV>";
	} else if("radio" == ctext) {	
		  HTML +="<span "+
			"class='MzTreeview' hideFocus "+
			"id='"+ this.name +"_link_"+ id +"' "+
			">"+ "<INPUT TYPE='radio' id='"+node.cid+"' NAME='"+node.cname+"' onclick='radioclear(this)' value='"+node.cvalue+"' nodelength='"+node.path+"' treename='"+this.name+"'cfunciton='"+node.cfunciton+"'>"+pimg+node.text + 
		  "</span></NOBR></DIV>";
	} else {
		  HTML +="<span "+
			"class='MzTreeview' hideFocus "+
			"id='"+ this.name +"_link_"+ id +"' "+
			">"+ pimg + node.text + 
		  "</span></NOBR></DIV>";
	}
	if(isRoot && node.text=="") HTML = "";


/* //原版
  HTML +="<span "+
    "class='MzTreeview' hideFocus "+
    "id='"+ this.name +"_link_"+ id +"' "+
    ">"+ node.text + 
  "</span></NOBR></DIV>";
  if(isRoot && node.text=="") HTML = "";
*/

  HTML = "\r\n<SPAN id='"+ this.name +"_tree_"+ id +"'>"+ HTML 
  HTML +="<SPAN style='DISPLAY: none'></SPAN></SPAN>";
  return HTML;
};
//根据节点的详细信息生成HTML 自动加载
//node   树在客户端的节点对象
//AtEnd  布尔值  当前要转换的这个节点是否为父节点的子节点集中的最后一项
	MTree.prototype.nodeToHTMLShow = function(node, AtEnd)
	{	
	  var source = this.nodes[node.sourceIndex];
	  var target = this.getAttribute(source, "target");
	  var data = this.getAttribute(source, "data");
	  var url  = this.getAttribute(source, "url");
	  if(!url) url = this.url;
	  if(data) url += (url.indexOf("?")==-1?"?":"&") + data;
	  if(!target) target = this.target;

	  var id   = node.id;
	  var HCN  = node.hasChild, isRoot = node.parentId=="0";
	// if(isRoot && node.icon=="") node.icon = "root";
	  //不设置节点图片时不要默认图片
	  if(node.icon !=null && node.icon !="" ){
		if(node.icon=="" || typeof(this.icons[node.icon])=="undefined")
		 node.icon = HCN ? "folder" : "file";
	  }
	  
		node.iconExpand  = AtEnd ? "└" : "├";

	  var HTML = "<DIV noWrap='True'><NOBR>";
	  if(!isRoot)
	  {
		node.childAppend = node.parentNode.childAppend + (AtEnd ? "　" : "│");
		if(this.wordLine)
		{
		  HTML += "<SPAN>"+ node.parentNode.childAppend + (AtEnd ? "└" : "├") +"</SPAN>";
		  if(HCN) HTML += "<SPAN class='pm' id='"+ this.name +"_expand_"+ id +"'>+</SPAN>";
		}
		else
		{
			//var word2imagetemp=this.word2image(node.parentNode.childAppend);
			//var src=this.icons[node.iconExpand].src;
		  node.iconExpand  = HCN ? AtEnd ? "PM2" : "PM1" : AtEnd ? "L2" : "L1";
		  HTML += "<SPAN>"+ this.word2image(node.parentNode.childAppend) +"<IMG "+
			"align='absmiddle' id='"+ this.name +"_expand_"+ id +"' "+
			"src='"+ this.icons[node.iconExpand].src+"' style='cursor: "+ (!node.hasChild ? "":
			(this.navigator=="msie"||this.navigator=="opera"? "hand" : "pointer")) +"'></SPAN>";
		}
	  }
		 if(node.icon !=null && node.icon !="")
	  if(typeof(this.icons[node.icon])!="undefined"){
	  HTML += "<IMG "+
		"align='absMiddle' "+
		"id='"+ this.name +"_icon_"+ id +"' "+
		"src='"+ this.icons[node.icon].src +"'>"
	  }

	  var ctext = this.getAttribute(source, "ctext"); // yeqw checkbox属性
	  var cid = this.getAttribute(source, "cid"); // yeqw checkbox或radio的id属性
	  var cname = this.getAttribute(source, "cname"); // yeqw checkbox或radio的name属性
	  var cvalue = this.getAttribute(source, "cvalue"); // yeqw checkbox或radio的value属性
	  var pimg = this.getAttribute(source, "pimg"); // yeqw 图片属性
	  var cfunciton = this.getAttribute(source, "cfunciton"); // yeqw 用户自定义函数属性
	  
	    var checkAction = "";
	  if(this.isCheckLink) {
	  	checkAction = "onclick='checkall(this)'";
	  }
	  
  
		if("checkbox" == ctext) {	
			  HTML +="<span "+
				"class='MzTreeview' hideFocus "+
				"id='"+ this.name +"_link_"+ id +"' "+
				">"+ "<INPUT TYPE='checkbox' id='"+node.cid+"' NAME='"+node.cname+"' " + checkAction + " value='"+node.cvalue+"' nodelength='"+node.path+"' treename='"+this.name+"' cfunciton='"+node.cfunciton+"'>"+pimg+node.text + 
			  "</span></NOBR></DIV>";
		} else if("radio" == ctext) {	
		  HTML +="<span "+
			"class='MzTreeview' hideFocus "+
			"id='"+ this.name +"_link_"+ id +"' "+
			">"+ "<INPUT TYPE='radio' id='"+node.cid+"' NAME='"+node.cname+"' onclick='radioclear(this)' value='"+node.cvalue+"' nodelength='"+node.path+"' treename='"+this.name+"' cfunciton='"+node.cfunciton+"'>"+pimg+node.text + 
		  "</span></NOBR></DIV>";
		} else {
			  HTML +="<span "+
				"class='MzTreeview' hideFocus "+
				"id='"+ this.name +"_link_"+ id +"' "+
				">"+ pimg + node.text + 
			  "</span></NOBR></DIV>";
		}
		 if(isRoot && node.text=="") HTML = "";
		  return HTML;
	};
//在使用图片的时候对 node.childAppend 的转换
MTree.prototype.word2image = function(word)
{
  var str = "";
  for(var i=0; i<word.length; i++)
  {
    var img = "";
    switch (word.charAt(i))
    {
      case "│" : img = "L4"; break;
      case "└" : img = "L2"; break;
      case "　" : img = "empty"; break;
      case "├" : img = "L1"; break;
      case "─" : img = "L3"; break;
      case "┌" : img = "L0"; break;
    }
    if(img!="")
      str += "<IMG align='absMiddle' src='"+ this.icons[img].src +"' height='20'>";
  }
  return str;
}


//将某个节点下的所有子节点转化成详细的<HTML>元素表达
//id 树的客户端节点 id
MTree.prototype.buildNode = function(id)
{
  if(this.node[id].hasChild)
  {
    var tcn = this.node[id].childNodes, str = "";
    for (var i=0; i<tcn.length; i++)
      str += this.nodeToHTML(tcn[i], i==tcn.length-1);
    var temp = this.getElementById(this.name +"_tree_"+ id).childNodes;
    temp[temp.length-1].innerHTML = str;
  }
};

//聚集到客户端生成的某个节点上
//id  客户端树节点的id
MTree.prototype.focusClientNode      = function(id)
{
  if(!this.currentNode) this.currentNode=this.node["0"];

  var a = this.getElementById(this.name +"_link_"+ id); 
  if(a){ 
    try {a.focus();} catch(err){}
  var link = this.getElementById(this.name +"_link_"+ this.currentNode.id);
  if(link)with(link.style){color="";   backgroundColor="";}
  //注掉节点聚焦时的颜色.
  //with(a.style){color = this.colors.highLightText;
  //backgroundColor = this.colors.highLight;}
  this.currentNode= this.node[id];}
};

//焦点聚集到树里的节点链接时的处理
//id 客户端节点 id
MTree.prototype.focusLink= function(id)
{
  if(this.currentNode && this.currentNode.id==id) return;
  this.focusClientNode(id);
};

//点击展开树节点的对应方法
MTree.prototype.expand   = function(id, sureExpand)
{	
  var node  = this.node[id];
 
  if (sureExpand && node.isExpand) return;
 
  if (!node.hasChild) return;
   
  var area  = this.getElementById(this.name +"_tree_"+ id);
 
  if (area)   area = area.childNodes[area.childNodes.length-1];
  if (area)
  { 
    var icon  = this.icons[node.icon];
    var iconE = this.iconsExpand[node.icon];
    var Bool  = node.isExpand = sureExpand || area.style.display == "none";
    var img   = this.getElementById(this.name +"_icon_"+ id);
    if (img)  img.src = !Bool ? icon.src :typeof(iconE)=="undefined" ? icon.src : iconE.src;
    var exp   = this.icons[node.iconExpand];
    var expE  = this.iconsExpand[node.iconExpand];
    var expand= this.getElementById(this.name +"_expand_"+ id);
    if (expand)
    {
      if(this.wordLine) expand.innerHTML = !Bool ? "+"  : "-";
      else expand.src = !Bool ? exp.src : typeof(expE) =="undefined" ? exp.src  : expE.src;
    }
    if(!Bool && this.currentNode.path.indexOf(node.path)==0 && this.currentNode.id!=id)
    {
      try{this.getElementById(this.name +"_link_"+ id).click();}
      catch(e){this.focusClientNode(id);}
    }
    area.style.display = !Bool ? "none" : "block";//(this.navigator=="netscape" ? "block" : "");
    if(!node.isLoad)
    {
      this.load(id);
      if(node.id=="0") return;

      //当子节点过多时, 给用户一个正在加载的提示语句
      if(node.hasChild && node.childNodes.length>this.nodecountToPrompt)
      {
        setTimeout(this.name +".buildNode('"+ id +"')", this.timeoutToPrompt);
        var temp = this.getElementById(this.name +"_tree_"+ id).childNodes;
        temp[temp.length-1].innerHTML = "<DIV noWrap><NOBR><SPAN>"+ (this.wordLine ?
        node.childAppend +"└" : this.word2image(node.childAppend +"└")) +"</SPAN>"+
        //屏蔽掉loading...前的图片
        //"<IMG border='0' height='16' align='absmiddle' src='"+this.icons["file"].src+"'>"+
        "<A style='background-Color: "+ this.colors.highLight +"; color: "+
        this.colors.highLightText +"; font-size: 9pt'>"+this.loadPromptInfo+"</A></NOBR></DIV>";
      }
      else this.buildNode(id);
    }
  }
};


//节点链接单击事件处理方法
//id 客户端树节点的 id
MTree.prototype.nodeClick = function(id)
{
  var source = this.nodes[this.node[id].sourceIndex];
  eval(this.getAttribute(source, "method"));
  return !(!this.getAttribute(source, "url") && this.url=="#");
};

//为配合系统初始聚集某节点而写的函数, 得到某节点在数据源里的路径
//sourceId 数据源里的节点 id
MTree.prototype.getPath= function(sourceId)
{
  
Array.prototype.indexOf = function(item)
  {
    for(var i=0; i<this.length; i++)
    {
      if(this[i]==item) return i;
    }
    return -1;
  };
  var _d = this._d, d = this.divider;
  var A = new Array(), id=sourceId; A[0] = id;
  while(id!="0" && id!="")
  {
    var str = "(^|"+_d+")([^"+_d+d+"]+"+d+ id +")("+_d+"|$)";
    if (new RegExp(str).test(this.names))
    {
      id = RegExp.$2.substring(0, RegExp.$2.indexOf(d));
      if(A.indexOf(id)>-1) break;
      A[A.length] = id;
    }
    else break;
  }
  return A.reverse();
};

//在源代码里指定 MzTreeView 初始聚集到某个节点
//sourceId 节点在数据源里的 id
MTree.prototype.focus = function(sourceId, defer)
{	
  if (!defer)
  {
    setTimeout(this.name +".focus('"+ sourceId +"', true)", 100);
    return;
  }
  var path = this.getPath(sourceId);
 
  if(path[0]!="0")
  {
    //alert("节点 "+ sourceId +" 没有正确的挂靠有效树节点上！\r\n"+
      //"节点 id 序列 = "+ path.join(this.divider));
    return;
  }
  var root = this.node["0"], len = path.length;
  var tt = "";
  for(var i=1; i<len; i++)
  {
    if(root.hasChild)
    {	
      var sourceIndex= path[i-1] + this.divider + path[i];
      for (var k=0; k<root.childNodes.length; k++)
      {
        if (root.childNodes[k].sourceIndex == sourceIndex)
        {
          root = root.childNodes[k];
          if(i<len - 1) this.expand(root.id, true);
          
          else this.focusClientNode(root.id);tt+=";"+sourceIndex;
          break;
        }
      }
    }
  }
};

//树的单击事件处理函数
MTree.prototype.clickHandle = function(e)
{	
  e = window.event || e; e = e.srcElement || e.target;
  
  switch(e.tagName)
  {
    case "IMG" :
      if(e.id)

	{	
        if(e.id.indexOf(this.name +"_icon_")==0)
          this.focusClientNode(e.id.substr(e.id.lastIndexOf("_") + 1));
        else if (e.id.indexOf(this.name +"_expand_")==0)
          this.expand(e.id.substr(e.id.lastIndexOf("_") + 1));
      }
      break;
    case "A" :
      if(e.id) this.focusClientNode(e.id.substr(e.id.lastIndexOf("_") + 1));
      break;
    case "SPAN" :
      if(e.className=="pm")
        this.expand(e.id.substr(e.id.lastIndexOf("_") + 1));
      break;
    default :
      if(this.navigator=="netscape") e = e.parentNode;
      if(e.tagName=="SPAN" && e.className=="pm")
        this.expand(e.id.substr(e.id.lastIndexOf("_") + 1));
      break;
  }
};

//MzTreeView 双击事件的处理函数
MTree.prototype.dblClickHandle = function(e)
{
  e = window.event || e; e = e.srcElement || e.target;
  if((e.tagName=="A" || e.tagName=="IMG")&& e.id)
  {
    var id = e.id.substr(e.id.lastIndexOf("_") + 1);
    if(this.node[id]){
    	if(this.node[id].hasChild){
    		this.expand(id);
    	}
    }
  }
};

//回到树当前节点的父层节点
MTree.prototype.upperNode = function()
{
  if(!this.currentNode) return;
  if(this.currentNode.id=="0" || this.currentNode.parentId=="0") return;
  if (this.currentNode.hasChild && this.currentNode.isExpand)
    this.expand(this.currentNode.id, false);
  else this.focusClientNode(this.currentNode.parentId);
};

//展开当前节点并
MTree.prototype.lowerNode = function()
{
  if (!this.currentNode) this.currentNode = this.node["0"];
  if (this.currentNode.hasChild)
  {
    if (this.currentNode.isExpand)
      this.focusClientNode(this.currentNode.childNodes[0].id);
    else this.expand(this.currentNode.id, true);
  }
}

//聚集到树当前节点的上一节点
MTree.prototype.pervNode = function()
{
  if(!this.currentNode) return; var e = this.currentNode;
  if(e.id=="0") return; var a = this.node[e.parentId].childNodes;
  for(var i=0; i<a.length; i++){if(a[i].id==e.id){if(i>0){e=a[i-1];
  while(e.hasChild){this.expand(e.id, true);
  e = e.childNodes[e.childNodes.length - 1];}
  this.focusClientNode(e.id); return;} else {
  this.focusClientNode(e.parentId); return;}}}
};

//聚集到树当前节点的下一节点
MTree.prototype.nextNode = function()
{
  var e = this.currentNode; if(!e) e = this.node["0"];
  if (e.hasChild){this.expand(e.id, true);
  this.focusClientNode(e.childNodes[0].id); return;}
  while(typeof(e.parentId)!="undefined"){
  var a = this.node[e.parentId].childNodes;
  for(var i=0; i<a.length; i++){ if(a[i].id==e.id){
  if(i<a.length-1){this.focusClientNode(a[i+1].id); return;}
  else e = this.node[e.parentId];}}}
};

//展开树的所有节点
MTree.prototype.expandAll = function()
{
  if(this.totalNode>500) 
	//if(confirm("您是否要停止展开全部节点？\r\n\r\n节点过多！展开很耗时")) return;
  if(this.node["0"].childNodes.length==0) return;
  var e = this.node["0"].childNodes[0];
  var isdo = t = false;
  while(e.id != "0")
  {
    var p = this.node[e.parentId].childNodes, pn = p.length;
    if(p[pn-1].id==e.id && (isdo || !e.hasChild)){e=this.node[e.parentId]; isdo = true;}
    else
    {
      if(e.hasChild && !isdo)
      {
        this.expand(e.id, true), t = false;
        for(var i=0; i<e.childNodes.length; i++)
        {
          if(e.childNodes[i].hasChild){e = e.childNodes[i]; t = true; break;}
        }
        if(!t) isdo = true;
      }
      else
      {
        isdo = false;
        for(var i=0; i<pn; i++)
        {
          if(p[i].id==e.id) {e = p[i+1]; break;}
        }
      }
    }
  }
};
//是否自动加载
MTree.prototype.setAutoReload  = function(autoReload){
		this.autoReload=autoReload;
}
//本树将要用动的图片的字义及预载函数
//path 图片存放的路径名
MTree.prototype.setIconPath  = function(path)
{
  var k = 0, d = new Date().getTime();
  for(var i in this.icons)
  {
    var tmp = this.icons[i];
    this.icons[i] = new Image();
    this.icons[i].src = path + tmp;
    //if(k==9 && (new Date().getTime()-d)>20)
      //this.wordLine = true; k++;
  }
  for(var i in this.iconsExpand)
  {
    var tmp = this.iconsExpand[i];
    this.iconsExpand[i]=new Image();
    this.iconsExpand[i].src = path + tmp;
  }
};
MTree.prototype.setTreeName=function(Tname){
	if(typeof(Tname) != "string" || Tname == "")
    throw(new Error(-1, '创建类实例的时候请把类实例的引用变量名传递进来！'));
	this.name=Tname;
	treename = Tname;
};
MTree.prototype.setIsCheckLink=function(isCheckLink){
	this.isCheckLink = isCheckLink;
};
MTree.prototype.setPromptInfo=function(promptInfo){
	this.loadPromptInfo=promptInfo;
};
MTree.prototype.setNodecountToPrompt=function(count){
	this.nodecountToPrompt=count;
};
MTree.prototype.setAutoReload=function(reload){
	this.autoreload=reload;
};
//设置树的默认链接
//url 默认链接  若不设置, 其初始值为 #
MTree.prototype.setURL     = function(url){this.url = url;};

//设置树的默认的目标框架名 target
//target 目标框架名  若不设置, 其初始值为 _self
MTree.prototype.setTarget  = function(target){this.target = target;};







/** *///~~


// -->

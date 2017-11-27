function changelevels(v, d, l, groupid, logined_user_level,groupfunc){
	var groupobj = document.getElementById(groupid+l);	
	var selects = document.getElementsByTagName('select');
	for(var i=0; i<selects.length; i++){
		if(selects[i].name.indexOf(groupid)==0&&selects[i].name.substring(groupid.length)>=l){
			selects[i].parentNode.removeChild(selects[i]);
			i--;
		}
	}
	if(groupobj==null){
		groupobj = document.createElement("select");
		groupobj.style.width="150px";
		//groupobj.onchange="changelevels(this.value,"+d+","+(l+1)+","+groupid+","+logined_user_level+")";
		if(window.addEventListener) // Mozilla, Netscape, Firefox 
		{
			groupobj.addEventListener('change', function (){
				changelevels(this.value,d,l+1,groupid,logined_user_level,groupfunc);
				if(groupfunc!='')
					eval(groupfunc);
			},false); 
		}
		else// IE 
		{ 
			groupobj.attachEvent('onchange',function (){
				changelevels(this.value,d,l+1,groupid,logined_user_level,groupfunc);
				if(groupfunc!='')
					eval(groupfunc);
			}); 
		} 
		groupobj.id = groupid+l;
		groupobj.name = groupid+l;
	}
	groupobj.options.length=0;
	var parentobj = document.getElementById(groupid+(l-1));
	var selOption = null;
	if(l>logined_user_level){
		selOption = document.createElement("option");  
		selOption.value = "0";  
		selOption.innerHTML = "请选择";
		groupobj.appendChild(selOption);
	}
	var found = 0;
	for(var i=0; i<servergroup.length; i++){
		if(servergroup[i].ldapid==v){
			selOption = document.createElement("option");  
			selOption.value = servergroup[i].id;  
			selOption.innerHTML = servergroup[i].name;
			if(servergroup[i].id==d){
				selOption.selected = true;
			}
			groupobj.appendChild(selOption);
			found++;
		}
	}	
	if(found>0)
	parentobj.parentNode.appendChild(groupobj);
}

function showTree(item,valueId){
	
	var direction = arguments[2] ? arguments[2] : 'down';
	if(document.getElementById(valueId+"combdtree").style.display=='none' || document.getElementById(valueId+"combdtree").style.display==''){
		var x = getLeft(item);
		var y = getTop(item) + item.offsetHeight;
		var w = item.offsetWidth;
		if(direction=='up'){
			y=y-460;
		}
		blockDTree(x,y,w,valueId);
	}else{
		hiddenDTree(valueId)
	}
}

function getTop(e){ 
	var offset=e.offsetTop;
	if(e.offsetParent!=null) offset+=getTop(e.offsetParent); 
	return offset; 
} 

function getLeft(e){ 
	var offset=e.offsetLeft; 
	if(e.offsetParent!=null) offset+=getLeft(e.offsetParent); 
	return offset; 
} 
function blockDTree(x,y,w,valueId){
	var item = document.getElementById(valueId+"combdtree");
	item.style.display = 'block';
	item.style.top = y;
	item.style.left = x;
	if(window.parent!=null&&window.parent!=undefined)
		window.parent.reinitIframe();
}
function hiddenDTree(valueId){
	var item = document.getElementById(valueId+"combdtree");
	if(item){
		item.style.display = 'none';
	}
}
function checkedChild(c, groupid, child){
	var child_arr = child.split(',');
	for(var i=0; i<child_arr.length; i++){
		if(document.getElementById(groupid+'_group_'+child_arr[i])!=undefined){
			document.getElementById(groupid+'_group_'+child_arr[i]).checked = c;
		}
	}
}
function setSrcValue(text,value, groupid, setpop, multipleselect, groupmanagerids){
	if(groupmanagerids!=""){
		if(value>0){
			if((value+"").indexOf(',')>0){
				var value_arr = value.split(',');
				for(var i=0; i<value_arr.length; i++){
					if(groupmanagerids.indexOf(','+value_arr[i]+',')<0){
						alert('没有权限选择该节点');
						return ;
					}
				}				
			}else{
				if(groupmanagerids.indexOf(','+value+',')<0){
					alert('没有权限选择该节点');
					return ;
				}
			}
		}
	}
	if(multipleselect==1){
		var inputs = document.getElementsByTagName("input");
		var namestr="";
		var idstr="";		
		
		for(var i=0; i<inputs.length; i++){
			if(inputs[i].name==groupid+'_group[]'&&inputs[i].checked){
				idstr += inputs[i].value.substring(0, inputs[i].value.indexOf('_'))+',';
				namestr += inputs[i].value.substring(inputs[i].value.indexOf('_')+1)+',';
			}
		}
		if(setpop==1){
			document.getElementById(groupid+'pop').value = namestr.substring(0,namestr.length-1);
		}
		document.getElementById(groupid+'h').value = idstr.substring(0,idstr.length-1);
	}else{
		if(setpop==1){
			document.getElementById(groupid+'pop').value = text;
		}
		document.getElementById(groupid+'h').value = value;
		hiddenDTree(groupid);
	}
}

function copyToClipboard(txt) {

    if (window.clipboardData) {

        window.clipboardData.clearData();

        window.clipboardData.setData("Text", txt);

        alert("已经成功复制到剪帖板上！");

    } else if (navigator.userAgent.indexOf("Opera") != -1) {

        window.location = txt;

    } else if (window.netscape) {

        try {

            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");

        } catch (e) {

            alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将'signed.applets.codebase_principal_support'设置为'true'");

        }

        var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);

        if (!clip) return;

        var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);

        if (!trans) return;

        trans.addDataFlavor('text/unicode');

        var str = new Object();

        var len = new Object();

        var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);

        var copytext = txt;

        str.data = copytext;

        trans.setTransferData("text/unicode", str, copytext.length * 2);

        var clipid = Components.interfaces.nsIClipboard;

        if (!clip) return false;

        clip.setData(trans, null, clipid.kGlobalClipboard);

        alert("已经成功复制到剪帖板上！");

    }

}


 

var isSupported = false;
function noinstall(url){//alert(isSupported);
	if(!isSupported){
		alert("请安装启动程序");
	}
}
function launcher(url){
	var explorer = window.navigator.userAgent ;
	var hidden = document.getElementById('hide');
	//ie 
	if (/(msie\s|trident.*rv:)([\w.]+)/.exec(explorer.toLowerCase())!=null) {
		//alert("ie");
		if(typeof(navigator.msLaunchUri)=='function'){			
			navigator.msLaunchUri(url,  function(){//alert('success');
				}, function() {	//alert('failed');
					isSupported = false;
					noinstall(url);
				});
		}else{
			window.parent.location=url;
			//document.getElementById('hide').src=url;
			/*
			 var w = window.open(url, 'xyz', 'status=0,toolbar=0,menubar=0,height=0,width=0,top=-10,left=-10');
			if(w == null) {            
				w.close();
				//Work Fine
				//window.parent.location = url;
			}
			else {
				w.close();
				if (confirm('You Need a Custom Program. Do you want to install?')) {
					 //URL for installer
				}
			}*/
		}
	}
	//firefox 
	else if (explorer.indexOf("Firefox") >= 0) {
		//alert("Firefox");
		try{
			hidden.contentWindow.location.href = url;
			isSupported = true;
		}catch(e){
			//FireFox
			if (e.name == "NS_ERROR_UNKNOWN_PROTOCOL"){
				noinstall(url);
			}
		}
	}
	//Chrome
	else if(explorer.indexOf("Chrome") >= 0){
		//alert("Chrome");
		protcolEl = $('#protocol')[0];	
		isSupported = false;
		protcolEl.style.display='';
		protcolEl.focus();
		protcolEl.onblur = function(){
			isSupported = true;
		};
		location.href = url;
		setTimeout(function(){
			protcolEl.onblur = null;
			//noinstall(url);
			protcolEl.style.display='none';
		}, 1000);
	}
	//Opera
	else if(explorer.indexOf("Opera") >= 0){
		alert("Opera");
	}
	//Safari
	else if(explorer.indexOf("Safari") >= 0){
		hidden.contentWindow.location.href = url;
	}
}
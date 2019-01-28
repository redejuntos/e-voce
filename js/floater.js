var persistclose=0 //set to 0 or 1. 1 means once the bar is manually closed, it will remain closed for browser session

var verticalpos="fromtop" //enter "fromtop" or "frombottom"

function iecompattest(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}


function staticbar(width,height,startX,startY){	
	if (persistclose==0 ){
		barheight=height;
		var ns = (navigator.appName.indexOf("Netscape") != -1) || window.opera;
		var d = document;	
	
	
		function ml(id){		
			var el=d.getElementById(id);
			if(d.layers)el.style=el;
			el.sP=function(x,y){this.style.left=x+"px";this.style.top=y+"px";};
			el.x = startX;
			if (verticalpos=="fromtop")
			el.y = startY;
			else{
				el.y = ns ? pageYOffset + innerHeight : iecompattest().scrollTop + iecompattest().clientHeight;
				el.y -= startY;
			}
			return el;
		}
			
		window.stayTopLeft=function(){
			if (verticalpos=="fromtop"){
				var pY = ns ? pageYOffset : iecompattest().scrollTop;
				ftlObj.y += (pY + startY +22- ftlObj.y)/8;
				ftlObj2.y += (pY + startY - ftlObj2.y)/8;
			}else{
				var pY = ns ? pageYOffset + innerHeight - barheight: iecompattest().scrollTop + iecompattest().clientHeight - barheight;
				ftlObj.y += (pY - startY - ftlObj.y)/8;
				ftlObj2.y += (pY - startY - ftlObj2.y)/8;
			}
			ftlObj.sP(ftlObj.x, ftlObj.y);
			ftlObj2.sP(ftlObj2.x, ftlObj2.y);
			setTimeout("stayTopLeft()", 10);
		}
		ftlObj = ml("GB_window");
		ftlObj2 = ml("GB_header");
		stayTopLeft();
	}
}

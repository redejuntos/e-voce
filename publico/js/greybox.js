 /****
 GreyBox - The pop-up window thingie
   Copyright Amir Salihefendic 2006
 AUTHOR
   4mir Salihefendic (http://amix.dk) - amix@amix.dk
 VERSION
	 1.31 (10/02/06 20:59:07)
 LICENSE
  LGPL (read more in LGPL.txt)
 SITE
   http://amix.dk/greybox
****/
var GB_HEADER = null;
var GB_WINDOW = null;
var GB_IFRAME = null;
var GB_OVERLAY = null;
var GB_TIMEOUT = null;
var GB_HEIGHT = 400;
var GB_WIDTH = 400;

var GB_caption = null;

function GB_show(caption, url /* optional */, height, width,tipo) {	


hide_select_combo();
  if(height != 'undefined')
    GB_HEIGHT = height;
  if(width != 'undefined')
    GB_WIDTH = width;

  initIfNeeded();

  GB_caption.innerHTML = '<font size="2" face="Verdana, Arial, Helvetica, sans-serif">'+caption+'</font>';

  if(GB_ANIMATION) {
    //22 is for header height
    GB_HEADER.style.top = -(GB_HEIGHT) + "px";
    GB_WINDOW.style.top = -(GB_HEIGHT+22) + "px";
  }

  showElement(GB_OVERLAY);
  showElement(GB_HEADER);
  showElement(GB_WINDOW);

  GB_IFRAME.src = url;
  GB_IFRAME.opener = this;

  GB_position(tipo);

  if(GB_ANIMATION) {
    GB_animateOut(-GB_HEIGHT,tipo);
  }


var startX = parseInt(GB_position(tipo)); //set x offset of bar in pixels
var startY = parseInt(90.1); //set y offset of bar in pixels

staticbar(width,height,startX,startY);

//  parent.top.cadastro.grid_iframe.after_greybox();


}

function GB_hide() {
  GB_IFRAME.href = "about:blank";
  hideElement(GB_WINDOW);
  hideElement(GB_HEADER);
  hideElement(GB_OVERLAY);
  show_select_combo();
   persistclose = 1;

  
}


function GB_animateOut(top,tipo) {
  if(top < 0) {
    GB_WINDOW.style.top = (top+22+document.body.scrollTop) + "px";
    GB_HEADER.style.top = top + "px";
    GB_TIMEOUT = window.setTimeout(function() { GB_animateOut(top+50,tipo); }, 1);
  }
  else {
	  
	(tipo=="c")? centraliza=150:centraliza=0;  
    GB_WINDOW.style.top = 22 + centraliza +document.body.scrollTop + "px";
    GB_HEADER.style.top = centraliza + document.body.scrollTop + "px";
    clearTimeout(GB_TIMEOUT);
  }
  

  
}

function GB_position(tipo) {
  var array_page_size = GB_getWindowSize();

  GB_IFRAME.style.overflow = 'hidden';
  GB_WINDOW.style.overflow = 'hidden';
  GB_HEADER.style.overflow = 'hidden';
  
if (tipo!=undefined){
  (tipo=="c")? ajuste_janela=0:ajuste_janela=10; 
  //Set size  
  GB_WINDOW.style.width = GB_WIDTH + "px";
  GB_IFRAME.style.width = GB_WIDTH - ajuste_janela + "px";
  GB_HEADER.style.width = GB_WIDTH + "px";
}

  GB_WINDOW.style.height = GB_HEIGHT + "px";
  GB_IFRAME.style.height = GB_HEIGHT - 5 + "px";

  GB_OVERLAY.style.width = array_page_size[0] + "px";

  var max_height = Math.max(array_page_size[1], GB_HEIGHT+30+400 + document.body.scrollTop );
  GB_OVERLAY.style.height =  max_height + "px";

  GB_WINDOW.style.left = ((array_page_size[0] - GB_WINDOW.offsetWidth) /2) + "px";
  GB_HEADER.style.left = ((array_page_size[0] - GB_HEADER.offsetWidth) /2) + "px";
  
  return ((array_page_size[0] - GB_HEADER.offsetWidth) /2);
}

function GB_init() {
  //Create the overlay
  GB_OVERLAY = DIV({'id': 'GB_overlay'});

  if(GB_overlay_click_close)
    GB_OVERLAY.onclick = GB_hide;

  getBody().insertBefore(GB_OVERLAY, getBody().firstChild);



  //Create the window  
  GB_WINDOW = DIV({'id': 'GB_window'});
  GB_HEADER = DIV({'id': 'GB_header'});
  GB_caption = DIV({'id': 'GB_caption'}, "");
  
  

  var close = DIV({'id': 'GB_close'}, IMG({'src': '../images/close.gif', 'alt': 'Fechar Janela'}));
  close.onclick = GB_hide;
  ACN(GB_HEADER, close, GB_caption);

  getBody().insertBefore(GB_WINDOW, GB_OVERLAY.nextSibling);
  getBody().insertBefore(GB_HEADER, GB_OVERLAY.nextSibling);

  
}

function initIfNeeded() {
  if(GB_OVERLAY == null) {
    GB_init();
    GB_addOnWinResize(GB_position);
  } 
  new_stuff = IFRAME({'id': 'GB_frame', 'name': 'GB_frame'});
  RCN(GB_WINDOW, new_stuff);
  GB_IFRAME = new_stuff;
}

function GB_getWindowSize(){
	var window_width, window_height;
	if (self.innerHeight) {	// all except Explorer
		window_width = self.innerWidth;
		window_height = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		window_width = document.documentElement.clientWidth;
		window_height = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		window_width = document.body.clientWidth;
		window_height = document.body.clientHeight;
	}	
	return [window_width, window_height];
}

function GB_addOnWinResize(func) {
  var oldonrezise = window.onresize;
  if (typeof window.onresize != 'function')
    window.onresize = func;
  else {
    window.onresize = function() {
      oldonrezise();
      func();
    }
  }
}


function  hide_select_combo(){
var x = document.getElementsByTagName("select");

for (i = 0; i < x.length; i++) {
   x[i].style.display = "none";
// or
// x[i].style.visibility = "hidden"
}
}

function  show_select_combo(){
var x = document.getElementsByTagName("select");

for (i = 0; i < x.length; i++) {
   x[i].style.display = "inline";
// or
// x[i].style.visibility = "hidden"
}
}

//TROCA IMAGENS DO MENU
function switchImage(imgId, imgSrc) 
{
	document.getElementById(imgId).src = imgSrc;
}

/* PRE-LOAD IMAGES */
function simplePreload()
{ 
	var args = simplePreload.arguments;
	document.imageArray = new Array(args.length);

	for(var i=0; i<args.length; i++)
	{
		document.imageArray[i] = new Image;
		document.imageArray[i].src = args[i];
	}
}

//animação menu
jQuery.noConflict();
jQuery(function() { 
	jQuery(document).ready(function(){
		//adicionando o evento click a todos os links que estão na primeira ul dentro da div menu
		jQuery('#menu').find('ul:eq(0)> li > a').click(function(){
			//adicionando o efeito ao elemento ul que está dentro da mesma li do link que foi clicado
			jQuery(this).parent().find('ul:eq(0)').slideToggle("slow");
		});
	});
});



function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}


//some e aparece div
function change(id){
     ID = document.getElementById(id);
    
     if(ID.style.display == "")
          ID.style.display = "none";
     else
          ID.style.display = "";
      }

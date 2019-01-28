
// AJAX ********AJAX***********AJAX********AJAX ********AJAX***********AJAX********


/*
 	function showSuccessToast(msg) {
        $().toastmessage('showSuccessToast', msg);
    }
	*/
	
    function showSuccessToast(msg) {
        $().toastmessage('showToast', {
            text     : msg,
            sticky   : false,
            position : 'top-left',
            type     : 'success',
            closeText: '',
            close    : function () {
                console.log("toast is closed ...");
            }
        });
    }
	
	
    function showStickySuccessToast(msg) {
        $().toastmessage('showToast', {
            text     : msg,
            sticky   : false,
            position : 'top-left',
            type     : 'success',
            closeText: '',
            close    : function () {
                console.log("toast is closed ...");
            }
        });
    }
	
	
	
    function showNoticeToast() {
        $().toastmessage('showNoticeToast', "Notice  Dialog which is fading away ...");
    }
    function showStickyNoticeToast() {
        $().toastmessage('showToast', {
             text     : 'Notice Dialog which is sticky',
             sticky   : true,
             position : 'top-right',
             type     : 'notice',
             closeText: '',
             close    : function () {console.log("toast is closed ...");}
        });
    }
	/*
    function showWarningToast(msg) {
        $().toastmessage('showWarningToast', msg);
    }*/
	
    function showWarningToast(msg) {
        $().toastmessage('showToast', {
            text     : msg,
            sticky   : false,
            position : 'top-left',
            type     : 'warning',
            closeText: '',
            close    : function () {
                console.log("toast is closed ...");
            }
        });
    }
	
	
    function showStickyWarningToast2(msg) {
        $().toastmessage('showToast', {
            text     : msg,
            sticky   : false,
            position : 'top-left',
            type     : 'warning',
            closeText: '',
            close    : function () {
                console.log("toast is closed ...");
            }
        });
    }
	/*
    function showErrorToast(msg) {
        $().toastmessage('showErrorToast', msg);
    }*/
    function showErrorToast(msg) {
        $().toastmessage('showToast', {
            text     : msg,
            sticky   : false,
            position : 'top-left',
            type     : 'error',
            closeText: '',
            close    : function () {
                console.log("toast is closed ...");
            }
        });
    }
	
	
	
    function showStickyErrorToast(msg) {
        $().toastmessage('showToast', {
            text     : msg,
            sticky   : false,
            position : 'top-left',
            type     : 'error',
            closeText: '',
            close    : function () {
                console.log("toast is closed ...");
            }
        });
    }

















function trim(str){
	if (str) {
		return str.replace(/^\s*|\s*$/g,"");
	}else{
		return "";
	}
}

function check_radio_box(form,campo){
	if (
		(form.elements[campo][0].checked == false)&&
		(form.elements[campo][1].checked == false)
		){
		alert("Selecione Primeiro o Tipo de Pessoa");
		form.elements[campo][0].focus();
		return false;
	}else{
		return true;
	} 
}









function handleHttpQuestion(){//para retornar num select
	if (http.readyState == 4) {		
		//alert(http.responseText);
		
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}
		
		return false;
	}
}


 
 
 
function no_image(string) {
	return string.replace(/<img[^>]+>/gi, '');
}


function no_tags(string) {
	return string.replace(/<\/?[^>]+>/gi, '');
}

function zero_esquerda(obj){
        // pega o valor inserido no campo.
        var campo = obj.value;
        // concatena 10 zeros a esquerda do valor inserido no campo.                    
        campo = "00" + campo;
        // no substring pega os últimos 2 digitos.
        var campoFormatado = campo.substring(campo.length - 2, campo.length);
        // passa o campo formatado para o seu TextBox.
        obj.value = campoFormatado;
}



function check_mascara_cnpf_cnpj(form,obj,e,campo){
			check_radio_box(form,campo);
	
		  if (form.elements[campo][1].checked == true){  //CPF		
			  txtBoxFormat(form, obj.name, '999.999.999-99', e);
			  obj.maxLength=14;
			  return sonumero(e);
		  }else{ //CNPJ	
			  if (form.elements[campo][0].checked == true){  //Cnpj
					txtBoxFormat(form, obj.name, '99.999.999/9999-99', e);
					obj.maxLength=18;
					return sonumero(e);		
			  }else{
					obj.maxLength=14;
					return sonumero(e);	
			  
			  }
		  }	
	
}



//incluindo um arquivo com a função include()
//include("arquivo.js");
function include(file_path){
	  var j = document.createElement("script"); /* criando um elemento script: </script><script></script> */
	  j.type = "text/javascript"; /* informando o type como text/javacript: <script type="text/javascript"></script>*/
	  j.src = file_path; /* Inserindo um src com o valor do parâmetro file_path: <script type="javascript" src="+file_path+"></script>*/
	  document.body.appendChild(j); /* Inserindo o seu elemento(no caso o j) como filho(child) do  BODY: <html><body><script type="javascript" src="+file_path+"></script></body></html> */
}


//incluindo um arquivo com a função include_once()
//include_once("arquivo.js");
function include_once(file_path) {
	  var sc = document.getElementsByTagName("script");
	  for (var x in sc)
	 	 if (sc[x].src != null & sc[x].src.indexOf(file_path) != -1) return;
	  include(file_path);
}



function limpa_campo(form,campo){
	form.elements[campo].value = "";
}


function set_label(value){	
	var label = document.getElementById("tipo_pessoa_label");
	label.innerHTML = value;	
}



function valida_cpf_cnpj(obj,form,campo){	
	if (form.elements[campo][1].checked == true){  //CPF
		validaCPF(obj);
	}else{ //CNPJ
			if (form.elements[campo][0].checked == true){  //CPF			
				validaCNPJ(obj);
			}
	}	
}


function formatavalorCEP(src, campo) {
  if (campo.search("-") != -1) {
	pre = campo.slice(0, campo.indexOf("-"));
	suf = campo.slice(campo.indexOf("-") + 1 , campo.length);
    campo = pre.concat(suf)
  }
  campo = campo.slice(0,8);
  pre = campo.slice(0, campo.length - 3);
  suf = campo.slice(campo.length - 3, campo.length);
  if (campo.length > 4)
    src.value = pre.concat("-").concat(suf);
  else
    src.value = pre.concat(suf);
}


function so_numero_tel(e) { 	
	if(document.all) { // Internet Explorer	
		if(event.keyCode > 57 || (event.keyCode < 47 && event.keyCode > 45) || (event.keyCode < 44 && event.keyCode > 41) || (event.keyCode < 40 && event.keyCode > 32) || event.keyCode < 32 ) event.keyCode = 0;
	} else { // firefox				
	  if ( e.charCode != 0){	
		  var caract = new RegExp(/^[-0-9 ,()]+$/i);
		  var str = String.fromCharCode(e.charCode)
		  var caract = caract.test(str);		
		  if(!caract){
		  //    alert("Caracter inválido: " +  str );		        
			  return false;
		  }
	  }
	}	
}

function sonumero(e) {
	  if(document.all) { // Internet Explorer
		  if(e.keyCode < 48 || e.keyCode > 57) e.keyCode = 0;
	  } else { // firefox	
		  if (e.charCode != 0){			
			  var caract = new RegExp(/^[0-9]+$/i);
			  var str = String.fromCharCode(e.charCode)
			  var caract = caract.test(str);		  
			  if(!caract){
			  //alert("Caracter inválido: " +  str );
				  return false;
			  }	
		  }
	  }
}


function coord_xy(e) {
	
	  if(document.all) { // Internet Explorer
		  if((e.keyCode < 48 || e.keyCode > 57)&&(e.keyCode != 46) )e.keyCode = 0;
	  } else { // firefox	
		  if ( e.charCode != 0){			
			  var caract = new RegExp(/^[\.0-9]+$/i);
			  var str = String.fromCharCode(e.charCode)
			  var caract = caract.test(str);		  
			  if(!caract){
			  //alert("Caracter inválido: " +  str );
				  return false;
			  }	
		  }
	  }
}


function check_telefone(e) { 	

	if(document.all) { // Internet Explorer
		var str = String.fromCharCode(event.keyCode)		
		 var c = /^[-0-9 \(\)]+$/;
		 if ( str.search( c ) == -1 ) {
			 event.keyCode = 0;
		 }   

	} else { // firefox	
		
		if ( e.charCode != 0){	
			var caract = new RegExp(/^[-0-9 \(\)]+$/i);
			var str = String.fromCharCode(e.charCode)
			var caract = caract.test(str);		
			if(!caract){
			  //alert("Caracter inválido: " +  str );		
			  return false;
			}
		}
		
	}	
}


function sonumero_rg(e) { 	
	if(document.all) { // Internet Explorer
		var str = String.fromCharCode(event.keyCode)		
		 var c = /^[a-zA-Z0-9]+$/;
		 if ( str.search( c ) == -1 ) {
			 event.keyCode = 0;
		 }   

	} else { // firefox		
		if ( e.charCode != 0){	
			var caract = new RegExp(/^[a-zA-Z0-9 ]+$/i);
			var str = String.fromCharCode(e.charCode)
			var caract = caract.test(str);		
			if(!caract){
				//alert("Caracter inválido: " +  str );		
				return false;
			}
		}
	}	
}



function number_format( number, decimals, dec_point, thousands_sep ) {
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: number_format(1234.5678, 2, '.', '');
    // *     returns 1: 1234.57
 
    var i, j, kw, kd, km;
 
    // input sanitation & defaults
    if( isNaN(decimals = Math.abs(decimals)) ){
        decimals = 2;
    }
    if( dec_point == undefined ){
        dec_point = ",";
    }
    if( thousands_sep == undefined ){
        thousands_sep = ".";
    }
 
    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";
 
    if( (j = i.length) > 3 ){
        j = j % 3;
    } else{
        j = 0;
    }
 
    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
 
 
    return km + kw + kd;
}

function checanum(campo){
	straux = campo.value + '#';
	i = 0;
	while (straux.charAt(i)!='#'){
		if ( ( (straux.charAt(i)>='0') && (straux.charAt(i)<='9') ) || (straux.charAt(i)=='-') || (straux.charAt(i)=='.'))
		i++;
		else{
		//  alert('Este campo deve ser numérico.');	   
		campo.value = campo.value.substring(0, campo.value.length - 1)	   
		// campo.value = '';
		campo.focus();
		return false;
		}
	}
	return true;
}

function converte_data($data){
	var $A = Array();	
	var $V_data;
	if ($data.search("/")>=0){
		$A =  $data.split("/");
		$V_data = $A[2] + "-"+ $A[1] + "-" + $A[0];
	}
	else{
		$A = $data.split("-");
		$V_data = $A[2] + "/"+ $A[1] + "/" + $A[0];	
	}
	return $V_data;
}



function close_windows(){
	var el = document.getElementsByTagName("DIV");	
	var time = 0;
	for (var y in el){		
		if(y != el[y].id.toString()){ // corrige bug do firefox
			if(el[y].id){
				  if( el[y].id.toString().indexOf("Container") == 0){					  
						var id = el[y].id;					
						if (el[y].childNodes[0].style.display != "none"){						
							el[y].childNodes[0].style.display = "none";
						}
				  }	
			}
		}
	}	
}






function distribuir_windows(){
	var el = document.getElementsByTagName("DIV");	
	var time = 0;
	var add_height = 0;	add_height1 = 0;	add_height2 = 0;	add_width2 = 0;
	for (var y in el){		
		if(y != el[y].id.toString()){ // corrige bug do firefox
			if(el[y].id){
				  if( el[y].id.toString().indexOf("Container") == 0){					  
						var id = el[y].id;					
						if (el[y].childNodes[0].style.display != "none"){
							time++;								
							if (time % 2 == 0){		//coluna da direita
								add_height = add_height2;
								add_width = add_width2;	
								add_height2  += parseFloat(el[y].childNodes[0].style.height.replace("px",""));	
							}else{				 //coluna da esquerda
								add_height = add_height1;
								add_width = '0';			
								add_width2 = el[y].childNodes[0].style.width;	
								add_height1  += parseFloat(el[y].childNodes[0].style.height.replace("px",""));	
							}		
							set_distribuir_windows(id,time,add_width,add_height);
							
						}
				  }	
			}
		}
	}	
}

function distribuir_windows_in_3_colunas(){
	var el = document.getElementsByTagName("DIV");	
	var time = 0;
	var coluna= 1;
	var add_width =0;add_height = 0;	add_height1 = 0;	add_height2 = 0;	add_width2 = 0;add_height3 = 0;	add_width3 = 0;
	for (var y in el){		
		if(y != el[y].id.toString()){ // corrige bug do firefox
			if(el[y].id){
				  if( el[y].id.toString().indexOf("Container") == 0){					  
						var id = el[y].id;					
						if (el[y].childNodes[0].style.display != "none"){
							time++;								
							switch (coluna){
								  case 1: 	 //coluna da esquerda								  
									  add_height = add_height1;
									  add_width = '0';			
									  add_width2 = el[y].childNodes[0].style.width;	
									  add_height1  += parseFloat(el[y].childNodes[0].style.height.replace("px",""));
									  break;
								  case 2:   //coluna do meio
									  add_height = add_height2;
									  add_width = parseFloat(add_width2);	
									  add_width3 = parseFloat(el[y].childNodes[0].style.width) +parseFloat(add_width2);
									  add_height2  += parseFloat(el[y].childNodes[0].style.height.replace("px",""));	
									  break;
								  case 3://coluna da direita
									  add_height = add_height3;
									  add_width = add_width3;	
									  add_height3  += parseFloat(el[y].childNodes[0].style.height.replace("px",""));	
									  break;
								  default:
									  break;
							}					
							
							set_distribuir_windows(id,time,add_width,add_height);
							if (coluna <= 2){
								coluna++;
							}else{
								coluna =1;
							}	
						}
				  }	
			}
		}
	}	
}

function emparelhar_windows_in_3_colunas(){
	var el = document.getElementsByTagName("DIV");	
	var time = 0;
	var coluna= 1;
	var add_width =0;add_width2 = 0;add_width3 = 0;
	for (var y in el){	
		if(y != el[y].id.toString()){ // corrige bug do firefox
			if(el[y].id){
				  if( el[y].id.toString().indexOf("Container") == 0){					  
						var id = el[y].id;					
						if (el[y].childNodes[0].style.display != "none"){
							time++;											
													
							switch (coluna){
								  case 1: 	 //coluna da esquerda		
									  add_width = '0';			
									  add_width2 = el[y].childNodes[0].style.width;									
									  break;
								  case 2:   //coluna do meio								 
									  add_width = parseFloat(add_width2);	
									  add_width3 = parseFloat(el[y].childNodes[0].style.width) +parseFloat(add_width2);						
									  break;
								  case 3://coluna da direita								
									  add_width = add_width3;									  
									  break;
								  default:
									  break;
							}					
							
	
							if (coluna <= 2){
								coluna++;
							}else{
								coluna =1;
							}	
							
					
							
							set_emparelhar_windows(id,time,add_width);
							
						}
				  }	
			}
		}
	}	
}



function set_distribuir_windows(id,time,add_width,add_height){	
		var y = setTimeout(function() { 							 
						  maxmizar_distribuir($('#'+id),add_width,add_height)	;							  
		}, (time * 150)  );
}



function maxmizar_distribuir(obj,add_width,add_height){

	  var Window          = obj.find(".AeroWindow");
	  var WindowContainer = obj.find(".table-mm-container");
	  var WindowContent   = obj.find(".table-mm-content");
	  var BTNMin          = obj.find(".win-min-btn");
	  var BTNMax          = obj.find(".WinBtnSet.winmax");
	  var BTNReg          = obj.find(".WinBtnSet.winreg");
	  var BTNClose        = obj.find(".win-close-btn");	  
	  
	  
	 // alert(obj+'-'+add_width+"-"+add_height);
	  
	 // var add_width = add_width.replace("px","");	  //comentado dia 15/04, verifica se houve alteraao na aplicacao
	  
 
		
	  	if(document.getElementById("table_menu_vertical")){  // se está habilitado em menu verticaL
			leftposition = -(get_left_position());			
			add_height -= 30;
		}else{		
			 leftposition = 0;	
			 
			// leftposition =  ($(window).width()/2) - (Window.width()/2);	
		}	
		
		 WindowContainer.css('visibility', 'visible'); 
          WindowContent.animate({ 
            width: Window.width()-32, 
            height: Window.height()-77}, {
            queue: false,
            duration: obj.WindowAnimationSpeed,
            easing: obj.WindowAnimation
          });
          //Set new Window Position
          Window.animate({ 
            width: Window.width(), 
            height: Window.height(),
            top: 80  +parseFloat(add_height) , 
            left: 10+parseFloat(add_width)-parseFloat(leftposition)}, {
            duration: obj.WindowAnimationSpeed,
            easing: obj.WindowAnimation
          });     
	
 		  $(".AeroWindow").removeClass('active');
          if (Window.hasClass('AeroWindow')) Window.addClass('active');
          if (($('body').data('AeroWindowMaxZIndex')) == null) {
            $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index'));
          }
          i = $('body').data('AeroWindowMaxZIndex');
          i++;
          Window.css('z-index', i);
          $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index'));
          //MaximizeWindow();
}


function emparelhar_windows(){
	var el = document.getElementsByTagName("DIV");	
	var time = 0;add_width2 = 0;
	for (var y in el){		
		if(y != el[y].id.toString()){ // corrige bug do firefox
			if(el[y].id){
				  if( el[y].id.toString().indexOf("Container") == 0){					  
						var id = el[y].id;					
						if (el[y].childNodes[0].style.display != "none"){
							time++;		
							if (time % 2 == 0){		
								add_width = add_width2;	
							}else{							
								add_width = '0';
								add_width2 = el[y].childNodes[0].style.width;	
							}			
							
							set_emparelhar_windows(id,time,add_width);
							
						}
				  }	
			}
		}
	}	
}



function set_emparelhar_windows(id,time,add_width){	
		var y = setTimeout(function() { 							 
						  maxmizar_emparelhamento($('#'+id),add_width)	;							  
		}, (time * 150)  );
}



function maxmizar_emparelhamento(obj,add_width){

				
	  var Window          = obj.find(".AeroWindow");
	  var WindowContainer = obj.find(".table-mm-container");
	  var WindowContent   = obj.find(".table-mm-content");
	  var BTNMin          = obj.find(".win-min-btn");
	  var BTNMax          = obj.find(".WinBtnSet.winmax");
	  var BTNReg          = obj.find(".WinBtnSet.winreg");
	  var BTNClose        = obj.find(".win-close-btn");	  
	  
	  
	  
	  
	//  var add_width = add_width.replace("px","");	  
	  
	  var add_height = 0;	 
		
	  	if(document.getElementById("table_menu_vertical")){  // se está habilitado em menu verticaL
			leftposition = -(get_left_position());			
			add_height -= 30;
		}else{		
			 leftposition = 0;	
			 
			// leftposition =  ($(window).width()/2) - (Window.width()/2);	
		}	
		
		 WindowContainer.css('visibility', 'visible'); 
          WindowContent.animate({ 
            width: Window.width()-32, 
            height: Window.height()-77}, {
            queue: false,
            duration: obj.WindowAnimationSpeed,
            easing: obj.WindowAnimation
          });
          //Set new Window Position
          Window.animate({ 
            width: Window.width(), 
            height: Window.height(),
            top: 80  +parseFloat(add_height) , 
            left: 10+parseFloat(add_width)-parseFloat(leftposition)}, {
            duration: obj.WindowAnimationSpeed,
            easing: obj.WindowAnimation
          });     
	
 		  $(".AeroWindow").removeClass('active');
          if (Window.hasClass('AeroWindow')) Window.addClass('active');
          if (($('body').data('AeroWindowMaxZIndex')) == null) {
            $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index'));
          }
          i = $('body').data('AeroWindowMaxZIndex');
          i++;
          Window.css('z-index', i);
          $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index'));
          //MaximizeWindow();
}




function cascade_windows(){
	var el = document.getElementsByTagName("DIV");	
	var time = 0;
	for (var y in el){	
		if(y != el[y].id.toString()){ // corrige bug do firefox
			if(el[y].id){
				  if( el[y].id.toString().indexOf("Container") == 0){					  
						var id = el[y].id;					
						if (el[y].childNodes[0].style.display != "none"){
							time++;
							set_cascade(id,time);
						}
				  }	
			}
		}
	}	
}




function set_cascade(id,time){
		 var y = setTimeout(function() { 									  
						  maxmizar_cascade( $('#'+id),(time * 20),(time * 20));						  
		}, (time * 150)  );
}



function maxmizar_cascade(obj,add_height,add_width){
	  var Window          = obj.find(".AeroWindow");
	  var WindowContainer = obj.find(".table-mm-container");
	  var WindowContent   = obj.find(".table-mm-content");
	  var BTNMin          = obj.find(".win-min-btn");
	  var BTNMax          = obj.find(".WinBtnSet.winmax");
	  var BTNReg          = obj.find(".WinBtnSet.winreg");
	  var BTNClose        = obj.find(".win-close-btn");	  
		
	  

	  	if(document.getElementById("table_menu_vertical")){  // se está habilitado em menu verticaL
			leftposition = get_left_position();				
		}else{		
			 leftposition = ($(window).width()/2) - (Window.width()/2);	
		}
					  
		 WindowContainer.css('visibility', 'visible'); 
          WindowContent.animate({ 
            width: Window.width()-32, 
            height: Window.height()-77}, {
            queue: false,
            duration: obj.WindowAnimationSpeed,
            easing: obj.WindowAnimation
          });
          //Set new Window Position
          Window.animate({ 
            width: Window.width(), 
            height: Window.height(),
            top: 80 +add_height, 
            left: parseFloat(leftposition) +parseFloat(add_width)}, {
            duration: obj.WindowAnimationSpeed,
            easing: obj.WindowAnimation
          });     
	
 		  $(".AeroWindow").removeClass('active');
          if (Window.hasClass('AeroWindow')) Window.addClass('active');
          if (($('body').data('AeroWindowMaxZIndex')) == null) {
            $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index'));
          }
          i = $('body').data('AeroWindowMaxZIndex');
          i++;
          Window.css('z-index', i);
          $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index'));
          //MaximizeWindow();
}




function reposition_conteiners(){
	var el = document.getElementsByTagName("DIV");	
	var time = 0;
	for (var y in el){	
		if(y != el[y].id.toString()){ // corrige bug do firefox
			if(el[y].id){
				  if( el[y].id.toString().indexOf("Container") == 0){					  
						var id = el[y].id;
						if (el[y].style.display != "none"){
							time++;
							set_position(id,time);
						}
				  }	
			}
		}
	}	
}
function set_position(id,time){
		 var y = setTimeout(function() { 									  
						  maxmizar( $('#'+id));						  
		}, (time * 150)  );
}

function get_left_position(){
	 if (window.document.body.clientWidth < 1100){		 
		return '23';
	 }else{
		return '210';
	 }	
}

function grid(div,Width,Height,Title){ //  //grid(table,Width,Height,Title)
	openAeroWindow(div,'80','center',Width,Height,Title,'./php/listar.php?table='+div);
}


function openAeroWindow(div,PositionTop,PositionLeft,Width,Height,Title,iframe_src){				
		   var myDate = new Date();	
		   var nounce = myDate.getTime();		   
		   
			if(document.getElementById("table_menu_vertical")){  // se está habilitado em menu verticaL
				PositionLeft = get_left_position();			
			}
		   
		   if (div != ""){		
		   	   var div_id = "Container"+div;	
			   var iframe_aero =  "iframe_aero"+div;	
		   }else{
			   var iframe_aero =  "iframe_aero"+nounce;	
			   var div_id = "Container"+nounce;	
		   }
		   
			var  obj = document.getElementById(div_id);
			
					
			if (!obj){ // nova janela
					//alert("novo");	
					var div = document.createElement('div');
					div.id = div_id;			
					div.style.display = "none";
					document.body.appendChild(div);
								
					var iframe = document.createElement('iframe');			
					iframe.width = "100%";
					iframe.height = "100%";
					iframe.style.border = "0px";
					iframe.frameBorder = "0";
					iframe.name = iframe_aero;
					iframe.id = iframe_aero;
					div.appendChild(iframe);
					
					var div2 = document.createElement('div');
					div2.id = "iframeHelper"+nounce;	
					div.appendChild(div2);	
				
				   $('#'+div.id).AeroWindow({
					  WindowTitle:          Title,
					  WindowPositionTop:    PositionTop,     /* Posible are pixels or 'center' */
					  WindowPositionLeft:   PositionLeft,    /* Posible are pixels or 'center' */
					  WindowWidth:          Width,
					  WindowHeight:         Height,
				//	  WindowDesktopIconFile:  'images/icons/default.png',  
					  WindowAnimationSpeed:    500,
					  WindowAnimation:      'easeOutCubic'        
					}); 
				
					document.getElementById(iframe_aero).src=iframe_src;	
					document.getElementById(iframe_aero).style.display =  "";
					document.getElementById(div_id).style.display =  "";	
			}else{ // janela já existe	
					obj.style.display = "";	
					var iframe = document.getElementById(iframe_aero);			
				
				   $('#'+obj.id).AeroWindow({
					  WindowTitle:          Title,
					  WindowPositionTop:    PositionTop,     /* Posible are pixels or 'center' */
					  WindowPositionLeft:   PositionLeft,    /* Posible are pixels or 'center' */
					  WindowWidth:          Width,
					  WindowHeight:         Height,
				//	  WindowDesktopIconFile:  'images/icons/default.png',  
					  WindowAnimationSpeed:    500,
					  WindowAnimation:      'easeOutElastic'        
					}); 
				
					//document.getElementById(iframe_aero).src=iframe_src;	
					document.getElementById(iframe_aero).style.display =  "";
					document.getElementById(div_id).style.display =  "";	
			
				maxmizar( $('#'+obj.id))
			}
		
}



function openNewAeroWindow(div,PositionTop,PositionLeft,Width,Height,Title,iframe_src){			 // abre janela dando refresh do conteudo	
		   var myDate = new Date();	
		   var nounce = myDate.getTime();
		   
			if(document.getElementById("table_menu_vertical")){  // se está habilitado em menu verticaL
				PositionLeft = get_left_position();			
			}
		   
		   if (div != ""){		
		   	   var div_id = "Container"+div;	
			   var iframe_aero =  "iframe_aero"+div;	
		   }else{
			   var iframe_aero =  "iframe_aero"+nounce;	
			   var div_id = "Container"+nounce;	
		   }
		   
			var  obj = document.getElementById(div_id);
					
		var div = document.createElement('div');
		div.id = div_id;			
		div.style.display = "none";
		document.body.appendChild(div);
					
		var iframe = document.createElement('iframe');			
		iframe.width = "100%";
		iframe.height = "100%";
		iframe.style.border = "0px";
		iframe.frameBorder = "0";
		iframe.name = iframe_aero;
		iframe.id = iframe_aero;
		div.appendChild(iframe);
		
		var div2 = document.createElement('div');
		div2.id = "iframeHelper"+nounce;	
		div.appendChild(div2);	

	  
	
       $('#'+div.id).AeroWindow({
          WindowTitle:          Title,
          WindowPositionTop:    PositionTop,     /* Posible are pixels or 'center' */
          WindowPositionLeft:   PositionLeft,    /* Posible are pixels or 'center' */
          WindowWidth:          Width,
          WindowHeight:         Height,
	//	  WindowDesktopIconFile:  'images/icons/default.png',  
		  WindowAnimationSpeed:    500,
          WindowAnimation:      'easeOutCubic'        
        }); 
	
		document.getElementById(iframe_aero).src=iframe_src;	
		document.getElementById(iframe_aero).style.display =  "";
		document.getElementById(div_id).style.display =  "";	
		
	if (!obj){ // nova janela
					//alert("novo");
			}else{ // janela já existe			
				maxmizar( $('#'+div.id))
			}
		
}




function maxmizar(obj){	
	  var Window          = obj.find(".AeroWindow");
	  var WindowContainer = obj.find(".table-mm-container");
	  var WindowContent   = obj.find(".table-mm-content");
	  var BTNMin          = obj.find(".win-min-btn");
	  var BTNMax          = obj.find(".WinBtnSet.winmax");
	  var BTNReg          = obj.find(".WinBtnSet.winreg");
	  var BTNClose        = obj.find(".win-close-btn");	  
	  
	  
	  
	  
	  var add_height = 0;	
	  		
	  	if(document.getElementById("table_menu_vertical")){  // se está habilitado em menu verticaL
			leftposition = get_left_position();	
			add_height -= 30;
		}else{		
			 leftposition = ($(window).width()/2) - (Window.width()/2);	
		}

	  
		 WindowContainer.css('visibility', 'visible'); 
          WindowContent.animate({ 
            width: Window.width()-32, 
            height: Window.height()-77}, {
            queue: false,
            duration: obj.WindowAnimationSpeed,
            easing: obj.WindowAnimation
          });
		  
          //Set new Window Position
          Window.animate({ 
            width: Window.width(), 
            height: Window.height(),
            top: 80 +add_height, 
            left: leftposition}, {
            duration: obj.WindowAnimationSpeed,
            easing: obj.WindowAnimation
          });    
		  
 		  $(".AeroWindow").removeClass('active');
          if (Window.hasClass('AeroWindow')) Window.addClass('active');
          if (($('body').data('AeroWindowMaxZIndex')) == null) {
            $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index'));
          }
          i = $('body').data('AeroWindowMaxZIndex');
          i++;
          Window.css('z-index', i);
          $('body').data( 'AeroWindowMaxZIndex' , Window.css('z-index'));

          //MaximizeWindow();
}


function calcula_idade(form, obj){	
	form.elements["idade"].value = " Idade:  "+ calculaIdade(obj.value)+"  anos";	
}


function calculaIdade(dataNasc){ 
	  var dataAtual = new Date();
	  var anoAtual = dataAtual.getFullYear();
	  var anoNascParts = dataNasc.split('/');
	  var diaNasc =anoNascParts[0];
	  var mesNasc =anoNascParts[1];
	  var anoNasc =anoNascParts[2];
	  var idade = anoAtual - anoNasc;
	  var mesAtual = dataAtual.getMonth() + 1; 
	  //se mês atual for menor que o nascimento, nao fez aniversario ainda; (26/10/2009) 
	  if(mesAtual < mesNasc){
	 	    idade--; 
	  }else {
			//se estiver no mes do nasc, verificar o dia
			if(mesAtual == mesNasc){ 
				if(dataAtual.getDate() < diaNasc ){ 
					//se a data atual for menor que o dia de nascimento ele ainda nao fez aniversario
					idade--; 
				}
			}
	  } 
	  return idade; 
}




function subtrai_data(data1,data2){  //formato BR
	
	var ano1 = data1.toString().substring(6,10);
	var mes1 = data1.toString().substring(3,5);
	var dia1 = data1.toString().substring(0,2);
	
	var ano2 = data2.toString().substring(6,10);
	var mes2 = data2.toString().substring(3,5);
	var dia2 = data2.toString().substring(0,2);
	
	var SECOND = 1000;
	var MINUTE = SECOND * 60;
	var HOUR = MINUTE * 60;
	var DAY = HOUR * 24;
	
	//var data1dif = ano1 + mes1 + dia1;
	//var data2dif = ano2 + mes2 + dia2;
	var data1dif = Date.UTC(ano1,(mes1-1),dia1);
	var data2dif = Date.UTC(ano2,(mes2-1),dia2);
	
	/*
	if (data1dif > data2dif){
	alert("A data planejada deve ser menor que a data executada");
	return 0;
	}
	*/	
	var difParc = data2dif - data1dif; 
	var dif = Math.round(difParc/DAY);
	//alert(dif); //calcula diferença de dias	
	//////////////////// calcula dias uteis /////////////
	//var data1c = new Date(ano1,(mes1 - 1),dia1);
	//var data2c = new Date(ano2,(mes2 - 1),dia2);
	
	//var cont = 0;
	//var c = 0;
	//var x = 1;
	
	//for(i=0;i < dif;i++){ 
		//if((data1c.getDay() == 0)||(data1c.getDay() == 6)){
			//cont += 1;
		//}
		//c = parseInt(data1c.getDate()) + x;
	//	data1c.setDate(c);
	//}
	//alert(cont); //numero de sabados e domingos
	
	return (dif); //retorna a difença completa das datas

}



function getHTTPObject() {
var req;

try {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();

		if (req.readyState == null) {
			req.readyState = 1;
			req.addEventListener("load", function () {
			req.readyState = 4;
			if (typeof req.onReadyStateChange == "function")
			req.onReadyStateChange();
			}, false);
		}
	return req;
	}

	if (window.ActiveXObject) {
		var prefixes = ["MSXML2", "Microsoft", "MSXML", "MSXML3"];

		for (var i = 0; i < prefixes.length; i++) {
			try {
				req = new ActiveXObject(prefixes[i] + ".XmlHttp");
				return req;
				} catch (ex) {};
		}
	}
	
	} catch (ex) {}
alert("XmlHttp Objects not supported by client browser");
}

var http = getHTTPObject();
// AJAX ********AJAX***********AJAX********AJAX ********AJAX***********AJAX********


// move frames
function clear_all() {
	var input = document.getElementsByTagName("INPUT");
  for (x = 0; x < input.length; x++ ) {	
  
  if ((input[x].type == "text")||(input[x].type == "file")){
	input[x].value="";  
  }
 	
  };
		
	//for (x=0;x<document.frmcadastro.length;x++){
		//document.frmcadastro.item(x).value="";
		//alert(document.frmcadastro.item(x).value);
	//}	
	
}


function limpa_form(form) {	
	  if (form){
	  		var input = form;
	  }else{
	  		var input = document.forms[0];
	  }
	  for (x = 0; x < input.length; x++ ){	  
			field_type = input[x].type.toLowerCase();
			switch (field_type){
				  case "text":
					  input[x].value=""; 
					  break;
				  case "password":
					  input[x].value="";  
					  break;
				  case "file":
					  input[x].value="";  
					  break;
				  case "textarea":
					  input[x].value="";  
					  break;
				  case "radio":		  
					  if ( input[x].checked == true) { // if a button in group is checked,
							 input[x].checked = false;  // uncheck it
					  }
					  break;
				  case "checkbox":								  
					  if ( input[x].checked == true) { // if a button in group is checked,
							 input[x].checked = false;  // uncheck it
					  }
					  break;	  
			      case "select-one":
					  //selectbox[x].selectedIndex = -1;
					  input[x].selectedIndex = 0;
					  break;	
				  case "select-multi":
					  //selectbox[x].selectedIndex = -1;
					  input[x].selectedIndex = 0;
					  break;	  
				  default:
					  break;
			}
	  }		
	  /*
	  if (self.frames.length > 0){
		  for (i=0; i < self.frames.length; i++){
			  if(self.frames[i].name != undefined){
				  if (self.frames[i].name.search("Xinha")!=-1){	
					 self.frames[i].document.body.innerHTML = "";
				  }
			  }
		  }
	  }*/
}




function sair_site(){
  var ok;
  ok = confirm("Confirma Logout?");
  if(ok) {	
	//parent.location.href='./php/logout.php';
	open('./php/logout.php','grid_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');
	
	
					setTimeout(function() { 
								parent.$( "#meu_cadastro_side" ).animate({
									  top: "-240px"					
								}, 500 );	
					  }, 200);	
						
						setTimeout(function() { 
								$( "#meu_cadastro_form" ).animate({
									  right: "-400px"					
								}, 500 );		
					  }, 400);	
						setTimeout(function() { 
								parent.$( "#alterar_senha_form" ).animate({
									  right: "-490px"					
								}, 500 );	
					  }, 700);	
						setTimeout(function() { 
								parent.$( "#login-side" ).animate({
									  top: "130px"					
								}, 500 );
					  }, 1000);	
						


	
	
    }
  }


//------------------------------data grid

var last_id;
function coincidence_numer(range){
	var range;
	var number = Math.round(Math.random()/(1/range));
	return number;
}


function save_field(obj){
	var value_str = obj.value;
	var id        = obj.id;
	var myDate = new Date();
	
	var coincidence = coincidence_numer(99999999999);
	
	while (value_str.search("'") >= 0){
	value_str=value_str.replace("'","");
	}
	while (value_str.search("#") >= 0){
	value_str=value_str.replace("#","");
	}
	
	open('save_form.php?id='+id+'&value='+value_str+'&coincidence='+coincidence+'&valor_antigo='+document.getElementById("valor_antigo").value+ '&time='+myDate.getTime(),'grid_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');
}


function save_combo_online(id,obj,valor){
	var value_str = valor;
	var myDate = new Date();
	//var id        = obj.id;
	var coincidence = coincidence_numer(99999999999);	
	open('save_form.php?tipo=save_combo&id='+id+'&value='+value_str+'&coincidence='+coincidence+ '&time='+myDate.getTime(),'grid_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');
}


function confira_delete(){
	var ok;
	ok = confirm("Confirma excluir esse registro?");
	if(ok){	
		if(confira_delete_final()){
			return(1)
		}
	}else{
		return(0)
	}
}


function confira_delete_final(){
	var ok;
		ok = confirm("Verifique se é possível apenas desativar o registro para ele não ser visto. Se apagado o registro não poderá mais ser consultado no sistema. Tem certeza que você quer apagá-lo?");
		if(ok){	
			var ok2;
			ok2 = confirm("O registro não poderá mais ser recuperado. Essa é a última confirmação. Se confirmar este procedimento, um log da exclusão será gravado, confirma apagar o registro?");
			if(ok2){	
				return(1)
			}else{
				return(0)
			}
		}else{
			return(0)
		}
}

function confirma_delete_múltiplos(titulo){	
	var ok;
	if (titulo=="projetos"){
		ok = confirm("Você pode apenas despublicar o projeto para ele não ser visto. Se apagado o projeto não poderá mais ser consultado no sistema. Tem certeza que você quer apagá-lo?");
		if(ok){	
			var ok2;
			ok2 = confirm("Os dados do projeto não poderão mais ser recuperados. Essa é a última confirmação. Se confirmar este procedimento, você estará assumindo a responsabilidade por apagar esse projeto. ?");
			if(ok2){	
				return(1)
			}else{
				return(0)
			}
		}else{
			return(0)
		}
	}else{
		return(1)
	}
}

function form_field(obj,id){
	var txt  = obj.innerHTML;
	var type = obj.type;
	last_id = id;
	var new_id = id + "_new";
	//var len = obj.innerText.length;	
	//alert(len);	

if (typeof(obj.textContent) != "undefined"){
	var len = obj.textContent.length;
}else if (typeof(obj.innerText) != "undefined"){
	var len = obj.innerText.length ;
}	
//alert(id);
	bRes  = txt.indexOf( '<input' );
	bRes1 = txt.indexOf( '<INPUT' );		
	if(bRes < 0 && bRes1 < 0){
	var frm = "<input title=\"Este campo deve ser editado em HTML\" type=\"text\" onBlur=\"update_field(this)\" onChange=\"update_field(this)\"  NAME=\"T1\" id=\""+ id + "\" VALUE=\""+ txt + "\" SIZE=\""+len+"\" STYLE=\"font-size: 8pt; font-family: Arial; border-style: solid; width:100%; border-width: 1\">";			
			obj.innerHTML=frm;			
			obj.childNodes[0].focus();
	}
}

function hora_field(obj,id_anexo,form){
	var txt  = obj.innerHTML;
	var type = obj.type;
	last_id = id_anexo;
	var new_id = id_anexo + "_new";
	//var len = obj.innerText.length;	
	//alert(len);	
	if (typeof(obj.textContent) != "undefined"){
		var len = obj.textContent.length;
	}else if (typeof(obj.innerText) != "undefined"){
		var len = obj.innerText.length ;
	}	
	//alert(id_anexo);
	bRes  = txt.indexOf( '<input' );
	bRes1 = txt.indexOf( '<INPUT' );		
	if(bRes < 0 && bRes1 < 0){
	var frm = '<input  type="text"   onblur="update_hora_field(this,'+id_anexo+',form)"  NAME="HOR1" id="'+ new_id + '" VALUE="'+ txt + '"  STYLE="font-size: 8pt; font-family: Arial; border-style: solid; width:40px; border-width: 1" onkeypress="return sonumero(event)"   onKeyDown="return Mascara_Hora(this)"  maxlength="5" onclick="this.select()"  title="Hora : Minuto" >';					
			obj.innerHTML=frm;			
			obj.childNodes[0].focus();
	}
}

function update_hora_field(obj,id_anexo,form){
	var myDate = new Date();	
	var value_str = obj.value;
	
	while (value_str.search("'") > 0){
		value_str=value_str.replace("'","");
	}
		
	if ( ( (obj.value == "")&&(obj.value != "00:00") )||((obj.value.length != 5)&&(obj.value.length != 0)) ) {
		alert("Por favor, digite uma hora válida");
		obj.value = "";
		obj.focus();
		return false;
	}else{
		if (testa_hora(obj.value, obj, obj.name)){
			open('update_hora.php?id_anexo='+id_anexo+'&hora_value='+value_str+'&time='+myDate.getTime(),'grid_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');
		}
	}
}
	  





function data_field(obj,id_anexo,form){
	var txt  = obj.innerHTML;
	var type = obj.type;
	last_id = id_anexo;
	var new_id = id_anexo + "_new";
	//var len = obj.innerText.length;	
	//alert(len);	
	if (typeof(obj.textContent) != "undefined"){
		var len = obj.textContent.length;
	}else if (typeof(obj.innerText) != "undefined"){
		var len = obj.innerText.length ;
	}	
	//alert(id_anexo);
	bRes  = txt.indexOf( '<input' );
	bRes1 = txt.indexOf( '<INPUT' );		
	if(bRes < 0 && bRes1 < 0){
	var frm = '<input  type="text"  class="datepicker" onChange="update_data_field(this,'+id_anexo+',form)"  NAME="DAT1" id="'+ new_id + '" VALUE="'+ txt + '"  STYLE="font-size: 8pt; font-family: Arial; border-style: solid; width:70px; border-width: 1" onKeyPress="return txtBoxFormat(this.form, this.name, \'99/99/9999\', event);"   title="Dia / Mês / Ano"  maxLength="10"  >';			
			obj.innerHTML=frm;		
	}
	$(function() {
		$(".datepicker").datepicker({									  
			changeMonth: true,
			changeYear: true,
			inline: true,
			monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho',
			'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
			monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
			'Jul','Ago','Set','Out','Nov','Dez'],
			dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'],
			dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'],
			dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'],
			dateFormat: 'dd/mm/yy', firstDay: 0,		
			prevText: '&#x3c;Anterior', prevStatus: '',
			nextText: 'Pr&oacute;ximo&#x3e;', nextStatus: '',
			currentText: 'Hoje', currentStatus: '',
			todayText: 'Hoje', todayStatus: '',
			clearText: 'Limpar', clearStatus: '',
			closeText: 'Fechar', closeStatus: ''
		});
		obj.childNodes[0].focus();
	});	
}


function update_data_field(obj,id_anexo,form){
	var myDate = new Date();	
	var value_str = obj.value;
	
	while (value_str.search("'") > 0){
	value_str=value_str.replace("'","");
	}
		
	if (obj.value =="") {
		alert("Por favor, digite uma data válida");
		obj.focus();
		return false;
	}

	if (newDataValidate(obj)){
		open('update_data.php?id_anexo='+id_anexo+'&data_value='+value_str+'&time='+myDate.getTime(),'grid_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');
	}
}
	  






function update_field(obj){
	var value_str = obj.value;
	var id        = obj.id;
	var coincidence = coincidence_numer(99999999999);
	
	while (value_str.search("'") > 0){
	value_str=value_str.replace("'","");
	}
	
	//alert(value_str);	
	open('update_form.php?ID='+id+'&anexo_name='+value_str+'&coincidence='+coincidence,'grid_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');
}


function delete_field(table,campo_1,campo_2,primary_key,tipo,order,foreigh_key){		
	if (confira_delete()){
		if (confirma_delete_múltiplos(tipo)){
		//alert("campo_1:"+campo_1+"  campo_2:"+campo_2+"  tipo:"+tipo+"  order:"+order+"  foreigh_key:"+foreigh_key);return false;
		open('delete_form.php?campo_1='+campo_1+'&table='+table+'&primary_key='+primary_key+'&titulo='+tipo+'&campo_2='+campo_2+'&foreigh_key='+foreigh_key+'&order='+order+'','grid_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');
		}
	}	
}

function field_ch(obj){
	
	id = obj.id;
	
if (typeof(obj.textContent) != "undefined"){ // To firefox
	//alert("firefox"); 
	if (document.getElementById(id).textContent != ""){
document.getElementById("valor_antigo").value=document.getElementById(id).textContent; //guarda valor antigo
	}
}else if (typeof(obj.innerText) != "undefined"){  // to IE
	//alert("IE");
	if (document.getElementById(id).innerText != ""){
document.getElementById("valor_antigo").value=document.getElementById(id).innerText; //guarda valor antigo
	}
}
//alert(document.getElementById("valor_antigo").value);
//alert(document.getElementById(id).onclick);
//document.getElementById(id).focus();
//document.getElementById(id).onclick="javascript:field_ch(obj);"; 	
	form_change(obj);

}






function form_change(obj){
	var txt  = obj.innerHTML;
	var type = obj.type;
	var id   = obj.id;
	last_id = id;
	var new_id = id + "_new";
	
	//var len = obj.innerText.length;	
	//alert(len);	

if (typeof(obj.textContent) != "undefined"){
	var len = obj.textContent.length;
}else if (typeof(obj.innerText) != "undefined"){
	var len = obj.innerText.length ;
}
	
	
	
	if(new_id=="_new"){
		alert("New ID é igual a new.");
	} else {
		if(len < 3) len = 8;
		var bRes; var bRes1;					
		if (len > 100){   
				//alert('area');
				//alert(len);
				bRes  = txt.indexOf( '<textarea' );
				bRes1 = txt.indexOf( '<TEXTAREA' );
				
			}
			else
			{
				if (len < 100){ 						
						//alert(len);
						//alert(document.getElementById(id).onclick);
						bRes  = txt.indexOf( '<input' );
						bRes1 = txt.indexOf( '<INPUT' );		
					}
			}
		
		//if(bRes < 0 && bRes1 < 0 && txt.indexOf( 'http://www.' )<0){
		  if(   (bRes < 0) && (bRes1 < 0) && (    (id.search("hiperlink") < 0) || ((id.search("hiperlink") > 0) && (txt.indexOf( 'www.' )<0))     ) ){
		//if(bRes < 0 && bRes1 < 0){
			if (len > 100){   
				var frm = "<textarea title=\"Este campo deve ser editado em HTML\" onBlur=\"save_field(this)\" onChange=\"save_field(this)\"  NAME=\"T1\" ID=\""+ new_id + "\"     cols=\"99\" rows=\"3\" wrap=\"VIRTUAL\"  STYLE=\"font-size: 8pt; font-family: Arial; border-style: solid; border-width: 1\">"+ txt + "</textarea>";
			// onKeyDown=\"if(event.keyCode=='13') save_field(this)\"onclick=\"alert(document.frmlistar.T1.innerHTML);\" 			
			}else{
				if (len < 100){ 
					var frm = "<input title=\"Este campo deve ser editado em HTML\" type=\"text\" onBlur=\"save_field(this)\" onChange=\"save_field(this)\"  NAME=\"T1\" ID=\""+ new_id + "\" VALUE=\""+ txt + "\" SIZE=\""+len+"\" STYLE=\"font-size: 8pt; font-family: Arial; border-style: solid; border-width: 1\">";
			// onKeyDown=\"if(event.keyCode=='13') save_field(this)\"onclick=\"alert(document.frmlistar.T1.value);\"	
				}
			}
			obj.innerHTML=frm;			
			document.getElementById(new_id).focus();
			document.getElementById(new_id).select();
		}	
	}
	
}

function pesquisar_txt(option){
	var form = document.frmLocalizar;
	
	form.localizar.value=form.txtLocalizar.value;
	form.fields_value.value=document.frmlistar.fields_value.value;
	
	if (option==1){		
		form.state_gif.value=option;
	}else{
		form.state_gif.value=option;
	}
		
	form.target = "_self";	
	form.method = "POST";
	form.action = "";	
	form.submit();
	
}

function txtLocalizar_onfocus()
  {  
    var tecla = event.keyCode;   
    pesquisar_txt(1);    
  }

function txtLocalizar_onkeypress()
  {
  var tecla = event.keyCode;   
    pesquisar_txt(1);
    return false;  
  }
  
function mostra_resultados(valor){	
	document.getElementById("label_resultados").innerHTML =valor;
}

function combo_resultados(valor,page,link_page){		
	//alert(link_page+"?titulo="+page+"&max_res="+valor);	
	document.location.href=link_page+"?titulo="+page+"&max_res="+valor;
}


function cols_width(cols_number,display){	

if (display=="inline"){
	
	
	for (x=1;x<=cols_number;x++){
	
	bRes  = document.getElementById('imput_width'+x).innerHTML.indexOf('<option');
	bRes1 = document.getElementById('imput_width'+x).innerHTML.indexOf('<OPTION');			
	if(bRes < 0 && bRes1 < 0){
	eval('document.getElementById("imput_width'+x+'").style.width=document.getElementById("col'+x+'").clientWidth-9');
	}
	
	eval('document.getElementById("imput_width'+x+'").style.display="inline"');
	}	
	document.getElementById("display_add").href="JavaScript:cols_width('"+cols_number+"','offine')";
	document.getElementById("display_img").title="cancelar";
	document.getElementById("display_img").src="../images/undo.gif";		
	document.getElementById("display_save").style.display="inline";		
	document.getElementById('btn_cancelar_incluir').style.display='inline';
	document.getElementById('btn_incluir').style.display='none';
}else{
	for (x=1;x<=cols_number;x++){
	eval('document.getElementById("imput_width'+x+'").style.display="none"');
	eval('document.getElementById("imput_width'+x+'").style.width=document.getElementById("col'+x+'").clientWidth-9');
	}		
	document.getElementById("display_add").href="JavaScript:cols_width('"+cols_number+"','inline');";	
	document.getElementById("display_img").title="adicionar";	
	document.getElementById("display_img").src="../images/add.gif";	
	document.getElementById("display_save").style.display="none";	
	document.getElementById('btn_incluir').style.display='inline';
	document.getElementById('btn_cancelar_incluir').style.display='none';
	
}
	//alert(document.getElementById("col1").clientWidth);	
	//document.getElementById("imput_width2").style.width=20;
}



function paridade_alterar_senha(form){
	if( form.senha.value != form.confirmar_senha.value){
		alert("Confirmação de Senhas diferente\nFavor digitar novamente!.");
		form.senha.value="";
		form.confirmar_senha.value="";
		form.senha.focus();	
		return false;		
	}else{
		return true;
	}
}

function paridade_alterar_email(form){
	if( form.email.value != form.confirmar_email.value){
		alert("Confirmação de Emails diferente\nFavor digitar novamente!.");
		form.email.value="";
		form.confirmar_email.value="";
		form.email.focus();	
		return false;		
	}else{
		return true;
	}
}



function write_msg(form){
	if ((form.data.value != "")&&(form.hora.value != "")){
		form.mensagem.style.background = "#FFF";
		form.mensagem.readOnly=false;
		//form.mensagem.value="Válido para Passeio em <b>"+form.data.value+"</b> - às  <b>"+form.hora.value+"</b>\nEste ticket deverá ser apresentado na entrada do ônibus\n";
		// alterado em 02/12/09
		form.mensagem.value="Passeio em\n<b>"+form.data.value+"</b> às <b>"+form.hora.value+"</b>\nApresentar na entrada \ndo ônibus\n";
		form.numero_lugares.focus();
	}	
}



function save_one_field(order,link_str)
{
	document.frmlistar.action="./save_one_field.php?order="+order+"&titulo="+link_str;			
	document.frmlistar.submit();		
}


function imprimir(){
	window.print();
}


//-----------------------------------------------------------------

function validacao(obj,valor){	
	alert_obj="alert_"+obj;	
	if (valor == ""){		
		//document.getElementById(alert_obj).style.color="#ff0000";
		document.getElementById(obj).style.backgroundColor="#FFFFCC";
		document.getElementById(alert_obj).innerHTML='<img src="../images/no.gif" align="middle">';
	}else{
		//document.getElementById(alert_obj).style.color="#00cc00";
		document.getElementById(obj).style.backgroundColor="#DEEBE0";
		document.getElementById(alert_obj).innerHTML='<img src="../images/yes.gif" align="middle">';
	}										  
}



function validacao_dual(obj,obj2){	
	alert_obj="alert_"+obj;	
	alert_obj2="alert_"+obj2;
	valor=document.getElementById(obj).value;
	valor2=document.getElementById(obj2).value;
	
	
	if ((valor == "")||(valor2 == "")){		
		document.getElementById(obj).style.backgroundColor="#FFFFCC";
		document.getElementById(obj2).style.backgroundColor="#FFFFCC";
		document.getElementById(alert_obj).innerHTML='<img src="../images/no.gif" align="middle">';
	}else{
		document.getElementById(obj).style.backgroundColor="#DEEBE0";
		document.getElementById(obj2).style.backgroundColor="#DEEBE0";
		document.getElementById(alert_obj).innerHTML='<img src="../images/yes.gif" align="middle">';
	}					
	
}


function valida_controle_senha(obj){
open('ajax_open_data.php?valida_controle_senha=yes&controle_senha='+obj.value,'action_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');
}


function max_area(obj,valor){
	var maximo = valor; 
	if (obj.value.length > maximo){
		obj.value = obj.value.substring(0,maximo);
	}
}


function max_caracteres(obj,valor,e){
	//alert(obj.value.length);
	  var whichCode = (window.Event) ? e.which : e.keyCode;
       // if (whichCode == 13) return true;
	   
	  var maximo = valor;  
	   
	   
	 // if(whichCode==86){  // ctrl+v			
		setTimeout(function() { 
				set_max(obj,maximo);	
		}, 100);	
	//  }
	
	//set_max(obj,maximo);	
}
function set_max(obj,maximo){
	if (obj.value.length > maximo){
		//obj.value = obj.value.substring(0,maximo);
		document.getElementById("disp_carac").innerHTML = '<span style="color:#F00">'+(parseInt(maximo) - obj.value.length)+'</span>';
	}else{
		document.getElementById("disp_carac").innerHTML = '<span style="color:#080">'+(parseInt(maximo) - obj.value.length)+'</span>';
	}
}




function pesquisar_dados(name,valor,valor2){	
	var myDate = new Date();
	switch (name){
		case "area_cultural":			
			http.open("GET", "ajax_open_data.php?combo_area_cultural=yes&area_cultural=" + valor + '&time='+myDate.getTime(), true);
			http.onreadystatechange = handleHttpResponseAreaCultural;
			break;
		default:
			break	
	}
	http.send(null);
}


function handleHttpResponseAreaCultural(){//para retornar num select

// dar select na cidade tambem	
	campo_select = document.forms[0].id_modalidade;
	if (http.readyState == 4) {		
		campo_select.options.length = 0;
		results = http.responseText.split("##ajax##");		
		//campo_select.options[0] = new Option( 'selecione', '' );
		for( i = 0; i < results.length-1; i++ ){ 			
			//alert(results[results.length-1]);return false;
			string = trim(results[i]).split( "|" );		
		//	if (trim(string[0])==document.getElementById("id_modalidade").value){
			//	campo_select.options[i] = new Option( string[0], string[1], "", 'selected' );
		//	}else{
				campo_select.options[i] = new Option( string[0], string[1] );
		//	}
		}
	}
}







function mostra_detalhes(value){
	obj=document.getElementById(value);
    if(obj.style.display=='none') {		
		obj.style.display ='inline';
		document.getElementById(value+"_foto").src="../images/seta_cima.gif";
       } else {
		obj.style.display ='none';
		document.getElementById(value+"_foto").src="../images/seta_baixo.gif";
    }	
}




 var testresults;
   function check_filter(obj){	 
     // var str=document.mensagem.item(name).value;	  only for IE
	 // var str=document.getElementById(name).value;
	  
	 var str= obj.value;
	  
	  if (str == "")return false;
	  
      var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
      if (filter.test(str))
         testresults=true;
      else{
         alert("Endereço de email inválido!")		
		 obj.value="";
		 obj.focus();
         testresults=false;
      }
      return (testresults);
   }

   function check_mail(obj){
      if (document.layers||document.getElementById||document.all)	  	 
         return check_filter(obj);
      else
         return true;
   }
 






function confimaPergunta(acao,id,texto){
	var ok;
	ok = confirm(texto);
	if(ok){		
		executa_acao(acao,id);
	}else{
		return false;  
	}
}
  
function confirma_acao(acao,id){
	switch (acao){	
		case "save":			
				var texto = "Já existe um usuário cadastrado com esse nome \nSe continuar com esse procedimento será criado um homônimo para esse usuário.\nTem certeza que deseja criar um homônimo?";
				confimaPergunta(acao,id,texto);
			break;						
		default:
			alert("acao nao declarada");
			break;	
	}		
}

function executa_acao(acao,id){
	switch (acao){
		case "update":		
			document.forms[0].action='./operacoes.php?acao=update&id='+id;
			break;			
		case "save":			
			document.forms[0].action='./operacoes.php?acao=save';
			break;			
		case "savecomo":			
			document.forms[0].action='./operacoes.php?acao=save';
			break;			
		default:
			alert("acao nao declarada");
			break;	
	}	
	document.forms[0].method="POST";
	document.forms[0].target="grid_iframe";
	document.forms[0].submit();
}





function atualiza_resultados(){	
	obj = parent.conteudo.document.getElementById("label_resultados");
	var str = obj.innerHTML;
	if (document.all){ //IE
		var numero_registros = parseInt(str.slice(parseInt(str.search("de")+3),str.search("</F")))+1;		
		numero_registros += str.match(/<\/F.*$/);
	}else{ //Firefox
		var numero_registros = parseInt(str.slice(parseInt(str.search("de")+3),str.search("</f")))+1;		
		numero_registros += str.match(/<\/f.*$/);
	}
	obj.innerHTML =  str.match(/^.*de /) + numero_registros.toString()  ;	
}

function menu_vertical_link_paginas(url,table,others){
	
parent.conteudo.location.href=url+"?table="+table+"&zera_consulta=yes"+others;

//parent.conteudo.openAeroWindow('',10,'center',700,500,'Permissões do Sistema',url+"?table="+table+"&zera_consulta=yes"+others);
}





function move_frame(valor){
	var valor;
	document.getElementById("frameset").cols=valor+", 100%";
	
	var w=parent.document.getElementById("frameset").cols.split(",");			
	(parseInt(w[0])==0)?valor=216:valor=0;
}


function funcao(valor){
	var valor;
	move_frame(valor);
}





// <b style="color:black;background-color:#ff9999">Browser</b> Detection <b style="color:black;background-color:#a0ffff">Javascript</b>
// copyright 1 February 2003, by Stephen Chapman, Felgall Pty Ltd
 
// You have permission to copy and use this <b style="color:black;background-color:#a0ffff">javascript</b> provided that the content of the script is not changed in any way.
 
function whichBrs() {
    var agt=navigator.userAgent.toLowerCase();
    if (agt.indexOf("opera") != -1) return 'Opera';
    if (agt.indexOf("staroffice") != -1) return 'Star Office';
    if (agt.indexOf("webtv") != -1) return 'WebTV';
    if (agt.indexOf("beonex") != -1) return 'Beonex';
    if (agt.indexOf("chimera") != -1) return 'Chimera';
    if (agt.indexOf("netpositive") != -1) return 'NetPositive';
    if (agt.indexOf("phoenix") != -1) return 'Phoenix';
    if (agt.indexOf("firefox") != -1) return 'Firefox';
    if (agt.indexOf("safari") != -1) return 'Safari';
    if (agt.indexOf("skipstone") != -1) return 'SkipStone';
    if (agt.indexOf("msie") != -1) return 'Internet Explorer';
    if (agt.indexOf("netscape") != -1) return 'Netscape';
    if (agt.indexOf("mozilla/5.0") != -1) return 'Mozilla';
    if (agt.indexOf('\/') != -1) {
    if (agt.substr(0,agt.indexOf('\/')) != 'mozilla') {
        return navigator.userAgent.substr(0,agt.indexOf('\/'));}
    else return 'Netscape';} else if (agt.indexOf(' ') != -1)
        return navigator.userAgent.substr(0,agt.indexOf(' '));
    else return navigator.userAgent;
}



switch (whichBrs()){
	case "Internet Explorer": 	//IE
	var browser_width = 36;
	break;
	case "Firefox": 	//Firefox
	var browser_width = 36; 
	break;
	case "Safari": 	//Chrome
	var browser_width = 20;
	break;
	default:	
	var browser_width = 36; 
	break;
}

function motion_menu(){  
  var obj_img = document.getElementById("img_seta_menu");
   // var obj = parent.document.getElementById("botoes");
//	var obj = document.getElementById("menu_botoes");
  var w=parent.document.getElementById("frameset").cols.split(",");		
  if(Math.round(w[0])==browser_width){
	 var valor=216;
	 obj_img.src="../images/seta_left.gif";
	parent.document.body.overflow = "visible";
  }else{	  
     var valor=0;
	 obj_img.src="../images/seta_right.gif";
	parent.document.body.style.overflow = "visible";
  }


  //alert(w[0]+"-"+valor);
  parent.slowMotion(valor);
}

function slowMotion(valor){			
	function ml(){		
		var el=document.getElementById("frameset");
		el.sP=function(y){move_frame(y);}		
		return el;
	}		

	window.stayTopLeft=function(){
		var w=document.getElementById("frameset").cols.split(",");			
		if ((parseInt(w[0])==0)&&(valor==0)||(parseInt(w[0])>=214.5)&&(valor==216)){
			if (parseInt(w[0])>=214.5) move_frame(216);			
			if (parseInt(w[0])<=1) move_frame(browser_width);		
			return false;				
		}	
		var pY = 0;					
		if (w[0] != NaN) pY=w[0];		
		var aux=valor;
		aux += parseFloat(parseFloat(pY - aux)/1.3);		
		ftlObj.sP(aux);		
		if(valor==0){					
			if (Math.round(aux) <= valor) {clearTimeout(tempo);return false};
		}else{
			if (Math.round(aux) > valor) {clearTimeout(tempo);return false};
		}		
		tempo = setTimeout("stayTopLeft()", 10);		
	}
	ftlObj = ml();	
	stayTopLeft();	
}



//Formatação de numeros
//DE                1200.00
//Para        R$ 1.200,00

function formatCurrency(number){
        var num = new String (number);
        if (num.indexOf (".") == -1){
                intLen = num.length;
                toEnd = intLen;
                var strLeft = new String (num.substring (0, toEnd));
                var strRight = new String ("00");
        }else {
                pos = eval (num.indexOf ("."));
                var strLeft = new String (num.substring (0, pos));
                intToEnd = num.length;
                intThing = pos + 1;
                var strRight = new String (num.substring (intThing, intToEnd));
                if (strRight.length > 2){
                        nextInt = strRight.charAt(2);
                        if (nextInt >= 5){
                                strRight = new String (strRight.substring (0, 2));
                                strRight = new String (eval ((strRight * 1) + 1));
                                if((strRight * 1) >= 100){
                                   strRight = "00";
                                   strLeft = new String (eval ((strLeft * 1) + 1));
                                }
                                if (strRight.length <= 1){
                                   strRight = new String ("0" + strRight);
                                }
                        }else{
                                        strRight = new String (strRight.substring (0, 2));
                        }
                }else{
                                if (strRight.length != 2){
                                   strRight = strRight + "0";
                                }
                }
        }
        if (strLeft.length > 3){
                var curPos = (strLeft.length - 3);
                while (curPos > 0){
                        var remainingLeft = new String (strLeft.substring (0, curPos));
                        var strLeftLeft = new String (strLeft.substring (0, curPos));
                        var strLeftRight = new String (strLeft.substring (curPos, strLeft.length));
                        strLeft = new String (strLeftLeft + "." + strLeftRight);
                        curPos = (remainingLeft.length - 3);
                }
        }
        strWhole = strLeft + "," + strRight;
        // finalValue = 'R$ '+ strWhole;
        finalValue = strWhole;
        return (finalValue);
}




function formataReais(fld, milSep, decSep, e) {
   if ( e.charCode != 0){	// essa linha para o firefox
		if (fld.value.length > 17) return false;
        var sep = 0;
        var key = '';
        var i = j = 0;
        var len = len2 = 0;
        var strCheck = '0123456789';
        var aux = aux2 = '';
        var whichCode = (window.Event) ? e.which : e.keyCode;
        if (whichCode == 13) return true;
        key = String.fromCharCode(whichCode);  // Valor para o código da Chave
        if (strCheck.indexOf(key) == -1) return false;  // Chave inválida
        len = fld.value.length;
        for(i = 0; i < len; i++)
        if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)) break;
        aux = '';
        for(; i < len; i++)
        if (strCheck.indexOf(fld.value.charAt(i))!=-1) aux += fld.value.charAt(i);
        aux += key;
        len = aux.length;
        if (len == 0) fld.value = '';
        if (len == 1) fld.value = '0'+ decSep + '0' + aux;
        if (len == 2) fld.value = '0'+ decSep + aux;
        if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
        if (j == 3) {
        aux2 += milSep;
        j = 0;
        }
        aux2 += aux.charAt(i);
        j++;
        }
        fld.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        fld.value += aux2.charAt(i);
        fld.value += decSep + aux.substr(len - 2, len);
        }
        return false;
   }
}

/*
Descrição.: formata um campo do formulário de
acordo com a máscara informada...
Parâmetros: - objForm (o Objeto Form)
- strField (string contendo o nome do textbox)

* - sMask (mascara que define o
* formato que o dado será apresentado,
* usando o algarismo "9" para
* definir números e o símbolo "!" para
* qualquer caracter...
* - evtKeyPress (evento)
* Uso.......: <input type="textbox"
* name="xxx".....
* onkeypress="return txtBoxFormat(document.rcfDownload, 'str_cep', '99999-999', event);">
* Observação: As máscaras podem ser representadas como os exemplos abaixo:
* CEP -> 99.999-999
* CPF -> 999.999.999-99
* CNPJ -> 99.999.999/9999-99
* Data -> 99/99/9999
* Tel Resid -> (99) 999-9999
* Tel Cel -> (99) 9999-9999
* Processo -> 99.999999999/999-99
* C/C -> 999999-!
* E por aí vai...
***/
function txtBoxFormat(objForm, strField, sMask, evtKeyPress) {
		var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla;
		
		if(document.all) { // Internet Explorer
			nTecla = evtKeyPress.keyCode;
		} else if(document.layers) { // Nestcape
			nTecla = evtKeyPress.which;
		} else {
			nTecla = evtKeyPress.which;
			if (nTecla == 8) {
				return true;
			}
		}
		
		sValue = objForm[strField].value;
		// Limpa todos os caracteres de formatação que
		// já estiverem no campo.
		// toString().replace [transforma em sring e troca elementos por ""]
		sValue = sValue.toString().replace( "-", "" );
		sValue = sValue.toString().replace( "-", "" );
		sValue = sValue.toString().replace( ".", "" );
		sValue = sValue.toString().replace( ".", "" );
		sValue = sValue.toString().replace( "/", "" );
		sValue = sValue.toString().replace( "/", "" );
		sValue = sValue.toString().replace( "/", "" );
		sValue = sValue.toString().replace( "(", "" );
		sValue = sValue.toString().replace( "(", "" );
		sValue = sValue.toString().replace( ")", "" );
		sValue = sValue.toString().replace( ")", "" );
		sValue = sValue.toString().replace( " ", "" );
		sValue = sValue.toString().replace( " ", "" );
		fldLen = sValue.length;
		mskLen = sMask.length;
		
		i = 0;
		nCount = 0;
		sCod = "";
		mskLen = fldLen;
		
		while (i <= mskLen) {
		bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ":") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/"))
		bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " ") || (sMask.charAt(i) == "."))
		
		//Se for true utiliza elementos especiais aumenta a máscara
		if (bolMask) {
			sCod += sMask.charAt(i);
			mskLen++;
		//Caso false mostra o sValue(o q foi digitado)
		} else {
			sCod += sValue.charAt(nCount);
			nCount++;
		}
		i++;
		}
		
		objForm[strField].value = sCod;
		if (nTecla != 8) { // backspace
			if (sMask.charAt(i-1) == "9") { // apenas números...
			return ((nTecla > 47) && (nTecla < 58)); } // números de 0 a 9
		else { // qualquer caracter...
			return true;
		}
		} else {
			return true;
		}
}
//Fim da Função Máscaras Gerais



function txtBoxFormat_array(objForm, obj, sMask, evtKeyPress) {
		var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla;
		
		if(document.all) { // Internet Explorer
			nTecla = evtKeyPress.keyCode;
		} else if(document.layers) { // Nestcape
			nTecla = evtKeyPress.which;
		} else {
			nTecla = evtKeyPress.which;
			if (nTecla == 8) {
				return true;
			}
		}
		
		sValue = obj.value;
		// Limpa todos os caracteres de formatação que
		// já estiverem no campo.
		// toString().replace [transforma em sring e troca elementos por ""]
		sValue = sValue.toString().replace( "-", "" );
		sValue = sValue.toString().replace( "-", "" );
		sValue = sValue.toString().replace( ".", "" );
		sValue = sValue.toString().replace( ".", "" );
		sValue = sValue.toString().replace( "/", "" );
		sValue = sValue.toString().replace( "/", "" );
		sValue = sValue.toString().replace( "/", "" );
		sValue = sValue.toString().replace( "(", "" );
		sValue = sValue.toString().replace( "(", "" );
		sValue = sValue.toString().replace( ")", "" );
		sValue = sValue.toString().replace( ")", "" );
		sValue = sValue.toString().replace( " ", "" );
		sValue = sValue.toString().replace( " ", "" );
		fldLen = sValue.length;
		mskLen = sMask.length;
		
		i = 0;
		nCount = 0;
		sCod = "";
		mskLen = fldLen;
		
		while (i <= mskLen) {
		bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ":") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/"))
		bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " ") || (sMask.charAt(i) == "."))
		
		//Se for true utiliza elementos especiais aumenta a máscara
		if (bolMask) {
			sCod += sMask.charAt(i);
			mskLen++;
		//Caso false mostra o sValue(o q foi digitado)
		} else {
			sCod += sValue.charAt(nCount);
			nCount++;
		}
		i++;
		}
		
		obj.value = sCod;
		if (nTecla != 8) { // backspace
			if (sMask.charAt(i-1) == "9") { // apenas números...
			return ((nTecla > 47) && (nTecla < 58)); } // números de 0 a 9
		else { // qualquer caracter...
			return true;
		}
		} else {
			return true;
		}
}
//Fim da Função Máscaras Gerais


function alterar_senha(form){
	
	var vetor = new Array ( "senha", "confirmar_senha");		
	var msg= new Array( "nova senha", "confirmar nova senha");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }		 
	 
	if (form.senha.value.length < 8){
		alert("Sua nova senha deve ter pelo menos 8 digitos");
		form.value="";
		form.senha.value="";
		form.confirmar_senha.value="";
		form.senha.focus();
		return false;
	}
	
	
	if (paridade_alterar_senha(form)){
		form.target = "grid_iframe";
		form.action = "./php/operacoes.php?alterar_senha=yes";
		form.submit();
	}	
}


function ativar_usuario(row){	
		open("operacoes.php?ativar_usuario=yes&row="+row,'grid_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');		
}






				  
				  











function relatorio_filtro_login(value){
open('ajax_open_data.php?relatorio_filtro_login=yes&id_usuario='+value,'action_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');
}






 
	
  





function valida_data_relatorio(data_inicio,data_fim){	
	var diff = subtrai_data(data_inicio,data_fim);
	if(diff<0){		
		alert("Data Inicio ( "+data_inicio+" ) não pode ser maior que Data Fim ( "+data_fim+" )");
	}else{
	    if (diff == 0){			
			var hora_inicial = document.forms[0].elements["hora_inicial"].value;
			var hora_final = document.forms[0].elements["hora_final"].value;			
			if (hora_final < hora_inicial){
				alert("Hora Inicial não pode ser maior que Hora Final no mesmo dia");
			}else{
				return true;	
			}
		}else{
			 return true;	
		}	
	}
}



 






function validaCPF(obj) {		
  cpf = obj.value;
  valor = true;
  erro = new String;
  if (cpf.length < 11) erro += "Sao necessarios 11 digitos para verificacao do CPF! \n\n"; 
  
  //substituir os caracteres que nao sao numeros
	if(document.layers && parseInt(navigator.appVersion) == 4){
	x = cpf.substring(0,3);
	x += cpf.substring(4,7);
	x += cpf.substring(8,11);
	x += cpf.substring(12,14);
	cpf = x; 
	} else {
	cpf = cpf.replace(".","");
	cpf = cpf.replace(".","");
	cpf = cpf.replace("-","");
	}
 
  var nonNumbers = /\D/;
  if (nonNumbers.test(cpf)) erro += "A verificacao de CPF suporta apenas numeros! \n\n"; 
  if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999"){
    erro += "Numero de CPF invalido!"
  }
  var a = [];
  var b = new Number;
  var c = 11;
  for (i=0; i<11; i++){
  a[i] = cpf.charAt(i);
  if (i < 9) b += (a[i] *  --c);
  }
  if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
  b = 0;
  c = 11;
  for (y=0; y<10; y++) b += (a[y] *  c--); 
  if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
  if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10])){
  erro +="Digito verificador com problema!";
  }
  if (erro.length > 0){
		if (obj.value == "") return false;
		alert(erro);
		obj.value = "";
		obj.focus();
		return false;  
  }else{
	//alert("CPF valido!");		
	  
  }
  return true;
}



function validaCNPJ(obj) {
	CNPJ = obj.value; 
	erro = new String;
	if (CNPJ.length < 18) erro += "É necessario preencher corretamente o numero do CNPJ! \n\n";
	if ((CNPJ.charAt(2) != ".") || (CNPJ.charAt(6) != ".") || (CNPJ.charAt(10) != "/") || (CNPJ.charAt(15) != "-")){
	if (erro.length == 0) erro += "É necessario preencher corretamente o numero do CNPJ! \n\n";
	}
	//substituir os caracteres que nao sao numeros
	if(document.layers && parseInt(navigator.appVersion) == 4){
	x = CNPJ.substring(0,2);
	x += CNPJ.substring(3,6);
	x += CNPJ.substring(7,10);
	x += CNPJ.substring(11,15);
	x += CNPJ.substring(16,18);
	CNPJ = x; 
	} else {
	CNPJ = CNPJ.replace(".","");
	CNPJ = CNPJ.replace(".","");
	CNPJ = CNPJ.replace("-","");
	CNPJ = CNPJ.replace("/","");
	}
	
	var nonNumbers = /\D/;
	if (nonNumbers.test(CNPJ)) erro += "A verificacao de CNPJ suporta apenas numeros! \n\n"; 
	var a = [];
	var b = new Number;
	var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
	for (i=0; i<12; i++){
	a[i] = CNPJ.charAt(i);
	b += a[i] * c[i+1];
	}
	if ((x = b % 11) < 2) { a[12] = 0 } else { a[12] = 11-x }
	b = 0;
	for (y=0; y<13; y++) {
	b += (a[y] * c[y]); 
	}
	if ((x = b % 11) < 2) { a[13] = 0; } else { a[13] = 11-x; }
	if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){
	erro +="Digito verificador com problema!";
	}
	
	if (obj.value=="00.000.000/0000-00"){
		erro +="Não existe esse CNPJ!";
	}
	
	if (erro.length > 0){
		if(obj.form.login){			
			obj.form.login.value = obj.value;			
		}		
		if (obj.value == "") return false;
		alert(erro);
		obj.value = "";
		obj.focus();
		return false;
	} else {		
		//alert("CNPJ valido!");		
		if(obj.form.login){			
			obj.form.login.value = obj.value;			
		}
	}
	return true;
	
}


function imprimir_bloco(obj){
	var docprint=open('','print_new','width='+screen.width+',height='+screen.height+',scrollbars=yes,statusbar=no,location=no,status=no,menubar=no,resizable=no,fullscreen=yes'); 
	docprint.document.open(); 
	docprint.document.write("<html><head><title></title>"); 
	docprint.document.write('</head><body onLoad="self.print();"  leftmargin=0 topmargin=0 scrollbars=yes marginwidth=0 marginheigth=0 >');          
	docprint.document.write(no_image(obj.parentNode.parentNode.parentNode.parentNode.innerHTML));   
	docprint.document.write("</body></html>"); 
	docprint.document.close(); 
	docprint.focus(); 
	
	
}

function exporta_consulta(tipo){	
	var form = document.frmLocalizar;
	//document.getElementById("portable_data").value = document.getElementById("tabela").innerHTML;	
	
	switch (tipo){
		  case "html":
			  form.target = "new_window"+tipo;
			  open('','new_window'+tipo,'width='+screen.width+',height='+screen.height+',scrollbars=yes,statusbar=no,location=no,status=no,menubar=no,resizable=no,fullscreen=yes');
			  break;
		  case "excel":
			  form.target = "grid_iframe";
			  break;		
		  case "csv":
			  form.target = "grid_iframe";
			  break;	
		  case "pdf":
			  form.target = "_blank";	
			  break;	
		  case "xml":
			  form.target = "_blank";	
			  break;	
		  default:
			  form.target = "new_window"+tipo;
			  break;			  
	}	
	var cell_conteudo = [];
	var obj = document;
	var itens = obj.getElementById("tabela");	
	var total_linhas = obj.getElementById("tabela").rows.length;//numero de linhas da tabela
	
	for (i=0; i<total_linhas; i++){		
		cell_conteudo[i] = [];					
		for (j=0; j<itens.rows[i].cells.length; j++){	
			if (itens.rows[i].cells[j].innerHTML.search(/<select.*/i) >= 0){
				var index = itens.rows[i].cells[j].childNodes[0].selectedIndex;	
				cell_conteudo[i][j] = itens.rows[i].cells[j].childNodes[0].options[index].innerHTML;
			}else{
				cell_conteudo[i][j] =  no_tags(itens.rows[i].cells[j].innerHTML).replace(/&nbsp;/g, "");						
			}
		}
	}					
	form.matrix_data.value =  encodeURIComponent(serialize(cell_conteudo));			
	 var myDate = new Date();
	 form.method = "POST";
	 form.action = "exportar_dados.php?time="+myDate.getTime()+"&tipo="+tipo;
	 form.submit();	
}

function js_array_serialize(a) {
    return JSON.stringify(a);
}

function serialize_array(a, limit) {
	if(!a.sort)
		return a;
	else if(!limit)
		return "?";
	var b = [];
	for(var i in a)
		b.push(serialize_array(a[i], limit - 1));
	return "[" + b.join(",") + "]";
}

function base64_encode (data) {
  // http://kevin.vanzonneveld.net
  // +   original by: Tyler Akins (http://rumkin.com)
  // +   improved by: Bayron Guevara
  // +   improved by: Thunder.m
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: Pellentesque Malesuada
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   improved by: Rafal Kukawski (http://kukawski.pl)
  // *     example 1: base64_encode('Kevin van Zonneveld');
  // *     returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
  // mozilla has this native
  // - but breaks in 2.0.0.12!
  //if (typeof this.window['btoa'] == 'function') {
  //    return btoa(data);
  //}
  var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
    ac = 0,
    enc = "",
    tmp_arr = [];

  if (!data) {
    return data;
  }

  do { // pack three octets into four hexets
    o1 = data.charCodeAt(i++);
    o2 = data.charCodeAt(i++);
    o3 = data.charCodeAt(i++);

    bits = o1 << 16 | o2 << 8 | o3;

    h1 = bits >> 18 & 0x3f;
    h2 = bits >> 12 & 0x3f;
    h3 = bits >> 6 & 0x3f;
    h4 = bits & 0x3f;

    // use hexets to index into b64, and append result to encoded string
    tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
  } while (i < data.length);

  enc = tmp_arr.join('');

  var r = data.length % 3;

  return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);

}


function json_encode (mixed_val) {
  // http://kevin.vanzonneveld.net
  // +      original by: Public Domain (http://www.json.org/json2.js)
  // + reimplemented by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +      improved by: Michael White
  // +      input by: felix
  // +      bugfixed by: Brett Zamir (http://brett-zamir.me)
  // *        example 1: json_encode(['e', {pluribus: 'unum'}]);
  // *        returns 1: '[\n    "e",\n    {\n    "pluribus": "unum"\n}\n]'
/*
    http://www.JSON.org/json2.js
    2008-11-19
    Public Domain.
    NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.
    See http://www.JSON.org/js.html
  */
  var retVal, json = this.window.JSON;
  try {
    if (typeof json === 'object' && typeof json.stringify === 'function') {
      retVal = json.stringify(mixed_val); // Errors will not be caught here if our own equivalent to resource
      //  (an instance of PHPJS_Resource) is used
      if (retVal === undefined) {
        throw new SyntaxError('json_encode');
      }
      return retVal;
    }

    var value = mixed_val;

    var quote = function (string) {
      var escapable = /[\\\"\u0000-\u001f\u007f-\u009f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;
      var meta = { // table of character substitutions
        '\b': '\\b',
        '\t': '\\t',
        '\n': '\\n',
        '\f': '\\f',
        '\r': '\\r',
        '"': '\\"',
        '\\': '\\\\'
      };

      escapable.lastIndex = 0;
      return escapable.test(string) ? '"' + string.replace(escapable, function (a) {
        var c = meta[a];
        return typeof c === 'string' ? c : '\\u' + ('0000' + a.charCodeAt(0).toString(16)).slice(-4);
      }) + '"' : '"' + string + '"';
    };

    var str = function (key, holder) {
      var gap = '';
      var indent = '    ';
      var i = 0; // The loop counter.
      var k = ''; // The member key.
      var v = ''; // The member value.
      var length = 0;
      var mind = gap;
      var partial = [];
      var value = holder[key];

      // If the value has a toJSON method, call it to obtain a replacement value.
      if (value && typeof value === 'object' && typeof value.toJSON === 'function') {
        value = value.toJSON(key);
      }

      // What happens next depends on the value's type.
      switch (typeof value) {
      case 'string':
        return quote(value);

      case 'number':
        // JSON numbers must be finite. Encode non-finite numbers as null.
        return isFinite(value) ? String(value) : 'null';

      case 'boolean':
      case 'null':
        // If the value is a boolean or null, convert it to a string. Note:
        // typeof null does not produce 'null'. The case is included here in
        // the remote chance that this gets fixed someday.
        return String(value);

      case 'object':
        // If the type is 'object', we might be dealing with an object or an array or
        // null.
        // Due to a specification blunder in ECMAScript, typeof null is 'object',
        // so watch out for that case.
        if (!value) {
          return 'null';
        }
        if ((this.PHPJS_Resource && value instanceof this.PHPJS_Resource) || (window.PHPJS_Resource && value instanceof window.PHPJS_Resource)) {
          throw new SyntaxError('json_encode');
        }

        // Make an array to hold the partial results of stringifying this object value.
        gap += indent;
        partial = [];

        // Is the value an array?
        if (Object.prototype.toString.apply(value) === '[object Array]') {
          // The value is an array. Stringify every element. Use null as a placeholder
          // for non-JSON values.
          length = value.length;
          for (i = 0; i < length; i += 1) {
            partial[i] = str(i, value) || 'null';
          }

          // Join all of the elements together, separated with commas, and wrap them in
          // brackets.
          v = partial.length === 0 ? '[]' : gap ? '[\n' + gap + partial.join(',\n' + gap) + '\n' + mind + ']' : '[' + partial.join(',') + ']';
          gap = mind;
          return v;
        }

        // Iterate through all of the keys in the object.
        for (k in value) {
          if (Object.hasOwnProperty.call(value, k)) {
            v = str(k, value);
            if (v) {
              partial.push(quote(k) + (gap ? ': ' : ':') + v);
            }
          }
        }

        // Join all of the member texts together, separated with commas,
        // and wrap them in braces.
        v = partial.length === 0 ? '{}' : gap ? '{\n' + gap + partial.join(',\n' + gap) + '\n' + mind + '}' : '{' + partial.join(',') + '}';
        gap = mind;
        return v;
      case 'undefined':
        // Fall-through
      case 'function':
        // Fall-through
      default:
        throw new SyntaxError('json_encode');
      }
    };

    // Make a fake root object containing our value under the key of ''.
    // Return the result of stringifying the value.
    return str('', {
      '': value
    });

  } catch (err) { // Todo: ensure error handling above throws a SyntaxError in all cases where it could
    // (i.e., when the JSON global is not available and there is an error)
    if (!(err instanceof SyntaxError)) {
      throw new Error('Unexpected error type in json_encode()');
    }
    this.php_js = this.php_js || {};
    this.php_js.last_error_json = 4; // usable by json_last_error()
    return null;
  }
}

function serialize (mixed_value) {
  // http://kevin.vanzonneveld.net
  // +   original by: Arpad Ray (mailto:arpad@php.net)
  // +   improved by: Dino
  // +   bugfixed by: Andrej Pavlovic
  // +   bugfixed by: Garagoth
  // +      input by: DtTvB (http://dt.in.th/2008-09-16.string-length-in-bytes.html)
  // +   bugfixed by: Russell Walker (http://www.nbill.co.uk/)
  // +   bugfixed by: Jamie Beck (http://www.terabit.ca/)
  // +      input by: Martin (http://www.erlenwiese.de/)
  // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net/)
  // +   improved by: Le Torbi (http://www.letorbi.de/)
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net/)
  // +   bugfixed by: Ben (http://benblume.co.uk/)
  // %          note: We feel the main purpose of this function should be to ease the transport of data between php & js
  // %          note: Aiming for PHP-compatibility, we have to translate objects to arrays
  // *     example 1: serialize(['Kevin', 'van', 'Zonneveld']);
  // *     returns 1: 'a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}'
  // *     example 2: serialize({firstName: 'Kevin', midName: 'van', surName: 'Zonneveld'});
  // *     returns 2: 'a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}'
  var val, key, okey,
    ktype = '', vals = '', count = 0,
    _utf8Size = function (str) {
      var size = 0,
        i = 0,
        l = str.length,
        code = '';
      for (i = 0; i < l; i++) {
        code = str.charCodeAt(i);
        if (code < 0x0080) {
          size += 1;
        }
        else if (code < 0x0800) {
          size += 2;
        }
        else {
          size += 3;
        }
      }
      return size;
    },
    _getType = function (inp) {
      var match, key, cons, types, type = typeof inp;

      if (type === 'object' && !inp) {
        return 'null';
      }
      if (type === 'object') {
        if (!inp.constructor) {
          return 'object';
        }
        cons = inp.constructor.toString();
        match = cons.match(/(\w+)\(/);
        if (match) {
          cons = match[1].toLowerCase();
        }
        types = ['boolean', 'number', 'string', 'array'];
        for (key in types) {
          if (cons == types[key]) {
            type = types[key];
            break;
          }
        }
      }
      return type;
    },
    type = _getType(mixed_value)
  ;

  switch (type) {
    case 'function':
      val = '';
      break;
    case 'boolean':
      val = 'b:' + (mixed_value ? '1' : '0');
      break;
    case 'number':
      val = (Math.round(mixed_value) == mixed_value ? 'i' : 'd') + ':' + mixed_value;
      break;
    case 'string':
      val = 's:' + _utf8Size(mixed_value) + ':"' + mixed_value + '"';
      break;
    case 'array': case 'object':
      val = 'a';
  /*
        if (type == 'object') {
          var objname = mixed_value.constructor.toString().match(/(\w+)\(\)/);
          if (objname == undefined) {
            return;
          }
          objname[1] = this.serialize(objname[1]);
          val = 'O' + objname[1].substring(1, objname[1].length - 1);
        }
        */

      for (key in mixed_value) {
        if (mixed_value.hasOwnProperty(key)) {
          ktype = _getType(mixed_value[key]);
          if (ktype === 'function') {
            continue;
          }

          okey = (key.match(/^[0-9]+$/) ? parseInt(key, 10) : key);
          vals += this.serialize(okey) + this.serialize(mixed_value[key]);
          count++;
        }
      }
      val += ':' + count + ':{' + vals + '}';
      break;
    case 'undefined':
      // Fall-through
    default:
      // if the JS object has a property which contains a null value, the string cannot be unserialized by PHP
      val = 'N';
      break;
  }
  if (type !== 'object' && type !== 'array') {
    val += ';';
  }
  return val;
}




function unserialize (data) {
  // http://kevin.vanzonneveld.net
  // +     original by: Arpad Ray (mailto:arpad@php.net)
  // +     improved by: Pedro Tainha (http://www.pedrotainha.com)
  // +     bugfixed by: dptr1988
  // +      revised by: d3x
  // +     improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +        input by: Brett Zamir (http://brett-zamir.me)
  // +     improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +     improved by: Chris
  // +     improved by: James
  // +        input by: Martin (http://www.erlenwiese.de/)
  // +     bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +     improved by: Le Torbi
  // +     input by: kilops
  // +     bugfixed by: Brett Zamir (http://brett-zamir.me)
  // +      input by: Jaroslaw Czarniak
  // %            note: We feel the main purpose of this function should be to ease the transport of data between php & js
  // %            note: Aiming for PHP-compatibility, we have to translate objects to arrays
  // *       example 1: unserialize('a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}');
  // *       returns 1: ['Kevin', 'van', 'Zonneveld']
  // *       example 2: unserialize('a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}');
  // *       returns 2: {firstName: 'Kevin', midName: 'van', surName: 'Zonneveld'}
  var that = this,
    utf8Overhead = function (chr) {
      // http://phpjs.org/functions/unserialize:571#comment_95906
      var code = chr.charCodeAt(0);
      if (code < 0x0080) {
        return 0;
      }
      if (code < 0x0800) {
        return 1;
      }
      return 2;
    },
    error = function (type, msg, filename, line) {
      throw new that.window[type](msg, filename, line);
    },
    read_until = function (data, offset, stopchr) {
      var i = 2, buf = [], chr = data.slice(offset, offset + 1);

      while (chr != stopchr) {
        if ((i + offset) > data.length) {
          error('Error', 'Invalid');
        }
        buf.push(chr);
        chr = data.slice(offset + (i - 1), offset + i);
        i += 1;
      }
      return [buf.length, buf.join('')];
    },
    read_chrs = function (data, offset, length) {
      var i, chr, buf;

      buf = [];
      for (i = 0; i < length; i++) {
        chr = data.slice(offset + (i - 1), offset + i);
        buf.push(chr);
        length -= utf8Overhead(chr);
      }
      return [buf.length, buf.join('')];
    },
    _unserialize = function (data, offset) {
      var dtype, dataoffset, keyandchrs, keys,
        readdata, readData, ccount, stringlength,
        i, key, kprops, kchrs, vprops, vchrs, value,
        chrs = 0,
        typeconvert = function (x) {
          return x;
        };

      if (!offset) {
        offset = 0;
      }
      dtype = (data.slice(offset, offset + 1)).toLowerCase();

      dataoffset = offset + 2;

      switch (dtype) {
        case 'i':
          typeconvert = function (x) {
            return parseInt(x, 10);
          };
          readData = read_until(data, dataoffset, ';');
          chrs = readData[0];
          readdata = readData[1];
          dataoffset += chrs + 1;
          break;
        case 'b':
          typeconvert = function (x) {
            return parseInt(x, 10) !== 0;
          };
          readData = read_until(data, dataoffset, ';');
          chrs = readData[0];
          readdata = readData[1];
          dataoffset += chrs + 1;
          break;
        case 'd':
          typeconvert = function (x) {
            return parseFloat(x);
          };
          readData = read_until(data, dataoffset, ';');
          chrs = readData[0];
          readdata = readData[1];
          dataoffset += chrs + 1;
          break;
        case 'n':
          readdata = null;
          break;
        case 's':
          ccount = read_until(data, dataoffset, ':');
          chrs = ccount[0];
          stringlength = ccount[1];
          dataoffset += chrs + 2;

          readData = read_chrs(data, dataoffset + 1, parseInt(stringlength, 10));
          chrs = readData[0];
          readdata = readData[1];
          dataoffset += chrs + 2;
          if (chrs != parseInt(stringlength, 10) && chrs != readdata.length) {
            error('SyntaxError', 'String length mismatch');
          }
          break;
        case 'a':
          readdata = {};

          keyandchrs = read_until(data, dataoffset, ':');
          chrs = keyandchrs[0];
          keys = keyandchrs[1];
          dataoffset += chrs + 2;

          for (i = 0; i < parseInt(keys, 10); i++) {
            kprops = _unserialize(data, dataoffset);
            kchrs = kprops[1];
            key = kprops[2];
            dataoffset += kchrs;

            vprops = _unserialize(data, dataoffset);
            vchrs = vprops[1];
            value = vprops[2];
            dataoffset += vchrs;

            readdata[key] = value;
          }

          dataoffset += 1;
          break;
        default:
          error('SyntaxError', 'Unknown / Unhandled data type(s): ' + dtype);
          break;
      }
      return [dtype, dataoffset - offset, typeconvert(readdata)];
    }
  ;

  return _unserialize((data + ''), 0)[2];
}


function Remote(value) {	
	 window.open('../swf/preabertura.php?senha_inicial='+value,'vRemote','location=no,toolbar=no,directories=no,width=+800+,height=+600+,status=no,menubar=no,scrollbars=no,resizable=no,fullscreen=yes');
} 



function atualiza_conteudo(url,params,method,handleHttpResponse){
	var myDate = new Date();
	http.open(method, url+"?"+params+"&time="+myDate.getTime(), true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=ISO-8859-1");
	http.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
	http.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
	http.setRequestHeader("Pragma", "no-cache");
	eval('http.onreadystatechange = '+handleHttpResponse+';');
	http.send(params); //passagem por post
}






 
 
 

function handleHttpBairro()//para retornar num select
{	
	for (x=1;x<=1;x++){
		eval('campo_select = document.forms[0].cod_logradouro_ref_'+x+';');
		if (http.readyState == 4) {
			campo_select.options.length = 0;		
			results = http.responseText.split(",");
			campo_select.options[0] = new Option( 'Escolha uma referência', '' );
			for( i = 0; i < results.length-1; i++ ){ 
				string = trim(results[i]).split( "|" );
				//if (trim(string[0])==document.getElementById("subcategoria_value").value){
				//campo_select.options[i] = new Option( string[0], string[1], "", 'selected' );
				//}else{
					campo_select.options[i+1] = new Option( string[0], string[1] );
				//}
			}
		}
	}
	
}

function handleHttpResponse2()//para retornar num select
{
campo_select = document.forms[0].cod_bairro;
if (http.readyState == 4) {
campo_select.options.length = 0;
results = http.responseText.split(",");
for( i = 0; i < results.length-1; i++ )
{ 
string = trim(results[i]).split( "|" );
campo_select.options[i] = new Option( string[0], string[1] );
}
}
}

function handleHttpResponse()//para retornar num select
{
	campo_select = document.forms[0].subcategoria;
	if (http.readyState == 4) {
		campo_select.options.length = 0;
		results = http.responseText.split(",");
		for( i = 0; i < results.length-1; i++ ){ 
			string = trim(results[i]).split( "|" );
			if (trim(string[0])==document.getElementById("subcategoria_value").value){
				campo_select.options[i] = new Option( string[0], string[1], "", 'selected' );
			}else{
				campo_select.options[i] = new Option( string[0], string[1] );
			}
		}
	}
}

function handleHttpResponse_texto() //para retornar texto
{
campo_text = document.forms[0].subcategoria;
if (http.readyState == 4) {
campo_text = http.responseText;
}
}

function pesquisar_dados( name,valor){		

switch (name){
	case "regiao":
		http.open("GET", "ajax_open_data.php?cod_"+name+"=" + valor, true);
		http.onreadystatechange = handleHttpResponse2;
		break;
	case "categoria":	
		http.open("GET", "ajax_open_data.php?cod_"+name+"=" + valor, true);
		http.onreadystatechange = handleHttpResponse;		
		break;
	case "cod_bairro":		
		http.open("GET", "ajax_open_data.php?"+name+"=" + valor, true);
		http.onreadystatechange = handleHttpBairro;		
		break;
	default:
		break	
}
http.send(null);
}


function busca_cep(obj){
	if(obj.value.length == 9){
		var myDate = new Date();
		var str = obj.value.replace("-","");	
	atualiza_conteudo("ajax_open_data.php","busca_cep=yes&cep="+str+"&time="+myDate.getTime(),"GET","handleHttpbuscacep");
	}
}

function handleHttpbuscacep(){ //para retornar texto
        if(http.readyState < 4) {
            //document.getElementById("").innerHTML= "Loading...";
        }		
		
        if (http.readyState == 4) {
                if (http.status ==200) {										
					results = http.responseText.split("#split#");
					document.form_area.endereco.value=(results[0] == "")?"":results[0];
					document.form_area.bairro.value=(results[1] == "")?"":results[1];
					document.form_area.tipo_logradouro.value=(results[2] == "")?"":results[2];
					document.form_area.cod_logradouro.value=(results[3] == "")?"":results[3];
					document.form_area.numero.focus();
                } else {
                   alert("Houve um problema ao obter os dados:\n" + http.statusText);                   
                }
        }
}

function handleHttpCategoria(){//para retornar num select	
	campo_select = document.getElementById("subcategoria");
	
	if (http.readyState == 4) {
		campo_select.options.length = 0;
		//alert(http.responseText);
		results = http.responseText.split("##ajax_split##");			
		
		campo_select.options[0] = new Option( 'selecione', '' );
		for( i = 0; i < results.length-1; i++ ){ 		
			string = trim(results[i]).split( "|" );			
			if (trim(string[0])==document.getElementById("subcategoria_value").value){
				campo_select.options[i+1] = new Option( string[0], string[1], "", 'selected' );
			}else{
				campo_select.options[i+1] = new Option( string[0], string[1] );
			}
		}				
		//value_str=results[i];
		//while (value_str.search("010101") > 0){
			//value_str=value_str.replace("010101",",");
		//}
		//document.getElementById("descricao").innerHTML=value_str;
		//document.getElementById("resultado_busca").style.display="none";
		//document.getElementById("pesquisar").value="";	
		//document.getElementById("pesquisar").focus();	
	}
}
function handleHttpSubcategoria(){			
		if (http.readyState == 4) {			
		//alert(http.responseText);
	//	results = http.responseText;			
	//	document.getElementById("categoria_resultados").innerHTML=results;		
	
		//	results = http.responseText.split(",");			
			//for( i = 0; i < results.length-1; i++ ){ 
				//string = trim(results[i]).split( "|" );
				//if (trim(string[0])==document.getElementById("subcategoria_value").value){
				//campo_select.options[i] = new Option( string[0], string[1], "", 'selected' );
				//}else{
					//campo_select.options[i+1] = new Option( string[0], string[1] );
				//}
			//}
		}	
}




			

function mostra(n,t){
var str_botoes;
var x;
str_botoes="";
for (x=1;x<=t;x++){
	str_botoes=str_botoes+"anexo"+x+",";
}
str_botoes=str_botoes.slice(0,str_botoes.length-1);
esconde(str_botoes);

	  for (x=1;x<=n;x++){	  		  	
		document.getElementById("div_anexo"+x).style.display = "";
		document.getElementById("anexo"+x).removeAttribute('disabled');
      }
}	

function esconde(str_botoes){	
	   var vetor=str_botoes.split(",");
	  var x;
	  for (x=0;x<vetor.length;x++){	  	
	  	//alert(vetor[x])
		document.getElementById("div_"+ vetor[x]).style.display = "none";
		document.getElementById(vetor[x]).setAttribute('disabled',true);

      }
}		
	

			
			
function handleHttpResponseCidade2(){//para retornar num select
	campo_select = document.cadastro_form.id_municipio;
	if (http.readyState == 4) {
		//alert(http.responseText);
		campo_select.options.length = 0;
		results = http.responseText.split(",");
		for( i = 0; i < results.length-1; i++ ){			
				string = trim(results[i]).split( "|" );	
				campo_select.options[i] = new Option( string[0], string[1] );		
		}
		
		
		var conteudo = document.createElement('div');
		conteudo.innerHTML=http.responseText;
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}			
	}
}


function handleHttpResponseCidade(){//para retornar num select

	campo_select = document.tela_meu_cadastro_form.id_municipio;
	if (http.readyState == 4) {
		campo_select.options.length = 0;
		results = http.responseText.split(",");
		for( i = 0; i < results.length-1; i++ ){			
				string = trim(results[i]).split( "|" );	
				campo_select.options[i] = new Option( string[0], string[1] );		
		}
		
		
		var conteudo = document.createElement('div');
		conteudo.innerHTML=http.responseText;
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}			
	}
}







function handleHttpResponseCategoria(){//para retornar num select

	campo_select = document.forms[0].id_subcategoria;
	if (http.readyState == 4) {
		campo_select.options.length = 0;
		campo_select.options[0] = new Option( 'Selecione uma SubCategoria', '' );
		results = http.responseText.split("##ajax_split##");
		for( i = 0; i < results.length-1; i++ ){			
				string = trim(results[i]).split( "|" );	
				campo_select.options[i+1] = new Option( string[0], string[1] );		
		}
		
		
		var conteudo = document.createElement('div');
		conteudo.innerHTML=http.responseText;
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}		
		
		if(document.forms[0].id_pergunta) {
			document.forms[0].id_pergunta.options.length = 0;
		}
		
		document.getElementById("texto_pergunta_opcao").style.display ="none";
	}
}





function handleHttpResponsePerguntas(){//para retornar num select
	campo_select = document.forms[0].id_pergunta;
	if (http.readyState == 4) {
		campo_select.options.length = 0;
		campo_select.options[0] = new Option( 'Selecione uma Pergunta', '' );
		//alert(http.responseText);
		results = http.responseText.split("##ajax_split##");
		for( i = 0; i < results.length-1; i++ ){			
				string = trim(results[i]).split( "|" );	
				campo_select.options[i+1] = new Option( string[0], string[1] );		
		}		
		
		var conteudo = document.createElement('div');
		conteudo.innerHTML=http.responseText;
		
	//	document.getElementById("texto_pergunta_opcao").innerHTML = string[0];
		
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}			
		
		document.getElementById("texto_pergunta_opcao").style.display ="none";
	}
}
function handleHttpResponseOpcoes(){//para retornar num select
	
	if (http.readyState == 4) {
		document.getElementById("texto_pergunta_opcao").style.display ="";
		
		document.getElementById("texto_pergunta_opcao").innerHTML = http.responseText;		
		
		var id_campanha =  document.forms[0].id_campanha.options[document.forms[0].id_campanha.selectedIndex].value;
		
		var id_subcategoria =  document.forms[0].id_subcategoria.options[document.forms[0].id_subcategoria.selectedIndex].value;
		
		var id_categoria =  document.forms[0].id_categoria.options[document.forms[0].id_categoria.selectedIndex].value;
		
		var id_pergunta =  document.forms[0].id_pergunta.options[document.forms[0].id_pergunta.selectedIndex].value;
		
		
		var myDate = new Date();
		document.getElementById("grid").src = "listar.php?table=opcoes&"+'id_campanha='+id_campanha+'&id_categoria='+id_categoria+'&id_subcategoria='+id_subcategoria +'&id_pergunta='+id_pergunta+'&titulo=opcoes&time='+myDate.getTime();

		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}		
	}

}






  function checkbox_all(form,obj,arrayName){	  

	if(obj.checked){	
		   if (form.elements[arrayName].length==undefined){
			   	   form.elements[arrayName].checked = true;		
				   this.scroll(0,99999999);	   
		   }else{				
			   for(i= 0;i<form.elements[arrayName].length;i++){		
				   form.elements[arrayName][i].checked = true;		
				   this.scroll(0,99999999);
			   }
		   }
	}else{
		   if (form.elements[arrayName].length==undefined){
				   form.elements[arrayName].checked = false;	
				   this.scroll(0,0);		   
		   }else{						
			   for(i= 0;i<form.elements[arrayName].length;i++){
				   form.elements[arrayName][i].checked = false;	
				   this.scroll(0,0);
			   }
		   }
	}  
  }
  
  
  
  function change_event_state(obj,id_tipo){		
open('operacoes.php?change_event_state_'+obj.name+'=yes&state='+obj.checked+'&id_tipo='+id_tipo,'grid_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');
}





function  valida_modalidade(form){	
	var vetor = new Array ("tipo", "standard_title");		
	var msg= new Array("Modalidade", "Título");	
		
	for (x=0;x<vetor.length;x++){	  					
	   	if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			form.elements[vetor[x]].focus();	
			return(0);
		}		
     }	
	 return true;
}


function alterar_modalidade(form){		
	if (valida_modalidade(form)){
		document.frmcadastro.action="operacoes.php?alterar_texto_padrao_modalidade=yes";
		document.frmcadastro.target = "grid_iframe";
		document.frmcadastro.submit();
	}
}
  
  
function incluir_modalidade(form){	
	if (valida_modalidade(form)){
		document.frmcadastro.action="operacoes.php?incluir_texto_padrao_modalidade=yes";
		document.frmcadastro.target = "grid_iframe";
		document.frmcadastro.submit();	
	}
}



function handleHttpRefreshMenu(){//para retornar num select
	if (http.readyState == 4) {		
		parent.parent.window.document.getElementById("menu").innerHTML = http.responseText;
		parent.init_menu();
		alert("Ordem da Modalidade Alterada com Sucesso!");	
	}
}


function handleHttpAlteraMenu(){//para retornar num select
	if (http.readyState == 4) {		
		parent.parent.window.document.getElementById("menu").innerHTML = http.responseText;
		parent.init_menu();
		alert("Modalidade Alterada com Sucesso!");	
	}
}

function handleHttpInsereMenu(){//para retornar num select
	if (http.readyState == 4) {		
		parent.parent.window.document.getElementById("menu").innerHTML = http.responseText;
		parent.init_menu();
		alert("Modalidade Inserida com Sucesso!");	
	}
}

function handleHttpExcluirMenu(){//para retornar num select
	if (http.readyState == 4) {		
		parent.parent.window.document.getElementById("menu").innerHTML = http.responseText;
		parent.init_menu();
		//alert("Modalidade Excluída com Sucesso!");	
	}
}


   
function init_menu(){
		$(function() {
			$( "#menu" ).draggable();	
		});	
		$( "#menu_lateral" ).click(function() {							
			if (document.getElementById("table_menu_vertical").style.width == '22px')  {				
				  $( "#table_menu_vertical" ).animate({
						width: "216px",
						opacity: 1						
				  }, 500 );			
				  				  
				 document.getElementById("img_seta_menu").src="./images/seta_left.gif";
			}else{			
			
				  $( "#table_menu_vertical" ).animate({
						width: "22px",
						opacity: 0.6						
				  }, 500 );			  
				   document.getElementById("img_seta_menu").src="./images/seta_right.gif";
			}			
			
			return false;
		});		
		
		$( "#go_home" ).click(function() {		
				  $( "#menu" ).animate({
						left: "0px"	,
						top: "0px"	
				  }, 500 );
		});
}

function  valida_evento(form){	
	var vetor = new Array ("id_tipo", "licitacao_nome","nro_licitacao");		
	var msg= new Array("Modalidade", "Título","Nº Licitacao");	
		
	for (x=0;x<vetor.length;x++){	  					
	   	if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			form.elements[vetor[x]].focus();	
			return(0);
		}		
     }	
	if(form.flag_eletronico_presencial){
		if (form.flag_eletronico_presencial.value == ""){
			alert("Faltou Selecionar Tipo da Modalidade");
			form.flag_eletronico_presencial.focus();
			return false;	
		}
	}	 
	 return true;
}




function incluir_evento(form){	
	if (valida_evento(form)){
		form.method = "POST";
		form.action="cadastro.php";
		form.submit();	
	}
}





function alterar_evento(form){	
	if (valida_evento(form)){
		form.method = "POST";
		form.action="alterar_modalidade.php";
		form.submit();	
	}
}



function combo_str(form)  {
   	var combo_str="";
	  
	  
	  if (form.publish.value == ""){
		  alert("Por favor, preencha a data de entrada");	
		  form.publish.focus();
		  return false;	
	  }
	  if (form.expire.value == ""){
		  alert("Por favor, preencha a data de saída");	
		  form.expire.focus();
		  return false;	
	  }
	  
	  if (form.field_reports.length==undefined){
		  combo_str="";
	  }else{
		  for(i= 0;i<form.field_reports.length;i++){
				  if  (form.field_reports[i].checked){					
					  if (combo_str==""){
						  combo_str=form.field_reports[i].value;
					  }else{
						  combo_str=combo_str+","+form.field_reports[i].value;
					  }
				  }
		   }	
	  }
	  
	  form.field_combo_str.value=combo_str;
	  form.action="relatorios.php";
	  
	 form.submit();
}



	function config_advanced(){
		if(document.getElementById("config_advanced").style.display == ""){			
			document.getElementById("config_advanced").style.display = "none";
			document.getElementById("marca_todos").style.display = "none";
		}else{
			document.getElementById("config_advanced").style.display="";
			document.getElementById("marca_todos").style.display ="";
		}
	}

  function checa(form) {	
	if(form.marca_todos.checked){	
	       for(i= 0;i<form.field_reports.length;i++){
	       form.field_reports[i].checked = true;		 
		   }
	}else{
	       for(i= 0;i<form.field_reports.length;i++){
	       form.field_reports[i].checked = false;		   
		   }
	}  
  }
  
  
  
function Timer (){
	this.objectId;
	this.sHors;
	this.sMins;
	this.sSecs;		
	
	this.getRegressiva = function(){
		
		  this.sSecs--;
		  if(this.sSecs<0){
			  this.sSecs=59;this.sMins--;
			  if(this.sMins<=9)this.sMins="0"+this.sMins;
		  }
		  if(this.sMins=="0-1"){
			  this.sMins=5;this.sHors--;
			  if(this.sHors<=9)this.sHors="0"+this.sHors;
		  }
		  if(this.sSecs<=9)this.sSecs="0"+this.sSecs;
		  if(this.sHors=="0-1"){
			  this.sHors="00";
			  this.sMins="00";
			  this.sSecs="00";
			  this.objectId.innerHTML=this.sHors+"<kbd>:</kbd>"+this.sMins+"<kbd>:</kbd>"+this.sSecs;
		  }else{
			  this.objectId.innerHTML=this.sHors+"<kbd>:</kbd>"+this.sMins+"<kbd>:</kbd>"+this.sSecs;
			  
			  var self = this;
			  if ((this.sHors == "00")&&(this.sMins == "00")&&(this.sSecs == 0)){
				  setTimeout(function() { 
  							  self.getProgressiva();
							}, 1000);	
			  }else{				  
				  setTimeout(function() { 
  							  self.getRegressiva();
							}, 1000);	
			  }
		  }
	}
		
	this.getProgressiva = function(){
		  this.sSecs++;
		  if(this.sSecs==60){
			  this.sSecs=0;this.sMins++;
			  if(this.sMins<=9)this.sMins="0"+this.sMins;
		  }
		  if(this.sMins==60){
			  this.sMins="0"+0;this.sHors++;
			  if(this.sHors<=9)this.sHors="0"+this.sHors;
		  }
		  if(this.sSecs<=9)this.sSecs="0"+this.sSecs;
		  this.objectId.innerHTML=this.sHors+"<kbd>:</kbd>"+this.sMins+"<kbd>:</kbd>"+this.sSecs;
		  var self = this;
		  setTimeout(function() { 
			  self.getProgressiva();
			}, 1000);			 
	}
	
	
}

function create_timer(id,sHors,sMins,sSecs){
	var obj = new Timer();
	obj.objectId = document.getElementById(id);
	obj.sHors = sHors; 
	obj.sMins = sMins;
	obj.sSecs = sSecs;
	obj.getRegressiva();	
}

function visualizar_anexo(id,form){
		var action_old = form.action;
		var target_old = form.target;	
		obj = document.getElementById(id);		

		form.anexo_view_nome.value = obj.name;	
		
		//var clone_obj = obj.cloneNode(true)
		//clone_obj.id = "clone_"+obj.id;			
		//form.appendChild(clone_obj);	

		form.target = "_blank";
		form.action = "anexo_view.php";
		form.submit();
		form.target = target_old;
		form.action = action_old;
		
}
  
  
  



  
 function delete_yourself(obj){	  
	 if (obj.id == "linha_0"){
		 alert ("Não é Possível apagar o Primeiro Profissional Técnico Vinculado");
		 return false;
	 }else{	 
		  var ok;
		  ok = confirm("Confirma Apagar esse Registro?");
		  if(ok)	  
			document.getElementById("tabela_profissional").deleteRow(obj.rowIndex);
		  else
			  return false;		  
	 }
 }
  
  
  
  
function check_first_professional(){	
	obj = document;
	var itens = obj.getElementById("tabela_profissional");	
	var total_linhas = obj.getElementById("tabela_profissional").rows.length;//numero de linhas da tabela
			for (i=0; i<total_linhas; i++){		
				var line = itens.rows[i].id.toString();	
				if (line.search("linha")!=-1){						
					  aux = line.replace("linha","");							
					  obj2 = obj.getElementById("linha"+aux).getElementsByTagName("input");		
					  //if (aux == "_0"){		
					  		//alert(obj2[3].name);return false;
							var vetor = new Array (obj2[0], obj2[3],obj2[4],obj2[5]);		
							var msg= new Array("Nome Responsável","E-mail","CREA", "CPF");									
							for (x=0;x<vetor.length;x++){	  					
								if(vetor[x].value == ""){	
									alert("É Obrigatório o Preenchimento do "+msg[x] +" do Profissional Vinculado!");
									$('#tabs').tabs('select', 'resp_tec');
									vetor[x].focus();	
									return false;
								}		
							 }		
					//  }
					
					obj3 = obj.getElementById("linha"+aux).getElementsByTagName("select");		
					//alert(obj3[0].selectedIndex );
					if (obj3[0].selectedIndex == 0){
							alert("É Obrigatório Escolher o Titulo Profissional");
							obj3[0].focus();
							return false;
					}
				}				
			}	
	return true;
}

function is_jpg(str){	
	if (str){
		var arraylist = str.split(".");		 
		if (
			(arraylist[arraylist.length-1].toLowerCase() != "jpg")&&
			(arraylist[arraylist.length-1].toLowerCase() != "png")&&
			(arraylist[arraylist.length-1].toLowerCase() != "gif")
			){				
			alert("Sua Foto precisa estar no formato JPG, PNG ou GIF");
			return false;
		}else{
				return  true; // Sua assinatura tem a extensão correta	
		}
	}else{
		return true;	
	}
}



 function alterar_empresa(form,cod){	 
 	var add = "";
 	var myDate = new Date();
	var vetor= new Array("razao_social","cnpj","email");
	var msg= new Array("Razão Social","CNPJ","E-mail");	
	for (x=0;x<vetor.length;x++){	  					
		if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			$('#tabs').tabs('select', 'tabs-1');
			form.elements[vetor[x]].focus();	
			return false;
		}		
	}	
	
	
	if ((form.elements["senha"].value != "")||(form.elements["confirmar_senha"].value != "")){		
			if (paridade_alterar_senha(form)){
				  if (form.senha.value.length < 8){
					  alert("Sua nova senha deve ter pelo menos 8 digitos");
					  $('#tabs').tabs('select', 'tabs-2');
					  form.senha.value="";
					  form.confirmar_senha.value="";
					  form.senha.focus();
					  return false;
				  }else{
						var add = "&alteracao_senha=yes"  
				  }
			}else{
				$('#tabs').tabs('select', 'tabs-2');
				return false;
			}
	}
	
	
	email = form.elements["email"];	
	if (check_mail(email)){		  
		  form.target = "grid_iframe";
		  form.action="operacoes.php?alterar_empresa=yes&cod="+cod+"&time="+myDate.getTime()+add;
		  form.submit();		
	}
 }



function alterar_participante(form){	   
	var vetor= new Array("nome_participante","cpf","data_nascimento");
	var msg= new Array("Nome","CPF","Data de Nascimento");		
	for (x=0;x<vetor.length;x++){	 	
		if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			form.elements[vetor[x]].focus();	
			return false;
		}		
	}	 

	form.target = "grid_iframe";
	form.method = "POST";
	form.action="./php/operacoes.php";
	form.submit();	

 }



  
 function cadastrar_participante(form){	   
	var vetor= new Array("nome_participante","telefone","data_nascimento","email","confirmar_email","senha","confirmar_senha","captcha","cpf");
	var msg= new Array("Nome","Telefone","Data de Nascimento","E-mail","Confirmar E-mail","senha","Confirmar Senha","Código de Validação","CPF");		
	for (x=0;x<vetor.length;x++){	 	
		if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			form.elements[vetor[x]].focus();	
			return false;
		}		
	}	 
		
	if (form.senha.value.length < 8){
		alert("Sua nova senha deve ter pelo menos 8 digitos");
		//$('#tabs').tabs('select', 'tabs-2');
		form.senha.value="";
		form.confirmar_senha.value="";
		form.senha.focus();
		return false;
	}
	

	
	if (paridade_alterar_senha(form)){		
		  email = form.elements["email"];	
		  if (check_mail(email)){			
		  	  if (paridade_alterar_email(form)){	
					form.target = "grid_iframe";
					form.method = "POST";
					form.action="./php/operacoes.php";
					form.submit();	
			  }
		  }		
	}
	return false;
 }
 
 
 function login_website(form){	  
	var vetor= new Array("login_email","senha");
	var msg= new Array("Username ou Email","Senha");		
	for (x=0;x<vetor.length;x++){	 	
		if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			form.elements[vetor[x]].focus();	
			return false;
		}		
	}	 

	form.target = "grid_iframe";
	form.method = "POST";
	form.action="./php/operacoes.php";
	form.submit();	

	return false;
 }
 
 
 
 
 
 
function verifica_cpf(value){	
		//open('./php/operacoes.php?verifica_login=yes&login='+value,'grid_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');		
		atualiza_conteudo("./php/operacoes.php","verifica_cpf=yes&cpf="+encodeURIComponent(value),"POST","handleHttpVerificaCPF");	
}
function verifica_cpf_adesao(value){	
		//open('./php/operacoes.php?verifica_login=yes&login='+value,'grid_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');		
		atualiza_conteudo("./php/operacoes.php","verifica_cpf=yes&cpf="+encodeURIComponent(value),"POST","handleHttpVerificaCPFAdesao");	
}


function handleHttpVerificaCPF(){
	if (http.readyState == 4) {		
		if(http.responseText){		
			alert(http.responseText);		
			document.cadastro_form.cpf.value = "";
			document.cadastro_form.cpf.focus();			
		}
		return false;
	}
}

function handleHttpVerificaCPFAdesao(){
	if (http.readyState == 4) {		
		if(http.responseText){		
			alert(http.responseText);		
			document.adesao_form.cpf.value = "";
			document.adesao_form.cpf.focus();			
		}
		return false;
	}
}



function verifica_email(value){	
		//open('./php/operacoes.php?verifica_login=yes&login='+value,'grid_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');		
		atualiza_conteudo("./php/operacoes.php","verifica_email=yes&email="+value,"POST","handleHttpVerificaEmail");	
}

function handleHttpVerificaEmail(){
	if (http.readyState == 4) {		
		if(http.responseText){		
			alert(http.responseText);		
			document.cadastro_form.email.value = "";
			document.cadastro_form.email.focus();			
		}
		return false;
	}
}
 
 

 
 
 

 

 
 function max_length (obj,tam){	
	if (obj.value != ""){
		if (obj.value.length < tam){
			alert(obj.name+" deve ter pelo menos "+tam+" caracteres");
			obj.value="";	
			obj.focus();
			return false;
		}else{
			return true;
		}
	}
}


function sqlInjection(e,obj){	
	if(document.all) { // Internet Explorer
		var str = String.fromCharCode(event.keyCode);
	}else{
		var str = String.fromCharCode(e.charCode);
	}							
	var caract = new RegExp(/^[\\+'*/%]+$/i);	
	var caract = caract.test(str);		
	if(e.charCode != 0){ //escape 
		  if(caract){
			 // alert("Caracter inválido: " +  str );		        
			  return false;
		  }
	}	
}






 

 

 






// Formata o Código Cartográfico (IPTU) - XXXX.XX.XX.XXXX.XXXXX
function formataCodCartografico(Campo) {
  var numeros = "";
  var digito, tam;
	 
   for (i=0; i<Campo.value.length; i++) 
 	  {
     digito = Campo.value.charAt(i);
     if (!isNaN(digito))
       numeros += digito;
		}			
   tam = numeros.length;

   if (tam <= 4) 
	  {
     Campo.value = numeros;
	  }
   else if ((tam > 4) && (tam <= 6)) 
	  {
     Campo.value = numeros.substring(0,4) + '.' + numeros.substring(4,tam);
	  }
   else if ((tam > 6) && (tam <= 8)) 
	  {
     Campo.value = numeros.substring(0,4) + '.' + numeros.substring(4,6) + '.' + numeros.substring(6,tam) ;
	  }
   else if ((tam > 8) && (tam <= 12)) 
	  {
     Campo.value = numeros.substring(0,4) + '.' + numeros.substring(4,6) + '.' + numeros.substring(6,8) + '.' + numeros.substring(8,tam);
	  }
   else if (tam > 12) 
	  {
     Campo.value = numeros.substring(0,4) + '.' + numeros.substring(4,6) + '.' + numeros.substring(6,8) + '.' + numeros.substring(8,12) + '.' + numeros.substring(12,17);
	  }		
}



function getRadioValue(obj){	
	for (var i = 0; i < obj.length; i++){
		if (obj[i].checked)	
			return obj[i].value;
	}
	return null;
}


function delete_project_label(obj,e){	
	if(e.keyCode == 8){		
  			setTimeout(function() { 
  							  document.getElementById("project_label").innerHTML = obj.value;		
							}, 300);	
	}	
}


function set_project_label(obj,e){		
	  			setTimeout(function() { 
  							  document.getElementById("project_label").innerHTML = obj.value;		
							}, 300);	
}






 


 


function refresh_captcha(){	
	var myDate = new Date();
	obj = document.getElementById("captcha_image");
	obj.src = "./php/captcha.php?time="+myDate.getTime();
}






function resetar_senha(form){
	var vetor = new Array ("esqueci_senha_value");		
	var msg= new Array("Email ou Username");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }		 	 

	form.target = "grid_iframe";
	form.action = "./php/operacoes.php";
	form.submit();
}




function marcar_todos(obj,form){	
	var checkboxs = document.getElementsByTagName("input");
	for (var x in checkboxs){
		if (checkboxs[x].type == "checkbox"){
			if(obj.checked == true){ // marca todos
				checkboxs[x].checked = true;
			}else{
				checkboxs[x].checked = false;
			}			
		}
	}
}


function check_permission(obj,form,id_transacao){	
	var checkboxs = document.getElementsByTagName("input");
	for (var x in checkboxs){		
		if  ((checkboxs[x].type == "checkbox")&&(checkboxs[x].size == id_transacao))   {
			if(obj.checked == true){ // marca todos
				checkboxs[x].checked = true;
			}else{
				checkboxs[x].checked = false;
			}			
		}
	}
}




function desabilita_form(form){	
	var tags = new Array ("input","textarea","select",'img');		
	for (x=0;x<tags.length;x++){		
		var el = document.getElementsByTagName(tags[x]);		
		for (var y in el){
			el[y].disabled = "disabled";
			el[y].onclick = "";			
		}
	}
}


function executa_filtro_consulta(form){	
	  for (x = 0; x < form.length; x++ ) 	  
			if ((form[x].type == "text")||(form[x].type == "select-one"))
				if(form[x].value != "")
					 var at_least_one = true;		
					 
	  if  (  (form.data_inicio.value == "")&&(form.data_fim.value != "")||(form.data_inicio.value != "")&&(form.data_fim.value == "")  ){
		  alert("É preciso preencher a Data Inicial e Final para consultar por Período");
		  return false;
	  }
					 				 
	  if (at_least_one){ //envia consulta	  
			   var myDate = new Date();
			   form.method = "POST";
			   form.target = "iframe_aerosolicitacoes";
			   form.action = "listar.php?table=solicitacoes&time="+myDate.getTime();
			   form.submit();	
			   var container = parent.window.document.getElementById("Containerfiltro_consulta_form");		  
			   container.style.display =  "none";
	  }else{
		  alert("É preciso preencher pelo menos um parâmetro para gerar o relatório");
	  }
}


function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}


function show_yes_no(obj,id_anexo_avaliacao) {
	var i = obj.selectedIndex;	
	atualiza_conteudo("operacoes.php","check_anexo=yes&id_anexo_avaliacao="+id_anexo_avaliacao+"&value="+ encodeURIComponent(obj.options[i].value),"POST",handleHttpQuestion); 
	
}

function show_field(obj){			
	  var id = obj.id;	
	  if (obj.style.height == '50px')  {	
	  		obj.style.overflow = "auto";
			obj.style.height = '100%';
	  }else{		  			
			obj.style.overflow = "hidden";	
			obj.style.height = '50px';
	  }	
}

function show_box(name){
	var original  = document.getElementById("original_"+name); 
	var obj  = document.getElementById(name); 
	var texto  = document.getElementById("text_"+name); 
	
	if (obj.style.display == "none"){
		obj.style.display = "";
		original.style.display = "none";
		texto.innerHTML = "Mostrar Menos";		
	}else{
		obj.style.display = "none";
		original.style.display = "";
		texto.innerHTML = "Exibir Mais";
	}
}



function valida_youtube(url,form,id_desafio ) {
	if(trim(url)){
		  var myDate = new Date();
	  
		  var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
		  if  ( (url.match(p)) ? RegExp.$1 : false ){		
			  var player = document.getElementById("preview_video_"+id_desafio );
			  player.data = 'http://www.youtube.com/v/' + RegExp.$1 + '&autoplay=1&rel=1&version=3&autohide=1&'+myDate.getTime();	
			  var player2 = document.getElementById("preview_video2_"+id_desafio );
			  player2.value = 'http://www.youtube.com/v/' + RegExp.$1  + '&autoplay=1&rel=1&version=3&autohide=1&'+myDate.getTime();	
			  var player3 = document.getElementById("preview_video3_"+id_desafio );
			  player3.src = 'http://www.youtube.com/v/' + RegExp.$1  + '&autoplay=1&rel=1&version=3&autohide=1&'+myDate.getTime();	
			  
			  
			var objectspanmakeinnerhtml = "";
			objectspanmakeinnerhtml = document.getElementById("objectspan"+id_desafio).innerHTML;
			document.getElementById("objectspan"+id_desafio).innerHTML = "";
			document.getElementById("objectspan"+id_desafio).innerHTML = objectspanmakeinnerhtml;
			  
					  
		  }else{
			  alert("Digite um Link do YouTube Válido");	
			  form.myYouTubePlayer.value = "";
			  form.myYouTubePlayer.focus();
		  }
		  
	}	
}
function remove_youtube(id_desafio) {			
			document.getElementById("preview_video_"+id_desafio).data = '';	
			document.getElementById("preview_video2_"+id_desafio).value = '';	
			document.getElementById("preview_video3_"+id_desafio).src = '';	
			document.getElementById("media_video"+id_desafio).style.display="none";			
}

function escolher_media(obj,id_desafio){	
	  if (obj.value == 'V')  {	
	  		document.getElementById("media_video"+id_desafio).style.display = "";
			document.getElementById("media_foto"+id_desafio).style.display = "none";
	  }else{		  			
	  		document.getElementById("media_video"+id_desafio).style.display = "none";
			document.getElementById("media_foto"+id_desafio).style.display = "";
	  }	
}

function enviar_inspiracao(form){	  
	if(form.fase_atual.value == 2){
		var fase = "Proposta";
	}else{
		var fase = "Inspiração";
	}
	
	var msg = "Faça seu login antes de enviar sua "+fase;
	if(parseInt(document.getElementById("login-side").offsetTop) > 0){ // ainda não foi feito login			
		   if( 
			  parseInt(document.getElementById("log-in-form").offsetLeft)
			   >
			  parseInt(document.body.clientWidth)
			   ){	// window está escondido   
		//	if (document.getElementById("log-in-form").style.right != '80px')  {				
				  $( "#log-in-form" ).animate({
						right: "80px"					
				  }, 500 );	
				  var y = setTimeout(function() { 					
									showWarningToast(msg);		  
								  //alert ("Por favor, faça seu login antes de enviar");					  
				  }, (500)  );	  
			}else{
				  showWarningToast(msg);
				  //alert ("Por favor, faça seu login antes de enviar");		
			}
		return false;  
	}
		
	var myDate = new Date();
	var vetor= new Array("nome_contribuicao","media_flag","descricao_contribuicao");
	var msg= new Array("Título da "+fase,"Escolher Tipo Media","Descrição da "+fase);		
	for (x=0;x<vetor.length;x++){	 	
		if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			form.elements[vetor[x]].focus();	
			return false;
		}		
	}	
	
	
	if (form.id_topico){
		if (form.id_topico.value == ''){
			alert("Faltou selecionar Tema");
			form.id_topico.focus();	
			return false;
		}
	}

	

	if (form.media_flag[1].checked){
		if (form.myYouTubePlayer.value == ''){
			alert("Faltou Link de Vídeo do Youtube");
			form.myYouTubePlayer.focus();	
			return false;
		}		
		
	
		var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
		if  ( (form.myYouTubePlayer.value.match(p)) ? RegExp.$1 : false ){			  
				//ok			  
		}else{
			alert("Digite um Link do YouTube Válido");	
			form.myYouTubePlayer.value="";
			form.myYouTubePlayer.focus();
		}
		
	}else{
		if (form.foto.value == ''){
			alert("Faltou selecionar Foto");
			form.foto.focus();	
			return false;
		}else{		
			if (is_jpg(form.foto.value)){
				//ok				
			}else{
				return false;
			}					
		}
	}
	
	 if (form.descricao_contribuicao.value.length > 500){
		 showWarningToast("Sua "+fase+" tem mais de 500 caracteres, reduza o texto para poder enviar");
		 form.descricao_contribuicao.focus();		 
		 return false;
	 }
	  
	  
	form.target = "grid_iframe";
	form.method = "POST";
	form.action="./php/operacoes.php?youtube_link="+ encodeURIComponent(RegExp.$1)+"&time="+myDate.getTime();
	form.submit();	
	return false;
 }
 

 
 
 
function enviar_comentario(form){	  
	var msg = "Faça seu login antes de enviar";
	if(parseInt(document.getElementById("login-side").offsetTop) > 0){ // ainda não foi feito login			
		   if( 
			  parseInt(document.getElementById("log-in-form").offsetLeft)
			   >
			  parseInt(document.body.clientWidth)
			   ){	// window está escondido   
		//	if (document.getElementById("log-in-form").style.right != '80px')  {				
				  $( "#log-in-form" ).animate({
						right: "80px"					
				  }, 500 );	
				  var y = setTimeout(function() { 					
									showWarningToast(msg);		  
								  //alert ("Por favor, faça seu login antes de enviar");					  
				  }, (500)  );	  
			}else{
				showWarningToast(msg);
				  //alert ("Por favor, faça seu login antes de enviar");		
			}
		return false;  
	}
		
	var myDate = new Date();
	var vetor= new Array("comentario_text");
	var msg= new Array("Comentário");		
	for (x=0;x<vetor.length;x++){	 	
		if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			form.elements[vetor[x]].focus();	
			return false;
		}		
	}	

	  
	form.target = "grid_iframe";
	form.method = "POST";
	form.action="./php/operacoes.php?time="+myDate.getTime();
	form.submit();	
	
	form.comentario_text.value = "";
	//aba_comentario(form.id_contribuicao.value);
	return false;
 }
 
 
 function curtir_contribuicao(id_contribuicao,fase_atual){
	 
	if(fase_atual == '3'){
		var msg = "Faça seu login antes de Votar";
	}else{
		var msg = "Faça seu login antes de curtir";
	}
	
	if(parseInt(document.getElementById("login-side").offsetTop) > 0){ // ainda não foi feito login			
		   if( 
			  parseInt(document.getElementById("log-in-form").offsetLeft)
			   >
			  parseInt(document.body.clientWidth)
			   ){	// window está escondido   
		//	if (document.getElementById("log-in-form").style.right != '80px')  {				
				  $( "#log-in-form" ).animate({
						right: "80px"					
				  }, 500 );	
				  var y = setTimeout(function() { 					
									showWarningToast(msg);		  
								  //alert ("Por favor, faça seu login antes de enviar");					  
				  }, (500)  );	  
			}else{
				showWarningToast(msg);
				  //alert ("Por favor, faça seu login antes de enviar");		
			}
		return false;  
	}	
	atualiza_conteudo("php/ajax_open_data.php","add_curtir=1&id_contribuicao="+id_contribuicao+"&fase_atual="+fase_atual,"POST","handleHttpAddCurtir");	
 }
 
 function handleHttpAddCurtir(){//para retornar num select
	if (http.readyState == 4) {
		//alert(http.responseText);
		////results = http.responseText.split("##ajax_split##");				
		//document.getElementById("aba_coments"+trim(results[0])).innerHTML = results[1];
		//$("#aba_coments"+trim(results[0])).fadeIn();
		
		var conteudo = document.createElement('div');
		conteudo.innerHTML=http.responseText;
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}
	}
}
 
 
 
function enviar_resposta(form){	  
	var msg = "Faça seu login antes de enviar";
	if(parseInt(document.getElementById("login-side").offsetTop) > 0){ // ainda não foi feito login			
		   if( 
			  parseInt(document.getElementById("log-in-form").offsetLeft)
			   >
			  parseInt(document.body.clientWidth)
			   ){	// window está escondido   
		//	if (document.getElementById("log-in-form").style.right != '80px')  {				
				  $( "#log-in-form" ).animate({
						right: "80px"					
				  }, 500 );	
				  var y = setTimeout(function() { 							 
								 // alert ("Por favor, faça seu login antes de enviar");	
								 showWarningToast(msg);
				  }, (500)  );	  
			}else{
				 // alert ("Por favor, faça seu login antes de enviar");		
				  showWarningToast(msg);
			}
		return false;  
	}
		
	var myDate = new Date();
	var vetor= new Array("comentario_text");
	var msg= new Array("Comentário");		
	for (x=0;x<vetor.length;x++){	 	
		if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			form.elements[vetor[x]].focus();	
			return false;
		}		
	}	

	  
	form.target = "grid_iframe";
	form.method = "POST";
	form.action="./php/operacoes.php?time="+myDate.getTime();
	form.submit();	
	
	form.comentario_text.value = "";
	aba_resposta(form.id_comentario.value);
	return false;
 }
 
 
 
  function aba_resposta(id_comentario){	 
			if(document.getElementById("aba_resposta"+id_comentario).style.display == "none"){						
						$("#aba_resposta"+id_comentario).fadeIn();
					}else{
						$("#aba_resposta"+id_comentario).fadeOut();						
			}
 }
 
 function aba_comentario(id_contribuicao){	 
 			$("#aba_coments"+id_contribuicao).fadeOut();
		//	if(document.getElementById("aba_enviar_comentario"+id_contribuicao).style.display == "none"){						
						$("#aba_enviar_comentario"+id_contribuicao).fadeIn();						
				//	}else{
					//	$("#aba_enviar_comentario"+id_contribuicao).fadeOut();						
		//	}
 } 

 
  function aba_coments(id_contribuicao,read_only){	
			if(document.getElementById("aba_coments"+id_contribuicao).style.display == "none"){		
						atualiza_conteudo("php/ajax_open_data.php","get_coments=1&id_contribuicao="+id_contribuicao+"&read_only="+read_only,"POST","handleHttpComents");							
					}else{
						$("#aba_coments"+id_contribuicao).fadeOut();						
			}
 }
 
 
 
 function handleHttpComents(){//para retornar num select
	if (http.readyState == 4) {
		results = http.responseText.split("##ajax_split##");				
		document.getElementById("aba_coments"+trim(results[0])).innerHTML = results[1];
		$("#aba_coments"+trim(results[0])).fadeIn();
	}
}
 
 
 

function aba_enviar_inspiracao(id_desafio){	  

					if(document.getElementById("aba_enviar_desafio"+id_desafio).style.display == "none"){						
						$("#aba_enviar_desafio"+id_desafio).fadeIn();									
					}else{
						$("#aba_enviar_desafio"+id_desafio).fadeOut();						
					}
					
					
		var msg = "Faça seu login antes de enviar";			
		if(parseInt(document.getElementById("login-side").offsetTop) > 0){ // ainda não foi feito login			
		   if( 
			  parseInt(document.getElementById("log-in-form").offsetLeft)
			   >
			  parseInt(document.body.clientWidth)
			   ){	// window está escondido  
				  $( "#log-in-form" ).animate({
						right: "80px"					
				  }, 500 );	
				  var y = setTimeout(function() { 	
								showWarningToast(msg);			  
								 // alert ("Por favor, faça seu login antes de enviar sua Inspiração");					  
				  }, (500)  );	  
			}else{
				showWarningToast(msg);
				 // alert ("Por favor, faça seu login antes de enviar sua Inspiração");		
			}
	  }
					
					

 }
 
 
 
 
 
 
function enviar_email_participante(form){	  
	var msg = "Faça seu login antes de enviar";	
		
	var myDate = new Date();
	var vetor= new Array("motivo_reprovacao");
	var msg= new Array("Motivo");		
	for (x=0;x<vetor.length;x++){	 	
		if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			form.elements[vetor[x]].focus();	
			return false;
		}		
	}	
	form.submit();		

 }
 
 
 
 
 function fase_alone(id_desafio,id_fase){
	 location.href = "fase_alone.php?id_desafio="+id_desafio+"&id_fase="+id_fase;	 
 }
 
 
  
 function fase_info(id_desafio,id_fase){
	 location.href = "index.php?id_desafio="+id_desafio+"&id_fase="+id_fase;	 
 }
 
 
 
function check_btn_marcar_todos_topicos(id_desafio){	
	var checkboxs = document.getElementsByTagName("input");
	for (var x in checkboxs){
		if (checkboxs[x].type == "checkbox"){
			if(checkboxs[x].id){
				if( checkboxs[x].id.toString().indexOf("checkbox_topico_"+id_desafio) == 0){	
						if(checkboxs[x].checked == true){ // marca todos
							
						}else{
							var once = 1;
						}	
				}
			}
		}
	}
	if (!once){
		document.getElementById("marca_todos_"+id_desafio).checked = true;
	}
}
 
 
 
 
  function check_owner_box(obj,id_desafio){
	   if (obj.checked == true){		   		
			show_topicos(obj.value,id_desafio);
			check_btn_marcar_todos_topicos(id_desafio);
	   }else{
			hide_topicos(obj.value,id_desafio);
			document.getElementById("marca_todos_"+id_desafio).checked = false;
	   }
  }
 
 function check_this_box(id_topico,id_desafio){
	 if (document.getElementById("checkbox_topico_"+id_desafio+"_"+id_topico).checked == true){		 
		 document.getElementById("checkbox_topico_"+id_desafio+"_"+id_topico).checked = false;
		 hide_topicos(id_topico,id_desafio);
	  	 document.getElementById("marca_todos_"+id_desafio).checked = false;
	 }else{
		 document.getElementById("checkbox_topico_"+id_desafio+"_"+id_topico).checked = true;
		 show_topicos(id_topico,id_desafio);
		 check_btn_marcar_todos_topicos(id_desafio);
	 }
 }
 
 
 function hide_topicos(id_topico,id_desafio){
		var el = document.getElementsByTagName("div");			
		for (var y in el){		
				if(el[y].className){
					  if( el[y].className.toString().indexOf("topico_"+id_desafio+"_"+id_topico) == 0){						  		
								$(".topico_"+id_desafio+"_"+id_topico).fadeOut();
					  }	
				}
		}	
 }
 
 function show_topicos(id_topico,id_desafio){
		var el = document.getElementsByTagName("div");			
		for (var y in el){		
				if(el[y].className){			
						if( el[y].className.toString().indexOf("topico_"+id_desafio+"_"+id_topico) == 0){						  		
								  $(".topico_"+id_desafio+"_"+id_topico).fadeIn();
						}	
				}
		}	
 }
 
  function show_all_topicos(id_desafio){
		var el = document.getElementsByTagName("div");			
		for (var y in el){		
				if(el[y].className){			
						if( el[y].className.toString().indexOf("topico_"+id_desafio) == 0){						  		
							 $("."+el[y].className).fadeIn();
						}	
				}
		}	
 }
 
  function hide_all_topicos(id_desafio){
		var el = document.getElementsByTagName("div");			
		for (var y in el){		
				if(el[y].className){			
						if( el[y].className.toString().indexOf("topico_"+id_desafio) == 0){						  		
							 $("."+el[y].className).fadeOut();
						}	
				}
		}	
 }
 
 
 
 function marcar_todos_topicos(obj,id_desafio){	
	var checkboxs = document.getElementsByTagName("input");
	for (var x in checkboxs){
		if (checkboxs[x].type == "checkbox"){
			if(checkboxs[x].id){
				if( checkboxs[x].id.toString().indexOf("checkbox_topico_"+id_desafio) == 0){	
						if(obj.checked == true){ // marca todos
							checkboxs[x].checked = true;
							show_all_topicos(id_desafio);
						}else{
							checkboxs[x].checked = false;
							hide_all_topicos(id_desafio);
						}	
				}
			}
		}
	}
}
 
 
 
 
 function confirma_adesao(){
	var form = document.forms["adesao_form"];
	if (form.elements["adesao"].checked == false){
		alert("É preciso concordar com os Termos de Uso");
		form.elements["adesao"].focus();
		return false;
	}
	if (form.elements["cpf"]){	
		if (form.elements["cpf"].value == ""){
			alert("É preciso digitar seu CPF");
			form.elements["cpf"].focus();
			return false;
		}
	}
	if (form.elements["data_nascimento"]){	
		if (form.elements["data_nascimento"].value == ""){
			alert("É preciso digitar sua Data de Nascimento");
			form.elements["data_nascimento"].focus();
			return false;
		}
	}
	
	
	form.action = "./php/operacoes.php";		
	form.method = "POST";	
	form.target="grid_iframe";
	form.submit();
}





 
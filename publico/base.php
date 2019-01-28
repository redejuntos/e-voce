<?

 if ($_SESSION["id_participante_session"]){	  
 		$login_side_top = '-300px';
 		$meu_cadastro_side_top =  '240px'; 
		$imagem_avatar = $_SESSION["imagem_avatar"];
 }else{	 
 		$login_side_top = '130px';
 		$meu_cadastro_side_top =  '-240px'; 
		$imagem_avatar = 'images/avatar.jpg';
	    $_SESSION["imagem_avatar"] = $imagem_avatar;
 }





?>
<HTML>
<HEAD>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js">
    </script>
<script type="text/javascript">
	
	
      WebFont.load({
        google: {
          families: [ 'Calibri' ]
        }
      });
	
    </script>

<style type="text/css">
.wf-inactive p {
	font-family: serif
}
.wf-active p {
	font-family: 'Calibri', serif  !important;
	font-size:18px;
}
</style>
<!-- plUpload -- ----------------------------------------------------------- -->
<!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
<script type="text/javascript" src="./js/browserplus-min.js"></script>
<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
<script type="text/javascript" src="./js/plupload.full.js"></script>
<!-- ----------------------------------------------------------------------- -->
<!-- Include Lightbox (Production) ----------------------------------------- -->
<link type="text/css" rel="stylesheet" media="screen" href="./css/style.css" />
<!-- ----------------------------------------------------------------------- -->
<script type="text/javascript">



// Custom example logic





function count_fotos(){
	 var itens = document.getElementById("fotos_conteiner").getElementsByTagName("LI");
	 var count = 0;					
	  for (i=0; i<itens.length; i++){	
			count ++;
	  }	
	  return count;
}


function get_habilita_fotos(){
	 var obj = document.getElementById("habilita_fotos");
	 if(obj.checked){
		return true; 
	 }else{
		return false; 
	 }
}



function upload_restrition(){
	if (count_fotos() >= 10){
		if(!get_habilita_fotos()){
			alert("Para inserir mais de 10 fotos é preciso que essa opção esteja habilitada");
			return false;
		}
	}
	return true;
}


function checklist(arr, obj) {
    for(var i=0; i<arr.length; i++) {		
        if (arr[i] == obj) return true;
    }
	return false;
}


function handleHttpArquivos(){
	if (http.readyState == 4) {			
	 // alert(http.responseText);  
  		document.getElementById("fotos_conteiner").innerHTML = http.responseText;	
	}
}





</script>
<style>

a {
	color:#254673;
	text-decoration:none;
}
a:hover {
	text-decoration:underline;
	color:#06C;
	font-weight:bold;
}
.boxAviso {
	margin-top:20px;
	width:100%;
	height:auto;
*height:300px;
	background-image:url(images/facebook_box_320.png);
	background-repeat:no-repeat;
	padding:25px;
	padding-top:35px;
}
.boxAviso p {
	font-size:14px;
	line-height:21px;
	max-width:270px;
}
#brasao {
	margin:0 auto;
	top: 0px;
	height:45px;
	background: url('./images/brasao-central.png') top no-repeat;
	z-index:999;
	text-align:center;
	float: left;
	width:948px;
}
#barra {
	margin:0 auto;
	width: 840px;
	display: table;
}
#widthBarraMenu {
	margin:0 auto;
	margin-top:69px;
	width: 900px;
	display: table;
	height:20px;
}
#barraMenu {
	margin:0 auto;
	top: 30px;
	position:absolute;
	width:100%;
	text-align:center;
	height:1px;
}
#menu {	
	position:relative;	
	float:right;
	text-align:right;
	width: 720px;
	font-size:14px;
	font-weight:bolder;
	cursor:pointer;
	color:#585858;
	

	
	
}
#menu a {
	color:#585858;
}
#barraTopo {
	margin:0 auto;
	top: 0px;
	position:static;
	height:45px;
	width:100%;
	background: url('./images/topbar_transp.png') top repeat-x;
	font-size: 1em;
	color:#FFF;
	z-index:900;
	text-align:center;
}
#link1 {
	margin-top:6px;
	float:left;
	text-align:right;
	width: 472px;
}
#link1 a {
	margin-right: 45px;
}
#link2 {
	margin-top:6px;
	float:left;
	width: 472px;
	text-align: left;
}
#link2 a {
	margin-left: 45px;
}
/* correcao IE: margin */
.ui-tabs .ui-tabs-nav li {
	margin: 0 .2em 0px 0;
}
.ui-tabs .ui-tabs-nav li a {
	float: left;
	/*padding: .5em 0.85em;*/
	padding: .5em 1.5em;
	text-decoration: none;
	font-size:11px;
}
#tabs-0, #tabs-1, #tabs-2, #tabs-3, #tabs-4, #tabs-5, #tabs-6 {
	outline:none;
}
.fb-like-box {
	margin-left:10px;
}
#login-side {
	background : transparent url(./images/login-side.png) no-repeat 0 0;
	height : 109px;
	right : 0;
	overflow : hidden;
	position : fixed;
	text-indent : -800px;
	text-transform : capitalize;
 top : <?= $login_side_top ?>;
	width : 41px;
	z-index : 40
}
#meu_cadastro_side {
	background : transparent url(./images/meu_cadastro_side.png) no-repeat 0 0;
	height : 159px;
	right : 0;
	overflow : hidden;
	position : fixed;
	text-indent : -800px;
	text-transform : capitalize;
 top :  <?= $meu_cadastro_side_top ?>;
	width : 41px;
	z-index : 40
}
#meu_cadastro_side:hover, #meu_cadastro_side:focus {
	background-position : 0 -157px;
}
#login-side:hover, #login-side:focus {
	background-position : 0 -108px;
}
#log-in-form {
	display : block;
	position : fixed;
	right : -300px;
	top : 81px;
	width : 240px;
	z-index : 1200;
	background-color: #000000;
	border-radius:5px;
	padding : 15px;
}
.shadow {
	-moz-box-shadow: 3px 3px 4px #000;
	-webkit-box-shadow: 3px 3px 4px #000;
	box-shadow: 3px 3px 4px #000;
	/* For IE 8 */
	  -ms-filter: "progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#000000')";
	  /* For IE 5.5 - 7 */
	  filter: progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#000000');
}
#esqueceu_senha_container {
	display : block;
	position : fixed;
	right : 80px;
	top : 226px;
	width : 253px;
	z-index : 1000;
}
#esqueceu_senha_form {
	display : block;
	position : fixed;
	right : 80px;
	top : -400px;
	width : 240px;
	z-index : 1200;
	background-color: #000000;
	border-radius:5px;
	padding : 15px;
}
#alterar_senha_container {
	display : block;
	position : fixed;
	right : 80px;
	top : 226px;
	width : 253px;
	z-index : 1000;
}
#alterar_senha_form {
	display : block;
	position : fixed;
	right : -490px;
	top : 130px;
	width : 240px;
	z-index : 1200;
	background-color: #000000;
	border-radius:5px;
	padding : 15px;
}
#cadastro-container {
	display : block;
	position : fixed;
	right : 280px;
	top : 226px;
	width : 253px;
	z-index : 1000;
}
#meu_cadastro_container {
	display : block;
	position : fixed;
	right : 280px;
	top : 226px;
	width : 253px;
	z-index : 1000;
}

#esconde_caixas_container {
	display : block;
	position : fixed;
	right : 280px;
	top : 226px;
	z-index : 9000;
}


#esconde_caixas{
	display : block;
	position : fixed;
	right : -530px;
	top : 41px;
	z-index : 9999;
	background-color: #ffffff;
	padding : 15px;
}

#sliders-container {
	display : block;
	position : fixed;
	right : 80px;
	top : 226px;
	width : 253px;
	z-index : 1000;
}
#meu_cadastro_form {
	display : block;
	position : fixed;
	right : -400px;
	top : 41px;
	width : 340px;
	z-index : 1200;
	background-color: #000000;
	border-radius:5px;
	padding : 15px;
}
#cadastro-form {
	display : block;
	position : fixed;
	right : -400px;
	top : 81px;
	width : 340px;
	z-index : 1200;
	background-color: #000000;
	border-radius:5px;
	padding : 15px;
}
#sliders-container .loading-img {
	margin : 20px 100px;
}
#sliders-container .hr {
	margin : 0;
}
.light-box .hr, .light-box-n .hr {
	background : url(./images/hr.png) 0 0 repeat-x
}
.light-box h3, .light-box-n h3 {
	background : none;
	color : #fff;
	font-size : 18px;
	font-weight : 400;
	margin-bottom : 0;
	padding-bottom : 0;
	text-shadow: #000 0 -1px 0
}

.curtir {	
	background-color:#0096e1;
}
.curtir:hover {	
	background-color:#63c14a;
}


.curtido {	
	background-color:#cccccc;
}

</style>
<script>
	
		
		
$(function() {
		   
		   
		   
		   
       $("#enviar_desafio_btn")
            .click(function(){
					if(document.getElementById("aba_enviar_desafio").style.display == "none"){						
						$("#aba_enviar_desafio").fadeIn();									
					}else{
						$("#aba_enviar_desafio").fadeOut();						
					}
					
					
		var msg = "Por favor, faça seu login antes de enviar";			
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
					
					
	  });
			
			
			

			
		   
	var opera_meu_cadastro = 0;	
	$("#meu_cadastro_side,#close_cadastro_for_btn").click(function() {																		   
		if (parseInt(document.getElementById("meu_cadastro_form").offsetLeft) == 0){ //Opera Browser	
			if (opera_meu_cadastro){
					  $( "#meu_cadastro_form" ).animate({
							right: "-400px"					
					  }, 500 );
					  opera_meu_cadastro = 0;
			}else{				
					  $( "#meu_cadastro_form" ).animate({
							right: "80px"					
					  }, 500 );
					  opera_meu_cadastro = 1;
			}	
		}else{	//Chrome, Firefox, IE																	   
			if( 
			  parseInt(document.getElementById("meu_cadastro_form").offsetLeft)
			   >
			  parseInt(document.body.clientWidth)
			   ){	// window está escondido						
				  $( "#meu_cadastro_form" ).animate({
						right: "80px"					
				  }, 500 );
			}else{			
				  $( "#meu_cadastro_form" ).animate({
						right: "-400px"					
				  }, 500 );					
			}		
		}
	});
	
	var opera_login = 0;		   
	$("#login-side,#close_btn").click(function() {	
		if (parseInt(document.getElementById("log-in-form").offsetLeft) == 0){ //Opera Browser
			if (opera_login){
					  $( "#log-in-form" ).animate({
							right: "-300px"					
					  }, 500 );		
					  opera_login = 0;
			}else{				
					  $( "#log-in-form" ).animate({
							right: "80px"					
					  }, 500 );
					  opera_login = 1;
			}		
		}else{	//Chrome, Firefox, IE							   
				if( 
				  parseInt(document.getElementById("log-in-form").offsetLeft)
				   >
				  parseInt(document.body.clientWidth)
				   ){	// window está escondido   
			//	if (document.getElementById("log-in-form").style.right != '80px')  {				
					  $( "#log-in-form" ).animate({
							right: "80px"					
					  }, 500 );
				}else{			
					  $( "#log-in-form" ).animate({
							right: "-300px"					
					  }, 500 );		
					//  document.getElementById("log-in-form").style.right = '-300px';
				}	
		}
		
		
		
	});
	
	var opera_cadastro = 0;
	$("#cadastrar_form_btn,#close_cadastrar_form_btn").click(function() {																  
	//	$( "#cadastro-form" ).draggable( "disable" )	
	
	if (parseInt(document.getElementById("cadastro-form").offsetLeft) == 0){ //Opera Browser
			if (opera_cadastro){
					  $( "#cadastro-form" ).animate({
							right: "-400px"					
					  }, 500 );		
					  opera_cadastro = 0;
			}else{				
					  $( "#cadastro-form" ).animate({
							right: "395px"					
					  }, 500 );
					  opera_cadastro = 1;
			}
	}else{	//Chrome, Firefox, IE			
	
		if( 
		  parseInt(document.getElementById("cadastro-form").offsetLeft)
		   >
		  parseInt(document.body.clientWidth)
		   ){	// window está escondido   		
	//	if (document.getElementById("cadastro-form").style.right != '395px')  {		
			  $( "#cadastro-form" ).animate({
					right: "395px"					
			  }, 500 );
			  	
		}else{			
			  
			  $( "#cadastro-form" ).animate({
					right: "-400px"					
			  }, 500 );		
			//  document.getElementById("cadastro-form").style.right = '-400px';
		}		
	//	$( "#cadastro-form" ).draggable( "enable" );
		//$( "#cadastro-form" ).draggable();
	}
		
	});
	
	
//	$("#cadastro-form").click(function() {																  
		//	$( "#cadastro-form" ).draggable();
//	});
	
	
	$("#esqueci_senha_btn,#close_esqueceu_senha_btn").click(function() {																  
		if (document.getElementById("esqueceu_senha_form").style.top != '350px')  {		
			  $( "#esqueceu_senha_form" ).animate({
					top: "350px"					
			  }, 500 );
		}else{			
			  $( "#esqueceu_senha_form" ).animate({
					top: "-400px"					
			  }, 500 );		
			  document.getElementById("esqueceu_senha_form").style.top = '-400px';
		}		
	});


	var opera_alterar_senha = 0;
	$("#alterar_senha_btn,#close_alterar_senha_btn").click(function() {	
		if (parseInt(document.getElementById("alterar_senha_form").offsetLeft) == 0){ //Opera Browser													
			if (opera_alterar_senha){
					  $( "#alterar_senha_form" ).animate({
							right: "-490px"					
					  }, 500 );		
					  opera_alterar_senha = 0;
			}else{				
					  $( "#alterar_senha_form" ).animate({
							right: "490px"					
					  }, 500 );
					  opera_alterar_senha = 1;
			}
		}else{	//Chrome, Firefox, IE													
			  if( 
				parseInt(document.getElementById("alterar_senha_form").offsetLeft)
				 >
				parseInt(document.body.clientWidth)
				 ){	// window está escondido   		
					$( "#alterar_senha_form" ).animate({
						  right: "490px"					
					}, 500 );
			  }else{			
					$( "#alterar_senha_form" ).animate({
						  right: "-490px"					
					}, 500 );	
			  }	
		}		
	});
	
	
	
	$(".themes_photo").hover(function() {	
			 $(this).next().animate({
					marginTop: '-40px'					
			  }, 200 );
	});
	
	$(".themes_photo").mouseout(function() {	
			 $(this).next().animate({
					marginTop: '-30px'					
			  }, 200 );
	});
	
	
	 
	
	$("#datepicker,.date_field").datepicker({									  
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
		closeText: 'Fechar', closeStatus: '', yearRange: "-120:+0"
	});


	   $('div.title').cluetip({splitTitle: '|'});

    var uploader = new plupload.Uploader({
        runtimes : 'gears,html5,flash,html4,silverlight,browserplus',
        browse_button : 'pickfiles',
        container : 'container',
        max_file_size : '15mb',
        url : 'upload.php',
        flash_swf_url : './js/plupload.flash.swf',
        silverlight_xap_url : './js/plupload.silverlight.xap',
        filters : [
            {title : "Image files", extensions : "jpg,gif,png"}
        ],
      //  resize : {width : 320, height : 240, quality : 90},
		multipart_params : {
          "login" : $("#login").val()
   	    }
    });

    uploader.bind('Init', function(up, params) {
     //   $('#filelist').html("<div>Current runtime: " + params.runtime + "</div>"); 	 
	   // za_pendencias();
    }); 
	



    $('#uploadfiles').click(function(e) {
        uploader.start();
        e.preventDefault();
    }); 
	
	


    uploader.init(); 	

	var lista = new Array();	
	
	

	

    uploader.bind('FilesAdded', function(up, files) {												 
		var indice = 0;
		//var fotos_incluidas = count_fotos(); // fotos já incluidas 
		//var soma = fotos_incluidas + up['files'].length;
		//var fotos_permitidas = parseInt(10 - fotos_incluidas);			
		//var total_upload = up['files'].length; // total de fotos que serão feitos upload
		//var fotos_upadas = 0;
		/*
		switch (whichBrs()){	 // para correção de bug no opera		
				case "Opera": 	
						if (!upload_restrition()) return false; // Não pode dar upload de mais de 10 fotos										
				break;		
		}		
		*/
		
        $.each(files, function(i, file) { // para cada arquivo adicionado na ultima selecao										   
			var count = 1;		
			var indice_do_arquivo_repetido = 0;	
			
			
			for (x=0;x<up['files'].length;x++){			   
				//if (up['files'][x].name == file.name){					
				if (checklist(lista, file.name) ){	
					count++;
					indice_do_arquivo_repetido = x;					
				}				
			}	
			
			
			if (count >= 2){ // arquivo repetido;
				//alert(up['files'][indice_do_arquivo_repetido].name);				
				var ok;
				ok = confirm("O arquivo \""+ file.name+"\" já foi selecionado anteriormente, gostaria de adicioná-lo novamente?");
				if(ok){						  
					  $('#filelist').append(
						  '<div id="' + file.id + '">' +
						  file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
					  '</div>');
					  //fotos_upadas++;
				}else{
						//alert(total_upload +"--"+ (indice));
						uploader.removeFile(files[indice]);						
				}
			}else{		//escreve arquivo na tela	
			/*
			    if (!get_habilita_fotos()){  // Não pode dar upload de mais de 10 fotos
					  if (indice < fotos_permitidas) {
							$('#filelist').append(
								'<div id="' + file.id + '">' +
								file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
							'</div>');
							 fotos_upadas++;
					  }
				}else{
					*/
					  $('#filelist').append(
						  '<div id="' + file.id + '">' +
						  file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
					  '</div>');
					   //fotos_upadas++;
				//}
				
				lista.push(file.name);
			}				
			
		/*
			if (!get_habilita_fotos()){  // Não pode dar upload de mais de 10 fotos
				if (soma > 10){					
					if (fotos_upadas > fotos_permitidas) {	
						uploader.removeFile(files[indice]);
						$('#' + file.id + " b").html("<b style='color:#F00;'>Não Enviada. Excede Limite Permitido !</b>");
						//alert(total_upload +"--"+ (indice-1));
						if (total_upload == (indice+1)){
							alert("A soma de suas fotos é maior do que as 10 permitidas , só serão enviadas até " + fotos_permitidas + " foto(s) ");	
						}
					}
				}
			}
			*/
			indice++;
			
        });
		//alert(up['files'].length);		
		
        up.refresh(); // Reposition Flash/Silverlight
		up.start();
    });



    uploader.bind('UploadProgress', function(up, file) {
        $('#' + file.id + " b").html(file.percent + "%");

    }); 

    uploader.bind('Error', function(up, err) {
        $('#filelist').append("<div>Error: " + err.code +
            ", Message: " + err.message +
            (err.file ? ", File: " + err.file.name : "") +
            "</div>"
        );
        up.refresh(); // Reposition Flash/Silverlight
    }); 

    uploader.bind('FileUploaded', function(up, file) {
        $('#' + file.id + " b").html("<b style='color:#090;'>100%</b>");
		$('#' + file.id).remove();
		
		if (uploader.total.uploaded == uploader.files.length){				 
			 // $("#tabs").tabs("select", "tabs-listar_anexo");			 
		    atualiza_avatar();
			up.splice(); // reset the queue to zero)
			//alert(dump(lista));
		}
		
		//up['files'].length = 0; // reset the queue to zero
		
		
    });

	
});

function atualiza_avatar(){
	atualiza_conteudo("./php/ajax_open_data.php","get_avatar=yes","POST",handleHttpAvatar);
}



function handleHttpAvatar(){//para retornar num select
	if (http.readyState == 4) {
		var obj = document.getElementById("pickfiles");
		if(http.responseText){
			obj.src = http.responseText;
		}else{
			obj.src = './images/avatar.jpg';
		}
		
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}			
	}
}


</script>

<? get_fb_btn($_GET["i"]) ?>


</HEAD>
<BODY  leftmargin=0 topmargin=0 scrollbars=yes marginwidth=0 marginheigth=0 scrolling="no" >

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NKVMJG"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NKVMJG');</script>
<!-- End Google Tag Manager -->


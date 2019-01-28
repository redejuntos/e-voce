<? 
$layout = new layout;
echo '<style>table tr td {font-family:Verdana, Geneva, sans-serif;font-size:12px;}</style>';
$layout -> set_body('','','');


foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  		 $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	


if ($_GET["cod"]){  // Alterar desafio
	$sql = "SELECT id_topico,id_desafio,nome_topico,descricao,id_topico,nro_topico,data_cancelamento,data_alteracao,data_inclusao,media_flag FROM topicos
			WHERE (id_topico = '".$_GET["cod"]."') 
			limit 1
			";  	
	$rs = get_record($sql);		

	
	 //Alterar entidade já existente
	$title_desafio = $rs["nome_topico"];	
}else{  //Adicionar Nova entidade
	$title_desafio = "Incluir Tópico";
}



?>

<!-- plUpload -- ----------------------------------------------------------- -->
<!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
<script type="text/javascript" src="../js/browserplus-min.js"></script>
<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
<script type="text/javascript" src="../js/plupload.full.js"></script>
<!-- ----------------------------------------------------------------------- -->
<!-- Include Lightbox (Production) ----------------------------------------- -->
<link type="text/css" rel="stylesheet" media="screen" href="../css/style.css" />
<!-- ----------------------------------------------------------------------- -->

<form name="form1" id="form1" method="post"  >

<input type="hidden" value="<?= $_GET["cod"] ?>" name="id_topico" id="id_topico">

<? create_table_extjs("99%","130px",$title_desafio);?>

<? require("form_topicos.php"); ?>
  <tr nowrap>
   <td align="left">
   
   <!--
   
   <input type="button" name="btn_salvar2" id="btn_salvar2" value="Atualizar Página" style="margin-right:5px;"   class="botao" onmouseover="this.className='botao_hover'" onmouseout="this.className='botao'"  onclick="refreshobjeto(this.form)" />     <input type="hidden" name="refresh" value="yes" />
   
   -->
   </td>
    <td colspan="5" align="right">
    
    
    
<?
	/////// ############# Verifica Permissão de Usuário ##############
	//	$permission = verifica_acesso('desafio','','',2);
		//if ($permission != "Acesso Negado"){	
	/////// ########################################################## 
    

	/////// ############# Verifica Permissão de Usuário ##############
	//	}	
	/////// ##########################################################
?>
      
      
      
      </td>
  </tr>
</table>
<? end_table_extjs();?>

</form >

  <iframe frameborder="0" NAME="grid_iframe" WIDTH="0" HEIGHT="0" style="display:none;">No Inlineframes</iframe>
  
  
  
 <script>
	
  
function valida_youtube(url) {
	if(trim(url)){
		  var myDate = new Date();
	  
		  var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
		  if  ( (url.match(p)) ? RegExp.$1 : false ){		
			  var player = document.getElementById("preview_video");
			  player.data = 'https://www.youtube.com/v/' + RegExp.$1 + '&autoplay=0&rel=1&version=3&autohide=1&'+myDate.getTime();	
			  var player2 = document.getElementById("preview_video2");
			  player2.value = 'https://www.youtube.com/v/' + RegExp.$1  + '&autoplay=0&rel=1&version=3&autohide=1&'+myDate.getTime();	
			  var player3 = document.getElementById("preview_video3");
			  player3.src = 'https://www.youtube.com/v/' + RegExp.$1  + '&autoplay=0&rel=1&version=3&autohide=1&'+myDate.getTime();	
			  
			  
			var objectspanmakeinnerhtml = "";
			objectspanmakeinnerhtml = document.getElementById("objectspan").innerHTML;
			document.getElementById("objectspan").innerHTML = "";
			document.getElementById("objectspan").innerHTML = objectspanmakeinnerhtml;
			  
					  
		  }else{
			  alert("Digite um Link do YouTube Válido");	
			  document.forms[0].myYouTubePlayer.value = "";
			  document.forms[0].myYouTubePlayer.focus();
		  }
		  
	}	
}




function adicionar_video_topico(form) {
	var myDate = new Date();
	var vetor = new Array ("myYouTubePlayer");	
	var msg= new Array(" link do seu vídeo no YouTube");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }	  	  
	  var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
	  if  ( (form.myYouTubePlayer.value.match(p)) ? RegExp.$1 : false ){		
	  
			form.target = "grid_iframe";
			form.action = "operacoes.php?adicionar_youtube_topico=yes"+"&value="+ encodeURIComponent(RegExp.$1)+"&time="+myDate.getTime();
			form.submit();
				  
	  }else{
		  alert("Digite um Link do YouTube Válido");	
		  form.myYouTubePlayer.value="";
		  form.myYouTubePlayer.focus();
	  }
}

	
function atualiza_arquivos(){
	atualiza_conteudo("operacoes.php","id_topico=<?= $_GET["cod"]  ?>&listar_arquivos=yes","POST",handleHttpArquivos);
}



function count_fotos(){
	 var itens = document.getElementById("fotos_container").getElementsByTagName("LI");
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
		results = http.responseText.split("###ajax_split###");
		//alert(results[1]);		
  		document.getElementById("fotos_container").innerHTML = results[0];	
		document.getElementById("videos_container").innerHTML = results[1];	
		
		$(document).ready(function() {
			$("a.fancybox").fancybox({
				'overlayShow'	: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});		
		});
	}
}


function delete_anexo(id_anexo){
	var ok;
	ok = confirm("Confirma excluir esse registro?");
	if(ok){	
		atualiza_conteudo("operacoes.php","id_anexo="+id_anexo+"&delete_anexo=yes","POST",handleHttpDeletarAnexo);
	}
	
}
function handleHttpDeletarAnexo(){
	if (http.readyState == 4) {		
		atualiza_arquivos();
	}
}
	
	
	
$(function() {
	$( ".date_field" ).datepicker({									  
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
	

	//xinha --------------------------------------------------------
		var xinha_plugins =
		[
		 'Linker'
		];
		var xinha_editors =
		[
		  'descricao'		];
		
		function xinha_init()
		{
		  if(!Xinha.loadPlugins(xinha_plugins, xinha_init)) return;
		
		  var xinha_config = new Xinha.Config();
		  
		//	xinha_config.width = "700px";
		//	xinha_config.height = "300px";
		  xinha_editors = Xinha.makeEditors(xinha_editors, xinha_config, xinha_plugins);
		  
		  // xinha_editors.instrucao.config.height = 550;
		
		  Xinha.startEditors(xinha_editors);
		}
		Xinha.addOnloadHandler(xinha_init);
	

   $('#tabs').bind('tabsshow',    // Quando carregar uma aba
	 function( event, ui ){   		
		if (ui.panel.id == "tabs-1") {  //somente quando for a aba tab3    
		   xinha_editors.obs.sizeEditor(); // necessário dar resize para corrigir um bug do xinha
		   }
		} );
   
   
   $('a.title').cluetip({splitTitle: '|'});
     


    var uploader = new plupload.Uploader({
        runtimes : 'gears,html5,flash,html4,silverlight,browserplus',
        browse_button : 'pickfiles',
        container : 'container',
        max_file_size : '200mb',
        url : 'upload.php',
        flash_swf_url : '../js/plupload.flash.swf',
        silverlight_xap_url : '../js/plupload.silverlight.xap',
        filters : [
			{title : "All files", extensions : "jpg,gif,tiff,png,psd,htm,html,css,zip,rar,tar,gzip,txt,doc,docx,xls,xlsx,ppt,pptx,pps,odt,ods,odp,sxw,sxc,sxi,wpd,pdf,rtf,csv,tsv,mp3,ogg,wav,mov,mp4,f4v,flv"},   
            {title : "Image files", extensions : "jpg,gif,tiff,png,psd"},
			{title : "Web files", extensions : "htm,html,css"},
			 {title : "Archive files", extensions : "zip,rar,tar,gzip"},
			 {title : "Document files", extensions : "txt,doc,docx,xls,xlsx,ppt,pptx,pps,odt,ods,odp,sxw,sxc,sxi,wpd,pdf,rtf,csv,tsv"},
			 {title : "Audio files", extensions : "mp3,ogg,wav"},
			 {title : "Video files", extensions : "mov,mp4,f4v,flv"}


        ],
      //  resize : {width : 320, height : 240, quality : 90},
		multipart_params : {
          "id_topico" : $("#id_topico").val()
   	    }
    });

    uploader.bind('Init', function(up, params) {
     //   $('#filelist').html("<div>Current runtime: " + params.runtime + "</div>"); 	 
	 atualiza_arquivos();
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
		
			 atualiza_arquivos();
			 // $("#tabs").tabs("select", "tabs-listar_anexo");
			up.splice(); // reset the queue to zero)
			//alert(dump(lista));
		}
		
		//up['files'].length = 0; // reset the queue to zero
		
		
    });
   
   
   
});


$( "#tabs" ).tabs();	// spry tabs  // precisa carregar antes do xinha senão dá bug no IE
// xinha ---------------------------------------------------------------------------
var _editor_url = "../lib/xinha_0.96.1/"; // precisa carregar antes do arquivo js externo do xinha
var _editor_lang = "en";
var _editor_skin = "ima-skin";



</script>
<script type="text/javascript" src="../lib/xinha_0.96.1/XinhaCore.js"></script>


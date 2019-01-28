<? 
if(!$_REQUEST["id_solicitacao"]) exit("Solicitação Não carregada, por favor, tente novamente");


foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	


$layout = new layout;
echo '<style>
table tr td {font-family:Verdana, Geneva, sans-serif;font-size:12px;}
legend{
	color:#15428B;
} 

select option{
 
}

.ui-tabs .ui-tabs-nav li a {
	padding: .5em .3em;
	font-size:12px;
}




</style>
';
$layout -> set_body('','','');?>
<!-- plUpload -- ----------------------------------------------------------- -->
<!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
<script type="text/javascript" src="../js/browserplus-min.js"></script>
<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
<script type="text/javascript" src="../js/plupload.full.js"></script>
<!-- ----------------------------------------------------------------------- -->
<!-- Include Lightbox (Production) ----------------------------------------- -->
	<link type="text/css" rel="stylesheet" media="screen" href="../css/style.css" />    
<!-- ----------------------------------------------------------------------- -->



 
	

<script type="text/javascript">



// Custom example logic





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
	  //alert(http.responseText);	  
	  	results = http.responseText.split("##ajax_split##");	  
		document.getElementById("fotos_conteiner").innerHTML = results[0];		
		document.getElementById("arquivos_correcao").innerHTML = results[1];	
	
	}
}



</script>
<?
$sql_empresa = "SELECT razao_social,nome_fantasia
		FROM empresas
		WHERE (id_empresa = '".$id_empresa."') 
		limit 1
		";  	
$rs_empresa = get_record($sql_empresa);	



$sql_questionario = "SELECT  a.id_questionario,  a.nome_questionario,  b.data_finalizacao,  c.data_finalizacao as solicitacao_finalizada, c.data_cancelamento, c.id_situacao
			FROM questionarios as a
			INNER JOIN questionarios_x_solicitacoes as b ON (a.id_questionario = b.id_questionario AND id_solicitacao= '".$id_solicitacao."')
			INNER JOIN solicitacoes as c ON (c.id_solicitacao = b.id_solicitacao)
			WHERE (a.data_cancelamento IS NULL AND a.id_tipo_questionario = '".$id_tipo_questionario."')
			limit 1
			";  	
$rs_questionario = get_record($sql_questionario);




if ($id_tipo_questionario == '1'){
	  /////// ############# Verifica Permissão de Usuário ##############		
	  $permission = verifica_acesso('','alterar_ficha_segmentacao','','');	
	  if ($permission == "Acesso Negado"){ 
		  $permission = "no";	
	  }
	  /////// ##########################################################	
}else{
	  /////// ############# Verifica Permissão de Usuário ##############		
	  $permission = verifica_acesso('','alterar_questionario_autoavaliacao','','');	
	  if ($permission == "Acesso Negado"){ 
		  $permission = "no";	
	  }
	  /////// ##########################################################		
}




?>




<form  method="post" enctype="multipart/form-data" name="ficha_form" >

<?
	/////// ############# Verifica se pode alterar formulario ##############

		if  (($rs_questionario["solicitacao_finalizada"])||($rs_questionario["data_cancelamento"])||($permission == "no") ){	
			echo '
			<script>
				window.onload  = function(){
					desabilita_form(this.form);					
				}			
			</script>			
			';		
		}
	/////// ##########################################################
?>




<? 	if ($rs_questionario["data_finalizacao"]){ ?>
    <div style="position:fixed;width:100%;text-align:center;">	
    <center>
            <div style="width:auto;padding:0 0 0 3px;text-align:center;background:#fff4c8;border:1px solid #ffcc00;">
    <b>Formulário Finalizado em <?= data_br(substr($rs_questionario["data_finalizacao"],0,10))." as ".substr($rs_questionario["data_finalizacao"],11,5); ?></b></b>
            </div>
    </center>
    </div>
    <br>                    
<?	}else{   ?>
    <div style="position:fixed;width:100%;text-align:center;">	
    <center>
            <div style="width:auto;padding:0 0 0 3px;text-align:center;background:#fff4c8;border:1px solid #ffcc00;">
    <b>Após preencher o formulário, é preciso validar as questões clicando aqui  </b><img src="../images/i.p.next.gif">
    <input  type="button" class="botao" value="Finalizar <?= $rs_questionario["nome_questionario"] ?> " onClick="finalizar_questionario(this.form,'<?= $rs_questionario["id_questionario"] ?>','<?= $_REQUEST["id_solicitacao"] ?>')">
            </div>
    </center>
    </div>
    <br><br> 
<? }  ?>



<input type="hidden" value="<?= $_REQUEST["id_solicitacao"] ?>" name="id_solicitacao" id="id_solicitacao" >
<? 


if($rs_questionario["nome_questionario"]){	
	create_table_extjs("99%","130px",$rs_questionario["nome_questionario"]);
	require("form_questionario.php");
	end_table_extjs("..");
}
?>

<input type="hidden" name="id_pergunta_array" value="<?= implode(',', $id_pergunta_array) ?>">

</form >
  
  
  
  <iframe frameborder="0" NAME="grid_iframe" WIDTH="0" HEIGHT="0" style="display:none;">No Inlineframes</iframe>
  
	<script>
$(function() {

	$( "#datepicker, .date_field" ).datepicker({									  
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
		  'obs'
		];
		
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
		if (ui.panel.id == "tabs-3") {  //somente quando for a aba tab3    
		   xinha_editors.obs.sizeEditor(); // necessário dar resize para corrigir um bug do xinha
		   }
		} );
   
   
   $('a.title').cluetip({splitTitle: '|'});
   
   
   
	
	
});


	</script>
    
    
     <script>
	 
$( "#tabs" ).tabs();	// spry tabs  // precisa carregar antes do xinha senão dá bug no IE
// xinha ---------------------------------------------------------------------------
var _editor_url = "../lib/xinha_0.96.1/"; // precisa carregar antes do arquivo js externo do xinha
var _editor_lang = "en";
var _editor_skin = "ima-skin";
</script>
<script type="text/javascript" src="../lib/xinha_0.96.1/XinhaCore.js"></script>
  <script>
  /*
    window.onload  = function(){
		  var tags = new Array ("input","textarea","select",'img');		
		  for (x=0;x<tags.length;x++){		
			  var el = document.getElementsByTagName(tags[x]);		
			  for (var y in el){
			  	   if (el[y].value != "Sair"){
						el[y].disabled = "disabled";
						el[y].onclick = "";			
				   }
			  }
		  }
    }		
	*/
  </script>	

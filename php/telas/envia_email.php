<? 

if(
   ($_REQUEST["id_contribuicao"]) ||
   ($_REQUEST["id_comentario"]) ||
   ($_REQUEST["id_proposta"])
){
}else{exit("Falha na transação, por favor, tente novamente");}


echo '<style>
table tr td {font-family:Verdana, Geneva, sans-serif;font-size:12px;}
legend{
	color:#15428B;
} 

select option{
 
}

.ui-tabs .ui-tabs-nav li a {
	padding: .5em .6em;
}

</style>
';
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



 
	

<script type="text/javascript">



// Custom example logic






</script>

<form  method="post" enctype="multipart/form-data" name="ficha_form" >




<? 





if($_POST){
	
	$Subject = $_POST["assunto"];
	$Html = email_header().$_POST["texto_email"].email_footer();
	
	$EmailRecipient = $_POST["email"];			  				
	SendMail(InfoSystem::email_sender,InfoSystem::titulo,$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
	
	echo "email enviado para ".$EmailRecipient;
	
	
	if ($_REQUEST["id_contribuicao"]){  
		$sql = "UPDATE contribuicoes SET motivo_reprovacao='".safe_text($Html)."' WHERE  id_contribuicao='".$_REQUEST["id_contribuicao"]."';";   
	}
	
	if ($_REQUEST["id_comentario"]){  
		$sql = "UPDATE comentarios SET motivo_reprovacao='".safe_text($Html)."' WHERE  id_comentario='".$_REQUEST["id_comentario"]."';";  
	}
	
	if ($_REQUEST["id_proposta"]){  
		$sql = "UPDATE contribuicoes SET motivo_reprovacao='".safe_text($Html)."' WHERE  id_contribuicao='".$_REQUEST["id_proposta"]."';";    
	}
	
	
	if($sql) update_record($sql);
	
	exit();
}




if ($_REQUEST["id_contribuicao"]){  
	$sql = "SELECT  id_participante
			FROM contribuicoes		
			WHERE (id_contribuicao = '".$_REQUEST["id_contribuicao"]."') 	
			LIMIT 1";
    $objeto = "Inspiração";
	$add_name = $_REQUEST["id_contribuicao"];
	
	echo '<input type="hidden" value="'.$_REQUEST["id_contribuicao"].'" name="id_contribuicao" id="id_contribuicao" >';
}

if ($_REQUEST["id_comentario"]){  
	$sql = "SELECT  id_participante
			FROM comentarios		
			WHERE (id_comentario = '".$_REQUEST["id_comentario"]."') 	
			LIMIT 1";
    $objeto = "Comentário";
	$add_name = "_comentario".$_REQUEST["id_comentario"];
	
	echo '<input type="hidden" value="'.$_REQUEST["id_comentario"].'" name="id_comentario" id="id_comentario" >';
}

if ($_REQUEST["id_proposta"]){  
	$sql = "SELECT  id_participante
			FROM contribuicoes		
			WHERE (id_contribuicao = '".$_REQUEST["id_proposta"]."') 	
			LIMIT 1";
    $objeto = "Proposta";
	$add_name = "_proposta".$_REQUEST["id_proposta"];
	
	echo '<input type="hidden" value="'.$_REQUEST["id_proposta"].'" name="id_proposta" id="id_proposta" >';
}


	$rs = get_record($sql);		


	//$cpf_cnpj = formatarCPF_CNPJ($rs["cpf_cnpj"]);
	
	$participante = get_participante($rs["id_participante"]);

	
			$Html .=  'Olá '.$participante["nome"] .',<br><br>';				
			
			if ($_GET["aprovado"] == '1'){
				$Html .= "Parabéns sua Contribuição foi aprovada e publicada na plataforma Campinas e-você.";
				$Html .= "<br><br> Divulgue ela para mais pessoas e ajudemos a torná-la realidade!<br>";
				$Html .= '<a href="'.InfoSystem::url_site.'">'.InfoSystem::url_site.'</a>';
			}else{
				$Html .= "Sua contribuição para a Campinas e-você foi reprovada.";
				$Html .= "<br><br><b>Motivo:</b>";
			}				
			
			$Html .= "<br><br> Agradecemos pela sua participação ";
			
						
			$Html .= '<br><br>Muito obrigado por sua participação,<br>Novas contribuições são sempre bem-vindas!';
			
				
			$Html .= '<br><br>Atenciosamente,<br>Prefeitura de Campinas';
			
			$Html .= '<br>';
			$Html .= '<a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br><br>';
				





 
 
     

create_table_extjs("99%","130px","Enviando Email para: ".$participante["nome"]);




if ($_GET["aprovado"] == '1'){
	$contribuicao_text = "Contribuição Aprovada ";	
}else{
	$contribuicao_text = "Contribuição Reprovada ";	
}


?>

<table style="margin:0px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">
  <tr >
    <td colspan="5" nowrap><div style="width:10%;float:left;text-align:right;font-weight:bold" >Para &nbsp;</div>
    
    <input name="email"  id="email"  type="text" class="x-form-text x-form-field"  style="width:90%;float:left" value="<?= $participante["email"]  ?>"   maxlength="180"   onBlur="check_mail(this);" />
   </td>
  </tr>
  <tr >
   <td colspan="5" nowrap><div style="width:10%;float:left;text-align:right;font-weight:bold">Assunto &nbsp;</div>
    
    <input name="assunto" type="text" class="x-form-text x-form-field" id="assunto" style="width:90%;float:left" value= "<?= $contribuicao_text. " | ".InfoSystem::nome_sistema ?>"   maxlength="180"   />
   </td>
  </tr>
  <tr nowrap="nowrap">    
    <td colspan="5" nowrap="nowrap" style="width:100%;">
 <textarea style="width:100%;height:300px;" rows="5" name="texto_email"  id="texto_email" class="x-form-text x-form-field" ><?= $Html ?></textarea>    
    </td>
  </tr>
  
  
</table>



<table style="margin:0px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">
  <tr nowrap>
    <td colspan="6" align="right">    
 

 <input type="button" name="btn_salvar" value="Sair" onclick='parent.document.getElementById("Containerenvia_email<?= $add_name ?>").style.display =  "none";' style="margin-right:5px;float:right"   class="botao" onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"   >   
 
     <input type="submit" name="btn_salvar" value="Envia E-mail" style="margin-right:5px;float:right"   class="botao" onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"   > 
          <a href="#"  class="win-close-btn" ></a>
           
    
      </td>
  </tr>
</table>
<? end_table_extjs("..");?>

</form >
  
  
  
  <iframe frameborder="0" NAME="grid_iframe" WIDTH="0" HEIGHT="0" style="display:none;">No Inlineframes</iframe>
  
	<script>
$(function() {


	//xinha --------------------------------------------------------
		var xinha_plugins =
		[
		 'Linker'
		];
		var xinha_editors =
		[
		  'texto_email'
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




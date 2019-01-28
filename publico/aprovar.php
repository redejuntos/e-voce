<?
ini_set("display_errors", "0"); //Retira o Warning


require_once ("./php/connections/connections.php");	
require_once ("./php/funcoes.php");



if (($_GET["hash"]=="")||($_GET["aprov"]=="")) exit('');


$key = "2565778324676";

$result = explode("|",decrypt_md5(base64_url_decode($_GET["hash"]),$key) );


if ($_GET["aprov"]){
	$aprovado = 'S';
}else{
	$aprovado = 'N';
}

//echo $result[0]."a".$result[1];	

if (is_numeric($result[0]) &&  is_numeric($result[1]) ){		
	
	  if($_POST){
				 if  (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) == false) exit("acessoNaoAutorizado");
				 
				 $participante = get_participante($result[1]);	 
				 
				 
				 $sql = "UPDATE contribuicoes SET motivo_reprovacao='".safe_text($_POST["motivo_reprovacao"])."' WHERE  id_contribuicao='".$result[0]."' AND id_participante='".$result[1]."';";     
				 update_record($sql);
				////////////////////////////////////////////////////////////////////
				//////////////// envia email  para o cliente/////////////////////////////////
				//////////////////////////////////////////////////////////////////
				$Subject = "Contribuição reprovada | ".InfoSystem::nome_sistema;			
				
				$Html = email_header();		
				$Html .=  $participante["nome"] .',<br><br>';
				$Html .= "Sua contribuição para a Campinas e-você foi reprovada.";
				$Html .= "<br><br>";
				$Html .= "Motivo: ".safe_text($_POST["motivo_reprovacao"]);
				
				$Html .= "<br><br>Muito obrigado por sua participação, ";
				
							
				$Html .= '<br>Novas contribuições são sempre bem-vindas!<br>';				
		
				$Html .= '<br><br>Atenciosamente,<br>Prefeitura de Campinas<br>';
				$Html .= '<a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br>'.email_footer();
					
				
				$Html .= '</html></body>';			
						  
				$EmailRecipient = $participante["email"];			  				
				SendMail(InfoSystem::email_sender,InfoSystem::titulo,$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
				 
				 
				 
				 echo "email enviado para ".$participante["email"];;
		  
	  }else{		//get  
			$sql = "UPDATE contribuicoes SET aprovado='".$aprovado."' WHERE  id_contribuicao='".$result[0]."' AND id_participante='".$result[1]."';";    	  
			if($aprovado == 'S'){
					if (update_record($sql)) echo "Publicacão aprovada com sucesso";		
					
					$participante = get_participante($result[1]);	 
					////////////////////////////////////////////////////////////////////
					//////////////// envia email  para o cliente/////////////////////////////////
					//////////////////////////////////////////////////////////////////
					$Subject = "Contribuição Aprovada | ".InfoSystem::nome_sistema;			
					
					$Html = email_header();		
					$Html .=  $participante["nome"] .',<br><br>';
					$Html .= "Parabéns, sua Contribuição foi aprovada e publicada na plataforma Campinas e-você.";
					$Html .= "<br><br> Divulgue ela para mais pessoas e ajudemos a torná-la realidade!<br>";
					
					$Html .= '<a href="'.InfoSystem::url_site.'">'.InfoSystem::url_site.'</a>';
					
								
					$Html .= '<br><br>Muito obrigado por sua participação,<br>Novas contribuições são sempre bem-vindas!';
					
					$Html .= '<br><br>Atenciosamente,<br>Prefeitura de Campinas<br>';
					$Html .= '<a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br>'.email_footer();
					
					$Html .= '</html></body>';			
							  
					$EmailRecipient = $participante["email"];			  				
					SendMail(InfoSystem::email_sender,InfoSystem::titulo,$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
					
					
					
			}else{
					if (update_record($sql)) {
					
					echo "Publicacão não aprovada<br><br>";	
					require_once ("./php/class.php");			  
					$layout = new layout;
					$layout -> cabecalho();
					$layout -> css('.');	
					$layout -> js('.');
					
					
					
					
					echo '
					<form method="POST" action="?hash='.$_GET["hash"].'&aprov='.$_GET["aprov"].'">
					<table>
					<tr><td colspan="2">
					   <input type="hidden" name="id_participante" value="'.$result[1].'">
					</td></tr>
				  
					<tr><td>			 
	  
		Motivo:   
	  
					
					</td>
					<td>
					 <textarea style="width:400px;height:200px;" rows="5" name="motivo_reprovacao"   class="x-form-text x-form-field" ></textarea> 
					</td>			  
					</tr>
					
					 <tr><td></td><td>
				  
			   <input type="button" name="btn_salvar" value="Envia E-mail" onclick="enviar_email_participante(this.form);"  class="botao" onMouseOver="this.className=\'botao_hover\'" onMouseOut="this.className=\'botao\'"   > 
				   </td></tr>		  
					
					</table>
					</form>  
					';					
					}					
			}
	  }
}
	
	



?>
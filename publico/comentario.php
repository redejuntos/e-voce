<?
ini_set("display_errors", "0"); //Retira o Warning


require_once ("./php/connections/connections.php");	
require_once ("./php/funcoes.php");



if (($_GET["hash"]=="")) exit('');


$key = "2565778324676";

$result = explode("|",decrypt_md5(base64_url_decode($_GET["hash"]),$key) );



//echo $result[0]."a".$result[1];	

if (is_numeric($result[0]) &&  is_numeric($result[1]) ){		
	
	  if($_POST){
				 if  (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) == false) exit("acessoNaoAutorizado");
				 
				 $participante = get_participante($result[1]);	 
				 
				 
				 $sql = "UPDATE comentarios SET motivo_reprovacao='".safe_text($_POST["motivo_reprovacao"])."' WHERE  id_comentario='".$result[0]."' AND id_participante='".$result[1]."';";     
				 update_record($sql);
				////////////////////////////////////////////////////////////////////
				//////////////// envia email  para o cliente/////////////////////////////////
				//////////////////////////////////////////////////////////////////
				$Subject = "Comentário não aprovado - ".InfoSystem::nome_sistema;			
				
				$Html = email_header();		
				
				$Html .= 'Oi '.$participante["nome"].', <br><br>';
				$Html .= "Seu comentário para a Campinas e-você foi reprovado.";
				$Html .= "<br><br>";
				$Html .= "Motivo:".safe_text($_POST["motivo_reprovacao"]);
				$Html .= "<br><br>Muito obrigado por sua participação, ";
							
				$Html .= '<br>Novas contribuições são sempre bem-vindas!<br>';			
		
				$Html .= '<br><br>Atenciosamente,<br>Prefeitura de Campinas<br>';
				$Html .= '<a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br>'.email_footer();

				
				$Html .= '</html></body>';			
						  
				$EmailRecipient = $participante["email"];			  				
				SendMail(InfoSystem::email_sender,InfoSystem::titulo,$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
				 
				 
				 
				 echo "email enviado para ".$participante["email"];;
		  
	  }else{		//get  
	  
			$sql = "UPDATE comentarios SET aprovado='N' WHERE id_comentario='".$result[0]."' AND id_participante='".$result[1]."';";    	  
	  

			if (update_record($sql)) {
					
					echo "Comentário não aprovado<br><br>";	
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
	
	



?>
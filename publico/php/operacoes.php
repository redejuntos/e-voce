<?
session_start();
// ----------------- no cache----------------------------
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT"); 
@header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

require_once ("./connections/connections.php");	
require_once ("./funcoes.php");

ini_set("display_errors", "0"); //Retira o Warning


foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):valida_SQL_injection($b);	
		  

 if  (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) == false) exit("acessoNaoAutorizado");
 
session_start();


////////////////////////////////////////////////////////////////////////////////
/////////////////////// logar_comunidade /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["logar_comunidade"]){	

   if ( !$login_email || !$senha )   {
		 echo '<script>alert("Ocorreu algum erro na transa��o. Tente novamente");</script>';	
         exit();
   }   
   
		$sql = "
select id_participante, nome_participante ,email, login, endereco, numero, cep, cpf, telefone, id_municipio, data_nascimento,facebook_id, avatar from participantes where (upper(email) = upper('".$login_email."') OR upper(login) = upper('".$login_email."') ) AND senha = '".md5($senha)."'  AND data_cancelamento is NULL LIMIT 1
";		

		//echo $sql;

		if ($rs = get_record($sql)){	
				$_SESSION["id_participante_session"] = $rs["id_participante"];
		    	$_SESSION["nome_participante_session"] = $rs["nome_participante"];	
				
			  if (trim($rs["avatar"])){
				   $image_avatar = $rs["avatar"];
			  }else{
				  	if($rs["facebook_id"]){
						$image_avatar = 'https://graph.facebook.com/'.$rs["facebook_id"].'/picture?width=200&height=200';						
					}else{
						$image_avatar = './images/avatar.jpg';				 		 
					}
			  }		
				
			  $_SESSION["imagem_avatar"] = $image_avatar;
			
 			   echo '<script>
			      parent.document.getElementById("pickfiles").src = "'.$image_avatar.'";	
				   var form = parent.document.tela_meu_cadastro_form;
				   form.nome_participante.value = "'.$rs["nome_participante"].'";
				//   form.endereco.value = "'.$rs["endereco"].'";
				//   form.numero.value = "'.$rs["numero"].'";
				   form.cpf.value = "'.formatarCPF_CNPJ($rs["cpf"]).'";
				   form.telefone.value = "'.$rs["telefone"] .'";
				   form.data_nascimento.value = "'.data_br($rs["data_nascimento"]).'";
				 </script>';
			
			
			   echo '<script>
						  //alert("Login efetuado com sucesso. Bem vindo a nossa Comunidade");	
						parent.limpa_form(parent.document.login_form);
						parent.$( "#log-in-form" ).animate({
							  right: "-300px"					
						}, 400 );		
						
						setTimeout(function() { 
								parent.$( "#login-side" ).animate({
									  top: "-300px"					
								}, 500 );	
					  }, 500);	
						
						setTimeout(function() { 
								parent.$( "#cadastro-form" ).animate({
								  right: "-400px"					
								 }, 500 );	
					  }, 600);	
		  
						setTimeout(function() { 
								parent.$( "#esqueceu_senha_form" ).animate({
									  top: "-400px"					
								}, 500 );	
					  }, 700);	
						
						setTimeout(function() { 
								parent.$( "#meu_cadastro_side" ).animate({
									  top: "240px"					
								}, 500 );	
					  }, 800);	
				</script>';
				
				
				if ($image_avatar == './images/avatar.jpg'){ // se foto nao cadastrada, abrir janela
				echo '				
				<script>
						setTimeout(function() { 
								parent.$( "#meu_cadastro_form" ).animate({
									  right: "80px"					
								}, 500 );
					  }, 900);	
				</script>';
				}
				
				
				?>  
                 <div  id="estado" >
                    <? //get_uf(get_estado_by_municipio($rs["id_municipio"]));	  ?>
                  </div>
              
                  <div id="id_municipio">  
                   <? //get_municipios(get_estado_by_municipio($rs["id_municipio"]),$rs["id_municipio"]); ?>
                 </div>                
                <?
			   echo '<script>
			  	   var form = parent.document.tela_meu_cadastro_form;				   
			//	  form.estado.innerHTML = document.getElementById("estado").innerHTML;
			//	  form.id_municipio.innerHTML = document.getElementById("id_municipio").innerHTML;  
			//	  parent.document.getElementById("label_login").innerHTML = "'.$rs["login"].'";
				  parent.document.getElementById("label_email").innerHTML = "'.$rs["email"].'";
				  parent.document.getElementById("saudacoes_login").innerHTML = \'<span style="color:#0096e1;font-size:12px;font-weight:bold;"> Ol� <b style="color:#393e44;font-size:12px"> '. $rs["nome_participante"]  .' </b>   </span> \';

				 </script>';				
         exit();
		}else{
		 echo '<script>
		 alert("Dados de Acesso Inv�lidos. \nDigite Novamente");
		 parent.limpa_form(parent.document.login_form);
		 </script>';	
         exit();
		}

}
////////////////////////////////////////////////////////////////////////////////
/////////////////////// cadastrar_participante /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["valid_request_cadastrar_participante"]){	 


   if ( !$nome_participante || !$email || !$cpf  || !$senha || !$captcha )   {
		 echo '<script>alert("Ocorreu algum erro na transa��o. Tente novamente");</script>';	
         exit();
   }   
   

	if ($_SESSION['session_textoCaptcha'] != $captcha){
			$mensagem = "C�digo de Valida��o Inv�lido!";
			echo '<script>
			   alert("'.$mensagem.'");
			   parent.document.cadastro_form.captcha.value="";
		   	   parent.document.cadastro_form.captcha.focus();
			</script>';		
			exit();
	}
	
	
   if ( trim($email) ) {
		$sql = "select id_participante from participantes where upper(email) = upper('".$email."')  LIMIT 1;";		
		if ($rs = get_record($sql)){		
		    echo '<script>alert("J� existe usu�rio(s) cadastrado(s) com esse E-mail \n'.$email.'");</script>';
			exit();
		}
   }
   
   
	$sql = "select cpf from participantes where cpf = '".limpaCpf_Cnpj($cpf)."'  LIMIT 1;";		
	if ($rs = get_record($sql)){		
		echo '<script>alert("J� existe usu�rio(s) cadastrado(s) com esse CPF \n'.$cpf.'");</script>';
		exit();
	}else{		
		  $sql_insert = "INSERT INTO participantes (nome_participante, id_municipio,  email, telefone, cpf, senha, data_nascimento, data_inclusao) VALUES ('$nome_participante', ".noempty($id_municipio).", ".noempty($email).", ".noempty($telefone).", ".noempty(limpaCpf_Cnpj($cpf)).", '".md5($senha)."', ".insertDataDB($data_nascimento).", '".date("Y-m-d H:i:s")."');
		  ";
		  if (insert_record($sql_insert)){	
		  		$id_participante = mysql_insert_id();
		  		$_SESSION["id_participante_session"] = $id_participante;
		    	$_SESSION["nome_participante_session"] = $nome_participante;	
				$image_avatar = './images/avatar.jpg';	
			 	$_SESSION["imagem_avatar"] = $image_avatar;
		  	
		  
		  echo '<script>alert("Usu�rio cadastrado com Sucesso \nE-mail: '.$email.'");		  
				  //parent.limpa_form(parent.document.cadastro_form);
				 //   parent.$( "#cadastro-form" ).animate({
					//right: "-400px"					
			 	 //   }, 500 );		
		  		parent.location.href="../index.php";
		  </script>';
		  
		  

			////////////////////////////////////////////////////////////////////
			//////////////// envia email /////////////////////////////////
			//////////////////////////////////////////////////////////////////
			$Subject = "Cadastro | ".InfoSystem::nome_sistema;			
			
			$Html = '<html><body bgcolor="#ffffff">'.email_header();
			

			$Html .= 'Ol� '.$nome_participante.', <br><br>';
			$Html .= "Bem-vindo ao ".InfoSystem::nome_sistema.", a plataforma de Inova��o Aberta da Prefeitura Municipal de Campinas.".'<br><br>';
		
			
			$Html .= 'Seu Login de Usu�rio �: '.$email.'<br>';
			$Html .= 'Sua Senha �: '.$senha.'<br>';
			
			$Html .= InfoSystem::nome_sistema.': <a href="'.InfoSystem::url_site.'">'.InfoSystem::url_site.'</a><br><br>';						
			
			$Html .= 'Agora voc� j� pode contribuir com inspira��es, propostas e votar nas melhores solu��es para a o servi�o p�blico de sa�de em Campinas. <br>';
			
			$Html .= '<br>Caso esque�a sua senha, voc� poder� gerar uma nova senha pelo bot�o "Lembrar Senha" na nossa p�gina inicial de login.<br>';
			
			$Html .= '<br>Muito obrigado por se cadastrar e seja muito bem-vindo!<br>';
			$Html .= '<br>Atenciosamente,<br>Prefeitura de Campinas<br><a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br><br><br>'.email_footer();
			
			$Html .= '</html></body>';					  
					  
			$EmailRecipient = $email;			  
			
			SendMail(InfoSystem::email_sender,InfoSystem::titulo,$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
			///////////////////////////////////////////////////////////////////////////////////////		  		  
          exit();
		  
		  }
	}	  
}



////////////////////////////////////////////////////////////////////////////////
/////////////////////// valid_request_alterar_participante /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["valid_request_alterar_participante"]){	

   if ( !$nome_participante || !$_SESSION["id_participante_session"])   {
		 echo '<script>alert("Ocorreu algum erro na transa��o. Tente novamente");</script>';	
         exit();
   }     


	$sql = "UPDATE participantes SET nome_participante='$nome_participante', cpf=".noempty(limpaCpf_Cnpj($cpf)).", telefone=".noempty($telefone).", data_nascimento=".insertDataDB($data_nascimento).", data_alteracao='".date("Y-m-d H:i:s")."' WHERE  id_participante='".$_SESSION["id_participante_session"]."' LIMIT 1;
";
   update_record($sql);	
		  echo '<script>alert("Usu�rio alterado com Sucesso \n- '.$nome_participante.'");		
				    parent.$( "#meu_cadastro_form" ).animate({
					right: "-400px"					
			 	    }, 500 );		
		  
		  </script>';
	  		  
          exit();

}




////////////////////////////////////////////////////////////////////////////////
/////////////////////// valid_request_termo_adesao /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["valid_request_termo_adesao"]){	

   if ( !$_SESSION["id_participante_session"])   {
		 echo '<script>alert("Ocorreu algum erro na transa��o. Tente novamente");</script>';	
         exit();
   }   
$add_sql = "";
 
if ($cpf){	
	$add_sql .= ' cpf='.noempty(limpaCpf_Cnpj($cpf)).'	, ';
}

if ($data_nascimento){	
	$add_sql .= ' data_nascimento='.noempty(data_us($data_nascimento)).'  , ';
}



	$sql = "UPDATE participantes SET  $add_sql  termo_adesao='S', data_alteracao='".date("Y-m-d H:i:s")."' WHERE  id_participante='".$_SESSION["id_participante_session"]."' LIMIT 1;
";
//echo $sql;
   update_record($sql);	
		  echo '<script>
		  			alert("Obrigado por Aceitar Nossos Termos de Uso");	
					parent.location.href="../index.php";
				    parent.$( "#meu_cadastro_form" ).animate({
					right: "-400px"					
			 	    }, 500 );	
					
		  
		  </script>';
	  		  
          exit();

}

////////////////////////////////////////////////////////////////////////////////
/////////////////////// verifica_cpf /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["verifica_cpf"]){		

	$sql = "select id_participante from participantes where cpf = '".limpaCpf_Cnpj($cpf)."'  LIMIT 1;";		
	if ($rs = get_record($sql)){		
		echo "J� existe usu�rio(s) cadastrado(s) com esse cpf \n".$cpf;
		exit();
	}

  // echo safe_text(limpaCpf_Cnpj($sql));
	exit();
}


////////////////////////////////////////////////////////////////////////////////
/////////////////////// verifica_email /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["verifica_email"]){		
   if ( trim($email) ) {
		$sql = "select id_participante from participantes where upper(email) = upper('".$email."')  LIMIT 1;";		
		if ($rs = get_record($sql)){		
			echo "J� existe usu�rio(s) cadastrado(s) com esse E-mail \n".$email;
			exit();
		}
   }
	exit();
}


////////////////////////////////////////////////////////////////////////////////
/////////////////////// esqueci_senha_check_value /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["esqueci_senha_check_value"]){		
   if ( !trim($esqueci_senha_value))   {
		 echo '<script>alert("Ocorreu algum erro na transa��o. Tente novamente");</script>';	
         exit();
   }      

		$sql = "
select id_participante,nome_participante,email from participantes where upper(email) = upper('".$esqueci_senha_value."') OR upper(login) = upper('".$esqueci_senha_value."')  LIMIT 1
";		
		if ($rs = get_record($sql)){	
		
			////////////////////////////////////////////////////////////////////
			//////////////// envia email /////////////////////////////////
			//////////////////////////////////////////////////////////////////
			$Subject = "Confirma��o para Gerar Nova Senha - ".InfoSystem::nome_sistema;			
			
			$Html = '<html><body bgcolor="#ffffff">'.email_header();
			
		
			$Html .=  $rs["nome_participante"].',<br><br>';
			$Html .= "Voc� solicitou a gera��o de uma nova senha para acessar sua conta no ".InfoSystem::nome_sistema."  da Prefeitura Municipal de Campinas. Para que a nova senha seja gerada, por favor acesse o link abaixo: ".'<br><br>';
				
			$Html .= 'URL: <a href="'.InfoSystem::url_site.'nova_senha.php?s='.md5($rs["email"]).'">'.InfoSystem::url_site.'nova_senha.php?s='.md5($rs["email"]).'</a><br><br>';
			
						
			$Html .= '<br>Este e-mail foi gerado automaticamente. Este comunicado cont�m informa��es que podem ser confidenciais. Se voc� n�o for o destinat�rio correto deste e-mail, fica notificado que qualquer difus�o, distribui��o ou c�pia desta mensagem ou de seu conte�do � estritamente proibida. Se receber esta mensagem com erro, exclua imediatamente.<br>';
			
			$Html .= '<br><br>';
			$Html .= '<a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br><br><br>'.email_footer();
			
			$Html .= '</html></body>';					  
					  
			$EmailRecipient = $rs["email"];			  
			
			SendMail(InfoSystem::email_sender,InfoSystem::titulo,$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
		  echo '<script>
				  parent.limpa_form(parent.document.esqueci_senha_form);
					parent.$( "#esqueceu_senha_form" ).animate({
						  top: "-400px"					
					}, 500 );		
					
				alert("Por favor, confirme a gera��o de uma nova senha no link enviado para seu email: '.$rs["email"].'");		  
		  
		  </script>';
			
			
		}
	exit();
   
   
}

////////////////////////////////////////////////////////////////////////////////
/////////////////////// enviar_contribuicao /////////////////
////////////////////////////////////////////////////////////////////////////////

if ($_POST["enviar_contribuicao"]){
	
   if ( !$_SESSION["id_participante_session"] )   {
		 echo '<script>
		 
		 alert("Para realizar essa contribui��o � preciso primeiro estar logado no sistema");
		  setTimeout(function() { 
				  parent.$( "#login-side" ).animate({
						top: "130px"					
				  }, 500 );
		}, 1000);	
		 
		 </script>';	
         exit();
   }   
   

	
	$sql_idade = "SELECT data_nascimento FROM participantes WHERE id_participante = '".$_SESSION["id_participante_session"]."'   LIMIT 1 ";
	
	$rs_idade = get_record($sql_idade);
	
	$idade = calcula_idade($rs_idade["data_nascimento"]);
	
   
   if ( $idade < 18 )   {
		 echo '<script>		 
		 parent.showErrorToast("Desculpe. S� � poss�vel contribuir maiores de 18 anos.");
		 </script>';	
         exit();
   }   
/*
	echo "1-".$_FILES["foto"]["name"]."<BR>";	
	echo "2-".$_FILES["foto"]["type"]."<BR>";	
	echo "3-".$_FILES["foto"]['size']."<BR>";
	echo "4-".$_FILES["foto"]['tmp_name']."<BR>";	
	echo "5-".$_FILES["foto"]['error']."<BR>";	
	echo "6-".print_r($_FILES["foto"])."<BR>";	
   */
   
   
   if ($media_flag == 'F'){
	//////////////////////////////////////////////////////////////////////
	//  extrai foto do upload///////////////////////
	////////////////////////////////////////////////////////////////////////
	if (  ($_FILES["foto"]["name"]) && ($_FILES["foto"]['error'] == 0)  ){						
		  $fileName = preg_replace('/[^\w\._]+/', '_', $_FILES["foto"]["name"]); // Clean the fileName for security reasons		
		   $anexo_ext=strtolower(strrchr($fileName,"."));	
		  if( (strtolower($anexo_ext) != ".jpg")&&(strtolower($anexo_ext) != ".png")&&(strtolower($anexo_ext) != ".gif")  ){
		 // if (strtolower($anexo_ext) != ".jpg"){  
				$mensagem = "- Foto n�o importada. � permitido apenas fotos na extens�o JPG, PNG ou GIF".'\n';		
				//$mensagem = "- Foto n�o importada. � permitido apenas fotos na extens�o JPG".'\n';
	 		    echo '<script>alert("'.$mensagem.'");</script>'; 
			    exit();
		  }else{			  
			  	$ano = date("Y");
				$mes = date("m");
				
				//////////////////////////////////
				// Pasta Download
				//////////////////////////////////				
				if(!is_dir("../download")) {
					mkdir("../download", 0755); // 0777 � a permiss�o/CHMOD = 777
					//echo "Diret�rio Ano criado com sucesso";
				} else {
					//echo "Diret�rio Ano n�o criado porque j� existe";
				}				

				//////////////////////////////////
				// Pasta Download
				//////////////////////////////////				
				if(!is_dir("../download/".$ano)) {
				  mkdir("../download/".$ano, 0755); // 0777 � a permiss�o/CHMOD = 777
				  //echo "Diret�rio Ano criado com sucesso";
				} else {
				  //echo "Diret�rio Ano n�o criado porque j� existe";
				}				
				
				//////////////////////////////////
				// Pasta Mes
				//////////////////////////////////				
				if(!is_dir("../download/".$ano."/".$mes)) {
				  mkdir("../download/".$ano."/".$mes, 0755); // 0777 � a permiss�o/CHMOD = 777
				  //echo "Diret�rio Ano criado com sucesso";
				} else {
				  //echo "Diret�rio Ano n�o criado porque j� existe";
				}				
				
				chdir("../download/".$ano."/".$mes);
				$diretorio = getcwd(); 		
				
				$anexo_link= date("Y-m-d-H-i-s").substr(md5(uniqid(rand(), true)),0,8).$anexo_ext;					
				$filePath = $diretorio . DIRECTORY_SEPARATOR . $anexo_link;
				
				if(copy($_FILES["foto"]['tmp_name'],$filePath)) {
					// rezise image				
					//DEFINE OS PAR�METROS DA MINIATURA	
						$thumb_largura = 280;
						$thumb_altura = 180;		
						//CRIA UMA NOVA IMAGEM		
						
					
						
						switch (strtolower($anexo_ext)){
							  case ".jpg":
							   $imagem_orig = imagecreatefromjpeg($filePath);
							   break;
							  case ".png":
							   $imagem_orig = imagecreatefrompng($filePath);
							   break;
							  case ".gif":
							   $imagem_orig = imagecreatefromgif($filePath);
							   break;
						}
			
						//LARGURA						
						$pontoX = imagesx($imagem_orig);
						//ALTURA
						$pontoY = imagesy($imagem_orig);
						//CRIA O THUMBNAIL
												
						
						if ($pontoX > $pontoY){ // paisagem
							$altura = $thumb_altura;
							$largura = abs($thumb_altura * ($pontoX / $pontoY)  );
						}else{ // retrato
							$altura = abs($thumb_largura * ($pontoY / $pontoX) );
							$largura = $thumb_largura;
						}
						
						
						$imagem_fin = ImageCreateTrueColor($largura, $altura);
						//COPIA A IMAGEM ORIGINAL PARA DENTRO
						imagecopyresampled($imagem_fin, $imagem_orig, 0, 0, 0,0, $largura+1, $altura+1, $pontoX, $pontoY);
						//SALVA A IMAGEM								
						
						
						
						switch (strtolower($anexo_ext)){
							  case ".jpg":
							   imagejpeg($imagem_fin, $diretorio . DIRECTORY_SEPARATOR . "tmp".$anexo_link, 80);
							   break;
							  case ".png":
							  imagepng($imagem_fin, $diretorio . DIRECTORY_SEPARATOR . "tmp".$anexo_link,9);							 
							   break;
							  case ".gif":
							  imagegif($imagem_fin, $diretorio . DIRECTORY_SEPARATOR . "tmp".$anexo_link);
							   break;
						}
						
						
						//LIBERA A MEM�RIA			
						imagedestroy($imagem_orig);
						imagedestroy($imagem_fin);	
						
						//$fp = fopen($diretorio . DIRECTORY_SEPARATOR . "tmp".$anexo_link, 'r');	
						//$imagem_hex = fread($fp, filesize($filePath));		
						
						
						
						
						switch (strtolower($anexo_ext)){
							  case ".jpg":
							   $image = imagecreatefromjpeg( $diretorio . DIRECTORY_SEPARATOR . "tmp".$anexo_link);
							   break;
							  case ".png":
							   $image = imagecreatefrompng( $diretorio . DIRECTORY_SEPARATOR . "tmp".$anexo_link);
							   break;
							  case ".gif":
							   $image = imagecreatefromgif( $diretorio . DIRECTORY_SEPARATOR . "tmp".$anexo_link);
							   break;
						}
						
						
						
						$thumb_width = $thumb_largura;
						$thumb_height = $thumb_altura;
						
						$width = imagesx($image);
						$height = imagesy($image);
						
						$original_aspect = $width / $height;
						$thumb_aspect = $thumb_width / $thumb_height;
						
						if ( $original_aspect >= $thumb_aspect ){
						   // If image is wider than thumbnail (in aspect ratio sense)
						   $new_height = $thumb_height;
						   $new_width = $width / ($height / $thumb_height);
						}else{
						   // If the thumbnail is wider than the image
						   $new_width = $thumb_width;
						   $new_height = $height / ($width / $thumb_width);
						}
						
						$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
						
						// Resize and crop
						imagecopyresampled($thumb,
										   $image,
										   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
										   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
										   0, 0,
										   $new_width, $new_height,
										   $width, $height);
					
						
						
						switch (strtolower($anexo_ext)){
							  case ".jpg":
							   imagejpeg($thumb,  $diretorio . DIRECTORY_SEPARATOR . "thumb".$anexo_link, 80);
							   break;
							  case ".png":
							   imagepng($thumb,  $diretorio . DIRECTORY_SEPARATOR . "thumb".$anexo_link, 8);
							   break;
							  case ".gif":
							   imagegif($thumb,  $diretorio . DIRECTORY_SEPARATOR . "thumb".$anexo_link);
							   break;
						}
						
						$caminho_arquivo = "download/".$ano."/".$mes."/";
						$arquivo = $anexo_link;
					//	@unlink("../download/".$anexo_link);	//foto original
						@unlink($diretorio . DIRECTORY_SEPARATOR . "tmp".$anexo_link); // apaga foto redimensionada temporaria
				}
		  }		  
	  }else{			
		  $upload_errors = array( 
			  UPLOAD_ERR_OK        => "No errors.", 
			  UPLOAD_ERR_INI_SIZE    => "Larger than upload_max_filesize.", 
			  UPLOAD_ERR_FORM_SIZE    => "Larger than form MAX_FILE_SIZE.", 
			  UPLOAD_ERR_PARTIAL    => "Partial upload.", 
			  UPLOAD_ERR_NO_FILE        => "Arquivo n�o Selecionado.", 
			  UPLOAD_ERR_NO_TMP_DIR    => "No temporary directory.", 
			  UPLOAD_ERR_CANT_WRITE    => "Can't write to disk.", 
			  UPLOAD_ERR_EXTENSION     => "File upload stopped by extension.", 
			  UPLOAD_ERR_EMPTY        => "File is empty." // add this to avoid an offset 
			); 			
		  $mensagem = "- Foto n�o importada. Motivo: ".$upload_errors[$_FILES["foto"]['error']].'\n';	
	  } 
	  if ( $mensagem){
		   echo '<script>		 
			   alert("'.$mensagem.'");
				parent.limpa_form(parent.document.form_inspiracao'.$id_desafio.');
				parent.aba_enviar_inspiracao('.$id_desafio.');				
			   </script>';  
		  exit();
	  }
	//////////////////////////////////////////////////////////////////////////////////////////  
   }
   
	if($fase_atual == '2'){
		$fase_titulo = "Proposta";
	}else{
		$fase_titulo = "Inspira��o";
	}
      $sql = "INSERT INTO contribuicoes (nome_contribuicao, media_flag, youtube_link, id_topico, id_participante, id_fase, id_desafio, data_inclusao, descricao, aprovado, caminho_arquivo, arquivo) VALUES (".noempty($nome_contribuicao).", ".noempty($media_flag).",  ".noempty($youtube_link).",  ".noempty($id_topico).", ".noempty($_SESSION["id_participante_session"]).", ".noempty($fase_atual).", ".noempty($id_desafio).", '".date("Y-m-d H:i:s")."','".safe_text($descricao_contribuicao)."','P',".noempty($caminho_arquivo).",".noempty($arquivo).");  ";
   if (insert_record($sql)){
	      echo '<script>';	
	      if ($media_flag == 'V'){
			  echo 'parent.remove_youtube('.$id_desafio.');';
		  }
	   
		 echo '	 		  
		  
		 alert("'.$fase_titulo.' cadastrada com sucesso! Aguarde a aprova��o no seu e-mail cadastrado.");		
		 parent.limpa_form(parent.document.form_inspiracao'.$id_desafio.');	
		 parent.aba_enviar_inspiracao('.$id_desafio.');	
		 </script>';  
		 $id_contribuicao = mysql_insert_id();
  }   

	
			////////////////////////////////////////////////////////////////////
			//////////////// envia email  para o cliente/////////////////////////////////
			//////////////////////////////////////////////////////////////////
			$Subject = "Confirma��o de Envio de ".$fase_titulo." | ".InfoSystem::nome_sistema;			
			
			$Html = email_header();		
			$Html .= 'Ol� '. $_SESSION["nome_participante_session"].', <br><br>';
			$Html .= 'Recebemos sua contribui��o na plataforma Campinas <a href="'.InfoSystem::url_site.'">'.InfoSystem::nome_sistema.'</a>. Muito obrigado pelo envio e participa��o!';
			$Html .= "<br><br> O conte�do enviado ser� analisado e ap�s aprovado ser� publicado.";
			$Html .= "<br><br> Agradecemos pela sua contribui��o, ";
			
						
			$Html .= '<br><br>Atenciosamente,<br>Prefeitura de Campinas';
			
			$Html .= '<br>';
			$Html .= '<a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br><br>OBS: Este e-mail foi gerado automaticamente.'.email_footer();
			
			$Html .= '</html></body>';					  
			
			$participante = get_participante($_SESSION["id_participante_session"]) ;
					  
			$EmailRecipient = $participante["email"];			  
			
			SendMail(InfoSystem::email_sender,InfoSystem::titulo,$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
	
	
	
			////////////////////////////////////////////////////////////////////
			//////////////// envia email  para o Administrador/////////////////////////////////
			//////////////////////////////////////////////////////////////////
			$Subject = "Recebimento de ".$fase_titulo." - ".InfoSystem::nome_sistema;			
			
			
			$tipo_media = ($media_flag == 'V')?"V�deo":"Foto";
			 
			
					if ($media_flag == 'F'){
						$media = '<a href="'.InfoSystem::url_site.$caminho_arquivo.$arquivo.'"><img src="'.InfoSystem::url_site.$caminho_arquivo."thumb".$arquivo.'"  style="width:280px;height:180px"></a>';
					}else{
						$media = youtube_embed($youtube_link,'440px','260px');
						$media .= '<br><a href="http://www.youtube.com/v/'.$youtube_link.'" target="blank">link do youtube</a>';
					}
					
			$key = "2565778324676";
			$hash = base64_url_encode(crypt_md5( $id_contribuicao."|".$_SESSION["id_participante_session"],$key));
			
			$Html = email_header();		
			$Html .=  "O usu�rio ".$_SESSION["nome_participante_session"].', ';
			$Html .= "enviou uma ".$fase_titulo." para ".InfoSystem::nome_sistema."  da Prefeitura Municipal de Campinas.<br> ";
			$Html .= "
			<table width=\"100%\" style=\"font-family:Verdana, Arial, Helvetica, sans-serif;\" >				
				<tr>
					<td><strong><em>De:</em></strong> <a href=\"mailto:" . $participante["email"] . "\">" . $participante["email"] . "</a> - IP ( " . $_SERVER['REMOTE_ADDR']  . " )
				</tr>
				<tr>
					<td><strong><em>Data:</em></strong> " . date("d/m/Y H:i"). "</td>
				</tr>			
				<tr>
					<td><strong><em>Para: </em></strong>  <a href=\"mailto:" . InfoSystem::email_sender . "\">" . InfoSystem::email_sender  . "</a></td>
				</tr>		
				<tr>
					<td><strong><em>Assunto: </em></strong> " . $Subject  . " </td>
				</tr>	
				<tr>
					<td><hr /></td>
				</tr>		
				<tr>
					<td>	<b>Titulo da ".$fase_titulo."</b> " . $nome_contribuicao . "</td>
				</tr>	
				<tr>
					<td>	<b>Conte�do da Mensagem:</b> " . safe_text($descricao_contribuicao). "</td>
				</tr>			
				<tr>
					<td>	<b>M�dia Escolhida</b> " . $tipo_media . "</td>
				</tr>
				<tr>
					<td> " . $media . "</td>
				</tr>
				<tr>
					<td><hr></td>
				</tr>	
				<tr>
					<td><a href='".InfoSystem::url_site."aprovar.php?hash=".$hash."&aprov=1'>Aprovar ".$fase_titulo."</a></td>
				</tr>	
				<tr>
					<td><a href='".InfoSystem::url_site."aprovar.php?hash=".$hash."&aprov=0'>Reprovar ".$fase_titulo."</a></td>
				</tr>	
			</table>
		</body>
	</html>";
		
			 
		
						
			$Html .= '<br><br>Este e-mail foi gerado automaticamente. Este comunicado cont�m informa��es que podem ser confidenciais. Se voc� n�o for o destinat�rio correto deste e-mail, fica notificado que qualquer difus�o, distribui��o ou c�pia desta mensagem ou de seu conte�do � estritamente proibida. Se receber esta mensagem com erro, exclua imediatamente.<br>';
			
			$Html .= '<br>';
			$Html .= '<a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br>'.email_footer();
			
			$Html .= '</html></body>';			
			
			$EmailRecipient = InfoSystem::email_sender;			  
			
			SendMail($participante["email"],InfoSystem::titulo,$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);

	//echo $Html;
}



////////////////////////////////////////////////////////////////////////////////
/////////////////////// add_comentario /////////////////
////////////////////////////////////////////////////////////////////////////////

if ($_POST["add_comentario"]){
	
   if ( !$_SESSION["id_participante_session"] )   {
		 echo '<script>
		 
		 alert("Para realizar essa contribui��o � preciso primeiro estar logado no sistema");
		  setTimeout(function() { 
				  parent.$( "#login-side" ).animate({
						top: "130px"					
				  }, 500 );
		}, 1000);	
		  
		 
		 
		 </script>';	
         exit();
   }   
      $sql = "INSERT INTO comentarios (texto_comentario, id_contribuicao, id_participante, data_inclusao) VALUES (".noempty(safe_text($comentario_text)).", ".noempty($id_contribuicao).", ".noempty($_SESSION["id_participante_session"]).",'".date("Y-m-d H:i:s")."');";
   if (insert_record($sql)){
		 echo '<script>		 
				 parent.showSuccessToast("Coment�rio cadastrado com sucesso. Agradecemos por sua participa��o");
				 parent.document.getElementById("contador_contribuicao'.$id_contribuicao.'").innerHTML = parseInt(parent.document.getElementById("contador_contribuicao'.$id_contribuicao.'").innerHTML)+1;
				 parent.atualiza_conteudo("php/ajax_open_data.php","get_coments=1&id_contribuicao='.$id_contribuicao.'","POST","handleHttpComents");			 
		 </script>';  
		 	$id_comentario = mysql_insert_id();		 
			$key = "2565778324676";
			$hash = base64_url_encode(crypt_md5( $id_comentario."|".$_SESSION["id_participante_session"],$key));
			$participante = get_participante($_SESSION["id_participante_session"]) ;
			$Subject = "Novo Coment�rio - ".InfoSystem::nome_sistema;		
			$Html = email_header();		
			$Html .=  "O usu�rio ".$_SESSION["nome_participante_session"].', ';
			$Html .= "enviou um coment�rio para ".InfoSystem::nome_sistema."  da Prefeitura Municipal de Campinas.<br> ";
			$Html .= "
			<table width=\"100%\" style=\"font-family:Verdana, Arial, Helvetica, sans-serif;\" >				
				<tr>
					<td><strong><em>De:</em></strong> <a href=\"mailto:" . $participante["email"] . "\">" . $participante["email"] . "</a> - IP ( " . $_SERVER['REMOTE_ADDR']  . " )
				</tr>
				<tr>
					<td><strong><em>Data:</em></strong> " . date("d/m/Y H:i"). "</td>
				</tr>			
				<tr>
					<td><strong><em>Para: </em></strong>  <a href=\"mailto:" . InfoSystem::email_sender . "\">" . InfoSystem::email_sender  . "</a></td>
				</tr>		
				<tr>
					<td><strong><em>Assunto: </em></strong> " . $Subject  . " </td>
				</tr>	
				<tr>
					<td><hr /></td>
				</tr>	
				<tr>
					<td>	<b>Conte�do da Mensagem:</b> " . safe_text($comentario_text). "</td>
				</tr>	
				<tr>
					<td><hr></td>
				</tr>	
				<tr>
					<td><a href='".InfoSystem::url_site."comentario.php?hash=".$hash."&aprov=0'>Reprovar Coment�rio</a></td>
				</tr>	
			</table>
		</body>
	</html>";
						
			$Html .= '<br><br>Este e-mail foi gerado automaticamente. Este comunicado cont�m informa��es que podem ser confidenciais. Se voc� n�o for o destinat�rio correto deste e-mail, fica notificado que qualquer difus�o, distribui��o ou c�pia desta mensagem ou de seu conte�do � estritamente proibida. Se receber esta mensagem com erro, exclua imediatamente.<br>';
			
			$Html .= '<br>';
			$Html .= '<a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br>'.email_footer();
			
			$Html .= '</html></body>';			
			
			$EmailRecipient = InfoSystem::email_sender;			  
			
			SendMail($participante["email"],InfoSystem::titulo,$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);

		 
		 
   }   
}





////////////////////////////////////////////////////////////////////////////////
/////////////////////// add_resposta /////////////////
////////////////////////////////////////////////////////////////////////////////

if ($_POST["add_resposta"]){
	
   if ( !$_SESSION["id_participante_session"] )   {
		 echo '<script>
		 
		 alert("Para realizar essa contribui��o � preciso primeiro estar logado no sistema");
		  setTimeout(function() { 
				  parent.$( "#login-side" ).animate({
						top: "130px"					
				  }, 500 );
		}, 1000);	
		 
		 </script>';	
         exit();
   }   
      $sql = "INSERT INTO comentarios (texto_comentario, sub_comentario, id_contribuicao, id_participante, data_inclusao) VALUES (".noempty(safe_text($comentario_text)).", ".noempty($id_comentario).", ".noempty($id_contribuicao).", ".noempty($_SESSION["id_participante_session"]).",'".date("Y-m-d H:i:s")."');";
   if (insert_record($sql)){
		 echo '<script>		 		
				 parent.showSuccessToast("Coment�rio cadastrado com sucesso. Agradecemos por sua participa��o");
				 parent.document.getElementById("contador_contribuicao'.$id_contribuicao.'").innerHTML = parseInt(parent.document.getElementById("contador_contribuicao'.$id_contribuicao.'").innerHTML)+1;
				 parent.atualiza_conteudo("php/ajax_open_data.php","get_coments=1&id_contribuicao='.$id_contribuicao.'","POST","handleHttpComents");	
	  	 </script>';  
   	   	    $id_comentario = mysql_insert_id();		 
			$key = "2565778324676";
			$hash = base64_url_encode(crypt_md5( $id_comentario."|".$_SESSION["id_participante_session"],$key));
			$participante = get_participante($_SESSION["id_participante_session"]) ;
			$Subject = "Novo Coment�rio - ".InfoSystem::nome_sistema;		
			$Html = email_header();		
			$Html .=  "O usu�rio ".$_SESSION["nome_participante_session"].', ';
			$Html .= "enviou um coment�rio para ".InfoSystem::nome_sistema."  da Prefeitura Municipal de Campinas.<br> ";
			$Html .= "
			<table width=\"100%\" style=\"font-family:Verdana, Arial, Helvetica, sans-serif;\" >				
				<tr>
					<td><strong><em>De:</em></strong> <a href=\"mailto:" . $participante["email"] . "\">" . $participante["email"] . "</a> - IP ( " . $_SERVER['REMOTE_ADDR']  . " )
				</tr>
				<tr>
					<td><strong><em>Data:</em></strong> " . date("d/m/Y H:i"). "</td>
				</tr>			
				<tr>
					<td><strong><em>Para: </em></strong>  <a href=\"mailto:" . InfoSystem::email_sender . "\">" . InfoSystem::email_sender  . "</a></td>
				</tr>		
				<tr>
					<td><strong><em>Assunto: </em></strong> " . $Subject  . " </td>
				</tr>	
				<tr>
					<td><hr /></td>
				</tr>	
				<tr>
					<td>	<b>Conte�do da Mensagem:</b> " . safe_text($comentario_text). "</td>
				</tr>	
				<tr>
					<td><hr></td>
				</tr>	
				<tr>
					<td><a href='".InfoSystem::url_site."comentario.php?hash=".$hash."&aprov=0'>Reprovar Coment�rio</a></td>
				</tr>	
			</table>
		</body>
	</html>";
						
			$Html .= '<br><br>Este e-mail foi gerado automaticamente. Este comunicado cont�m informa��es que podem ser confidenciais. Se voc� n�o for o destinat�rio correto deste e-mail, fica notificado que qualquer difus�o, distribui��o ou c�pia desta mensagem ou de seu conte�do � estritamente proibida. Se receber esta mensagem com erro, exclua imediatamente.<br>';
			
			$Html .= '<br>';
			$Html .= '<a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br>'.email_footer();
			
			$Html .= '</html></body>';			
			
			$EmailRecipient = InfoSystem::email_sender;			  
			
			SendMail($participante["email"],InfoSystem::titulo,$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
   }   
}

////////////////////////////////////////////////////////////////////////////////
/////////////////////// alterar senha /////////////////
////////////////////////////////////////////////////////////////////////////////

if ($_POST["alterar_senha_check_post"]){
	
   if ( !$senha || !$_SESSION["id_participante_session"] )   {
		 echo '<script>alert("Ocorreu algum erro na transa��o. Tente novamente");</script>';	
         exit();
   }   
	
	
      $sql = "UPDATE participantes SET senha = '".md5($senha)."' where id_participante = '".$_SESSION["id_participante_session"]."'   ";
      update_record($sql);
      echo '<script>
      alert("Senha Alterada com Sucesso!"); 
	 parent.limpa_form(parent.document.alterar_senha_form_window);
		parent.$( "#alterar_senha_form" ).animate({
			  right: "-490px"					
		}, 800 );	
      </script>'."\n";
}
	
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////


	
	



?>


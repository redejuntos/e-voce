<?php
 
//Prefeitura Municipal de Campinas
//App ID:	
//App Secret:	
//https://campinasevoce.campinas.sp.gov.br


// Verifica o tipo de requisi??o e se tem a vari?vel 'code' na url
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['code'])){
  // Informe o id da app
  $appId = '';
  // Senha da app
  $appSecret = '';
  // Url informada no campo "Site URL"
  $redirectUri = urlencode(InfoSystem::url_site);
  // Obt?m o c?digo da query string
  $code = $_GET['code'];
 
  // Monta a url para obter o token de acesso
  $token_url = "https://graph.facebook.com/oauth/access_token?"
  . "client_id=" . $appId . "&redirect_uri=" . $redirectUri
  . "&client_secret=" . $appSecret . "&code=" . $code;
 
  // Requisita token de acesso
  $response = @file_get_contents($token_url);
 
  if($response){
    $params = null;
    parse_str($response, $params);
 
    // Se veio o token de acesso
    if(isset($params['access_token']) && $params['access_token']){
      $graph_url = "https://graph.facebook.com/me?access_token="
      . $params['access_token'];
 
      // Obt?m dados atrav?s do token de acesso
      $user = json_decode(file_get_contents($graph_url));
 
      // Se obteve os dados necess?rios
      if(isset($user->email) && $user->email){
 
        /*
        * Autentica??o feita com sucesso. 
        * Loga usu?rio na sess?o. Substitua as linhas abaixo pelo seu c?digo de registro de usu?rios logados
        */
		
		$sql_facebook = "SELECT id_participante, nome_participante,facebook_id, avatar	FROM participantes WHERE email = '". $user->email."'";
		
		if (numrows($sql_facebook)>0){ // j? cadastrado no sistema		
			$rs_fb = get_record($sql_facebook);			
			if ($rs_fb["facebook_id"]){  // j? logou com facebook			
				  if (trim($rs_fb["avatar"])){
					   $image_avatar = $rs_fb["avatar"];
				  }else{
						if($rs_fb["facebook_id"]){
							$image_avatar = 'https://graph.facebook.com/'.$rs_fb["facebook_id"].'/picture?width=200&height=200';						
						}else{
							$image_avatar = './images/avatar.jpg';				 		 
						}
				  }	
			}else{	// primeiro login com facebook					
				if ($user->birthday){
					  $nYear = substr($user->birthday,6,4); 
					  $nDay = substr($user->birthday,3,2); 
					  $nMonth = substr($user->birthday,0,2);
					  $birthday_us = $nYear."-".$nMonth."-".$nDay;				
					  $add_sql = " data_nascimento ='".$birthday_us."',  ";
				}
			
				$sql_update = "UPDATE participantes SET facebook_id='".$user->id."', facebook_gender='".$user->gender."',facebook_page='".$user->link."',  facebook_hometown='".$user->hometown->name."', ".$add_sql."    data_alteracao='".date("Y-m-d H:i:s")."'  WHERE  id_participante='".$rs_fb["id_participante"]."' LIMIT 1;";
				update_record($sql_update);	
				$add_sql = "";
				echo '
				<script>
						setTimeout(function() { 
								parent.$( "#meu_cadastro_form" ).animate({
									  right: "80px"					
								}, 500 );
					  }, 2000);	
				</script>
				';
			}	
			$_SESSION["id_participante_session"] = $rs_fb["id_participante"];
		    $_SESSION["nome_participante_session"] = $rs_fb["nome_participante"];	
				  if (trim($rs_fb["avatar"])){
					   $image_avatar = $rs_fb["avatar"];
				  }else{
						if($user->id){
							$image_avatar = 'https://graph.facebook.com/'.$user->id.'/picture?width=200&height=200';						
						}else{
							$image_avatar = './images/avatar.jpg';				 		 
						}
				  }	
			$_SESSION["imagem_avatar"] = $image_avatar;
			
			
		}else{
			$nYear = substr($user->birthday,6,4); 
			$nDay = substr($user->birthday,3,2); 
			$nMonth = substr($user->birthday,0,2);
			$birthday_us = $nYear."-".$nMonth."-".$nDay;		
			$sql_insert = "INSERT INTO participantes (nome_participante, email, facebook_id,  facebook_gender,  facebook_page,  facebook_hometown,  data_nascimento, data_inclusao) VALUES ('".utf8_decode($user->name)."', '".$user->email."', '".$user->id."', '".$user->gender."', '".$user->link."', '".$user->hometown->name."', '".$birthday_us."', '".date("Y-m-d H:i:s")."');";
			if(insert_record($sql_insert)){				
				$_SESSION["id_participante_session"] = mysql_insert_id();
				$_SESSION["nome_participante_session"] = $user->name;
				$_SESSION["imagem_avatar"] = 'https://graph.facebook.com/'.$user->id.'/picture?width=200&height=200';	
				echo '
				<script>
						window.onload = function(){
							  setTimeout(function() { 
									  parent.$( "#meu_cadastro_form" ).animate({
											right: "80px"					
									  }, 500 );
							}, 1000);	
						}
				</script>
				';	
				////////////////////////////////////////////////////////////////////
				//////////////// envia email /////////////////////////////////
				//////////////////////////////////////////////////////////////////
				$Subject = "Cadastro | ".InfoSystem::nome_sistema;		
				$Html = '<html><body bgcolor="#ffffff">'.email_header();	
				$Html .= 'Ol? '.$user->name.', <br><br>';
				$Html .= "Bem-vindo ao ".InfoSystem::nome_sistema.", a plataforma de Inova??o Aberta da Prefeitura Municipal de Campinas.".'<br><br>';				
				$Html .= 'Seu Login de Usu?rio ?: '.$user->email.'<br>';
				$Html .= 'Sua Senha de acesso pode ser criada ou alterada no link "Alterar Senha" na janela "Meu Cadastro"<br>';
				$Html .= InfoSystem::nome_sistema.': <a href="'.InfoSystem::url_site.'">'.InfoSystem::url_site.'</a><br><br>';			
				$Html .= 'Agora voc? j? pode contribuir com inspira??es, propostas e votar nas melhores solu??es para a o servi?o p?blico de sa?de em Campinas. <br>';
				$Html .= '<br>Caso esque?a sua senha, voc? poder? gerar uma nova senha pelo bot?o "Lembrar Senha" na nossa p?gina inicial de login.<br>';
				$Html .= '<br>Muito obrigado por se cadastrar e seja muito bem-vindo!<br>';
				$Html .= '<br>Atenciosamente,<br>Prefeitura de Campinas<br><a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br><br><br>'.email_footer();
				$Html .= '</html></body>';					  
				$EmailRecipient = $user->email;	
				SendMail(InfoSystem::email_sender,InfoSystem::titulo,$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
				///////////////////////////////////////////////////////////////////////////////////////		  
			}
		}
		
		
	
		
		
		
	 //  echo '<img src="https://graph.facebook.com/'.$user->id.'/picture?width=200&height=200">';
	 //  print_r($user);
 
        /*
        * Aqui voc? pode adicionar um c?digo que cadastra o email do usu?rio no banco de dados
        * A cada requisi??o feita em p?ginas de ?rea restrita voc? verifica se o email
        * que est? na sess?o ? um email cadastrado no banco
        */
      }
 
    }else{
      $_SESSION['fb_login_error'] = 'Falha ao logar no Facebook';
    }
 
  }else{
    $_SESSION['fb_login_error'] = 'Falha ao logar no Facebook';
  }
 
}else if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['error'])){
  $_SESSION['fb_login_error'] = 'Permiss?o n?o concedida';
}
?>
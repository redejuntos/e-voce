<? 
require_once ("./php/connections/connections.php");	
require_once ("./php/funcoes.php");

foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):valida_SQL_injection($b);	
		  
		  
   if ( !$s )   {
		/* echo '<script>alert("Ocorreu algum erro na transação. Tente novamente");</script>';	*/
         exit();
   }   
   
		$sql = "
select id_participante,nome_participante,email,senha,login from participantes where md5(email) = '".$s."' LIMIT 1
";		


		if ($rs = get_record($sql)){			
					
			
			$nova_senha=substr(md5(uniqid(rand(), true)),1,8);
			$sql = "update participantes set senha= '".md5($nova_senha)."' where  md5(email) = '".$s."' and id_participante = '".$rs["id_participante"]."'";
			update_record($sql);			
			
			$Subject =  " Esqueci minha senha | ".InfoSystem::nome_sistema;	  
			
			$Html = '<html><body bgcolor="#ffffff">'.email_header();
			$Html .=  'Prezado(a) '.$rs["nome_participante"].',<br><br>';
			$Html .= "Bem-vindo à plataforma de Inovação Aberta da Prefeitura Municipal de Campinas, a <a href='".InfoSystem::url_site."'>e-você</a>.".'<br>';				
			$Html .= '<br>Seu Login de Usuário é: '.$rs["email"].'<br>';
			$Html .= 'Sua nova senha é: '.$nova_senha.'<br>';	
			$Html .= 'e-você: '.InfoSystem::url_site.'<br>';	
			
			//$Html .= '<br>Caso necessite, pode trocar sua senha no “Meu Cadastro”.<br>';
			
			$Html .= '<br>Caso necessite, pode trocar sua senha no “Meu Cadastro”. Se tiver mais alguma dificuldade técnica, entre em contato conosco pelo campinasevoce@campinas.sp.gov.br, estaremos muito contentes de ajudá-lo.<br>';
			
			
			$Html .= '<br>Contribua com inspirações, propostas e vote nas melhores soluções para a o serviço público de saúde em Campinas.<br>';
			
			$Html .= '<br>Atenciosamente,<br>Prefeitura de Campinas';
			
			$Html .= '<br><a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br>';	
			
			$Html .= '<br>OBS: Este e-mail foi gerado automaticamente.<br><br><br>	
				'.email_footer().'		
			';			
			
			$Html .= '</html></body>';	
			
			$EmailRecipient = $rs["email"];
			$NameRecipient = "";
			SendMail(InfoSystem::email_sender ,InfoSystem::titulo,$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
			$aviso = $rs["nome_participante"]. ", obrigado por confirmar, sua nova senha foi gerada e enviada para seu email: ".$rs["email"];	
			echo "<script>alert('".$aviso."');</script>";	
			echo '<script>
			location.href="./index.php"	 
			</script>';
			exit();
			
		}
?>


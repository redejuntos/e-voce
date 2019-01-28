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


if (DBConnect::database=="postgresql") 
	require_once ("./fundaDB_pg.class.php");	

////////////////////////////
//VERIFICAÇÃO DE SEGURANÇA//
////////////////////////////
verifica_seguranca();



include_once("./class_relationship_restrition.php");//define os relacionamentos das tabelas
$class_relationship_restrition = new relationship_restrition;







///////////////////
//TESTE DE SESSÃO//
///////////////////
//echo "---------session---------<br>";
//foreach ($_SESSION as $a => $b){
//echo (count($b) > 1)? "":$a."=".$b."<br>";
//is_array($b)? "":eval ("$".$a."=\"".$b."\";");
//}


//echo "---------POST---------<br>";http://pindell.ima.sp.gov.br/~celulaatendimento/appo/#
/*


foreach ($_POST as $a => $b){
is_array($b)? "":$$a = valida_SQL_injection($b);
echo $a."=".$$a."<br>";
}

echo $_POST["imagem_assinatura"][1];


foreach ($_FILES as $a => $b){
is_array($b)? "":$$a = valida_SQL_injection($b);
echo $a."=".$$a."<br>";
}


echo $data_fase;






	echo "1-".$_FILES["assinatura_principal"]["name"]."<BR>";	
	echo "2-".$_FILES["assinatura_principal"]["type"]."<BR>";	
	echo "3-".$_FILES["assinatura_principal"]['size']."<BR>";
	echo "4-".$_FILES["assinatura_principal"]['tmp_name']."<BR>";	
	echo "5-".$_FILES["assinatura_principal"]['error']."<BR>";	
	echo "6-".print_r($_FILES["assinatura_principal"])."<BR>";

echo "<BR>-------------------<br>";

	echo "1-".$_FILES["assinatura"]["name"][0]."<BR>";	
	echo "2-".$_FILES["assinatura"]["type"][0]."<BR>";	
	echo "3-".$_FILES["assinatura"]['size'][0]."<BR>";
	echo "4-".$_FILES["assinatura"]['tmp_name'][0]."<BR>";	
	echo "5-".$_FILES["assinatura"]['error'][0]."<BR>";	
	echo "6-".print_r($_FILES["assinatura"][0])."<BR>";




//echo "---------GET---------<br>";
foreach ($_GET as $a => $b){
is_array($b)? "":$$a = valida_SQL_injection($b);
//echo $a."=".$$a."<br>";
}*/

foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	

////////////////////////////////////////////////////////////////////////////////
/////////////////////// incluir_nova_solicitacao /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["incluir_nova_solicitacao"]){	
	
   if ( !$id_empresa  )   {
         echo 'Ocorreu algum erro na transação. Tente novamente';
         exit();
   }   
 	$sql = "SELECT id_empresa
			FROM solicitacoes
			WHERE id_empresa = '".$id_empresa."' AND id_situacao <> '5' 
			AND data_cancelamento IS NULL LIMIT 1;";			
		//echo $sql;	
	if (get_record($sql)){
		echo '';
         exit();
	}else{		
		  $sql_insert = "INSERT INTO solicitacoes (id_situacao, id_empresa, data_inclusao,id_checklist)
						  SELECT '1' as id_situacao, '".$id_empresa."' as id_empresa, NOW() as data_inclusao,						
						 ( SELECT id_checklist
						  FROM checklists
						  WHERE data_cancelamento IS NULL
						  ORDER BY id_checklist DESC
						  LIMIT 1 ) as id_checklist  						  
						   FROM solicitacoes LIMIT 1;
		  ";
		  insert_record($sql_insert);	
		  echo 'Nova Solicitação Incluída com Sucesso!';
         exit();
	}
	  
}






////////////////////////////////////////////////////////////////////////////////
/////////////////////// alterar_proposta /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_GET["alterar_proposta"]){
   
   if (!$cod )   {
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   $resposta_opcao= utf8_decode($value);
   $comentario = "";
   
		  /// insert com inner join - somente empresa logada faz inclusao na sua propria solicitacao
		  
		  
	$sql_update = "UPDATE contribuicoes SET nome_contribuicao='".safe_text($nome_contribuicao)."', descricao='".safe_text($descricao)."' WHERE  id_contribuicao='".$cod."';";		
	update_record($sql_update);	  	

		 echo '<script>		 
				 parent.parent.showSuccessToast("Proposta Alterada com sucesso.");
				 parent.close_aerowindow("'.$table.$cod.'","'.$table.'")	
				 </script>';
	
}







////////////////////////////////////////////////////////////////////////////////
/////////////////////// update_complemento /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["update_complemento"]){
   
   if (!$id_empresa|| !$id_solicitacao ||  !$id_pergunta || !$id_opcao   )   {
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   $resposta_opcao= utf8_decode($value);
   $comentario = "";
   
		  /// insert com inner join - somente empresa logada faz inclusao na sua propria solicitacao
		  
		  
	$sql_update = "UPDATE respostas_questionarios  as a
			INNER JOIN solicitacoes AS b ON (b.id_empresa = '".$id_empresa."' AND b.id_solicitacao = '$id_solicitacao')
			SET a.resposta_opcao='$resposta_opcao', a.data_inclusao = '".date("Y-m-d H:i:s")."'
			WHERE a.id_solicitacao='$id_solicitacao' AND a.id_opcao='$id_opcao'";		
	update_record($sql_update);	  	

	
}




////////////////////////////////////////////////////////////////////////////////
/////////////////////// update_radiobox /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["update_radiobox"]){
	
   if (!$id_empresa|| !$id_solicitacao ||  !$id_pergunta || !$id_opcao   )   {
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   
   $resposta_opcao= "";
   $comentario = "";
					
		//////////////////////////////////////////////////////////////////			
		////////// apaga registros anteriores marcados para radiobox					
		//////////////////////////////////////////////////////////////////	
		 
		$sql_delete = "DELETE a.*
					FROM respostas_questionarios AS a
							INNER JOIN solicitacoes AS b ON (b.id_empresa = '".$id_empresa."' AND b.id_solicitacao = '$id_solicitacao')
					WHERE a.id_solicitacao = '$id_solicitacao'  
					AND a.id_opcao IN (
										  SELECT c.id_opcao as id_opcao
										  FROM opcoes AS c
										  WHERE c.id_pergunta = (
																  SELECT d.id_pergunta
																  FROM opcoes AS d
																  WHERE d.id_opcao='".$id_opcao ."'		
																)
									  ); ";
		 
		 delete_record($sql_delete);	
	///////////////////////////////////////////////////////
	  
	  
	  
	/// insert com inner join - somente empresa logada faz inclusao na sua propria solicitacao
	$sql_insert = "INSERT INTO respostas_questionarios (id_solicitacao, id_opcao, resposta_opcao,data_inclusao)
					SELECT '$id_solicitacao' AS id_solicitacao, '$id_opcao' AS id_opcao, '$resposta_opcao' AS resposta_opcao, NOW() AS data_inclusao
					FROM solicitacoes
					WHERE ( id_empresa = '".$id_empresa."' AND id_solicitacao = '$id_solicitacao')
					LIMIT 1
	";
	insert_record($sql_insert);	
}



////////////////////////////////////////////////////////////////////////////////
/////////////////////// update_checkbox /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["update_checkbox"]){
	
   if (!$id_empresa|| !$id_solicitacao ||  !$id_pergunta || !$id_opcao   )   {
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   
   $resposta_opcao= "";
   $comentario = "";
   
   if ($value=="true"){	   
		  /// insert com inner join - somente empresa logada faz inclusao na sua propria solicitacao
		  $sql_insert = "INSERT INTO respostas_questionarios (id_solicitacao, id_opcao, resposta_opcao,data_inclusao)
						  SELECT '$id_solicitacao' AS id_solicitacao, '$id_opcao' AS id_opcao, '$resposta_opcao' AS resposta_opcao, NOW() AS data_inclusao
						  FROM solicitacoes
						  WHERE ( id_empresa = '".$id_empresa."' AND id_solicitacao = '$id_solicitacao')
						  LIMIT 1
		  ";
		  insert_record($sql_insert);	
   }else{
		$sql_delete = "DELETE a.* FROM respostas_questionarios AS a
							INNER JOIN solicitacoes AS b ON (b.id_empresa = '".$id_empresa."' AND b.id_solicitacao = '$id_solicitacao')
					WHERE a.id_solicitacao = '$id_solicitacao'  AND a.id_opcao = '".$id_opcao."' ";
		 
		  delete_record($sql_delete);	
	   
   }			
}




////////////////////////////////////////////////////////////////////////////////
/////////////////////// update_input /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["update_input"]){
	
   if (!$id_empresa|| !$id_solicitacao ||  !$id_pergunta || !$id_opcao   )   {
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   $resposta_opcao= utf8_decode($value);
   $comentario = "";
   
	  	  $sql_delete = "DELETE a.* FROM respostas_questionarios AS a
							INNER JOIN solicitacoes AS b ON (b.id_empresa = '".$id_empresa."' AND b.id_solicitacao = '$id_solicitacao')
					WHERE a.id_solicitacao = '$id_solicitacao'  AND a.id_opcao = '".$id_opcao."' ";
		 
		  delete_record($sql_delete);	
   
   
   
		  /// insert com inner join - somente empresa logada faz inclusao na sua propria solicitacao
		  $sql_insert = "INSERT INTO respostas_questionarios (id_solicitacao, id_opcao, resposta_opcao,data_inclusao)
						  SELECT '$id_solicitacao' AS id_solicitacao, '$id_opcao' AS id_opcao, '$resposta_opcao' AS resposta_opcao, NOW() AS data_inclusao
						  FROM solicitacoes
						  WHERE ( id_empresa = '".$id_empresa."' AND id_solicitacao = '$id_solicitacao')
						  LIMIT 1
		  ";
		  insert_record($sql_insert);	  	
}



////////////////////////////////////////////////////////////////////////////////
/////////////////////// update_textarea /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["update_textarea"]){
	
   if (!$id_empresa|| !$id_solicitacao ||  !$id_pergunta  )   {
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
 
  		  $comentario= utf8_decode($value);
   
	  	  $sql_delete = "DELETE a.* FROM respostas_comentarios AS a
							INNER JOIN solicitacoes AS b ON (b.id_empresa = '".$id_empresa."' AND b.id_solicitacao = '$id_solicitacao')
					WHERE a.id_solicitacao = '$id_solicitacao'  AND a.id_pergunta = '".$id_pergunta."' ";
		 
		  delete_record($sql_delete);	
   
		  /// insert com inner join - somente empresa logada faz inclusao na sua propria solicitacao
		  $sql_insert = "INSERT INTO respostas_comentarios (id_solicitacao, id_pergunta, comentario,data_inclusao)
						  SELECT '$id_solicitacao' AS id_solicitacao, '$id_pergunta' AS id_pergunta, '$comentario' AS comentario, NOW() AS data_inclusao
						  FROM solicitacoes
						  WHERE ( id_empresa = '".$id_empresa."' AND id_solicitacao = '$id_solicitacao')
						  LIMIT 1
		  ";
		  insert_record($sql_insert);	  	
}

////////////////////////////////////////////////////////////////////////////////
/////////////////////// update_resposta_checklist /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["update_resposta_checklist"]){
	
   if (!isset($id_solicitacao)|| !isset($id_checklist) ||  !isset($id_item_checklist) || !isset($resposta)   )   {
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   
   
   // exclui a resposta anterior
	$sql_delete = "
		DELETE FROM respostas_checklist
		WHERE 
			id_solicitacao = ".$id_solicitacao." AND
			id_checklist = ".$id_checklist." AND
			id_item_checklist = ".$id_item_checklist."
	";
	delete_record($sql_delete);	
		
    if ($resposta!=""){
		  // insere a resposta do checklist se for conforme ou pendente
		  $sql_insert = "
			INSERT INTO respostas_checklist 
				(
					id_solicitacao, 
					id_checklist,
					id_item_checklist,
					resposta,
					data_inclusao
				)
			VALUES
				(
					".$id_solicitacao.", 
					".$id_checklist.",
					".$id_item_checklist.",
					".$resposta.",
					NOW()
				)
		  ";
		  insert_record($sql_insert);	
   }
   
}


////////////////////////////////////////////////////////////////////////////////
/////////////////////// change_event_state_e_offline /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["change_event_state_e_offline"]){
	$_SESSION["eventos_off-line"]=$_GET["state"];
	echo '<script>parent.location.href="listar.php?table=t_licitacoes&id_tipo='.$id_tipo.'";</script>';
}

if ($_GET["change_event_state_e_fechado"]){
	$_SESSION["evento_fechado"]=$_GET["state"];
	echo '<script>parent.location.href="listar.php?table=t_licitacoes&id_tipo='.$id_tipo.'";</script>';
}



////////////////////////////////////////////////////////////////////////////////
/////////////////////// alterar senha /////////////////
////////////////////////////////////////////////////////////////////////////////

if ($_GET["alterar_senha"]){
   $sql_senha = "select id_usuario from usuarios where login = '".$_SESSION["login_session"]."' and
   senha = '".md5($senha_atual)."';";
   
   

   if (($valida_nova_senha=get_record($sql_senha))&&($senha)){     //se senha atual é verdadeira
      $sql = "UPDATE usuarios SET senha = '".md5($senha)."' where login = '".$_SESSION["login_session"]."' and id_usuario = '".$_SESSION["id_usuario_session"]."'";
      update_record($sql);
      echo '<script>
      alert("Senha Alterada com Sucesso!");
      parent.document.forms[0].reset();
	  var container = parent.parent.window.document.getElementById("Containeralterar_senha'.$cod.'");		  
	 container.style.display =  "none";		
      </script>'."\n";
   }else{
      echo '<script>
      alert("A Senha Atual que você digitou não é igual a senha cadastrada no sistema anteriormente.");
      parent.document.forms[0].senha_atual.value="";
      parent.document.forms[0].senha_atual.focus();
      </script>'."\n";
   }


   insert_log("alterar_senha",$sql);
}

////////////////////////////////////////////////////////////////////////////////
/////////////////////// filtra tabela /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["filtra_tabela"]){
   if ($_POST["campos_visiveis"] != ""){
      $campo_vetor = split("\|",$_POST["campos_visiveis"]);
   }else{
      $campo_vetor ="";
   }

    unset($_SESSION["activate_filtro"]);
    session_unregister("activate_filtro");
    if ((count($campo_vetor)>0)&&($campo_vetor != "")){
      $_SESSION["activate_filtro"] = array();
      foreach ($campo_vetor as $a){
         array_push($_SESSION["activate_filtro"],$a);
      }
   }else{
      $_SESSION["activate_filtro"] = array();
   }

   echo '<script>parent.top.conteudo.location.reload();</script>';

}



////////////////////////////////////////////////////////////////////////////////
/////////////////////// gerar_relatorio_operacoes /////////////////
////////////////////////////////////////////////////////////////////////////////

if ($_GET["gerar_relatorio_operacoes"]){

   if((!$data_inicial)  or (!$hora_inicial) or (!$data_final) or (!$hora_final) ){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }


   $_SESSION["data_inicial_operacoes"] =  data_us($data_inicial)." ".$hora_inicial.":00";
   $_SESSION["data_final_operacoes"] =  data_us($data_final)." ".$hora_final.":00";

      echo '<script>
         if (document.all)
            window.parent.location.reload();
         else
            window.parent.location.href = window.parent.location.href;
      </script>'."\n";


}

////////////////////////////////////////////////////////////////////////////////
/////////////////////// ativar_usuario /////////////////
////////////////////////////////////////////////////////////////////////////////

if ($_GET["ativar_usuario"]){

   if(!$row){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }
   
	if (verifica_acesso('','ativar_desativar_usuario','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		 exit();
	}
	

      $sql = "UPDATE usuarios SET data_cancelamento= NULL where id_usuario = '".$row."' limit 1";
      insert_record($sql);
      echo '<script>
         alert("Usuario ativado com Sucesso!");
         window.parent.parent.document.forms[0].reset();
         if (document.all)
            window.parent.location.reload();
         else
            window.parent.location.href = window.parent.location.href;
      </script>'."\n"; 

      insert_log("ativar_desativar_usuario",$sql,"id: ".$row);
}

////////////////////////////////////////////////////////////////////////////////
/////////////////////// adicionar_usuario /////////////////
////////////////////////////////////////////////////////////////////////////////

if ($_GET["adicionar_usuario"]){

   if((!$login)  or (!$nome_usuario) or (!$email) or (!$senha) ){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }
   
	if (verifica_acesso('','adicionar_usuario','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}
   
	$mensagem ="";
      $sql = "INSERT into usuarios (id_nivel,login,senha,nome_usuario,email, data_inclusao) VALUES('".$id_nivel."','".$login."','".md5($senha)."','".$nome_usuario."','".$email."','".date("Y-m-d H:i:s")."')";
      insert_record($sql);

      insert_log("adicionar_usuario",$sql,"user: ".$login);
	  
	$mensagem = $mensagem."Usuario `".$login."` foi inserido(a) com sucesso!";	
      echo '<script>	  
			  var myDate = new Date();		  
			  var window_opener = parent.parent.window.document.getElementById("iframe_aerousuarios");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
			  var container = parent.parent.window.document.getElementById("Containerincluir_usuarios");		  
			  container.style.display =  "none";			
			  parent.limpa_form();
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>'; 
	  
	  
}




////////////////////////////////////////////////////////////////////////////////
/////////////////////// alterar_usuario /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["alterar_usuario"]){
	// define dados para acessar o BD
	
   if (!$cod){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
	
	if (verifica_acesso('','alterar_usuario','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}
	

	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao = str_replace($var_ascii, $var_html, $descricao);
  	
	$mensagem ="";
	$sql = "UPDATE usuarios SET nome_usuario='$nome_usuario', email='$email', id_nivel='$id_nivel', data_alteracao='".date("Y-m-d H:i:s")."' WHERE  id_usuario=".$cod." LIMIT 1;";	
		
	//exit($sql);
	update_record($sql);		
	
	insert_log("alterar_usuario",$sql,$nome_usuario);
	
	$mensagem = $mensagem."O usuario `".$nome_usuario."` foi alterado(a) com sucesso!";	
      echo '<script>	  
			  var myDate = new Date();		  
			  var window_opener = parent.parent.window.document.getElementById("iframe_aerousuarios");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
			  var container = parent.parent.window.document.getElementById("Containerusuario'.$cod.'");		  
			  container.style.display =  "none";			 		
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>'; 
	  
	  
}





////////////////////////////////////////////////////////////////////////////////
/////////////////////// adicionar_documento /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["adicionar_documento"]){
	// define dados para acessar o BD
	
   if (!$nome_documento){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   
	if (verifica_acesso('','adicionar_documento','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}

	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao = str_replace($var_ascii, $var_html, $descricao);
  	
	$mensagem ="";
	$sql = "INSERT INTO documentos (nome_documento, descricao, data_inclusao) VALUES ('$nome_documento', '$descricao','".date("Y-m-d H:i:s")."')";		
	//exit($sql);
	insert_record($sql);	
	
	insert_log("adicionar_documento",$sql,$nome_documento);
	
	$mensagem = $mensagem."O Documento `".$nome_documento."` foi inserido(a) com sucesso!";	
      echo '<script>	  
			  var myDate = new Date();		  
			  var window_opener = parent.parent.window.document.getElementById("iframe_aerodocumentos");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
			  var container = parent.parent.window.document.getElementById("Containerincluir_documento");		  
			  container.style.display =  "none";			 		
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>'; 
	  
	  
}


////////////////////////////////////////////////////////////////////////////////
/////////////////////// alterar_desafio /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["alterar_desafio"]){
	// define dados para acessar o BD
	
   if (!$cod){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   
   
   /*
	if (verifica_acesso('','alterar_documento','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}*/
	

	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao = str_replace($var_ascii, $var_html, $descricao);
  	
	$mensagem ="";
	$sql = "UPDATE desafios SET  nome_desafio='$nome_desafio', data_inicio='".data_us($data_inicio)."', data_fim='".data_us($data_fim)."',media_flag='$media_flag', descricao='$descricao', data_alteracao='".date("Y-m-d H:i:s")."'       WHERE  id_desafio=".$cod." LIMIT 1;
";			
	//exit($sql);
	update_record($sql);	
	
	
	$sql = "DELETE FROM desafios_x_fases WHERE id_desafio='".$cod."';";
	delete_record($sql);
	foreach ($_POST["data_fase"] as $a => $b){
		if ($b){
			$sql = "INSERT INTO desafios_x_fases (id_desafio, id_fase, data_inicio) VALUES ('".$cod."', '".$a."', '".data_us($b)."');";
			insert_record($sql);
		}
	}		
	//insert_log("alterar_documento",$sql,$nome_documento);
	$mensagem = $mensagem."O Desafio `".$nome_desafio."` foi alterado(a) com sucesso!";		  
    alert_and_close_windows($mensagem, $cod, 'desafios');
}




////////////////////////////////////////////////////////////////////////////////
/////////////////////// alterar_topico /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["alterar_topico"]){
	// define dados para acessar o BD
	
   if (!$cod){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   
   
   /*
	if (verifica_acesso('','alterar_documento','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}*/
	

	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao = str_replace($var_ascii, $var_html, $descricao);
  	
	$mensagem ="";
	$sql = "UPDATE topicos SET  nome_topico='$nome_topico', 	media_flag='$media_flag', descricao='$descricao', data_alteracao='".date("Y-m-d H:i:s")."',id_desafio='$id_desafio',nro_topico='$nro_topico'       WHERE  id_topico=".$cod." LIMIT 1;
";			
	//exit($sql);
	update_record($sql);	
	
		//insert_log("alterar_documento",$sql,$nome_documento);
	$mensagem = $mensagem."O topico `".$nome_topico."` foi alterado(a) com sucesso!";		  
    alert_and_close_windows($mensagem, $cod, 'topicos');
}





////////////////////////////////////////////////////////////////////////////////
/////////////////////// adicionar_checklist /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["adicionar_checklist"]){
	// define dados para acessar o BD
	
	
	if (verifica_acesso('','adicionar_checklist','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}

	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao = str_replace($var_ascii, $var_html, $descricao);
  	
	$mensagem ="";
	$sql = "INSERT INTO checklists (nome_checklist, descricao, data_inclusao) VALUES ('$nome_checklist', '$descricao','".date("Y-m-d H:i:s")."')";		
	//exit($sql);
	insert_record($sql);	
	
	insert_log("adicionar_checklist",$sql,$nome_checklist);
	
	$mensagem = $mensagem."O Checklist `".$nome_checklist."` foi inserido(a) com sucesso!";	
      echo '<script>	  
			  var myDate = new Date();		  
			  var window_opener = parent.parent.window.document.getElementById("iframe_aerochecklists");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
			  var container = parent.parent.window.document.getElementById("Containerincluir_checklist");		  
			  container.style.display =  "none";			 		
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>'; 
	  
	  
}






////////////////////////////////////////////////////////////////////////////////
/////////////////////// adicionar_situacao /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["adicionar_situacao"]){
	// define dados para acessar o BD
	
	if (verifica_acesso('','adicionar_situacao','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}

	

	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao = str_replace($var_ascii, $var_html, $descricao);
  	
	$mensagem ="";
	$sql = "INSERT INTO situacoes (nome_situacao, descricao, data_inclusao) VALUES ('$nome_situacao', '$descricao','".date("Y-m-d H:i:s")."')";		
	//exit($sql);
	insert_record($sql);	
	
	insert_log("adicionar_situacao",$sql,$nome_situacao);
	
	$mensagem = $mensagem."A situação `".$nome_situacao."` foi inserido(a) com sucesso!";	
      echo '<script>	  
			  var myDate = new Date();		  
			  var window_opener = parent.parent.window.document.getElementById("iframe_aerosituacoes");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
			  var container = parent.parent.window.document.getElementById("Containerincluir_situacao");		  
			  container.style.display =  "none";			 		
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>'; 
	  
	  
}
 

////////////////////////////////////////////////////////////////////////////////
/////////////////////// alterar_situacao /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["alterar_situacao"]){
	// define dados para acessar o BD
	
   if (!$cod){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   
	if (verifica_acesso('','alterar_situacao','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}
   

	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao = str_replace($var_ascii, $var_html, $descricao);
  	
	$mensagem ="";
	$sql = "UPDATE situacoes SET nome_situacao='$nome_situacao', descricao='$descricao', data_alteracao='".date("Y-m-d H:i:s")."' WHERE  id_situacao=".$cod." LIMIT 1;";	
		
	//exit($sql);
	update_record($sql);	
	
	insert_log("alterar_situacao",$sql,$nome_situacao);
	
	$mensagem = $mensagem."A situação `".$nome_situacao."` foi alterado(a) com sucesso!";	
      echo '<script>	  
			  var myDate = new Date();		  
			  var window_opener = parent.parent.window.document.getElementById("iframe_aerosituacoes");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
			  var container = parent.parent.window.document.getElementById("Containersituacao'.$cod.'");		  
			  container.style.display =  "none";			 		
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>';   
}







////////////////////////////////////////////////////////////////////////////////
/////////////////////// adicionar_pendencia /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["adicionar_pendencia"]){
	// define dados para acessar o BD
	
	/*
	if (verifica_acesso('','adicionar_profissao','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}*/
	
   if (!$pendencia){
         echo '<script>alert("Faltou conteúdo em Pendência !");</script>';
         exit();
   }   
	
	
	
   if (!$titulo){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
	

	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao = str_replace($var_ascii, $var_html, $pendencia);
  	
	$mensagem ="";
	$sql = "INSERT INTO pendencias_avaliacao (id_solicitacao, id_checklist, id_item_checklist, id_usuario, pendencia, titulo, data_inclusao) VALUES ('$id_solicitacao', '$id_checklist', '$id_item_checklist',  '".$_SESSION["id_usuario_session"]."', '$pendencia', '$titulo','".date("Y-m-d H:i:s")."');
";			
	//exit($sql);
	insert_record($sql);	
	
	//insert_log("adicionar_profissao",$sql,$nome_profissao);
	
	$mensagem = $mensagem."Pendencia `".$titulo." ` foi inserido(a) com sucesso!";	

	  
	  echo '<script>alert("'.$mensagem.'");
	  parent.atualiza_pendencias();
	  parent.limpa_form();
	  parent.$("#tabs").tabs("select", "tabs-listar");	   
	  </script>'; 
	  
	  
}
 




////////////////////////////////////////////////////////////////////////////////
/////////////////////// adicionar_ocupacao /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["adicionar_ocupacao"]){
	// define dados para acessar o BD
	
	if (verifica_acesso('','adicionar_ocupacao','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}
	

	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao = str_replace($var_ascii, $var_html, $descricao);
  	
	$mensagem ="";
	$sql = "INSERT INTO tipo_ocupacao (nome_tipo_ocupacao, descricao, data_inclusao) VALUES ('$nome_tipo_ocupacao', '$descricao','".date("Y-m-d H:i:s")."')";		
	//exit($sql);
	insert_record($sql);	
	
	insert_log("adicionar_ocupacao",$sql,$nome_tipo_ocupacao);
	
	$mensagem = $mensagem."A Ocupação `".$nome_tipo_ocupacao." ` foi inserido(a) com sucesso!";	
      echo '<script>	  
			  var myDate = new Date();		  
			  var window_opener = parent.parent.window.document.getElementById("iframe_aeroocupacoes");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
			  var container = parent.parent.window.document.getElementById("Containerincluir_tipo_ocupacao");		  
			  container.style.display =  "none";			 		
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>'; 
	  
	  
}
 

////////////////////////////////////////////////////////////////////////////////
/////////////////////// alterar_ocupacao /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["alterar_ocupacao"]){
	// define dados para acessar o BD
	
   if (!$cod){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   
	if (verifica_acesso('','alterar_ocupacao','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}
	
   

	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao = str_replace($var_ascii, $var_html, $descricao);
  	
	$mensagem ="";
	$sql = "UPDATE tipo_ocupacao SET nome_tipo_ocupacao='$nome_tipo_ocupacao', descricao='$descricao', data_alteracao='".date("Y-m-d H:i:s")."' WHERE  id_tipo_ocupacao=".$cod." LIMIT 1;";	
		
	//exit($sql);
	update_record($sql);	
	
	insert_log("alterar_ocupacao",$sql,$nome_tipo_ocupacao);
	
	$mensagem = $mensagem."A ocupação `".$nome_tipo_ocupacao."` foi alterado(a) com sucesso!";	
      echo '<script>	  
			  var myDate = new Date();		  
			  var window_opener = parent.parent.window.document.getElementById("iframe_aeroocupacoes");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
			  var container = parent.parent.window.document.getElementById("Containertipo_ocupacao'.$cod.'");		  
			  container.style.display =  "none";			 		
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>';   
}



////////////////////////////////////////////////////////////////////////////////
/////////////////////// adicionar_youtube /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["adicionar_youtube"]){
	
	/*
	if (verifica_acesso('','adicionar_objeto','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}
	
	// define dados para acessar o BD
	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao = str_replace($var_ascii, $var_html, $descricao);*/
	
	
	$mensagem ="";	
	
$sql = "SELECT ordem+1 AS ordem from anexos where id_desafio='$id_desafio'  AND caminho_arquivo is NULL order by id_anexo desc limit 1";
$rs = get_record($sql);
$ordem = intval($rs["ordem"]);


	$sql = "INSERT INTO anexos (descricao, id_desafio, youtube_link, ordem, data_inclusao) VALUES ('$nome_original', '$id_desafio', '$value', '".$ordem."','".date("Y-m-d H:i:s")."');
";		
	//exit($sql);
	insert_record($sql);	
	
	
	//insert_log("adicionar_objeto",$sql,$nome_objeto);
	
	$mensagem = $mensagem."O Vídeo foi inserido(a) com sucesso!";	

	  
	  echo '<script>
	  parent.atualiza_arquivos();
	  alert("'.$mensagem.'");
	  
	  </script>'; 
}
 
 
 
 
////////////////////////////////////////////////////////////////////////////////
/////////////////////// adicionar_youtube_topico /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["adicionar_youtube_topico"]){
	
	/*
	if (verifica_acesso('','adicionar_objeto','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}
	
	// define dados para acessar o BD
	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao = str_replace($var_ascii, $var_html, $descricao);*/
	
	
	$mensagem ="";	
	
$sql = "SELECT ordem+1 AS ordem from anexos where id_topico='$id_topcio'  AND caminho_arquivo is NULL order by id_anexo desc limit 1";
$rs = get_record($sql);
$ordem = intval($rs["ordem"]);


	$sql = "INSERT INTO anexos (descricao, id_topico, youtube_link, ordem, data_inclusao) VALUES ('$nome_original', '$id_topico', '$value', '".$ordem."','".date("Y-m-d H:i:s")."');
";		
	//exit($sql);
	insert_record($sql);	
	
	
	//insert_log("adicionar_objeto",$sql,$nome_objeto);
	
	$mensagem = $mensagem."O Vídeo foi inserido(a) com sucesso!";	

	  
	  echo '<script>
	  parent.atualiza_arquivos();
	  alert("'.$mensagem.'");
	  
	  </script>'; 
	  
	  
}

////////////////////////////////////////////////////////////////////////////////
/////////////////////// alterar_objeto /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["alterar_objeto"]){
	// define dados para acessar o BD
	
	
	if (verifica_acesso('','alterar_objeto','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}
	
	
   if (!$cod){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   

	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao = str_replace($var_ascii, $var_html, $descricao);
  	
	$mensagem ="";
	$sql = "UPDATE objetos SET nome_objeto='$nome_objeto', descricao='$descricao', data_alteracao='".date("Y-m-d H:i:s")."' WHERE  id_objeto=".$cod." LIMIT 1;";	
		
	//exit($sql);
	update_record($sql);	
	
	  $sql = "delete from documentos_x_objetos where id_objeto='".$cod."';";
	  delete_record($sql); 	 
	if ($_POST["documentos"]){ //somente se foi selecionado alguam algum item 
			foreach($_POST["documentos"] as $a => $b){
				$sql = "insert into documentos_x_objetos (id_objeto,id_documento) values ('".$cod."','".$b."');";	
				insert_record($sql); // insere dados 
			}
	}
	
	  $sql = "delete from checklists_x_objetos where id_objeto='".$cod."';";
	  delete_record($sql); 	 
	if ($_POST["checklist"]){ //somente se foi selecionado alguam algum item 
			foreach($_POST["checklist"] as $a => $b){
				$sql = "insert into checklists_x_objetos (id_objeto,id_checklist) values ('".$cod."','".$b."');";	
				insert_record($sql); // insere dados 
			}
	}
	
	
	
	insert_log("alterar_objeto",$sql,$nome_objeto);
	
	$mensagem = $mensagem."A situação `".$nome_objeto."` foi alterado(a) com sucesso!";	
      echo '<script>	  
			  var myDate = new Date();		  
			  var window_opener = parent.parent.window.document.getElementById("iframe_aeroobjetos");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
			  var container = parent.parent.window.document.getElementById("Containerobjeto'.$cod.'");		  
			  container.style.display =  "none";			 		
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>';   
}






////////////////////////////////////////////////////////////////////////////////
/////////////////////// adicionar_empresa /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["adicionar_empresa"]){
	$mensagem ="";
	
   if (!$cnpj){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   
	if (verifica_acesso('','adicionar_empresa','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}
   
   	//verifica se cpf ou cnpj já existe cadastado
	$cnpj = limpaCpf_Cnpj($cnpj);
	$sql="select id_empresa from empresas where cnpj='".$cnpj."'";
   
	if (get_record($sql)){
        echo '<script>
		alert("Já existe cadastro com esse CNPJ, favor usar outro");
		parent.$("#tabs").tabs("select", "tabs-1");
		parent.document.forms[0].elements["cnpj"].value="";	
		parent.document.forms[0].elements["cnpj"].focus();	
		</script>';		
         exit();
	}
	
	
	
	// define dados para acessar o BD
	$var_ascii = array("'");
	$var_html  = array('"');
	//$empresa = safe_text(str_replace($var_ascii, $var_html, $_POST["empresa"]));	
	$obs = str_replace($var_ascii, $var_html, $obs);
	
	if($cep)$cep = limpaCep($cep);	
	
	$data_fundacao = $data_fundacao? "'".data_us($data_fundacao)."'":"NULL";
	
	$sql = "INSERT INTO empresas ( id_municipio,  razao_social,  nome_fantasia,  data_fundacao,  cnpj,  inscricao_estadual,  inscricao_municipal,  endereco,  numero,  complemento, bairro,  cep,  responsavel_pmc,  responsavel,  cargo,  email,  telefone,  fax,  celular,  data_cancelamento,  data_alteracao,  data_inclusao,  obs,  senha
) VALUES ('$id_municipio', '$razao_social', '$nome_fantasia', ".$data_fundacao.", '$cnpj', '$inscricao_estadual', '$inscricao_municipal', '$endereco', '$numero', '$complemento', '$bairro', '$cep', '$responsavel_pmc', '$responsavel', '$cargo', '$email', '$telefone', '$fax', '$celular', NULL, NULL, '".date("Y-m-d H:i:s")."', '$obs', '".md5($senha)."');";	
	//exit($sql);
	//echo $sql;
	insert_record($sql);	
	$sql_log .= $sql;  // registra log da operação
	$id_empresa = mysql_insert_id();	

	
////////////////////////////////////////////////////////////////////
//////////////// envia email /////////////////////////////////
//////////////////////////////////////////////////////////////////		



	
			$Subject = "Cadastro - ".InfoSystem::nome_sistema;
			
			
			$Html = '<html><body bgcolor="#ffffff">				
			<table style="width:100%;" cellpadding="0" cellspacing="0" >		
			<tr >
			<td style="width:38px" rowspan="2" >				
			
			<img width="38px"   src="'.InfoSystem::url_site.'/images/pmc_brasao_sem_fundo_100x108.png" align="left" border="0"> 
			
			</td>
			
			<td>
			<b style="font-size:14px;"> '.InfoSystem::titulo.' </b>
			| <b style="font-size:10px;">'.InfoSystem::subtitulo.'</b><br>
			<b style="font-size:10px;color:#006600;">'.InfoSystem::nome_sistema.'</b><br>			
			</td>
			<td>	
			</td>
			</tr>	
			<tr><td colspan="2"><hr style="border:1px solid #15428B">
			</td></tr>
			<table>';

			
			
			

			$Html .=  'CNPJ: '.$_POST["cnpj"].',<br><br>';
			$Html .= "Bem-vindo ao sistema ".InfoSystem::nome_sistema." da Prefeitura Municipal de Campinas.".'<br>';
			$Html .= "Este email foi usado durante um registro em nosso site.".'<br><br>';			
			
			$Html .= 'Seu Login de Usuário é seu CNPJ: '.$_POST["cnpj"].'<br>';
			$Html .= 'Sua Senha é: '.$senha.'<br>';
			
			$Html .= 'URL: <a href="'.InfoSystem::url_site.'">'.InfoSystem::url_site.'</a><br>';
			
			
			
			$Html .= '<br>A sua senha foi codificada de forma segura em nosso banco de dados e não podemos restaurá-la. Contudo, caso se esqueça da mesma, você poderá gerar uma nova senha pelo botão "Lembrar Senha" na nossa página inicial de login.<br>';
			
			$Html .= '<br>Este e-mail foi gerado automaticamente. Este comunicado contém informações que podem ser confidenciais. Se você não for o destinatário correto deste e-mail, fica notificado que qualquer difusão, distribuição ou cópia desta mensagem ou de seu conteúdo é estritamente proibida. Se receber esta mensagem com erro, exclua imediatamente.<br>';
			
			$Html .= '<br>Obrigado por registrar-se!<br>';
			$Html .= '<a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br>';
			
			$Html .= '</html></body>';
					  
					  
			$EmailRecipient = $email;			  
			
			SendMail(InfoSystem::email_sender,InfoSystem::titulo,$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
			insert_log("enviar_email",$Subject,"to: ".$EmailRecipient);				  
				 
///////////////////////////////////////////////////////////////////////////////////////
		
		
		
	
	insert_log("adicionar_empresa",$sql_log,$razao_social);
	
	$mensagem = "A empresa `".$razao_social."` foi inserido(a) com sucesso!".'\n'.$mensagem;	
      echo '<script>	  
			  var myDate = new Date();		  
			  var window_opener = parent.parent.window.document.getElementById("iframe_aeroempresas");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
			  var container = parent.parent.window.document.getElementById("Containerincluir_empresas");		  
			  container.style.display =  "none";			 		
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>'; 
	  
	  
}




////////////////////////////////////////////////////////////////////////////////
/////////////////////// alterar_empresa/////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["alterar_empresa"]){
	// define dados para acessar o BD
	
   if (!$cod){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   
   
	if (verifica_acesso('','alterar_empresa','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}
   
	$mensagem ="";
		

	// define dados para acessar o BD
	$var_ascii = array("'");
	$var_html  = array('"');
	//$empresa = safe_text(str_replace($var_ascii, $var_html, $_POST["empresa"]));	
	$obs = str_replace($var_ascii, $var_html, $obs);
	
  	if($cep)$cep = limpaCep($cep);	
	
	$cnpj = limpaCpf_Cnpj($cnpj);
	
	$data_fundacao = $data_fundacao? "'".data_us($data_fundacao)."'":"NULL";
	
	
	if (($alteracao_senha)&&($senha)&&($confirmar_senha)){
		$add = "  , senha = '".md5($senha)."'   ";	
		$add_coment = " \\n Senha Alterada com Sucesso!";
	}


	$sql = "UPDATE empresas SET						
							  id_municipio	 = '$id_municipio',
							  razao_social	 = '$razao_social',
							  nome_fantasia	 = '$nome_fantasia', 
							  data_fundacao	 = $data_fundacao, 
							  cnpj	 = '$cnpj', 
							  inscricao_estadual	 = '$inscricao_estadual',
							  inscricao_municipal	 = '$inscricao_municipal',
							  endereco	 = '$endereco', 
							  numero	 = '$numero', 
							  complemento	 = '$complemento',
							  bairro	 = '$bairro', 
							  cep	 = '$cep',
							  responsavel_pmc 	 = '$responsavel_pmc',  
							  responsavel	 = '$responsavel',
							  cargo	 = '$cargo',
							  email	 = '$email',
							  telefone	 = '$telefone',
							  fax	 = '$fax',
							  celular	 = '$celular',	
							  obs	 = '$obs',
							  data_alteracao='".date("Y-m-d H:i:s")."' ".$add."
			WHERE  id_empresa='".$cod."' LIMIT 1;";	
		
	//exit($sql);
	update_record($sql);	
	$sql_log .= $sql;  // registra log da operação
	
	
	insert_log("alterar_empresa",$sql_log,$razao_social);
	
	$mensagem = "A Empresa `".$razao_social."`  foi alterado(a) com sucesso!".'\n'.$mensagem.$add_coment;	
      echo '<script>	  
			  var myDate = new Date();		  
			  var window_opener = parent.parent.window.document.getElementById("iframe_aeroempresas");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
			  var container = parent.parent.window.document.getElementById("Containerempresas'.$cod.'");		  
			  container.style.display =  "none";			 		
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>';   
}




////////////////////////////////////////////////////////////////////////////////
/////////////////////// lembrar_senha /////////////////
////////////////////////////////////////////////////////////////////////////////

if ($_GET["lembrar_senha"]){


$sql ="select id_tecnico,nome_resp_tecnico,senha,email from tecnicos
   where email = '".$_POST["email"]."'   and  cpf_cnpj ='".limpaCpf_Cnpj($_POST["cpf_cnpj"])."'";   


	  if ($rs=get_record($sql)){
		  	if ($rs["senha"]){
				  $nova_senha=substr($rs["senha"],1,8);	  
				  $sql = "update tecnicos set senha= ('".md5($nova_senha)."') where cpf_cnpj = '".limpaCpf_Cnpj($_POST["cpf_cnpj"])."'";			
				  //echo $sql;
				  update_record($sql);
			
				  $Subject = "Recuperação de Senha - Prefeitura Municipal de Campinas";						
				  
					  $Html = '<html><body bgcolor="#ffffff">';	
					  $Html .=  'Prezado(a) '.$rs["nome_resp_tecnico"].',<br><br>';
					  $Html .= "Esse e-mail foi enviado em atendimento à sua solicitação de gerar uma nova senha.".'<br>';
					  $Html .= "Para ter acesso ao sistema, será necessário inserir sua Nova Senha.".'<br>';		
					  $Html .= '<br>';
					  $Html .= 'Sua nova senha é: '.$nova_senha.'<br>';
					  
					  $Html .= '<br>Este e-mail foi gerado automaticamente. Este comunicado contém informações que podem ser confidenciais. Se você não for o destinatário correto deste e-mail, fica notificado que qualquer difusão, distribuição ou cópia desta mensagem ou de seu conteúdo é estritamente proibida. Se receber esta mensagem com erro, exclua imediatamente.<br>';	
				  
					  $Html .= '<br><a href="http://www.campinas.sp.gov.br">www.campinas.sp.gov.br</a><br>';
					  
					  $Html .= '</html></body>';	
				  
				  $EmailRecipient = $rs["email"];
				  $NameRecipient = "";
				  //$EmailRecipient = "pauloeno@yahoo.com.br";a
				  
				  
				  SendMail($email_sender,"Recuperador de Senha",$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
				  
				  
				  $aviso = "Uma nova senha foi enviada para seu email \\n".$EmailRecipient;
				  
				 echo '<script>
					var container = parent.parent.window.document.getElementById("Containerlembrar_senha");		  
					container.style.display =  "none";
				 </script>';	
				   $action = 'parent.parent.window.location.href="../login.php";';
			}else{		
				  $aviso="Sua senha ainda não está ativa, por favor, utilize a opção de Primeiro Acesso";
				  $action = 'parent.parent.window.location.href="../primeiro_acesso.php";';				
			}
	 }else{
			$aviso="Email ou CPF / CNPJ inválido";
	 }
	 
	 echo "<script>
	 	alert('".$aviso."');
		".$action."
	 </script>";	 
	 exit();
}













//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------









//########################################################################################
//--------------------------------envia_email--------------------------------------
//########################################################################################


if ($_GET["envia_email"]){	

   if (!$email){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }  

 					  $Subject = $assunto;						
				  
					  $Html = '<html><body bgcolor="#ffffff">				  
					  
			<table style="width:100%;" cellpadding="0" cellspacing="0" >		
			<tr >
			<td style="width:38px" rowspan="2" >			
			<img src="http://godc.campinas.sp.gov.br/images/pmc_brasao_sem_fundo_100x108.png" align="left" border="0"> 
			</td>
			<td>
			<b style="font-size:14px;"> Prefeitura Municipal de Campinas </b>
			| <b style="font-size:10px;">Secretaria Municipal  </b><br>
			<b style="font-size:10px;color:#006600;">Nome Sistema </b><br>			
			</td>
			<td>	
			</td>
			</tr>	
			<tr><td colspan="2"><hr style="border:1px solid #15428B">
			</td></tr>
			<table>

					  
					  
					  
					  ';	
					  
					  
					  $Html .= $texto_email;	
				  
			
					  
					  $Html .= '</html></body>';	
				  
				  $EmailRecipient = $email;
		
				  
				  
				  SendMail('email@campinas.sp.gov.br',"Nome Sistema",$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
				  
				  
				    insert_log("enviar_email",$Subject,"to: ".$EmailRecipient);
				  
				  
				   echo '<script>				   
					var container = parent.parent.window.document.getElementById("Containerenvia_email'.$id_solicitacao.'");		  
					container.style.display =  "none";
					alert("Email Enviado com Sucesso");
					</script>
					';
	
	 
}	




////////////////////////////////////////////////////////////////////////////////
/////////////////////// alterar_grupo_acesso /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["alterar_grupo_acesso"]){
	// define dados para acessar o BD
	
   if (!$cod){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   

	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao_nivel = str_replace($var_ascii, $var_html, $descricao_nivel);
  	$sql_log = "";
	$mensagem ="";
	$sql = "UPDATE niveis_acesso SET nome_nivel='$nome_nivel', descricao_nivel='$descricao_nivel', data_alteracao='".date("Y-m-d H:i:s")."' WHERE  id_nivel='".$cod."' LIMIT 1;";	
	$sql_log .= $sql;
		

	update_record($sql);	
	
	  $sql = "delete from nivel_operacao where id_nivel='".$cod."';";
	  delete_record($sql); 	
	  $sql_log .= $sql;
	if ($_POST["id_objeto"]){ //somente se foi selecionado alguam algum item 
			foreach($_POST["id_objeto"] as $a => $b){
				$sql = "insert into nivel_operacao (id_operacao,id_nivel) values ('".$b."','".$cod."');";					
				insert_record($sql); // insere dados 
				$sql_log .= $sql;
			}
	}
	
	
	
	//	exit($sql_log);
	
   insert_log("alterar_grupo_acesso",$sql_log,$nome_nivel);
	
	$mensagem = $mensagem."O Grupo de Acesso `".$nome_nivel."` foi alterado(a) com sucesso!";	
      echo '<script>	  
			  var myDate = new Date();		  
			  var window_opener = parent.parent.window.document.getElementById("iframe_aeroniveis_acesso");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
			  var container = parent.parent.window.document.getElementById("Containerniveis_acesso'.$cod.'");		  
			  container.style.display =  "none";			 		
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>';   
}






////////////////////////////////////////////////////////////////////////////////
/////////////////////// inserir_grupo_acesso /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["inserir_grupo_acesso"]){
	// define dados para acessar o BD
	
   if (!$nome_nivel){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   
	if (verifica_acesso('','alterar_grupo_acesso','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}
   

	$var_ascii = array("'");
	$var_html  = array('"');
	//$objeto = safe_text(str_replace($var_ascii, $var_html, $_POST["objeto"]));	
	$descricao_nivel = str_replace($var_ascii, $var_html, $descricao_nivel);
  	$sql_log = "";
	$mensagem ="";
	
	$sql = "INSERT INTO niveis_acesso (nome_nivel, descricao_nivel,data_inclusao) VALUES ('$nome_nivel', '$descricao_nivel','".date("Y-m-d H:i:s")."');";
	$sql_log .= $sql;		
	insert_record($sql);		
	$id_nivel = mysql_insert_id(); 	

	if ($_POST["id_objeto"]){ //somente se foi selecionado alguam algum item 
			foreach($_POST["id_objeto"] as $a => $b){
				$sql = "insert into nivel_operacao (id_operacao,id_nivel) values ('".$b."','".$id_nivel."');";					
				insert_record($sql); // insere dados 
				$sql_log .= $sql;
			}
	}
	
	
	
	//	exit($sql_log);
	
   insert_log("alterar_grupo_acesso",$sql_log,$nome_nivel);
	
	$mensagem = $mensagem."O Grupo de Acesso `".$nome_nivel."` foi incluido(a) com sucesso!";	
      echo '<script>	  
			  var myDate = new Date();		  
			  var window_opener = parent.parent.window.document.getElementById("iframe_aerogrupo_acesso");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
			  var container = parent.parent.window.document.getElementById("Containerniveis_acesso'.$cod.'");		  
			  container.style.display =  "none";			 		
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>';   
}




////////////////////////////////////////////////////////////////////////////////
/////////////////////// inserir_form_padrao /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["inserir_form_padrao"]){
	// define dados para acessar o BD		

	
   if (!$_GET["table"]){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }      
   
   /*
	if (verifica_acesso('','alterar_grupo_acesso','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}  	
	
	 */
	  
	  //////////////////////////////////////////////////////////////////////////////
	  ///////////////////////// Campo que serão removidos do form /////////////////
	  /////////////////////////////////////////////////////////////////////////////////
	  $remove_form_field = array();
	  $xml_remove = simplexml_load_file("../xml/form_remove_field.xml");
	  foreach($xml_remove as $field){		
		  if  ((string)$field->children() == $_GET["table"]){ //verifica se tabelea tem campo form em xml			
				foreach($field->children() as $child){
						if ( (string)$child->getName() == 'field'){ // pega campos do form que serão escondidos	
								$remove_form_field[] = trim((string)$child);
						}
				}
		  }
	  }
	  //////////////////////////////////////////////////////////////////////////////
	  
	  $class_table_variables = new table_variables;
	  $class_table_variables -> overload_tables ($_GET["table"]);  //perde a sessão aqui
	  /*
	  for($x=0;$x<count($_SESSION["listfield_vetor"]);$x++){
		  $campos_sql .= $_SESSION["listfield_vetor"][$x];	
		  ($x == intval(count($_SESSION["listfield_vetor"])-1))? "":$campos_sql .= ",";
	  }*/
	  $sql = "SELECT * FROM ".$_GET["table"];	
	  
	  $result = return_query($sql);	
	  $describe = db_describe_table($_GET["table"]);
	  $num = db_num_fields($result);
	  
	  $field_name = array();
	  $field_max_length  = array();
	  $field_numeric = array();
	  $field_type = array();
	  $field_def = array();
	  $output = array();
	  

	  for ($i = 0; $i < $num; ++$i) {		 
		  $field = db_fetch_field($result, $i);
		  // Create the column_definition
		  $field->definition = db_result($describe, $i, 'Type');
		  $field->len = db_field_len($result, $i);
		  $field_name[] = strtolower($field->name);	
		  $field_max_length[] = $field->len;
		  $field_numeric[] =  $field->numeric;
		  $field_type[] =  $field->type;
		  $field_def[] =  $field->definition;
	  }

	  //////////////////////////////////////
	  // remove campos do formulario ////////////////////
	  /////////////////////////////////////////  
	  
	  $remove_fields = array("ativado","data_cancelamento","data_alteracao",$_SESSION["primary_key"]);
	  $remove_fields = array_merge($remove_fields, $remove_form_field);
	  foreach ($remove_fields as $field_value){
			$remove_number = array_search($field_value,$field_name);		
			unset($field_name[$remove_number]);
			unset($field_max_length[$remove_number]);
			unset($field_numeric[$remove_number]);
			unset($field_type[$remove_number]);
			unset($field_def[$remove_number]);
	  } 
	$var_ascii = array("'");
	$var_html  = array('´');	  
	 $i=0;
	foreach ($field_name as $index => $value){
	   if ($i != 0) {
		   $sql_col .= ",";
		   $sql_value .= ",";
	   }
	   $sql_col .= $value ;
	   $field_value = $$value;	   
	   
	  // echo $field_type[$index];
	   
		if (
			($field_type[$index]=="string")||   //mysql
			($field_type[$index]=="text") // postgreSQL text
			){ 
		    if  (
				 (stristr($value, 'cpf') == TRUE)||
				 (stristr($value, 'cnpj') == TRUE) 
				 ){	
				 $field_value = limpaCpf_Cnpj($field_value);
			}
		}	
	   
		if (
			($field_type[$index]=="datetime") ||   //mysql
			($field_type[$index]=="timestamp")   //postgreSQL 
			){ 
			 if ($value == "data_inclusao"){
				 $field_value = date("Y-m-d H:i:s");
			 }else{
				  $data = data_us(substr($field_value, 0,10));	 			  
				  $hora=$field_name[$index]."_hora";				
				  $hora = $$hora;	
				  $field_value = $data." ".$hora;
			 }
		}		   
	   if ($field_type[$index]=="date"){
           $field_value = data_us(substr($field_value, 0,10));	  
	   }
	   if ($field_type[$index]=="time"){
           $field_value .= ":00";   
	   }

	   
	   if (
		   ($field_type[$index]=="real") ||   //mysql 
		   ($field_type[$index]=="float4")  ||  //postgreSQL
		   ($field_type[$index]=="float8")  ||  //postgreSQL
		   ($field_type[$index]=="numeric")    //postgreSQL		   
		   ){
           $search = array (".",",");
           $replace = array ("",".");
           $field_value = str_replace($search, $replace, $field_value);
	   }
	   
	   if (
		   ($field_type[$index]=="int") ||   //mysql integer ou bigint
		   ($field_type[$index]=="int2") ||   //postgreSQL smallint
		   ($field_type[$index]=="int4") ||   //postgreSQL integer
		   ($field_type[$index]=="int8")   //postgreSQL bigint
		   ){
		    if (stristr($value, 'cep') == TRUE){	
				$field_value = limpaCep($field_value);	
			}		
		    if  (
				 (stristr($value, 'cpf') == TRUE)||
				 (stristr($value, 'cnpj') == TRUE) 
				 ){	
				 $field_value = limpaCpf_Cnpj($field_value);
			}
	   }	  

	   $field_value = str_replace($var_ascii, $var_html, $field_value);
	   $sql_value .= noempty($field_value);
	  $i++;
	} 
		
	$sql = "INSERT INTO ".$_GET["table"]."(".$sql_col.") VALUES ($sql_value);";
	$sql_log .= $sql;		
	//echo $sql;
	insert_record($sql);	

	
	if (DBConnect::database=="postgresql"){    //PostgreSQL
		$sql_key = "select replace(REPLACE(column_default,'nextval(\'',''),'\'::regclass)','') from information_schema.columns where table_name = '".$_GET["table"]."' 
and column_default is not NULL";
		$key = pg_insert_id($sql_key);
	}else{ //Mysql	
		$key = mysql_insert_id(); 	
	}
	

	
   insert_log("adicionar_".$_GET["table"],$sql_log,"id:".$key);
	
	$mensagem = $mensagem."Registro na tabela `".$_GET["table"]."` foi incluido(a) com sucesso!";	
      echo '<script>	  
			  var myDate = new Date();		  			 
			  var container = parent.parent.window.document.getElementById("Containerincluir_'.$_GET["table"].'");		  
			  container.style.display =  "none";			 
			  var window_opener = parent.parent.window.document.getElementById("iframe_aero'.$_GET["table"].'");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();			  
			  parent.limpa_form();
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>';   
	  
}




////////////////////////////////////////////////////////////////////////////////
/////////////////////// alterar_form_padrao /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["alterar_form_padrao"]){
	// define dados para acessar o BD	
	
   if (
	   (!$_GET["table"])||
	   (!$_GET["cod"]) 
	   ){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }      
   
   /*
	if (verifica_acesso('','alterar_grupo_acesso','','') == "Acesso Negado") {
 		  echo '<script>alert("Acesso Proibido. Você não tem privilégios para executar essa operação");</script>';
		  exit();
	}  

  	$sql_log = "";
	$mensagem ="";
	
	 */
	  //////////////////////////////////////////////////////////////////////////////
	  ///////////////////////// Campo que serão removidos do form /////////////////
	  /////////////////////////////////////////////////////////////////////////////////
	  $remove_form_field = array();
	  $xml_remove = simplexml_load_file("../xml/form_remove_field.xml");
	  foreach($xml_remove as $field){		
		  if  ((string)$field->children() == $_GET["table"]){ //verifica se tabelea tem campo form em xml			
				foreach($field->children() as $child){
						if ( (string)$child->getName() == 'field'){ // pega campos do form que serão escondidos	
								$remove_form_field[] = trim((string)$child);
						}
				}
		  }
	  }
	  //////////////////////////////////////////////////////////////////////////////

	 
	  
	  $class_table_variables = new table_variables;
	  $class_table_variables -> overload_tables ($_GET["table"]);  //perde a sessão aqui
	  /*
	  for($x=0;$x<count($_SESSION["listfield_vetor"]);$x++){
		  $campos_sql .= $_SESSION["listfield_vetor"][$x];	
		  ($x == intval(count($_SESSION["listfield_vetor"])-1))? "":$campos_sql .= ",";
	  }*/
	  $sql = "SELECT * FROM ".$_GET["table"];	
	  
	  $result = return_query($sql);	
	  $describe = db_describe_table($_GET["table"]);
	  $num = db_num_fields($result);
	  
	  $field_name = array();
	  $field_max_length  = array();
	  $field_numeric = array();
	  $field_type = array();
	  $field_def = array();
	  $output = array();

	  for ($i = 0; $i < $num; ++$i) {		 
		  $field = db_fetch_field($result, $i);
		  // Create the column_definition
		  $field->definition = db_result($describe, $i, 'Type');
		  $field->len = db_field_len($result, $i);
		  $field_name[] = strtolower($field->name);	
		  $field_max_length[] = $field->len;
		  $field_numeric[] =  $field->numeric;
		  $field_type[] =  $field->type;
		  $field_def[] =  $field->definition;
	  }

	  //////////////////////////////////////
	  // remove campos do formulario ////////////////////
	  /////////////////////////////////////////  
	  
	  $remove_fields = array("ativado","data_cancelamento","data_inclusao",$_SESSION["primary_key"]);
	  $remove_fields = array_merge($remove_fields, $remove_form_field);
	  foreach ($remove_fields as $field_value){
			$remove_number = array_search($field_value,$field_name);		
			unset($field_name[$remove_number]);
			unset($field_max_length[$remove_number]);
			unset($field_numeric[$remove_number]);
			unset($field_type[$remove_number]);
			unset($field_def[$remove_number]);
	  }
	$var_ascii = array("'");
	$var_html  = array('´');	  
	 $i=0;
	foreach ($field_name as $index => $value){
		$sql_col = "";
		$field_value = "";
	   if ($i != 0) {
		   $sql_col = ", ";		  
	   }
	   $sql_col .= $value ;
	   $field_value = $$value; 
	   
	   
	
		if (
			($field_type[$index]=="string")||   //mysql
			($field_type[$index]=="text") // postgreSQL text
			){ 
		    if  (
				 (stristr($value, 'cpf') == TRUE)||
				 (stristr($value, 'cnpj') == TRUE) 
				 ){	
				 $field_value = limpaCpf_Cnpj($field_value);
			}
		}	
	   	   

		if (
			($field_type[$index]=="datetime") ||   //mysql
			($field_type[$index]=="timestamp")   //postgreSQL 
			){ 
			 if ($value == "data_alteracao"){
				 $field_value = date("Y-m-d H:i:s");
			 }else{
				  $data = data_us(substr($field_value, 0,10));	 			  
				  $hora=$field_name[$index]."_hora";				
				  $hora = $$hora;	
				  $field_value = $data." ".$hora;
			 }
		}		   
	   if ($field_type[$index]=="date"){
           $field_value = data_us(substr($field_value, 0,10));	  
	   } 
	   
	   if ($field_type[$index]=="time"){
           $field_value .= ":00";   
	   }

   
	   if (
		   ($field_type[$index]=="real") ||   //mysql 
		   ($field_type[$index]=="float4")  ||  //postgreSQL
		   ($field_type[$index]=="float8")  ||  //postgreSQL
		   ($field_type[$index]=="numeric")   //postgreSQL	
		   ){
           $search = array (".",",");
           $replace = array ("",".");
           $field_value = str_replace($search, $replace, $field_value);
	   }
	   
	   if (
		   ($field_type[$index]=="int") ||   //mysql integer ou bigint
		   ($field_type[$index]=="int2") ||   //postgreSQL smallint
		   ($field_type[$index]=="int4") ||   //postgreSQL integer
		   ($field_type[$index]=="int8")   //postgreSQL bigint
		   ){
		    if (stristr($value, 'cep') == TRUE){	
				$field_value = limpaCep($field_value);	
			}		  
		    if  (
				 (stristr($value, 'cpf') == TRUE)||
				 (stristr($value, 'cnpj') == TRUE) 
				 ){	
				 $field_value = limpaCpf_Cnpj($field_value);
			}
	   }	   
	   $field_value = str_replace($var_ascii, $var_html, $field_value);	
	   $sql_value .= $sql_col. " = ". noempty($field_value)."   " ;
	  $i++;
	} 
	
	$sql = "UPDATE ".$_GET["table"]." SET ".$sql_value."
			WHERE  ".$_SESSION["primary_key"]."='".$cod."' ";	
			
			
	if (DBConnect::database=="mysql") $sql .= " LIMIT 1; ";
			
		//	exit($sql);
	
	$sql_log .= $sql;	
	update_record($sql);	

	
    insert_log("alterar_".$_GET["table"],$sql_log,"id:".$cod);
	
	$mensagem = $mensagem."Registro na tabela `".$_GET["table"]."` foi alterado(a) com sucesso!";	
      echo '<script>	  
			  var myDate = new Date();		  			 
			  var container = parent.parent.window.document.getElementById("Container'.$_GET["table"].$cod.'");		  
			  container.style.display =  "none";			 
			  var window_opener = parent.parent.window.document.getElementById("iframe_aero'.$_GET["table"].'");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
      </script>'."\n";
	  
	  echo '<script>alert("'.$mensagem.'");</script>';   
}







////////////////////////////////////////////////////////////////////////////////
/////////////////////// finalizar_questionario /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["finalizar_questionario"]){
	
   if (
	   (!$_GET["id_questionario"])||
	   (!$_GET["id_solicitacao"]) 
	   ){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }      		  
		  
 	$pergunta_obrigatoria = array();
	$pergunta_respondida = array();
	  
	$sql_obrigatorio = "SELECT   a.id_pergunta
				FROM perguntas  as a
				WHERE (a.data_cancelamento is NULL) 
				AND a.id_questionario = '".$id_questionario."' 
				AND a.obrigatorio_flag = 'S'";		

	$result_obrigatorio = return_query($sql_obrigatorio);		
	while( $rs_obrigatorio = db_fetch_array($result_obrigatorio) ){	
		$pergunta_obrigatoria[] = $rs_obrigatorio["id_pergunta"];				
	} 		
	  
	$sql_respondido = "SELECT distinct c.id_pergunta
							  FROM respostas_questionarios AS a
							  INNER JOIN opcoes AS b ON (b.id_opcao = a.id_opcao)
							  INNER JOIN perguntas AS c ON (c.id_pergunta = b.id_pergunta)
							  INNER JOIN questionarios AS d ON (d.id_questionario = c.id_questionario)
							  INNER JOIN solicitacoes AS e ON (e.id_solicitacao = a.id_solicitacao)
							  WHERE e.id_solicitacao =  '".$id_solicitacao."'  AND d.id_questionario =  '".$id_questionario."' 
							  order by c.id_pergunta";		

	$result_respondido = return_query($sql_respondido);		
	while( $rs_respondido = db_fetch_array($result_respondido) ){	
		$pergunta_respondida[] = $rs_respondido["id_pergunta"];				
	} 	
	
	foreach ($pergunta_obrigatoria as $a => $b){			
		if (array_search($b, $pergunta_respondida)!== FALSE ){			
			// questao preenchida
		}else{
			?><script>
			alert("Faltou preencher questão obrigatória:\n -"+parent.document.getElementById("label_pergunta_"+<?= $b ?>).innerHTML);
            var obj = parent.document.getElementById("pergunta_"+<?= $b ?>);
			if (obj[0]){
				obj[0].focus();
			}else{
				obj.focus();
			}
            </script><?
			exit();
		}
	}
	
	/*  
	  $sql_update = "UPDATE questionarios_x_solicitacoes  as a
					INNER JOIN solicitacoes AS b ON (a.id_solicitacao = b.id_solicitacao AND b.id_empresa = '".$_SESSION["id_empresa_session"]."' AND b.id_solicitacao = '".$id_solicitacao."')
					SET a.data_finalizacao='".date("Y-m-d H:i:s")."'
					WHERE a.id_solicitacao='".$id_solicitacao."' AND a.id_questionario = '".$id_questionario."'
	  ";*/	
	  $sql_update = "UPDATE questionarios_x_solicitacoes SET data_finalizacao='".date("Y-m-d H:i:s")."' WHERE id_solicitacao='".$id_solicitacao."' AND id_questionario = '".$id_questionario."' LIMIT 1;";
	  update_record($sql_update);
	  
	  $sql_update = "UPDATE solicitacoes SET id_situacao=2 WHERE  id_solicitacao='".$id_solicitacao."' LIMIT 1;";
	  update_record($sql_update); 
	  
	   $sql = "INSERT INTO andamentos (id_solicitacao, id_situacao, data_andamento) VALUES ('".$id_solicitacao."' , '2' , '".date("Y-m-d H:i:s")."');";
	   insert_record($sql);
	  
	
	?><script>alert("Questionário Finalizado com Sucesso!");</script><?
	
      echo '<script>	  
			  var myDate = new Date();		  			 
			  var container = parent.parent.window.document.getElementById("Containerquestionario'.$id_solicitacao.'");		  
			  container.style.display =  "none";			 
			  var window_opener = parent.parent.window.document.getElementById("iframe_aerosolicitacoes");
			  window_opener.src = window_opener.src+"&"+myDate.getTime();				 
      </script>'."\n";
}





////////////////////////////////////////////////////////////////////////////////
/////////////////////// check_anexo /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["check_anexo"]){
   
   if (!$id_anexo_avaliacao){
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   		  
		  
	$sql_update = "UPDATE anexos_avaliacao SET visualizado_flag='".utf8_decode($value)."',data_alteracao = '".date("Y-m-d H:i:s")."'  WHERE  id_anexo_avaliacao='".$id_anexo_avaliacao."' LIMIT 1";			
	update_record($sql_update);	  	
}






/////////////////////////////////////////////////////
//////////////////  listar_arquivos /////////////////////
/////////////////////////////////////////////////////
if ($_POST["listar_arquivos"]){
	
	
	if ($id_desafio)
			$add_sql = " id_desafio = '$id_desafio' ";
			
	if ($id_topico)
			$add_sql = " id_topico = '$id_topico' ";

		$sql = "SELECT
				  id_anexo,descricao,caminho_arquivo,arquivo,ordem,data_inclusao
				  FROM anexos
				  WHERE $add_sql AND youtube_link IS NULL
				  ORDER BY ordem ASC
			";	
						
						
	  $arquivos .= ' <tr>
	  	<td class="fundo2">&nbsp;</td>
		 <td  class="fundo2" style="text-align:center;" nowrap>Foto</td>
		 <td class="fundo2" style="text-align:center;"  >Data</td>
		 <td class="fundo2" style="text-align:center;">Ordem</td>
		 <td class="fundo2" style="text-align:center;">Descrição</td>
		 </tr>';
	  
				
						
				  $result = return_query($sql);
				  while( $rs = db_fetch_array($result) ){			
					 $cor = ($x%2 == 0)?'#fff':'#eaeff7';$x++;
					$data_inclusao = ($rs["data_inclusao"])?data_br(substr($rs["data_inclusao"], 0,10)):"";		  
					$hora_inclusao = ($rs["data_inclusao"])?substr($rs["data_inclusao"], 11,5):"";			  
				  $arquivos .= '<tr style="text-align:center;background:'.$cor .'">
				  		<td><img style="cursor:pointer;" onclick="delete_anexo('.$rs["id_anexo"].')"  src="../images/delete.gif"  align="top">
				  		</td>
						<td >			 
						<div class="gallery" style="margin:0px;padding:0px;"   >
						<ul  class="images" style="margin:0px;padding:0px;" > 
						<li class="image" style="margin:0px;padding:0px;" >
						<div style="margin:0px;padding:0px;text-align:center" >				  			
						<a  href="../publico/'.$rs["caminho_arquivo"].$rs["arquivo"].'"  target="_blank" class="fancybox" ><img  src="../publico/'.$rs["caminho_arquivo"].'tb-'.$rs["arquivo"].'" style="width:80px;height:80px;"  align="top"></a>			  
						</div>			 
						</li>
						</ul>
						</div> 		   
						</td>
				  <td >'.$data_inclusao.' '.$hora_inclusao.'</td>
				  <td>
				  
	
	
				  			  <input type="text" style="width:30px"  class="x-form-text x-form-field"  onblur=\'atualiza_conteudo("operacoes.php","update_anexo_ordem=yes&id_anexo='.$rs["id_anexo"].'&value="+ encodeURIComponent(this.value),"POST",handleHttpQuestion)\'  value="'.$rs["ordem"]  .'">
				  
				  
				  </td>
					 
				  <td><textarea rows="4" style="border:1px solid #ccc"  cols="50"   onblur=\'atualiza_conteudo("operacoes.php","update_anexo=yes&id_anexo='.$rs["id_anexo"].'&value="+ encodeURIComponent(this.value),"POST",handleHttpQuestion)\'  >'. $rs["descricao"].'</textarea></td>	
					 
					 </tr>';
			  }
		  
		  
		
		  
		  
	$sql = "SELECT
				  id_anexo,descricao,id_desafio,youtube_link,ordem,data_inclusao
				  FROM anexos
				  WHERE $add_sql  AND  youtube_link IS NOT NULL
				  ORDER BY ordem ASC
			";	
						
						
	  $videos .= ' <tr>
	  	<td class="fundo2">&nbsp;</td>
		 <td  class="fundo2" style="text-align:center;" nowrap>Video</td>
		 <td class="fundo2" style="text-align:center;"  >Data</td>
		 <td class="fundo2" style="text-align:center;">Ordem</td>
		 <td class="fundo2" style="text-align:center;">Descrição</td>
		 </tr>';
	  
				
						
				  $result = return_query($sql);
				  while( $rs = db_fetch_array($result) ){			
					 $cor = ($x%2 == 0)?'#fff':'#eaeff7';$x++;
					$data_inclusao = ($rs["data_inclusao"])?data_br(substr($rs["data_inclusao"], 0,10)):"";		  
					$hora_inclusao = ($rs["data_inclusao"])?substr($rs["data_inclusao"], 11,5):"";			  
				  $videos .= '<tr style="text-align:center;background:'.$cor .'">
				  		<td><img style="cursor:pointer;" onclick="delete_anexo('.$rs["id_anexo"].')"  src="../images/delete.gif"  align="top">
				  		</td>
						<td >			 
						<div class="gallery" style="margin:0px;padding:0px;"   >
						<ul  class="images" style="margin:0px;padding:0px;" > 
						<li class="image" style="margin:0px;padding:0px;" >
						<div style="margin:0px;padding:0px;text-align:center" >				  			
						
						
<object type="application/x-shockwave-flash" style="width:246px; height:142px;" data="https://www.youtube.com/v/'.$rs["youtube_link"].'"  ><param name="movie" value="https://www.youtube.com/v/'.$rs["youtube_link"].'" /></param>
  <param name="wmode" value="transparent"></param><embed src="https://www.youtube.com/v/'.$rs["youtube_link"].'" type="application/x-shockwave-flash" wmode="transparent" width="440" height="260" ></embed>
  </object>
						
						
						</div>			 
						</li>
						</ul>
						</div> 		   
						</td>
				  <td >'.$data_inclusao.' '.$hora_inclusao.'</td>
				  <td>
				  
	
	
				  			  <input type="text" style="width:30px"  class="x-form-text x-form-field"  onblur=\'atualiza_conteudo("operacoes.php","update_anexo_ordem=yes&id_anexo='.$rs["id_anexo"].'&value="+ encodeURIComponent(this.value),"POST",handleHttpQuestion)\'  value="'.$rs["ordem"]  .'">
				  
				  
				  </td>
				  <td><textarea rows="4" style="border:1px solid #ccc"  cols="50"   onblur=\'atualiza_conteudo("operacoes.php","update_anexo=yes&id_anexo='.$rs["id_anexo"].'&value="+ encodeURIComponent(this.value),"POST",handleHttpQuestion)\'  onkeypress="max_area(this,120)" >'. $rs["descricao"].'</textarea></td>		  
					 
					 </tr>';
			  }
		  // wordwrap($rs["descricao"], 25, "<br />\n", true) 
		  
		  echo $arquivos."###ajax_split###".$videos;  
		  
	  
}





////////////////////////////////////////////////////////////////////////////////
/////////////////////// update_anexo /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["update_anexo"]){
	
   if ( !$id_anexo   )   {
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   		 $descricao = utf8_decode($value);
		  /// insert com inner join - somente empresa logada faz inclusao na sua propria solicitacao
		  $sql_update = "UPDATE anexos SET descricao='$descricao' WHERE  id_anexo='$id_anexo'  LIMIT 1;
		  ";
		  update_record($sql_update );	  	
}


////////////////////////////////////////////////////////////////////////////////
/////////////////////// update_anexo_ordem /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["update_anexo_ordem"]){
	
   if ( !$id_anexo   )   {
         echo '<script>alert("Ocorreu algum erro na transação. Tente novamente.");</script>';
         exit();
   }   
   		 $ordem = utf8_decode($value);
		  /// insert com inner join - somente empresa logada faz inclusao na sua propria solicitacao
		  $sql_update = "UPDATE anexos SET ordem='$ordem' WHERE  id_anexo='$id_anexo'  LIMIT 1;
		  ";
		  update_record($sql_update );	  	
}




////////////////////////////////////////////////////////////////////////////////
/////////////////////// delete_anexo /////////////////
////////////////////////////////////////////////////////////////////////////////
if ($_POST["delete_anexo"]){	
 	$sql = "SELECT caminho_arquivo,arquivo FROM anexos WHERE  id_anexo='".$id_anexo."' LIMIT 1;";
	$rs = get_record($sql);		
	$caminho = '../publico/' .$rs["caminho_arquivo"];	
	
	  $sql = "DELETE FROM anexos WHERE  id_anexo='".trim($id_anexo)."'  LIMIT 1";
	 
	 if (delete_record($sql)){
			 @unlink($caminho);	  
			 @unlink($caminho.$rs["arquivo"]);	  
	 }
}



////////////////////////////////////////////////////////////////////////////////
/////////////////////// enviar_contribuicao /////////////////
////////////////////////////////////////////////////////////////////////////////

if ($_POST["enviar_contribuicao"]){
	   
   
   if ($media_flag == 'F'){
	//////////////////////////////////////////////////////////////////////
	//  extrai foto do upload///////////////////////
	////////////////////////////////////////////////////////////////////////
	if (  ($_FILES["foto"]["name"]) && ($_FILES["foto"]['error'] == 0)  ){						
		  $fileName = preg_replace('/[^\w\._]+/', '_', $_FILES["foto"]["name"]); // Clean the fileName for security reasons		
		   $anexo_ext=strtolower(strrchr($fileName,"."));	
		  if (strtolower($anexo_ext) != ".jpg"){
				$mensagem = "- Foto não importada. É permitido apenas fotos na extensão JPG".'\n';						
		  }else{			  
			  	$ano = date("Y");
				$mes = date("m");
				
				//////////////////////////////////
				// Pasta Download
				//////////////////////////////////				
				if(!is_dir("../publico/download")) {
					mkdir("../publico/download", 0755); // 0777 é a permissão/CHMOD = 777
					//echo "Diretório Ano criado com sucesso";
				} else {
					//echo "Diretório Ano não criado porque já existe";
				}				

				//////////////////////////////////
				// Pasta publico/download
				//////////////////////////////////				
				if(!is_dir("../publico/download/".$ano)) {
				  mkdir("../publico/download/".$ano, 0755); // 0777 é a permissão/CHMOD = 777
				  //echo "Diretório Ano criado com sucesso";
				} else {
				  //echo "Diretório Ano não criado porque já existe";
				}				
				
				//////////////////////////////////
				// Pasta Mes
				//////////////////////////////////				
				if(!is_dir("../publico/download/".$ano."/".$mes)) {
				  mkdir("../publico/download/".$ano."/".$mes, 0755); // 0777 é a permissão/CHMOD = 777
				  //echo "Diretório Ano criado com sucesso";
				} else {
				  //echo "Diretório Ano não criado porque já existe";
				}				
				
				chdir("../publico/download/".$ano."/".$mes);
				$diretorio = getcwd(); 		
				
				$anexo_link= date("Y-m-d-H-i-s").substr(md5(uniqid(rand(), true)),0,8).$anexo_ext;					
				$filePath = $diretorio . DIRECTORY_SEPARATOR . $anexo_link;
				
				if(copy($_FILES["foto"]['tmp_name'],$filePath)) {
					// rezise image				
					//DEFINE OS PARÂMETROS DA MINIATURA	
						$thumb_largura = 280;
						$thumb_altura = 180;		
						//CRIA UMA NOVA IMAGEM									
						$imagem_orig = imagecreatefromjpeg($filePath);
						//LARGURA						
						$pontoX = ImagesX($imagem_orig);
						//ALTURA
						$pontoY = ImagesY($imagem_orig);
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
						imagejpeg($imagem_fin, $diretorio . DIRECTORY_SEPARATOR . "tmp".$anexo_link, 80);
						//LIBERA A MEMÓRIA			
						imagedestroy($imagem_orig);
						imagedestroy($imagem_fin);	

						
						//$fp = fopen($diretorio . DIRECTORY_SEPARATOR . "tmp".$anexo_link, 'r');	
						//$imagem_hex = fread($fp, filesize($filePath));		
						
						$image = imagecreatefromjpeg( $diretorio . DIRECTORY_SEPARATOR . "tmp".$anexo_link);
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
						imagejpeg($thumb,  $diretorio . DIRECTORY_SEPARATOR . "thumb".$anexo_link, 80);
						
						$caminho_arquivo = "download/".$ano."/".$mes."/";
						$arquivo = $anexo_link;
					//	@unlink("../publico/download/".$anexo_link);	//foto original
						@unlink($diretorio . DIRECTORY_SEPARATOR . "tmp".$anexo_link); // apaga foto redimensionada temporaria
				}
		  }		  
	  }else{			
		  $upload_errors = array( 
			  UPLOAD_ERR_OK        => "No errors.", 
			  UPLOAD_ERR_INI_SIZE    => "Larger than upload_max_filesize.", 
			  UPLOAD_ERR_FORM_SIZE    => "Larger than form MAX_FILE_SIZE.", 
			  UPLOAD_ERR_PARTIAL    => "Partial upload.", 
			  UPLOAD_ERR_NO_FILE        => "Arquivo não Selecionado.", 
			  UPLOAD_ERR_NO_TMP_DIR    => "No temporary directory.", 
			  UPLOAD_ERR_CANT_WRITE    => "Can't write to disk.", 
			  UPLOAD_ERR_EXTENSION     => "File upload stopped by extension.", 
			  UPLOAD_ERR_EMPTY        => "File is empty." // add this to avoid an offset 
			); 			
		  $mensagem = "- Foto não importada. Motivo: ".$upload_errors[$_FILES["foto"]['error']].'\n';	
	  } 
	  if ( $mensagem){
		   echo '<script>		 
			   alert("'.$mensagem.'");					
			   </script>';  
		  exit();
	  }
	//////////////////////////////////////////////////////////////////////////////////////////  
   }
   
	if($fase_atual == '4'){
		$fase_titulo = "Execução";
	}
      $sql = "INSERT INTO contribuicoes (nome_contribuicao, media_flag, youtube_link, id_participante, id_fase, id_desafio, data_inclusao, descricao, aprovado, caminho_arquivo, arquivo) VALUES (".noempty($nome_contribuicao).", ".noempty($media_flag).",  ".noempty($youtube_link).", ".noempty($id_participante).", '4', ".noempty($id_desafio).", '".date("Y-m-d H:i:s")."','".safe_text($descricao)."','S',".noempty($caminho_arquivo).",".noempty($arquivo).");  ";
	
  if (insert_record($sql)){
	      echo '<script>';	
	      if ($media_flag == 'V'){
			  echo 'parent.remove_youtube_desafio('.$id_desafio.');';
		  }	   
		 echo '	 	
		 parent.parent.showSuccessToast("'.$fase_titulo.' cadastrada com sucesso. Agradecemos por sua participação");
		 parent.limpa_form(parent.document.form1);	
		 parent.close_aerowindow("incluir_execucao","execucao")	
		 </script>';  
  }   

	//echo $Html;
}
?>


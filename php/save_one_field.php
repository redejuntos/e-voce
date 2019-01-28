<? 
session_start();
require_once ("../php/connections/connections.php");	
require_once ("./funcoes.php");			

////////////////////////////
//VERIFICAÇÃO DE SEGURANÇA//
////////////////////////////
verifica_seguranca();

include_once("./class_relationship_restrition.php");//define os relacionamentos das tabelas
$class_relationship_restrition = new relationship_restrition;


foreach($_POST as $a => $b){
//echo "$".$a."=\"".$b."\";"."<br>";
eval ("$".$a."=\"".$b."\";");
}


foreach($_GET as $a => $b){
//echo "$".$a."=\"".$b."\";"."<br>";
eval ("$".$a."=\"".$b."\";");
}
/*
// verifica se categoria já existe ----------------------------------
if($class_relationship_restrition -> in_table('categoria') ){
	 $sql="select cod_categoria from categoria where cod_categoria='".$cod_categoria."'";
	 if (get_record($sql)){
	    $mensagem = "Não foi possível realizar essa operação, essa categoria já existe, digite outra!<br>";
		$erro=1;
	 } 
}
// verifica se login já existe ----------------------------------
if($class_relationship_restrition -> in_table('usuario') ){
	 $sql="select login from usuarios where login='".$login."'";
	 if (get_record($sql)){
	    $mensagem = "Não foi possível realizar essa operação, esse login já existe, digite outro!<br>";
		$erro=1;
	 } 
}
// verifica se subcategoria já existe ----------------------------------
if($class_relationship_restrition -> in_table('subcategoria') ){
	 $sql="select cod_categoria from subcategoria where cod_categoria='".$cod_categoria."' and cod_subcategoria='".$cod_subcategoria."'";
	 if (get_record($sql)){
	    $mensagem = "Não foi possível realizar essa operação, essa subcategoria já existe, digite outra!<br>";
		$erro=1;
	 } 
}
*/
if (!$erro){
	$fields_value_vetor=split(",",$fields_value);
	$sql = "insert into ".$_SESSION["table"]."  (".$fields_value.") values (";
for ($x=0;$x<count($fields_value_vetor);$x++){

		switch ($fields_value_vetor[$x]){	
			case 'senha':
				$sql .= "'".md5($senha)."'";
				if ($x < intval(count($fields_value_vetor)-1)){$sql .= ",";}	
				break;		
			case '':
	
			default:
				$sql .= "'";										
					eval('$sql .= '."$".$fields_value_vetor[$x].";");					
				if ($x < intval(count($fields_value_vetor)-1)){$sql .= "',";}
				break;		
		}		
}
	if ($fields_value_vetor[intval(count($fields_value_vetor)-1)] == "senha"){
		$sql .= ")";	
	}else{
		$sql .= "')";	
	}
	insert_record($sql);	

// insere uma copia da primary key no campo ID
//	if($class_relationship_restrition -> add_copy_ID()){
		//$ID=strval(mysql_insert_id());
		//$sql = "UPDATE ".$_SESSION["table"]." SET ID=".$ID." WHERE ".						$class_relationship_restrition ->field_primary_key()."=".$ID."";			
		//insert_record($sql);
//	}

/*
if($class_relationship_restrition -> in_button_extends() ){
$ID=strval(mysql_insert_id());
$cod_licitacao="cod".$ID;
$sql = "UPDATE t_licitacoes SET cod_licitacao='".$cod_licitacao."' WHERE ID='".$ID."'";			
insert_record($sql);	
}

*/


/*
// insere um registro do login que é FK na tabela filha
if($class_relationship_restrition -> add_new_user() ){
$sql = "insert into t_licitacoes_users_detail (login) values ('$login')";	
insert_record($sql);	
}
*/


$mensagem = $mensagem."O registro ".$tipo." foi cadastrado(a) com sucesso!<br>";


} //fim $erro
?>
<script src="../js/functions.js" type="text/javascript"></script>
<script src="../js/functions_form_validation.js" type="text/javascript"></script>
<?
/*
 if ($_SESSION["table"]=="t_licitacoes_type"){ // somente para talela t_licitacoes_type
echo '<SCRIPT>refresh_menu();</SCRIPT>';
}
*/

?>
<BODY onLoad="document.redirect.submit();">
 <form name="redirect" method="post" action="listar.php?table=<?= $_SESSION["table"] ?>&titulo=<?= $_GET["titulo"] ?>&order=<?= $_GET["order"] ?><? if($class_relationship_restrition -> in_button_extends()){echo "&licitacoes=yes";} ?> 	" >
<input type="hidden" name="mensagem" value="<?=$mensagem?>" />
</form>
</body>
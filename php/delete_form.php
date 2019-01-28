<? 
session_start();
require_once ("./connections/connections.php");		
require_once ("./funcoes.php");			

////////////////////////////
//VERIFICA��O DE SEGURAN�A//
////////////////////////////
verifica_seguranca();
?>
<script src="../js/functions.js" type="text/javascript"></script>
<script src="../js/functions_form_validation.js" type="text/javascript"></script>
<?

include("./class_relationship_restrition.php");//define os relacionamentos das tabelas
$class_relationship_restrition = new relationship_restrition;

foreach($_GET as $a => $b){
//echo "$".$a."=\"".$b."\";"."<br>";
is_array($b)? "":$$a = $b;
}

if($table =='usuarios'){	
	$sql = "UPDATE ".$table." SET data_cancelamento='".date("Y-m-d H:i:s")."' where ".$primary_key."='".$campo_1."' ";	
	
	/*echo '<script>alert("'.$sql.'");</script>';*/
			
	$mensagem="Usu�rio cancelado com sucesso";
	update_record($sql);
	$erro=1;	
	echo '<script>				
			window.parent.parent.document.forms[0].reset();
			parent.parent.document.getElementById("viagem_info").innerHTML="";			
		</script>'."\n";
		
	insert_log("update_tabela",$sql,$table);
}


if (!$erro){
	

		$sql = "delete from ".$table." where (".$primary_key."='".$campo_1."') ";				
		
		
		delete_record($sql);	
		$mensagem="Registro exclu�do com sucesso";
}

		insert_log("delete_tabela",$sql,$table);



echo '<script>					
		alert("'.$mensagem.'");		
	</script>'."\n";
		


?>

<script>
         if (document.all)
            window.parent.location.reload();
         else
            window.parent.location.href = window.parent.location.href;
</script>



<?


?>
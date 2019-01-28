<? 
session_start();
require_once ("./connections/connections.php");	
require_once ("./funcoes.php");			


// ----------------- no cache----------------------------
$gmtDate = gmdate("D, d M Y H:i:s");
@header("Expires: {$gmtDate} GMT");
@header("Last-Modified: {$gmtDate} GMT"); 
@header("Cache-Control: no-cache, must-revalidate"); 
@header("Pragma: no-cache"); 




////////////////////////////
//VERIFICA��O DE SEGURAN�A//
////////////////////////////
verifica_seguranca();

include("./class_relationship_restrition.php");//define os relacionamentos das tabelas

$class_relationship_restrition = new relationship_restrition;


// define dados para acessar o BD
  	$connect = new DBConnect;
  	
  	// This config is needed only for save_form.php
	$server     = DBConnect::host;
	$user       = DBConnect::user;
	$password   = DBConnect::passwd;
	$database   = DBConnect::database_name; 

// Some PHP and Javascript, to save the changes to the database
?><html>
<head>
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<title></title>
</head>
<body><?

$id    = $_REQUEST["id"];
$value = $_REQUEST["value"];
$valor_antigo = $_REQUEST["valor_antigo"];

$value = valida_SQL_injection($value);

$id    = ereg_replace("_new","",$id);

list ($id_name,$span_id,$db_field,$tabela,$database,$feldtyp) = split ('[,]', $id);



$tabela = table_alias($tabela);



$sql = "SELECT * FROM $tabela WHERE $id_name='$span_id'  ";

$result = return_query($sql);

$anz = numrows($sql);
 
		echo $id;

		
 
if($anz > 0){
	
// verifica se essa tabela pode ser atualizada----------------------------------



if ($erro){
	echo '<script>	
	alert("'.$msg_erro.'. Por favor, digite novamente");
	var val = "'.$valor_antigo.'";
	var id  = "'.$id.'";
	var fr = top.frames.length;
	if(fr > 1){
		var doc = window.parent.document;
	} else {
		var doc = window.parent.document;
	}			
	doc.getElementById(id).innerHTML=val; 	
	</script>';	
	exit();
}

	$string = db_result($result, 0, "$db_field");
	
	

		
		
		if ($value == ""){
			$sql = "UPDATE $tabela SET $db_field= NULL WHERE ($id_name='$span_id')   ";		
		}else{
			$sql = "UPDATE $tabela SET $db_field='$value' WHERE ($id_name='$span_id')   ";
		}
		
		if($db_field=="aprovado"){		
  				if (trim($value) == "N"){ // reprova inspira��o enviada
						switch ($tabela){
							case 'inspiracoes':
								  echo "<script>
								  parent.parent.openAeroWindow('envia_email".$span_id."',80,'center',750,450,'','./php/telas.php?go_to_page=envia_email&id_contribuicao=".$span_id."');
								  </script>";
							break;								
							////////////////////////////////////////////////////////////////////////////// 
							case 'comentarios':
								  echo "<script>
								  parent.parent.openAeroWindow('envia_email_comentario".$span_id."',80,'center',750,450,'','./php/telas.php?go_to_page=envia_email&id_comentario=".$span_id."');
								  </script>";
							break;	
							////////////////////////////////////////////////////////////////////////////// 
							case 'propostas':
								  echo "<script>
								  parent.parent.openAeroWindow('envia_email_proposta".$span_id."',80,'center',750,450,'','./php/telas.php?go_to_page=envia_email&id_proposta=".$span_id."');
								  </script>";
							break;	
							////////////////////////////////////////////////////////////////////////////// 		
					    }	   
				}
  				if (trim($value) == "S"){ // reprova inspira��o enviada
						switch ($tabela){
							case 'inspiracoes':
								  echo "<script>
								  parent.parent.openAeroWindow('envia_email_aprovado".$span_id."',80,'center',750,450,'','./php/telas.php?go_to_page=envia_email&aprovado=1&id_contribuicao=".$span_id."');
								  </script>";
							break;
							////////////////////////////////////////////////////////////////////////////// 	
							////////////////////////////////////////////////////////////////////////////// 
							case 'propostas':
								  echo "<script>
								  parent.parent.openAeroWindow('envia_email_aprovado".$span_id."',80,'center',750,450,'','./php/telas.php?go_to_page=envia_email&aprovado=1&id_proposta=".$span_id."');
								  </script>";
							break;	
							////////////////////////////////////////////////////////////////////////////// 	
					    }	   
				}
		}
		
		
		if($db_field=="selecionado"){		
  				if (trim($value) == "S"){ // reprova inspira��o enviada
						switch ($tabela){
							case 'propostas':
								  echo "<script>
								  parent.parent.openAeroWindow('',80,'center',300,100,'','./php/telas.php?go_to_page=copiar_proposta&id_contribuicao=".$span_id."');
								  </script>";
							break;	
							case 'contribuicoes':
								  echo "<script>
								  parent.parent.openAeroWindow('',80,'center',300,100,'','./php/telas.php?go_to_page=copiar_contribuicao&id_contribuicao=".$span_id."');
								  </script>";
							break;	
							default:								
							break;				
					    }						
				}
		}
		
		if($db_field=="proposta"){		
  				if (trim($value) == "S"){ //inspira��o enviada
						switch ($tabela){
							case 'contribuicoes':
								  echo "<script>
								  parent.parent.openAeroWindow('',80,'center',300,100,'','./php/telas.php?go_to_page=copiar_para_proposta&id_contribuicao=".$span_id."');
								  </script>";
								  
								  
							break;	
							default:								
							break;				
					    }						
				}else{
  							echo "<script>
								  alert('N�o � poss�vel desfazer a c�pia j� feita anteriormente');
								  </script>";
				}
				$sql = "UPDATE $tabela SET selecionado='$value' WHERE ($id_name='$span_id')   ";
		}
		
		
		
		if($db_field=="ativado"){			
			  if (trim($value) == ""){ // ativa a solicitac�o			  
					switch ($tabela){
							case 'solicitacoes':			
							break;				
							case 'agendamentos':								////////////////////////////////////////////////////////////////////////////// 							
							break;
							default:
								   $sql = "UPDATE $tabela SET data_cancelamento = NULL WHERE ($id_name='$span_id')   ";
								   $info = "Ativa��o de Registro";
							break;				
					}	                                                   
			  }else{		// cancela a solicia��o
					switch ($tabela){
							case 'agendamentos':							
							break;
							default:
								  $modified = date("Y-m-d H:i:s");				  
								  $sql = "UPDATE $tabela SET data_cancelamento='".$modified."' WHERE ($id_name='$span_id')   ";
								  $info = "Desativa��o de Registro";				  
								  $modified = data_br(substr($modified,0,10))." ".substr($modified,11,8);	
							break;	
					}
			  }
		}
		
		

		update_record($sql);

		insert_log("update_tabela",$sql,$info."<br>Tabela: ".$tabela." <br>Valor: ".$value);

		$anz = db_affected_rows($result);
		
		if($anz <= 0) $font_color = "#FF0000";		
		else{
			$pfx = "<u>";
			$pfx1 = "</u>";
			$font_color = "#000000";			
		}
		
		
		
		
		
		
		
		
		
		
		
		
	
	
} else 
	$anz = 0;	
$sql = "SELECT * FROM $tabela WHERE $id_name='$span_id'  ";



	
$sql .= "limit 1";


	
$result = return_query($sql);
$value = db_result($result, 0, "$db_field");
$id2=str_replace($db_field,'data_cancelamento',$id);


		

?><script language="javascript">
//alert('<? //echo $modified ?>');
	var id  = '<? echo $id ?>';
	
	
	
	
	
	<? if ($db_field == "ativado"){ ?>
	var id2  = '<? echo $id2 ?>';
	var val2 = '<? echo $modified ?>';
	<? } ?>
	var val = '<? echo $value ?>';

	
	var fr = top.frames.length;
	if(fr > 1){		
		if (document.all) {//IE				
			//var doc = top.document.frames[1].document;
			var doc = window.parent.document;
			
		}else{ //Firefox
			//var doc = parent.top.conteudo.document;
			var doc = window.parent.document;
		}	
	} else {
		var doc = top.document;
	}
	
	
	<? if ($_GET["tipo"] != "save_combo"){	
	echo 'doc.getElementById(id).innerHTML=val;'; 	
	}
	?>
	<?
	
	if ($db_field == "ativado"){ 
	echo '
	var doc = window.parent.document;
	if (doc.getElementById(id2)) doc.getElementById(id2).innerHTML=val2;
	
	'; 
	} 
	
	if ($db_field == "id_situacao"){ 
	
	$data_inclusao = get_data_inclusao_solicitacao($span_id);
	$andamento = get_andamento_icone($span_id,$data_inclusao,'');
	echo '
	var doc = window.parent.document;
	if (doc.getElementById("count_'.$span_id.'")) {
		doc.getElementById("count_'.$span_id.'").innerHTML=\''.str_replace("'","\'",$andamento).'\';
	}	
	
	   parent.$(\'a.title\').cluetip({splitTitle: \'|\'});
	'; 
	} 

	
	?>
	
	
</script>
</body>
</html>
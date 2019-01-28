
<?
// --------------------------------------------
// return data to db with ajax
// ---------------------------------------------
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT"); 
@header("Last-Modified: {$gmtDate} GMT"); 
@header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 

ini_set("display_errors", "0"); //Retira o Warning

ini_set( 'error_reporting', E_ALL ^ (E_NOTICE | E_DEPRECATED) ); // mostra todas mensagens exceto notice e deprecated
ini_set( 'display_errors', '1' );

session_start();


require_once ("./connections/connections.php");	
require_once ("./funcoes.php");	



foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):valida_SQL_injection($b);
		  
		  




//-----------------------------------------------------------------------------------
if ($_GET["cod_estado"]){
	$conn = db_connect(); 
	$cod_estado = addslashes($_GET["cod_estado"]); // pegamos o id passado pelo select
	 $sql = "select distinct id_municipio,nome_municipio from municipios 
	 		where uf = '".$cod_estado."'
	 		order by nome_municipio";	
			
	 $result=return_query($sql);	
	 while( $rs = db_fetch_array($result) ){ 
		 echo strtoupper(trim($rs["nome_municipio"]))."|".trim($rs["id_municipio"]).  ","; // apresentamos cada subcategoria dessa forma "NOME|CODIGO,NOME|CODIGO,NOME|CODIGO,...", exatamente da maneira que iremos tratar no JavaScript
	 }

}




//-----------------------------------------------------------------------------------
if ($_POST["get_avatar"]){
	 $sql = "SELECT  avatar FROM participantes   WHERE  id_participante='".$_SESSION["id_participante_session"]."' LIMIT 1;";				
	 if ($rs = get_record($sql)){	
 			echo $rs["avatar"];
	 }

}





//-----------------------------------------------------------------------------------
if ($_POST["get_coments"]){
	echo $id_contribuicao."##ajax_split##";
	show_coments($_SESSION["imagem_avatar"],$id_contribuicao,$read_only); 
}




////////////////////////////////////////////////////////////////////////////////
/////////////////////// add_curtir /////////////////
////////////////////////////////////////////////////////////////////////////////

if ($_POST["add_curtir"]){
	
   if ( !$_SESSION["id_participante_session"] )   {
		 echo '<script>
		 
		 alert("Para realizar essa operação é preciso primeiro estar logado no sistema");
		  setTimeout(function() { 
				  parent.$( "#login-side" ).animate({
						top: "130px"					
				  }, 500 );
		}, 1000);	
		  
		 
		 
		 </script>';	
         exit();		 
   }   
   
   
  $sql_check = "select id_curtir  from curtidas where id_contribuicao = ".noempty($id_contribuicao)." and id_participante = ".noempty($_SESSION["id_participante_session"]);
  
  
	switch ($fase_atual){
		case 1:
		 $msg = "curtiu essa inspiração";
		 break;
		case 2:
		 $msg = "curtiu essa proposta";
		 break;
		case 3:
		 $msg = "votou nessa proposta";
		 break;
		case 4:
		 $msg = "curtiu essa execução";		
		  break;
		default:
		 $msg = "";
		 break;				
	}	
  
  
   
   if (get_record($sql_check)){ // ainda nao curtido		   
				 echo '<script>		 
						 parent.showWarningToast("Você já '.$msg.'. Agradecemos por sua participação");					
				 </script>';  
   }else{
			  $sql = "INSERT INTO curtidas (id_contribuicao, id_participante, data_inclusao) VALUES ( ".noempty($id_contribuicao).", ".noempty($_SESSION["id_participante_session"]).",'".date("Y-m-d H:i:s")."');";
		   if (insert_record($sql)){
				 echo '<script>		 
						 parent.showSuccessToast("Você '.$msg.'. Agradecemos por sua participação");
						 parent.document.getElementById("contador_curtidas'.$id_contribuicao.'").innerHTML = parseInt(parent.document.getElementById("contador_curtidas'.$id_contribuicao.'").innerHTML)+1;					 
						 var obj = parent.document.getElementById("curtido_icone'.$id_contribuicao.'");
						 obj.src="images/tick.png";
						 obj.parentNode.className="curtido";
						 
				 </script>';  
		   }   
   }
	
}

?>

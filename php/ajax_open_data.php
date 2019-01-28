
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

////////////////////////////
//VERIFICA��O DE SEGURAN�A//
////////////////////////////
verifica_seguranca();

//echo "---------GET---------<br>";
//foreach ($_GET as $a => $b){
//is_array($b)? "":$$a = valida_SQL_injection($b);
//echo $a."=".$$a."<br>";
//}

foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):valida_SQL_injection($b);
		  
		  

if ($_GET["busca_cep"]){	
	$sql = "select  tipo_logradouro,nome,bairro_nome,cod_logradouro from logradouro where cep = '".$_GET["cep"]."' ";
	
		if($rs = get_record($sql) ){
			echo $rs["nome"]."#split#".$rs["bairro_nome"]."#split#".$rs["tipo_logradouro"]."#split#".$rs["cod_logradouro"];	
		}else{
			echo "#split#";	
		}
}		


//########################################################################################
//--------------------------------busca_cpf_cnpj--------------------------------------
//########################################################################################


if ($_GET["busca_cpf_cnpj"]){	
	
}	








//-----------------------------------------------------------------------------------
if ($_GET["cod_regiao"]){
	$conn = db_connect();    
	$cod_regiao = addslashes($_GET["cod_regiao"]); // pegamos o id passado pelo select
	$consulta = mysql_query("select nome,cod_bairro from bairro where regiao = '".$cod_regiao."' order by nome, distrito;",$conn); // selecionamos todas as subcategorias que pertencem � categoria selecionada
	while( $row = mysql_fetch_assoc($consulta) )
	{
	echo $row["nome"] . "|" . $row["cod_bairro"] . ","; // apresentamos cada subcategoria dessa forma "NOME|CODIGO,NOME|CODIGO,NOME|CODIGO,...", exatamente da maneira que iremos tratar no JavaScript
	}
}
//-------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------
if ($_GET["cod_bairro"]){
	$conn = db_connect();    
	$cod_bairro = addslashes($_GET["cod_bairro"]); // pegamos o id passado pelo select
	
	$sql = "select a.cod_logradouro,a.cep,a.tipo_logradouro,a.nome from logradouro a,bairro b where upper(a.bairro_nome) = upper(b.nome) and b.cod_bairro='".$cod_bairro."' order by a.tipo_logradouro,a.nome;";
	$consulta = mysql_query($sql,$conn); 	
	  
	while( $row = mysql_fetch_assoc($consulta) )
	{
	echo $row["tipo_logradouro"]." ".$row["nome"] . " CEP ( ".$row["cep"]." )". "|" . $row["cod_logradouro"] . ","; 
	}
}
//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------

if ($_GET["relatorio_filtro_login"]){	
		$_SESSION["relatorio_filtro_login"] = $id_usuario;
		
		echo '<script>	
			if (document.all) 
				window.parent.location.reload();
			else
				window.parent.location.href = window.parent.location.href;				
		</script>';
}

//-----------------------------------------------------------------------------------


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



////////////////////////////////////////////////////////////////////////////////
/////////////////////// cadastro_senha /////////////////
////////////////////////////////////////////////////////////////////////////////


if ($_GET["cadastro_senha"]){
	// define dados para acessar o BD
	
   
}



?>

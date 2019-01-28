<?php
$gmtDate = gmdate("D, d M Y H:i:s");header("Expires: {$gmtDate} GMT"); @header("Last-Modified: {$gmtDate} GMT"); 
@header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 


$q = strtolower($_GET["q"]);
if (!$q) return;


$items[] = array();
require_once ("./connections/connections.php");		
require_once ("./funcoes.php");			

$sql = "select  bairro_nome,cep,nome,tipo_logradouro,cod_logradouro from logradouro where  nome like '%".$q."%' limit 20";

$result=return_query($sql);	
		while( $rs = mysql_fetch_array($result) ){
			echo $rs["nome"]."|".$rs["cep"]."|".$rs["bairro_nome"]."|".$rs["tipo_logradouro"]."|".$rs["cod_logradouro"]."\n";	
		}
?>
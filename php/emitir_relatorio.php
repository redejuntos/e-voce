<? 
session_start();
// ----------------- no cache----------------------------
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT"); 
@header("Last-Modified: {$gmtDate} GMT"); 
@header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 

require_once ("./connections/connections.php");	
require_once ("./funcoes.php");	
require_once ("./class.php");	


renew_timeout();
////////////////////////////
//VERIFICAÇÃO DE SEGURANÇA//
////////////////////////////


//foreach ($_REQUEST as $a => $b){
	//echo $a."=".$b."<br>";
//}



foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	









?>
<title>Relatórios</title>
<center>
<iframe src="multidepthpie.php?data_inicio=<?= $data_inicio ?>&data_fim=<?= $data_fim ?>" width="600" height="400" frameborder="0"></iframe>
</center>
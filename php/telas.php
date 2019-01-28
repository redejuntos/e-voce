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
require_once ("./datagrid.class.php"); 
require_once ("./class.php");
if (DBConnect::database=="postgresql") 
	require_once ("./fundaDB_pg.class.php");			

renew_timeout();
////////////////////////////
//VERIFICAÇÃO DE SEGURANÇA//
////////////////////////////


verifica_seguranca();


 switch ($_GET ["go_to_page"]){	 		 
	case "bem_vindo":					
		break;	 
	default:							
		//comprimir_PHP_start();
		$layout = new layout;
		$layout -> cabecalho();
		$layout -> css('..');	
		$layout -> js('..');
		$layout -> jquery('..');
		$layout -> aeroWindow('..');
		$layout -> datepicker('..');
		$layout -> clueTip('..');	
		$layout -> fancybox('..');
		$layout -> toastmessage('..');

		//$layout -> bootstrap('..');		
		
		//$layout -> spryTabbedPanels('..');
		
		
		//$layout -> thickbox('..');
		include ("./telas/". $_GET ["go_to_page"] .".php");// vai para pagina interna do site
		//comprimir_PHP_finish();
		break;	
 }	


?>

	


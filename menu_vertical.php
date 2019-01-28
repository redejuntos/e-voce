<?
// --------------------------------------------
// return data to db with ajax
// ---------------------------------------------


//ini_set("display_errors", "0"); //Retira o Warning

ini_set( 'error_reporting', E_ALL ^ (E_NOTICE | E_DEPRECATED) ); // mostra todas mensagens exceto notice e deprecated
ini_set( 'display_errors', '1' );

session_start();

require_once ("./php/connections/connections.php");
require_once ("./php/funcoes.php");	
require_once ("./php/class.php");	


////////////////////////////
//VERIFICAÇÃO DE SEGURANÇA//
/////////////////////////

verifica_seguranca();

//echo "---------GET---------<br>";
foreach ($_GET as $a => $b){
is_array($b)? "":$$a = valida_SQL_injection($b);
//echo $a."=".$$a."<br>";
}

////////////////////////////////////////////////////////////////////////////////
/////////////////////// refresh_menu /////////////////
////////////////////////////////////////////////////////////////////////////////
$menu_vetor = verifica_acesso('','',1,'');
$menu_vetor[] = "";
	

			$menu = new menu;			
			$menu -> menu_inicio();	 
			for($w=0;$w<count($_SESSION["menu_item"]["item"]);$w++){
				$aux = $_SESSION["menu_item"]["item"][$w];	
				$menu -> title_item($w,$aux,count($_SESSION["menu_item"][retirar_acentos($aux)]["titulo"]));	
				for($x=0;$x<count($_SESSION["menu_item"][retirar_acentos($aux)]["titulo"]);$x++){
					if (in_array($_SESSION["menu_item"][retirar_acentos($aux)]["permission"][$x], $menu_vetor )) {
						$titulo = $_SESSION["menu_item"][retirar_acentos($aux)]["titulo"][$x];
						$menu -> item($titulo,$aux.$x,$_SESSION["menu_item"][retirar_acentos($aux)]["onclick"][$x]); // $nome,$nome_seq,onclick_javascript		
						////////////////  sub-item /////////////////////////				
							$h=0;
							for($h=0;$h<count($_SESSION["menu_subitem"][retirar_acentos($aux)][$titulo]["titulo"]);$h++){	
								if ($h == 0)  $menu ->sub_item_header();
									if (in_array($_SESSION["menu_subitem"][retirar_acentos($aux)][$titulo]["permission"][$h], $menu_vetor )) {
										$subtitulo = $_SESSION["menu_subitem"][retirar_acentos($aux)][$titulo]["titulo"][$h];
										if ($subtitulo){																								
											  $menu -> sub_item($subtitulo,$_SESSION["menu_subitem"][retirar_acentos($aux)][$titulo]["onclick"][$h]); // $nome,onclick_javascript	
										}
									}									
							}	
							if ($h != 0)  $menu ->sub_item_bottom();
						////////////////////////////////////////////////////
					}
				}
				$menu -> fim_title_item();
			}		
			$menu -> menu_fim();
	
	?>
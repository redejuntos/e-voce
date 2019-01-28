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
	
echo '<ul id="lista_menu_horizontal" class="sf-menu sf-js-enabled sf-shadow" style="text-align:center"  >';
$menu_vetor = verifica_acesso('','',1,'');

$menu_vetor[] = "";

for($w=0;$w<count($_SESSION["menu_item"]["item"]);$w++){
	$aux = $_SESSION["menu_item"]["item"][$w];		
	echo '<li><a href="#" class="sf-with-ul">'.str_replace("_"," ",$aux).'</a><ul >';	
	for($x=0;$x<count($_SESSION["menu_item"][retirar_acentos($aux)]["titulo"]);$x++){		
		if (in_array($_SESSION["menu_item"][retirar_acentos($aux)]["permission"][$x], $menu_vetor )) {
			$titulo = $_SESSION["menu_item"][retirar_acentos($aux)]["titulo"][$x];
			echo '<li><a href="#"  onclick="'.$_SESSION["menu_item"][retirar_acentos($aux)]["onclick"][$x].'">'.$titulo.'</a>';
			////////////////  sub-item /////////////////////////			
				$h=0;
				for($h=0;$h<count($_SESSION["menu_subitem"][retirar_acentos($aux)][$titulo]["titulo"]);$h++){
						if ($h == 0)  echo '<ul>';	
						if (in_array($_SESSION["menu_subitem"][retirar_acentos($aux)][$titulo]["permission"][$h], $menu_vetor )) {
							$subtitulo = $_SESSION["menu_subitem"][retirar_acentos($aux)][$titulo]["titulo"][$h];
							if ($subtitulo){
								  echo '<li><a href="#"  onclick="'.$_SESSION["menu_subitem"][retirar_acentos($aux)][$titulo]["onclick"][$h].'">'.$subtitulo.'</a>';			
								  echo '</li>';
							}
						}						
				}	
				if ($h != 0)  echo '</ul>';
			////////////////////////////////////////////////////	  
			echo '</li>';
		}
	}		
	echo '</ul></li>';
}	
echo '</ul>';




	
	?>
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
require_once ("./class_fpdf.php");	
require_once ("./class.php");	
require_once ("./datagrid.class.php"); 

renew_timeout();
////////////////////////////
//VERIFICAÇÃO DE SEGURANÇA//
////////////////////////////


//foreach ($_REQUEST as $a => $b){
	//echo $a."=".$b."<br>";
//}

$class_table_variables = new table_variables;
$class_table_variables -> overload_tables ($_POST["table"]);  //perde a sessão aqui




foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	

$matrix_data = unserialize(urldecode($_POST["matrix_data"])) ;

verifica_seguranca();

$data = array();		
foreach($matrix_data as $a => $b){	
  $itens = array();
  foreach($b as $c => $d){
	  $itens[]= htmlspecialchars_decode( utf8_decode($d));			
  }			
  array_shift($itens);
  array_shift($itens);						
  $data[] = $itens;
}	
$header = array();
  foreach($data[0] as $header_field){
	  $header[] =  $header_field;			
  }
array_shift($data);  	
$cell_width = array();
for ($x=0;$x<count($header);$x++){	
   $cell_width[$x] =  282.5/count($header);		  
} 		




	switch ($tipo){
		case "excel":
					header("Content-type: application/vnd.ms-excel"); 
					header("Content-type: application/force-download");
					header("Content-Disposition: attachment; filename=relatorio_".date("d_m_Y").".xls");
					header("Pragma: no-cache");  
					echo'
						<style>
						th{
							border: 1px solid #cccccc;
							background-color:#15428B;
							color:#ffffff;
							font-weight:bolod;
							font-size:14px;						
						}
						#rel_html td{
							border-right: 1px solid #15428B;		
							border-left: 1px solid #15428B;
							border-bottom: 1px solid #dddddd;
							padding:3px;
						}
						#rel_html {
							border-bottom: 1px solid #15428B;						
						}						
						</style>
						';
					
					relatorio_header('http://www.ima.sp.gov.br/sites/all/themes/ima/images/brasao.png');		
					echo '<table  style="width:100%;font-size:10px;" cellpadding="0" cellspacing="0" id="rel_html">';
					echo '<tr>';
					foreach($header as $row){
						echo '<th>'.$row.'</th>';
					}
					echo '</tr>';	
				
					
					foreach($data as $row){
						$cor = ($count % 2 == 0)?"#eaeaf0":"#ffffff";
						echo '<tr bgcolor="'.$cor.'">';
					    foreach ($row as $field){			  
							 echo '<td>'.$field.'</td>';			
					    }
						echo '</tr>';	
						$count++;
					}
					echo '<tr>';
					for ($h=0;$h <count($header);$h++) echo'<td></td>';
					echo'</tr>';
					echo '</table>';
		 break;
		 case "csv":
					define ("DELIMITADOR", ";");                 // delimitador de campo para ser usado na exportação
					define ("NOME_ARQ","relatorio_csv_".date("d_m_Y_H_i_s").".csv");  // nome do arquivo que será sugerido para o usuario salvar (janela download)							
					header("Content-type: application/csv");
					header("Content-type: application/force-download");
					header("Content-Disposition: attachment; filename=".NOME_ARQ);
					$linha = "";				
					for($x=0;$x<count($header);$x++){
						$linha .= $header[$x];						
						if ($x <  count($header)-1){
							$linha .= DELIMITADOR;
						}else{
							$linha .= "\r\n";
						}
					}
					echo $linha;$linha = "";
					
					foreach($data as $row){
						for($y=0;$y<count($row);$y++){				
							$linha .=  $row[$y];							
							if ($y <  count($row)-1){
								$linha .= DELIMITADOR;
							}else{
								$linha .= "\r\n";
							}
						}
					}
					echo $linha;
		 break;
		 case "txt":
					define ("DELIMITADOR", "	");                 // delimitador de campo para ser usado na exportação
					define ("NOME_ARQ","relatorio_txt_".date("d_m_Y_H_i_s").".txt");  // nome do arquivo que será sugerido para o usuario salvar (janela download)						
					header('Content-type: application/txt');
					header("Content-type: application/force-download");
					header('Content-Disposition: attachment; filename="relatorio_txt_'.date("d_m_Y_H_i_s").'.txt"');
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");     // always modified
					header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
					header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					$linha = "";				
					for($x=0;$x<count($header);$x++){
						$linha .= $header[$x];						
						if ($x <  count($header)-1){
							$linha .= DELIMITADOR;
						}else{
							$linha .= "\r\n";
						}
					}
					echo $linha;$linha = "";
					
					foreach($data as $row){
						for($y=0;$y<count($row);$y++){				
							$linha .=  $row[$y];							
							if ($y <  count($row)-1){
								$linha .= DELIMITADOR;
							}else{
								$linha .= "\r\n";
							}
						}
					}
					echo $linha;
		 break;
		 case "xml":					
					// abrindo o documento XML
					header('Content-type: application/xml');
					header("Content-type: application/force-download");
					header('Content-Disposition: attachment; filename="relatorio_xml_'.date("d_m_Y_H_i_s").'.xml"');
					$xml = '<?xml version="1.0" encoding="ISO-8859-1"?>'."\n";							
					$xml .= "<".$_SESSION["table"].">"."\n";
					foreach($data as $row){
						$xml .= "<".$_SESSION["primary_key"].">"."\n";
						for($y=0;$y<count($row);$y++){				
							$xml .=  "<".__limpaString($header[$y]).">".__limpaString($row[$y])."</".__limpaString($header[$y]).">"."\n";		
						}
						$xml .= "</".$_SESSION["primary_key"].">"."\n";
					}
					
					$xml .= "</".$_SESSION["table"].">"."\n";
					
					echo $xml;
		 break;
	  	case "extrator":
		echo'
			<style>
			th{
			border-bottom: 1px solid #cccccc;
			border-top: 1px solid #cccccc;		
			}
			</style>	
			';
		 relatorio_header('');
		 
		$portable_data = $_POST["portable_data"];
		$portable_data = str_replace(	"\\", '', $portable_data); 
		$portable_data = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $portable_data);
		$portable_data = preg_replace('/(<[^>]+) onclick=".*?"/i', '$1', $portable_data);
		$portable_data = preg_replace('/(<[^>]+) id=".*?"/i', '$1', $portable_data);
		$portable_data = preg_replace('/(<[^>]+) onchange=".*?"/i', '$1', $portable_data);
		$portable_data = preg_replace('/(<[^>]+) title=".*?"/i', '$1', $portable_data);
		$portable_data = preg_replace('/(<[^>]+) class=".*?"/i', '$1', $portable_data);
		$portable_data = preg_replace('/(<[^>]+) nowrap=".*?"/i', '$1', $portable_data);
		$portable_data = preg_replace('/(<[^>]+) value=".*?"/i', '$1', $portable_data);
		$portable_data = strip_tags($portable_data,"<th><table><tr><td><select><option>"); 
		echo '<table  style="width:100%;font-size:10px;" cellpadding="1" cellspacing="1" >';
		echo $portable_data;  
		echo '</table>';		 
		 
		 break;
		 
		case "html":	
					echo'
						<style>
						th{
							border: 1px solid #15428B;
							border-right: 1px solid #cccccc;		
							border-left: 1px solid #cccccc;	
							background-color:#15428B;
							color:#ffffff;
							font-weight:bolod;
							font-size:14px;						
						}
						#rel_html td{
							border-right: 1px solid #15428B;		
							border-left: 1px solid #15428B;							
							padding:3px;
						}
						#rel_html {								
							border: 1px solid #15428B;
						}						
						</style>
						';
					
					relatorio_header('');		
					echo '<table  style="width:100%;font-size:10px;" cellpadding="0" cellspacing="0" id="rel_html">';
					echo '<tr>';
					foreach($header as $row){
						echo '<th>'.$row.'</th>';
					}
					echo '</tr>';	
				
					
					foreach($data as $row){
						$cor = ($count % 2 == 0)?"#eaeaf0":"#ffffff";
						echo '<tr bgcolor="'.$cor.'">';
					    foreach ($row as $field){			  
							 echo '<td>'.$field.'</td>';			
					    }
						echo '</tr>';	
						$count++;
					}
					echo '<tr>';
					for ($h=0;$h <count($header);$h++) echo'<td></td>';
					echo'</tr>';
					echo '</table>';
			
		 break;
		case "pdf":		
				// inicio - gerados pdf
					$pdf = new PDF('L','mm','A4');
					$pdf->AliasNbPages();	
				
					$pdf->SetField($header);
					$pdf->SetHeaderCell($cell_width);		
					$pdf->Open();
					$pdf->AddPage();
					$pdf->FancyTable($data,$header,$cell_width);
					$pdf->Output();			
			
		 break;
		case 4:
		  $cor = "#ff3333";				
		  break;
		default:
		 break;				
	}	
  



  







	switch ($tipo){
		case "excel":

		 break;
	  	case "html":
		 	echo '<center><input type="button" onclick="self.print();" value="Imprimir Relatório"></center><br><br><br><br><br>';
		 break;
		case "pdf":
			
		 break;
		case 4:
		  $cor = "#ff3333";				
		  break;
		default:
		 break;				
	}	




















  ?>
  
  
 
    




            
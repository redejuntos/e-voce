<?php
require_once("../lib/chartdir/phpchartdir.php");


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



foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	



$data = array();
$labels = array();
$depths = array();
$cores = array();
$add_data_inicio = null;
$add_data_fim = null;

if ($data_inicio) $add_data_inicio = " AND a.data_inclusao >= '".data_us($data_inicio)."'  ";
if ($data_fim) $add_data_fim = " AND a.data_inclusao <= '".data_us($data_fim)."'  ";




////////////////////////////////////
/// calcula total de solicitacões ///
////////////////////////////////////
$sql = "SELECT SUM(total) AS soma
		FROM(
			  SELECT COUNT(*) AS total
			  FROM contribuicoes AS a
			  WHERE id_desafio = '$id_desafio' $add_data_inicio $add_data_fim
			  GROUP BY a.id_fase
		
		) AS temp
";
if (numrows($sql)>0){
	$rs = get_record($sql);
	$total = $rs["soma"];	
}else{
	exit("Não há dados nesse período.");
}
////////////////////////////////////

$sql = "
SELECT COUNT(*) AS total,
	  (SELECT b.nome_Fase
	  FROM fases AS b
	  WHERE b.id_fase=a.id_fase) AS nome_fase
FROM contribuicoes AS a
WHERE id_desafio = '$id_desafio' $add_data_inicio $add_data_fim
GROUP BY a.id_fase
";
$altura_fatia = 5;
if (numrows($sql)>0){
		$result = return_query($sql);		
		while( $rs = db_fetch_array($result) ){				
			
			#The data for the pie chart
			$data[] = number_format($rs["total"]*100/$total,2,".","");
			
			#The labels for the pie chart
			$labels[] = $rs["nome_fase"];
			
			$cores[] = strtolower(trim($rs["nome_fase"]));
			
			#The depths for the sectors
			$depths[] = $altura_fatia;			
			$altura_fatia += 10;

		} 			
}else{
	exit("Não há dados suficientes para gerar o gráfico");
}










#Create a PieChart object of size 360 x 300 pixels, with a light blue (0xccccff)
#background and a 1 pixel 3D border
$c = new PieChart(600, 400, 0xffffff, -1, 0);

#Set the center of the pie at (180, 175) and the radius to 100 pixels
$c->setPieSize(300, 230, 175);



if ($data_inicio){
	$periodo = " - $data_inicio à  $data_fim";
}


#Add a title box using 14 pts Times Bold Italic font and 0x99bbe8 as background
#color
$titleObj = $c->addTitle("Fases - ". get_desafio($id_desafio), "timesbi.ttf", 14);
$titleObj->setBackground(0x99bbe8);



#Set the pie data and the pie labels
$c->setData($data, $labels);





for ($indice = 8; $indice <= (SizeOf($cores) + 8); $indice++) {	
//echo $cores[$indice-9];
$cor = setColorBarNameChart($cores[$indice-8]);
if ($cor != '0x000000')
	eval('$c->setColor($indice,'.$cor.');');
}

//$c->setColor(8, 0xD0D1D7);



#Draw the pie in 3D with variable 3D depths
$c->set3D2($depths);

#Set the start angle to 225 degrees may improve layout when the depths of the
#sector are sorted in descending order, because it ensures the tallest sector is
#at the back.
$c->setStartAngle(225);

#output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>


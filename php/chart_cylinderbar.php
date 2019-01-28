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
$cores = array();
$add_data_inicio = null;
$add_data_fim = null;

if ($data_inicio) $add_data_inicio = " AND c.data_inicio_vigencia >= '".data_us($data_inicio)."'  ";


if ($data_fim) $add_data_fim = " AND c.data_inicio_vigencia <= '".data_us($data_fim)."'  ";


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


		
			



# Create a XYChart object of size 400 x 240 pixels.
$c = new XYChart(600, 400);
//$c->setColor(8, 0xD0D1D7);


for ($indice = 8; $indice <= (SizeOf($cores) + 8); $indice++) {	
//echo $cores[$indice-9];
$cor = setColorBarNameChart($cores[$indice-8]);
if ($cor != '0x000000')
	eval('$c->setColor($indice,'.$cor.');');
}




if ($data_inicio){
	$periodo = " - $data_inicio à  $data_fim";
}

# Add a title to the chart using 14 pts Times Bold Italic font
$c->addTitle("Fases - " . get_desafio($id_desafio) .$periodo, "timesbi.ttf", 14);

# Set the plotarea at (45, 40) and of 300 x 160 pixels in size. Use alternating light
# grey (f8f8f8) / white (ffffff) background.
$c->setPlotArea(65, 80, 500, 290, 0xf8f8f8, 0xffffff);

# Add a multi-color bar chart layer
$layer = $c->addBarLayer3($data);

# Set layer to 3D with 10 pixels 3D depth
$layer->set3D(10);

# Set bar shape to circular (cylinder)
$layer->setBarShape(CircleShape);

# Set the labels on the x axis.
$c->xAxis->setLabels($labels);




# Add a title to the y axis
$c->yAxis->setTitle("Quantidade de Solicitações");

# Add a title to the x axis
$c->xAxis->setTitle("");

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>

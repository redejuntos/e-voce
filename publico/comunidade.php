<? 
session_start();
// ----------------- no cache----------------------------
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT"); 
@header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

require_once ("./php/funcoes.php");
require_once ("./php/class.php");	
require_once ("./php/connections/connections.php");	  
require_once ("./facebook.php");	
include_once ("./php/analyticstracking.php");


//comprimir_PHP_start();
		$layout = new layout;	
		$layout -> animate_menu('.');
		$layout -> css('.');	
		$layout -> js('.');
		$layout -> jquery('.');
		$layout -> aeroWindow('.');
		$layout -> toastmessage('.');
		$layout -> datepicker('.');
		$layout -> clueTip('.');	
		$layout -> fancybox('.');
		//$layout ->bootstrap('.');


require_once ("./base.php");

echo cabecalho_pmc();
echo menu_top();
echo facebook_box();
require_once ("./caixas_flutuantes.php");	 
echo icones_facebook_twitter();

echo banner_top_comunidade();
?>
<center>  

<h1 style="color:#363945;max-width:1280px">Veja aqui quem está participando da e-você. Quanto mais inspirações e propostas enviar, mais você sobe na classificação e mostra sua dedicação em ajudar nossa cidade.</h1>

<br>

<img src="./images/faixa_comunidade.gif" style="border:0px">

<br><br>


<?

$sql_comunidade = "
SELECT  a.id_participante,  a.nome_participante, a.avatar,  a.facebook_id,
		(
		SELECT @total_comentarios := COUNT(*)
		FROM comentarios AS b
		WHERE b.id_participante = a.id_participante AND aprovado = 'S') AS total_comentarios,
		(
		SELECT @total_inspiracoes := COUNT(*)
		FROM contribuicoes AS c
		WHERE c.id_participante = a.id_participante AND c.id_fase='1' AND aprovado = 'S') AS total_inspiracoes,
		(
		SELECT @total_propostas := COUNT(*)
		FROM contribuicoes AS d
		WHERE d.id_participante = a.id_participante AND d.id_fase=2 AND aprovado = 'S') AS total_propostas,
		(
		SELECT @total_visualizacoes := COUNT(*)
		FROM visualizacoes AS f
		WHERE f.id_participante = a.id_participante) AS total_visualizacoes,
		(
		SELECT @total_curtidas := COUNT(*)
		FROM curtidas AS e
		WHERE e.id_participante = a.id_participante) AS total_curtidas,
		(
		SELECT ceil(g.visualizacoes*@total_visualizacoes+g.comentarios*@total_comentarios + g.curtidas*@total_curtidas + g.propostas*@total_propostas + g.inspiracoes*@total_inspiracoes)
		FROM pontuacoes AS g
		ORDER BY id_pontuacao DESC
		LIMIT 1
		) AS pontuacao
FROM participantes AS a
WHERE a.data_cancelamento IS NULL
ORDER BY pontuacao DESC

";

$count = 1;		 
$result = return_query($sql_comunidade);

echo '<div style="margin:0 auto;width:900px;height:auto">';
while( $rs = db_fetch_array($result) ){		
	if ($count%3 == 0){
		$quebra_linha = '<br><hr style="border: 1px dotted #cccccc;border-collapse:collapse;width:900px"></hr><br>';
		$css = "";
	}else{
		$quebra_linha = "";
		$css = "float:left;";
	}		
	if (trim($rs["avatar"])){
		$avatar = $rs["avatar"];
	}else{
		  if($rs["facebook_id"]){
			  $avatar = 'https://graph.facebook.com/'.$rs["facebook_id"].'/picture?width=200&height=200';						
		  }else{
			  $avatar = './images/avatar.jpg';				 		 
		  }
	}		
	 ?>
     
	<div style="overflow:hidden;width:300px;height:130px;<?= $css ?>">
	<table cellpadding="1" cellspacing="1" style="width:300px;">
	  <tr>    
		<td rowspan="7" style="width:90px;text-align:left">    
	   <img src="<?= $avatar ?>" style="border:0;width:110px;height:110px;margin:0px;float:left" align="absmiddle">  
       
      <br>  
      
      <span style="font-family:Arial, Helvetica, sans-serif;font-size:11px;color:#7c858e;"><img src="./images/points.png" align="left" style="border:0px;margin-top:1px;"><?= $rs["pontuacao"] ?> pontos</span>
		</td>
		<td style="font-size:12px;font-weight:bold;color:#363945"><?= $count ?>º</td>
	  </tr>
	  <tr>
		<td style="font-size:12px;font-weight:bold;color:#363945"><?= $rs["nome_participante"] ?></td>
	  </tr>
	  <tr>
		<td style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#7c858e;"><img src="./images/propostas.png" align="left" style="border:0px"><?= $rs["total_propostas"] ?> propostas</td>
	  </tr>
	  <tr>
		<td style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#7c858e;"><img src="./images/inspiracoes.png" align="left" style="border:0px"><?= $rs["total_inspiracoes"] ?> inspirações</td>
	  </tr>
	  <tr>
		<td style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#7c858e;"><img src="./images/curtir_ico.png" align="left" style="border:0px"><?= $rs["total_curtidas"] ?> curtidas</td>
	  </tr>
	  <tr>
		<td style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#7c858e;"><img src="./images/comentario_ico.png" align="left" style="border:0px"><?= $rs["total_comentarios"] ?> comentários</td>
	  </tr>
      <!--
	  <tr>
		<td style="font-family:Arial, Helvetica, sans-serif;font-size:11px;color:#7c858e;"><img src="./images/visualizacoes_ico.png" align="left" style="border:0px"><?= $rs["total_visualizacoes"] ?> visualizacoes</td>
	  </tr>-->
	</table>
	</div>
    <?= $quebra_linha ?>
	<?
	$count++;
}
echo '</div>';
?>


<div style="width:100%;float:left;height:30px;">&nbsp;</div>

<div style="width:100%;float:left">
<?= show_logos() ?>
</div>

<div style="width:100%;float:left">
 <?= banner_bottom() ?>
</div>

</center>
<iframe frameborder="0" NAME="grid_iframe" WIDTH="1" HEIGHT="1" style="display:none;">No Inlineframes</iframe>
</BODY>
</HTML>
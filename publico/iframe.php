<? 
session_start();
// ----------------- no cache----------------------------
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT"); 
@header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	

require_once ("./php/funcoes.php");
require_once ("./php/class.php");	
require_once ("./php/connections/connections.php");	  

$layout = new layout;	
$layout -> animate_menu('.');
$layout -> js('.');
$layout -> jquery('.');
$layout -> fancybox('.');

?>
<style type="text/css">
h4 {
color: #363636;
font-size: 20px;
font-weight: 700;
line-height: 20px;
border-bottom: 1px solid #1a1a1a;
margin:0px 0px 10px 0px;
padding:0px;
}

</style>
<?


$sql_temas = "
		SELECT a.id_topico, a.nome_topico, a.media_flag, a.descricao, a.nro_topico,
		(SELECT concat(b.youtube_link,'|',b.descricao)
					FROM anexos AS b 
					WHERE caminho_arquivo IS NULL
					AND (a.id_topico = b.id_topico)
					ORDER BY b.ordem
					LIMIT 1   
		) as youtube,
		(SELECT concat(COALESCE(c.caminho_arquivo, ''),'|',COALESCE(c.arquivo, ''),'|',
									   COALESCE(c.descricao, ''))
					FROM anexos AS c 
					WHERE youtube_link  IS NULL
					AND (a.id_topico = c.id_topico)
					ORDER BY c.ordem
					LIMIT 1   
		) as imagem
		FROM topicos as a
		WHERE  a.id_topico = '".$id_topico."'	
		";
		//echo $sql_temas;
  if (numrows($sql_temas)>0){					  
		$rs = get_record($sql_temas);						
		if($rs["media_flag"] == 'V'){
			$aux = explode("|",$rs["youtube"]);
			$youtube = $aux[0];
			$descricao_anexo = $aux[1];
		}else{
			$aux = explode("|",$rs["imagem"]);
			$caminho = $aux[0];
			$arquivo = $aux[1];
			$descricao_anexo = $aux[2];
		}  				
		echo '
		<center>
		<div style="width:760px;text-align:justify;line-height: 21px;color:#333;font-family: Helvetica, Arial, Geneva, sans-serif;font-size: 14px;overflow:hidden">';		
	
		echo '<h4>Temas</h4>';
		
		
		echo '
		<div style="background: #F2F1F0;padding: 5px;display: block;margin-bottom:10px;height:50px;">';
		
		
		
	  $sql_menu_tema = "
						SELECT a.id_topico, a.nome_topico,
						(SELECT concat(COALESCE(c.caminho_arquivo, ''),'|',COALESCE(c.arquivo, ''),'|',
									   COALESCE(c.descricao, ''))
									FROM anexos AS c 
									WHERE youtube_link  IS NULL
									AND (a.id_topico = c.id_topico)
									ORDER BY c.ordem
									LIMIT 1   
						) as imagem
						FROM topicos as a
						WHERE a.data_cancelamento is NULL 
						AND a.id_desafio = '".$id_desafio."'
						ORDER BY a.nro_topico
						";
		
		
		  if (numrows($sql_menu_tema)>0){
			  	$result_temas = return_query($sql_menu_tema);
				while( $rs_temas = db_fetch_array($result_temas) ){					
					$aux = explode("|",$rs_temas["imagem"]);												
					echo '<div style="height:40px;width:116px;background:#898787;float:left;margin:5px;cursor:pointer;" onclick="location.href=\'iframe.php?id_topico='.$rs_temas["id_topico"].'&id_desafio='.$id_desafio.'\'">
<img src="'.$aux[0].'tb-'.$aux[1].'" style="width:40px;height:40px;border:0" align="left"><div style="font-size:9px;color:#ffffff;line-height:10px;height:40px;overflow:hidden;padding:3px; 3px 0px 0px;text-align:left; ">'.$rs_temas["nome_topico"].'</div>
&nbsp;
</div>';
				
				}			  
		  }
		
		
		
		
		
		echo '
		</div>
		';
		
		
		if ($rs["media_flag"] == 'F'){
			echo '<a href="'.$caminho.$arquivo.'" class="fancybox"><img src="'.$caminho.'thumb-'.$arquivo.'"  style="width:352px;height:208px;border:0px;margin:0px 15px 5px 0px;"  align="left"></a>';
		}else{
			echo '<div style="float:left;margin-right:10px;">'.youtube_embed($youtube,'352px','208px').'</div>';
		}		
		echo '<h2 style="color:#4d4d4d">'.$rs["nome_topico"].'</h2>
	
		'.$rs["descricao"].'
	
		';
		echo '
		</div>
		</center>';
  }
?>
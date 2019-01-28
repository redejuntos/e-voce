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



//comprimir_PHP_start();
		$layout = new layout;	
		$layout -> cabecalho();
		$layout -> animate_menu('.');
		$layout -> css('.');	
		$layout -> js('.');		
		include_once ("./php/analyticstracking.php");
		$layout -> jquery('.');
		$layout -> aeroWindow('.');
		$layout -> toastmessage('.');
		$layout -> datepicker('.');
		$layout -> clueTip('.');	
		$layout -> fancybox('.');
		$layout -> flexslider('.');	
		//$layout ->bootstrap('.');


require_once ("./base.php");	

echo cabecalho_pmc();
echo menu_top();
echo facebook_box();
require_once ("./caixas_flutuantes.php");	 
echo icones_facebook_twitter();

require_once ("./confirma_adesao.php");	 

if (!$id_desafio) echo banner_top();
?>
<center>  


<?


if ($id_desafio) $add_sql = " AND id_desafio = '".$id_desafio."' ";
  $sql_desafio = "
SELECT a.id_desafio, a.nome_desafio, a.media_flag, a.data_inicio, a.data_fim,a.descricao,
(SELECT concat(COALESCE(b.youtube_link, ''),'|',COALESCE(b.descricao, ''))
            FROM anexos AS b 
            WHERE caminho_arquivo IS NULL
            AND (a.id_desafio = b.id_desafio)
            ORDER BY b.ordem
            LIMIT 1   
) as youtube,
(SELECT 
			   
	   concat(COALESCE(c.caminho_arquivo, ''),'|',COALESCE(c.arquivo, ''),'|',
									   COALESCE(c.descricao, ''))	   
			   
			   
            FROM anexos AS c 
            WHERE youtube_link  IS NULL
            AND (a.id_desafio = c.id_desafio)
            ORDER BY c.ordem
            LIMIT 1   
) as imagem
FROM desafios as a
WHERE a.data_cancelamento is NULL 
AND a.data_inicio < now()   ".$add_sql."   ORDER BY a.data_inclusao DESC ;
";


					 
$result_desafio = return_query($sql_desafio);
while( $rs_desafio = db_fetch_array($result_desafio) ){				
	if($rs_desafio["media_flag"] == 'V'){
		$aux = explode("|",$rs_desafio["youtube"]);
		$youtube = $aux[0];
		$descricao_anexo = $aux[1];
	}else{
		$aux = explode("|",$rs_desafio["imagem"]);
		$caminho = $aux[0];
		$arquivo = $aux[1];
		$descricao_anexo = $aux[2];
	}

 ?>
  <!-- Desafio -->
  <div style="margin:0 auto;margin-top:0px;background-color:transparent;width:980px;height:auto;" >
    <table cellpadding="0" cellspacing="0">
      <tr><td><div  style="line-height:60px;font-size:22px;font-weight:bold;color:#393e44;width:980px;text-indent:40px;">Desafio</div></td></tr>
      <tr><td><? desafio_titulo($rs_desafio["nome_desafio"]) ?></td></tr>      
      <tr><td>
      <div  style="width:980px;height:100%;background-image:url(images/desafio_fundo.png);background-repeat:repeat-y;margin:0;padding:0;padding-left:40px;">
	  <?				  
        $fases = explode("|",show_menu_fases($rs_desafio["id_desafio"],'','1'));  //motra menu de fases e pega a fase atual do desafio	
		$fase_atual = $fases[0];
		$nome_fase = $fases[1];
		
        desafio_info($rs_desafio["media_flag"],$caminho,$arquivo,$youtube,$rs_desafio["descricao"],$descricao_anexo,$rs_desafio["id_desafio"],$fase_atual,$nome_fase,'0','0');
      ?>
       </div>
      <div style="width:980px;height:auto;">
        <center>
	  <?
	  echo show_form_inspiracao($rs_desafio["id_desafio"],$fase_atual);
	  filtro_contribuicao($fase_atual,$rs_desafio["id_desafio"]);
	  show_contribuicao($rs_desafio["id_desafio"],$fase_atual,'0');   
  	 // show_form_coments($imagem_avatar,trim($rs_contribuicao["id_contribuicao"])); 
	  ?>
 		</center>        
     </div>      
      </td>      
      </tr>      
    </table>
  </div>
  <!-- Desafio End -->
<?
} // fim while
?>


<?= show_logos() ?>

</center>




<?= banner_bottom() ?>


<iframe frameborder="0" NAME="grid_iframe" WIDTH="1" HEIGHT="1" style="display:none;">No Inlineframes</iframe>
</BODY>
</HTML>




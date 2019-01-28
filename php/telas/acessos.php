<? 
session_start();
echo '<style>table tr td {font-family:Verdana, Geneva, sans-serif;font-size:12px;}</style>';
echo '</HEAD><BODY>';


foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  		 $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	



create_table_extjs("950px","auto","Acessos");


?>

<form name="form1" id="form1" method="post" action="">
<center>
  <table style="width:97%;height:97%"   cellpadding="3" cellspacing="2">


     
 
    
    
         <tr>         
    <td nowrap="nowrap" width="100px;" ><div align="right" style="margin-top:20px"><b>Desafio</b></div></td>
    <td colspan="5" >
    <select name="id_desafio" style="margin-top:20px" onChange="this.form.submit()">
    <?= get_desafio_combo($_POST["id_desafio"]) ?>
    </select>
    </td>
    </tr>   
     </table>
  </center>
  <?

  
  
  
  $sql = "
SELECT b.nome_fase,b.id_fase, COUNT(a.id_contribuicao) AS total
FROM fases AS b
LEFT OUTER
JOIN contribuicoes AS a ON (a.id_fase = b.id_fase AND a.id_desafio = '".$_POST["id_desafio"]."' AND a.data_cancelamento is NULL)
GROUP BY a.id_fase
ORDER BY b.ordem
";
$nome_fases = array();
$total_fases = array();
$result = return_query($sql);
echo '<table style="width:300px;height:auto;margin:20px 0 0 20px;background:#dfe8f6;border: 1px solid #99bbe8;padding:5px 20px 20px 20px;box-shadow: 1px 1px 4px #888888;"   cellpadding="3" cellspacing="2">';
echo'
    <tr>         
    <td nowrap="nowrap" colspan="6" style="background:#fff;" ><div style="text-align:center;border: 1px solid #99bbe8;padding:5px;"  ><b style="font-size:18px;"> Acessos por Fases </b></div></td>   
    </td>
    </tr>  
';
$total_geral = 0;	
$total_contribuicoes = array();
while( $rs = db_fetch_array($result) ){		
	$total_visualizacoes = max_visualizacao($rs["id_fase"],$_POST["id_desafio"]);	
	$total_contribuicoes[$rs["id_fase"]] = $rs["total"];
echo '
    <tr>         
    <td nowrap="nowrap" width="200px;" nowrap ><div align="right" ><b> Total de '.$rs["nome_fase"].': </b></div></td>
    <td colspan="5" >
    '.$rs["total"].'
    </td>
    </tr>   
    <tr>         
    <td nowrap="nowrap" width="200px;" nowrap ><div align="right" ><b> Acessos em '.$rs["nome_fase"].':  </b></div></td>
    <td colspan="5" >
    '. $total_visualizacoes .'
    </td>
    </tr> 
';
	$total_geral += intval($total_visualizacoes);
} 		
echo '
    <tr>         
    <td nowrap="nowrap" width="200px;" nowrap ><div align="right"  ><b> Total de Visualizações: </b></div></td>
    <td colspan="5">
	<span  style="width:auto;color:#080;font-weight:bold">
    '.$total_geral.'
	</span>
    </td>
    </tr>  
	';
 echo '</table>';
  
  
  
  
	$desafio = array(array());
		 $sql = "SELECT a.nome_fase,b.data_inicio,a.id_fase,c.data_fim
				FROM fases AS a
				INNER JOIN desafios_x_fases AS b ON (a.id_fase = b.id_fase)
				INNER JOIN desafios AS c ON (c.id_desafio = b.id_desafio)
				where b.id_desafio = '".$_POST["id_desafio"]."' and a.data_cancelamento is NULL
				AND NOW() > c.data_inicio
				ORDER BY a.ordem
		";					
		 $result = return_query($sql);
		 while( $rs = db_fetch_array($result) ){	
			$desafio["data_inicio"][] = $rs["data_inicio"];
			$desafio["id_fase"][] = $rs["id_fase"];
			$desafio["nome_fase"][] = $rs["nome_fase"];
			$data_fim = $rs["data_fim"];
		 }


		foreach ($desafio["data_inicio"] as $index => $data_inicio ){						
			 $data_fim_fase = $desafio["data_inicio"][$index+1];
			 $data_fim_fase = ($data_fim_fase)?$data_fim_fase:$data_fim; // se nao tem fase inicial posterior, é a ultima fase.
			 $periodo = subtrai_data($data_inicio,$data_fim_fase);	
			 $desafio["periodo"][] = $periodo;
		}

 
 
echo '<table style="width:300px;height:auto;margin:20px 0 0 20px;background:#dfe8f6;border: 1px solid #99bbe8;padding:5px 20px 20px 20px;box-shadow: 1px 1px 4px #888888;"   cellpadding="3" cellspacing="2">';
echo'
    <tr>         
    <td nowrap="nowrap" colspan="6" style="background:#fff;" ><div style="text-align:center;border: 1px solid #99bbe8;padding:5px;"  ><b style="font-size:18px;"> Contribuições por Dia </b></div></td>   
    </td>
    </tr>  
';

echo '
    <tr>         
    <td nowrap="nowrap" width="50px;" nowrap ><div align="right" ><b> '.$desafio["nome_fase"][0].': </b></div></td>
    <td colspan="5" >
    '.number_format($total_contribuicoes[1]/$desafio["periodo"][0],2).'  / dia
    </td>
    </tr>   
    <tr>         
    <td nowrap="nowrap"  nowrap ><div align="right" ><b> '.$desafio["nome_fase"][1].':  </b></div></td>
    <td colspan="5" >
    '.number_format($total_contribuicoes[2]/$desafio["periodo"][1],2).'   / dia
    </td>
    </tr> 
';
echo '</table>'; 

  ?>
  
  

  

  
  

</form>

<? end_table_extjs();?>

<iframe frameborder="0" NAME="grid_iframe" WIDTH="1" HEIGHT="1" style="display:none" >No Inlineframes</iframe>  

<script>
$(function() {

	$( "#datepicker, .date_field" ).datepicker({									  
		changeMonth: true,
		changeYear: true,
		inline: true,
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho',
		'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
		'Jul','Ago','Set','Out','Nov','Dez'],
		dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'],
		dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'],
		dateFormat: 'dd/mm/yy', firstDay: 0,		
		prevText: '&#x3c;Anterior', prevStatus: '',
		nextText: 'Pr&oacute;ximo&#x3e;', nextStatus: '',
		currentText: 'Hoje', currentStatus: '',
		todayText: 'Hoje', todayStatus: '',
		clearText: 'Limpar', clearStatus: '',
		closeText: 'Fechar', closeStatus: ''
	});
	
});


	</script>
    
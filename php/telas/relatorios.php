<? 
session_start();
echo '<style>table tr td {font-family:Verdana, Geneva, sans-serif;font-size:12px;}</style>';
echo '</HEAD><BODY>';


foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  		 $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	



create_table_extjs("auto","120px","Emitir Relatórios");


?>

<form name="form1" id="form1" method="post">
<center>
  <table style="width:97%;height:97%"   cellpadding="3" cellspacing="2">


     
         <tr>         
    <td nowrap="nowrap" width="100px;" ><div align="right"> Gráfico</div> </td>
    <td colspan="5" >
      
          <select name="grafico">
          
          <option value="">Todos</option>
          <option value="multidepthpie">Certificações - Pizza</option>
          <option value="chart_cylinderbar">Certificações - Coluna</option>     
          </select>
   
    </td>
    </tr>       

     
 
    
    
         <tr>         
    <td nowrap="nowrap" width="100px;" ><div align="right">Desafio</div></td>
    <td colspan="5" >
    <select name="id_desafio">
    <?= get_desafio_combo('') ?>
    </select>
    </td>
    </tr>   
     
     
     
     <tr nowrap>
     <td colspan="6" align="right" nowrap="nowrap">
  
       <input type="button" name="btn_salvar" id="btn_salvar" value="Visualizar" class="botao"  onclick="emitir_relatorio(this.form);" style="margin:5px 5px 0 10px">  
       <input type="reset" name="btn_reset" id="btn_reset" value="Limpar" class="botao" style="margin-right:10px;">
    
          </td>
    </tr>
  </table>
  </center>
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
    
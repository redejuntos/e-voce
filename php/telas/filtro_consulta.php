<? 
session_start();
echo '<style>table tr td {font-family:Verdana, Geneva, sans-serif;font-size:12px;}</style>';
echo '</HEAD><BODY>';


foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  		 $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	



create_table_extjs("450px","160px","Filtro para Consulta de Solicitações");


?>

<form name="form1" id="form1" method="post">
<center>
  <table style="width:97%;height:97%"   cellpadding="0" cellspacing="2">

    <tr nowrap="nowrap">          
              <td nowrap="nowrap" width="150px;" ><div align="right"> Situação&nbsp;</div> </td>
<td colspan="5" nowrap="nowrap">
                <? situacao_options('','') ?></td>
     </tr>
  
     
      <tr nowrap="nowrap">          
              <td nowrap="nowrap" width="150px;" ><div align="right"> Nível Maturidade&nbsp;</div> </td>
<td colspan="5" nowrap="nowrap">
               <select name="id_nivel_maturidade"    > <? echo  get_nivel_maturidade_sugerida('','') ?></select>
               
               </td>
     </tr>   
     
     
     
     
     
    <tr>         
    <td nowrap="nowrap" width="150px;" ><div align="right"> CNPJ</div> </td>
    <td colspan="5" >
      
           			 <INPUT type="text"  class="input" NAME="cnpj" style="width:150px;"    value="<?= $rs_empresa["cnpj"]?formatarCPF_CNPJ($rs_empresa["cnpj"]):$cnpj;  ?>"   maxlength="18"  onkeypress="return txtBoxFormat(this.form, this.name, '99.999.999/9999-99', event);"   onblur="validaCNPJ(this);"  >	
   
    </td>
    </tr>
     
     
     <tr>         
    <td nowrap="nowrap" width="150px;" ><div align="right">Razão Social</div> </td>
    <td colspan="5" ><input name="razao_social" type="text" class="x-form-text x-form-field"  style="width:250px;"   value=""  maxlength="180"   /></td>
    </tr>   
    
    
   <tr>         
    <td nowrap="nowrap" width="150px;" ><div align="right">Nome Fantasia</div> </td>
    <td colspan="5" >
    
    <input name="nome_fantasia" type="text" class="x-form-text x-form-field"  style="width:250px;" value=""  maxlength="180"   />
    </td>
    </tr>   
    
    
    
         <tr>         
    <td nowrap="nowrap" width="150px;" ><div align="right"> Período&nbsp;</div> </td>
    <td colspan="5" >
      
           <input  name="data_inicio"  type="text" class="x-form-text x-form-field date_field"  style="width:90px;"   onblur="newDataValidate(this)" onkeypress="return txtBoxFormat(this.form, this.name, '99/99/9999', event);"   title="Dia / Mês / Ano"  maxLength="10"   /> a 
           
           <input  name="data_fim"  type="text" class="x-form-text x-form-field date_field"  style="width:90px;"   onblur="newDataValidate(this)" onkeypress="return txtBoxFormat(this.form, this.name, '99/99/9999', event);"   title="Dia / Mês / Ano"  maxLength="10"   />
   
    </td>
    </tr>   
     
     
     
     <tr nowrap>
     <td colspan="6" align="right" nowrap="nowrap">
     
     	<input type="hidden" name="filtro_consulta" value="yes" >
  
       <input type="button" name="btn_salvar" id="btn_salvar" value="Visualizar" class="botao"  onclick="executa_filtro_consulta(this.form);" style="margin:5px 5px 0 10px">  
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
    
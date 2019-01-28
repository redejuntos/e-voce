<? 
echo '<style>table tr td {font-family:Verdana, Geneva, sans-serif;font-size:12px;}</style>';
echo '</HEAD><BODY>';


foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	



$class_table_variables = new table_variables;
$class_table_variables -> overload_tables ($_GET["table"]);  //perde a sessão aqui
/*
foreach ($_SESSION as $a => $b){
	echo $a."-".$b."<br>";	
}


for($x=0;$x<count($_SESSION["listfield_vetor"]);$x++){
	$campos_sql .= $_SESSION["listfield_vetor"][$x];	
	($x == intval(count($_SESSION["listfield_vetor"])-1))? "":$campos_sql .= ",";
}*/

//////////////////////////////////////////////////////////////////////////////
///////////////////////// Campo que serão removidos do form /////////////////
/////////////////////////////////////////////////////////////////////////////////
$remove_form_field = array();
$xml_remove = simplexml_load_file("../xml/form_remove_field.xml");
foreach($xml_remove as $field){		
	if  ((string)$field->children() == $_GET["table"]){ //verifica se tabelea tem campo form em xml			
		  foreach($field->children() as $child){
				  if ( (string)$child->getName() == 'field'){ // pega campos do form que serão escondidos	
						  $remove_form_field[] = trim((string)$child);
				  }
		  }
	}
}
//////////////////////////////////////////////////////////////////////////////




if ($_GET["cod"]){  // Alterar Registro
	$sql = "SELECT * 
			FROM ".$_GET["table"]."
			WHERE (".$_SESSION["primary_key"]." = '".$_GET["cod"]."') 
			limit 1
			";  	
	$rs = get_record($sql);		
}else{  //Adicionar Registro
	$sql = "SELECT * FROM ".$_GET["table"];	
}





$result = return_query($sql);	
$describe = db_describe_table($_GET["table"]);
$num = db_num_fields($result);

$field_name = array();
$field_max_length  = array();
$field_numeric = array();
$field_type = array();
$field_def = array();
$output = array();

//while ($field=db_fetch_field($result)) {	
$string_variaveis_not_null = array();

	 for ($i = 0; $i < $num; ++$i) {		 
			$field = db_fetch_field($result, $i);
            $field->definition = db_result($describe, $i, 'Type');			
			
			if (DBConnect::database=="postgresql"){    //PostgreSQL
					$array = pg_Fields_Info();
					//print_r($array);
					foreach ($array as $a){
						foreach ($a as $b => $c){
							//print_r($a);											
							if ($b == "name"){								
								if ($c == $field->name){									
									if (
										($a["type"]=='varchar')||
										($a["type"]=='bpchar')								
									){
										$field->len = $a["len"]-4;
									}else{
										$field->len = $a["len"];
									}
									if ($a["notnull"] == 't'){ //true, not null é obrigatorio										
										$field->not_null = '1';
									}else{ //false, permite null
										$field->not_null = '0';
									}
								}
								
							}							
						}
					}						
			}else{ //Mysql			
					$field->len = db_field_len($result, $i); // Create the field length
			}			
			
			$field_name[] = $field->name;	
			$field_max_length[] = $field->len;
			$field_multiple_key[] =  $field->multiple_key ;
			$field_type[] =  $field->type;
			$field_def[] =  $field->definition;
			if ($field->not_null) { //se campo é not null
				if (in_array(trim($field->name), $remove_form_field)) { //se campo será removido do formulario
						// not null nao adicionado
				}else{
						$string_variaveis_not_null[] = $field->name;
				}
			}
	 }
 //print_r ($field_multiple_key);
	// print_r ($field_type);
	//print_r ($field_max_length);
	//print_r ($string_variaveis_not_null);
//}
//////////////////////////////////////
// remove campos do formulario ////////////////////
/////////////////////////////////////////

$remove_fields = array("ativado","data_cancelamento","data_inclusao","data_alteracao","fisica_juridica",$_SESSION["primary_key"]);
$remove_fields = array_merge($remove_fields, $remove_form_field);
//print_r ($remove_fields);


foreach ($remove_fields as $field_value){
	  $remove_number = array_search($field_value,$field_name);		
	  unset($field_name[$remove_number]);
	  unset($field_max_length[$remove_number]);
	  unset($field_multiple_key[$remove_number]);
	  unset($field_type[$remove_number]);
	  unset($field_def[$remove_number]);
}

$label_field = $field_name;

$xml = simplexml_load_file("../xml/rename_col_header.xml");

	
foreach ($label_field as $i => $value){
	foreach($xml->field as $field){			
		if ($label_field[$i]  == (string)$field->old){			
		   $label_field[$i] = (string)utf8_decode($field->new)  ; // Old field ==> New field  
		}
	}
}


$string_variaveis_not_null_label = array();
foreach ($string_variaveis_not_null as $i => $value){	
	$achou = 0;
	foreach($xml->field as $field){	
		if (trim($string_variaveis_not_null[$i])  == trim($field->old)){
		   $string_variaveis_not_null_label[$i] = (string)utf8_decode($field->new)  ; // Old field ==> New field  
		   $achou = 1;
		}
	}
	if (!$achou) $string_variaveis_not_null_label[$i] = $value;		
}
	


	   



if ($_GET["cod"]){  // Alterar checklist
	$title_window = "Editar";	
	$title = $rs[$field_name[1]];
}else{  //Adicionar Nova entidade
	$title_window = "Incluir Novo - ".(string)utf8_decode($class_table_variables -> titulo);	
	$title = (string)utf8_decode($class_table_variables -> titulo);
}



?>

<form name="form1" id="form1" method="post" >

<? create_table_extjs("99%","130px",$title_window);?>

<table style="margin:2px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">
<tr>
  <td colspan="6" style="width:97%">
  <div id="tabs" style="width:97%">
    <ul>
      <li><a href="#tabs-1">
	  
	 
      
      
      <?= ((strlen($title)>100)? substr($title,0,100)."...":$title); ?>
      
      </a></li>
    </ul>
    <div id="tabs-1" style="width:97%;">
      <!-- ----------------------------- ------------------------------------------------    -->
      <table style="margin:2px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">
      <?   
	   foreach ($field_name as $i => $value){
		  $label = '<tr><td  nowrap><div align="right">'.$label_field[$i].'</div></td>';  
		  
		  
		  if (stristr($field_name[$i], 'id_municipio') != TRUE){	//se combo é id_municipio ativa componente e nao verifica se é foreighkey
					  if (DBConnect::database=="postgresql"){    //PostgreSQL precisa testar todos os campos
							$foreign_key_value = get_combo_foreign_key($_GET["table"],$value,$rs[$value]); //confirma se o campo mul é foreign key
					  }
					  
					  if (DBConnect::database=="mysql"){    //Mysql	- testa apenas campos mul
							if ($field_multiple_key[$i]){ // mysql: campo é mul -> foreign key ou unique composto						
								  $foreign_key_value = get_combo_foreign_key($_GET["table"],$value,$rs[$value]); //confirma se o campo mul é foreign key		  
							}else{
								  $foreign_key_value = "";			  
							}
					  }
		  }
		  if ($foreign_key_value){ // campo é foreign key
			   $str = '<td colspan="5">'.$foreign_key_value.'</td>';			  
		  }else{		  
		      switch ($field_type[$i]){
				case "string": //mysql
				case "varchar": //mysql
				case "bpchar": // postgreSQL char				
				 	if ($field_max_length[$i] > 200){
						$str = '	<td colspan="5" nowrap="nowrap" style="width:100%;"><textarea style="width:100%;height:100px;" rows="5" wrap="soft" name="'.$value.'" class="x-form-text x-form-field" onkeypress="max_area(this,'.$field_max_length[$i].');">'.$rs[$value].'
</textarea></td>';
					}else{		
						if ($field_max_length[$i] < 10){
							$width = "90px";
						}else{
							$width = "100%";
						}						
						 $str = '
         				 <td colspan="5"><input name="'.$value.'" type="text" class="x-form-text x-form-field"  style="width:'.$width.';" value="'.$rs[$value].'"  maxlength="'.$field_max_length[$i].'"   /></td>';			  				
					   if (
						   (stristr($field_name[$i], 'telefone') == TRUE)||
						   (stristr($field_name[$i], 'celular') == TRUE)
						   ){						   
						    $str = '
							 <td colspan="5"><input name="'.$value.'" id="'.$value.'" type="text" class="x-form-text x-form-field"  style="width:120px;" value="'.$rs[$value].'"   maxlength="15"    onkeypress="return txtBoxFormat(this.form, this.name, \'(99) 9999-9999\', event);"/>
							</td>';
						}
					   if (stristr($field_name[$i], 'protocolo') == TRUE){						   
						    $str = '
							 <td colspan="5"><INPUT type="text" style="width:200px" NAME="'.$value.'" maxlength="12"  value="'.$rs[$value].'" class="x-form-text x-form-field" onkeypress="return txtBoxFormat(this.form, this.name, \'99/99/99.999\', event);" > 
							</td>';
						}	
					   if (stristr($field_name[$i], 'email') == TRUE){						   
						    $str = '
							 <td colspan="5">    <input name="'.$value.'"  id="'.$value.'"  type="text" class="x-form-text x-form-field"  style="width:80%;" value="'.$rs[$value].'"   maxlength="180"   onBlur="check_mail(this);" />
							</td>';
						}							
						if (							
							 (($field_type[$i] == "string")&&($field_max_length[$i] == 1)&&(DBConnect::database=="mysql"))||  //MySQL		
							 (($field_type[$i] == "bpchar")&&($field_max_length[$i] == 1)&&(DBConnect::database=="postgresql" ))   //PostgreSQL		
							){							
						      $str = '<td colspan="5"> '.getSelectTrueFalse($value,$rs[$value])."</td>"; 
							  if (stristr($field_name[$i], 'sexo') == TRUE){						   
								  $str = '
								   <td colspan="5"> <input type="radio" name="'.$value.'" value="M"  ';								   
								   $str .= ($rs[$value]=="M")?"checked":"";								   
								   $str .= ' > Masculino &nbsp; <input type="radio" name="sexo" value="F" ';
								   $str .= ($rs[$value]=="F")?"checked":"";
								   $str .= '> Feminino 
								  </td>';
							  }	
						}
					    if  (  (stristr($field_name[$i], 'cpf') == TRUE) && ($field_max_length[$i] >= 11)  ){						   
						    $str = '
							 <td colspan="5"> 							 
							 <INPUT type="text"  class="input"  name="'.$value.'" style="width:150px;"  value="'.formatarCPF_CNPJ($rs[$value],true).'" maxlength="14" onKeyPress="return txtBoxFormat(this.form, this.name, \'999.999.999-99\', event);"  onblur="validaCPF(this);"  >							 
							</td>';
						}
					    if  (  (stristr($field_name[$i], 'cnpj') == TRUE) && ($field_max_length[$i] >= 14)  ){						   
						    $str = '
							 <td colspan="5"> 			
							 <INPUT type="text"  class="input" NAME="'.$value.'" style="width:150px;"   value="'.formatarCPF_CNPJ($rs[$value],true).'"  maxlength="18"  onkeypress="return txtBoxFormat(this.form, this.name, \'99.999.999/9999-99\', event);"   onblur="validaCNPJ(this);" >							 
							</td>';							
						}
					    if  (  (  ($field_name[$i] == "cpf_cnpj")||($field_name[$i] == "cnpj_cpf")     ) && ($field_max_length[$i] >= 14)  ){						   
						    $str = '
							 <td colspan="5"> 			
									<input type="radio" name="fisica_juridica"  value="J" onclick="set_tipo_pessoa(this.form,\''.$value.'\',this);"   '.( ($rs["fisica_juridica"] == "J")?' checked="checked" ':"" ) .' >
									CNPJ   &nbsp;&nbsp;
									<input type="radio" name="fisica_juridica"  value="F" onclick="set_tipo_pessoa(this.form,\''.$value.'\',this);" '. ( ($rs["fisica_juridica"] == "F")?' checked="checked" ':"" ).'>
									CPF 
									&nbsp;
									
									<input name="'.$value.'" type="text"  class="x-form-text x-form-field"  style="width: 150px;" maxlength="18"
									
									onfocus="check_radio_box(this.form,\'fisica_juridica\')" 
									onkeypress="return check_mascara_cnpf_cnpj(this.form,this, event, \'fisica_juridica\');"
									onblur="valida_cpf_cnpj(this,this.form,\'fisica_juridica\');"   
									
									value="'.formatarCPF_CNPJ($rs[$value],true).'"                       
									/>					 
							</td>';							
						}
						
					}				
				 break;			
				case "time":
				 	 $str = '
						  <td colspan="5"><input type="Text"  value="'.substr($rs[$value], 0,5).'" maxlength="5" style="width:50px;text-align:right;margin-left:3px;" onclick="this.select()" title="Hora : Minuto"  name="'.$value.'" class="x-form-text x-form-field"  size="7"   onkeypress="return sonumero(event)"   onKeyDown="return Mascara_Hora(this)"  onchange="javascript:testa_hora(this.value, this, this.name)" > </td>
					';
				 break;	
				case "datetime"://mysql
				case "timestamp": //postgreSQL 
				 	 $str = '
						  <td colspan="5"> <input  name="'.$value.'"  value="'.data_br(substr($rs[$value], 0,10)).'" type="text" class="x-form-text x-form-field date_field"  style="width:90px;"   onblur="newDataValidate(this)" onkeypress="return txtBoxFormat(this.form, this.name, \'99/99/9999\', event);"   title="Dia / Mês / Ano"  maxLength="10"   /> 
						  
    <input type="Text"  value="'.substr($rs[$value], 11,5).'" maxlength="5" style="width:50px;text-align:right;margin-left:3px;" onclick="this.select()" title="Hora : Minuto" name="'.$value.'_hora" class="x-form-text x-form-field"  size="7"   onkeypress="return sonumero(event)"   onKeyDown="return Mascara_Hora(this)"  onchange="javascript:testa_hora(this.value, this, this.name)" > </td>
					';
				 break;	
				 
				case "date":
				 	 $str = '
						  <td colspan="5"> <input  name="'.$value.'"  value="'.data_br(substr($rs[$value], 0,10)).'" type="text" class="x-form-text x-form-field date_field"  style="width:90px;"   onblur="newDataValidate(this)" onkeypress="return txtBoxFormat(this.form, this.name, \'99/99/9999\', event);"   title="Dia / Mês / Ano"  maxLength="10"   /> </td>
					';
				 break;		
				case "int": //mysql integer ou bigint
				case "int2": //postgreSQL smallint
				case "int4": //postgreSQL integer
				case "int8": //postgreSQL bigint
				 	$str =  '
						<td colspan="5"> <input name="'.$value.'" type="text" class="x-form-text x-form-field"  style="width:15%;"     maxlength="'.$field_max_length[$i].'"  onkeypress="return sonumero(event);" value="'.$rs[$value].'"  /></td>
					';
					 if (stristr($field_name[$i], 'cep') == TRUE){						   
						  $str = ' <td colspan="5">
						      <input name="'.$value.'" id="'.$value.'" type="text"  class="x-form-text x-form-field"  style="width: 80px;" maxlength="9" onkeypress="return sonumero(event);"     onkeyup="formatavalorCEP(this,this.value);"      value="'.($rs[$value]?formataCepApresentacao($rs[$value]):"").'"    />
						  </td>';
					  }	
					 if (stristr($field_name[$i], 'id_municipio') == TRUE){	
					       $label = "";
						   $str = '<tr >
								  <td   ><div align="right">Estado</div></td>
								  <td colspan="5">
								  <select class="tabela-rotulo"  name="estado" id="estado" onchange="atualiza_conteudo(\'./ajax_open_data.php\',\'cod_estado=\'+this.value,\'POST\',\'handleHttpResponseCidade2\')">
									'.get_uf(get_estado_by_municipio($rs[$value])).'
								  </select>
								 &nbsp;&nbsp; Município
								  
								  <select class="tabela-rotulo" name="'.$value.'"  id="id_municipio">
									'. get_municipios(get_estado_by_municipio($rs[$value]),$rs[$value]) .'
								  </select>
								 </td>
								</tr>';
					  }		
					    if  (  (stristr($field_name[$i], 'cpf') == TRUE) && ($field_max_length[$i] >= 11)  ){						   
						    $str = '
							 <td colspan="5"> 							 
							 <INPUT type="text"  class="input"  name="'.$value.'" style="width:150px;"  value="'.formatarCPF_CNPJ($rs[$value],true).'" maxlength="14" onKeyPress="return txtBoxFormat(this.form, this.name, \'999.999.999-99\', event);"  onblur="validaCPF(this);"  >							 
							</td>';
						}
					    if  (  (stristr($field_name[$i], 'cnpj') == TRUE) && ($field_max_length[$i] >= 14)  ){						   
						    $str = '
							 <td colspan="5"> 			
							 <INPUT type="text"  class="input" NAME="'.$value.'" style="width:150px;"   value="'.formatarCPF_CNPJ($rs[$value],true).'"  maxlength="18"  onkeypress="return txtBoxFormat(this.form, this.name, \'99.999.999/9999-99\', event);"   onblur="validaCNPJ(this);" >							 
							</td>';							
						}
					    if  (  (  ($field_name[$i] == "cpf_cnpj")||($field_name[$i] == "cnpj_cpf")     ) && ($field_max_length[$i] >= 14)  ){						   
						    $str = '
							 <td colspan="5"> 			
									<input type="radio" name="fisica_juridica"  value="J" onclick="set_tipo_pessoa(this.form,\''.$value.'\',this);"   '.( ($rs["fisica_juridica"] == "J")?' checked="checked" ':"" ) .' >
									CNPJ   &nbsp;&nbsp;
									<input type="radio" name="fisica_juridica"  value="F" onclick="set_tipo_pessoa(this.form,\''.$value.'\',this);" '. ( ($rs["fisica_juridica"] == "F")?' checked="checked" ':"" ).'>
									CPF 
									&nbsp;
									
									<input name="'.$value.'" type="text"  class="x-form-text x-form-field"  style="width: 150px;" maxlength="18"
									
									onfocus="check_radio_box(this.form,\'fisica_juridica\')" 
									onkeypress="return check_mascara_cnpf_cnpj(this.form,this, event, \'fisica_juridica\');"
									onblur="valida_cpf_cnpj(this,this.form,\'fisica_juridica\');"   
									
									value="'.formatarCPF_CNPJ(strval($rs[$value]),true).'"                       
									/>					 
							</td>';							
						}
				 break;	
				case "blob": //MySQL 
				case "text": // postgreSQL text		
				 	 $str = '<td colspan="5">
						 <textarea style="width:100%;height:300px;" rows="5" name="'.$value.'"  id="'.$value.'" class="x-form-text x-form-field" >'.$rs[$value].'</textarea>    </td>
					';
					$xinha_add .= ",'".$value."'";
				 break;	 
				case "real":   //mysql 
				case "float4": //postgreSQL
				case "float8": //postgreSQL
				case "numeric": //postgreSQL				
				 	 $str = '<td colspan="5">
						  <input name="'.$value.'"  id='.$value.'"  type="text" class="x-form-text x-form-field"  style="width:25%;"      maxlength="14"  onkeypress=\'return formataReais(this,".",",",event)\'         value="'.($rs[$value]?converte_reais($rs[$value]):"").'"  />    </td>
					';					
				 break;	
				default:				
				   $str = '<td colspan="5"><input name="'.$value.'" type="text" class="x-form-text x-form-field"  style="width:100%;" value="'.$rs[$value].'"  maxlength="'.$field_max_length[$i].'"   /></td>';
				 break;				
			  }
		  }
       	  echo  $label.$str.'</tr>'; 
	   }	  
	   
	  // print_r($string_variaveis_not_null_label)
	  ?>     
      </table>
      <!-- ----------------------------- ------------------------------------------------    -->
    </div>
 </div>
    </td>
</tr>

    
  <tr nowrap>
   <td align="left">
   </td>
    <td colspan="5" align="right">
    
    
    
 <? if ($_GET["cod"]){  // Alterar checklist ?>
          <input type="button" name="btn_salvar" value="Alterar" onclick="alterar_padrao(this.form,'<?= $_GET["table"] ?>','<?= $_GET["cod"] ?>','<?= implode(",",$string_variaveis_not_null) ?>','<?= join("|",$string_variaveis_not_null_label) ?>');" style="margin-right:5px;"   class="botao" onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"   >          
     <? }else{  //Adicionar Novo checklist ?>
              <input type="button" name="btn_salvar" id="btn_salvar" value="Incluir" onclick="inserir_form_padrao(this.form,'<?= $_GET["table"] ?>','<?= implode(",",$string_variaveis_not_null) ?>','<?= join("|",$string_variaveis_not_null_label) ?>');" style="margin-right:5px;"   class="botao" onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"   >
     <? } ?>       
      <input type="button" name="btn_reset"  value="Limpar" class="botao"  onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"  style="margin-right:30px;" onclick="limpa_form(this.form)">
    

      
      
      
      </td>
  </tr>
</table>
<? end_table_extjs();?>

</form >

  <iframe frameborder="0" NAME="grid_iframe" WIDTH="0" HEIGHT="0" style="display:none;">No Inlineframes</iframe>
  


	<script>
$(function() {
	$( ".date_field" ).datepicker({									  
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
	

	//xinha --------------------------------------------------------
		var xinha_plugins =
		[
		 'Linker'
		];
		var xinha_editors =
		[
		  'obs' <?= $xinha_add ?>
		];
		
		function xinha_init()
		{
		  if(!Xinha.loadPlugins(xinha_plugins, xinha_init)) return;
		
		  var xinha_config = new Xinha.Config();
		  
		//	xinha_config.width = "700px";
		//	xinha_config.height = "300px";
		  xinha_editors = Xinha.makeEditors(xinha_editors, xinha_config, xinha_plugins);
		  
		  // xinha_editors.instrucao.config.height = 550;
		
		  Xinha.startEditors(xinha_editors);
		}
		Xinha.addOnloadHandler(xinha_init);
	

   $('#tabs').bind('tabsshow',    // Quando carregar uma aba
	 function( event, ui ){   		
		if (ui.panel.id == "tabs-1") {  //somente quando for a aba tab3    
		   xinha_editors.obs.sizeEditor(); // necessário dar resize para corrigir um bug do xinha
		   }
		} );
   
   
   $('a.title').cluetip({splitTitle: '|'});
});


$( "#tabs" ).tabs();	// spry tabs  // precisa carregar antes do xinha senão dá bug no IE
// xinha ---------------------------------------------------------------------------
var _editor_url = "../lib/xinha_0.96.1/"; // precisa carregar antes do arquivo js externo do xinha
var _editor_lang = "en";
var _editor_skin = "ima-skin";
</script>
<script type="text/javascript" src="../lib/xinha_0.96.1/XinhaCore.js"></script>

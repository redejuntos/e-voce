<? 
session_start(); 


// ----------------- no cache----------------------------
$gmtDate = gmdate("D, d M Y H:i:s");
@header("Expires: {$gmtDate} GMT");
@header("Last-Modified: {$gmtDate} GMT"); 
@header("Cache-Control: no-cache, must-revalidate"); 
@header("Pragma: no-cache"); 


require_once ("./connections/connections.php");	
require_once ("./fundaDB_pg.class.php");
require_once ("./funcoes.php");		
require_once ("./datagrid.class.php"); 
require_once ("./class.php");	



foreach($_GET as $a => $b){
//echo $a."-".$b."<BR>";	
$$a = $b;
}

foreach($_POST as $a => $b){
//echo $a."-".$b."<BR>";	
$$a = $b;
}

/*
echo "<br>session ----------- <br>";
foreach($_SESSION as $a => $b){
echo $a."-".$b."<BR>";	
$$a = $b;
}
*/
$layout = new layout;
$layout -> jquery('..');
$layout -> clueTip('..');
$layout -> fancybox('..');
//$layout -> window_pop();

////////////////////////////
//VERIFICA��O DE SEGURAN�A//
////////////////////////////
verifica_seguranca();

//compressao de p�ginas deixa processamento de servidor muito lento
//comprimir_PHP_start(); //compressao de p�ginas com GZip 

$class_table_variables = new table_variables;
$class_table_variables -> overload_tables ($_GET["table"]);  //perde a sess�o aqui
$class_relationship_restrition = new relationship_restrition;

$menu_vetor = verifica_acesso('','',1,'');

for($w=0;$w<count($_SESSION["menu_item"]["item"]);$w++){
	$aux = $_SESSION["menu_item"]["item"][$w];	
	for($x=0;$x<count($_SESSION["menu_item"][$aux]["titulo"]);$x++){
		if ($_SESSION["menu_item"][$aux]["permission"][$x] == $_SESSION["table"]){	
			$permission = verifica_acesso($_SESSION["table"],'','','1');
			
			echo $permission;
			if  (
				($permission == "Acesso Negado")&&
				(($_GET["table"]!="selecionar_propostas")&&($_SESSION["table"]!="boletos_em_aberto")&&($_SESSION["table"]!="boletos_vencidos")&&($_SESSION["table"]!="boletos_sim"))  
				){
				  exit("Acesso Negado. Seu usu�rio n�o tem privil�gios para executar essa consulta. Por favor, entre em contato com o Administrador do Sistema");	
			}
		}	
	}	
}	




if ($_GET["titulo"]){
	$titulo =  urldecode($_GET["titulo"]);
}else{
	$titulo = utf8_decode($class_table_variables -> titulo);
}

if ($_GET["order_tbl"]) $_SESSION["order"] = $_GET["order_tbl"];

?>

<script src="../js/functions.js" type="text/javascript"></script>
<script src="../js/functions_form_validation.js" type="text/javascript"></script>
<link  href="../css/conteudo.css" rel="stylesheet" type="text/css" >
<? 


//configura��es para entrada de dados ------------------------
$_SESSION["tamanho_grid"]='100%';
//-----------------------------------------------------------------------------

if (($_GET["zera_consulta"])||($_SESSION["ultima_tabela"]!=$_GET["table"])){ //zera consulta na troca de tabelas
	$_SESSION["localizar"]="";
	$_SESSION["fields_value"]="";		
	$_SESSION["ultima_tabela"]=$_GET["table"];
}

//print_r($_SESSION["hidefield_vetor"]);
//if ($_GET["events"]){
	//$_SESSION["events"]=$_GET["events"];
//}
//print_r($_GET);exit();
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------

//-----------------------------------------------------------------------------
if ($_GET["zera_consulta"]){ //zera consulta na troca de tabelas
	$_SESSION["localizar"]="";
	$_SESSION["fields_value"]="";		
}
//-----------------------------------------------------------------------------
//print_r($_GET);exit();
//-----------------------------------------------------------------------------
//quantidade de registros mostrados na pagina��o
if ($_GET["max_res"]){
	$_SESSION["max_res"]=$_GET["max_res"];
}
//-----------------------------------------------------------------------------
//-----------ativa componente de ordena��o de tabelas----------------------------
//-----------------------------------------------------------------------------
/*
if ($_GET["ordenar_anexo"]){
	$conn = db_connect();  
	$Codigo = substr($Valor,strlen(stristr($Valor,",")+1), strlen($Valor));
	$Ordem  = substr($Valor,strlen(stristr($Valor,",")+1), strlen($Valor));
	$Codigo = explode(",",$Codigo);
	$Ordem = explode(",",$Ordem);
	//print_r($Codigo );exit();
	for( $Var = 0; $Var < Count($Codigo); $Var++ ){
		$OrdemGravacao[] = substr($Codigo[$Var], - 1, strlen($Codigo[$Var]) + strlen (stristr ($Codigo[$Var],"|")));
		$Comparacao[] = substr($Codigo[$Var], - strlen($Codigo[$Var]), strlen($Codigo[$Var]) - strlen(stristr($Codigo[$Var],"|")));
	}
	$sqlSoma = "";
	for( $Var1 = 0; $Var1 < Count($OrdemGravacao); $Var1++ ){
		// 	echo $Comparacao[$Var1]."-".$OrdemGravacao[$Var1];
		//exit($Comparacao[$Var1]);
		$UpdateOrdem = "update ".$_SESSION["table"]."	
				 set ordem = '$Var1'
				 where id_tipo = '$Comparacao[$Var1]'";
		$sqlSoma .=	$UpdateOrdem.";" ;		
		$QueryUpdate = mysql_query ($UpdateOrdem, $conn);  
		//exit($UpdateOrdem);
	}
	
	insert_log("ordenar_modalidade",$sqlSoma,$_SESSION["table"]);
	
	if (!mysql_error()){     
		if ($_SESSION["table"]=="t_licitacoes_type"){ // somente para talela t_licitacoes_type
			echo '<SCRIPT>atualiza_conteudo("../refresh_menu.php","refresh_menu=yes","POST","handleHttpRefreshMenu");</SCRIPT>';
		}
	}else{
		 echo '<SCRIPT>window.alert("N�o foi poss�vel realizar a Ordena��o!!! \nVerifique se existe o campo ordem nesta tabela")</SCRIPT>';
	}
}
*/
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
echo '<body onload="">'; 
?>
<center>
<table cellpadding="0" width="99%" cellspacing="0" style="margin:5px 1px 0px 1px;">
  <tr>
    <td  class="top_esq" ></td>
    <td class="topo" style="text-align:center;font-weight:bold;font-size:16px;vertical-align:top;padding-top:3px; ">
<?

if  (
	($_POST["localizar"] != "")||	
	($_SESSION["localizar"] != "")
	){	
			if (DBConnect::database=="mysql"){    //MySQL	
				  ////////////////////////////////////////////////
				  ///////////////// campos foreign key //////////
				  ///////////////////////////////////////////////
				  $result = return_query("SELECT * FROM ".$_SESSION["table"]." LIMIT 1 ");	
			  //	$describe = db_describe_table($_SESSION["table"]);
				  $num = db_num_fields($result);			
				  $field_name = array();
				  for ($i = 0; $i < $num; ++$i) {		 
					  $field = db_fetch_field($result, $i);
				  //	$field->definition = db_result($describe, $i, 'Type');	
					  $field->len = db_field_len($result, $i); // Create the field length
					  $field_name[] = $field->name;					
					  $field_multiple_key[] =  $field->multiple_key ;			
				  }			
				  foreach ($field_multiple_key as $a => $b){
						if ($b != '1'){
						   unset($field_name[$a]);
						   unset($field_multiple_key[$a]);
						}
				  }
				  //print_r ($field_name);print_r ($field_multiple_key);			
				  //////////////////////////////////////		
			}	
			
}




if ($_POST["localizar"] != ""){		
	if ($_POST["state_gif"]==1){
		$_SESSION["localizar"]="";
		$_SESSION["fields_value"]="";
	}else{
		$_SESSION["localizar"]=$_POST["localizar"];
		$_SESSION["fields_value"]=$_POST["fields_value"];
		$LocalizarLike = "%".$_POST["localizar"]."%";	  
		$campo = split(",",$_POST["fields_value"]);			
		for ($x=0;$x<(count($campo));$x++){	
			if (($campo[$x] != "ativado")&&($campo[$x] != "aux")){ // n�o busca no campo ativado	
						/////////////////////////////////////////////////////
						 if(
								(
								($_SESSION["table"]=="contribuicoes") ||
								($_SESSION["table"]=="propostas") ||
								($_SESSION["table"]=="inspiracoes")						
								) &&  (
										($campo[$x] == "selecionado")|| 
									   ($campo[$x] == "id_participante") || 
									   ($campo[$x] == "id_topico") ||  
									   ($campo[$x] == "id_desafio") || 
									   ($campo[$x] == "proposta")||  
									   ($campo[$x] == "media_votacao") || 
									   ($campo[$x] == "votos")||  
									   ($campo[$x] == "curtidas")
									   )
						   )
						 {
						 // todo
					    }else{
								 if ($sql_localizar != "") {$sql_localizar .= " OR ";}						 
								 //////////////////////////////////////////////////
								 if (					 
									((DBConnect::database=="mysql")&&(array_search($campo[$x], $field_name)!== FALSE)) ||  //MySQL
									 (DBConnect::database=="postgresql") //PostgreSQL						 
									 ){					 
									 $get_name_field_fk = get_table_foreign_key($_SESSION["table"],$campo[$x]);
									 
									 if ($get_name_field_fk){
										   $arr = explode("|",$get_name_field_fk);
										   $sql_localizar .= " ".$campo[$x]."  in ( 		
																				  SELECT ".$arr[2]."
																				  FROM ".$arr[0]."
																				  WHERE ".$arr[1]." Like '".$LocalizarLike."'																
																				  )";
									 }
								 }else{
									$sql_localizar .= " ".$campo[$x]."  Like '".$LocalizarLike."'";
								 }
								 //////////////////////////////////////////////////		
						}
						////////////////////////////////////////////////////
				 
			
			}
		}  
 	}     
}else{
		if ($_SESSION["localizar"] != ""){
			$LocalizarLike = "%".$_SESSION["localizar"]."%";	  
			$campo = split(",",$_SESSION["fields_value"]);		
			
  			for ($x=0;$x<(count($campo));$x++){
				if (($campo[$x] != "ativado")&&($campo[$x] != "aux")){ // n�o busca no campo ativado
				
						/////////////////////////////////////////////////////
						 if(
								(
								($_SESSION["table"]=="contribuicoes") ||
								($_SESSION["table"]=="propostas") ||
								($_SESSION["table"]=="inspiracoes")						
								) &&  (
									   ($campo[$x] == "id_participante") || 
									   ($campo[$x] == "id_topico") ||  
									   ($campo[$x] == "id_desafio") || 
									   ($campo[$x] == "proposta")||  
									   ($campo[$x] == "media_votacao") || 
									   ($campo[$x] == "votos")||  
									   ($campo[$x] == "curtidas")
									   )
						   )
						 {
						  //todo
					    }else{	
							 if ($sql_localizar != "") {$sql_localizar .= " OR ";}	
							 //////////////////////////////////////////////////
							 if (					 
								((DBConnect::database=="mysql")&&(array_search($campo[$x], $field_name)!== FALSE)) ||  //MySQL
								 (DBConnect::database=="postgresql") //PostgreSQL						 
								 ){
								 $get_name_field_fk = get_table_foreign_key($_SESSION["table"],$campo[$x]);
								 
								 if ($get_name_field_fk){
									   $arr = explode("|",$get_name_field_fk);
									   $sql_localizar .= " ".$campo[$x]."  in ( 		
																			  SELECT ".$arr[2]."
																			  FROM ".$arr[0]."
																			  WHERE ".$arr[1]." Like '".$LocalizarLike."'																
																			  )";
								 }
							 }else{
								$sql_localizar .= " ".$campo[$x]."  Like '".$LocalizarLike."'";
							 }
							 //////////////////////////////////////////////////							
						}
						////////////////////////////////////////////////////
						
				
				}
	 	    }   	
		}	
		//exit($sql_localizar);
}

if ($_POST["filtro_consulta"] != ""){	  
	  if ($id_situacao)	{	
	 		 if ($sql_add != "") $sql_add .= " AND ";
			$sql_add .=  " id_situacao = '".$id_situacao."'";			 
	  }
	
	  
	  if ($id_nivel_maturidade){
		  	if ($sql_add != "") $sql_add .= " AND ";
			$sql_add .=  " id_nivel_maturidade = '".$id_nivel_maturidade."'";
	  }
		
	  
	  if ($cnpj){
		  	if ($sql_add != "") $sql_add .= " AND ";					
			$sql_add .=  " id_empresa = (
									SELECT id_empresa
									FROM empresas
									WHERE cnpj = '".limpaCpf_Cnpj($cnpj)."' 
									LIMIT 1
									 )  ";
			
	  }		
		
	  
	  if ($razao_social){
		  	if ($sql_add != "") $sql_add .= " AND ";					
			$sql_add .=  " id_empresa in (
									SELECT id_empresa
									FROM empresas
									WHERE razao_social like '%".$razao_social."%' 
									
									 )  ";
			
	  }
	  
	  
	  if ($nome_fantasia){
		  	if ($sql_add != "") $sql_add .= " AND ";					
			$sql_add .=  " id_empresa in (
									SELECT id_empresa
									FROM empresas
									WHERE nome_fantasia like '%".$nome_fantasia."%' 
									
									 )  ";
			
	  }

	  
	  if  ( ($data_inicio)&&($data_fim) ){
			if ($sql_add != "") $sql_add .= " AND ";
			$sql_add .=  " data_inclusao  > '".data_us($data_inicio)."' AND  data_inclusao  < '".data_us($data_fim)."'" ;		
	  }
}

//-------------------- no vo -----------------------------------------------------
//-----------------------------------------------------------------------------
if ($titulo){
	echo $titulo;
	
	if (count($_SESSION["listfield_vetor"]) == 1){
		$campos_sql=$_SESSION["listfield_vetor"];
	}else{		
		for($x=0;$x<count($_SESSION["listfield_vetor"]);$x++){
			$campos_sql .= $_SESSION["listfield_vetor"][$x];	
			($x == intval(count($_SESSION["listfield_vetor"])-1))? "":$campos_sql .= ",";
		}
	}	

	$sql = "SELECT ".$campos_sql." FROM ".$_SESSION["table"];	



if ($_SESSION["table"]=="relatorio_operacoes"){	
		$sql = "SELECT ".$campos_sql." FROM log";			
		if (($_SESSION["data_inicial_operacoes"] != "")&&($_SESSION["data_final_operacoes"] != "")){	
				$sql .= " where ( data_atualizacao >=  '".$_SESSION["data_inicial_operacoes"]."' and data_atualizacao <= '".$_SESSION["data_final_operacoes"]."'   ) ";	
		}		
		if ($_SESSION["relatorio_filtro_login"] != ""){
			  if (stristr($sql,"where")){
				  $sql .= " and  ( id_usuario = '".$_SESSION["relatorio_filtro_login"]."' ) ";
			  }else{
				  $sql .= " where  ( id_usuario = '".$_SESSION["relatorio_filtro_login"]."' ) ";		
			  }
		}		
	//	insert_log("gerar_relatorio_log",$sql);
}	
	
	
	


	if (utf8_decode($class_table_variables -> where) != ""){
			if (stristr($sql,"where")){
				$sql .= " and ( ".$class_table_variables -> where ." ) ";
			}else{
				$sql .= " where ( ".$class_table_variables -> where." ) ";		
			}		
	}

	
		
	if ($sql_localizar){	
		if (stristr($sql,"where")){
			$sql .= " and ( ".$sql_localizar ." ) ";
		}else{
			$sql .= " where ( ".$sql_localizar." ) ";		
		}			
	}	
	
	
	if ($sql_add){	
		if (stristr($sql,"where")){
			$sql .= " and ( ".$sql_add ." ) ";
		}else{
			$sql .= " where ( ".$sql_add." ) ";		
		}			
	}			

	if (!$_GET["type"]){
	$sql .= " ORDER BY ".$_SESSION["order"];
	}
}else{
	exit();	
}

//echo $sql;


				 ?>
    </td>
    <td  class="top_dir"></td>
  </tr>
  
  
  
  
  <tr>
  
    <td class="midle_esq">&nbsp;</td>
      
  <td  class="topo">
  
  <table bgcolor="#ffffff" style="background-color:#f2F2FB; border-collapse:collapse;width:100%; " cellpadding="0" cellspacing="0" >
    <tr>
    <td>
    
    <table cellspacing="5" bgcolor="">
      <tr>
        <td><? if (($_POST["mensagem"])||($_GET["mensagem"])){?>
          <div class="aviso" style="text-indent:0px;font-weight:bold;font-size:12px;" id="mensagem_txt">
            <?=$_POST["mensagem"].$_GET["mensagem"]?>
          </div>
          <? } ?>
          <div style="padding-top:3px;"></div></td>
      </tr>
      <tr>
      <td>
      
      <table width="100%"  cellpadding="0" cellspacing="0" >
        <tr>
          <td style="text-align:left;font-weight:bold;font-size:12px;color:#15428b;" colspan="3" > Linhas:
       
		<? $class_relationship_restrition -> filtro($id_tipo); ?>
            
            
            
          <?
if ($_SESSION["max_res"]=="") $_SESSION["max_res"]=10;


?>
       
            <div style="position:absolute">
            <form name="">
              </div>
              <select name="" onChange="combo_resultados(this.value,'<? echo $titulo."&table=".$_GET["table"]."&order=".$_SESSION["order"]."&id_tipo=".$id_tipo; ?>','<?= $_SERVER['PHP_SELF']?>');">
                <option value="3" <? if ($_SESSION["max_res"]==3){echo "selected";} ?> >3</option>
                <option value="5" <? if ($_SESSION["max_res"]==5){echo "selected";} ?> > 5</option>
                <option value="7" <? if ($_SESSION["max_res"]==7){echo "selected";} ?> >7</option>
                <option value="10" <? if ($_SESSION["max_res"]==10){echo "selected";} ?> >10</option>
                <option value="15" <? if ($_SESSION["max_res"]==15){echo "selected";} ?> >15</option>
                <option value="20" <? if ($_SESSION["max_res"]==20){echo "selected";} ?> >20</option>
                <option value="30" <? if ($_SESSION["max_res"]==30){echo "selected";} ?> >30</option>
                <option value="50" <? if ($_SESSION["max_res"]==50){echo "selected";} ?> >50</option>
                <option value="100" <? if ($_SESSION["max_res"]==100){echo "selected";} ?> >100</option>
                <option value="500" <? if ($_SESSION["max_res"]==500){echo "selected";} ?> >500</option>
                <option value="1000" <? if ($_SESSION["max_res"]==1000){echo "selected";} ?> >1000</option>
                <option value="2000" <? if ($_SESSION["max_res"]==2000){echo "selected";} ?> >2000</option>
              </select>
              <div style="position:absolute">
            </form>
            </div>
            </td>
          <td style="width:auto;height:21px;vertical-align:top;" >
          &nbsp;
          
          <img src="../images/print.gif" onClick="imprimir();"  title="imprimir" style="cursor:pointer;">
          <img src="../images/html.png" onClick="exporta_consulta('html')"  title="imprimir" style="cursor:pointer;">
          <img src="../images/excel.png" onClick="exporta_consulta('excel')"  title="Gerar Arquivo Excel XLS" style="cursor:pointer;">
	   	  <img src="../images/csv.png" onClick="exporta_consulta('csv')"  title="Gerar Arquivo CSV" style="cursor:pointer;">  
          <img src="../images/pdf20.png" onClick="exporta_consulta('pdf')"  title="imprimir" style="cursor:pointer;">
          <img src="../images/txt.png" onClick="exporta_consulta('txt')"  title="imprimir txt" style="cursor:pointer;">
          <img src="../images/xml.png" onClick="exporta_consulta('xml')"  title="imprimir txt" style="cursor:pointer;">
         
        
          </td>
          <td style="text-align:center;width:170px;"  colspan="2">
            <div style="position:absolute">
           <form name="frmLocalizar" method="post" action="<?=  $_SERVER['PHP_SELF'] ?>?titulo=<?=$titulo?>&order=<?=$_SESSION["order"]?>&table=<?=$_SESSION["table"]?>&id_tipo=<?= $id_tipo ?>">
           	<input type="hidden" name="table" value="<?=$_SESSION["table"]?>">
            </div>
            <? if ($_SESSION["localizar"] != ""){ ?>
            <input onKeyDown="if(event.keyCode=='13'){pesquisar_txt(1);}"  name="txtLocalizar"  class="input" id="txtLocalizar"  onKeyPress="return txtLocalizar_onkeypress();" 
	  value="<?= $_SESSION["localizar"]  ?>"
			<? }else{ ?>	  
            <input onKeyDown="if(event.keyCode=='13'){pesquisar_txt(0);}"  name="txtLocalizar"  class="input" id="txtLocalizar"  
	  value=""
	        <? } ?>		
		  size=15 style="text-align:left;width:80%;text-indent:0px;margin-right:5px;margin-left:4px;" />

			  <? if ($_SESSION["localizar"] != ""){ ?>
              <a style="border:0px;" href="javascript:pesquisar_txt(1);"><img  alt="Localizar" src="../images/undo.gif" style="height:16px;width:16px;border:0;text-indent:0px;"   align="absmiddle"/></a>
              <? }else{ ?>
              <a style="border:0px;" href="javascript:pesquisar_txt(0);"><img  alt="Localizar" src="../images/localizar.gif" style="height:21px;width:21px;border:0;text-indent:0px;"   align="absmiddle" /></a>
              <? } ?>
              
              
              	
              </td>
            <td >
            <div style="position:absolute">
              <input type="hidden" name="localizar" value="">
              <input type="hidden" name="fields_value" value="">
              <input type="hidden" name="state_gif" value="">
              <input type="hidden" name="valor_antigo" value="" id="valor_antigo">
			  <input type="hidden" name="portable_data"  id="portable_data" value="">
              <input type="hidden" name="matrix_data"  id="matrix_data" value="">
          </form>
          </div>
          <?= btn_incluir($cols_number,''); ?>
        </td>
        </tr>
      </table>
      </td>
      </tr>
      
      <tr>
        <td style="text-align:center;background-color:#cccccc;" ><div style="height:14px;font-size:13px;background-color:#ffffff;" id="label_resultados">Resultados:</div></td>
      </tr>
      <tr>
      <td>
      
      <div style="position:absolute;">
      
      <form name="frmlistar" method="post" >
      
      </div>
      
      </td>
      </tr>
      
      <tr>
        <td><?  
  //-----------------------------------------------------------------------------	
	
  	$connect = new DBConnect;
  	
  	$grid = new datagrid;
	$grid -> server     = DBConnect::host;
	$grid -> user       = DBConnect::user;
	$grid -> password   = DBConnect::passwd;
	$grid -> database   = DBConnect::database; 
	$grid -> table      = $_SESSION["table"];
	$grid -> titulo     = $titulo;
	$grid -> id_tipo    = $id_tipo;
	$grid -> order      = $_SESSION["order"];
	$grid -> primary_key= $_SESSION["primary_key"];
	$grid -> SQL($sql);
	
	
			
	if (count($_SESSION["hidefield_vetor"]) == 1){
			eval('$grid -> HideField("'.$_SESSION["hidefield_vetor"].'");');	
	}else{		
		for($x=0;$x<count($_SESSION["hidefield_vetor"]);$x++){
			eval('$grid -> HideField("'.$_SESSION["hidefield_vetor"][$x].'");');	
		}
	}	
		
	$xml = simplexml_load_file("../xml/rename_col_header.xml");

	foreach($xml->field as $field){
		 $grid -> RenameCol((string)$field->old,(string)utf8_decode($field->new)); // Old field ==> New field  
	}
	   
	if ( ($_SESSION["table"] == "solicitacoes")||($_SESSION["table"] == "andamento") )   {
	     $grid -> RenameCol("data_inclusao","In�cio Solicita��o"); // Old field ==> New field 
	}else{
	     $grid -> RenameCol("data_inclusao","Data Inclus�o"); // Old field ==> New field 
	}
	 
	
	/*	$grid -> HideField("tipo");	*/	
	$grid -> th_style("");    	
	$grid -> tr_style("");
  	$output = $grid->create_grid();
  //-----------------------------------------------------------------------------

    echo $output;      
    echo '</td></tr> </form> <tr><td>';   	
	
	
	
	

  	

?></td>
      </tr>
    </table>
    
    
    </td>
    </tr>
    
  </table>
  </td>
  
  <td style="background-image:url(../images/midle_dir_extjs.gif);background-repeat:repeat-y;width:9px;height:100%;">&nbsp;</td>      
  </tr>
  
  
  <tr>
    <td style="background-image:url(../images/botton_esq_extjs.gif);width:9px;height:8px;"></td>
    <td style="background-image:url(../images/botton_extjs.gif);background-repeat:repeat-x;"></td>
    <td style="background-image:url(../images/botton_dir_extjs.gif);width:9px;height:8px;";></td>
  </tr>
</table>
</center>
<br /><br />
</body>
<script> $('a.title').cluetip({splitTitle: '|'}); //tooltip init() </script>

<? 
//$layout -> initialize_window_pop();

//comprimir_PHP_finish(); // compressao de p�ginas com GZip
 ?>
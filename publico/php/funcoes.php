<?


//ini_set( 'error_reporting', E_ALL ^ (E_NOTICE | E_DEPRECATED) ); // mostra todas mensagens exceto notice e deprecated
//ini_set( 'display_errors', '1' );

ini_set("display_errors", "0"); //Retira o Warning


function db_connect(){   
	 $connect = new DBConnect;	
	// abre a conex�o com o banco de dados
	if (DBConnect::database=="postgresql"){     
			if( $result = pg_pconnect("host=".DBConnect::host." dbname=".DBConnect::database_name." user=".DBConnect::user." password=".DBConnect::passwd)){ 	       
					return $result;     
			} else {
					echo "<script>alert('Servidor n�o encontrado: ".DBConnect::host."');</script>";
					exit();
			}
	}
	if (DBConnect::database=="mysql"){     
			if( $result = @mysql_pconnect(DBConnect::host, DBConnect::user, DBConnect::passwd) ){
					if( $conect_db = @mysql_select_db(DBConnect::database_name,$result) ){
				   		  return $result;
					} else {
						  echo "<script>alert('DBConnect::database n�o encontrado: ".DBConnect::database_name."');</script>";
						  exit();
					}
					return $result;
			} else {
					echo "<script>alert('Servidor n�o encontrado: ".DBConnect::host."');</script>";
					exit();
			}
	}	
}



function IOException($result,$sql){			
	if (!$result) {		
		  // send mail to system administrator
		  if (DBConnect::database=="postgresql") {	
			/*	echo '<script>alert("'.pg_last_error().'");</script>';*/
				$erro = pg_last_error();
		  }
		  if (DBConnect::database=="mysql") {
			/*	echo '<script>alert("'.mysql_error().'");</script>';*/	
				$erro = mysql_error();				
		  }				
		      mail("paulo.enok@ima.sp.gov.br","SQL nao executado - ".InfoSystem::nome_sistema,"IP: ".$_SERVER['REMOTE_ADDR']."\n URL: ".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."\n Data: ".date("d/m/Y H:i:s")."\n Erro: ".$erro."\n SQL: ".safe_text($sql));
			 return $erro;
	}
}

// only mysql
function list_tables(){
  $conn = db_connect();  
  $result  = mysql_list_tables(DBConnect::database_name);
  IOException($result,'');
  return($result);
}


function get_record($sql){
    $conn = db_connect();  	
	if (DBConnect::database=="postgresql"){ 
		  $result = pg_exec($conn, $sql);
		  IOException($result,$sql);
		  return(pg_fetch_array($result));
	}	
	if (DBConnect::database=="mysql"){ 			
		$result = mysql_query($sql, $conn);				
		IOException($result,$sql);		
		return(mysql_fetch_array($result));
	}  
}


function return_query($sql){
  $conn = db_connect();   
	if (DBConnect::database=="postgresql"){ 
		  $result = pg_exec($conn, $sql);
		  IOException($result,$sql);
		  return($result);
	}	
	if (DBConnect::database=="mysql"){
		  $result = mysql_query($sql, $conn);
		  IOException($result,$sql);
		  return($result);
	}
}

function numrows($sql){
  $conn = db_connect();  
	if (DBConnect::database=="postgresql"){ 	
		  $result = pg_exec($conn, $sql);	
		  IOException($result,$sql);
		  return(pg_numrows($result));
	}	
	if (DBConnect::database=="mysql"){
		  $result = mysql_query($sql, $conn);
		  IOException($result,$sql);
		  return(mysql_num_rows($result));
	} 
}

function insert_record($sql){
 	$conn = db_connect();    
	if (DBConnect::database=="postgresql")
		  $result = pg_exec($conn, $sql);	
	if (DBConnect::database=="mysql")
		  $result = mysql_query($sql, $conn);	
	
	IOException($result,$sql);	
	if (!$result) {			
		  if (DBConnect::database=="mysql")	  
				echo '<script>alert("N�O foi poss�vel INSERIR esse registro, alguns dados inseridos podem estar duplicados ou ter refer�ncias que ferem a consist�ncia do sistema");</script>';	
		  exit();
	}else{
		  return($result);
	}
	
}


function insert_nounces($sql){
 	$conn = db_connect();    
	if (DBConnect::database=="postgresql")
		  $result = pg_exec($conn, $sql);	
	if (DBConnect::database=="mysql")
		  $result = mysql_query($sql, $conn);		
	return $result;
}




function delete_record($sql){
 	$conn = db_connect();    
	if (DBConnect::database=="postgresql")
		  $result = pg_exec($conn, $sql);	
	if (DBConnect::database=="mysql")
		  $result = mysql_query($sql, $conn);	
		  
	IOException($result,$sql);	
	if (!$result) {			
		  if (DBConnect::database=="mysql")	  
				echo '<script>alert("N�O foi poss�vel excluir esse registro, pois ele j� est� sendo usado em outra tabela do sistema");</script>';	
		  exit();
	}else{
		  return($result);
	}
}

function update_record($sql){
 	$conn = db_connect();    
	if (DBConnect::database=="postgresql")
		  $result = pg_exec($conn, $sql);	
	if (DBConnect::database=="mysql")
		  $result = mysql_query($sql, $conn);	
	IOException($result,$sql);	
	if (!$result) {			
		  if (DBConnect::database=="mysql")	  
				echo '<script>alert("N�O foi poss�vel fazer essa altera��o, alguns dados inseridos podem estar duplicados ou ter refer�ncias que violam a consist�ncia de dados j� gravados em outras tabelas");</script>';	
		  exit();
	}else{
		  return($result);
	}
}





function pg_insert_id($sequence_name) {  //mysql_insert_id()
	  $conn = db_connect();   	 
	  $result = pg_exec($conn, "SELECT last_value FROM $sequence_name");
	  IOException($result,'');
	  $seq_array=pg_fetch_row($result, 0); 
	  return $seq_array[0]; 
}

function db_fetch_field($result){
	if (DBConnect::database=="postgresql") 		  
		  return(pg_fetch_field($result));	
	if (DBConnect::database=="mysql")
		  return(mysql_fetch_field($result));		
}


function db_field_name($result,$i){
	if (DBConnect::database=="postgresql") 		  
		  return(pg_field_name($result,$i));	
	if (DBConnect::database=="mysql")
		  return(mysql_field_name($result,$i));		
}



function db_fetch_row($result){
	if (DBConnect::database=="postgresql") 		  
		  return(pg_fetch_row($result));	
	if (DBConnect::database=="mysql")
		  return(mysql_fetch_row($result));		
}

function db_result($result, $x, $unique_field){
	if (DBConnect::database=="postgresql") 		  
		  return(@pg_fetch_result($result, $x, $unique_field));	// o @ � pra corrrigir bug de warning da versao 8.03 do postgresql
	if (DBConnect::database=="mysql")
		  return(mysql_result($result, $x, $unique_field));		
}

function db_num_fields($result){
	if (DBConnect::database=="postgresql") 		  
		  return(pg_num_fields($result));	
	if (DBConnect::database=="mysql")
		  return(mysql_num_fields($result));		
}


function db_affected_rows($result){
	if (DBConnect::database=="postgresql") 		  
		  return(pg_affected_rows($result));	
	if (DBConnect::database=="mysql")
		  return(mysql_affected_rows());		
}


function db_fetch_array($result){
	if (DBConnect::database=="postgresql") 		  
		  return(pg_fetch_array($result));	
	if (DBConnect::database=="mysql")
		  return(mysql_fetch_array($result));		
}


function db_fetch_object($result){
	if (DBConnect::database=="postgresql") 		  
		  return(pg_fetch_object($result));	
	if (DBConnect::database=="mysql")
		  return(mysql_fetch_object($result));		
}


/*

function pg_list_dbname($conn){
        assert(is_resource($conn));
        $query = '
SELECT
d.datname as "Name",
u.usename as "Owner",
pg_encoding_to_char(d.encoding) as "Encoding"
FROM
pg_DBConnect::database d LEFT JOIN pg_user u ON d.datdba = u.usesysid
ORDER BY 1;
';
        return pg_query($conn, $query);
}

// fields : Name, Owner, Type
function pg_list_table($conn)
{
        assert(is_resource($conn));
        $query = "
SELECT
c.relname as "Name",
CASE c.relkind WHEN 'r' THEN 'table' WHEN 'v' THEN 'view' WHEN 'i' THEN 'index' WHEN 'S' THEN 'sequence' WHEN 's' THEN 'special' END as "Type",
  u.usename as "Owner"
FROM
pg_class c LEFT JOIN pg_user u ON c.relowner = u.usesysid
WHERE
c.relkind IN ('r','v','S','')
AND c.relname !~ '^pg_'
ORDER BY 1;
";
        return pg_query($conn, $query);
}

// fields : attname, format_type, attnotnull, atthasdef, attnum
function pg_list_field($conn, $table)
{
        if(!$table) return 0;
        assert(is_resource($conn));
        $query = "
SELECT
a.attname,
format_type(a.atttypid, a.atttypmod),
a.attnotnull,
a.atthasdef,
a.attnum
FROM
pg_class c,
pg_attribute a
WHERE
c.relname = '".$table."'
AND a.attnum > 0 AND a.attrelid = c.oid
ORDER BY a.attnum;
";
        return pg_query($conn, $query);
}


*/

// funcoes para layout










function body_onload($comando){
echo '<body onLoad="javascript:'.$comando.'">';
}






function data_us($data){
	if (strstr($data, "/")){
		$A = explode ("/", $data);
		$V_data = $A[2] . "-". $A[1] . "-" . $A[0];
	}else{
		$V_data=$data;
	}
	return $V_data;
}

function data_br($data){
	if (strstr($data, "-")){
		$A = explode ("-", $data);
		$V_data = $A[2] . "/". $A[1] . "/" . $A[0];	
	}else{
		$V_data=$data;
	}
	return $V_data;
}


function subtrai_data($data_inicial,$data_final){ //formato US

list($from_year,$from_month,$from_day) = explode("-",$data_inicial);   
list($to_year,$to_month,$to_day) = explode("-",$data_final); 

    if ($to_day < 0) { 
        $to_day = 30 +($to_day); 
        $to_month = $from_month - 1;           
        if ($to_month == 0) {               
            $to_month = 12; 
            $to_year = $from_year - 1; 
        }  
    } 

    $to = ($to_month."-".$to_day."-".$to_year);           

list($to_month,$to_day,$to_year) = explode("-",$to);   

  $from_date = @mktime(0,0,0,$from_month,$from_day,$from_year);   
  $to_date = @mktime(0,0,0,$to_month,$to_day,$to_year);               

  $days = ($to_date - $from_date)/86400;         
   // echo "<br><br>A diferen�a de dias entre duas datas seria: ";       

// Adicionado o ceil($days) para garantir que o resultado seja sempre um n�mero inteiro */ 
    return ceil($days); 
}




function valida_SQL_injection($data){ 
//elimino tags HTML e PHP 
$data = strip_tags($data, '<a><b><i><u><br><br /><em><p><strong><ul><li>'); // nao elimina tags entre aspas
//elimino o caractere aspas simples 
$data = str_replace("'","�",$data); 
//$data = str_replace("#"," ",$data); 
return $data; 
} 

function renew_timeout(){
	/* Define o limitador de cache para 'private' */
//	session_cache_limiter('private');
//	$cache_limiter = session_cache_limiter();
	
//	ini_set(session.gc_maxlifetime, 1440);
//	ini_set(session.cache_expire, 180);
	
	/* Define o limite de tempo do cache em 180 minutos */
	//session_cache_expire(180);
	//$cache_expire = session_cache_expire();
}



function verifica_seguranca(){
	if(!$_SESSION["nome_usuario_session"] or !$_SESSION["login_session"] or (intval(ini_get('session.gc_maxlifetime'))<5) or (ini_get('session.gc_maxlifetime')<5) ){
	session_unset();
	session_destroy();  	
	echo "<script>parent.location.href='../index.php?path=1';</script>";	
	}		
}






function comprimir_PHP_start(){
	ob_start(); 
}
function comprimir_PHP_finish(){
	$cntACmp =ob_get_contents(); 
	ob_end_clean(); 
	$cntACmp=str_replace("\n",' ',$cntACmp); 
	$cntACmp=ereg_replace('[[:space:]]+',' ',$cntACmp); 
	ob_start("ob_gzhandler"); 
	echo $cntACmp; 
	ob_end_flush(); 
}

function safe_text($text) {
	//returns safe code for preloading in textarea
	$tmpString = $text;
	
	//convert all types of single quotes
	$tmpString = str_replace(chr(145), chr(39), $tmpString);
	$tmpString = str_replace(chr(146), chr(39), $tmpString);
	//$tmpString = str_replace("'", "&#39;", $tmpString);
	$tmpString = str_replace("'", "�", $tmpString);
	
	//convert all types of double quotes
	$tmpString = str_replace(chr(147), chr(34), $tmpString);
	$tmpString = str_replace(chr(148), chr(34), $tmpString);
	//$tmpString = str_replace('"', '\"', $tmpString);
	//$tmpString = str_replace(';', "\;", $tmpString);
	$tmpString = str_replace('#', "", $tmpString);
	
	//replace carriage returns & line feeds
	$tmpString = str_replace(chr(10), " ", $tmpString);
	$tmpString = str_replace(chr(13), " ", $tmpString);
	
	return $tmpString;
}


function safe_text_link($text) {
	//returns safe code for preloading in textarea
	$tmpString = $text;
	
	//convert all types of single quotes
	$tmpString = str_replace(chr(145), chr(39), $tmpString);
	$tmpString = str_replace(chr(146), chr(39), $tmpString);
	//$tmpString = str_replace("'", "&#39;", $tmpString);
	$tmpString = str_replace("'", "�", $tmpString);
	$tmpString = str_replace('"', "�", $tmpString);
	//convert all types of double quotes
	$tmpString = str_replace(chr(147), chr(34), $tmpString);
	$tmpString = str_replace(chr(148), chr(34), $tmpString);
	//$tmpString = str_replace('"', '\"', $tmpString);
	//$tmpString = str_replace(';', "\;", $tmpString);
	$tmpString = str_replace('#', "", $tmpString);
	
	//replace carriage returns & line feeds
	$tmpString = str_replace(chr(10), " ", $tmpString);
	$tmpString = str_replace(chr(13), " ", $tmpString);	
	
	$tmpString = strip_tags($tmpString); //  elimina tags
	
	return $tmpString;
}



function tabbedPanelsContent($url){
         create_panel_extjs();
		 require ($url);	     
         end_table_extjs();
}

function create_panel_extjs(){
	echo '
	    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td style="background-image:url(../images/topo_panel_esq_extjs.gif);width:9px;height:8px;"></td>
        <td style="background-image:url(./images/topo_panel_extjs.gif);background-repeat:repeat-x;"><div style="height:8px;"></div></td>
        <td style="background-image:url(./images/topo_panel_dir_extjs.gif);width:9px;height:8px;";></td>
      </tr>
      <tr>
        <td  class="midle_esq"  ></td>
        <td style="background-color:#fff;height:100%;">';
}


function btn_tabs(){
echo '
			    <input type="button" value="go to tab1" onClick="TabbedPanels1.showPanel(0)">
			  <input type="button" value="go to tab2" onClick="TabbedPanels1.showPanel(1)">
			   <input type="button" value="go to tab3" onClick="TabbedPanels1.showPanel(2)">
			   <input type="button" value="go to tab4" onClick="TabbedPanels1.showPanel(2);TabbedPanels2.showPanel(0)">
			  <input type="button" value="go to tab5" onClick="TabbedPanels1.showPanel(2);TabbedPanels2.showPanel(1)">
			   <input type="button" value="go to tab6" onClick="TabbedPanels1.showPanel(2);TabbedPanels2.showPanel(2)">
			   <input type="button" value="CurrenTabIndex" onClick="alert(\'Estou na Aba numero \'+ parseInt(TabbedPanels1.getCurrentTabIndex()+1,10) +\' do form principal\');">			
';

}

function create_table_extjs($width,$height,$titulo){
	
	if(is_dir("../images")) {
		$path = "..";
	}else{
		$path = ".";
	}	
	
	echo '
	    <center><div  id="div_'.$titulo.'"><table width="'.$width.'" cellpadding="0" cellspacing="0" style="margin:5px 1px 0px 1px;" >
      <tr>
        <td class="top_esq"></td>
        <td class="topo"><div id="header_'.$titulo.'" style="height:34px;font-weight:bold;font-size:12px;color:#15428b;line-height:22px;">'.str_replace("_"," ",$titulo).'
		
		
		
		<a onClick="self.print()" ><img src="'.$path.'/images/olho_print.gif" align="right"  style="margin-top:5px;cursor:pointer;" id="olho_print"></a>
		
		<a onClick="imprimir_bloco(this)" ><img src="'.$path.'/images/impressora_icone.gif" align="right"  style="margin-top:5px;cursor:pointer;" id="impressora_icone"></a>
		
		
		
		</div></td>
        <td class="top_dir" ></td>
      </tr>
      <tr>
        <td  class="midle_esq" ></td>
        <td style="background-color:#fff;height:'.$height.';">';
}
function end_table_extjs($path){		
		echo'</td>
        <td style="background-image:url('.$path.'/images/midle_dir_extjs.gif);background-repeat:repeat-y;width:9px;height:3px;";></td>
      </tr>
      <tr>
        <td style="background-image:url('.$path.'/images/botton_esq_extjs.gif);width:9px;height:8px;"></td>
        <td style="background-image:url('.$path.'/images/botton_extjs.gif);background-repeat:repeat-x;"></td>
        <td style="background-image:url('.$path.'/images/botton_dir_extjs.gif);width:9px;height:8px;";></td>
      </tr>
    </table></div></center>
	';	
}


function filtro_menu_titulo($text){			
        //	$search = array ("�","�"," ");
      	//    $replace = array ("c","a","_");
  	    //    $text= str_replace($search, $replace, $text);	
			
			return retirar_acentos($text);
}

  function limpacpf($cpf) {
    $cpf = str_replace( ".", "", $cpf );
    $cpf = str_replace( "-", "", $cpf );
    return $cpf;
  }
  function limpacnpj($cnpj) {
    $cnpj = str_replace( "/", "", $cnpj);
	$cnpj=limpacpf($cnpj);    
    return $cnpj;
  }


function SendMail($From,$FromName,$To,$ToName,$Subject,$Text,$Html,$AttmFiles){
      $OB="----=_OuterBoundary_000";
      $IB="----=_InnerBoundery_001";
      $Html=$Html?$Html:preg_replace("/\n/","{br}",$Text)
      or die("neither text nor html part present.");
      $Text=$Text?$Text:"Sorry, but you need an html mailer to read this mail.";
      $From or die("sender address missing");
      $To or die("recipient address missing");

      $headers ="MIME-Version: 1.0\r\n";
      $headers.="From: ".$FromName." <".$From.">\n";
      $headers.="To: ".$ToName." <".$To.">\n";
      $headers.="Reply-To: ".$FromName." <".$From.">\n";
      $headers.="X-Priority: 1\n";
      $headers.="X-MSMail-Priority: High\n";
      $headers.="X-Mailer: My PHP Mailer\n";
      $headers.="Content-Type: multipart/mixed;\n\tboundary=\"".$OB."\"\n";

      //Messages start with text/html alternatives in OB
      $Msg ="This is a multi-part message in MIME format.\n";
      $Msg.="\n--".$OB."\n";
      $Msg.="Content-Type: multipart/alternative;\n\tboundary=\"".$IB."\"\n\n";

      //plaintext section
      $Msg.="\n--".$IB."\n";
      $Msg.="Content-Type: text/plain;\n\tcharset=\"iso-8859-1\"\n";
      $Msg.="Content-Transfer-Encoding: quoted-printable\n\n";
      // plaintext goes here
      $Msg.=$Text."\n\n";

      // html section
      $Msg.="\n--".$IB."\n";
      $Msg.="Content-Type: text/html;\n\tcharset=\"iso-8859-1\"\n";
      $Msg.="Content-Transfer-Encoding: base64\n\n";
      // html goes here
      $Msg.=chunk_split(base64_encode($Html))."\n\n";

      // end of IB
      $Msg.="\n--".$IB."--\n";

      // attachments
      if($AttmFiles){
          foreach($AttmFiles as $AttmFile){
                $patharray = explode ("/", $AttmFile);
                $FileName=$patharray[count($patharray)-1];
                $Msg.= "\n--".$OB."\n";
                $Msg.="Content-Type: application/octetstream;\n\tname=\"".$FileName."\"\n";
                $Msg.="Content-Transfer-Encoding: base64\n";
                $Msg.="Content-Disposition: attachment;\n\tfilename=\"".$FileName."\"\n\n";

                //file goes here
                $fd=fopen ($AttmFile, "r");
                $FileContent=fread($fd,filesize($AttmFile));
                fclose ($fd);
                $FileContent=chunk_split(base64_encode($FileContent));
                $Msg.=$FileContent;
                $Msg.="\n\n";
          }
      }

      $Msg.="\n--".$OB."--\n";
      mail($To,$Subject,$Msg,$headers);
}



function email_header2(){
  									$html = '
										  <html>
										  <head>
											  <style type="text/css">
												  body {
													  margin: 10px;
													  padding: 10px;
													  font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
													  font-size: 14px;
													  border: 1px dotted #999999;
												  }
												  
												  .destaque {
													  font-weight: bold;
													  color: #000088;
												  }
												  
												  .destaque-fundo {
													  background-color: #FFFF88;
												  }
												  
												  .obs {
													  font-size: 12px;
													  font-weight: bold;
													  color: #880000;
												  }		
											  </style>
										  </head>
										  <body bgcolor="#ffffff">				
											  <table style="width:100%;" cellpadding="0" cellspacing="0" >		
												  <tr >
													  <td style="width:38px" rowspan="2" >			
														  <img width="38px" src="'.InfoSystem::url_site.'/images/pmc_brasao_sem_fundo_100x108.png" align="left" border="0"> 
													  </td>
													  <td>
														  <b style="font-size:14px;"> '.InfoSystem::titulo.' </b>
														  | <b style="font-size:10px;">'.InfoSystem::subtitulo.'</b><br>
														  <b style="font-size:10px;color:#006600;">'.InfoSystem::nome_sistema.'</b><br>			
													  </td>
													  <td></td>
												  </tr>	
												  <tr>
													  <td colspan="2"><hr style="border:1px solid #15428B"></td>
												  </tr>
											  <table>';
											  
											  return $html;
}



function grupo_options($selected){	
	$sql = "select id_nivel,nome_nivel  from niveis_acesso  where (data_cancelamento is NULL OR data_cancelamento = '') order by id_nivel";		
	if (numrows($sql)>0){
			$result = return_query($sql);
			$cells_conteudo .= '<select name="id_nivel"  class="x-form-text x-form-field"   >';
			$cells_conteudo .= '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){				
				$cells_conteudo .= "<option value=\"".$rs['id_nivel']."\" ";
				if ($selected == $rs['id_nivel']) $cells_conteudo .= "selected";
				$cells_conteudo .= " >".$rs['nome_nivel']."</option>\n";
			} 	
			$cells_conteudo .= '</select>';
	}else{
		$cells_conteudo .= '<span style="color:#f00;font-weight:bold;">N�o h� nivel cadastrado</span>';
	}
	return $cells_conteudo;
}


function get_nivel_acesso($selected){			
	$sql = "select id_nivel,nome_nivel  from niveis_acesso  where (data_cancelamento is NULL OR data_cancelamento = '') order by id_nivel";	
	if (numrows($sql)>0){
			$result = return_query($sql);
			$cells_conteudo .= '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){				
				$cells_conteudo .= "<option value=\"".$rs['id_nivel']."\" ";
				if ($selected == $rs['id_nivel']) $cells_conteudo .= "selected";
				$cells_conteudo .= " >".$rs['nome_nivel']."</option>\n";
			} 				
	}else{
		$cells_conteudo .= '';
	}
	return $cells_conteudo;
	exit();
}




function situacao_options($selected){	
	$sql = "select id_situacao,nome_situacao  from situacao  order by nome_situacao";		
	if (numrows($sql)>0){
			$result = return_query($sql);
			echo '<select name="id_situacao"    >';
			echo '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){				
				echo "<option value=\"".$rs['id_situacao']."\" ";
				if ($selected == $rs['id_situacao']) echo "selected";
				echo " >".$rs['nome_situacao']."</option>\n";
			} 	
			echo '</select>';
	}else{
		echo '<span style="color:#f00;font-weight:bold;">N�o h� Situa��o Cadastrada</span>';
	}
}






function secretaria_options($selected){	
	$sql = "select id_secretaria,nome_secretaria  from secretarias order by nome_secretaria";		
	if (numrows($sql)>0){
			$result = return_query($sql);
			echo '<select name="id_secretaria"    >';
			echo '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){				
				echo "<option value=\"".$rs['id_secretaria']."\" ";
				if ($selected == $rs['id_secretaria']) echo "selected";
				echo " >".$rs['nome_secretaria']."</option>\n";
			} 	
			echo '</select>';
	}else{
		echo '<span style="color:#f00;font-weight:bold;">N�o h� Secretaria cadastrada</span>';
	}
}



				   



	


			




function selectTrueFalse($campo,$selected){	
			echo '<select name="'.$campo.'"   >';
			echo '<option value="">selecione</option>';
			echo '<option value="S" ';
    		if ($selected == 'S') echo " selected ";
    		echo " >Sim</option>\n";
			echo '<option value="N" ';
    		if ($selected == 'N') echo " selected ";
    		echo " >N�o</option>\n";
			echo '</select>';
}



function selectTipoEntrada($campo,$selected){	
			echo '<select name="'.$campo.'"   >';
			echo '<option value="">selecione</option>';
			echo '<option value="R" ';
    		if ($selected == 'R') echo " selected ";
    		echo " >Sele��o �nica (RadioBox)</option>\n";
			echo '<option value="C" ';
    		if ($selected == 'C') echo " selected ";
    		echo " >Multi-Sele��o (CheckBox)</option>\n";
			echo '</select>';
}	






function login_options($selected){	
	$sql = "select id_usuario,login from usuario order by login";		
	if (numrows($sql)>0){
			$result = return_query($sql);
			echo '<select name="id_nivel"  class="x-form-text x-form-field"  onchange="relatorio_filtro_login(this.value)" >';
			echo '<option value="">todos</option>';
			while( $rs = db_fetch_array($result) ){				
				echo "<option value=\"".$rs['id_usuario']."\" ";
				if ($selected == $rs['id_usuario']) echo "selected";
				echo " >".$rs['login']."</option>\n";
			} 	
			echo '</select>';
	}else{
		echo '<span style="color:#f00;font-weight:bold;">N�o h� usuario cadastrado</span>';
	}
}



function grupo_acesso_options($selected){
	$sql = "select id_nivel, nome_nivel  from niveis_acesso  where data_cancelamento is NULL order by id_nivel";		
	$result=return_query($sql);	
	if($selected){
			while( $rs_grupo_acesso = db_fetch_array($result) ){
				$return .= "<option value=\"".$rs_grupo_acesso['id_nivel']."\" ";
				if ($selected == $rs_grupo_acesso['id_nivel']) $return .= "selected";
				$return .= " >".$rs_grupo_acesso['nome_nivel']."</option>\n";
			} 
			return $return;
			exit();
	}else{
			echo '<select name="id_nivel"  class="x-form-text x-form-field"><option value="">selecione</option>';
			while( $rs_grupo_acesso = db_fetch_array($result) ){
				echo "<option value=\"".$rs_grupo_acesso['id_nivel']."\" ";
				echo " >".$rs_grupo_acesso['nome_nivel']."</option>\n";
			} 
			echo ' </select>';			
	}
}


function ativado_options($selected){	
	if (ereg ("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}", data_br(substr($selected,0,10)),$regs)) {
			$cells_conteudo .= '<option value="" >sim</option><option value="'.$selected.'" selected> n&atilde;o</option></select>';		 
	}else{ 	
	
			$cells_conteudo .= '<option value="" selected>sim</option><option value="'.date("d/n/Y").'">n&atilde;o</option>';	
	}
	return $cells_conteudo;
	exit();
}

function get_situacao($id_situacao){			
	$sql = "select id_situacao,nome_situacao  from situacao  order by nome_situacao";		
	if (numrows($sql)>0){
			$result = return_query($sql);
			$cells_conteudo .= '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){				
				$cells_conteudo .= "<option value=\"".$rs['id_situacao']."\" ";
				if ($id_situacao == $rs['id_situacao']) $cells_conteudo .= "selected";
				$cells_conteudo .= " >".$rs['nome_situacao']."</option>\n";
			} 			
	}else{
		$cells_conteudo .= '';
	}
	return $cells_conteudo;
	exit();
}





function get_subcategoria($id_subcategoria,$row){			
	$sql = "select id_subcategoria,nome_subcategoria  
			from sub_categorias  
			where id_categoria = '".$row["id_categoria"]."'
			and id_campanha = '".$row["id_campanha"]."'
			order by nome_subcategoria";		
	if (numrows($sql)>0){
			$result = return_query($sql);
			$cells_conteudo .= '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){				
				$cells_conteudo .= "<option value=\"".$rs['id_subcategoria']."\" ";
				if ($id_subcategoria == $rs['id_subcategoria']) $cells_conteudo .= "selected";
				
				if (strlen($rs['nome_subcategoria']) > 30){
					$cells_conteudo .= " >".substr($rs['nome_subcategoria'],0,27)."...</option>\n";
				}else{
					$cells_conteudo .= " >".$rs['nome_subcategoria']."</option>\n";
				}
			} 			
	}else{
		$cells_conteudo .= '';
	}
	return $cells_conteudo;
	exit();
}



function get_categoria($id_categoria,$row){	
$sql = "select id_categoria,nome_categoria  
			from categorias  
			where  id_campanha = '".$row["id_campanha"]."'
			order by nome_categoria";		
	if (numrows($sql)>0){
			$result = return_query($sql);
			$cells_conteudo .= '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){				
				$cells_conteudo .= "<option value=\"".$rs['id_categoria']."\" ";
				if ($id_categoria == $rs['id_categoria']) $cells_conteudo .= "selected";
				
				if (strlen($rs['nome_categoria']) > 30){
					$cells_conteudo .= " >".substr($rs['nome_categoria'],0,27)."...</option>\n";
				}else{
					$cells_conteudo .= " >".$rs['nome_categoria']."</option>\n";
				}
			} 			
	}else{
		$cells_conteudo .= '';
	}
	return $cells_conteudo;
	exit();
	
}



function get_entidade($id_entidade){			
	$sql = "select nome_entidade  from entidade 
			WHERE id_entidade='".$id_entidade."' limit 1";	
	if ($rs = get_record($sql)){
		return $rs["nome_entidade"];
	}
}




function get_select_true_false($value){					
				if ($value=="S"){		
						$str .= '<option value="S" selected>sim</option><option value="N">n&atilde;o</option></select>';
				}else{
						$str .= '<option value="S" >sim</option><option value="N" selected> n&atilde;o</option></select>';
				}	
	return $str;	
}




function get_senhas_espera($id_viagem){	
		$sql = "select sum(quantidade_passagem) as total from senha WHERE espera = 'S' and id_viagem='".$id_viagem."' limit 1";
		if ($rs = get_record($sql)){
			return $rs["total"];
		}
}


function get_servico($cod_servico){	
		$sql = "select nome from servicos WHERE cod_servico='".$cod_servico."' limit 1";
		if ($rs = get_record($sql)){
			return $rs["nome"];
		}
}

function get_login($id_usuario){	
		$sql = "select login from usuarios WHERE id_usuario='".$id_usuario."' limit 1";
		if ($rs = get_record($sql)){
			return $rs["login"];
		}
}

function get_operacao($id_operacao){	
		$sql = "select descricao_operacao from operacoes WHERE id_operacao='".$id_operacao."' limit 1";
		if ($rs = get_record($sql)){
			return $rs["descricao_operacao"];
		}
}


function get_campanha($id_campanha){	
		$sql = "select nome_campanha  from campanhas  WHERE id_campanha='".$id_campanha."' limit 1";
		if ($rs = get_record($sql)){
			return $rs["nome_campanha"];
		}
}


function get_campanha_combo($id_campanha){	
	  // seleciona a campanha
	$sql_campanha = "select id_campanha,nome_campanha from campanhas order by nome_campanha"; 
		if ($result_campanha = return_query($sql_campanha)){
			while ($rs_campanha= mysql_fetch_array($result_campanha)){	
				  echo '<option value="'.$rs_campanha["id_campanha"].'" ';
				  if ($id_campanha == $rs_campanha["id_campanha"]) echo ' selected ';
				  echo ' >'.$rs_campanha["nome_campanha"].'</option>';
			}
		}
}




function get_fisica_juridica($value){			
		if ($value == 'F'){
			return 'F�sica';
		}else if ($value == 'J'){
			return 'Jur�dica';
		}else{
			return '';
		}			
}




function insert_log($operacao_interna,$sql_log,$resumo){	
		$sql_operacao_interna = "select id_operacao from operacoes WHERE operacao_interna='".trim($operacao_interna)."' limit 1";
		if ($rs_op = get_record($sql_operacao_interna)){			
			$sql = "insert into log_sys (id_usuario,data_log,sql_text,id_operacao,resumo) VALUES('".$_SESSION["id_usuario_session"]."','".date("Y-m-d H:i:s")."','".safe_text($sql_log)."','".$rs_op["id_operacao"]."','".$resumo."')";			
			insert_record($sql);		
		}
}


function converte_reais($valor){
        return number_format($valor,2,",",".");
}

function formatarCPF_CNPJ($campo, $formatado = true){ 
           //retira formato 
           $codigoLimpo = ereg_replace("[' '-./ t]",'',$campo); 
           // pega o tamanho da string menos os digitos verificadores 
           $tamanho = (strlen($codigoLimpo) -2); 
           //verifica se o tamanho do c�digo informado � v�lido 
           if ($tamanho != 9 && $tamanho != 12){ 
               return false; 
           } 
         
           if ($formatado){ 
               // seleciona a m�scara para cpf ou cnpj 
               $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';  
         
               $indice = -1; 
               for ($i=0; $i < strlen($mascara); $i++) { 
                   if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice]; 
               } 
               //retorna o campo formatado 
               $retorno = $mascara; 
         
           }else{ 
               //se n�o quer formatado, retorna o campo limpo 
               $retorno = $codigoLimpo; 
           } 
         
           return $retorno; 
         
       }
	   
	   

function create_table_relatorio_extjs($width,$height,$titulo){

	echo '
	  <table cellpadding="0" cellspacing="0" style="margin:0 0 0 12px;padding:0;width:'.$width.';">
  <tr >
    <td style="background-image:url(./images/relatorio_ext_top.gif);background-position:top;background-repeat:no-repeat;height:29px;" ><div style="font-weight:bold;font-size:12px;color:#15428b;width:100%;vertical-align:top;height:29px;margin:5px 0 0 5px;" >'.$titulo.'</div></td>
  </tr>
  <tr >
    <td style="background-image:url(./images/relatorio_ext_middle.gif);background-repeat:repeat-y;height:'.$height.';" >';
}


	   
function end_table_relatorio_extjs(){		
		echo'</td>
  </tr>
  <tr>
    <td style="background-image:url(./images/relatorio_ext_bottom.gif);background-position:top;background-repeat:no-repeat;height:7px;" ></td>
  </tr>
</table>
	';	
}



function get_estado(){
echo '
    <select name="estado" id="estado"  value="" style="width:50px;" class="x-form-field" >
                <option  value="SP">SP </option>
                <option  value="RJ">RJ </option>
                <option  value="MG">MG </option>
                <option  value="SC">SC </option>
                <option  value="DF">DF </option>
                <option  value="PR">PR </option>
                <option  value="RS">RS </option>
                <option  value="MS">MS </option>
                <option  value="PA">PA </option>
                <option  value="GO">GO </option>
                <option  value="BA">BA </option>
                <option  value="PE">PE </option>
                <option  value="SE">SE </option>
                <option  value="ES">ES </option>
                <option  value="CE">CE </option>
                <option  value="MT">MT </option>
                <option  value="PB">PB </option>
                <option  value="MA">MA </option>
                <option  value="AC">AC </option>
                <option  value="AL">AL </option>
                <option  value="AM">AM </option>
                <option  value="AP">AP </option>
                <option  value="PI">PI </option>
                <option  value="RN">RN </option>
                <option  value="RO">RO </option>
                <option  value="RR">RR </option>
                <option  value="TO">TO </option>
              </select>
';
}
	   
	   

function get_cabecalho($nivel){
	if ($_SESSION["id_user"]) {			
		echo '<script>
				
				'.$nivel.'document.getElementById("show_cabecalho").innerHTML = \'<table cellpadding="0"  cellspacing="0" style="width:100%;"><tr><td>'.saudacoes(). " Sr(a) "."".'</td><td style="width:120px;text-align:right"><a onclick="show_alterar_cadastro();" href="#">Alterar meus dados</a></td><td style="width:120px;text-align:right"><a onclick="show_alterar_senha();" href="#">Alterar minha senha</a></td><td style="width:40px;text-align:right"><a onclick="sair_sistema();" href="#">Sair</a></td></tr></table>\';
			
				
			  </script>
		';
	}else{
		echo '<script>
				
				'.$nivel.'document.getElementById("show_cabecalho").innerHTML = "";
				
			  </script>
		';
	}
}






function saudacoes(){
	  $hora_do_dia=date("H");	  
	  /*uso de condicionais, poder�amos utilizar o switch tamb�m*/	  
	  if (($hora_do_dia >=6) && ($hora_do_dia <=12)) return "Bom Dia!";
	  if (($hora_do_dia >12) && ($hora_do_dia <=18)) return "Boa Tarde!";
	  if (($hora_do_dia >18) && ($hora_do_dia <=24)) return "Boa Noite!";
	  if (($hora_do_dia >24) && ($hora_do_dia <6)) return "Boa Madrugada!";	
}


  function formataCepApresentacao( $cep ){
      $cep = str_replace( "-", "", $cep );
      if ($cep!="") return substr($cep,0,5)."-".substr($cep,5,3);
  }
  


function get_uf($uf_responsavel){
	
	 $sql = "select distinct uf from municipios order by uf";		 
	 
	 $result=return_query($sql);	
	
     while( $rs = db_fetch_array($result) ){		 
		 $text .=  '<option value="'.$rs["uf"].'"';		 
		 if (!$uf_responsavel) $uf_responsavel = 'SP';
		 if (strtoupper(trim($rs["uf"])) == $uf_responsavel) $text .=  ' selected="selected"  ' ;		 		 
		 $text .=  '  >'.strtoupper(trim($rs["uf"])).'</option>';
	 }
	
	 return $text;
}


function get_estado_by_municipio($id_municipio){
	if ($id_municipio){
		 $sql = "select uf from municipios where id_municipio = '".$id_municipio."'	limit 1";
		 //exit($sql);
		if($rs = get_record($sql)){
			return $rs["uf"];			  
		}else{
			return "";	
		}
	}else{
		return "";	
	}
}


function get_municipio_name($id_municipio){
	if ($id_municipio){
		 $sql = "select nome_municipio from municipios  where id_municipio = '".$id_municipio."'	limit 1";
		 //exit($sql);
		if($rs = get_record($sql)){
			return $rs["nome_municipio"];			  
		}else{
			return "";	
		}
	}else{
		return "";	
	}
}


function get_municipios($uf_responsavel, $nome_municipio_responsavel){
   	 if (!$uf_responsavel) $uf_responsavel = 'SP';
	 $sql = "select distinct id_municipio,nome_municipio from municipios 
	 		where upper(uf) = upper('".$uf_responsavel."')
	 		order by nome_municipio";	
	 $result=return_query($sql);	
	 while( $rs = db_fetch_array($result) ){
		 $text .=  '<option value="'.$rs["id_municipio"].'"';
		 
		 if (!$nome_municipio_responsavel) $nome_municipio_responsavel = '21096'; // cod da cidade de campinas
		 if ($rs["id_municipio"] == $nome_municipio_responsavel) $text .=  ' selected="selected"  ' ;
		 $text .=  '  >'.strtoupper(trim($rs["nome_municipio"])).'</option>';
	 }
	 return $text;
}



  function limpaCpf_Cnpj($campo) {
    $campo= str_replace( ".", "", $campo);
    $campo= str_replace( "-", "", $campo);
    $campo= str_replace( "/", "", $campo );
    return $campo;
  }
  
  
function   noempty($value){
	return (trim($value) == "")?"NULL":"'".$value."'";	
}



function insertDataDB($value){
		if( strlen($value) != 10){
			  return "NULL"; //Data Inv�lida;
		}else{
			 // if (ereg ("([0-3][0-9])/([0-1][0-9])/([0-9]{4})", substr($value,0,10), $regs)) {
			  if (ereg ("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}", $value, $regs)) {
				  // formato de data valida		
			  } else {
				  return "NULL"; //Data Inv�lida;
			  }			  
			  if (!$erro){				  			  
				  $nYear = substr($value,6,4); $nMonth = substr($value,3,2); $nDay = substr($value,0,2);
				  if (!checkdate($nMonth, $nDay, $nYear)) return "NULL"; //Data Inv�lida;
				  
				  return "'".data_us($value)."'"; //Data V�lida
			  }
		}
	return "NULL"; //Data Inv�lida;
		

}
  
function refreshArrayMap($params){
	if (is_array($params)){
		$params = array_map("refreshArrayMap", $params);
		return $params;
	}else{ 		
		return $params;
	}
}


function setColorBar($nro_opcao){
	switch ($nro_opcao){
		case 1:
		 $cor = "#33ff33";
		 break;
		case 2:
		 $cor = "#6666ff";
		 break;
		case 3:
		 $cor = "#ffff00";
		 break;
		case 4:
		  $cor = "#ff3333";				
		  break;
		default:
		 $cor = "#000";
		 break;				
	}	
	return $cor;
}



function setImage($anexo_link){
	
//	$ext = strtolower( substr($anexo_link,-3) );
	
	$ext = strtolower(  strchr($anexo_link,".")  );
	
	switch ($ext){
		case ".pdf":
		 $image = "pdf.png";
		 break;
		case ".doc":
		 $image = "doc.png";
		 break;
		case ".docx":
		 $image = "doc.png";
		 break;
		case ".xls":
		 $image = "xls.png";
		 break;
		case ".xlsx":
		 $image = "xls.png";
		 break;
		case ".png":
		 $image = "jpg.gif";
		 break;
		case ".jpg":
		 $image = "jpg.gif";
		 break;
		case ".png":
		 $image = "jpg.gif";
		 break;
		case ".gif":
		 $image = "gif.gif";
		 break;
		case ".odt":
		 $image = "odt.gif";
		 break;
		case ".ppt":
		 $image = "ppt.png";
		 break;
		case ".pptx":
		 $image = "ppt.png";
		 break;
		case ".ods":
		 $image = "ods.png";
		 break;
		case ".zip":
		 $image = "zip.gif";
		 break;
		case ".rar":
		 $image = "rar.gif";
		 break;
		case ".txt":
		 $image = "txt.gif";
		 break;
		case ".xml":
		 $image = "xml.png";
		 break;
		case ".csv":
		 $image = "csv.gif";
		 break;
		default:
		 $image = "xxx.png";
		 break;				
	}	
	return $image;
}



  function limpaCep( $cep ) {
    $cep = str_replace( "-", "", $cep );
    return $cep;
  }
  
  function plural($value){
	if ($value > 1) return 's';
  }
  
function calcHora($entrada,$saida){
	  $hora1 = explode(":",$entrada);
	  $hora2 = explode(":",$saida);
	  $acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60) + $hora1[2];
	  $acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60) + $hora2[2];
	  $resultado = $acumulador2 - $acumulador1;
	  $hora_ponto = floor($resultado / 3600);
	  $resultado = $resultado - ($hora_ponto * 3600);
	  $min_ponto = floor($resultado / 60);
	  $resultado = $resultado - ($min_ponto * 60);
	  $secs_ponto = $resultado;
	  return $hora_ponto."h e ".$min_ponto."min"; 
}

function get_time($entrada,$saida){
	  $hora1 = explode(":",$entrada);
	  $hora2 = explode(":",$saida);
	  $acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60) + $hora1[2];
	  $acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60) + $hora2[2];
	  $resultado = $acumulador2 - $acumulador1;
	  $hora_ponto = floor($resultado / 3600);	
	  $resultado = $resultado - ($hora_ponto * 3600);
	  $min_ponto = floor($resultado / 60);
	  $resultado = $resultado - ($min_ponto * 60);
	  $secs_ponto = $resultado;
	  if (strlen($hora_ponto) == 1)$hora_ponto = "0".$hora_ponto;
	  if (strlen($min_ponto) == 1) $min_ponto = "0".$min_ponto;
	  if (strlen($secs_ponto) == 1)$secs_ponto = "0".$secs_ponto;	  
	  return $hora_ponto."|".$min_ponto."|".$secs_ponto; 
}
  


function addDayIntoDate($date,$days) {
     $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 5, 2 );
     $thisday =  substr ( $date, 8, 2 );
     $nextdate = mktime ( 0, 0, 0, $thismonth, $thisday + $days, $thisyear );
     return strftime("%Y-%m-%d", $nextdate);
}

function subDayIntoDate($date,$days) {
     $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 5, 2 );
     $thisday =  substr ( $date, 8, 2 );
     $nextdate = mktime ( 0, 0, 0, $thismonth, $thisday - $days, $thisyear );
     return strftime("%Y-%m-%d", $nextdate);
}



function simpleDate($date) {
     $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 5, 2 );
     $thisday =  substr ( $date, 8, 2 );

     return $thisyear."-".$thismonth."-".$thisday;
}

function retirar_acentos($string){
     $string = ereg_replace("[^a-zA-Z0-9_.]", "", strtr($string, "�������������������������� ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
     return $string;
}

function youtube_embed($embed,$width,$height){
	return '
		  <object type="application/x-shockwave-flash" style="width:'.$width.';height:'.$height.';" data="http://www.youtube.com/v/'.$embed.'"  >
								  <param name="movie" value="http://www.youtube.com/v/'.$embed.'" />
								  </param>
								  <param name="wmode" value="transparent">
								  </param>
								  <embed src="http://www.youtube.com/v/'.$embed.'" type="application/x-shockwave-flash" wmode="transparent" width="'.$width.'" height="'.$height.'" ></embed>
		  </object>
	';
}


function get_participante($id_participante){
$sql = "SELECT   avatar,  facebook_id,nome_participante,email,moderador FROM participantes WHERE id_participante = '".$id_participante."'  LIMIT 1";
		$participante = array();
	
		if($rs = get_record($sql) ){	
			  if (trim($rs["avatar"])){
				  $participante["avatar"] = $rs["avatar"];
			  }else{
				  	if($rs["facebook_id"]){
						$participante["avatar"] = 'https://graph.facebook.com/'.$rs["facebook_id"].'/picture?width=200&height=200';						
					}else{
						$participante["avatar"] = './images/avatar.jpg';				 		 
					}
			  }		
			
		
		}else{
			$participante["avatar"] = "./images/avatar.jpg";	
		}
		
		$participante["nome"] = $rs["nome_participante"];
		
		$participante["email"] = $rs["email"];
		$participante["moderador"] = $rs["moderador"];
		
		
		return $participante;
}


function dias_passados($data_completa) {
		$hora = substr($data_completa, 11,5);
		$data = substr($data_completa,0,10);
		$diff= subtrai_data(date("Y-m-d"),$data); //formato US	
		
		if($diff == 0){						
						$valor_h = abs(substr($hora, 0,2));		
						$valor_m = abs(substr($hora, 3));	
						$time = explode("|",get_time($hora.":00",date("H:i:s")));						
						if (abs($time[0]) > 0){
							$msg=calcHora($hora.":00",date("H:i:s"))." atr�s";	
						}else{
							if ($time[1] == '0'){
								$msg=" menos de 1 minuto";
							}else{
								$msg=abs($time[1])."min atr�s";	
							}
							
						}
						return $msg;
		}
		
		return   abs($diff)." dia".plural(abs($diff)). " atr�s";								
	
}


function dataextenso($data_completa) {
		$hora_extenso = substr($data_completa,11,2)."h".substr($data_completa,14,2)."min";
		$hora = substr($data_completa, 11,5);
		$data = substr($data_completa,0,10);			
		$diff= subtrai_data(date("Y-m-d"),$data); //formato US			
		
		
		if($diff == 0){						
						$valor_h = abs(substr($hora, 0,2));		
						$valor_m = abs(substr($hora, 3));	
						$time = explode("|",get_time($hora.":00",date("H:i:s")));						
						if (abs($time[0]) > 0){
							$msg=calcHora($hora.":00",date("H:i:s"))." atr�s";	
						}else{
							if ($time[1] == '0'){
								$msg="publicado h� menos de 1 minuto";
							}else{
								$msg=abs($time[1])."min atr�s";	
							}
							
						}
						return $msg;
		}
		
		if(abs($diff) <= 7){						
				return   abs($diff)." dia".plural(abs($diff)). " atr�s";								
		}
		
		
		
        $data = explode("-",$data);
        $dia = $data[2];
        $mes = $data[1];
        $ano = $data[0];
        switch ($mes){
			  case 1: $mes = "Janeiro"; break;
			  case 2: $mes = "Fevereiro"; break;
			  case 3: $mes = "Mar�o"; break;
			  case 4: $mes = "Abril"; break;
			  case 5: $mes = "Maio"; break;
			  case 6: $mes = "Junho"; break;
			  case 7: $mes = "Julho"; break;
			  case 8: $mes = "Agosto"; break;
			  case 9: $mes = "Setembro"; break;
			  case 10: $mes = "Outubro"; break;
			  case 11: $mes = "Novembro"; break;
			  case 12: $mes = "Dezembro"; break;
        }
        //$mes=strtolower($mes);
        return ("$dia de $mes de $ano, ".$hora_extenso);
}


function insert_visualizacoes($id_contribuicao){			
			$sql = "INSERT INTO visualizacoes (id_contribuicao, id_participante, data_inclusao,ipv4,session_id) VALUES (".noempty($id_contribuicao).", ".noempty($_SESSION["id_participante_session"]).",'".date("Y-m-d H:i:s")."',".noempty($_SERVER['REMOTE_ADDR']).",".noempty(session_id()).")";
			insert_record($sql);	
}



function get_curtiu_comentario($id_contribuicao){			
	$sql = "
			SELECT COUNT(*) AS views
			FROM curtidas
			WHERE id_contribuicao = '".$id_contribuicao."'		
			AND id_participante = '".$_SESSION["id_participante_session"]."'
			LIMIT 1";	
	if ($rs = get_record($sql)){
		return $rs["views"];
	}
}

function get_total_curtidas($id_contribuicao){			
	$sql = "SELECT COUNT(*) AS views
			FROM curtidas
			WHERE id_contribuicao = '".$id_contribuicao."'			
			LIMIT 1";	
	if ($rs = get_record($sql)){
		return $rs["views"];
	}
}


function get_views_contribuicao($id_contribuicao){			
	$sql = "SELECT COUNT(*) AS views
			FROM visualizacoes
			WHERE id_contribuicao = '".$id_contribuicao."'
			LIMIT 1";	
	if ($rs = get_record($sql)){
		return $rs["views"];
	}
}

function get_sum_comentarios($id_contribuicao){			
	$sql = "select sum(soma) as total from (
			SELECT count(*) as soma
						FROM comentarios as a
					 INNER JOIN comentarios as b ON (a.id_comentario = b.sub_comentario AND b.data_cancelamento is NULL  AND b.aprovado = 'S')
						WHERE a.id_contribuicao = '".$id_contribuicao."' AND a.aprovado = 'S'	AND a.data_cancelamento is NULL AND a.sub_comentario is NULL
				
			union all
			
			SELECT count(*) as soma
						FROM comentarios as a		
						WHERE a.id_contribuicao = '".$id_contribuicao."' AND a.aprovado = 'S'	AND a.data_cancelamento is NULL AND a.sub_comentario is NULL
			)as temp";	
	if ($rs = get_record($sql)){
		return $rs["total"];
	}
}


function show_replay($id_contribuicao,$id_comentario){		
     $sql_resposta = "SELECT id_comentario,texto_comentario,id_participante,data_inclusao
					FROM comentarios
					WHERE id_contribuicao = '".$id_contribuicao."' 
					AND sub_comentario is not NULL AND sub_comentario = '".$id_comentario."' AND aprovado='S' AND data_cancelamento is NULL
					ORDER BY data_inclusao DESC
     ";
     $result_resposta = return_query($sql_resposta);    
     while( $rs_resposta = db_fetch_array($result_resposta) ){	      
           $participante_resposta = get_participante($rs_resposta["id_participante"]);
		   
		   //<!-- mostra resposta do comentario  begin  -->
		   
		   echo '
           
          <div style="width:940px;">
     
            <table cellpadding="0" cellspacing="0" style="width:940px;min-height:90px;" >
              <tr>
                <td style="width:190px;" valign="top"><img src="'. $participante_resposta["avatar"] .'" style="border:0;width:60px;height:60px;margin:10px 10px 0 0;float:right" align="absmiddle"></td>
                <td  style="width:560px;"  valign="top">
                
                <img src="images/arrow.png" style="border:0;float:left;margin-top:20px" align="absmiddle">
                
            
                    <div  style="width:550px;height:auto;border:0px;margin-top:10px;background-color:#efefef;float:left;padding:10px;word-wrap: break-word;">';
					
				 if ($participante_resposta["moderador"] == 'S') {					 
					 echo '<strong style="color:#006600">'. $participante_resposta["nome"].' &nbsp; <em style="font-weight:normal;">( moderador )</em>';
				 }else{
					 echo '<strong>'. $participante_resposta["nome"];
				 }
				 
				 
				 
					
					echo '</strong><br>
                     '. dataextenso($rs_resposta["data_inclusao"]) .'<br>
                     <em style="font-size:13px;">"'. quebra_palavra($rs_resposta["texto_comentario"]) .'"</em>
                     </div>
   
                  
                  </td>
                <td style="width:150px;"  valign="top">
                </td>
              </tr>
            </table>
          
          </div>
		  ';
         //<!-- mostra resposta do comentario  end  -->

 	 }  
}


function show_form_replay($imagem_avatar,$id_contribuicao,$id_comentario){	
// <!-- form resposta do comentario  begin  -->
echo '
          <div style="width:940px;">
           <form method="POST">
            <table cellpadding="0" cellspacing="0" style="width:940px;height:120px;display:none" id="aba_resposta'. $id_comentario .'">
              <tr>
                <td style="width:190px;" valign="top"><img src="'. $imagem_avatar .'" style="border:0;width:60px;height:60px;margin:20px 10px 0 0;float:right" align="absmiddle"></td>
                <td  style="width:560px;"  valign="top" nowrap>
                
                <img src="images/arrow.png" style="border:0;float:left;margin-top:20px" align="absmiddle">
                
    			 <input name="add_resposta" type="hidden" value="1">
                <input name="id_contribuicao" type="hidden" value="'. $id_contribuicao .'">
                <input name="id_comentario" type="hidden" value="'. $id_comentario .'">
                
                  <textarea  style="width:560px;height:80px;border:0px;margin-top:20px;background-color:#efefef" name="comentario_text"  onKeyPress="max_area(this,255)"  onblur="max_area(this,255)"></textarea>
                  
                  <strong style="color:#000;float:right">max (255 carac)</strong>
                  
                  </td>
                <td style="width:150px;"  valign="top"><input type="button" value="Enviar"   style="border:2px solid #cccccc;background-color:#ffffff;font-size:16px;color:#393e44;font-weight:bold;padding:10px;width:120px;float:right;margin:25px 10px 0 0;cursor:pointer" onClick="enviar_resposta(this.form);"  onMouseOver="this.style.background=\'#cccccc\'" onMouseOut="this.style.background=\'#ffffff\'">
                </td>
              </tr>
            </table>
            </form>
          </div>
        ';
// <!-- form resposta do comentario  end  -->
}


function show_coments($imagem_avatar,$id_contribuicao,$read_only){	
//<!-- contribui��o  begin----------------------------------------------  -->
	  
	   $sql_coments = "SELECT a.id_comentario,a.texto_comentario,a.id_participante,a.data_inclusao,
								  (CASE WHEN								  
								  (SELECT b.data_inclusao
								  FROM comentarios as b 
								  WHERE b.id_contribuicao = '".$id_contribuicao."' 
								  AND a.id_comentario = b.sub_comentario AND b.aprovado = 'S' AND data_cancelamento is NULL
								  ORDER BY b.data_inclusao DESC
								  LIMIT 1) > a.data_inclusao THEN								  
                                                            (SELECT b.data_inclusao
                                                            FROM comentarios as b 
                                                            WHERE b.id_contribuicao = '".$id_contribuicao."' 
                                                            AND a.id_comentario = b.sub_comentario  AND b.aprovado = 'S' AND data_cancelamento is NULL
                                                            ORDER BY b.data_inclusao DESC
                                                            LIMIT 1)
  								  ELSE a.data_inclusao
								  END	
								  ) AS ordem
					  FROM comentarios as a
					  WHERE a.id_contribuicao = '".$id_contribuicao."' AND a.sub_comentario IS NULL AND aprovado='S' AND data_cancelamento is NULL
					  ORDER BY ordem desc, a.data_inclusao desc
	  ";
	   
	  
	   $result_coments = return_query($sql_coments);
	   
	   echo '<br><hr style="border:1px dashed #efefef">';
	   while( $rs_coments = db_fetch_array($result_coments) ){	   
			  $participante_coments = get_participante($rs_coments["id_participante"]);
	
				
		// <!--  comentarios begin -->		
		echo '<table cellpadding="0" cellspacing="0" style="width:940px;">
				  <tr>
					<td style="width:130px;" valign="top"><img src="'. $participante_coments["avatar"] .'" style="border:0;width:60px;height:60px;margin:10px 10px 0 0;float:right" align="absmiddle"></td>
					<td  style="width:610px"  valign="top"><img src="images/arrow.png" style="border:0;float:left;margin-top:20px" align="absmiddle">
	
					  <div  style="width:610px;height:auto;border:0px;margin-top:10px;background-color:#efefef;float:left;padding:10px;word-wrap: break-word;">';
					  
					  
					  
				 if ($participante_coments["moderador"]== 'S') {					 
					 echo '<strong style="color:#006600">'. $participante_coments["nome"].' &nbsp; <em style="font-weight:normal;">( moderador )</em>';
				 }else{
					 echo '<strong>'. $participante_coments["nome"];
				 }
				 
		
					
					  
					  echo '</strong><br> '. dataextenso($rs_coments["data_inclusao"]) .'<br><em style="font-size:13px;">"'. quebra_palavra($rs_coments["texto_comentario"]) .'"</em></div></td>
					<td style="width:150px;"  valign="middle">';
					
					
					if(!$read_only) echo '<input type="button" value="Responder"   style="border:2px solid #cccccc;background-color:#ffffff;font-size:16px;color:#393e44;font-weight:bold;padding:10px;width:120px;float:right;margin:0px 10px 0 0;cursor:pointer" onClick="aba_resposta('. $rs_coments["id_comentario"] .');"  onMouseOver="this.style.background=\'#cccccc\'" onMouseOut="this.style.background=\'#ffffff\'">
					';
					
					echo'
					</td>
				  </tr>
				</table> ';
		//  <!--  comentarios end -->

		 if(!$read_only) show_form_replay($imagem_avatar,$id_contribuicao,$rs_coments["id_comentario"]);
		 show_replay($id_contribuicao,$rs_coments["id_comentario"]);
	  }    
   //<!-- contribui��o  end----------------------------------------------  --> 
}


function show_form_coments($imagem_avatar,$id_contribuicao){	
 echo '
          <div style="width:940px;">
           <form method="POST">
            <table cellpadding="0" cellspacing="0" style="width:940px;height:120px;border:1px solid #ccc;background-color:#CCC;display:none" id="aba_enviar_comentario'. trim($id_contribuicao) .'">
              <tr>
                <td style="width:120px;" valign="top"><img src="'. $imagem_avatar .'" style="border:0;width:60px;height:60px;margin:20px 10px 0 0;float:right" align="absmiddle"></td>
                <td  style="width:630px"  valign="top"><img src="images/contorno_caixa.png" style="border:0;width:20px;height:80px;float:left;margin-top:20px" align="absmiddle">
                
                <input name="add_comentario" type="hidden" value="1">
                <input name="id_contribuicao" type="hidden" value="'.$id_contribuicao.'">
                  <textarea  style="width:630px;height:80px;border:0px;margin-top:20px" name="comentario_text"  onKeyPress="max_area(this,255)"  onblur="max_area(this,255)"></textarea>
                  
                  <strong style="color:#000;float:right">max (255 carac)</strong>
                  
                  </td>
                <td style="width:150px;"  valign="top"><input type="button" value="Enviar"  style="border:2px solid #ffffff;background-color:#cccccc;font-size:16px;color:#393e44;font-weight:bold;padding:10px;width:120px;float:right;margin:55px 20px 0 0;cursor:pointer" onClick="enviar_comentario(this.form);"   onMouseOver="this.style.background=\'#ffffff\'" onMouseOut="this.style.background=\'#cccccc\'">
                </td>
              </tr>
            </table>
            </form>
          </div>
';
}


function cabecalho_pmc(){
	return '
<div id="barraTopo">
  <div id="barra">
    <div id="brasao">
      <div id="link1"><a href="http://www.campinas.sp.gov.br/" target="_blank" title="Prefeitura Municipal de Campinas">Prefeitura Municipal de Campinas</a></div>
      <div id="link2"><a href="http://www.campinas.sp.gov.br/governo/saude" target="_blank" title="Secretaria de Sa�de">Secretaria de Sa�de</a></div>
    </div>
  </div>
</div>
	';	
}


function botao_quero_participar(){	
	$sql = "SELECT count(*) as total_desafios
			FROM desafios as a
			WHERE a.data_cancelamento is NULL 
			AND a.data_inicio < now() ";
	if ($rs = get_record($sql)){
		$total_desafios = $rs["total_desafios"];
	}
	
	if ($total_desafios >= 2){
		$location = "desafios.php";
	}else{
		$location = "index.php";
	}
	
	 return '<div style="width:270px;height:40px;background-color:#63c14a;color:#FFF;font-size:22px;text-align:center;line-height:40px;margin-top:20px;cursor:pointer;" onMouseOver="this.style.background=\'#0096e1\'" onMouseOut="this.style.background=\'#63c14a\'" onClick="location.href=\''.$location.'\'"> Quero participar! </div>';
 
	
}

function menu_top(){
	$sql = "SELECT count(*) as total_desafios
			FROM desafios as a
			WHERE a.data_cancelamento is NULL 
			AND a.data_inicio < now() ";
	if ($rs = get_record($sql)){
		$total_desafios = $rs["total_desafios"];
	}
	
	$text = '
			<div id="barraMenu">
			  <div id="widthBarraMenu">			  	
				<div id="menu">
				  <ul>
					<li style="width:80px;">
					  <p style="height:20px;margin-top:0px" ><a href="index.php">HOME</a></p>
			 
					</li>
					';
					
					
		if ($total_desafios >= 2)   //somente mostrar botao quando tiver mais de 2 desafios			
		$text .=  '
					<li style="width:auto;"> <img src="images/divisoria_menu.gif"> </li>			
					<li   style="width:104px;">
					  <p style="height:20px;margin-top:0px"><a href="desafios.php">DESAFIOS</a></p>				
					</li>';
					
					
			$text .=  '		
					<li style="width:auto;"> <img src="images/divisoria_menu.gif"> </li>
			
					<li   style="width:164px;">
					  <p style="height:20px;margin-top:0px"><a href="como_funciona.php">COMO FUNCIONA</a></p>			
					</li>
					
					<li style="width:auto;"> <img src="images/divisoria_menu.gif"> </li>			
					<li style="width:134px;">
					  <p style="height:20px;margin-top:0px"><a href="comunidade.php">COMUNIDADE</a></p>			  
					</li>
					
					<li style="width:auto;"> <img src="images/divisoria_menu.gif"> </li>			
					<li style="width:220px;">
					  <p style="height:20px;margin-top:0px"><a href="faq.php">PERGUNTAS FREQUENTES</a></p>			  
					</li>
					</li>
				  </ul>
				</div>
			  </div>
			</div>
		';
		
		return $text;
}


function facebook_box(){
	return '
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=190436047799972";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));
</script>
	';
}


function icones_facebook_twitter(){
	
 if ($_SESSION["id_participante_session"]){	   
 		$participante_logado = $_SESSION["nome_participante_session"].' &nbsp;<img src="images/divisoria_menu.gif" >&nbsp; '; 
		$saudacoes = "Ol�";
 }
	
return '
<center>
  <div style="width:960px">   
  <table  cellpadding="0" cellspacing="0" style="width:100%"><tr>
  <td>
  <a href="index.php" style="cursor:pointer;"><img src="./images/logo_site.png" style="border:0;margin:0px;"></a>
  </td>
  <td valign="top" id="saudacoes_login">
  <span style="color:#0096e1;font-size:12px;font-weight:bold;"> '. $saudacoes .' <b style="color:#393e44;font-size:12px"> '. $participante_logado  .' </b>   </span>  </td> 
  <td  valign="top" style="text-align:right;width:390px;margin:0px;pading;0px;">  
  
   <div class="fb-like" data-href="'.InfoSystem::url_site.'" data-send="true" data-layout="button_count" data-width="200" data-show-faces="true" style="float:left" ></div>  
  
  
  <a href="https://twitter.com/share" class="twitter-share-button" data-url="'.InfoSystem::url_site.'">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>
 
 

 
<!-- Posicione esta tag onde voc� deseja que o bot�o +1 apare�a. -->
<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="80"  ></div>
<!-- Posicione esta tag depois da �ltima tag do bot�o +1. -->
<script type="text/javascript">
  window.___gcfg = {lang: \'pt-BR\'};

  (function() {
    var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
    po.src = \'https://apis.google.com/js/plusone.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
 </td>
  </tr>
  </table>
 </div>
 </center>
';
}


function banner_top_image1(){
return '
  <div style="margin:0 auto;background-color:transparent;width:100%;background-image:url(images/banner_fundo.gif);height: 100%;" >
    <table  cellpadding="0" cellspacing="0" style="">
      <tr>
        <td><div style="margin-top:18%;">&nbsp;</div></td>
      </tr>
      <tr>
        <td style="color:#FFF;font-size:4.8em;"> Traga ideias para juntos <br>
          melhorarmos Campinas. </td>
      </tr>
      <tr>
        <td>
		<div>
		<center>
            <div style="width:160px;height:40px;background-color:#63c14a;color:#FFF;font-size:22px;text-align:center;line-height:40px;margin-top:20px;cursor:pointer;"  onMouseOver="this.style.background=\'#f1d624\'" onMouseOut="this.style.background=\'#63c14a\'"  onclick="location.href=\'como_funciona.php\'"> Saiba mais </div>
          </center>
		  </div>
		  </td>
      </tr>
      <tr>
        <td><div style="margin-bottom:15%;">&nbsp;</div></td>
      </tr>
    </table>
  </div>
  ';
}


function banner_top_image2(){
return '
  <div style="margin:0 auto;background-color:transparent;width:100%;background-image:url(images/banner_top_slide2b.png);height: 100%;" >
	<div style="height:100%;">
    <table  cellpadding="0" cellspacing="0" style="width:100%;margin-left:6%">
      <tr>
        <td style="color:#363945;font-size:4.8em;text-align:left;font-weight:bolder;height:355px;" valign="middle">
		Queremos te<br>
          ouvir para melhorar<br>
		  o servi�o de sa�de<br>
		  em Campinas
		  </td>
      </tr>
    </table>
	 </div>

  </div>
  ';
}


function banner_top(){
return '
  <!-- BANNER TOP -->
  <center>
  <div style="margin:0 auto;margin-top:10px;max-width:1280px;max-height:355px;"  class="flexslider">
     <ul class="slides"  style="max-height:355px;">
    <li style="max-height: 355px;" >
      '.banner_top_image1().'
    </li>
    <li style="max-height: 355px;" >
      '.banner_top_image2().'
    </li>
   </ul>
  </div>
  </center>';
}



function banner_top_faq(){
return '
  <!-- BANNER TOP -->
  <center>
  <div style="margin:0 auto;margin-top:10px;background-color:transparent;max-width:1280px;background-image:url(images/banner_top_faq.png);height:355px;" >
    <table  cellpadding="0" cellspacing="0">
      <tr>
        <td><div style="height:110px"></div></td>
      </tr>
      <tr>
        <td style="color:#FFF;font-size:48px;"> Traga id�ias para juntos <br>
          melhorarmos Campinas. </td>
      </tr>
      <tr>
        <td><center>
            <div style="width:160px;height:40px;background-color:#63c14a;color:#FFF;font-size:22px;text-align:center;line-height:45px;margin-top:20px;cursor:pointer;"  onMouseOver="this.style.background=\'#f1d624\'" onMouseOut="this.style.background=\'#63c14a\'"  onclick="location.href=\'como_funciona.php\'"> Saiba mais </div>
          </center></td>
      </tr>
    </table>
  </div>
  </center>';
}



function banner_top_como_funciona(){
return '
  <!-- BANNER TOP -->
  <center>
  <div style="margin:0 auto;margin-top:10px;background-color:transparent;max-width:1280px;background-image:url(images/banner_top.png);height:355px;" >
    <table  cellpadding="0" cellspacing="0">
      <tr>
        <td><div style="height:95px"></div></td>
      </tr>
      <tr>
        <td style="color:#FFF;font-size:48px;text-align:center;"> A Prefeitura de Campinas quer <br>
												criar junto com voc� servi�os <br>
													p�blicos de qualidade! 
         </td>
      </tr>
      
    </table>
  </div>
  </center>';
}




function banner_top_comunidade(){
return '
  <!-- BANNER TOP -->
  <center>
  <div style="margin:0 auto;margin-top:10px;background-color:transparent;max-width:1280px;background-image:url(images/top_banner_comunidade.png);height:120px;" >
    <table  cellpadding="0" cellspacing="0">
      <tr>
        <td><div style="height:5px"></div></td>
      </tr>
     
      
    </table>
  </div>
  </center>';
}




function show_form_inspiracao($id_desafio,$fase_atual,$read_only){	

	switch ($fase_atual){
		case 1:
		 $titulo = "Inspira��o";
		 break;
		case 2:
		 $titulo = "Proposta";
		 break;	
		default:
		 return '<div style="width:940px;height:auto;border-top:1px #ccc solid"></div>'; // form so existe na fase 1 e 2
		 break;				
	}		

	$text = '
		<div style="width:940px;height:auto;border-top:1px #ccc solid">
            <table cellpadding="0" cellspacing="0" style="background-color:#cccccc;width:940px;height:300px;display:none" id="aba_enviar_desafio'. $id_desafio .'">
              <tr>
                <td style="padding:15px 0 0 20px;font-size:16px;color:#393e44;width:460px;" valign="top">
                <form name="form_inspiracao'.$id_desafio.'" enctype="multipart/form-data" method="POST">
                  <strong>T�tulo da '.$titulo.'</strong>
                  <spam style="font-size:13px">(at� 150 carc.)</spam>
                  <br>
                  <input type="text" style="width:440px;height:45px;border:0px;font-size:12px;font-family:arial, tahoma, helvetica, sans-serif" maxlength="150" name="nome_contribuicao" >';
				  
	if ($fase_atual == '2'){			  
		$text .=  temas_options($id_desafio,'');
	}
				  
				  
	$text .= '
                  <br>
                  <br>
                  <strong>Escolher M�dia</strong>
                  <input name="media_flag" type="radio" value="F" onClick="escolher_media(this,'. $id_desafio .')">
                  Imagem
                  <input name="media_flag"  type="radio" value="V" onClick="escolher_media(this,'. $id_desafio .')">
                  V�deo <br>
                  <br>
                  <div id="media_video'. $id_desafio .'" style="display:none"> <strong>Link do YouTube</strong>
                    <spam style="font-size:13px"></spam>
                    <br>
                    <input type="text" style="width:440px;height:45px;border:0px;font-size:12px;" name="myYouTubePlayer" id ="myYouTubePlayer"  onblur="valida_youtube(this.value,this.form,'.$id_desafio.')">
                    <div id="objectspan'. $id_desafio .'">
                    <object type="application/x-shockwave-flash" style="width:440px; height:260px;" data=""  id="preview_video_'. $id_desafio .'">
                      <param name="movie" value=""  id="preview_video2_'. $id_desafio .'" />
                      </param>
                      <param name="wmode" value="transparent">
                      </param>
                      <embed src="" type="application/x-shockwave-flash" wmode="transparent" width="440px" height="260px"  id="preview_video3_'. $id_desafio .'"></embed>
                    </object>
                    </div> </div>
                  <div id="media_foto'. $id_desafio .'" style="display:none"> <strong>Imagem</strong>
                    <spam style="font-size:13px"></spam>
                    <br>
                    <input type="file" style="width:440px;height:45px;border:0px" name="foto">
                  </div>
                  </td>
                  <td style="font-size:16px;color:#393e44;padding-top:15px;"  valign="top"><strong>Descri��o da '.$titulo.'</strong>
                    <span style="font-size:13px">(at� 500 carc.)</span>
                    <textarea  style="width:440px;height:190px;border:0px;font-family:arial, tahoma, helvetica, sans-serif;font-size:12px;" name="descricao_contribuicao"  onKeyDown="max_caracteres(this,500,event)"  ></textarea>
                    <br><span style="font-size:13px">dispon�vel: <span id="disp_carac">500</span></span>
                    <input type="hidden" name="enviar_contribuicao" value="1">
                    <input type="hidden" name="id_desafio" value="'.$id_desafio.'">
					<input type="hidden" name="fase_atual" value="'.$fase_atual.'">
                    <input type="button" value="Enviar"  style="border:2px solid #ffffff;background-color:#cccccc;font-size:16px;color:#393e44;font-weight:bold;padding:10px;width:120px;float:right;margin:10px 20px 0 0;cursor:pointer"   onMouseOver="this.style.background=\'#63c14a\'" onMouseOut="this.style.background=\'#cccccc\'" onClick="enviar_inspiracao(this.form)">
                </form>
              </td>
              
              </tr>
              
            </table>
          </div>
	';
	
	return $text;
}


function temas_options($id_desafio,$selected){	
	$sql = "						
		   SELECT a.id_topico, a.nome_topico
		  FROM topicos as a
		  WHERE a.data_cancelamento is NULL 
		  AND a.id_desafio = '".$id_desafio."'
		  ORDER BY a.nro_topico
		  ";

	if (numrows($sql)>0){
			$result = return_query($sql);
			$text = '<br><br><strong>Escolher Tema </strong>';		
			$text .= '<select name="id_topico"  style="height:25px;border:0px;font-family:arial, tahoma, helvetica, sans-serif;font-size:12px;"  >';
			$text .=  '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){				
				$text .= "<option value=\"".$rs['id_topico']."\" ";
				if ($selected == $rs['id_topico']) echo "selected";
				$text .= " >".$rs['nome_topico']."</option>\n";
			} 	
			$text .= '</select>';
			
			return $text;
	}
}



				   


function show_menu_fases($id_desafio,$id_fase,$print){	
	
	$texto = '     <div style="background-image:url(images/ball_all_empty.png);background-repeat:no-repeat;width:900px;height:auto;">
          <table  cellpadding="0" cellspacing="0" style="">
            <tr><td colspan="4">';

			
  		$fase_atual = "";
		$fase_realizada = "";
		$nome_fase = "";
		$desafio = array(array());
		 $sql = "SELECT a.nome_fase,b.data_inicio,a.id_fase,c.data_fim
				FROM fases AS a
				INNER JOIN desafios_x_fases AS b ON (a.id_fase = b.id_fase)
				INNER JOIN desafios AS c ON (c.id_desafio = b.id_desafio)
				where b.id_desafio = '".$id_desafio."' and a.data_cancelamento is NULL
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
			 $dias = subtrai_data(date("Y-m-d"),$data_inicio);			
			 $data_fim_fase = $desafio["data_inicio"][$index+1];
			 $data_fim_fase = ($data_fim_fase)?$data_fim_fase:$data_fim; // se nao tem fase inicial posterior, � a ultima fase.
			 $periodo = subtrai_data($data_inicio,$data_fim_fase);	
			 $falta_dias = subtrai_data(date("Y-m-d"),$data_fim_fase);							 
			 
			 if ($fase_atual == "") { // fase_n�o_inicializada
				 if (subtrai_data($data_inicio,date("Y-m-d")) < 0){ //desafio ainda n�o come�ou
					  $fase_atual = 0;
					  $alert_fase = '<br><em style="font-size:12px;color:#006633">inicia em '.abs(subtrai_data($data_inicio,date("Y-m-d"))).' dia(s)</em>'; 							
				 }else{
					   $fase_atual = $desafio["id_fase"][$index]; // preenche fase inicial
					   $nome_fase = $desafio["nome_fase"][$index];					  
				 }
			 }else{
				 $alert_fase = "";
			 }
			 
			  if( (float)$dias <= 0){ //fase j� terminada									
				  $fase_realizada = 1;
				  $fase_atual = $desafio["id_fase"][$index]; // atualiza fase atual com ultima fase realizada	
				  $nome_fase = $desafio["nome_fase"][$index];				  
			  }else{	
				  $fase_realizada = 0;				
			  }		
			  
			  
			  $fim = subtrai_data($data_fim,date("Y-m-d"));	
			   
			   $backg = "";
			  if( (float)$fim > 0){	 // projeto finalizado			  		
				 // echo  '<td><em style="font-size:12px;color:#990000">Desafio Finalizado</em></td>'; 
				  $fase_atual = 5;
				  $nome_fase = '';
			  }else{

			  }			
			  
			  
			  
			  switch ($desafio["id_fase"][$index]){
					case '1': $cor = "verde"; break;
					case '2': $cor = "amarelo"; break;
					case '3': $cor = "laranja"; break;
					case '4': $cor = "azul"; break;
					default: $cor = "verde"; break;
			  }
			  
			  
			   if ($fase_realizada == 1){	
					   if ($falta_dias > 0){
							
							

							
							$pixels_percentagem = abs(10*($periodo-$falta_dias)/$periodo); //100 � porcentagem
							$nro_fatia = floor($pixels_percentagem);							
							if ($nro_fatia == '0') $nro_fatia = 1;
							
							
							$alert_fase = '<br><em style="font-size:12px;color:';
							if ($nro_fatia > 4){
								$alert_fase .= '#33CC33';
							}else{
								$alert_fase .= '#006633';
							}
							$alert_fase .= '">finaliza em '.$falta_dias.' dia(s)</em>'; 
							
							
						//$pixels_percentagem = abs(201*($periodo-$falta_dias)/$periodo); //201 � o numero de pixel correspondente ao tamanho da div de uma fase 
						//	$backg = "background-image:url(./images/ball_full.png);background-repeat:no-repeat;background-size:201px ".$pixels_percentagem."px";	
							
							
							$backg = "background-image:url(./images/".$cor.$nro_fatia.".png);background-repeat:no-repeat;";
							
							$onclick = "fase_info('".$id_desafio."','".$desafio["id_fase"][$index]."');";
							if($id_fase != "") $backg = ""; // somente para leitura
					   }else{
							$alert_fase = '<br><em style="font-size:12px;color:#cc0000">Finalizado</em>'; 
					        $backg = "background-image:url(./images/".$cor."10.png);background-repeat:no-repeat;";
							$onclick = "fase_alone('".$id_desafio."','".$desafio["id_fase"][$index]."');";												
					   }		
					$cursor = "cursor:pointer;";
			   }else{
					$cursor = "";   
					$onclick = "";
			   }
			   
			   
			   if($id_fase != ""){
				   if ($id_fase >= $desafio["id_fase"][$index]){
					   $backg = "background-image:url(./images/".$cor."10.png);background-repeat:no-repeat;";
				   }else{
					   $backg = "";
				   }
			   }
			   
			   
			   
			 $texto .= '				
				<div style="cursor:pointer;float:left;width:201px;text-align:center;height:201px;font-weight:bold;color:#393e44;font-size:14px;top:50%;left:50%;'.$cursor.$backg.'"  onclick="'.$onclick.'"><div style="display:table-cell;vertical-align:middle;width:201px;height:201px;cursor:pointer;" ><div title="<center>'.strtoupper(strtr($desafio["nome_fase"][$index] ,"����������������","����������������")).'</center>| <table cellspacing=\'0\' style=\'width:170px;\'><tr><td align=right>In�cio:</td><td>'.data_br($data_inicio).'</td></tr><tr style=\'background:#eee;\'><td align=right >Fim:</td><td	>'.data_br(subDayIntoDate($data_fim_fase,1)).'</td></tr><tr><td align=right>Dura��o:</td><td> '.$periodo.'  dia(s)</td></tr></table>" class="title" style="cursor:pointer;"> 
				'.strtoupper(strtr($desafio["nome_fase"][$index] ,"����������������","����������������")).'  '.'</div>
				 <em>'.strtoupper(data_br($data_inicio)).'</em>							
			 ';								   
			 $texto .=  $alert_fase;	   
			 
			 $texto .=  '							
				</div></div><div style="width:32px;float:left;">&nbsp;</div>
				
			 ';	
		 }
		 $texto .=  '</td>';
	     $texto .=  '</tr>
			<tr><td colspan="4">';
			
			
		if($id_fase != ""){ //ver fase anterior			
			$texto .=  '<img src="./images/BOXevoce'.$id_fase.'.png" style="border:0;margin-top:7px;">';
		}else{ //fase atual
			if (($fase_atual >=1) && ($fase_atual <=4) )$texto .=  '<img src="./images/BOXevoce'.$fase_atual.'.png" style="border:0;margin-top:7px;">';
		}
			

			
			
	$texto .=  '
			</td></tr>
          </table>
        </div>';		
		
		if($print) echo $texto;
		return $fase_atual."|".$nome_fase;
}


/*
function show_menu_fases_alone($id_desafio,$id_fase){	
	echo '     <div style="background-image:url(images/ball_all_empty.png);background-repeat:no-repeat;width:900px;height:360px;">
          <table  cellpadding="0" cellspacing="0" style="">
            <tr><td colspan="4">';

			
  		$fase_atual = "";
		$fase_realizada = "";
		$nome_fase = "";
		$desafio = array(array());
		 $sql = "SELECT a.nome_fase,b.data_inicio,a.id_fase,c.data_fim
				FROM fases AS a
				INNER JOIN desafios_x_fases AS b ON (a.id_fase = b.id_fase)
				INNER JOIN desafios AS c ON (c.id_desafio = b.id_desafio)
				where b.id_desafio = '".$id_desafio."' and a.data_cancelamento is NULL
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
			 $dias = subtrai_data(date("Y-m-d"),$data_inicio);			
			 $data_fim_fase = $desafio["data_inicio"][$index+1];
			 $data_fim_fase = ($data_fim_fase)?$data_fim_fase:$data_fim; // se nao tem fase inicial posterior, � a ultima fase.
			 $periodo = subtrai_data($data_inicio,$data_fim_fase);	
			 $falta_dias = subtrai_data(date("Y-m-d"),$data_fim_fase);							 
			 
			 if ($fase_atual == "") {
				 $fase_atual = $desafio["id_fase"][$index]; // preenche fase inicial
				 $nome_fase = $desafio["nome_fase"][$index];
			 }
			 
			  if( (float)$dias <= 0){ //fase j� come�ou								
				  $fase_realizada = 1;
				  $fase_atual = $desafio["id_fase"][$index]; // atualiza fase atual com ultima fase realizada	
				  $nome_fase = $desafio["nome_fase"][$index];				  
			  }else{	
				  $fase_realizada = 0;						  
			  }			
			  
			  $fim = subtrai_data($data_fim,date("Y-m-d"));	
			   $alert_fase = "";
			   $backg = "";
			  if( (float)$fim > 0){	 // projeto finalizado			  		
				 // echo  '<td><em style="font-size:12px;color:#990000">Desafio Finalizado</em></td>'; 
				  $fase_atual = 5;
				  $nome_fase = '';
			  }else{

			  }			
			  
			  
			   if ($fase_realizada == 1){	
					   if ($falta_dias > 0){
							$alert_fase = '<br><em style="font-size:12px;color:#009900">finaliza em '.$falta_dias.' dia(s)</em>'; 
							$pixels_percentagem = abs(201*($periodo-$falta_dias)/$periodo); //225 � o numero de pixel correspondente ao tamanho da div de uma fase 						
							$onclick = "fase_info('".$id_desafio."','".$desafio["id_fase"][$index]."');";							
					   }else{
							$alert_fase = '<br><em style="font-size:12px;color:#990000">Finalizado</em>'; 								
							$onclick = "fase_alone('".$id_desafio."','".$desafio["id_fase"][$index]."');";														
					   }		
					$cursor = "cursor:pointer;";
			   }else{
					$cursor = "";   
					$onclick = "";
			   }
			   
				
			   if ($id_fase == $desafio["id_fase"][$index]){
				   $backg = "background-image:url(./images/ball_full.png);background-repeat:no-repeat;";
			   }else{
				   $backg = "";
			   }
			   
			 echo '
				
				<div style="float:left;width:201px;text-align:center;height:201px;font-weight:bold;color:#393e44;font-size:14px;top:50%;left:50%;'.$cursor.$backg.'"  onclick="'.$onclick.'"><div style="display:table-cell;vertical-align:middle;width:201px;height:201px;">
				'.strtoupper(strtr($desafio["nome_fase"][$index] ,"����������������","����������������")).' <em style="font-size:10px">( '.$periodo.' dias )</em> '.'<br>
				 <em>'.strtoupper(data_br($data_inicio)).'</em>							
			 ';								   
			 echo $alert_fase;	   
			 
			 echo '							
				</div></div><div style="width:32px;float:left;">&nbsp;</div>
				
				
			 ';	
		 }
	echo '</td> </tr>
			<tr><td colspan="4">';
		 
				echo '<img src="./images/BOXevoce'.$fase_atual.'.jpg" stype="border:0">';
				 
		 
	echo '</td></tr>
          </table>
        </div>';		
		return $fase_atual."|".$nome_fase;
}
*/


function desafio_titulo($nome_desafio){	
	echo'
       <div  style="font-size:30px;color:#ffffff;font-weight:bold;width:980px;height:100px;background-image:url(images/desafio_top.png);padding-left:40px;background-repeat:no-repeat;">
            <div style="width:880px;height:80px;padding-top:5px;vertical-align:middle;display:table-cell;">
              '.$nome_desafio.'
            </div>
          </div>';
}




function desafio_info($media_flag,$caminho,$arquivo,$youtube,$descricao,$descricao_anexo,$id_desafio,$fase_atual,$nome_fase,$read_only,$resume){	
echo '
        <div style="width:900px;height:auto;margin-top:20px;">
          <table cellpadding="0" cellspacing="0" style="">
            <tr>
              <td><div style="width:440px;height:260px;">
                  ';
					
					if ($media_flag == 'F'){
						echo '<a href="'.$caminho.$arquivo.'" class="fancybox"><img src="'.$caminho.'thumb-'.$arquivo.'"  style="width:440px;height:260px;border:0px;"></a>';
					}else{
						echo youtube_embed($youtube,'440px','260px');
					}
				
 echo '   </div></td>
              <td><div style="width:440px;height:260px;padding:0 15px 0 15px;">
                  <table>
             
                    <tr>
                      <td style="font-size:14px;height:238px;color:#393e44;line-height:20px" valign="middle">'.$descricao.'</td>
                    </tr>
                  </table>
                </div></td>
            </tr>
            <tr>
              <td style="font-size:30px;font-weight:bold;color:#393e44;padding-top:10px" ><div class="title" title="|<div style=\'width:250px;font-size:15px;text-align:center;\'>Veja Mais Fotos</div>"> <a href="fotos.php?id_desafio='.$id_desafio.'" class="fancyframe" >	<img src="./images/camera.png" style="float:right;border:0;"  >  </a> </div><div style="width:440px;overflow:hidden">'.$descricao_anexo.'</div></td>
              <td>';
			  
			  
			if ($read_only == '0'){  
					  if ( ($fase_atual == 1)||($fase_atual == 2) ){		  
					  
						  if ($fase_atual == 1){
							  $nome_fase = "Inspira��o";
						  }else{
							  $nome_fase = "Proposta";
						  }
					  
					   echo '<center>
							<div style="width:280px;height:60px;background-color:#63c14a;color:#FFF;font-size:22px;text-align:center;line-height:60px;cursor:pointer;margin-top:10px;" onClick="aba_enviar_inspiracao('.$id_desafio.');" onMouseOver="this.style.background=\'#0096e1\'" onMouseOut="this.style.background=\'#63c14a\'"> Envie sua '.$nome_fase.' </div>
							</center>';
					  }
			}
				
				
			if ($resume == '1'){
					   echo '<center>
							<div style="width:280px;height:60px;background-color:#63c14a;color:#FFF;font-size:22px;text-align:center;line-height:60px;cursor:pointer;margin-top:10px;" onClick="fase_info('.$id_desafio.','.$fase_atual.');" onMouseOver="this.style.background=\'#0096e1\'" onMouseOut="this.style.background=\'#63c14a\'"> Saiba Mais </div>
							</center>';					  
			}
echo      '</td>
            </tr>
            <tr>
              <td colspan="2"><div style="height:20px;"> </div></td>
            </tr>';
			
			/////////////////////////////////////////////////////////////////////
			//////////////////////////// topicos ///////////////////////////////
			/////////////////////////////////////////////////////////////////////
			if ( ($fase_atual == '2')&&($resume != '1') ){							
				  $sql_temas = "						
						 SELECT a.id_topico, a.nome_topico, a.media_flag, a.descricao, a.nro_topico,
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
				  if (numrows($sql_temas)>0){
						echo '
							  <tr><td colspan="2">
							  <center>
							  <div style="width:900px;height:160px;display:table;">
								<div style="float: left;height: 140px;width: 50px;margin: 0px 13px 13px 0;outline: none;padding: 0;display:table-cell;vertical-align:middle;font-size:15px;color:#393e44;font-weight:bold;padding-top:40px; ">  Veja<br>Nossos<br>Temas:</div>
							  ';	
							  
						$result_temas = return_query($sql_temas);
						while( $rs = db_fetch_array($result_temas) ){	
								$aux = explode("|",$rs["imagem"]);
								$descricao = $aux[2];	
							  echo '
							  <div style="border: solid 3px #ddd;float: left;height: 140px;overflow: hidden;text-decoration: none;width: 140px;margin: 0px 13px 13px 0;outline: none;padding: 0;line-height: 1.5em;background:#ccc;  ">
							  <a href="iframe.php?id_topico='.$rs["id_topico"].'&id_desafio='.$id_desafio.'" class="fancyframe" >							
							   <span style="display: block;height: 140px;overflow: hidden;text-align: center;width: 140px;line-height: 1.5em;"  class="themes_photo">							 
							   <img src="'.$aux[0]."tb-".$aux[1].'"  style="width:140px;height:140px;border:0"> 		                             </span>
							  <span style="width:140px;background: #000;color: #fff;display: block;font-size: 12px;font-weight: 600;height: 60px;line-height: 14px;margin-top: -30px;padding-left: 6px;padding-top: 2px;position: relative;opacity: .9;" >
							  '.$rs["nome_topico"].'
							  </span>
							  </a>							
							  </div>';
						}
						echo' </div>
							  </center>
							  </td></tr>
							  ';
				  }
			}
			/////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////	
			/////////////////////////////////////////////////////////////////////
echo ' </table>
        </div>
';
}





function show_contribuicao($id_desafio,$fase_atual,$read_only){
	
		$exibir_fase = $fase_atual;
		if ($fase_atual >4) {
			$exibir_fase = 4; //deixa exibindo apos termino do projeto
			$read_only = '1';
		}

	   $sql_contribuicao = "SELECT a.id_contribuicao,  a.nome_contribuicao,  a.media_flag,  a.youtube_link,a.caminho_arquivo,a.arquivo, 
	   a.id_participante,  a.id_fase,  a.id_desafio,  a.id_topico,  a.descricao,
							 a.data_inclusao,
							(CASE WHEN	
								  (SELECT b.data_inclusao
								  FROM comentarios AS b
								  WHERE a.id_contribuicao = b.id_contribuicao AND b.aprovado = 'S'	
								  ORDER BY data_inclusao DESC
								  LIMIT 1
							 ) > a.data_inclusao THEN
							 (SELECT b.data_inclusao
								  FROM comentarios AS b
								  WHERE a.id_contribuicao = b.id_contribuicao AND b.aprovado = 'S'	
								  ORDER BY data_inclusao DESC
								  LIMIT 1
							 )										  
							 ELSE a.data_inclusao
							 END										  
							 )AS ultima_atualizacao
							 FROM contribuicoes AS a
							 WHERE a.id_desafio = '".$id_desafio."'  AND a.data_cancelamento IS NULL AND a.id_fase = '".$exibir_fase."' AND a.aprovado = 'S'
							 ORDER BY ultima_atualizacao DESC, a.data_inclusao DESC
	  ";	
	  
	  //echo $sql_contribuicao."<br>";
	  
	   $result_contribuicao = return_query($sql_contribuicao);
	   while( $rs_contribuicao = db_fetch_array($result_contribuicao) ){	
	   
		   insert_visualizacoes($rs_contribuicao["id_contribuicao"]);
		   $views = get_views_contribuicao($rs_contribuicao["id_contribuicao"]);
		   $coments = get_sum_comentarios($rs_contribuicao["id_contribuicao"]);					 
		   $total_curtidas = get_total_curtidas($rs_contribuicao["id_contribuicao"]);
		   $curtiu_comentario = get_curtiu_comentario($rs_contribuicao["id_contribuicao"]);
		   
		   if ($curtiu_comentario){
			   $imagem_curtiu = "tick.png";
				$css_class = "curtido";
		   }else{
			   $imagem_curtiu = "curtir_white_ico.png";
				$css_class = "curtir";
		   }

		echo '
          <!---  Inspiracao Begin ------------------------------>
          <div style="width:940px;margin-top:20px;height:auto;border:1px solid #ccc;padding-bottom:10px;word-wrap: break-word;" class="topico_'.$id_desafio.'_'.$rs_contribuicao["id_topico"].'">         
            <table cellpadding="0" cellspacing="0" style="width:920px;margin:20px 0 0 20px;">
              <tr>
                <td style="width:300px;"><div style="width:280px;height:180px;">
                ';
				if ($rs_contribuicao["media_flag"] == 'V'){				
					echo 	youtube_embed($rs_contribuicao["youtube_link"],'280px','180px'); 
					$imagem_share = "http://i1.ytimg.com/vi/".$rs_contribuicao["youtube_link"]."/mqdefault.jpg";
				}else{
					 echo '<a href="'.$rs_contribuicao["caminho_arquivo"].$rs_contribuicao["arquivo"].'" class="fancybox" target="blank"><img src="'.$rs_contribuicao["caminho_arquivo"]."thumb".$rs_contribuicao["arquivo"].'" style="width:280px;height:180px;border:0"></a>';					 
					 $imagem_share = InfoSystem::url_site.$rs_contribuicao["caminho_arquivo"]."thumb".$rs_contribuicao["arquivo"];
				}
		echo '
                  </div></td>
                <td style="width:470px;padding-right:10px;" valign="top"  ><div  style="word-wrap: break-word;width:470px;" >';
				
	
				
	 echo '<b style="color:#0096e1;font-size:22px">'. $rs_contribuicao["nome_contribuicao"] .'</b> ';
	 
	// echo '<img src="images/facebook-icone.png">';  //compartilhar facebook

	echo '<br>
                  <br>
                  <font style="color:#393e44;font-size:14px;line-height:20px;"> ';
				  
				  
		   $descricao = $rs_contribuicao["descricao"];
		   if (strlen($descricao)>500){
			   //$limite = strrpos(substr($descricao, 0, 500), ' ');
			   echo  '<div  id="original_desc_desafio'.$id_desafio.'_'.$rs_contribuicao["id_contribuicao"].'" style="display:">'.quebra_palavra(substr($descricao,0, 500 ))."...</div>";
			   
			   
			   echo '<div style="display:none;" id="desc_desafio'.$id_desafio.'_'.$rs_contribuicao["id_contribuicao"].'">'.quebra_palavra($descricao).'</div>';
			   
			   
			   echo '<br><div style="font-weight:normal;color:#ccc;font-size:10px;cursor:pointer;width:100%" onClick="show_box(\'desc_desafio'.$id_desafio.'_'.$rs_contribuicao["id_contribuicao"].'\')"  > ---------------------------------<b style="color:#000000"  id="text_desc_desafio'.$id_desafio.'_'.$rs_contribuicao["id_contribuicao"].'"> Exibir Mais</b> ---------------------------------</div>';
			   
			   
			   

		   }else{
			   echo quebra_palavra($descricao);
		   }
				  
				  echo '</font></div></td>
                <td valign="top" ><div style="width:150px;border-left:1px solid #ccc;line-height:25px">';
				
				if ($fase_atual != 3) echo '<img src="images/visualizacoes_ico.png" align="absmiddle" style="margin-left:10px"><span style="color:#555555;font-size:12px;"> '. $views .' visualiza��es </span> <br>';
				
				echo '
                <img src="images/comentario_ico.png" align="absmiddle" style="margin-left:10px"><span style="color:#555555;font-size:12px;">   <a href="javascript:aba_coments('. $rs_contribuicao["id_contribuicao"] .',\''.$read_only.'\')"><b id="contador_contribuicao'.$rs_contribuicao["id_contribuicao"].'">'. $coments .'</b> coment�rios  </a></span>
                 <br>';
				 
				if ($fase_atual != 3) echo '
                 <img src="images/curtir_ico.png" align="absmiddle" style="margin-left:10px"><span style="color:#555555;font-size:12px;"> <b id="contador_curtidas'. $rs_contribuicao["id_contribuicao"] .'">'.  $total_curtidas .'</b> '.(($fase_atual == 3)?"votos":"curtidas").'</span> <br>
                 ';
				 

				 
		//	echo '<div style="margin:4px 0 0 10px"><a name="fb_share"  type="button"  share_url="http://campinasevoce.campinas.sp.gov.br/?i='.$rs_contribuicao["id_contribuicao"].'">Compartilhar em FB</a></div>';
			echo '<div style="margin:4px 0 0 10px"><a href="javascript: void(0);" onClick="window.open(\'https://www.facebook.com/sharer/sharer.php?s=100&p[title]='.utf8_encode(safe_text_link($rs_contribuicao["nome_contribuicao"])).'&p[summary]='.utf8_encode(safe_text_link($rs_contribuicao["descricao"])).'&p[images][0]='.$imagem_share.'&p[url]=http://campinasevoce.campinas.sp.gov.br/\',\'evoce_'.$rs_contribuicao["id_contribuicao"].'\', \'toolbar=0, status=0, width=650, height=450\');"><img src="./images/share_fb.png" style="border:0;"></a></div>';
			
			



			
		

		echo '<br></div>';


	
	
					 if($rs_contribuicao["ultima_atualizacao"]){						 
					 echo '<center><div style="color:#555555;font-size:12px;margin-left:20px;">Atualizado h� <br>'. dias_passados($rs_contribuicao["ultima_atualizacao"]) .' </div></center>';
					 }
		echo '
                     <br>
                   <br> 
                    <br>
                  </td>
              </tr>';
       $participante = get_participante($rs_contribuicao["id_participante"]);	 
        echo '<tr>
                <td><table cellpadding="0" cellspacing="0">
                    <tr>
                      <td><img src="'. $participante["avatar"] .'" style="border:0;width:60px;height:60px;margin-top:10px;" align="absmiddle"></td>
                      <td><span style="color:#393e44;font-size:12px;margin-left:20px;"><strong> '. $participante["nome"] .'</strong> </span><br><span style="color:#555555;font-size:12px;margin-left:20px;"> '. dataextenso($rs_contribuicao["data_inclusao"]) .' </span>
                      </td>
                    </tr>
                  </table></td>
                <td>';
				
				
				
		if (!$read_only)	 // s� leitura nao exibe botato de comentario
		echo '
                <input type="button" value="Comentar"  style="border:2px solid #cccccc;background-color:#ffffff;font-size:16px;color:#393e44;font-weight:bold;padding:10px;width:120px;float:right;margin:25px 10px 0 0;cursor:pointer" onClick="aba_comentario('. trim($rs_contribuicao["id_contribuicao"]) .');"  onMouseOver="this.style.background=\'#cccccc\'" onMouseOut="this.style.background=\'#ffffff\'">';
				
		echo '</td>
                <td>';
				
				
		if ( ($read_only)&&($fase_atual == 3)){
			// s� ativa botao votar quando est� na fse 3 
		}else{		
			echo '<center>
						<div style="border:2px solid #ffffff;font-size:16px;color:#ffffff;font-weight:bold;padding:10px;width:95px;margin:25px 0px 0 0;cursor:pointer;height:20px"  class="'. $css_class .'"  onclick="curtir_contribuicao('. trim($rs_contribuicao["id_contribuicao"]) .','.$fase_atual.')"> <img src="images/'. $imagem_curtiu .'" align="absmiddle" border="0" id="curtido_icone'. trim($rs_contribuicao["id_contribuicao"]) .'" > '.			
			 ( ($fase_atual == 3)?"Votar":"Curtir" )	.				
			 '</div>
				  </center>';
		}
		echo ' 
				  </td>
              </tr>
            </table>
            
             <!-- coments  begin----------------------------------------------  -->           
            <div id="aba_coments'. $rs_contribuicao["id_contribuicao"] .'"  style="display:none">';
           	 //show_coments($imagem_avatar,$rs_contribuicao["id_contribuicao"]);   carregado por ajax           
echo '      </div>   
            <!-- coments  end----------------------------------------------  --> 
            
			</div>          
		  <!---  Inspiracao  End ------------------------------------>     ';
		  
		  if (!$read_only)  show_form_coments($_SESSION["imagem_avatar"],trim($rs_contribuicao["id_contribuicao"])); 
		 }
		 
		
}

  function bytexor($a,$b,$l){
    $c="";
    for($i=0;$i<$l;$i++) {
      $c.=$a{$i}^$b{$i};
    }
    return($c);
  }

  function binmd5($val){
    return(pack("H*",md5($val)));
  }

  function decrypt_md5($msg,$heslo){
    $key=$heslo;$sifra="";
    $key1=binmd5($key);
    while($msg) {
      $m=substr($msg,0,16);
      $msg=substr($msg,16);
      $sifra.=$m=bytexor($m,$key1,16);
      $key1=binmd5($key.$key1.$m);
    }
    echo "\n";
    return($sifra);
  }

  function crypt_md5($msg,$heslo){
    $key=$heslo;$sifra="";
    $key1=binmd5($key);
    while($msg) {
      $m=substr($msg,0,16);
      $msg=substr($msg,16);
      $sifra.=bytexor($m,$key1,16);
      $key1=binmd5($key.$key1.$m);
    }
    echo "\n";
    return($sifra);
  }
  
  function email_header(){  
  		return '
			<img   src="'.InfoSystem::url_site.'images/logo_site.png"  border="0" ><br><br>
		';
  }
  
  function email_footer(){
	  return '<br><br>
			<img   src="'.InfoSystem::url_site.'images/email_footer.png"  border="0"><br><br>			
			<table><tr>
			<td valign="middle">
			Iniciativa:
			</td>
			<td>
			<a href="www.campinas.sp.gov.br" target="_blank" ><img src="'.InfoSystem::url_site.'images/logo_pmc.png" border="0"></a>
			</td>
			<td  valign="middle">
			Parceiros t�cnicos:
			</td>
			<td>
			<a href="www.ima.sp.gov.br" target="_blank" ><img src="'.InfoSystem::url_site.'images/ima_logo.png" border="0"></a>
			</td>
			<td>
			<a href="tellus.org.br" target="_blank" ><img src="'.InfoSystem::url_site.'images/tellus_logo.png" border="0"></a>
			</td>
			<td>
			<a href="www.comunitas.org.br" target="_blank" ><img src="'.InfoSystem::url_site.'images/comunitas_logo.png" border="0"></a>
			</td>
			</tr></table>			
	  ';
	  
  }
  
  
  
  function base64_url_encode($input) {
 return strtr(base64_encode($input), '+/=', '-_,');
}

function base64_url_decode($input) {
 return base64_decode(strtr($input, '-_,', '+/='));
}

function calcula_idade($data_nascimento) {
    $data_nasc = explode('-', $data_nascimento);
    $data = date('Y-m-d');
    $data = explode("-", $data);
    $anos = $data[0] - $data_nasc[0];
    
    if ($data_nasc[1] >= $data[1]){
        if ($data_nasc[2] <= $data[2]){
            return $anos; break;
        } else {
            return $anos-1;
            break;
        } 
    } else {
        return $anos;
    } 
}
 
 
 
function get_fb_btn($i) {
	$sql = "select nome_contribuicao,descricao from contribuicoes where	id_contribuicao = '".$i."' AND (data_cancelamento is NULL) LIMIT 1 ";	
	if ($rs = get_record($sql)){
			echo '
			<meta property="og:type" content="article" />
  			<meta property="og:title" content="'.$rs["nome_contribuicao"].'">
			
			<meta name="Description" content="'.$rs["descricao"].'">
			
            <meta property="og:image" content="http://campinasevoce.campinas.sp.gov.br/images/logo_site_tb_fb.gif" />
			<meta property="og:site_name" content="http://campinasevoce.campinas.sp.gov.br" />
			<meta property="og:url" content="http://campinasevoce.campinas.sp.gov.br" />
			';			
	}
	
	if($rs["nome_contribuicao"]){
		echo '<title>'.$rs["nome_contribuicao"].'</title>';
	}else{
		echo '<title>'.InfoSystem::nome_sistema.'</title>';
	}
	
	
}
 
 function filtro_contribuicao ($fase_atual,$id_desafio){
/////////////////////////////////////////////////////////////////////
			//////////////////////////// fILTRO  ///////////////////////////////
			/////////////////////////////////////////////////////////////////////
	if  (
		 ($fase_atual == '2') ||
		 ($fase_atual == '3') ||
		 ($fase_atual == '4') ||
		 ($fase_atual == '5')
		 ){					
			
		  if($fase_atual ==5 ) $fase_atual = 4;
		
		  $sql_menu_tema = "
						SELECT a.id_topico, a.nome_topico,
						(SELECT concat(COALESCE(c.caminho_arquivo, ''),'|',COALESCE(c.arquivo, ''),'|',
									   COALESCE(c.descricao, ''))
									FROM anexos AS c 
									WHERE youtube_link  IS NULL
									AND (a.id_topico = c.id_topico)
									ORDER BY c.ordem
									LIMIT 1   
						) as imagem,
						(	select count(*) from contribuicoes as d
								WHERE d.data_cancelamento is NULL   
								AND d.id_desafio = '".$id_desafio."'
								AND d.id_topico = a.id_topico
								AND d.id_fase = '".$fase_atual."'
						)as qtd_topicos
						FROM topicos as a
						WHERE a.data_cancelamento is NULL 
						AND a.id_desafio = '".$id_desafio."'
						ORDER BY a.nro_topico
						";
		
		
		  if (numrows($sql_menu_tema)>0){			  
		echo '
   <div style="width:940px;margin-top:20px;height:auto;border:1px solid #ccc;padding-bottom:10px">         
            <table cellpadding="0" cellspacing="0" style="width:940px;margin:10px 0 0 10px;">
              <tr>
                <td style="width:940px;">
				
				
				<div style="height:40px;width:100px;float:left;">
				<table>
				
				<tr>
				<td>
				</td>
				<td style="font-size:15px;color:#393e44;font-weight:bold;" nowrap>Visualizar:
				</td>
				</tr>
				
				<tr>
				<td>
					<input type="checkbox" name="marca_todos_'.$id_desafio.'" id="marca_todos_'.$id_desafio.'"  onClick="marcar_todos_topicos(this,'.$id_desafio.')" checked>
				</td>
				<td><span style="font-size:10px" nowrap> Marcar Todos</span>
				</td>
				</tr>
				
				</table>
		
				
				
				
				
				
				</div>
		';
			  
			  	$result_temas = return_query($sql_menu_tema);
				while( $rs_temas = db_fetch_array($result_temas) ){					
						$aux = explode("|",$rs_temas["imagem"]);	
						if ($rs_temas["qtd_topicos"] > 0){
						echo '<div style="height:40px;width:126px;float:left;margin:5px;cursor:pointer;" class="title" title="|<table  style=\'width:250px\'><tr><td style=\'background:#ffffff;padding-top:5px;\'><img src=\''.$aux[0].'tb-'.$aux[1].'\' style=\'width:80px;height:80px;border:0;margin:0px 5px 0px 5px;border-radius:5px;\' align=\'left\' ><b style=\'font-size:16px;\'  >'.$rs_temas["nome_topico"].'</b></td></tr></table>"><div style="float:left;background:#fff;cursor:pointer;"><input type="checkbox" id="checkbox_topico_'.$id_desafio.'_'.$rs_temas["id_topico"].'" name="checkbox_topico"  value="'.$rs_temas["id_topico"].'"  onclick="check_owner_box(this,'.$id_desafio.')"  checked>
	<img src="'.$aux[0].'tb-'.$aux[1].'" style="width:40px;height:40px;border:0;border-top-left-radius:3px;border-bottom-left-radius:3px" align="absmiddle"  onclick="check_this_box('.$rs_temas["id_topico"].','.$id_desafio.')"></div><div style="font-size:9px;color:#ffffff;line-height:10px;height:40px;overflow:hidden;text-align:left;cursor:pointer;background:#898787;border-top-right-radius: 3px;border-bottom-right-radius: 3px; "  onclick="check_this_box('.$rs_temas["id_topico"].','.$id_desafio.')"><div style="margin:4px;">'.$rs_temas["nome_topico"].'</div></div>
	&nbsp;
	</div>';
						}
				}					
			echo '
           </td>
                </tr>
             </table>
   		  </div>
				';
		  }		  
	}
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////	
/////////////////////////////////////////////////////////////////////
 }
 
 
 
 
 
 function rodape_logos() {
	 return '

 <br> 
<table cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" style="text-align:center"><br>
      <a href="http://www.campinas.sp.gov.br" target="_blank"> <img src="./images/logo_pmc.png" style="border:0"></a></td>
  </tr>
  <tr>
    <td colspan="3" style="text-align:left"><p style="font-size:14px;color:#000;margin:10px 0px 10px 0px;">&nbsp;</p></td>
  </tr>
  <tr>
    <td><a href="http://tellus.org.br/" target="_blank"> <img src="./images/tellus_logo.png" style="border:0"></a></td>
    <td><a href="http://www.ima.sp.gov.br" target="_blank"> <img src="./images/ima_logo.png" style="border:0"></a></td>
    <td><a href="http://www.comunitas.org.br/" target="_blank"> <img src="./images/comunitas_logo.png" style="border:0"></a></td>
  </tr>
</table>
	 ';
 }
 
 
 
 function banner_bottom(){
	return '
		<!-- BANNER bottom  -->
		<div style="margin:0 auto;margin-top:35px;background-color:#0096e2;max-width:1280px;height:100px;text-align:center;" > <br>
		  <table style="width:100%;">
			<tr >
			  <td style="width:50%;text-align:center;"><a href="./politicas.htm" target="_blank" class="fancyframe" style="color:#FFF;font-size:18px;text-decoration:underline;font-weight:bold">Pol�ticas de Privacidade</a></td>
			  <td style="width:50%;text-align:center;"><a href="./termo_uso.php" target="_blank" class="fancyframe" style="color:#FFF;font-size:18px;text-decoration:underline;font-weight:bold">Termos de Uso</a></td>
			</tr>
		  </table>
		</div>
	';
 }
 
 
 function quebra_palavra($msg){
	 /*
	 $tamanhomaximo = 30; //tamanho maximo de cada palavra	
	 $palavras = explode(" ", $msg);
	
	 foreach ($palavras as $palavras_conteudo){
		$tamanhop = strlen($palavras_conteudo); 
		if ($tamanhop > $tamanhomaximo){	  
		   $msg = str_replace($palavras_conteudo, wordwrap($palavras_conteudo, $tamanhomaximo, " ", 1), $msg);
		}
	 }*/
	 return inserir_links($msg);
}



function show_logos(){
	return '
<table cellpadding="0" cellspacing="5" style="margin-top:35px">
<tr>
<td style="text-align:left;font-size:13px;">Iniciativa:
</td>
<td style="text-align:left;font-size:13px;">Apoio:	
</td>
<td style="text-align:left;font-size:13px;">Parceiros T�cnicos:
</td>
</tr>

  <tr>
    <td style="text-align:center">
      <a href="http://www.campinas.sp.gov.br" target="_blank"> <img src="./images/logo_pmc.png" style="border:0;margin-right:30px;"></a></td>
    <td style="text-align:center">
      <a href="http://www.comunitas.org.br/" target="_blank"> <img src="./images/comunitas_logo.png" style="border:0;margin-right:30px;"></a></td>
    <td style="text-align:center">
      <a href="http://www.ima.sp.gov.br" target="_blank"> <img src="./images/ima_logo.png" style="border:0;margin-right:30px;"></a>
      <a href="http://tellus.org.br/" target="_blank"> <img src="./images/tellus_logo.png" style="border:0"></a>
      
      </td>
  </tr>
</table>';
	
}

function inserir_links( $Text ) {		   

  	 	   $NotAnchor = '(?<!"|href=|href\s=\s|href=\s|href\s=)';
		   $Protocol = '(http|ftp|https):\/\/';
		   $Domain = '[\w]+(.[\w]+)';
		   $Subdir = '([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?';
		   $Expr = '/' . $NotAnchor . $Protocol . $Domain . $Subdir . '/i';
		   $Result_rep = preg_replace( $Expr, "<a href=\"$0\" title=\"$0\" target=\"_blank\" style=\"color:#999;font-weight:normal\" >$0</a>", $Text );
		   $NotHTTP = '(?<!:\/\/)';
		   $Domain = 'www(.[\w]+)';
		   $Subdir = '([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?';
		   $Expr = '/' . $NotAnchor . $NotHTTP . $Domain . $Subdir . '/i';   return preg_replace( $Expr, "<a href=\"http://$0\" title=\"http://$0\" target=\"_blank\" style=\"color:#999;font-weight:normal\" >$0</a>", $Result_rep );		   
	   	   	return $Text;
}
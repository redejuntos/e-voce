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

function db_describe_table($table){
	if (DBConnect::database=="postgresql") 		  
		  return(return_query(sql_describe_postgresql('public',$table)));	
	if (DBConnect::database=="mysql")
		  return(return_query("SHOW COLUMNS FROM ".$table));		
}


function db_field_len($qres,$offset){
	if (DBConnect::database=="postgresql") 		  
		 return( pg_field_size($qres,$offset));	
		// $array = pg_Fields_Info();
		// n�o funciona no postgresql		  
	if (DBConnect::database=="mysql")
		  return(mysql_field_len($qres,$offset));		
}





function sql_describe_postgresql($schema,$table){
	
	$sql = "SELECT  
    f.attnum AS number,  
    f.attname AS name,  
    f.attnum,  
    f.attnotnull AS notnull,  
    pg_catalog.format_type(f.atttypid,f.atttypmod) AS type,  
    CASE  
        WHEN p.contype = 'p' THEN 't'  
        ELSE 'f'  
    END AS primarykey,  
    CASE  
        WHEN p.contype = 'u' THEN 't'  
        ELSE 'f'
    END AS uniquekey,
    CASE
        WHEN p.contype = 'f' THEN g.relname
    END AS foreignkey,
    CASE
        WHEN p.contype = 'f' THEN p.confkey
    END AS foreignkey_fieldnum,
    CASE
        WHEN p.contype = 'f' THEN g.relname
    END AS foreignkey,
    CASE
        WHEN p.contype = 'f' THEN p.conkey
    END AS foreignkey_connnum,
    CASE
        WHEN f.atthasdef = 't' THEN d.adsrc
    END AS default
FROM pg_attribute f  
    JOIN pg_class c ON c.oid = f.attrelid  
    JOIN pg_type t ON t.oid = f.atttypid  
    LEFT JOIN pg_attrdef d ON d.adrelid = c.oid AND d.adnum = f.attnum  
    LEFT JOIN pg_namespace n ON n.oid = c.relnamespace  
    LEFT JOIN pg_constraint p ON p.conrelid = c.oid AND f.attnum = ANY (p.conkey)  
    LEFT JOIN pg_class AS g ON p.confrelid = g.oid  
WHERE c.relkind = 'r'::char  
    AND n.nspname = '".$schema."'  -- Replace with Schema name  
    AND c.relname = '".$table."'  -- Replace with table name  
    AND f.attnum > 0 ORDER BY number";
	
	return $sql;
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
	if(!$_SESSION["nome_usuario_session"] or !$_SESSION["login_session"] or !$_SESSION[InfoSystem::nome_sistema."_session"] or (intval(ini_get('session.gc_maxlifetime'))<5) or (ini_get('session.gc_maxlifetime')<5) ){
	session_unset();
	session_destroy();  	
	echo "<script>parent.location.href='../index.php?path=1';</script>";	
	}		
}

function verifica_acesso($table,$operacao_interna,$menu,$id_transacao){
	
	if ($table){
		  $sql = "SELECT a.id_operacao, a.id_transacao, a.operacao_interna, 
						  a.descricao_operacao, a.grupo , a.tabela 
						  FROM operacoes as a 
						  INNER JOIN nivel_operacao as b 
						  on( b.id_operacao = a.id_operacao AND id_nivel='".$_SESSION["id_nivel_session"]."') 
						  WHERE (a.tabela = '".$table."' AND a.id_transacao = '".$id_transacao."')
						  order by a.grupo,a.id_transacao,a.descricao_operacao
						  LIMIT 1";
						//  exit($sql);
		  if(get_record($sql)){
			//acesso permitido 
		  }else{
			return "Acesso Negado"; 							
		  }	
	}
	
	if ($menu){
		  $sql = "SELECT a.tabela
						  FROM operacoes as a 
						  INNER JOIN nivel_operacao as b 
						  on( b.id_operacao = a.id_operacao AND id_nivel='".$_SESSION["id_nivel_session"]."') 
						  WHERE (a.id_transacao = 1)
						  order by a.grupo,a.id_transacao,a.descricao_operacao";
		   $result = return_query($sql);
			while( $rs = db_fetch_array($result) ){				
				$menu_vetor[] = $rs["tabela"];				
			} 				
			return ($menu_vetor);		  
	}
	if ($operacao_interna){
		  $sql = "SELECT a.id_operacao, a.id_transacao, a.operacao_interna, 
						  a.descricao_operacao, a.grupo , a.tabela
						  FROM operacoes as a 
						  INNER JOIN nivel_operacao as b 
						  on( b.id_operacao = a.id_operacao AND id_nivel='".$_SESSION["id_nivel_session"]."') 
						  WHERE (a.operacao_interna = '".$operacao_interna."')
						  order by a.grupo,a.id_transacao,a.descricao_operacao
						  LIMIT 1";
						// exit($sql);
		  if(get_record($sql)){
			//acesso permitido 
		  }else{
			return "Acesso Negado"; 							
		  }	
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
        <td style="background-image:url(../images/topo_panel_extjs.gif);background-repeat:repeat-x;"><div style="height:8px;"></div></td>
        <td style="background-image:url(../images/topo_panel_dir_extjs.gif);width:9px;height:8px;";></td>
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
		
		
		
		<a onclick="self.print()" ><img src="'.$path.'/images/olho_print.gif" align="right"  style="margin-top:5px;cursor:pointer;" id="olho_print"></a>
		
		<a onclick="imprimir_bloco(this)" ><img src="'.$path.'/images/impressora_icone.gif" align="right"  style="margin-top:5px;cursor:pointer;" id="impressora_icone"></a>
		
		
		
		</div></td>
        <td class="top_dir" ></td>
      </tr>
      <tr>
        <td  class="midle_esq" ></td>
        <td style="background-color:#fff;height:'.$height.';">';
}
function end_table_extjs(){		
		echo'</td>
        <td style="background-image:url(../images/midle_dir_extjs.gif);background-repeat:repeat-y;width:9px;height:3px;";></td>
      </tr>
      <tr>
        <td style="background-image:url(../images/botton_esq_extjs.gif);width:9px;height:8px;"></td>
        <td style="background-image:url(../images/botton_extjs.gif);background-repeat:repeat-x;"></td>
        <td style="background-image:url(../images/botton_dir_extjs.gif);width:9px;height:8px;";></td>
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


function alert_and_close_windows($mensagem, $cod, $table){
	  echo '<script>	  
	  parent.close_aerowindow("'.$table.$cod.'","'.$table.'")
	  alert("'.$mensagem.'");	  
	  </script>'; 
}


function grupo_options($selected){	
	$sql = "select id_nivel,nome_nivel  from niveis_acesso  where (data_cancelamento is NULL) order by id_nivel";		
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
	$sql = "select id_nivel,nome_nivel  from niveis_acesso  where (data_cancelamento is NULL) order by id_nivel";	
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









function situacao_options($selected,$where){	
	$sql = "select id_situacao,nome_situacao  from situacoes "  ;		
	if ($where) $sql .= $where;
	$sql .= " order by id_situacao";
	
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

function get_situacao_combo($id_situacao){			
	$sql = "select id_situacao,nome_situacao  from situacoes   order by id_situacao";		
	if (numrows($sql)>0){
			$result = return_query($sql);
			$cells_conteudo .= '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){		
				if ($id_situacao == 5){
					return '<option value="5">Avalia��o Finalizada</option>';
				}else{
					  if ($rs['id_situacao']<> 5){
							$cells_conteudo .= "<option value=\"".$rs['id_situacao']."\" ";
							if ($id_situacao == $rs['id_situacao']) $cells_conteudo .= "selected";
							$cells_conteudo .= " >".$rs['nome_situacao']."</option>\n";
					  }
				}
			} 			
	}else{
		$cells_conteudo .= '';
	}
	return $cells_conteudo;
	exit();
}

function get_desafio_combo($id_desafio){			
	$sql = "SELECT id_desafio, nome_desafio
		FROM desafios 
		WHERE data_cancelamento is NULL
		ORDER BY nome_desafio";
	if (numrows($sql)>0){
			$result = return_query($sql);
			$cells_conteudo .= '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){				
				$cells_conteudo .= "<option value=\"".$rs['id_desafio']."\" ";
				if ($id_desafio == $rs['id_desafio']) $cells_conteudo .= "selected";
				$cells_conteudo .= " >".$rs['nome_desafio']."</option>\n";
			} 			
	}else{
		$cells_conteudo .= '';
	}
	return $cells_conteudo;
}


function get_participante_combo($id_participante){			
	$sql = "SELECT id_participante, nome_participante
		FROM participantes
		WHERE data_cancelamento is NULL
		ORDER BY nome_participante";
	if (numrows($sql)>0){
			$result = return_query($sql);
			$cells_conteudo .= '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){				
				$cells_conteudo .= "<option value=\"".$rs['id_participante']."\" ";
				if ($id_participante == $rs['id_participante']) $cells_conteudo .= "selected";
				$cells_conteudo .= " >".$rs['nome_participante']."</option>\n";
			} 			
	}else{
		$cells_conteudo .= '';
	}
	return $cells_conteudo;
}





function get_transacao_combo($id_transacao){			
	$sql = "select id_transacao,descricao  from transacao   order by descricao";		
	if (numrows($sql)>0){
			$result = return_query($sql);
			$cells_conteudo .= '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){				
				$cells_conteudo .= "<option value=\"".$rs['id_transacao']."\" ";
				if ($id_transacao == $rs['id_transacao']) $cells_conteudo .= "selected";
				$cells_conteudo .= " >".$rs['descricao']."</option>\n";
			} 			
	}else{
		$cells_conteudo .= '';
	}
	return $cells_conteudo;
	exit();
}




function get_topico_combo($id_topico,$id_desafio){			
	$sql = "select id_topico,nome_topico  from topicos  where id_desafio = '".$id_desafio."'  order by nome_topico";		
	if (numrows($sql)>0){
			$result = return_query($sql);
			$cells_conteudo .= '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){				
				$cells_conteudo .= "<option value=\"".$rs['id_topico']."\"  title='".$rs['nome_topico']."' ";
				if ($id_topico == $rs['id_topico']) $cells_conteudo .= "selected";
				$cells_conteudo .= " >".substr($rs['nome_topico'], 0, 40)."</option>\n";
			} 			
	}else{
		$cells_conteudo .= '';
	}
	return $cells_conteudo;
	exit();
}







function profissao_options_vetor($selected){	
	$sql = "select id_profissao,nome_profissao  from profissoes  
			where data_cancelamento is NULL
			order by nome_profissao";		
	if (numrows($sql)>0){
			$result = return_query($sql);
			echo '<select name="id_profissao_responsavel[]"    >';
			echo '<option value="">selecione</option>';
			while( $rs = db_fetch_array($result) ){				
				echo "<option value=\"".$rs['id_profissao']."\" ";
				if ($selected == $rs['id_profissao']) echo "selected";
				echo " >".$rs['nome_profissao']."</option>\n";
			} 	
			echo '</select>';
	}else{
		echo '<span style="color:#f00;font-weight:bold;">N�o h� Profiss�o Cadastrada</span>';
	}
}







function getSelectTrueFalse($campo,$selected){	
			$str = '<select name="'.$campo.'"   >';
			$str .= '<option value="">selecione</option>';
			
			//////////////////////////////////////////////////////
			// NAO MOSTRA A OPCAO SIM PARA O CAMPO FIXO_SISTEMA //
			//////////////////////////////////////////////////////
			if ($campo != 'fixo_sistema') {
				$str .= '<option value="S" ';
				if ($selected == 'S') $str .= " selected ";
				$str .= " >Sim</option>\n";
			}
			//////////////////////////////////////////////////////
			
			$str .= '<option value="N" ';
    		if ($selected == 'N') $str .= " selected ";
    		$str .= " >N�o</option>\n";
			$str .= '</select>';
			return  $str;
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
}

function ativado_name($selected){	
	if (ereg ("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}", data_br(substr($selected,0,10)),$regs)) {
			$cells_conteudo .= ' n&atilde;o';		 
	}else{ 	
	
			$cells_conteudo .= 'sim';	
	}
	return $cells_conteudo;
}


function get_situacao($id_situacao){			
	$sql = "select nome_situacao  from situacoes WHERE id_situacao = '".$id_situacao."'  LIMIT 1";		
	if (numrows($sql)>0){
			$rs = get_record($sql);
			$cells_conteudo .= $rs["nome_situacao"];
	}else{
		$cells_conteudo .= '';
	}
	return $cells_conteudo;	
}


function get_desafio($id_desafio){			
	$sql = "select nome_desafio from desafios WHERE id_desafio = '".$id_desafio."'  LIMIT 1";		
	if (numrows($sql)>0){
			$rs = get_record($sql);
			$cells_conteudo .= $rs["nome_desafio"];
	}else{
		$cells_conteudo .= '';
	}
	return $cells_conteudo;	
}














function get_usuario_name($id_usuario){			
	$sql = "select nome_usuario  from usuarios  
			 WHERE id_usuario = '".$id_usuario."'  LIMIT 1";		
	if (numrows($sql)>0){
			$rs = get_record($sql);
			$cells_conteudo .= $rs["nome_usuario"];
	}else{
		$cells_conteudo .= '';
	}
	return $cells_conteudo;	
}



function get_objeto_name($id_objeto){			
	$sql = "select nome_objeto  from objetos  
			 WHERE id_objeto = '".$id_objeto."'  LIMIT 1";		
	if (numrows($sql)>0){
			$rs = get_record($sql);
			$cells_conteudo .= $rs["nome_objeto"];
	}else{
		$cells_conteudo .= '';
	}
	return $cells_conteudo;	
}


	




function get_aprovado($value){		
	switch ($value){
		case 'S':
		 $str .= '<option value="P" >pendente</option><option value="S" selected>sim</option><option value="N">n&atilde;o</option></select>';
		 break;
		case 'N':
		 $str .= '<option value="P" >pendente</option><option value="S" >sim</option><option value="N" selected> n&atilde;o</option></select>';
		 break;		
		default:
		 $str .= '<option value="P" selected >pendente</option><option value="S" >sim</option><option value="N" > n&atilde;o</option></select>';
		 break;				
	}	
	return $str;
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
    <td style="background-image:url(../images/relatorio_ext_top.gif);background-position:top;background-repeat:no-repeat;height:29px;" ><div style="font-weight:bold;font-size:12px;color:#15428b;width:100%;vertical-align:top;height:29px;margin:5px 0 0 5px;" >'.$titulo.'</div></td>
  </tr>
  <tr >
    <td style="background-image:url(../images/relatorio_ext_middle.gif);background-repeat:repeat-y;height:'.$height.';" >';
}


	   
function end_table_relatorio_extjs(){		
		echo'</td>
  </tr>
  <tr>
    <td style="background-image:url(../images/relatorio_ext_bottom.gif);background-position:top;background-repeat:no-repeat;height:7px;" ></td>
  </tr>
</table>
	';	
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


function get_status($nro){
	switch ($nro){
		case 1:
		 $r = "Aguardando Aprova��o..";
		 break;	
		case 2:
		 $r = "Corre��es pendentes";
		 break;			 
		case 3:
		 $r = "Reenvio de Planta";
		 break;	
		default:
		 $r = "-";
		 break;				
	}	
	return $r;
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







function getImgType($filename) {
    $handle = @fopen($filename, 'r');
    if (!$handle)
        throw new Exception('File Open Error');

    $types = array('jpeg' => "\xFF\xD8\xFF", 'gif' => 'GIF', 'png' => "\x89\x50\x4e\x47\x0d\x0a", 'bmp' => 'BM', 'psd' => '8BPS', 'swf' => 'FWS');
    $bytes = fgets($handle, 8);
    $found = 'other';

    foreach ($types as $type => $header) {
        if (strpos($bytes, $header) === 0) {
            $found = $type;
            break;
        }
    }
    fclose($handle);
    return $found;
}

function getStringType($string) {
    $handle = $string;
    if (!$handle)
        throw new Exception('File Open Error');

    $types = array('jpeg' => "\xFF\xD8\xFF", 'gif' => 'GIF', 'png' => "\x89\x50\x4e\x47\x0d\x0a", 'bmp' => 'BM', 'psd' => '8BPS', 'swf' => 'FWS');
    $bytes = fgets($handle, 8);
    $found = 'other';

    foreach ($types as $type => $header) {
        if (strpos($bytes, $header) === 0) {
            $found = $type;
            break;
        }
    }
    fclose($handle);
    return $found;
}


	





class MyConect{
	#conex�o com banco de Dados
		
	var $host; #Qual � o servidor
	var $db;	#Qual � o banco de dados
	var $user;	#Qual � o usu�rio
	var $pass;	#Qual � o password

		function conect($host="",$db="",$user="",$pass=""){
			$this->socket = ociplogon($user,$pass,$host, 'AL32UTF8');
			if ( $this->socket == false ){
				//echo OCIError($this->socket)."<BR>";
				echo "Problemas";
				exit;
			} else {
				//ECHO "Conectado com sucesso.!!!";
				return $this->socket;
			}
		}
		function CloseDB(){
			return $this->CloseData = @oci_close($this->socket);
		}
}

function sql_query($conn,$sql){
  $stmt = ociparse($conn,$sql);
  //ociexecute($stmt,OCI_DEFAULT);
  //return $stmt;  
	if(OCIExecute($stmt)) {
		return $stmt;
	}else{
	    echo '<script>alert("'. OCIError() . '")</script>';
	}
}



  
  


class BarCode
{
	var $valor;					// n�mero do c�digo de barra (valor do c�digo 2of5)
	var $barra_preta;		// arquivo de imagem para barra preta
	var $barra_branca;	// arquivo de imagem para barra branca

	// constantes para o padr�o 2 of 5
	var $fino = 1 ;
	var $largo = 3 ;
	var $altura = 50 ;

	var $html; // privado

	function BarCode($val, $bpreta="../barcode/images/p.png", $bbranca="../barcode/images/b.png", $gerar=false)
	{
		$this->setValor($val);
		$this->setBarraPreta($bpreta);
		$this->setBarraBranca($bbranca);

		if ($gerar) {
			$this->drawBarCode();
		}
	}
	
	function setValor($val)
	{
		$this->valor = $val;
	}
	
	function getValor()
	{
		return $this->valor;
	}
	
	function setBarraPreta($val)
	{
		$this->barra_preta = $val;
	}
	
	function getBarraPreta()
	{
		return $this->barra_preta;
	}
	
	function setBarraBranca($val)
	{
		$this->barra_branca = $val;
	}
	
	function getBarraBranca()
	{
		return $this->barra_branca;
	}
	
	function getHtml()
	{
		return $this->html;
	}
	
	function parseBarCode($draw=false)
	{
	  $barcodes[0] = "00110" ;
  	$barcodes[1] = "10001" ;
	  $barcodes[2] = "01001" ;
	  $barcodes[3] = "11000" ;
	  $barcodes[4] = "00101" ;
	  $barcodes[5] = "10100" ;
	  $barcodes[6] = "01100" ;
	  $barcodes[7] = "00011" ;
	  $barcodes[8] = "10010" ;
	  $barcodes[9] = "01010" ;
  
		for($f1=9;$f1>=0;$f1--) { 
	    for($f2=9;$f2>=0;$f2--){  
  	    $f = ($f1 * 10) + $f2 ;
	      $texto = "" ;
	      for($i=1;$i<6;$i++){ 
  		     $texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
      	}
	      $barcodes[$f] = $texto;
  	  }
	  }
		// guarda inicial
		$this->html = "
		<img src='" . $this->barra_preta . "' width='" . $this->fino . "' height='" . $this->altura . "' border='0'><img 
		src='" . $this->barra_branca . "' width='" . $this->fino . "' height='" . $this->altura . "' border='0'><img 
		src='" . $this->barra_preta . "' width='" . $this->fino . "' height='" . $this->altura . "' border=0><img 
		src='" . $this->barra_branca . "' width='" . $this->fino . "' height='" . $this->altura . "' border=0><img 
		";
		
		$texto = $this->valor ;
		if((strlen($texto) % 2) <> 0){
			$texto = "0" . $texto;
		}

		// Draw dos dados
		while (strlen($texto) > 0) {
		  $i = round($this->_esquerda($texto,2));
		  $texto = $this->_direita($texto,strlen($texto)-2);
		  $f = $barcodes[$i];
		  for($i=1;$i<11;$i+=2){
		    if (substr($f,($i-1),1) == "0") {
		      $f1 = $this->fino ;
		    }else{
		      $f1 = $this->largo ;
		    }

				$this->html .= "src='" . $this->barra_preta . "' width='" . $f1 . "' height='" . $this->altura . "' border='0'><img \n";

	  	  if (substr($f,$i,1) == "0") {
  	  	  $f2 = $this->fino ;
		    }else{
		      $f2 = $this->largo ;
		    }

				$this->html .= "src='" . $this->barra_branca . "' width='" . $f2 . "' height='" . $this->altura . "' border='0'><img \n";
			}
		}

		// Draw guarda final
		$this->html .= "
		src='". $this->barra_preta . "' width='" . $this->largo . "' height='" . $this->altura . "' border='0'><img
		src='". $this->barra_branca . "' width='" . $this->fino . "' height='" . $this->altura . "' border='0'><img
		src='". $this->barra_preta . "' width='1' height='" . $this->altura . "' border=0>
		";

		if ($draw) {
			echo $this->html;
		}
	} // fun��o parseBarCode

	function drawBarCode()
	{
		$this->parseBarCode(true);
	}
	
	// privadas
	function _esquerda($entra,$comp)
	{
		return substr($entra,0,$comp);
	}

	function _direita($entra,$comp)
	{
		return substr($entra,strlen($entra)-$comp,$comp);
	}

} // classe BarCode







function get_certificado_icone($id_solicitacao,$id_situacao,$id_empresa){	
		$permission = verifica_acesso('','visualizar_certificado_maturidade','','');	
		if ($permission == "Acesso Negado"){ 
				$certificado = '';
		}else{
				if ($id_situacao == 5){
					$certificado = '<a onclick="'."parent.openNewAeroWindow('certificado_maturidade_".$id_solicitacao."',80,'center',960,650,'','./php/telas.php?go_to_page=certificado&id_solicitacao=".$id_solicitacao."&id_empresa=".$id_empresa."');".'"  class="title"   title="Certificado de Maturidade|Clique para visualizar e imprimir"  >					
									<img src="../images/graduation-hat.png"  style="cursor:pointer;" '.' >					
									</a>';
				}else{
					$certificado = '';
				}
		}
		return $certificado;		
}

function get_ficha_segmentacao_icone($id_solicitacao,$id_empresa){	
		$permission = verifica_acesso('','ficha_segmentacao','','');	
		if ($permission == "Acesso Negado"){ 
				$text = '';
		}else{
				$text = '<a onclick="'."parent.openNewAeroWindow('questionario1_".$id_solicitacao."',80,'center',1200,screen.height-300,'','./php/telas.php?table=questionario&go_to_page=questionario&id_solicitacao=".$id_solicitacao."&id_tipo_questionario=1&id_empresa=".$id_empresa."');".'" class="title"       title="Ficha Cadastral para Segmenta��o|Clique no �cone para preencher"  >
			<img src="../images/layout_edit.png"  style="cursor:pointer;" '.' >
			</a>';	
		}
		return $text;			
}


function get_questionario_autoavaliacao_icone($id_solicitacao,$id_empresa){	
		$permission = verifica_acesso('','questionario_autoavaliacao','','');	
		if ($permission == "Acesso Negado"){ 
				$text = '';
		}else{
				$text = '<a onclick="'."parent.openNewAeroWindow('questionario2_".$id_solicitacao."',80,'center',1200,650,'','./php/telas.php?table=questionario&go_to_page=questionario&id_solicitacao=".$id_solicitacao."&id_tipo_questionario=2&id_empresa=".$id_empresa."');".'" class="title"       title="Questionario de Autoavalia��o|Clique no �cone para preencher"  >					
					<img src="../images/vcard.png"  style="cursor:pointer;" '.' >					
					</a>';	
		}
		return $text;			
}


function get_checklist_avaliacao_icone($id_solicitacao,$id_empresa){	
		$permission = verifica_acesso('','checklist_avaliacao','','');	
		if ($permission == "Acesso Negado"){ 
				$text = '';
		}else{
				$text = '<a onclick="'."parent.openNewAeroWindow('avaliacao_".$id_solicitacao."',80,'center',960,650,'','./php/telas.php?table=avaliacao&go_to_page=avaliacao&id_solicitacao=".$id_solicitacao."&id_empresa=".$id_empresa."');".'" class="title"       title="Checklist de Avalia��o|Clique no �cone para preencher"  >					
					<img src="../images/page_tick.gif"  style="cursor:pointer;"  >					
					</a>';	
		}
		return $text;			
}

function get_finalizar_solicitacao_icone($id_solicitacao,$id_empresa){	
		$permission = verifica_acesso('','finalizar_solicitacao','','');	
		if ($permission == "Acesso Negado"){ 
				$text = '';
		}else{
				$text = '<a onclick="'."parent.openNewAeroWindow('finalizar_".$id_solicitacao."',80,'center',960,650,'','./php/telas.php?go_to_page=finalizar&id_solicitacao=".$id_solicitacao."&id_empresa=".$id_empresa."');".'"  class="title"   title="Finalizar Solicita��o|Definir N�vel de Maturidade"  >					
					<img src="../images/award_star_bronze_3.png"  style="cursor:pointer;" '.' >					
					</a>';	
		}
		return $text;			
}


function get_andamento_icone($id_solicitacao,$data_inclusao,$data_finalizacao){
		$permission = verifica_acesso('','consultar_andamento_solicitacao','','');	
		if ($permission == "Acesso Negado"){ 
				return $text;		
		}else{
			 $sql_andamento = "SELECT b.nome_usuario,a.data_andamento,c.nome_situacao
				FROM andamentos as a
				LEFT OUTER JOIN usuarios as b ON (a.id_usuario = b.id_usuario)
				INNER JOIN situacoes as c ON (a.id_situacao = c.id_situacao )
				 where a.id_solicitacao = '".$id_solicitacao."'
				 ORDER BY data_andamento desc
				 ";	
			   $result_andamento=return_query($sql_andamento);	
			   $count_andamento = 0;			   	
			   
				$text_andamento .= "<table style='background-color:#eaeff7;border:5px solid #dfe8f6;padding:5px;width:500px;text-align:center'  cellpadding='0' cellspacing='0'>";
				
				$text_andamento .= "<tr ><td colspan='3'><div  style='background-color:#FFFFCC;border:1px solid #ccc;margin-bottom:5px;'><table width='100%'><tr><td>   &nbsp;Iniciado em: <b>".data_br(substr($data_inclusao, 0,10))."</b></td><td>&nbsp;Encerrado em: <b>".data_br(substr($data_finalizacao, 0,10))."</b></td></tr></table></div></td></tr>";
				
				$text_andamento .= "<tr ><td class='fundo2'>Operador</td><td  class='fundo2'>Situa��o</td><td  class='fundo2'>Data Andamento</td></tr>";
				$x = 0;
			   while( $rs_andamento = db_fetch_array($result_andamento) ){	
					$cor = ($x%2 == 0)?'#fff':'#eaeff7';
					$hora = substr($rs_andamento["data_andamento"], 11,5);
					$value = data_br(substr($rs_andamento["data_andamento"], 0,10));
				   $text_andamento .= "<tr style='background-color:".$cor."'><td>".($rs_andamento["nome_usuario"]?$rs_andamento["nome_usuario"]:"-")."</td><td>".$rs_andamento["nome_situacao"]."</td><td>".$value." ".$hora."</td></tr>";
				   $count_andamento++;		
				   if ($x == 0)  $ultimo_adamento = substr($rs_andamento["data_andamento"], 0,10);
				   $primeiro_andamento = substr($rs_andamento["data_andamento"], 0,10);
					$x++;
			   }
				$text_andamento .= "</table>";		
				
				
				if($ultimo_adamento) $text_andamento .= "Da Inclus�o ao �ltimo Andamento: ". subtrai_data(substr($data_inclusao, 0,10),$ultimo_adamento ). " dias";
				
				if($ultimo_adamento) $text_andamento .= "<br>Do �ltimo Andamento at� Hoje: ". subtrai_data($ultimo_adamento,date("Y-m-d")). " dias";
				
				return '<label id="count_'.$id_solicitacao.'"><a href="#" class="title"  title="Andamentos|'.$text_andamento.'" ><img src="../images/user_edit.png" border=0  style="margin:0px 0px 0 2px;"></a>('.$count_andamento.') </label>';	
		}
}


function get_historico_icone($id_solicitacao,$data_inclusao){
	 $sql_historico = "SELECT  id_arquivo, nome_original, id_solicitacao,  ordem,  arquivo,  caminho,  status,  data_inclusao FROM arquivos	
				  WHERE id_solicitacao = '".$id_solicitacao."' 
				  AND status in (1,2,3)				  
				  order by  data_inclusao asc
			 ";	
		   $result_historico=return_query($sql_historico);	
		   $count_historico = 0;			   	
		   
		    $text_historico .= "<table style='background-color:#eaeff7;border:5px solid #dfe8f6;padding:5px;width:800px;text-align:center'  cellpadding='0' cellspacing='0'>";
			
			$text_historico .= "<tr ><td class='fundo2'>Arquivo</td><td class='fundo2'>A��o</td><td class='fundo2'>Tipo</td><td  class='fundo2'>Status</td><td  class='fundo2'>Data Arquivo</td></tr>";
			$x = 0;
		   while( $rs_historico = db_fetch_array($result_historico) ){		
		   	$cor = ($x%2 == 0)?'#fff':'#eaeff7';
				$hora = substr($rs_historico["data_inclusao"], 11,5);
				$value = data_br(substr($rs_historico["data_inclusao"], 0,10));
			   $text_historico .= "<tr style='background-color:".$cor."'><td>".$rs_historico["nome_original"]."</td>";
			   
				if ($rs_historico["status"] == 2){
					 $text_historico .= "<td>Enviado</td><td>Corre��o</td>";		 
				}else{
					 $text_historico .= "<td>Recebido</td><td>Planta</td>";
				}
			   
			    $text_historico .= "<td>".get_status($rs_historico["status"])."</td><td>".$value." ".$hora."</td></tr>";
				
			   if ($x == 0) $primeiro_historico = substr($rs_historico["data_inclusao"], 0,10);
			   $ultimo_historico = substr($rs_historico["data_inclusao"], 0,10);			   
			   $count_historico++;
			   $x++;
		   }
			$text_historico .= "</table>";		
			
			if($ultimo_historico) $text_historico .= "Do �ltimo Arquivo at� Hoje: ". subtrai_data($ultimo_historico,date("Y-m-d")). " dias";
			
			return '<a href="#" class="title"  title="Hist�rico|'.$text_historico.'" ><img src="../images/application_cascade.png" border=0  style="margin:0px 0px 0 2px;"></a>('.$count_historico.')';			
}

function relatorio_header($brasao){
	$connect = new InfoSystem;
	$brasao = ($brasao)?$brasao:"../images/brasao.jpg";
echo'	  
  <table style="width:100%;font-family:Verdana, Geneva, sans-serif;" cellpadding="0" cellspacing="0" >		
  <tr >
  <td style="width:38px" rowspan="3" >			
  <img src="'.$brasao.'" align="left" border="0"> 
  </td>
  <td colspan="3" style="border-bottom:2px solid #15428B;">
  <b style="font-size:14px;"> '.InfoSystem::titulo.' </b>
  <b style="font-size:10px;">&nbsp; </b><br>
  <b style="font-size:10px;color:#006600;">'.InfoSystem::subtitulo.' </b><br>	
		
  </td> 
  </tr>	
  <tr >
  <td style="font-family:Verdana, Geneva, sans-serif;font-size:10px">Relat�rio Emitido em '.date("d/m/Y").' as '.date("H").'h'.date("i").'min
  </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
';
}

function __limpaString($texto){
        $aFind = array('&','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�',' ','/');
        $aSubs = array('e','a','a','a','a','e','e','i','o','o','o','u','u','c','A','A','A','A','E','E','I','O','O','O','U','U','C','','-');
        $novoTexto = str_replace($aFind,$aSubs,$texto);
        $novoTexto = preg_replace("/[^a-zA-Z0-9 @,-.;:]/", "", $novoTexto);
        return $novoTexto;
    }//fim __limpaString



function get_table_foreign_key($table,$campo){		// return table e campo da foreig key
	if (DBConnect::database=="mysql"){    //Mysql	
		$sql_fk = "SELECT 
			 table_name, column_name, 
			 referenced_table_name, referenced_column_name
			FROM
			 information_schema.key_column_usage
			WHERE
			 referenced_table_name IS NOT NULL AND table_name = '".$table."'  AND column_name = '".$campo."'  AND CONSTRAINT_SCHEMA = DATABASE()   LIMIT 1 ;";		
	}
			 
			 
	if (DBConnect::database=="postgresql"){    //PostgreSQL
		$sql_fk = "SELECT
					  tc.constraint_name, tc.table_name, kcu.column_name, 
					  ccu.table_name AS foreign_table_name,
					  ccu.column_name AS foreign_column_name 
				  FROM 
					  information_schema.table_constraints AS tc 
					  JOIN information_schema.key_column_usage AS kcu ON tc.constraint_name = kcu.constraint_name
					  JOIN information_schema.constraint_column_usage AS ccu ON ccu.constraint_name = tc.constraint_name
				  WHERE constraint_type = 'FOREIGN KEY' AND tc.table_name='".$table."'  AND kcu.column_name='".$campo."' LIMIT 1;";				  
	}
	
	
	if(numrows($sql_fk)>0){					
			$rs_fk = get_record($sql_fk);		
			if (DBConnect::database=="mysql"){    //Mysql	
					  $sql = "describe ".$rs_fk["referenced_table_name"];
					  $result = return_query($sql);
					  $x=0;
					  while( $rs = db_fetch_array($result) ){	
							  if ($x==1) 	{
								  return $rs_fk["referenced_table_name"]."|".$rs["Field"]."|".$rs_fk["referenced_column_name"];;
								  exit();
							  }
							  $x++;
					  }
			}
			if (DBConnect::database=="postgresql"){    //PostgreSQL			
					  $sql = "select column_name from INFORMATION_SCHEMA.COLUMNS where table_name = '".$rs_fk["foreign_table_name"]."'; ";				
					  if (numrows($sql)>0){						  		
							  $result = return_query($sql);		
							  $x=0;
							  while( $rs = db_fetch_array($result) ){	
								  if ($x==1) 	{
									  return $rs_fk["foreign_table_name"]."|".$rs["column_name"]."|".$rs_fk["foreign_column_name"];
									  exit();
								  }
								  $x++;
							  } 			
					  }else{
						  return '';
					  }
			}			
	}else{
		return "";	
	}
}

	function add_sql_combo_box_foreign_key($table,$campo){		
		  //////////////////////////////////////////////////////////////////////////////
		  ///////////////////////// sql add em form combobox  /////////////////
		  /////////////////////////////////////////////////////////////////////////////////
		  $xml= simplexml_load_file("../xml/form_add_sql_combobox_field.xml");
		  foreach($xml as $field){		
			  if  ((string)$field->children() == $table){ //verifica se tabelea tem campo form em xml			
					foreach($field->children() as $child){
							if ( (string)$child->getName() == $campo){ // pega campos do form que ser�o escondidos	
									return trim((string)$child);
							}
					}
			  }
		  }
		  //////////////////////////////////////////////////////////////////////////////	
		return "";
	}


function get_combo_foreign_key($table,$campo,$value){	


	if (DBConnect::database=="postgresql"){    //PostgreSQL
		$sql_fk = "SELECT
					  tc.constraint_name, tc.table_name, kcu.column_name, 
					  ccu.table_name AS foreign_table_name,
					  ccu.column_name AS foreign_column_name 
				  FROM 
					  information_schema.table_constraints AS tc 
					  JOIN information_schema.key_column_usage AS kcu ON tc.constraint_name = kcu.constraint_name
					  JOIN information_schema.constraint_column_usage AS ccu ON ccu.constraint_name = tc.constraint_name
				  WHERE constraint_type = 'FOREIGN KEY' AND tc.table_name='".$table."'  AND kcu.column_name='".$campo."' LIMIT 1;";
				  
		if (numrows($sql_fk) >= 1) {	//existe foreigh key
				$rs_fk = get_record($sql_fk);		
				$sql_data_cancelamento = "SELECT column_name
											FROM information_schema.columns
											WHERE table_schema = 'public'
											  AND table_name   = '".$rs_fk["foreign_table_name"]."'
											  AND column_name = 'data_cancelamento'"; 
				if(get_record($sql_data_cancelamento)) $add_field_data_cancelamento = " WHERE data_cancelamento IS NULL ";		
				$sql = "select *  from ".$rs_fk["foreign_table_name"]." ".$add_field_data_cancelamento;	
		
				/// personaliza��o de combobox ///////////				
				$add_sql = add_sql_combo_box_foreign_key($table,$campo);
				if ($add_sql){	
					if (stristr($sql,"where") == ""){
						$sql .= " WHERE  ".$add_sql;	
					}else{
						$sql .= " AND ". $add_sql;	
					}		
				}
				//////////////////////////////////////////
				
				$sql .=  " ORDER BY 2 ";
				//exit($sql);
				if (numrows($sql)>0){
						$result = return_query($sql);						
						$cells_conteudo .= '<select name="'.$campo.'"  class="x-form-text x-form-field"   >';
						$cells_conteudo .= '<option value="">selecione</option>';
						while( $rs = db_fetch_array($result) ){								
							$cells_conteudo .= "<option value=\"".$rs[$rs_fk["foreign_column_name"]]."\" ";
							if ($value == $rs[$rs_fk["foreign_column_name"]]) $cells_conteudo .= "selected";						
							$cells_conteudo .= " >".((strlen($rs[1])>85)? substr($rs[1],0,85)."...":$rs[1])."</option>\n";
						} 						
						$cells_conteudo .= '</select>';
				}else{
					$cells_conteudo .= '<span style="color:#f00;font-weight:bold;">N�o h� registro cadastrado</span>';
				}
				return $cells_conteudo;
		}else{
			return "";	
		}
				  
				  
				  
				  
	}
	if (DBConnect::database=="mysql"){    //Mysql			
		$sql_fk = "SELECT 
				 table_name, column_name, 
				 referenced_table_name, referenced_column_name
				FROM
				 information_schema.key_column_usage
				WHERE
				 referenced_table_name IS NOT NULL AND table_name = '".$table."'  AND column_name = '".$campo."'  AND CONSTRAINT_SCHEMA = DATABASE()  LIMIT 1 ;";			 
				// exit($sql_fk);	
		if($rs_fk = get_record($sql_fk)){	
				$sql_data_cancelamento = "SHOW COLUMNS FROM ".$rs_fk["referenced_table_name"]." WHERE field = 'data_cancelamento'"; 
				if(get_record($sql_data_cancelamento)) $add_field_data_cancelamento = " WHERE data_cancelamento IS NULL ";		
				$sql = "select *  from ".$rs_fk["referenced_table_name"]." ".$add_field_data_cancelamento;					
				
				/// personaliza��o de combobox ///////////				
				$add_sql = add_sql_combo_box_foreign_key($table,$campo);
				if ($add_sql){	
					if (stristr($sql,"where") == ""){
						$sql .= " WHERE  ".$add_sql;	
					}else{
						$sql .= " AND ". $add_sql;	
					}		
				}
				//////////////////////////////////////////
				
				$sql .=  " ORDER BY 2 ";			
				
				//exit($sql);
				if (numrows($sql)>0){
						$result = return_query($sql);
						$cells_conteudo .= '<select name="'.$campo.'"  class="x-form-text x-form-field"   >';
						$cells_conteudo .= '<option value="">selecione</option>';
						while( $rs = db_fetch_array($result) ){				
							$cells_conteudo .= "<option value=\"".$rs[$rs_fk["referenced_column_name"]]."\" ";
							if ($value == $rs[$rs_fk["referenced_column_name"]]) $cells_conteudo .= "selected";						
							$cells_conteudo .= " >".((strlen($rs[1])>85)? substr($rs[1],0,85)."...":$rs[1])."</option>\n";
						} 						
						$cells_conteudo .= '</select>';
				}else{
					$cells_conteudo .= '<span style="color:#f00;font-weight:bold;">N�o h� registro cadastrado</span>';
				}
				return $cells_conteudo;
		}else{
			return "";	
		}
	}
}

function get_value_foreign_key($table,$campo,$value){	
	if (DBConnect::database=="mysql"){    //Mysql	
		$sql_fk = "SELECT 
			 table_name, column_name, 
			 referenced_table_name AS foreign_table_name, referenced_column_name AS foreign_column_name
			FROM
			 information_schema.key_column_usage
			WHERE
			 referenced_table_name IS NOT NULL AND table_name = '".$table."'  AND column_name = '".$campo."'  AND CONSTRAINT_SCHEMA = DATABASE()   LIMIT 1 ;";		
	}
			 
			 
	if (DBConnect::database=="postgresql"){    //PostgreSQL
		$sql_fk = "SELECT
					  tc.constraint_name, tc.table_name, kcu.column_name, 
					  ccu.table_name AS foreign_table_name,
					  ccu.column_name AS foreign_column_name 
				  FROM 
					  information_schema.table_constraints AS tc 
					  JOIN information_schema.key_column_usage AS kcu ON tc.constraint_name = kcu.constraint_name
					  JOIN information_schema.constraint_column_usage AS ccu ON ccu.constraint_name = tc.constraint_name
				  WHERE constraint_type = 'FOREIGN KEY' AND tc.table_name='".$table."'  AND kcu.column_name='".$campo."' LIMIT 1;";
	}
			 
			
	if(numrows($sql_fk)>0){				
			$rs_fk = get_record($sql_fk);		
			$sql = "select *  from ".$rs_fk["foreign_table_name"];				
			if (numrows($sql)>0){
					$result = return_query($sql);					
					while( $rs = db_fetch_array($result) ){							
						if (trim($value) == $rs[$rs_fk["foreign_column_name"]])	{							
							return $rs[1];
							exit();
						}
					} 			
			}else{
				return '';
			}			
	}else{
		return "";	
	}
}

// retorna o proximo id do item do checklist
function get_proximo_id_item_checklist($id_checklist) {
	$sql = "
		SELECT id_item_checklist
		FROM itens_checklist
		WHERE id_checklist = ".$id_checklist."
		ORDER BY id_item_checklist DESC
	";
	$proximo_id = 1;
	$resultado = return_query($sql);
	if ($registro = db_fetch_object($resultado)) {
		$proximo_id = (int)$registro->id_item_checklist + 1;
	}
	
	return $proximo_id;
}


// verifica se tem anexo no item do checklist / solicitacao informado
// retorna boolean
function verificar_anexos($id_solicitacao, $id_checklist, $id_item_checklist) {
	$resultado = false;
	$sql = "
		SELECT id_anexo_avaliacao
		FROM anexos_avaliacao
		WHERE 
			id_solicitacao = ".$id_solicitacao." 
			AND id_checklist = ".$id_checklist." 
			AND id_item_checklist = ".$id_item_checklist." 
	";
	if (numrows($sql) >= 1) {
		$resultado = true;
	}
	
	return $resultado;
}

// verifica se tem anexo no item do checklist / solicitacao informado
// retorna boolean
function verificar_pendencias($id_solicitacao, $id_checklist, $id_item_checklist) {
	$resultado = false;
	$sql = "
		SELECT id_pendencia_avaliacao
		FROM pendencias_avaliacao
		WHERE 
			id_solicitacao = ".$id_solicitacao." 
			AND id_checklist = ".$id_checklist." 
			AND id_item_checklist = ".$id_item_checklist." 
	";
	if (numrows($sql) >= 1) {
		$resultado = true;
	}
	
	return $resultado;
}

function youtube_embed($embed,$width,$height){
	return '
		  <object type="application/x-shockwave-flash" style="width:'.$width.';height:'.$height.';" data="https://www.youtube.com/v/'.$embed.'"  >
								  <param name="movie" value="https://www.youtube.com/v/'.$embed.'" />
								  </param>
								  <param name="wmode" value="transparent">
								  </param>
								  <embed src="https://www.youtube.com/v/'.$embed.'" type="application/x-shockwave-flash" wmode="transparent" width="'.$width.'" height="'.$height.'" ></embed>
		  </object>
	';
}


function get_atendentes_combo($id_atendente = 1){            
    $sql = "SELECT id_atendente AS id, nome_atendente AS nome 
        FROM atendentes
        ORDER BY nome_atendente";
    if (numrows($sql)>0){
            $result = return_query($sql);
            $cells_conteudo .= '<option value="0">selecione</option>';
            while( $rs = db_fetch_array($result) ){                
                $cells_conteudo .= "<option value=\"".$rs['id']."\" ";
                if ($id_atendente == $rs['id']) $cells_conteudo .= "selected";
                $cells_conteudo .= " >".$rs['nome']."</option>\n";
            }             
    }else{
        $cells_conteudo .= '';
    }
    return $cells_conteudo;
    exit();
}


function setColorBarNameChart($nro_opcao){
	switch (strtolower($nro_opcao)){
		case 'inspira��es':  //verde
		 $cor = '0x63c14a';
		 break;		 
		case 'execu��o':  //AZUL
		 $cor = '0x0095e0';
		 break;		 
		case 'plus':  //Pink
		 $cor = '0x33FFFF';
		 break;
		case 'propostas': //amarelo
		 $cor = '0xfcd429';
		 break;
		case 'regular': //laranja
		 $cor = '0xFF9900';
		 break;
		case 'vota��o'://vermelho
		  $cor = '0xea2d2c';				
		  break;
		case 'N�o se Aplica': 
		  $cor = '0xD0D1D7';		//Marrom
		  break;
		default:
		 $cor = '0xD0D1D7';
		 break;				
	}	
	return $cor;
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
			$participante["avatar"] = "publico/images/avatar.jpg";	
		}
		
		$participante["nome"] = $rs["nome_participante"];
		
		$participante["email"] = $rs["email"];
		$participante["moderador"] = $rs["moderador"];
		
		
		return $participante;
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


function max_visualizacao($id_fase,$id_desafio){
	
	if (!$id_desafio) return 0;
	if (!$id_fase) return 0;
  $sql = "
SELECT COUNT(*) AS soma
FROM visualizacoes AS a
INNER JOIN contribuicoes AS b ON (b.id_contribuicao = a.id_contribuicao AND id_desafio = '".$id_desafio."' AND id_fase = '".$id_fase."' AND b.data_cancelamento is NULL)
GROUP BY a.id_contribuicao
ORDER BY soma DESC
LIMIT 1
		";  
//exit($sql);
  $rs = get_record($sql);
  return  $rs["soma"];
}

?>

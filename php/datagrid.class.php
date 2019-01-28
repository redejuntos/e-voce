<?PHP
include("./class_relationship_restrition.php");//define os relacionamentos das tabelas
class datagrid extends relationship_restrition{
	var $hide_field             = array();
	var $rename_field           = array();
	var $sql;
	var $th_style;
	var $tr_style;
	var $col_style;
	var $html;	
	var $cell_others           = array(); // passa informações adicionais nas células da table
	var $titulo; //titulo da tabela
	var $id_tipo;  //modalidade / tipo
	var $order; //campo da tabela pelo qual será ordenado na listagem
	var $table;
	var $primary_key;
	var $foreign_key           = array();
	
	function InsertLinks ( $Text,$id ) {		   
	   if ($id=="hiperlink"){	
  	 	   $NotAnchor = '(?<!"|href=|href\s=\s|href=\s|href\s=)';
		   $Protocol = '(http|ftp|https):\/\/';
		   $Domain = '[\w]+(.[\w]+)';
		   $Subdir = '([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?';
		   $Expr = '/' . $NotAnchor . $Protocol . $Domain . $Subdir . '/i';
		   $Result_rep = preg_replace( $Expr, "<a href=\"$0\" title=\"$0\" target=\"_blank\">$0</a>", $Text );
		   $NotHTTP = '(?<!:\/\/)';
		   $Domain = 'www(.[\w]+)';
		   $Subdir = '([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?';
		   $Expr = '/' . $NotAnchor . $NotHTTP . $Domain . $Subdir . '/i';   return preg_replace( $Expr, "<a href=\"http://$0\" title=\"http://$0\" target=\"_blank\">$0</a>", $Result_rep );		   
	   	   	return $Text;
		}else{
	   		return $Text;
	   }
	}
    
	function SQL($s) {
        $this->sql = $s;
    }
    function col_style($col,$style) {
        $this->col_style[$col] = $style;
    }
    function th_style($st) {
        $this->th_style = $st;
    }
    function tr_style($tr) {
        $this->tr_style = $tr;
    }
    function HideField($field) {
        $cur = count($this->hide_field);
        $this->hide_field[$cur] = trim($field);				
		//echo $this->hide_field[$cur] ;
    }
    function RenameCol($oldname,$newname) {
        $this->rename_field[$oldname] = trim($newname);
    }	
	
	function create_grid(){
		global $sql_order;
		global $cols_number;		
		
		//MYSQL_CONNECT($this->server, $this->user, $this->password) or die ( "&lt;H3&gt;Usuário ou senha invalidos&lt;/H3&gt;");
		//MYSQL_SELECT_DB($this->database) or die ( "<h3>Não foi possivel conectar ao banco de dados</h3>");
		//$connect = new define_db_connect;
     	//$connect -> databaseconnect();
		
		$type      = $_GET["type"];		
		$order_tbl = $_GET["order_tbl"];		
		if($type == "ASC"){
			$sql_order = " ORDER BY " . $order_tbl . " " . "ASC";
			$type = "DESC";			
		} elseif($type == "DESC"){
			$sql_order = " ORDER BY " . $order_tbl . " " . "DESC";
			$type = "ASC";
		}		
		//exit($this->sql.$sql_order);		
		
		//paginacao -------------------------------
		if ($_SESSION["max_res"]==""){
			$max_res = 10; // máximo de resultados à serem exibidos por tela ou pagina
		}else{
			$max_res=$_SESSION["max_res"];
		}		
		
		
		
		if ($_GET["curpage"]){
			$curpage=$_GET["curpage"];
		}else{
			$curpage=1;// pagina atual
		}				
		
		
		
		$inicio_pesq=(intval($curpage-1)*$max_res);				
		//$total_resultados=mysql_num_rows(mysql_query($this->sql.$sql_order));			
		$total_resultados=numrows($this->sql.$sql_order);
		
		$page_number=floor($total_resultados/$max_res);// total de paginas
		if ((abs($total_resultados%$max_res))>0){$page_number++;}	

		if (!$_GET["type"]){
			if (DBConnect::database=="postgresql")
				$this->sql .= " LIMIT $max_res OFFSET $inicio_pesq";			
			if (DBConnect::database=="mysql")	
				$this->sql .= " LIMIT $inicio_pesq, $max_res";			
		}else{			
			if (DBConnect::database=="postgresql")
				$sql_order .=  " LIMIT $max_res OFFSET $inicio_pesq";		
			if (DBConnect::database=="mysql")	
				$sql_order .= " LIMIT $inicio_pesq, $max_res";
		}
		$result = return_query( $this->sql.$sql_order);	
		//echo $this->sql;
		
		//paginacao -------------------------------		
		//$number = numrows($this->sql.$sql_order);		
		
		$this->html .= "<TABLE  id='tabela' BORDER=\"1\" CELLPADDING=\"2\" CELLSPACING=\"0\"  STYLE=\"border-collapse: collapse;border:#dddddd thin 1px;width:".$_SESSION["tamanho_grid"].";overflow:scroll;\">\n";		
		$this->html .= "<tr>\n";
	 
		//------ colocar coluna a mais antes da tabela--------
		
		$this->html .= '<th nowrap>'."<a href=".$_SESSION["PHP_SELF"]."?titulo=".urlencode($this -> titulo)."&id_tipo=".$this -> id_tipo."&table=".$_GET["table"]."&order=".$this -> order.">".'<img src="../images/recycle.gif" title="Atualizar" width="16" height="16" style=\"text-decoration:none;border:0;\"></a>'."</th>";						
		$this->html .= $this -> create_cols_header();
		//----------------------------------------------------
		
		if($type==""){$type="ASC";}		
		$cols_number=0;
		while ($field=db_fetch_field($result)) {		
		

			if ($field->multiple_key == 1) $this -> foreign_key[] = trim($field -> name);
			
			if($field -> primary_key == 1) $unique_field = $field -> name;
			elseif($field -> unique_key == 1) $unique_field = $field -> name;			
			$feld = strtolower($field->name);	
			
			//if (empty($unique_field)){ // sempre pega a chave primaria passada pelo xml
				$unique_field = $this->primary_key;
			//} 			

			if(!in_array($feld, $this->hide_field)){
				$cols_number++;
				$fields_value_str.= $field->name .",";//string com os campos da tabela
			
				if(!empty($this->rename_field[$feld])) $feld = $this->rename_field[$feld]; 				
				$this->html .= "<th bgcolor=\"#d7e5f5\" id=col".$cols_number." title=\""."ordenar por ".$type."\" style=\"".$this->tamanho_coluna($feld).$this->th_style."\" nowrap onclick=\"javascript:location.href='$PHP_SELF?shop_id=$shop_id&table=".$_GET["table"]."&order=".$this -> order."&order_tbl=".urldecode($field->name)."&type=".$type."&titulo=".$this -> titulo."&id_tipo=".$this -> id_tipo."';\">".$feld;		
				
				if ( ($_GET["order_tbl"] == $field->name) && ($_GET["type"] == "ASC") ){
				$this->html .= "&nbsp;<img style='text-decoration:none;border:0px;' src='../images/ardown.gif'>";
				}else{			
				$this->html .= "&nbsp;<img style='text-decoration:none;border:0px;' src='../images/arup.gif'>";
				}				
				$this->html .= "</th></a>";
			}
		}
		
		$this->html .= "</tr>";
		$x=0;				

		while($row  =  db_fetch_array($result))  {
			if($color == "#ffffff") $color = "#eaeaf0"; else $color = "#ffffff";
			$this->html .= "<tr id='linha".$row[0]."'  bgcolor=\"$color\">";
			
			//------ colocar coluna a mais com botao deletar antes da tabela--------										
					$this->html .= $this -> create_button_delete($this->database,$this->table,$id,$unique_field,$style,$color,$row[0],$row[1],$row,$this -> titulo,$this -> order,$this->primary_key);				
					
			//------ botoes adicionais --------	
					if($this -> in_button_extends() ){ //se possuir botoes adicionais							
						//$this->html .= $this -> create_button_extends($row[0],$this->database,$this->table,$id,$unique_field,$style,$color);
							$this->html .= $this -> create_button_extends($row[0],$row[1],$this->database,$this->table,$id,$unique_field,$style,$color,$row);	
					}else{  //senão					
					//	$this->html .= "<td bgcolor=\"$color\" wrap>&nbsp;</td>";
						$this->html .= "<td wrap>&nbsp;</td>";
					}
	   	//----------------------------------------------------
					
		//	$id = db_result($result, $x, $unique_field); //comentado em 15/02/2013			
			$id = $row[$this->primary_key]; //alterado em 15/02/2013
			$x++;
			
			
			$this->cell_others = array();
			for($i=0;  $i < db_num_fields($result);  $i++)  {
				//$str   = db_fetch_field($result,$i);	
        		$fieldname = db_field_name($result, $i);      
	
				if(!in_array($fieldname, $this->hide_field)){
					$style = $this->col_style[$fieldname];
					$value = trim($row[$i]);					
					// conteudo dentro das células da tabela					
					//if(strlen($value)==0) $value = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";			
					$this->cell_others[$fieldname] = $row[$i];	
				
				//	if (   strlen(array_search($fieldname,$this -> foreign_key))>0   ){	 // verifica se campo é foreign key						
						//$this->html .= "<td >".get_value_foreign_key($_GET["table"],$fieldname,$value)."</td>\n";						
						
				//	}else{
						$this->html .= $this -> create_cells_conteudo($this->database,$this->table,$fieldname,$id,$unique_field,$style,$color,$value,$this->cell_others);
				//	}
				}else{
					$this -> create_cell_others($fieldname,trim($row[$i]));
				}
			}            
			$this->html .= "</tr>\n";
		}		
		
		// incluir um registro-----------------------------------------------
		$fields_value_str=substr($fields_value_str,0,strrpos($fields_value_str,","));		
		$fields_value_vetor=split(",",$fields_value_str);// transforma em vetor os campos da tabela		
		
		$this->html .= "<tr>";		
		$this->html .= "<td style=\" width:16px;height:16px;background-color:#F4F4FF;\" nowrap>";	
		
		//------ botao adicionar new line --------	
		$this->html .= $this -> create_button_add_new_line($cols_number);					
		//----------------------------------------------------					
		
		$this->html .= "</td><td style=\" width:16px;height:16px;background-color:#F4F4FF;\" nowrap>"."<a style=\"display:none;\" id=\"display_save\"
		
		href=\"javascript:save_one_field('".$this->link_save_one_field($fields_value_vetor[0])."','".$this -> titulo."');\">".
		
		'<img src="../images/savenew.gif" title="Salvar" width="16" height="16" style=\"text-decoration:none;border:0;\"></a>'."</td>";		
		//--
		
		for ($x=0 ; $x < count($fields_value_vetor) ; $x++)
				$this->html .=  $this ->create_add_cells($fields_value_vetor[$x],$x);
	
		
		$this->html .=  "</tr></table>";
		// ---------------------------------------------
		
		
		
		// paginacao-----------------------------------------------
		$this->html .= "<TABLE width=100% BORDER=\"0\" CELLPADDING=\"2\" CELLSPACING=\"0\" bgcolor=\"#ffffff\" STYLE=\"width:";
		

		
		$this->html .= "px;font-size:14px;\">\n";
		
//Primeira página
if ($curpage > 1){
  $this->html .= "<tr><td align='left'><a href='".$PHP_SELF."?titulo=".$this -> titulo."&curpage=1&table=".$_GET["table"]."&order=".$this -> order."&id_tipo=".$this -> id_tipo."' title='Primeira página'><FONT color=#0000FF><< Primeira</FONT></a></td>";
  
  
  
}else{
	$this->html .= "<tr><td align='left'><FONT color=silver><< Primeira</FONT></td>";
}
		
//Página anterior
if ($curpage > 1){
	  $this->html .= "<td align='center'><a href='".$PHP_SELF."?titulo=".$this -> titulo."&curpage=".($curpage-1)."&table=".$_GET["table"]."&order=".$this -> order."&id_tipo=".$this -> id_tipo."' title='Página anterior'><FONT color=#0000FF><< Anterior</font></a>  <strong>(</strong> "; 
}else{
	$this->html .= "<td align='center'><FONT color=silver><< Anterior</font>  <strong>(</strong> ";
}
		
	   
	 for ($x = $curpage - 4; $x <= $curpage + 4; $x++) {	
	 
		if ( ($x >= 1) && ($x <= $page_number) ){
			$link_page = "<a href='".$PHP_SELF."?titulo=".$this -> titulo."&curpage=".$x."&table=".$_GET["table"]."&order=".$this -> order."&id_tipo=".$this -> id_tipo."'>";	
			
			if ($x == $curpage){		
				$this->html .= "<strong style='color=#000000;'>".$x."</strong>"."&nbsp;";
			}elseif ( ($x == $curpage+4)&&($x < $page_number) ){
				$this->html .= $link_page.$x."...&nbsp;";
			}elseif ( ($x == $curpage-4)&&($x > 1) ){
				$this->html .= $link_page."...&nbsp;".$x."&nbsp;";
			}else{
				$this->html .= $link_page.$x."&nbsp;";
			}									
			
			
			$this->html .= "</a>";		
		}
	 }
		
//Próxima página
if ($curpage < $page_number){
	  $this->html .= "<strong>)</strong> <a href='".$PHP_SELF."?titulo=".$this -> titulo."&curpage=".($curpage+1)."&table=".$_GET["table"]."&order=".$this -> order."&id_tipo=".$this -> id_tipo."' title='Próxima página'><FONT color=#0000FF>Próxima >></font></a>"; 
}else{
	$this->html .= "<strong>)</strong> <FONT color=silver>Próxima >></font>";
}

//Última página
$this->html .= "</td><td align='right'>";
if ($curpage < $page_number){
	  $this->html .= "<a href='".$PHP_SELF."?titulo=".$this -> titulo."&curpage=".$page_number."&table=".$_GET["table"]."&order=".$this -> order."&id_tipo=".$this -> id_tipo."' title='Última página'><FONT color=#0000FF>Última >></font></a>"; 
}else{
	$this->html .= "<FONT color=silver>Última >></font>";
}
$this->html .= "</td></tr>\n";


		
		
		
		if (abs($inicio_pesq+$max_res) < $total_resultados){
		$fim_pesq=abs($inicio_pesq+$max_res);
		}else{
		$fim_pesq=$total_resultados;
		}		
		$this->html .=  "</table>";
	//	$this->html .="<br />Resultados ".abs($inicio_pesq+1)." - ".$fim_pesq." de ".$total_resultados;
		//$this->html .="<br />page_number = ".$page_number;
		//$this->html .="<br />page_atual = ".$curpage;
		
		if ($total_resultados == 0){
		$resultados .="<strong>Resultados: <font color=#0000ff>".abs($inicio_pesq)." - ".$fim_pesq." de ".$total_resultados."</font></strong>";
		}else{		
		$resultados .="<strong>Resultados: <font color=#0000ff>".abs($inicio_pesq+1)." - ".$fim_pesq." de ".$total_resultados."</font></strong>";
		}
		
		//paginacao -------------------------------
		
		
		
		
		$this->html .=  '<input type="hidden" name="fields_value" value="'.$fields_value_str.'">';		
		$this->html .=  "\n<iframe frameborder=\"0\" NAME=\"grid_iframe\" WIDTH=\"1\" HEIGHT=\"1\" style=\"display:none;\">No Inlineframes</iframe>\n";  
		$this->html .=  "\n<script>mostra_resultados('$resultados');</script>\n";  
		return $this->html;
	}
}
?>

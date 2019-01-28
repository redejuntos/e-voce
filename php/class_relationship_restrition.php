<?


class relationship_restrition {	

	function link_save_one_field ($campo_type){				
		switch ($_SESSION["table"]){	
			case 't_licitacoes_type':
				$titulo_str=$_SESSION["order"]."&button_extends=yes"; 
				break;					
			default:
				$titulo_str=$_SESSION["order"];
				break;		
		}		
		
		return $titulo_str;
	}

	
	function in_button_extends(){						
		if ($_SESSION["button_extends"]=="yes"){		
			$value=1;
		}else{
			$value=0;
		}		
		return $value;
	}

	
	function in_table($table){					
		switch ($_SESSION["table"]){	
			case $table:
				$value=1;
				break;					
			default:
				$value=0;
				break;		
		}		
		return $value;
	}
	

	function in_table_package($table_select){					
		switch ($_SESSION["table_select"]){	
			case $table_select:
				$this->value=1;
				break;					
			default:
				$this->value=0;
				break;		
		}		
		return $this->value;
	}
	
	function admin_area_permission(){						
		//if ($_SESSION["level_permission_session"]>=50){		
			$this->value=1;
		//}else{
		//	$this->value=0;
		//}		
		return $this->value;
	}
	
	function admin_restrict_manager(){						
		//if ($_SESSION["level_permission_session"]<=10){		
		//	$this->value=1;
		//}else{
			$this->value=0;
		//}		
		return $this->value;
	}
	


	
	function tamanho_coluna($campo){				
		switch ($campo){	
			case 'Descrição':
				$style="width: 300px;word-wrap:break-word;";
				break;	
			case 'nome_situacao':
				$style="width: 200px;";
				break;	
			case 'nome_documento':
				$style="width: 200px;";
				break;
			case 'nome_checklist':
				$style="width: 200px;";
				break;			
			case 'sql':
				$style="width: 250px;";
				break;	
			case 'dados':
				$style="width: 100px;";
				break;	
			case 'cep':
				$style="width: 60px;";
				break;					
			case 'sql_text':
				$style="width: 300px;";
				break;	
			case 'Empresa':
				$style="width: 200px;";
				break;			
			default:				
				break;		
		}				
		return $style;
	}

	

	
	function combo_box($n_row,$cod,$campo,$tabela,$tamanho,$nome){			
			$exec_sql=return_query("select ".$cod.",".$campo." from ".$tabela." order by ".$campo);							
			$this->value = '<td ><select class="input" id="imput_width'.$n_row.'" 			style="display:none;width:'.$tamanho.'px;" name="'.$nome.'">';
			while ($rs=mysql_fetch_array($exec_sql)){
				$this->value .= '<option value="'.$rs[0].'">'.$rs[1].'</option>';
			}
			$this->value .= '</select> </td>';		
			
		return $this->value;
	}
	
	
	function create_cols_header(){
	
		switch ($_SESSION["table"]){				
			case "solicitacoes":
				$cols_header .= "<th  style=\" width:16px;height:16px;text-align:left  ".$this->th_style."\" nowrap>".'<img    width="16" height="16" src="../images/busca.gif"'. "onclick=\"parent.openAeroWindow('filtro_consulta_form',80,'center',500,220,'','./php/telas.php?table=relatorios&amp;go_to_page=filtro_consulta');\"> "."</th>";	
			break;	
			default:
				$cols_header .= "<th  style=\" width:16px;height:16px;  ".$this->th_style."\" nowrap>".'<img    width="16" height="16" src="../images/blank.gif" > '."</th>";	
			break;		
		}			
			return $cols_header;
	}
	
	//function create_button_extends($row,$database,$table,$id,$unique_field,$style,$color){
	function create_button_extends($row,$row2,$database,$table,$id,$unique_field,$style,$color,$cell_others){			
		

		
		
		$menu_vetor = verifica_acesso('','',1,'');
		
		for($w=0;$w<count($_SESSION["menu_item"]["item"]);$w++){
		  $aux = $_SESSION["menu_item"]["item"][$w];		
		  for($x=0;$x<count($_SESSION["menu_item"][retirar_acentos($aux)]["titulo"]);$x++){
			  if ($_SESSION["menu_item"][retirar_acentos($aux)]["permission"][$x] == $table){	
				  /////// ############# Verifica Permissão de Usuário ##############
				  $permission = verifica_acesso($table,'','',2);
				  /////// ##########################################################
			  }	
		  }	
		}	
	
	//bota oconsultar
	//  <img src="../images/b_search.png"  style="cursor:pointer;" '."  onclick=\"parent.openAeroWindow('incluir_solicitacoes".$row."',80,'center',1200,650,'','./php/telas.php?table=solicitacoes&go_to_page=solicitacoes&id_solicitacao=".$row."');\"" . 'border=0 title="alterar">
		
	if($this -> in_table('solicitacoes')){			
	
		/////// ############# Verifica Permissão de Usuário ##############
		if ($permission == "Acesso Negado")
			return "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>&nbsp;</td>\n";
			
		/////// ##########################################################
	
	
	
		$botoes = "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>";					
		$botoes .= "
		 		 <div style=\"float:left;\" nowrap >
                 	<span  id=\"".$unique_field.",$id,".$name .",$table,$database\">" . '					
					
						'.get_ficha_segmentacao_icone($row,$cell_others["id_empresa"]).'
						
						
						'.get_questionario_autoavaliacao_icone($row,$cell_others["id_empresa"]).'
					
					
						'.get_checklist_avaliacao_icone($row,$cell_others["id_empresa"]).'	
					
					
						'.get_finalizar_solicitacao_icone($row,$cell_others["id_empresa"]).'	
					
				
					
					'.get_certificado_icone($row,$cell_others["id_situacao"],$cell_others["id_empresa"]).'
						
				
					'.get_andamento_icone($row,$cell_others["data_inclusao"],$cell_others["data_finalizacao"]).'
					
				
					
					
					
			'."</span></div>";		
			$botoes .= "</td>\n";
			return $botoes;
		}	
		

				
		
//-------------------------------------------------------------------------------------------------		
		
		if($table =='participantes'){		
				/////// ############# Verifica Permissão de Usuário ##############
				if ($permission == "Acesso Negado")
					return "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap></td>\n";			
				/////// ##########################################################
				$botoes = "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>";					
				$botoes .= "
		 		 <div style=\"float:left;\" nowrap >
                 	<span  id=\"".$unique_field.",$id,".$name .",$table,$database\">" . '<img src="../images/b_edit.png"  style="cursor:pointer;" '."  onclick=\"parent.openNewAeroWindow('".$table.$row."',80,'center',960,550,'','./php/telas.php?table=".$table."&amp;go_to_page=form_padrao&amp;cod=".$row."');\"" . 'border=0 title="alterar">'.'<a href="mailto:'.$cell_others["email"].'" class="title"  title="'.$cell_others["email"].'|Clique para Enviar um E-mail" ><img src="../images/email.gif" border=0  style="margin:0px 0px 0 2px;"></a> '. "</span>															
					";	
				if($cell_others["facebook_page"])$botoes .= '<a href="'.$cell_others["facebook_page"].'" target="blank"><img src="../images/facebook-icone.png" border=0  style="margin:0px 2px 0 2px;"></a>';	
					
					
				$botoes .= "</div>	";	
					
			$botoes .= "</td>\n";
			return $botoes;
		}	
		
		
//-------------------------------------------------------------------------------------------------		
		
		if($table =='desafios' ){	
		/////// ############# Verifica Permissão de Usuário ##############
		if ($permission == "Acesso Negado")
			return "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>&nbsp;</td>\n";
			
		/////// ##########################################################
		
				$botoes = "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>";					
				$botoes .= "
		 		 <div style=\"float:left;\" nowrap >
                 	<span  id=\"".$unique_field.",$id,".$name .",$table,$database\">". '<img src="../images/b_edit.png"  style="cursor:pointer;" '."  onclick=\"parent.openNewAeroWindow('".$table.$row."',80,'center',960,550,'','./php/telas.php?go_to_page=desafios&cod=".$row."');\"" . 'border=0 title="alterar">'. "</span>		
					</div>										
					";			
			$botoes .= "</td>\n";
			return $botoes;
		}


//-------------------------------------------------------------------------------------------------		
		
		if($table == 'topicos' ){	
		/////// ############# Verifica Permissão de Usuário ##############
		if ($permission == "Acesso Negado")
			return "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>&nbsp;</td>\n";
			
		/////// ##########################################################
				$botoes = "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>";					
				$botoes .= "
		 		 <div style=\"float:left;\" nowrap >
                 	<span  id=\"".$unique_field.",$id,".$name .",$table,$database\">". '<img src="../images/b_edit.png"  style="cursor:pointer;" '."  onclick=\"parent.openNewAeroWindow('".$table.$row."',80,'center',960,550,'','./php/telas.php?go_to_page=topicos&cod=".$row."');\"" . 'border=0 title="alterar">'. "</span>		
					</div>										
					";			
			$botoes .= "</td>\n";
			return $botoes;
		}
		
//-------------------------------------------------------------------------------------------------		
		
		if($_GET["table"] == 'votacao'){	
		/////// ############# Verifica Permissão de Usuário ##############
		if ($permission == "Acesso Negado")
			return "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>&nbsp;</td>\n";
			
		/////// ##########################################################
				$botoes = "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>";					
				$botoes .= "
		 		 <div style=\"float:left;\" nowrap >
                 	<span  id=\"".$unique_field.",$id,".$name .",$table,$database\">". '<img src="../images/b_edit.png"  style="cursor:pointer;" '."  onclick=\"parent.openNewAeroWindow('".$_GET["table"].$row."',80,'center',960,550,'','./php/telas.php?go_to_page=votacao&id_contribuicao=".$row."');\"" . 'border=0 title="alterar">'. "</span>		
					</div>										
					";			
			$botoes .= "</td>\n";
			return $botoes;
		}
		
		
//-------------------------------------------------------------------------------------------------		
		
		if($_GET["table"] == 'execucao'){	
		/////// ############# Verifica Permissão de Usuário ##############
		if ($permission == "Acesso Negado")
			return "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>&nbsp;</td>\n";
			
		/////// ##########################################################
				$botoes = "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>";					
				$botoes .= "
		 		 <div style=\"float:left;\" nowrap >
                 	<span  id=\"".$unique_field.",$id,".$name .",$table,$database\">". '<img src="../images/b_edit.png"  style="cursor:pointer;" '."  onclick=\"parent.openNewAeroWindow('".$_GET["table"].$row."',80,'center',960,550,'','./php/telas.php?go_to_page=execucao&id_contribuicao=".$row."');\"" . 'border=0 title="alterar">'. "</span>		
					</div>										
					";			
			$botoes .= "</td>\n";
			return $botoes;
		}
		
		


//-------------------------------------------------------------------------------------------------	
		
		if($this -> in_table('usuarios') ){	
				/////// ############# Verifica Permissão de Usuário ##############
				if ($permission == "Acesso Negado")
					return "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap></td>\n";			
				/////// ##########################################################		
				$botoes = "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>";					
				$botoes .= "
		 		 <div style=\"float:left;\" nowrap >
                 	<span  id=\"".$unique_field.",$id,".$name .",$table,$database\">" . '<img src="../images/b_edit.png"  style="cursor:pointer;" '."  onclick=\"parent.openAeroWindow('usuario".$row."',80,'center',800,550,'','./php/telas.php?table=usuarios&amp;go_to_page=usuarios&amp;cod=".$row."');\"" . 'border=0 title="alterar">'.'<a href="mailto:'.$cell_others[4].'"><img src="../images/email.gif" border=0  title="enviar email" style="margin:0px 0px 0 2px;"></a>&nbsp; '. "</span>		
					</div>										
					";		
			$botoes .= "</td>\n";
			return $botoes;
		}	
		
//-------------------------------------------------------------------------------------------------
		
		
		if($this -> in_table('niveis_acesso') ){			
				/////// ############# Verifica Permissão de Usuário ##############
				if ($permission == "Acesso Negado")
					return "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap></td>\n";			
				/////// ##########################################################		
				$botoes = "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>";					
				$botoes .= "
		 		 <div style=\"float:left;\" nowrap >
                 	<span  id=\"".$unique_field.",$id,".$name .",$table,$database\">" . '<img src="../images/b_edit.png"  style="cursor:pointer;" '."  onclick=\"parent.openNewAeroWindow('niveis_acesso".$row."',80,'center',1000,750,'','./php/telas.php?table=niveis_acesso&amp;go_to_page=niveis_acesso&amp;cod=".$row."');\"" . 'border=0 title="alterar">'.'&nbsp; '. "</span>		
					</div>										
					";			
			$botoes .= "</td>\n";
			return $botoes;
		}	



//-------------------------------------------------------------------------------------------------
		
		
						
				/////// ############# Verifica Permissão de Usuário ##############
				if ($permission == "Acesso Negado")
					return "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap></td>\n";			
				/////// ##########################################################
				$botoes = "<td title=\"\" style=\"".$style."width=35px"."\" class=\"schrift\" bgcolor=\"$color\" nowrap>";					
				$botoes .= "
		 		 <div style=\"float:left;\" nowrap >
                 	<span  id=\"".$unique_field.",$id,".$name .",$table,$database\">" . '<img src="../images/b_edit.png"  style="cursor:pointer;" '."  onclick=\"parent.openNewAeroWindow('".$table.$row."',80,'center',960,550,'','./php/telas.php?table=".$table."&amp;go_to_page=form_padrao&amp;cod=".$row."');\"" . 'border=0 title="alterar">'. "</span>		
					</div>										
					";			
			$botoes .= "</td>\n";
			return $botoes;
	

//-------------------------------------------------------------------------------------------------
		

	}
	
	
	function create_button_delete($database,$table,$id,$unique_field,$style,$color,$row,$row1,$cell_others,$titulo,$order,$primary_key){		
	
	
	$menu_vetor = verifica_acesso('','',1,'');
	
	for($w=0;$w<count($_SESSION["menu_item"]["item"]);$w++){
	  $aux = $_SESSION["menu_item"]["item"][$w];	
	  for($x=0;$x<count($_SESSION["menu_item"][retirar_acentos($aux)]["titulo"]);$x++){
		  if ($_SESSION["menu_item"][retirar_acentos($aux)]["permission"][$x] == $table){	
				  /////// ############# Verifica Permissão de Usuário ##############
				  $permission = verifica_acesso($table,'','',4);	
				  if ($permission == "Acesso Negado"){ 
					  return "<td title=\"apagar\"  wrap></td>\n";	;		 
				  }
				  /////// ##########################################################
		  }	
	  }	
	}	
	
	
	
	//echo "chave:".$row."<br>";
	switch ($table){	
			case "usuarios":	
				$botao_delete = "<td title=\"apagar\" style=\"cursor:pointer\" onclick=\"delete_field('".$table."','".$row."','".$row1."','".$primary_key."','".$titulo."','".$order."','";
				// if($this -> in_table('subcategoria') ){$this->html .= $row[2];}		//para chave composta	
				$botao_delete .="');\" id=\"".$unique_field.",$id,".$name .",$table,$database\">" . '<img src="../images/delete.gif" width="16" height="16">' . "	</td>\n";						
	 		break;	
			case "log_sys":			
				$botao_delete = "<td title=\"apagar\"  wrap></td>\n";					
	 		break;	
			case "pontuacoes":			
				$botao_delete = "<td title=\"apagar\"  wrap></td>\n";					
	 		break;	
			case "fases":			
				$botao_delete = "<td title=\"apagar\"  wrap></td>\n";					
	 		break;	
			case "solicitacoes":			
				$botao_delete = '<td id="'.$unique_field.','.$id.','.$name .','.$table.','.$database.'"   > ';
				if (($cell_others["id_situacao"] == 5)||($cell_others["data_cancelamento"])){				
					$botao_delete .= '<a class="title" title="Incluir Nova Solicitação|Clique no ícone para incluir" onclick="incluir_nova_solicitacao('.$cell_others["id_empresa"].')"   >' . '<img src="../images/add.gif" width="16" height="16"  style="cursor:pointer"   ></a>';	
				}	
				$botao_delete .="</td>\n";					
	 		break;	
			case "situacoes":				
					if ($cell_others["fixo_sistema"] == 'S'){
						  $botao_delete = "<td title=\"apagar\"  wrap></td>\n";	
					}else{
						  $botao_delete = "<td title=\"apagar\"  style=\"cursor:pointer\" onclick=\"delete_field('".$table."','".$row."','".$row1."','".$primary_key."','".$titulo."','".$order."','";
						  // if($this -> in_table('subcategoria') ){$this->html .= $row[2];}		//para chave composta	
						  $botao_delete .="');\" id=\"".$unique_field.",$id,".$name .",$table,$database\">" . '<img src="../images/delete.gif" width="16" height="16">' . "</td>\n";
					}			
	 		break;	
			default:
				$botao_delete = "<td title=\"apagar\"  style=\"cursor:pointer\" onclick=\"delete_field('".$table."','".$row."','','".$primary_key."','".$titulo."','".$order."','";
				// if($this -> in_table('subcategoria') ){$this->html .= $row[2];}		//para chave composta	
				$botao_delete .="');\" id=\"".$unique_field.",$id,".$name .",$table,$database\">" . '<img src="../images/delete.gif" width="16" height="16">' . "</td>\n";			
			break;		
		}					
		
		
		
	switch ($_GET["table"]){	
			case "selecionar_votacao":		
			case "selecionar_propostas":	
				$botao_delete = "<td title=\"apagar\"  wrap></td>\n";					
	 		break;	
	}					
		
	  return $botao_delete;
	}
	
	function create_cell_others($name,$value){	
		$this -> cell_others[$name]=$value;	
	}
	
	

	
	
	function create_cells_conteudo($database,$table,$name,$id,$unique_field,$style,$color,$value,$cell_others){		
	
		switch ($name){	 	
			case "tipo_entrada":			
				$cells_conteudo .= "<td >".'<select '."id=\"".$unique_field.",$id,".$name .",$table,$database\"".' name="select" onchange="save_combo_online(this.id,this,this.value)">'; 				
				if ($this->InsertLinks($value,'')=="R"){		
						$cells_conteudo .= '<option value="R" selected>RadioBox</option><option value="C">CheckBox</option></select>';
				}else{
						$cells_conteudo .= '<option value="R" >RadioBox</option><option value="C" selected>CheckBox</option></select>';
				}						
	 		break;				
					
			case "manutencao_flag":	
				$cells_conteudo .= "<td style='text-align:right' >".'<select '."id=\"".$unique_field.",$id,".$name .",$table,$database\"".' name="select" onchange="save_combo_online(this.id,this,this.value)">'; 					
				$cells_conteudo .= get_select_true_false($value);	
			break;	
			
			case "fisica_juridica":	
				$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\">";
				$value = get_fisica_juridica($value);				
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);
			break;	
			case "cpf_cnpj":	
			case "cnpj_cpf":	
			case "cnpj":
			case "cnpj_empresa":
				$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\" nowrap>";
				$value = formatarCPF_CNPJ($value);				
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);
			break;


			 
			case "cep":			
				$cells_conteudo .= "<td  id=\"".$unique_field.",$id,".$name .",$table,$database\">"; 						
				$value = formataCepApresentacao($value);
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);	
	 		break;
			case "avatar":			
					$cells_conteudo .= "<td style=\"$style"."cursor:pointer;"."\" class=\"schrift\" bgcolor=\"$color\"   id=\"".$unique_field.",$id,".$name .",$table,$database\">"; 
					//$imagem_name = explode(".", $value);
	
			  if ($value){
				  $cells_conteudo .= "<a href='../publico/$value' target='_blank'><img src='../publico/$value'   title='Clique para aumentar' style='border:0;width:75px;height:75px'></a></span>";	
			  }else{
				  	if($cell_others["facebook_id"]){
						$cells_conteudo .= "<img src='https://graph.facebook.com/".$cell_others["facebook_id"]."/picture?width=75&height=75'   style='border:0;width:75px;height:75px'></span>";	
					}else{
						$cells_conteudo .= "<img src='../publico/images/avatar.jpg'   style='border:0;width:75px;height:75px'></span>";				 		 
					}
			  }	
					
					
					
					
					
					
	 		break;	 		
			case "media":			
					$cells_conteudo .= "<td style=\"$style"."cursor:pointer;"."\" class=\"schrift\" bgcolor=\"$color\"   id=\"".$unique_field.",$id,".$name .",$table,$database\">"; 					
					if ($cell_others["media_flag"] == 'V'){ //video outube					
					$cells_conteudo .= youtube_embed($value,'280px','180px');					
					}else{
						$cells_conteudo .= "<a class='fancybox'  href='../publico/".$cell_others["caminho_arquivo"]."/".$cell_others["arquivo"]."' target='_blank'><img src='../publico/".$cell_others["caminho_arquivo"]."thumb".$cell_others["arquivo"]."'   title='Clique para aumentar' style='border:0;width:280px;height:180px'></a></span>";								
					}		
	 		break;	 
			
			case "media_votacao":			
					$cells_conteudo .= "<td style=\"$style"."cursor:pointer;"."\" class=\"schrift\" bgcolor=\"$color\"   id=\"".$unique_field.",$id,".$name .",$table,$database\">"; 					
					if ($cell_others["media_flag"] == 'V'){ //video outube					
					$cells_conteudo .= youtube_embed($cell_others["youtube_link"],'280px','180px');					
					}else{
						$cells_conteudo .= "<a class='fancybox'  href='../publico/".$cell_others["caminho_arquivo"]."/".$cell_others["arquivo"]."' target='_blank'><img src='../publico/".$cell_others["caminho_arquivo"]."thumb".$cell_others["arquivo"]."'   title='Clique para aumentar' style='border:0;width:280px;height:180px'></a></span>";								
					}		
	 		break;	 
			
			case "votos":	
			case "curtidas":
				$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\">";
				$value = get_total_curtidas($value);			
	 	  		$cells_conteudo .= "<center>".$value."</center>";								
	 		break;
			
			case "responsavel":		
					$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\" nowrap>";
					$value = get_usuario_name($value);				
					$cells_conteudo .= $this->InsertLinks($value,$name);
	 		break;	
			case "id_participante":		
					$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\" >";
					$participante = get_participante($value) ;  				
					$cells_conteudo .= $participante["nome"];
	 		break;	

			
			
			case "id_usuario":	
					$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\">";
					$value = get_login($value);				
					$cells_conteudo .= $this->InsertLinks($value,$name);
	 		break;				
			case "id_operacao":			
				$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\">";
				$value = get_operacao($value);				
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);								
	 		break;
			case "id_nivel":	
				/////// ############# Verifica Permissão de Usuário ##############
				$permission = verifica_acesso($table,'','',5);	
				if ($permission == "Acesso Negado"){ 
					$cells_conteudo .= "<td   id=\"".$unique_field.",$id,".$name .",$table,$database\">";	
					$cells_conteudo .= get_nivel_name($value);	
				}else{
					$cells_conteudo .= "<td style='text-align:right' >".'<select '."id=\"".$unique_field.",$id,".$name .",$table,$database\"".' name="select" onchange="save_combo_online(this.id,this,this.value)">'; 					
					$cells_conteudo .= get_nivel_acesso($value);															
					$cells_conteudo .= '</select>';	
				}
				/////// ##########################################################				
	 		break;
			case "id_nivel_maturidade":	
				/////// ############# Verifica Permissão de Usuário ##############		
				$permission = verifica_acesso('','alterar_nivel_solicitacao','','');	
				if ($permission == "Acesso Negado"){ 
						$cells_conteudo .= "<td   id=\"".$unique_field.",$id,".$name .",$table,$database\" nowrap>";	
				  		$cells_conteudo .=  get_nivel_name($value);	
				}else{
					$cells_conteudo .= "<td style='text-align:right' >".'<select '."id=\"".$unique_field.",$id,".$name .",$table,$database\"".' name="select" onchange="save_combo_online(this.id,this,this.value)" style="width:70px">'; 					
					$cells_conteudo .= get_nivel_maturidade_sugerida($value,$cell_others["id_situacao"]);															
					$cells_conteudo .= '</select>';	
				}
				/////// ##########################################################				
	 		break;
			
			
			
			case "cod_servico":			
				$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\">";
				$value = get_servico($value);				
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);								
	 		break;			
			case "ativado":		
				$menu_vetor = verifica_acesso('','',1,'');
				
				for($w=0;$w<count($_SESSION["menu_item"]["item"]);$w++){
				  $aux = $_SESSION["menu_item"]["item"][$w];	
				  for($x=0;$x<count($_SESSION["menu_item"][retirar_acentos($aux)]["titulo"]);$x++){
					  if ($_SESSION["menu_item"][retirar_acentos($aux)]["permission"][$x] == $table){	
							 $verifica_permissao = 1;
					  }	
				  }	
				}	
				
				if ($verifica_permissao){			
						/////// ############# Verifica Permissão de Usuário ##############
						$permission = verifica_acesso($table,'','',5);	
						if ($permission == "Acesso Negado"){ 
							$cells_conteudo .= "<td   id=\"".$unique_field.",$id,".$name .",$table,$database\">";	
							$cells_conteudo .= ativado_name($value);	
						}else{
							if ($this -> in_table('situacoes')&& ($cell_others["fixo_sistema"]=='S') ){
								$cells_conteudo .= "<td   id=\"".$unique_field.",$id,".$name .",$table,$database\">";	
								$cells_conteudo .= "<center>".ativado_name($value)."</center>";												   
							}else{
							
							$cells_conteudo .= "<td align='center' >".'<select '."id=\"".$unique_field.",$id,".$name .",$table,$database\"".' name="select" onchange="save_combo_online(this.id,this,this.value)">'; 					
							$cells_conteudo .= ativado_options($value);														
							$cells_conteudo .= '</select>';	
							
							}
						}
						/////// ##########################################################
				}else{
					$cells_conteudo .= "<td align='center' >".'<select '."id=\"".$unique_field.",$id,".$name .",$table,$database\"".' name="select" onchange="save_combo_online(this.id,this,this.value)">'; 					
							$cells_conteudo .= ativado_options($value);														
							$cells_conteudo .= '</select>';	
				}				
	 		break;	
		

			case "comentario_flag":			
			case "randomico_flag":		
			case "ativo":	
			case "selecionado":
			case "proposta":
			case "moderador":
			case "validado":	
				$cells_conteudo .= "<td  align='center' >".'<select '."id=\"".$unique_field.",$id,".$name .",$table,$database\"".' name="select" onchange="save_combo_online(this.id,this,this.value)">'; 					
				$cells_conteudo .= get_select_true_false($value);														
				$cells_conteudo .= '</select>';								
	 		break;	
			
			
			
			case "aprovado":
				$cells_conteudo .= "<td  align='center' >".'<select '."id=\"".$unique_field.",$id,".$name .",$table,$database\"".' name="select" onchange="save_combo_online(this.id,this,this.value)">'; 					
				$cells_conteudo .= get_aprovado($value);														
				$cells_conteudo .= '</select>';								
	 		break;	

			case "id_situacao":		
				/////// ############# Verifica Permissão de Usuário ##############
				$permission = verifica_acesso('','alterar_situacao_solicitacao','','');	
				if ($permission == "Acesso Negado"){ 
						$cells_conteudo .= "<td   id=\"".$unique_field.",$id,".$name .",$table,$database\" nowrap>";	
				  		$cells_conteudo .= get_situacao($value);	
				}else{
						$cells_conteudo .= "<td align='center' >".'<select '."id=\"".$unique_field.",$id,".$name .",$table,$database\"".' name="select" onchange="save_combo_online(this.id,this,this.value)" style="width:200px">'; 					
						$cells_conteudo .= get_situacao_combo($value);														
						$cells_conteudo .= '</select>';			
				}
				/////// ##########################################################
	 		break;
			case "id_transacao":		

				  $cells_conteudo .= "<td align='center' >".'<select '."id=\"".$unique_field.",$id,".$name .",$table,$database\"".' name="select" onchange="save_combo_online(this.id,this,this.value)">'; 					
				  $cells_conteudo .= get_transacao_combo($value);														
				  $cells_conteudo .= '</select>';			

	 		break;
			case "id_topico":		
				  $cells_conteudo .= "<td align='center' >".'<select '."id=\"".$unique_field.",$id,".$name .",$table,$database\"".' name="select" onchange="save_combo_online(this.id,this,this.value)">'; 					
				  $cells_conteudo .= get_topico_combo($value,$cell_others["id_desafio"]);														
				  $cells_conteudo .= '</select>';			

	 		break;
			
			case "sql_text":		
				/////// ############# Verifica Permissão de Usuário ##############
				$permission = verifica_acesso('','consultar_sql_logs','','');	
				if ($permission == "Acesso Negado"){ 
						$cells_conteudo .= "<td   id=\"".$unique_field.",$id,".$name .",$table,$database\" nowrap>";	
				  		$cells_conteudo .= "<center>acesso restrito</center>";	
				}else{
						$cells_conteudo .= "<td   id=\"".$unique_field.",$id,".$name .",$table,$database\" nowrap>";	
				  		$cells_conteudo .= wordwrap($value, 30, "<br />\n", true); 				
				}
				/////// ##########################################################										
	 		break;
			
			
			case "em_aberto":
					  $cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\" nowrap>";	
					  
					   $diff= subtrai_data(date("Y-m-d"),data_us($value)); //formato US	
					
					 	 $value = data_br(substr($value,0,10))."  ".substr($value,11,5);							 
						 
						 $value = "<center style='font-size:11px;'>".$value."</center>";
					 		
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);
	 		break;				


			case "data_hora_emissao":					
				$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\">";	
				$value = substr($value,11,8);
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);
			break;
			case "horario_inicial":				
			case "horario_final":		
			case "horario_inicio":	
			case "horario_termino":	
				$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\">";	
				$value = substr($value,0,5);
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);
			break;			
			case "campo_alteravel":
				$cells_conteudo .= "<td   onclick=\"field_ch(this);\" id=\"".$unique_field.",$id,".$name .",$table,$database\">"; 	
				$value = converte_reais($value);
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);	
	 		break;			
			case "modified":							
				$cells_conteudo .= "<td style=\"$style\" class=\"schrift\" bgcolor=\"$color\" wrap><span  id=\"".$unique_field.",$id,".$name .",$table,$database\">"; 				
				$hora = substr($value, 11,5);
				$value = data_br(substr($value, 0,10));
				if($value=="00/00/0000"){$value="<i style='color:#006600;'>nenhuma alteração</i>";$hora="";}
	 	  		$cells_conteudo .= $this->InsertLinks($value."<br>".$hora,$name);	
	 		break;			
			case "created":	
			case "access_date":			
			case "data_treinamento":			
			case "dt_emissao":		
			case "data_reenvio":
			case "data_cancelamento":
			case "data_alteracao":
			case "data_log":
			case "data_inicio":
			case "data_final":
			case "dt_credito":
			case "data_inscricao":
					  $cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\" nowrap>";	
					  if (ereg ("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}", data_br(substr($value,0,10)),$regs)) {
					 	 $value = data_br(substr($value,0,10))."  ".substr($value,11,5);	
						 $value = "<center style='font-size:11px;'>".$value."</center>";
					  } 		
	 	  	 	  	  $cells_conteudo .= $this->InsertLinks($value,$name); 	  		
	 		break;	
			
			
	
			case "data_fim":	
			case "data_nascimento":	
			case "data_agenda":	
				$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\">"; 								
					  if (ereg ("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}", data_br(substr($value,0,10)),$regs)) {
					 	 $value = data_br(substr($value,0,10));		
						 $value = "<center style='font-size:11px;'>".$value."</center>";
					  } 	
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);
	 		break;					
			case "data_inclusao":
					  $cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\" nowrap>";	
					  if (ereg ("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}", data_br(substr($value,0,10)),$regs)) {
					 	 $value = data_br(substr($value,0,10))."<br>".substr($value,11,5);	
						 $value = "<center style='font-size:11px;'>".$value."</center>";
					  } else if (substr($value,0,10) == '0000-00-00') {
						 $value = '-';
						 $value = "<center style='font-size:11px;'>".$value."</center>";
					  }
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);
	 		break;				
			case "expire":							
				$cells_conteudo .= "<td style=\"$style\" class=\"schrift\" bgcolor=\"$color\" wrap><span  id=\"".$unique_field.",$id,".$name .",$table,$database\">";	
				$hora = substr($value, 11,5);
				$value = ($value)?data_br(substr($value, 0,10)):"";							
				 $diff= subtrai_data(date("Y-m-d"),data_us($value)); //formato US				
				
				 if(($value=="00/00/0000")||($value=="")){ // não colocou data para expirar
					 $value="<i style='color:#006600;'>não encerra</i>";$hora="";
				 }else{
				 	if($diff == 0){
						$msg="<b style='color:#ff0000;'>encerra hoje</b>";	
					}else{
						if($diff > 0){
							$msg="<b style='color:#006600;'>encerra em ".$diff." dias</b>";				 
						}else{
							$msg="<b style='color:#ff0000;'>encerrou há ".abs($diff)." dias</b>";		
							$this -> create_cell_others('publicado','nao');		 
						}
					}
				 }
	 	  		$cells_conteudo .= $this->InsertLinks($value."<br>".$hora."<br>".$msg,$name);	
	 		break;						
			case "publish":							
				$cells_conteudo .= "<td style=\"$style\" class=\"schrift\" bgcolor=\"$color\" wrap><span  id=\"".$unique_field.",$id,".$name .",$table,$database\">"; 				
				$hora = substr($value, 11,5);
				$value = data_br(substr($value, 0,10));
				$diff= subtrai_data(data_us($value),date("Y-m-d")); //formato US		
				if($value=="00/00/0000"){
					$value="<b style='color:#ff0000;'>não publicado</b>";$hora="";
					$this -> create_cell_others('publicado','nao');
				}else{
					if($diff == 0){
						$msg="<b style='color:#ff0000;'>publica hoje</b>";	
					}else{
						if($diff > 0){
							$msg2="publicado há ".abs($diff)." dias";
							$value="<span title='".$msg2."' style='color:#006600;cursor:pointer;'>".$value."</span>";				
							 $hora="<span title='".$msg2."' style='color:#006600;cursor:pointer;'>".$hora."</span>";		
						}else{
							$msg="<b style='color:#ff0000;'>publicação em ".abs($diff)." dias</b>";				 
						}
					}
				}
				$cells_conteudo .= $this->InsertLinks($value."<br>".$hora."<br>".$msg,$name);		 	  
	 		break;				
			case "bit_aberto":			
				$cells_conteudo .= "<td style=\"$style\" class=\"schrift\" bgcolor=\"$color\" wrap>					<span \\ >".'<select '."id=\"".$unique_field.",$id,".$name .",$table,$database\"".' name="select" onchange="save_combo_online(this.id,this,this.value)">'; 				
				if ($this->InsertLinks($value,'')=="1"){
					$cells_conteudo .= '<option value="1" selected>sim</option><option value="0">n&atilde;o</option></select>';
				}else{
					$cells_conteudo .= '<option value="1" >sim</option><option value="0" selected> n&atilde;o</option></select>';
				}						
	 		break;	 
			case "bit_disponivel":						
				$cells_conteudo .= "<td style=\"$style\" class=\"schrift\" bgcolor=\"$color\" wrap>					<span \\ >".'<select '."id=\"".$unique_field.",$id,".$name .",$table,$database\"".' name="select" onchange="save_combo_online(this.id,this,this.value)">'; 				
				if ($this->InsertLinks($value,'')=="1"){
					$cells_conteudo .= '<option value="1" selected>sim</option><option value="0">n&atilde;o</option></select>';
				}else{
					$cells_conteudo .= '<option value="1" >sim</option><option value="0" selected> n&atilde;o</option></select>';
				}			
	 		break;	 	 
			
			case "valor_total":
				$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\">";	
				$value = converte_reais($value);
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);	
	 		break;
			
			case "nro_solicitacao":			
			case "nro_ficha":
			case "cpf_cnpj_proprietario":
				$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\" nowrap>";	
				$value = "<center>".$value."</center>";
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);	
	 		break;
			
			
			
			
			case "nome_projeto":
				$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\" nowrap>";		
	 	  		$cells_conteudo .= substr($value,0,40);
	 		break;
			
			
			case "cod_cartografico_imovel":
				$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\" nowrap>";	
				$value = "<center style='font-size:11px;'> ".$value."</center>";
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);
	 		break;	
			
			case "aux":
				if ($this -> in_table('solicitacoes')){
					$cells_conteudo .= "<td    id=\"".$unique_field.",$id,".$name .",$table,$database\" nowrap>";	
					$value = get_nivel_avaliado($cell_others["id_solicitacao"],$cell_others["id_empresa"]);
					$cells_conteudo .= $this->InsertLinks($value,$name);	
				}
	 		break;
			
			case "id_desafio":
				$cells_conteudo .= "<td>";	
				$value = get_desafio($value);
				
	 	  		$cells_conteudo .= $this->InsertLinks($value,$name);
	 		break;	
			
			

			default:				
				if  ( //desbloqueia tabelas ou campos de tabelas					
					 ($_SESSION["table"] == "operacoes") ||  
					 ($_SESSION["table"] == "perguntas") ||  
					 (($_SESSION["table"] == "t_licitacoes_type")&&
					 (($name == "nome_tipo")||($name == "standard_title")||($name == "standard_text")))					 
				    ){					
					$cells_conteudo .= "<td   onclick=\"field_ch(this);\" id=\"".$unique_field.",$id,".$name .",$table,$database\">"; 
				}else{					
					$cells_conteudo .= "<td   id=\"".$unique_field.",$id,".$name .",$table,$database\">";					
				}				
				if(strlen($value)==0) $value = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";					
				
				if (DBConnect::database=="postgresql"){    //PostgreSQL precisa testar todos os campos
					  $foreign_key_value = get_value_foreign_key($table,$name,$value); //confirma se o campo mul é foreign key					 
				}
				
				if (DBConnect::database=="mysql"){    //Mysql	- testa apenas campos mul
					  if (   strlen(array_search($name,$this -> foreign_key))>0   ){	 // verifica se campo é MUL
							$foreign_key_value = get_value_foreign_key($table,$name,$value);
					  }else{
							$foreign_key_value = "";			  
					  }	
				}				
						
				if ($foreign_key_value){ // verifica se campo é foreign key		
					$cells_conteudo .= $foreign_key_value;	
				}else{
					$cells_conteudo .= $this->InsertLinks($value,$name);
				}				
			break;
		}
		$cells_conteudo .= "</td>\n";		
		return $cells_conteudo;
	}
	
	
	  function create_add_cells($field,$x){ // combos nas insert das tabelas
		  
			  $aux=1;
	 
			  if ($field =="senha"){
				  $add_cells_conteudo .= '<td style="background-color:#F4F4FF;"><input type="password" name="'.$field.'" class="input" id="imput_width'.intval($x+1).'" style="display:none;"></td>';	
				  $aux=0;
			  }			
					  
			  if (($field =="cod_categoria")&&($_SESSION["table"]=="subcategoria")){
				  $add_cells_conteudo .= $this -> combo_box(intval($x+1),"cod_categoria",$field,"categoria","300","cod_categoria");
				  $aux=0;
			  }		
			  
			  if ((($field =="cod_servico")&&($_SESSION["table"]=="subcategoria"))||(($field =="cod_servico")&&($_SESSION["table"]=="categoria"))){
				  $add_cells_conteudo .= $this -> combo_box(intval($x+1),$field,"nome","servicos","170","cod_servico");			
				  $aux=0;
			  }
			  
			  
			  if (($field =="id_transacao")&&($_SESSION["table"]=="operacoes")){
				  $add_cells_conteudo .= $this -> combo_box(intval($x+1),$field,"descricao","transacao","100","id_transacao");			
				  $aux=0;
			  }
		
			  
			  
			  if ($aux){
				  $add_cells_conteudo .= '<td style="background-color:#F4F4FF;"><input type="text" name="'.$field.'" class="input" id="imput_width'.intval($x+1).'" style="display:none;"></td>';		
			  }
	  
		   
			return $add_cells_conteudo;
	  }
	  
	  

		  
	  function create_button_add_new_line($cols_number){
		  if(											// habilita botao	
			 ($this -> in_table('operacoes'))||			  
			 ($this -> in_table('table2')) ){
			  $this->html .= "<a id=\"display_add\" href=\"javascript:";		
				  if ( ($this -> in_table('area'))||($this -> in_table('projetos'))||($this -> in_table('modelos'))||($this -> in_table('grupos_modelos'))||($this -> in_table('grupos_usuarios'))||($this -> in_table('usuarios')||($this -> in_table('marcos_projeto'))) ) {
					  $this->html .= "location.href='./telas.php?go_to_page=cadastro_".$this -> table."'\" ";
				  }else{
					  $this->html .= "cols_width('".$cols_number."','inline');\"";
				  }			
					  $this->html .=" >".'<img id="display_img" src="../images/add.gif" title="Adicionar" width="16" height="16" style=\"text-decoration:none;border:0;\"></a>';	
		  }else{			// desabilita botao
				// desabilita botao	
		  }				
	  }
	  
	  
	function filtro($id_tipo){
		if($this->in_table("t_licitacoes")){// desabilita botao
		
			if ($_SESSION["eventos_off-line"] == "false"){
				$checked_offline="";
			}else{
				$checked_offline="checked";
			}
			
			if ($_SESSION["evento_fechado"] == "false"){
				$checked_fechado="";
			}else{
				$checked_fechado="checked";
			}
		
				echo '
<span>&nbsp;|&nbsp;</span>
<div style="position:absolute"><form></div>	

<input type="checkbox" name="e_fechado"  '.$checked_fechado.' onclick="change_event_state(this,\''.$id_tipo.'\');"><span style="text-transform:none;" >Fechados</span>
  <input type="checkbox" name="e_offline"  '.$checked_offline.' onclick="change_event_state(this,\''.$id_tipo.'\');"><span style="text-transform:none;" >Off-line</span>
 <div style="position:absolute"></form></div> 

				';
		}else{	// habilita botao		
			
		}				
	} 
	  
	  

}


class table_variables {	
	var $titulo;
	var $where;
	function overload_tables ($table){						
		$dados = implode("",file("../xml/tables.xml"));
		$parser = xml_parser_create();		
		xml_parse_into_struct($parser,$dados,$valores,$indices);
		xml_parser_free($parser);				
		for ($i=0;$i<sizeof($indices["TABLE"]);$i++) {
			//echo $valores[$indices["NOME"][$i]]["value"];
			if($valores[$indices["NOME"][$i]]["value"] == $table){			
				$_SESSION["table"]=$table;  //nome da tabela a ser listada		
				$_SESSION["table"] = table_alias($table);				
				
				
				//campo pelo qual a tabela vai ser ordenado
				if ($_GET["order"]){
					$_SESSION["order"]=$_GET["order"];
				}else{
					$_SESSION["order"]=$valores[$indices["ORDER"][$i]]["value"];
				}
				if ($_GET["order_tbl"]) $_SESSION["order"] = $_GET["order_tbl"];				
				
				$_SESSION["primary_key"]= $valores[$indices["PRIMARY_KEY"][$i]]["value"];// chave primaria da tabela							
				$_SESSION["button_extends"]= $valores[$indices["BUTTON_EXTENDS"][$i]]["value"];//botoes adicionais						
		
				$this -> titulo = $valores[$indices["TITULO"][$i]]["value"];		
				$this -> where = $valores[$indices["WHERE"][$i]]["value"];	

				$str_listfield_vetor=$valores[$indices["LISTFIELD_VETOR"][$i]]["value"];
				if (count(explode(",",$str_listfield_vetor)) == 1){
					$_SESSION["listfield_vetor"]=$str_listfield_vetor;
				}else{
					$_SESSION["listfield_vetor"]=explode(",",$str_listfield_vetor);   // campos da tabela que não serão visualizados
				}			
				
				$str_hidefield_vetor=$valores[$indices["HIDEFIELD_VETOR"][$i]]["value"];
				if (count(explode(",",$str_hidefield_vetor)) == 1){
					$_SESSION["hidefield_vetor"]=$str_hidefield_vetor;
				}else{
					$_SESSION["hidefield_vetor"]=explode(",",$str_hidefield_vetor);   // campos da tabela que não serão visualizados
				}	
				
				//print_r ($_SESSION["hidefield_vetor"]);
			}
		}	
	}
}





function table_alias ($table){		
	$xml = simplexml_load_file("../xml/tables_alias.xml");
	foreach($xml->table_alias as $field){
		if ($table == (string)$field->alias) return (string)utf8_decode($field->table); // Old field ==> New field  
	}
	return $table;		
}
	
	


	
	
	
function btn_incluir ($cols_number,$titulo){		


	$menu_vetor = verifica_acesso('','',1,'');
	
	for($w=0;$w<count($_SESSION["menu_item"]["item"]);$w++){
	  $aux = $_SESSION["menu_item"]["item"][$w];	
	  for($x=0;$x<count($_SESSION["menu_item"][retirar_acentos($aux)]["titulo"]);$x++){
		  if ($_SESSION["menu_item"][retirar_acentos($aux)]["permission"][$x] == $_SESSION["table"]){	
				/////// ############# Verifica Permissão de Usuário ##############
				$permission = verifica_acesso($_SESSION["table"],'','',3);	
				if ($permission == "Acesso Negado"){ 
					return false;	 
				}
				/////// ##########################################################
		  }	
	  }	
	}	


		switch ($_SESSION["table"]){	//desabilita boão incluir			
			case 'parametros':
				return false;
				break;			
			case 'comentarios':
				return false;
				break;	
			case 'participantes':
				return false;
				break;	
			case 'inspiracoes':
				return false;
				break;		
			case 'propostas':
				return false;
				break;				
			case 'pontuacoes':
				return false;
				break;	
			case 'fases':
				return false;
				break;	
			case 'log_sys':
				return false;
				break;				
		}	

		// codigo do botão incluir
		$btn = '<input id="btn_incluir" name="salvar" type="button"  class="botao" onMouseOver="this.className=\'botao_hover\'" onMouseOut="this.className=\'botao\'" style="float:right;" value="Incluir '.$titulo.'" onClick="';	
		
		
		switch ($_GET["table"]){	
			case 'votacao':
				return false;
				break;		
			case 'execucao':
			$btn .= "parent.openNewAeroWindow('incluir_execucao',80,'center',960,550,'','./php/telas.php?go_to_page=add_contribuicao');\"";
			$btn .=  ' />'; 
			return $btn;
			break;		
		}	
		
		
		
		
		
		switch ($_SESSION["table"]){	
			case 'teste2':
				$btn .= "location.href='./telas.php?go_to_page=cadastro_area';\" ";
				break;					
			case 'usuarios':
			$btn .= "parent.openAeroWindow('incluir_usuarios',80,'center',800,550,'','./php/telas.php?go_to_page=usuarios');\"";
				break;	
			default:
				$btn .= "parent.openAeroWindow('incluir_".$_SESSION["table"]."',80,'center',800,550,'','./php/telas.php?table=".$_SESSION["table"]."&amp;go_to_page=form_padrao');\"";
				break;		
		}	
		

		
		
		
		$btn .=  ' />'; 
		return $btn;
	}
	

?>
<table style="margin:0px 2px 0 2px;width:100%" cellpadding="1" cellspacing="0">
    <tr nowrap>
      <td>
            Razão Social: <strong><?= $rs_empresa["razao_social"] ?></strong>&nbsp;/&nbsp;Nome Fantasia: <strong>&nbsp;<?= $rs_empresa["nome_fantasia"] ?></strong>
     
        </td>
    </tr>   
 </table>
<?
echo $rs_pergunta["nome_pergunta"];
	
$sql_pergunta = "SELECT   a.id_pergunta, 
						  a.texto_pergunta, 
						  a.id_questionario,
						  b.chave,
						  a.nro_pergunta,
						  a.comentario_flag,
						  a.obrigatorio_flag,
						  t.nome_topico,
						  t.descricao,
						  c.comentario
				FROM perguntas  as a
				INNER JOIN forms_componentes as b ON (a.id_form_componente = b.id_form_componente )
				LEFT OUTER JOIN respostas_comentarios as c ON (a.id_pergunta  = c.id_pergunta AND c.id_solicitacao='".$id_solicitacao."') 
				LEFT OUTER JOIN topicos as t ON (t.id_topico  =  a.id_topico) 
				WHERE (a.data_cancelamento is NULL) 
				AND a.id_questionario = '".$rs_questionario["id_questionario"]."' 
				ORDER BY t.nro_topico,a.nro_pergunta
				";

	// color 99bbe8
/////////////////////////////////////////////////////////
////////////////////////  perguntas   //////////////////////
////////////////////////////////////////////////////////
echo '<table  cellpadding="3" cellspacing="3" style="width:100%;border:5px solid #ffffff">';
$result_pergunta=return_query($sql_pergunta);	
$x=0;
$id_pergunta_array = array();
while ($rs_pergunta =  db_fetch_array($result_pergunta)){	
	$cor = ($x%2 == 0)?'#fff':'#eaeff7';$x++;	
	
	// /////   verifica quais perguntas são obrigatórias  ///////////
	if ($rs_pergunta["obrigatorio_flag"] == 'S') 
				$id_pergunta_array[] = $rs_pergunta["id_pergunta"];
	/////////////////////////////////////////////////////////////////
	
	if ($rs_pergunta["nome_topico"] != $nome_topico_atual){
				echo '<tr style="background:#fff"><td><hr style="border:1px solid #99bbe8"></td></tr>';	
				echo '<tr style="background:#fff"><td><b style="font-size:18px">'.$rs_pergunta["nome_topico"]."</b></td></tr>";	
				$nome_topico_atual = $rs_pergunta["nome_topico"];
				echo '<tr style="background:#fff"><td>'.$rs_pergunta["descricao"]."</td></tr>";	
				echo '<tr style="background:#fff"><td><hr style="border:1px solid #99bbe8"></td></tr>';	
	}

	echo '<tr style="background:'.$cor .'"><td><b id="label_pergunta_'.$rs_pergunta["id_pergunta"].'">'.$rs_pergunta["texto_pergunta"]."</b>";
	/////////////////////////////////////////////////////////
	////////////////////////  opções   //////////////////////
	////////////////////////////////////////////////////////
	$sql_opcao = "SELECT   	
								a.id_opcao, 
								a.id_pergunta,
								a.nro_opcao,
								a.ordem,
								a.style,  
								a.break_line_before_flag,
								a.complemento_flag,
								a.texto_opcao,
								b.id_opcao as checked,
								b.resposta_opcao
			  FROM opcoes as a
			  LEFT OUTER JOIN respostas_questionarios as b ON (a.id_opcao  =  b.id_opcao AND id_solicitacao='".$id_solicitacao."') 
			  WHERE (a.data_cancelamento is NULL) 
			  AND a.id_pergunta = '".$rs_pergunta["id_pergunta"]."' 
			  ORDER BY a.ordem
			  ";
			  
	//echo $sql_opcao;
	$result_opcao=return_query($sql_opcao);	
	while ($rs_opcao =  db_fetch_array($result_opcao)){	
	
		  switch ($rs_pergunta["chave"]){
			  case 'radiobox':
				   $componente = '<input type="radio" name="pergunta_'.$rs_pergunta["id_pergunta"].'"  ';
				  if ( ($rs_questionario["solicitacao_finalizada"]=="")&&($rs_questionario["data_cancelamento"]=="")&&($permission != "no")   )
				   			$componente .= ' onclick=\'atualiza_radiobox(this,"'.$id_solicitacao.'","'.$rs_pergunta["id_pergunta"].'","'.$rs_opcao["id_opcao"].'","'.$id_empresa.'");\'  '; 
				   if ($rs_opcao["checked"]) $componente .=  " checked ";		
				   if ($rs_opcao["complemento_flag"] == 'S') $componente .=  ' id="pergunta_'.$rs_pergunta["id_pergunta"].'_'.$rs_opcao["id_opcao"].'" ';	
				   $componente .= '   >'.$rs_opcao["texto_opcao"]."&nbsp;";
			   break;
			  case 'checkbox':
				   $componente = '<input type="checkbox"  name="pergunta_'.$rs_pergunta["id_pergunta"].'"  ';
				  if ( ($rs_questionario["solicitacao_finalizada"]=="")&&($rs_questionario["data_cancelamento"]=="")&&($permission != "no")   )
				 			$componente .=  ' onclick=\'atualiza_checkbox(this,"'.$id_solicitacao.'","'.$rs_pergunta["id_pergunta"].'","'.$rs_opcao["id_opcao"].'","'.$id_empresa.'");\'  ';
				   if ($rs_opcao["checked"]) $componente .=  " checked ";		
				   if ($rs_opcao["complemento_flag"] == 'S') $componente .=  ' id="pergunta_'.$rs_pergunta["id_pergunta"].'_'.$rs_opcao["id_opcao"].'" ';				   
				   $componente .= '   >'.$rs_opcao["texto_opcao"]."&nbsp;";
			   break;
			  case 'combobox':
			   $cor = "";
			   break;
			  case 'texto':
				$componente = '&nbsp;<input name="pergunta_'.$rs_pergunta["id_pergunta"].'"  type="text" class="x-form-text x-form-field" ';
				  if ( ($rs_questionario["solicitacao_finalizada"]=="")&&($rs_questionario["data_cancelamento"]=="")&&($permission != "no")   )
						$componente .=  ' onblur=\'atualiza_conteudo("operacoes.php","update_input=yes&id_solicitacao='.$id_solicitacao.'&id_pergunta='.$rs_pergunta["id_pergunta"].'&id_opcao='.$rs_opcao["id_opcao"].'&id_empresa='.$id_empresa.'&value="+ encodeURIComponent(this.value),"POST",handleHttpQuestion)\' ';						
				$componente .= ' style="'.$rs_opcao["style"].';"  value="'.$rs_opcao["resposta_opcao"].'"   maxlength="180"   />';	
				break;
			  default:
			   $cor = "";
			   break;				
		  }	
		  
		  if ($rs_opcao["break_line_before_flag"] == 'S')  echo "<br>";		  
		  echo $componente;		
		  
		  if ($rs_opcao["complemento_flag"] == 'S') {
			  echo '&nbsp;<input name="complemento_'.$rs_pergunta["id_pergunta"].'_'.$rs_opcao["id_opcao"].'"  id="complemento_'.$rs_pergunta["id_pergunta"].'_'.$rs_opcao["id_opcao"].'"  type="text" class="x-form-text x-form-field"  value="'.$rs_opcao["resposta_opcao"].'"  style="'.$rs_opcao["style"].';"   maxlength="180"  onclick="check_pergunta(this)"  ';
				  if ( ($rs_questionario["solicitacao_finalizada"]=="")&&($rs_questionario["data_cancelamento"]=="")&&($permission != "no")   )
					  echo ' onblur=\'atualiza_complemento(this,"'.$id_solicitacao.'","'.$rs_pergunta["id_pergunta"].'","'.$rs_opcao["id_opcao"].'","'.$id_empresa.'");\' ';
			  echo ' />';
		  }
	}
	/////////////////////////////////////////////////////////
	
	
	if ($rs_pergunta["comentario_flag"] == 'S'){
			echo	'<br><div style="height:50px;padding:10px;"> comentário: <textarea class="x-form-text x-form-field" style="width:70%;height:50px;vertical-align:middle;" rows="5" wrap="soft"  name="commentario_'.$rs_pergunta["id_pergunta"].'_'.$rs_opcao["id_opcao"].'" ';
		    if ( ($rs_questionario["solicitacao_finalizada"]=="")&&($rs_questionario["data_cancelamento"]=="")&&($permission != "no")   )
					echo ' onblur=\'atualiza_conteudo("operacoes.php","update_textarea=yes&id_solicitacao='.$id_solicitacao.'&id_pergunta='.$rs_pergunta["id_pergunta"].'&id_opcao='.$rs_opcao["id_opcao"].'&id_empresa='.$id_empresa.'&value="+ encodeURIComponent(this.value),"POST",handleHttpQuestion)\' ';
			echo ' >'.$rs_pergunta["comentario"].'</textarea>( opcional ) </div>';
	}
	
	echo '<br/>&nbsp;</td></tr>';	
}
/////////////////////////////////////////////////////////
echo '</table>';
	
?>
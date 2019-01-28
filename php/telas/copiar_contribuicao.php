<? 
$layout = new layout;
echo '<style>table tr td {font-family:Verdana, Geneva, sans-serif;font-size:12px;}</style>';
$layout -> set_body('','','');


foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  		 $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	


if ($_GET["id_contribuicao"]){  // Alterar desafio
	$sql_check = "SELECT id_contribuicao from contribuicoes
			WHERE (id_contribuicao_origem = '".$_GET["id_contribuicao"]."')  AND id_fase = '4'
			limit 1
			";  
	if (numrows($sql_check)>0){
		echo "Proposta já copiada anteriormente";	
	}else{			
		$sql = "INSERT INTO contribuicoes (id_contribuicao,  nome_contribuicao,  aprovado,  selecionado,  media_flag,  youtube_link,  caminho_arquivo,  arquivo,  id_participante, id_fase,  id_desafio,  id_topico,  descricao,  motivo_reprovacao, id_contribuicao_origem, data_inclusao) 
SELECT  NULL,  nome_contribuicao,  aprovado,  'N' as selecionado,  media_flag,  youtube_link,  caminho_arquivo,  arquivo,  id_participante, '4' as id_fase,  id_desafio,  id_topico,  descricao,  motivo_reprovacao, '".$_GET["id_contribuicao"]."' as id_contribuicao_origem, '".date("Y-m-d H:i:s")."' as  data_inclusao FROM contribuicoes WHERE (id_contribuicao = '".$_GET["id_contribuicao"]."')  AND id_fase = '3' LIMIT 1";
		insert_record($sql);
		echo "Proposta copiada para Execução";	
	}		
}

exit();


?>
<? 
echo '<style>table tr td {font-family:Verdana, Geneva, sans-serif;font-size:12px;}</style>';
echo '</HEAD><BODY>';

foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	


if ($_GET["cod"]){  // Alterar usuario
	$sql = "select id_nivel,  nome_nivel,  descricao_nivel,  data_alteracao,  data_inclusao,  data_cancelamento 
			FROM niveis_acesso
			WHERE (id_nivel = '".$_GET["cod"]."') 
			limit 1
			";  	
			
	$rs_niveis_acesso = get_record($sql);		
	
	//exit($sql);

	
	 //Alterar entidade já existente
	$title_usuario = $rs_niveis_acesso["nome_nivel"];	
}else{  //Adicionar Nova entidade
	$title_usuario = "Incluir Novo Grupo de Acesso";
}




?>

<form name="form1" id="form1" method="post" >

<? create_table_extjs("99%","130px",$title_usuario);?>





<table style="margin:2px 2px 0 2px;width:100%" cellpadding="1" cellspacing="0">
<tr>
  <td colspan="6" style="width:100%">
  <div id="tabs" style="width:97%">
    <ul>
     <li><a href="#tabs-identificao">Identificação</a></li>
      <li><a href="#tabs-controle">Controle de Acesso</a></li>
    </ul>
    <div id="tabs-identificao" style="width:97%;">
        <!-- ----------------------------- ------------------------------------------------    -->
      <table style="margin:2px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">
        <tr >
          <td   nowrap><div align="right">Nome Grupo de Acesso</div></td>
          <td colspan="5"><input name="nome_nivel" type="text" class="x-form-text x-form-field"  style="width:100%;" value="<?= $rs_niveis_acesso["nome_nivel"]?$rs_niveis_acesso["nome_nivel"]:""  ?>"  maxlength="60"   /></td>
        </tr>
        <tr nowrap="nowrap">
          <td nowrap="nowrap"   ><div align="right">Descrição</div></td>
          <td colspan="5" nowrap="nowrap" style="width:100%;"><textarea style="width:100%;height:100px;" rows="5" wrap="soft" name="descricao_nivel" class="x-form-text x-form-field" id="descricao_nivel"><?=  $rs_niveis_acesso["descricao_nivel"]?$rs_niveis_acesso["descricao_nivel"]:"" ?>
</textarea></td>
        </tr>      
      </table>
      <!-- ----------------------------- ------------------------------------------------    -->
    </div>
    <div id="tabs-controle" style="width:97%;">
        <!-- ----------------------------- ------------------------------------------------    -->
      <table style="margin:2px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">     
        <tr>
          <td colspan="6" style="width:100%;border:1px solid #99bbe8;background-color:#dfe8f6;;color:#000;font-weight:bold;text-align:center">
     <input type="checkbox" name="marca_todos"  onClick="marcar_todos(this,this.form)">   Marcar Todos
     
     
         &nbsp; <input type="checkbox" name="somente_consulta_btn"  onClick="check_permission(this,this.form,1)">   Consulta
          
          
         &nbsp;  <input type="checkbox" name="editar_btn"  onClick="check_permission(this,this.form,2)">   Editar
           
       &nbsp;    <input type="checkbox" name="inserir_btn"  onClick="check_permission(this,this.form,3)">   Incluir
           
           
      &nbsp;     <input type="checkbox" name="apagar_btn"  onClick="check_permission(this,this.form,4)">   Apagar
           
       &nbsp;   <input type="checkbox" name="ativar_btn"  onClick="check_permission(this,this.form,5)">     Ativar / Desativar

           
           
        </td>
        
        
        </tr>


        <tr><td colspan="6">
        
        
        <?
		$sql = "SELECT a.id_operacao, a.id_transacao, a.operacao_interna, 
				a.descricao_operacao, a.grupo , b.id_nivel
				FROM operacoes as a 
				left outer join nivel_operacao as b 
				on( b.id_operacao = a.id_operacao  AND id_nivel='".$_GET["cod"]."')
				WHERE grupo is not NULL
 				order by a.grupo,a.id_transacao,a.descricao_operacao		
				";		
				
				//exit($sql);
				
		  if (numrows($sql)>0){
				  $result = return_query($sql);			
				  while( $rs = db_fetch_array($result) ){					  
				  	$grupo[$rs["grupo"]][] = $rs["descricao_operacao"]."|".$rs["id_operacao"]."|".$rs["id_nivel"]."|".$rs["id_transacao"];
				  }
		  }
				
		 echo '<table cellpadding="0" cellspacing="0" style="background-color:#eaeff7;border:1px solid #dfe8f6;padding:10px;width:100%" >';		
		foreach ($grupo as $a => $b){			
			 echo '<tr><td colspan="4"><div  class="titulo_border">&nbsp;'.$a.'</div></td></tr>';	
			 echo '<tr ><td colspan="4" class="linha_border">';
			 foreach ($b as $c){
				  $result = explode("|",$c);
				  echo '<div style="float:left;width:210px;"><input type="checkbox" name="id_objeto[]" size="'.$result[3].'" value="'.$result[1].'" ';  				  
				  if ($result[2]) echo "checked";
				  echo ' >'.$result[0].'</div>';
					
					
			 }
			 echo '</td></tr>';
		}
		
		?>
      	  <tr><td colspan="4"><div style="border-top:1px solid #99bbe8;">&nbsp;</div></td></tr>
        </table>
       </td></tr>
      </table>
      <!-- ----------------------------- ------------------------------------------------    -->
    </div>
 </div>
    </td>
</tr>

    
  <tr nowrap>
    <td colspan="6" align="right">   
 <? if ($_GET["cod"]){  // Alterar usuario ?>
          <input type="button" name="btn_salvar" value="Alterar Grupo de Acesso" onclick="alterar_grupo_acesso(this.form,'<?= $_GET["cod"] ?>');" style="margin-right:5px;"   class="botao" onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"   >
     <? }else{  //Adicionar Novo usuario ?>
              <input type="button" name="btn_salvar" id="btn_salvar" value="Incluir Grupo de Acesso" onclick="adicionar_grupo_acesso(this.form);" style="margin-right:5px;"   class="botao" onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"   >
     <? } ?>       
      <input type="button" name="btn_reset" id="btn_reset" value="Limpar" class="botao"  onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"  style="margin-right:30px;" onclick="limpa_form(this.form)">
      
      </td>
  </tr>
</table>
<? end_table_extjs();?>

</form >

  <iframe frameborder="0" NAME="grid_iframe" WIDTH="0" HEIGHT="0" style="display:none;">No Inlineframes</iframe>
  
	<script>
$(function() {
	$( "#tabs" ).tabs();	
});
	</script>
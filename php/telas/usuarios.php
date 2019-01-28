<? 
echo '<style>table tr td {font-family:Verdana, Geneva, sans-serif;font-size:12px;}</style>';
echo '</HEAD><BODY>';


foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	


if ($_GET["cod"]){  // Alterar usuario
	$sql = "SELECT id_usuario,login,id_nivel,nome_usuario,email
			FROM usuarios as s
			WHERE (s.id_usuario = '".$_GET["cod"]."') 
			limit 1
			";  	
	$rs = get_record($sql);		
	
	//exit($sql);

	
	 //Alterar entidade já existente
	$title_usuario = $rs["nome_usuario"];	
}else{  //Adicionar Nova entidade
	$title_usuario = "Incluir Novo Usuário";
}




?>

<form name="form1" id="form1" method="post" >

<? create_table_extjs("99%","130px",$title_usuario);?>





<table style="margin:2px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">
<tr>
  <td colspan="6" style="width:97%">
  <div id="tabs" style="width:97%">
    <ul>
      <li><a href="#tabs-1">Usuário</a></li>
    </ul>
    <div id="tabs-1" style="width:97%;">
      <!-- ----------------------------- ------------------------------------------------    -->
      <table style="margin:2px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">
        <tr >
          <td   ><div align="right">Login</div></td>
          <td colspan="5"><input name="login" type="text"  id="login" style="width:200px;" value="<?= $rs["login"]?$rs["login"]:$login ?>"  maxlength="20"    
               <? if ($_GET["cod"]){  // Alterar usuario ?>
               		             disabled
               <? }else{  ?>          
                  class="x-form-text x-form-field"
               <? } ?>   
        />
       </td>
        </tr>
        <tr nowrap="nowrap">
          <td nowrap="nowrap"   ><div align="right">Nível de Acesso</div></td>
          <td colspan="5" nowrap="nowrap" style="width:100%;"> <?= grupo_options($rs["id_nivel"]); ?></td>
        </tr>
        <tr nowrap="nowrap">
          <td nowrap="nowrap"   ><div align="right">Nome</div></td>
          <td colspan="5" nowrap="nowrap" style="width:100%;"><input name="nome_usuario" type="text" class="x-form-text x-form-field" id="nome_usuario" style="width:90%;"  maxlength="80"  value="<?= $rs["nome_usuario"]?$rs["nome_usuario"]:$nome_usuario  ?>" /></td>
        </tr>
        <tr nowrap="nowrap">
          <td nowrap="nowrap"   ><div align="right">E-mail</div></td>
          <td colspan="5" nowrap="nowrap"><input name="email" type='text'   class="x-form-field" id="email" style='width:90%;text-transform:lowercase; ' onblur="check_mail(this);" value="<?= $rs["email"]?$rs["email"]:$email  ?>" maxlength="80"  autocomplete="off"></td>
        </tr>
        

         <? if (!$_GET["cod"]){  // Alterar usuario ?>
        
        <tr nowrap="nowrap">
          <td nowrap="nowrap"   ><div align="right">Senha</div></td>
          <td colspan="5" nowrap="nowrap"><input name="senha" type='password' value='' maxlength="32" class='x-form-field' style='width:200px;' id="senha" autocomplete="off">
           
            </td>
        </tr>     
        
        
        <tr nowrap="nowrap">
          <td nowrap="nowrap"   >Confirmar Senha</td>
          <td colspan="5" nowrap="nowrap"><input name="confirmar_senha" type='password' value='' maxlength="32" class="x-form-text x-form-field" id="confirmar_senha" style="width:200px;"    /></td>
        </tr>
        
        
         <? }  // Alterar usuario ?>
        
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
    
    
    
 <? if ($_GET["cod"]){  // Alterar usuario ?>
          <input type="button" name="btn_salvar" value="Alterar usuario" onclick="alterar_usuario(this.form,'<?= $_GET["cod"] ?>');" style="margin-right:5px;"   class="botao" onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"   >
     <? }else{  //Adicionar Novo usuario ?>
              <input type="button" name="btn_salvar" id="btn_salvar" value="Incluir usuario" onclick="adicionar_usuario(this.form);" style="margin-right:5px;"   class="botao" onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"   >
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
<? 
$layout = new layout;
$layout -> cabecalho();
$layout -> js("..");

$layout -> grey_box();
echo '<style>table tr td {font-family:Verdana, Geneva, sans-serif;font-size:12px;}</style>';
$layout -> css("..");
$layout -> set_body('document.forms[0].senha_atual.focus();','','');
create_table_extjs("350px","120px","Alterar Minha Senha");


?>

<form name="form1" id="form1" method="post">
<center>
  <table style="width:92%;height:92%"   cellpadding="0" cellspacing="2">

    <tr nowrap="nowrap" class="aviso">          
              <td nowrap="nowrap" width="150px;" style="color:#000;"><div align="right"> Senha Atual &nbsp;</div> </td>
<td colspan="5" nowrap="nowrap">
                <input name="senha_atual" type='password' value='' maxlength="32" class="x-form-text x-form-field" id="senha_atual" style="width:120px;"   autocomplete="off"  /></td>
     </tr>
    <tr nowrap="nowrap">          
              <td nowrap="nowrap" ><div align="right"> Nova Senha &nbsp;</div> </td>
<td colspan="5" nowrap="nowrap">
                <input name="senha" type='password' value='' maxlength="32" class="x-form-text x-form-field" id="senha" style="width:120px;"   autocomplete="off"   /></td>
     </tr>
    <tr nowrap="nowrap">          
              <td nowrap="nowrap" ><div align="right"> Confirmar Nova Senha &nbsp;</div> </td>
<td colspan="5" nowrap="nowrap"><input name="confirmar_senha" type='password' value='' maxlength="32" class="x-form-text x-form-field" id="confirmar_senha" style="width:120px;"   autocomplete="off"  /></td>
     </tr>
     
     <tr nowrap>
     <td colspan="6" align="right" nowrap="nowrap">
  
       <input type="button" name="btn_salvar" id="btn_salvar" value="Alterar Senha" class="botao"  onclick="alterar_senha(this.form);" style="margin:5px 5px 0 10px">  
       <input type="reset" name="btn_reset" id="btn_reset" value="Limpar" class="botao" style="margin-right:10px;">
    
          </td>
    </tr>
  </table>
  </center>
</form>
<iframe frameborder="0" NAME="grid_iframe" WIDTH="1" HEIGHT="1" style="display:none" >No Inlineframes</iframe>  
<? end_table_extjs();?>
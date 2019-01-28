<? 
session_start();
// ----------------- no cache----------------------------
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT"); 
@header("Last-Modified: {$gmtDate} GMT"); 
@header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 


require_once ("./connections/connections.php");	
require_once ("./funcoes.php");		
require_once ("./class.php");	
	




	
		//comprimir_PHP_start();
$layout = new layout;

$layout -> css('..');	
$layout -> js('..');
$layout -> jquery('..');



echo '<style>table tr td {font-family:Verdana, Geneva, sans-serif;font-size:12px;}</style>';

$layout -> body_onload('','','');
create_table_extjs("450px","100%","Fale Conosco");


?>
<style>
body {
	background-image:none;
}
</style>
<form method="post">
  <center>
    <table style="width:92%;height:92%"   cellpadding="0" cellspacing="2">
      <tr nowrap="nowrap">
        <td nowrap="nowrap"   style="width:90px;"><div align="right"> Seu nome &nbsp;</div></td>
        <td colspan="5" nowrap="nowrap"><INPUT type="text"  class="input" NAME="nome" id="nome"   style="width:300px"   value="" maxlength="180" autocomplete="off" ></td>
      </tr>
      <tr nowrap="nowrap">
        <td nowrap="nowrap" ><div align="right"> Seu email &nbsp;</div></td>
        <td colspan="5" nowrap="nowrap"><INPUT type="text"  class="input" NAME="email" id="email"   style="width:300px"   value="" maxlength="180" onBlur="check_mail(this.name);" autocomplete="off" ></td>
      </tr>
      <tr nowrap="nowrap">
        <td nowrap="nowrap" ><div align="right"> Assunto  &nbsp;</div></td>
        <td colspan="5" nowrap="nowrap"><select name="assunto">
            <option value="Sugestão">Sugestão</option>
            <option value="Observação">Observação</option>
            <option value="Dúvida">Dúvida</option>
          </select></td>
      </tr>
      <tr nowrap="nowrap">
        <td nowrap="nowrap" ><div align="right"> Mensagem</div></td>
        <td colspan="5" nowrap="nowrap"><textarea name="mensagem" style="width:300px;height:100px;"></textarea></td>
      </tr>
      <tr nowrap>
        <td colspan="6" align="right" nowrap="nowrap"><input type="button" name="btn_salvar" id="btn_salvar" value="Enviar" class="botao"  onclick="fale_conosco(this.form)" style="margin:5px 5px 0 10px"></td>
      </tr>
    </table>
  </center>
</form>
<iframe frameborder="0" NAME="grid_iframe" WIDTH="1" HEIGHT="1" style="display:none" >No Inlineframes</iframe>
<? end_table_extjs('..'); ?>

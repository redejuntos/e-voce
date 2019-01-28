<? 
echo '<style>table tr td {font-family:Verdana, Geneva, sans-serif;font-size:12px;}</style>';
echo '</HEAD><BODY>';

$id = $_GET["id"];

echo $id;


create_table_extjs("99%","130px","Alterar Usuário");?>

<form name="form1" id="form1" method="post">
<? require("form_usuarios.php"); ?>
  <tr nowrap>
    <td colspan="6" align="right"><input type="button" name="btn_salvar" id="btn_salvar" value="Adicionar Usu&aacute;rio" class="botao"  onclick="adicionar_usuario(this.form);" style="margin-right:5px;">
      <input type="reset" name="btn_reset" id="btn_reset" value="Limpar" class="botao"  onclick="" style="margin-right:30px;"></td>
  </tr>
</table>
<? end_table_extjs();?>

 </form>
<script language="JavaScript"><!--
function deleteOption(object,index) {
    object.options[index] = null;
}

function addOption(object,text,value) {
    var defaultSelected = true;
    var selected = true;
    var optionName = new Option(text, value, defaultSelected, selected)
    object.options[object.length] = optionName;
}

function copySelected(fromObject,toObject) {
    for (var i=0, l=fromObject.options.length;i<l;i++) {
        if (fromObject.options[i].selected)
            addOption(toObject,fromObject.options[i].text,fromObject.options[i].value);
    }
    for (var i=fromObject.options.length-1;i>-1;i--) {
        if (fromObject.options[i].selected)
            deleteOption(fromObject,i);
    }
}

function copyAll(fromObject,toObject) {
    for (var i=0, l=fromObject.options.length;i<l;i++) {
        addOption(toObject,fromObject.options[i].text,fromObject.options[i].value);
    }
    for (var i=fromObject.options.length-1;i>-1;i--) {
        deleteOption(fromObject,i);
    }
}

function teste(fromObject) {
  var sTeste = '';
    for (var i=0, l=fromObject.options.length;i<l;i++) {
    if (i>0) {sTeste += '|';}
    sTeste += fromObject.options[i].value;
    }
    return sTeste;
}

function teste2(frmElem){
  var sTeste = '';
  for ( i=0 ; i < frmElem.length; i++ ){
    if (frmElem[i].checked){
      if (sTeste.length>0) {sTeste += '|';}
         sTeste += frmElem[i].value;
    }
  }
  return sTeste;
}
//-->
</script>
<?
$all_vetor = array("convite","nome","empresa_orgao","cargo","setor_depto","telefone","celular","data","atualizado","tipo","apelido","email","fax","endereco","bairro","cep","cidade","estado","site","secretaria","outro_email","aniversario","interesse","contato");

if (($_SESSION["table"]=="contato")&&(count($_SESSION["activate_filtro"])>0)){	
	$mostra_vetor=$_SESSION["activate_filtro"];
	$hide_vetor = array_diff($all_vetor,$_SESSION["activate_filtro"]);
}else{
	$mostra_vetor = $_SESSION["listfield_vetor"];
	$hide_vetor = array_diff($all_vetor,$_SESSION["listfield_vetor"]);
	
}

?>
<form name="form_filtro"  method="POST">
<table border="0" cellspacing="0" cellpadding="0"  >
  <tr>
    <td rowspan="5" align="center"> Mostrar Campos:<br>
      <select name="mostrar" multiple size="7" style="WIDTH: 200px;">
	  <?
	   foreach($mostra_vetor as $a => $b){
		   if ($b != "id") 	echo '<option value="'.$b.'">'.$b.'</option>';
	   }
	  ?>
      </select>
    </td>
    <td align="center"></td>
    <td rowspan="5" align="center"> Esconder Campos: <br>
      <select name="Filtro" style="WIDTH: 200px;" multiple size="7">
	  <?
	   foreach($hide_vetor as $a => $b){
	 	  if ($b != "id") 	echo '<option value="'.$b.'">'.$b.'</option>';
	   }
	  ?>
	  
      </select>
    </td>
  </tr>
  <tr>
    <td align="center"><input type="button" value=" > " onClick="if (document.images) copySelected(this.form.mostrar,this.form.Filtro)"></td>
  </tr>
  <tr>
    <td align="center"><input type="button" value=" < " onClick="if (document.images) copySelected(this.form.Filtro,this.form.mostrar)"></td>
  </tr>
  <tr>
    <td align="center"><input type="button" value=">>" onClick="if (document.images) copyAll(this.form.mostrar,this.form.Filtro)"></td>
  </tr>
  <tr>
    <td align="center"><input type="button" value="<<" onClick="if (document.images) copyAll(this.form.Filtro,this.form.mostrar)"></td>
  </tr>
   <tr>
    <td align="center" colspan="3">
	<input type='hidden' name="campos_visiveis" value="">
	<input type='button' onClick="setForm();" value="atualizar">
	</td>
  </tr>
</table>
</form>
<script language="javascript">
<!--//
self.focus();

function setForm(){
	document.form_filtro.campos_visiveis.value=teste(document.form_filtro.mostrar);
	document.form_filtro.action='./operacoes.php?filtra_tabela=yes';
	document.form_filtro.method="POST";
	document.form_filtro.target="grid_iframe";
	document.form_filtro.submit();
	
	//self.close();
	return false;
}
//-->
</script>

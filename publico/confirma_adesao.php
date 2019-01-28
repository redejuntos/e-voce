<? 



if ($_SESSION["id_participante_session"]){  // se está logado


	$sql_adesao = "SELECT termo_adesao,cpf,data_nascimento	FROM participantes WHERE id_participante = '".$_SESSION["id_participante_session"]."'  LIMIT 1 ";
	
	$rs_adesao = get_record($sql_adesao);
	$termo_adesao = $rs_adesao["termo_adesao"];
	$cpf = $rs_adesao["cpf"];
	$data_nascimento = $rs_adesao["data_nascimento"];
			
	if (($termo_adesao != 'S')||($cpf == "")||($cpf == "0")||($data_nascimento == "")||($data_nascimento == "0000-00-00")){
?>
<form name="adesao_form">
<br>


<center>
<div style="height:470px;width:900px;background-color:#FFF;border-radius:10px;text-align:left;box-shadow: 5px 5px 0 #ccc;padding:15px;background-color:#eee;">

<div style="height:400px;width:900px;overflow:scroll"> 

<?
require_once("termo_uso.php");

?>

</div>



<div style="text-align:center">





<?
if (($data_nascimento == "")||($data_nascimento == "0000-00-00")){
?>
   <label>Data de Nascimento *</label>                         
       <input  name="data_nascimento"  id="data_nascimento"  class="date_field"  type="text"   style="width:80px;"   onblur="newDataValidate(this);"   onkeypress="return txtBoxFormat(this.form, this.name, '99/99/9999', event);"  onChange="calcula_idade(this.form,this);"  maxLength="10" placeholder="Dt. Nasc."  value=""   />
       
      
<?
}
?>    
        
        

<?
if (($cpf == "")||($cpf == "0")){
?>

        <label >CPF *</label>   
   <INPUT type="text"   name="cpf" style="width:150px;"    maxlength="14" onKeyPress="return txtBoxFormat(this.form, this.name, '999.999.999-99', event);"  onblur="validaCPF(this);"  placeholder="Digite seu CPF" onChange="verifica_cpf_adesao(this.value);" >
<?
}
?>

<input type="hidden" name="valid_request_termo_adesao" value="1">

<input type="checkbox" name="adesao" value="yes">Li e estou de acordo com os termos de uso 
<br>
<br>
<img src="./images/bt-enviar.gif" onClick="confirma_adesao();" style="cursor:pointer">
<img src="./images/bt-voltar.gif" onClick="location.href='index.php'" style="cursor:pointer">
</div>


</div>
</center>


</form>
<iframe frameborder="0" NAME="grid_iframe" WIDTH="1" HEIGHT="1" style="display:none" >No Inlineframes</iframe>  

<?
	exit();
	}
}
?>
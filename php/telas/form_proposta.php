

<table style="margin:2px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">
<tr>
  <td colspan="6" style="width:97%">
  <div id="tabs" style="width:97%">
    <ul>
      <li><a href="#tabs-1">Proposta</a></li>

      <li><a href="#tabs-3">
      
      <?
	  if ($rs["media_flag"] == "F"){
		  echo "Foto";
	  }else{
		  echo "Vídeo";
	  }
	  
	  
	  ?>
      
      
      
      </a></li>
    
    </ul>
    <div id="tabs-1" style="width:97%;">
      <!-- ----------------------------- ------------------------------------------------    -->
      <table style="margin:2px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">
        <tr><td  nowrap><div align="right">Titulo da Proposta</div></td>
         				 <td colspan="5"><input name="nome_contribuicao" type="text" class="x-form-text x-form-field"  style="width:100%;" value="<?= $rs["nome_contribuicao"] ?>"  maxlength="180"   /></td></tr>
        
             
        
        <tr nowrap="nowrap">
          <td nowrap="nowrap"   ><div align="right">Descrição</div></td>
          <td colspan="5" nowrap="nowrap" style="width:100%;"><textarea style="width:100%;height:300px;" rows="5" wrap="soft" name="descricao" class="x-form-text x-form-field" id="descricao"><?=  $rs["descricao"]?$rs["descricao"]:$descricao ?>
</textarea>
</td>
        </tr>      

        
        
        <tr>
 <td colspan="6" align="right">
          <input type="button" name="btn_salvar" value="Alterar" onclick="alterar_proposta(this.form,'<?= $_GET["id_contribuicao"] ?>','<?= $_GET["go_to_page"] ?>');" style="margin-right:5px;"   class="botao" onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"   >          
     
     
     <input type="button" name="btn_reset" id="btn_reset" value="Limpar" class="botao"  onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"  style="margin-right:30px;" onclick="limpa_form(this.form)">  
      </td>
        
      </table>
      
      <!-- ----------------------------- ------------------------------------------------    -->
    </div>

    
    <div id="tabs-3" style="width:97%;">
      <!-- ----------------------------- ------------------------------------------------    -->
      

      
      <table style="width:95%;" cellpadding="2" cellspacing="2">
    
      <tr nowrap="nowrap">
              <td colspan="6"  style="width:100%;text-align:center">
              
<?
		  if ($rs["media_flag"] == 'V'){ //video youtube					
				  echo youtube_embed($rs["youtube_link"],'546px','306px');					
		  }else{
				  echo '<a class="fancybox" href="../publico/'.$rs["caminho_arquivo"].'/'.$rs["arquivo"].'"><img src="../publico/'.$rs["caminho_arquivo"].'thumb'.$rs["arquivo"].'"   title="Clique para aumentar" style="border:0;width:280px;height:180px"></a></span>';								
		  }	
?>
              
              </td>
            </tr>  
    
    </table>
    
  <table style="margin:5px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0" id="fotos_container">  

  </table>
    
      <!-- ----------------------------- ------------------------------------------------    -->
    </div>
    
    
    
    
    
    </div>
    </td>
</tr>

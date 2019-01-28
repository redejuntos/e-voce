

<table style="margin:2px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">
<tr>
  <td colspan="6" style="width:97%">
  <div id="tabs" style="width:97%">
    <ul>
      <li><a href="#tabs-1">Tópicos</a></li>

      <li><a href="#tabs-3">Fotos</a></li>
      <li><a href="#tabs-4">Vídeos</a></li>
    </ul>
    <div id="tabs-1" style="width:97%;">
      <!-- ----------------------------- ------------------------------------------------    -->
      <table style="margin:2px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">
        <tr><td  nowrap><div align="right">Nome Tópico</div></td>
         				 <td colspan="5"><input name="nome_topico" type="text" class="x-form-text x-form-field"  style="width:100%;" value="<?=  $rs["nome_topico"]?$rs["nome_topico"]:$nome_topico ?>"  maxlength="180"   /></td></tr>
        
             
        
        <tr nowrap="nowrap">
          <td nowrap="nowrap"   ><div align="right">Descrição</div></td>
          <td colspan="5" nowrap="nowrap" style="width:100%;"><textarea style="width:100%;height:300px;" rows="5" wrap="soft" name="descricao" class="x-form-text x-form-field" id="descricao"><?=  $rs["descricao"]?$rs["descricao"]:$descricao ?>
</textarea>
</td>
        </tr>      
        
        
  <tr nowrap="nowrap">       
          <td nowrap="nowrap"   ><div align="right">Escolher Mídia</div></td>
          <td colspan="5" nowrap="nowrap" style="width:100%;">
          
          <select name="media_flag">
          <option value="V" <? if ($rs["media_flag"] == 'V')echo 'selected'; ?> >Vídeo</option>
          <option value="F" <? if ($rs["media_flag"] == 'F')echo 'selected'; ?> >Foto</option>
          
          </select>
          
          
          &nbsp;</td>
        </tr>
        
        
      <td  nowrap><div align="right">nº</div></td><td colspan="5">
						  <input name="nro_topico"  id="nro_topico"  type="text" class="x-form-text x-form-field"  style="width:25%;"      maxlength="14"        value="<?=  $rs["nro_topico"]?$rs["nro_topico"]:nro_topico ?>"  />    </td>
					</tr>






        <tr>
            <td  nowrap><div align="right">Desafio</div></td>
            <td colspan="5">
            <select name="id_desafio" id="id_desafio"  class="x-form-text x-form-field" >
           <?= get_desafio_combo($rs["id_desafio"]) ?>
            </select>
            </td>
       </tr>
        
        
        <tr>
 <td colspan="6" align="right">
          <input type="button" name="btn_salvar" value="Alterar Tópico" onclick="alterar_topico(this.form,'<?= $_GET["cod"] ?>');" style="margin-right:5px;"   class="botao" onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"   >          
     
     
     <input type="button" name="btn_reset" id="btn_reset" value="Limpar" class="botao"  onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"  style="margin-right:30px;" onclick="limpa_form(this.form)">  
      </td>
        
      </table>
      
      <!-- ----------------------------- ------------------------------------------------    -->
    </div>

    
    <div id="tabs-3" style="width:97%;">
      <!-- ----------------------------- ------------------------------------------------    -->
      

      
      <table style="width:95%;" cellpadding="2" cellspacing="2">
    
      <tr nowrap="nowrap">
              <td colspan="6"  style="width:100%;">
              
 <div id="container" align="right"> 
          <div id="filelist" style="font-size:10px;border:1px solid #FFF;background-color:#FFC;color:#000;text-align:left;text-indent:10px;width:520px;"></div>
        </div>
              
              </td>
            </tr>         
            
    
    <tr nowrap>
      <td colspan="6" align="center">
      
      
  <input id="pickfiles" type="button" class="botao" style="width: 350px;" value="Procurar Arquivos no Meu Computador"  />

        
   
        </td>
    </tr>
    
    </table>
    
  <table style="margin:5px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0" id="fotos_container">  

  </table>
    
      <!-- ----------------------------- ------------------------------------------------    -->
    </div>
    
    
	
 <div id="tabs-4" style="width:97%;">
      <!-- ----------------------------- ------------------------------------------------    -->
      <table style="width:95%;" cellpadding="2" cellspacing="2">
            
      <tr nowrap>
<td rowspan="4" align="right">
        
        
   <fieldset style="border:1px solid #9cbde9;vertical-align:top;margin:0px 2px 0px 2px;height:100%;width:250px;">
     <legend>Preview</legend>
     <center>
       <span id="objectspan">
  <object type="application/x-shockwave-flash" style="width:246px; height:142px;" data=""  id="preview_video"><param name="movie" value=""  id="preview_video2" /></param>
  <param name="wmode" value="transparent"></param><embed src="" type="application/x-shockwave-flash" wmode="transparent" width="246" height="142"  id="preview_video3"></embed>
  </object>
  </span>
  </center>
   </fieldset>        	</td>
<td colspan="4" align="left">&nbsp; 
</td>
<td rowspan="5">
    </td>
</tr>      
    
    <tr nowrap>
    	<td colspan="4" align="center">  
    	  <div align="left" style="width:100%">
          <img src="../images/delete.gif" align="absmiddle" style="cursor:pointer" onClick="document.forms[0].myYouTubePlayer.value='';"   >          
    	    <input type="text" name="myYouTubePlayer" id ="myYouTubePlayer"  style="min-width:50%"  onblur="valida_youtube(this.value)" class="x-form-text x-form-field">            
             <input type="button" class="botao" style="width: 40%;" value="Adicionar Vídeo" onclick="adicionar_video_topico(this.form)"  />
  	    </div>
        </td>
        </tr>
   <tr nowrap>
<td colspan="4" align="left">    Insira o link do seu v&iacute;deo no YouTube 
</tr>
    <tr nowrap>
      <td colspan="4" align="left" valign="top"></td>
    </tr>
 
    
<tr nowrap>
<td align="right"></td>
<td colspan="4" align="left">    
</td>
</tr>

    
    
      <tr><td colspan="5">
      
      
        <table style="margin:5px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0" id="videos_container"></table>
      
      </td></tr> 
    
    
    </table>
      <!-- ----------------------------- ------------------------------------------------    -->
    </div>
    
    
    
    </div>
    </td>
</tr>

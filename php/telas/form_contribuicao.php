

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
      
        <tr><td  nowrap><div align="right">Titulo da Execução</div></td>
         				 <td colspan="5"><input name="nome_contribuicao" type="text" class="x-form-text x-form-field"  style="width:100%;" value="<?= $rs["nome_contribuicao"] ?>"  maxlength="180"   /></td></tr>
        
        <tr>
            <td  nowrap><div align="right">Desafio</div></td>
            <td colspan="5">
            <select name="id_desafio" id="id_desafio"  class="x-form-text x-form-field" >
           <?= get_desafio_combo($id_desafio) ?>
            </select>
            </td>
       </tr>
       
       
        <tr>
            <td  nowrap><div align="right">Membro</div></td>
            <td colspan="5">
            <select name="id_participante" id="id_participante" class="x-form-text x-form-field" >
           <?= get_participante_combo($id_participante) ?>
            </select>
            </td>
       </tr>   
       
       
        
        
        <tr nowrap="nowrap">
          <td nowrap="nowrap"   ><div align="right">Descrição</div></td>
          <td colspan="5" nowrap="nowrap" style="width:100%;"><textarea style="width:100%;height:300px;" rows="5" wrap="soft" name="descricao" class="x-form-text x-form-field" id="descricao"><?=  $rs["descricao"]?$rs["descricao"]:$descricao ?>
</textarea>
</td>
        </tr>      

        
        
        <tr>

        
      </table>
      
      <!-- ----------------------------- ------------------------------------------------    -->
    </div>

    
    <div id="tabs-3" style="width:97%;">
      <!-- ----------------------------- ------------------------------------------------    -->
      

      
      <table style="width:95%;" cellpadding="2" cellspacing="2">
    
      <tr nowrap="nowrap">
              <td colspan="6"  style="width:100%;text-align:center">
              
              
               <strong>Escolher Mídia </strong>
                  <input name="media_flag" type="radio" value="F" onClick="escolher_media(this,1)">
                  Imagem
                  <input name="media_flag"  type="radio" value="V" onClick="escolher_media(this,1)">
                  Vídeo <br>
 <br>
                  <div id="media_video1" style="display:none"> <strong>Link do YouTube</strong>
                    <spam style="font-size:13px"></spam>
                    <br>
                http://    <input type="text" style="width:440px;"  class="x-form-text x-form-field" name="myYouTubePlayer" id ="myYouTubePlayer"  onblur="valida_youtube(this.value,this.form,1)">
                    <div id="objectspan1">
                    <object type="application/x-shockwave-flash" style="width:440px; height:260px;" data=""  id="preview_video_1">
                      <param name="movie" value=""  id="preview_video2_1" />
                      </param>
                      <param name="wmode" value="transparent">
                      </param>
                      <embed src="" type="application/x-shockwave-flash" wmode="transparent" width="440px" height="260px"  id="preview_video3_1"></embed>
                    </object>
                    </div> </div>
                  <div id="media_foto1" style="display:none"> <strong>Imagem</strong>
                    <spam style="font-size:13px"></spam>
                    <br>
                    <input type="file" style="width:100%;" class="x-form-text x-form-field" name="foto">
                  </div>       
                  
  <input type="hidden" name="enviar_contribuicao" value="1">

					<input type="hidden" name="fase_atual" value="4">
                  
                  
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

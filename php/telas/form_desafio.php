

<table style="margin:2px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">
<tr>
  <td colspan="6" style="width:97%">
  <div id="tabs" style="width:97%">
    <ul>
      <li><a href="#tabs-1">Desafio</a></li>
      <li><a href="#tabs-2">Vincular Fases</a></li>
      <li><a href="#tabs-3">Fotos</a></li>
      <li><a href="#tabs-4">Vídeos</a></li>
    </ul>
    <div id="tabs-1" style="width:97%;">
      <!-- ----------------------------- ------------------------------------------------    -->
      <table style="margin:2px 2px 0 2px;width:97%" cellpadding="1" cellspacing="0">
        <tr >
          <td   nowrap><div align="right">Nome Desafio</div></td>
          <td colspan="5">          
          <input name="nome_desafio" type="text" class="x-form-text x-form-field"  style="width:100%;" value="<?= $rs["nome_desafio"]?$rs["nome_desafio"]:$nome_desafio  ?>"  maxlength="180"   />
          
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
        <tr nowrap="nowrap">
          <td nowrap="nowrap"   ><div align="right">Descrição</div></td>
          <td colspan="5" nowrap="nowrap" style="width:100%;"><textarea style="width:100%;height:300px;" rows="5" wrap="soft" name="descricao" class="x-form-text x-form-field" id="descricao"><?=  $rs["descricao"]?$rs["descricao"]:$descricao ?>
</textarea>
</td>
        </tr>      
        
        
 <td colspan="6" align="right">
          <input type="button" name="btn_salvar" value="Alterar Desafio" onclick="alterar_desafio(this.form,'<?= $_GET["cod"] ?>');" style="margin-right:5px;"   class="botao" onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"   >          
     
     
     <input type="button" name="btn_reset" id="btn_reset" value="Limpar" class="botao"  onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"  style="margin-right:30px;" onclick="limpa_form(this.form)">  
      </td>
        
      </table>
      
      <!-- ----------------------------- ------------------------------------------------    -->
    </div>
    <div id="tabs-2">
      <!-- ----------------------------- ------------------------------------------------    -->
      
      
             <span align="right">Data Início</span>
			<input  name="data_inicio"  id="data_inicio" type="text" class="x-form-text x-form-field date_field"  style="width:90px;"   onblur="newDataValidate(this)" onkeypress="return txtBoxFormat(this.form, this.name, '99/99/9999', event);"   title="Dia / Mês / Ano"  maxLength="10"  value="<?= $rs["data_inicio"]?data_br($rs["data_inicio"]):$data_inicio  ?>"  /> 
				<span align="right">Data Fim</span>
						  <input  name="data_fim"   id="data_fim"  value="<?= $rs["data_fim"]?data_br($rs["data_fim"]):$data_fim  ?>" type="text" class="x-form-text x-form-field date_field"  style="width:90px;"   onblur="newDataValidate(this)" onkeypress="return txtBoxFormat(this.form, this.name, '99/99/9999', event);"   title="Dia / Mês / Ano"  maxLength="10"   /> 
      
      
      
      <table style="margin:10px 10px 0 0px;width:250px;border:1px solid #dfe8f6" cellpadding="1" cellspacing="2">
      
      
  
      
      				  <tr class="fundo3" ><td style="border-left:1px solid #8db2e3;border-right:1px solid #8db2e3;width:150px;text-align:center;font-weight:bold;">Fases</td><td colspan="5" style="border-left:1px solid #8db2e3;border-right:1px solid #8db2e3;text-align:center;width:80px;font-weight:bold;" > Data Inicial</td></tr>
         
                  <? 
$sql = "select a.id_fase,a.nome_fase,b.data_inicio from fases as a
LEFT outer join desafios_x_fases AS b ON (a.id_fase = b.id_fase AND b.id_desafio='".$cod."')
where (a.data_cancelamento is NULL) 
order by a.ordem;";		
	if (numrows($sql)>0){
			$result = return_query($sql);
			$x =0;
			while( $rs = db_fetch_array($result) ){		
					$cor = ($x%2==0)?'#eaeff7':'#F8F9FC';
					echo '<tr nowrap="nowrap"><td style="background-color:'.$cor.';" ><div align="right" >'.$rs["nome_fase"].'</div></td><td  colspan="5" nowrap="nowrap" style="text-align:center;">  ';					
					$data_inicio = ($rs["data_inicio"]) ?data_br($rs["data_inicio"]):"";
					?>
<input  name="data_fase[<?=  $rs["id_fase"] ?>]"  type="text" class="x-form-text x-form-field date_field"  style="width:90px;"   onblur="valida_data_fase(this)" onChange="valida_data_fase(this)"   onkeypress="return txtBoxFormat(this.form, this.name, '99/99/9999', event);"   title="Dia / Mês / Ano"  maxLength="10"  value="<?= $data_inicio ?>"  />
                    <?
					echo '</td></tr>';   
					$x++;
			}
	}
				  ?>   
                  
        

        
      </table>
      
     <input type="button" name="btn_reset" id="btn_reset" value="Limpar" class="botao"  onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'" style="float:right;"  onclick="limpa_form(this.form)">  
          <input type="button" name="btn_salvar" value="Alterar Desafio" onclick="alterar_desafio(this.form,'<?= $_GET["cod"] ?>');" style="float:right;"   class="botao" onMouseOver="this.className='botao_hover'" onMouseOut="this.className='botao'"   >          
     
     
<br>
    
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
          <img src="../images/delete.gif" align="absmiddle" style="cursor:pointer" onClick="document.forms[0].myYouTubePlayer.value='';" >          
    	    <input type="text" name="myYouTubePlayer" id ="myYouTubePlayer"  style="min-width:50%"  onblur="valida_youtube(this.value)" class="x-form-text x-form-field">      
               
             <input type="button" class="botao" style="width: 40%;" value="Adicionar Vídeo" onclick="adicionar_video(this.form)"  />
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

 <form name="cadastro_form" id="cadastro_form"  method="post" >
        <h3>Faça seu Cadastro</h3>

        
        
  <a href="https://www.facebook.com/dialog/oauth?client_id=190436047799972&scope=email,user_birthday,user_hometown&redirect_uri=<?= InfoSystem::url_site ?>" class="facebook-trace" title="Login with your Facebook account">  <img src="./images/connect_light_medium_long.gif" alt="Connect" border="0" /> </a>
        
        
        <br>
        
        
        <table border="0px solif #fff">
        
        <tr><td colspan="3">
        <label style="color:#FFF" >Nome *</label> <br>
        <input name="nome_participante" class="autofocus login-inputs" placeholder="Nome completo"   style="width:340px" />
        </td></tr>
        
        
        
        
               
        <tr><td >
      

          <label style="color:#FFF" >Telefone / Celular *</label>          <br> 
   <input name="telefone" id="telefone" type="text"  style="width:120px;"    maxlength="15"    onkeypress="return txtBoxFormat(this.form, this.name, '(99) 9999-9999', event);"  placeholder="(xx) xxxx-xxxxx"  />
   
   </td>  <td colspan="2">
       <label style="color:#FFF" >CPF *</label>          <br> 
       
       
   <INPUT type="text"  class="input"  name="cpf" style="width:150px;"  value="" maxlength="14" onKeyPress="return txtBoxFormat(this.form, this.name, '999.999.999-99', event);"  onblur="validaCPF(this);"  placeholder="CPF" onChange="verifica_cpf(this.value);" >	
       
       

  
   </td>
        </tr>      
        
        <!--
        
        <tr><td colspan="3">
    <select   name="estado"   id="estado" onChange="atualiza_conteudo('./php/ajax_open_data.php','cod_estado='+this.value,'POST','handleHttpResponseCidade2')">
      <? 		  
		  echo get_uf($rs["estado"]);
		  ?>
    </select>
    

   <select  name="id_municipio"  id="id_municipio">  
     <? get_municipios('',''); ?>
   </select>
   
        </td></tr>      
        
        -->      
        <tr><td style="color:#fff;" colspan="3">
        <label style="color:#FFF" >Data de Nascimento *</label>                           <br>
       <input  name="data_nascimento"  class="date_field"  type="text"   style="width:90px;"   onblur="newDataValidate(this);"   onkeypress="return txtBoxFormat(this.form, this.name, '99/99/9999', event);"  onChange="calcula_idade(this.form,this);"  maxLength="10" placeholder="Nascimento"  />
       
        <input name="idade" id="idade" type="text"   style="width: 150px;border:0px;background-color:#000;color:#FFF;font-weight:bolder" maxlength="30" readonly />       
        </td></tr>   
        
        <tr><td colspan="3">
        <label style="color:#FFF" >E-mail *</label> <br>
        <input name="email" class="autofocus login-inputs" placeholder="E-mail"  style="width:340px"  onchange="verifica_email(this.value)";  maxlength="180"   onBlur="check_mail(this);" /> 
        </td></tr>
        
        <tr><td colspan="3">
        <label style="color:#FFF" >Confirme seu E-mail *</label> <br>
        <input name="confirmar_email" class="autofocus login-inputs" placeholder="Redigite seu E-mail" style="width:340px"  maxlength="180"   onBlur="check_mail(this);" />  
        </td></tr>

        <tr><td>
      
    <label style="color:#FFF">Senha *  <em>(min 8 dígitos)</em></label> <br>
        <input id="senha" name="senha" placeholder="Digite sua senha" type="password" class="login-inputs" style="width:150px" autocomplete="off" /> 
      
        </td>
          <td colspan="2">     <label for="password" style="color:#FFF">Código de validação</label> <br>      <img src="./php/captcha.php"  align="middle" id="captcha_image">  <img src="./images/button_refresh.png" align="texttop" style="cursor:pointer" onClick="refresh_captcha();" title="Refresh sua Captcha Imagem">
          
          </td>
        </tr>
        
        <tr><td>
    
    <label for="password" style="color:#FFF">Confirmar Senha *</label> <br>
        <input id="confirmar_senha" name="confirmar_senha" placeholder="Redigite sua senha" type="password"  style="width:150px"  autocomplete="off"  />
        
        </td>
          <td colspan="2"> 
               <label style="color:#FFF" >Redigite código acima *</label> <br>
   <input type="text"  style="width:135px" maxlength="9" name="captcha"  value=""> </td>
        </tr>

        <tr><td>
         
        </td>
          <td colspan="2">          
          <center>          
          <div style="background-image:url(images/fundo_button.png);width:109;height:30;text-align:center;line-height:30px;font-weight:bolder;color:#FFF;cursor:pointer;" onClick="cadastrar_participante(document.cadastro_form)">Cadastrar</div>          
          </center>          
          </td>
        </tr>        

        </table>
        
        
        <input type="hidden" name="valid_request_cadastrar_participante" value="1">
      </form>
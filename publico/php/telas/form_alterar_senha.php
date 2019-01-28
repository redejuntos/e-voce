      <form  name="alterar_senha_form_window"  method="post" >
        <h3>Alterar Minha Senha</h3>   

        <label style="color:#FFF">Digite Nova Senha *</label> <br>
        <input id="senha" name="senha" placeholder="Digite sua senha" type="password" class="login-inputs" style="width:200px"  /> <br>
        
        <input type="hidden" name="alterar_senha_check_post" value="1" >
       
        
<label for="password" style="color:#FFF">Confirmar Senha *</label> <br>
        <input id="confirmar_senha" name="confirmar_senha" placeholder="Redigite sua senha" type="password"  style="width:200px"  />
        
       


      

               <center>    
          <div style="background-image:url(images/fundo_button.png);width:109;height:30;text-align:center;line-height:30px;font-weight:bolder;color:#FFF;cursor:pointer;" onClick="alterar_senha(document.alterar_senha_form_window)">Alterar Senha</div>          
          </center>         
       
          
      
      </form>
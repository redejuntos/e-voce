      <form id="login-form" name="login_form"  method="post" >
        <h3>Faça seu Login</h3>
        <a href="https://www.facebook.com/dialog/oauth?client_id=190436047799972&scope=email,user_birthday,user_hometown&redirect_uri=<?= InfoSystem::url_site ?>" class="facebook-trace" title="Login with your Facebook account"> <img src="./images/connect_light_medium_long.gif" alt="Connect" border="0" /> </a><br>
        <label style="color:#FFF" >Email</label><br>
        <input name="login_email"  placeholder="Email" size="30" tabindex="1" /><br>
        <span style="float:right"><a title="Clique aqui para resetar sua senha." style="color:#09F;font-weight:bolder;cursor:pointer;"     id="esqueci_senha_btn">Esqueci minha senha?</a></span>
        <input type="hidden" name="logar_comunidade" value="1">
  
        
        <label  style="color:#FFF">Senha</label>
        <input  name="senha" placeholder="Por favor, entre com sua senha" type="password"  size="30" tabindex="2"  onKeyPress="  if (window.event && window.event.keyCode == 13) {login_website(document.login_form)}"  autocomplete="off"  />
        <div > 
        
        
        <table><tr><td>   
                  <div style="width:100px;">
                  <!--
              <label  style="color:#fff"> Relembrar senha
                <input type="checkbox" name="relembrar_me"  tabindex="3" />
              </label>  -->
              </div>
              </td><td>
               <center>    
          <div style="background-image:url(images/fundo_button.png);width:109;height:30;text-align:center;line-height:30px;font-weight:bolder;color:#FFF;cursor:pointer;"  onClick="login_website(document.login_form)" >Login</div>          
          </center>         
              </td></tr></table>
              
        </div>
        <b style="color:#FFF;font-size:14px;font-family:Verdana, Geneva, sans-serif"> Novo usuário? <a  style="color:#09F;cursor:pointer;" id="cadastrar_form_btn">Cadastre-se</a> </b>
      </form>
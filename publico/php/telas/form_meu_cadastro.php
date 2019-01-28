 <?
 session_start();
 if ($_SESSION["id_participante_session"]){	 
	 $sql = "select nome_participante,email,login,endereco,numero,cpf,telefone,id_municipio,data_nascimento,avatar,facebook_id,facebook_page from participantes where id_participante = '".$_SESSION["id_participante_session"]."'  LIMIT 1";
		if ($rs = get_record($sql)){				
			  if (trim($rs["avatar"])){
				   $image_avatar = $rs["avatar"];
			  }else{
				  	if($rs["facebook_id"]){
						$image_avatar = 'https://graph.facebook.com/'.$rs["facebook_id"].'/picture?width=200&height=200';						
					}else{
						$image_avatar = './images/avatar.jpg';				 		 
					}
			  }		
		}
 } 
		
		
 ?>
 
<form name="tela_meu_cadastro_form"  method="post" >
  <h3>Meu Cadastro</h3>
       
        
        
        <table border="0px solif #fff">
        
          <tr><td colspan="3" id="fotos_conteiner">
          
          
          <table cellpadding="0" cellspacing="0">
          <tr>
          <td> 
          
          <img src="<?= $image_avatar ?>" width="185px" height="185px" id="pickfiles" style="cursor:pointer;border:0"  align="left"  >     
           <div id="container" align="left"> 
          <div id="filelist" style="font-size:10px;border:1px solid #000;background-color:#FFC;color:#000;text-align:left;width:183px;"></div>
        </div>       
          </td>
          <td style="padding:10px">
          
          	<table cellpadding="0" cellspacing="0" style="width:100%">
            <tr><td>
                <div style="color:#FFF;height:170px;vertical-align:middle;display: table-cell;" >Clique na imagem ao lado para adicionar / alterar sua foto do perfil</div>
            </td></tr>
            <tr><td>
            <?
			if ($rs["facebook_page"]){				
				echo '<a href="'.$rs["facebook_page"].'"  target="_blank"><img src="./images/facebook-icone.png" style="border:0"> </a>';
			}
			
			
			
			?>
             
            </td></tr>
            </table>
            
       
            
          </td>
          </tr>
          </table>
                  
                  
                  
     
      
                  
       
          
         
   
    
      
      
      
      
        </td></tr>
        
        
         <tr><td colspan="3">
        <hr style="height:2px;border:0px;background-image:url(./images/hr.png)"></hr>
        </td></tr>
        
        <tr><td colspan="3">
        <label style="color:#FFF" >Nome *</label> <br>
        <input name="nome_participante" class="autofocus login-inputs" placeholder="Nome completo"   style="width:340px" value="<?= $rs["nome_participante"] ?>" />
        </td></tr>
        
        
        <tr><td colspan="2" >
        
        <!--
        <label style="color:#FFF" >Endereço  <em>( Esses dados não serão divulgados )</em></label>  <br>
        <input name="endereco"  value="<? // $rs["endereco"] ?>" style="width:285px" />
        </td><td >  
       <label style="color:#FFF"  >Número</label>                         <br>
         <input name="numero"  value="<? // $rs["numero"] ?>" placeholder="Número"  style="width:50px" onkeypress="return sonumero(event)"  maxlength="8"/> 
         -->
        </td></tr>      
        
         
               
        <tr><td>
        <label style="color:#FFF" >CPF *</label>          <br>

   <INPUT type="text"  class="input"  name="cpf" style="width:150px;"    maxlength="14" onKeyPress="return txtBoxFormat(this.form, this.name, '999.999.999-99', event);"  onblur="validaCPF(this);"  placeholder="CPF"    value="<?= formatarCPF_CNPJ($rs["cpf"],true) ?>" >


   </td><td   >
          <label style="color:#FFF" >Telefone / Celular</label>          <br> 
   <input name="telefone" id="telefone" type="text"  style="width:120px;"    maxlength="15"    onkeypress="return txtBoxFormat(this.form, this.name, '(99) 9999-9999', event);"  value="<?= $rs["telefone"] ?>"  />
   
   </td>  <td>
   
   
   </td>
        </tr>      
        
        <tr><td colspan="3">
        
        <!--
    <select   name="estado"   id="estado" onChange="atualiza_conteudo('./php/ajax_open_data.php','cod_estado='+this.value,'POST','handleHttpResponseCidade')">
      <? // get_uf(get_estado_by_municipio($rs["id_municipio"]));
		  ?>
    </select>

   <select  name="id_municipio"  id="id_municipio">  
     <? //get_municipios(get_estado_by_municipio($rs["id_municipio"]),$rs["id_municipio"]); ?>
   </select>
   
   -->
        </td></tr>            
        <tr><td style="color:#fff;" colspan="3">
        <label style="color:#FFF" >Data de Nascimento *</label>                           <br>
       <input  name="data_nascimento"  class="date_field"  type="text"   style="width:90px;"   onblur="newDataValidate(this);"   onkeypress="return txtBoxFormat(this.form, this.name, '99/99/9999', event);"  onChange="calcula_idade(this.form,this);"  maxLength="10" placeholder="Nascimento"  value="<?= data_br($rs["data_nascimento"]) ?>"   />
       
        <input name="idade" id="idade" type="text"   style="width: 150px;border:0px;background-color:#000;color:#FFF;font-weight:bolder" maxlength="30" readonly />       
        </td></tr>   
        
        <tr>        
        <td colspan="3">
             <table cellpadding="0" cellspacing="0" width="100%"><tr><td>
        
        <label style="color:#FFF" >E-mail: </label>  <label style="color:#09F" id="label_email"> <?= $rs["email"] ?> </label> 
        </td>
          <td colspan="2" rowspan="2" style="text-align:right">  
          
      
          <div style="background-image:url(images/fundo_button.png);width:109;height:30;text-align:center;line-height:30px;font-weight:bolder;color:#FFF;cursor:pointer;" onClick="alterar_participante(document.tela_meu_cadastro_form)">Alterar Dados</div>          
                 </td>
        </tr>      
    

        <tr><td>
        <!--
        
        <label style="color:#FFF" >Username / Login: </label> <label style="color:#09F" id="label_login" > <? // $rs["login"] ?> </label> 
        
        
        
        -->
        	</td></tr></table>
        </td>
        </tr>
        
        <tr><td colspan="3">
        <hr style="height:2px;border:0px;background-image:url(./images/hr.png)"></hr>
        </td></tr>
              
        
        <tr><td colspan="3" style="text-align:right;font-weight:bolder"> 
        <a  style="color:#09F;cursor:pointer;"  id="alterar_senha_btn">Alterar Senha</a><label style="color:#FFF" > / </label>   <a  style="color:#09F;cursor:pointer;" onClick="sair_site()">Logout</a>  
        </td></tr>  
        
        
        </table>
        
        
        <input type="hidden" name="valid_request_alterar_participante" value="1">
</form>
      
      

<?
$em_manutencao = false;
//$em_manutencao = true;	// apresenta mensagem de sistema em manutencao e nao permite fazer login

session_start();

$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT"); 
@header("Last-Modified: {$gmtDate} GMT"); 
@header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 


//echo "---------POST---------<br>";
foreach ($_POST as $a => $b) $$a = $b;

 
   ////////////////////////////////////////////////////
////////////INICIALIZANDO VARIAVEIS/////////////////
////////////////////////////////////////////////////
$aviso = "";
$msg = "";

require_once ("./php/connections/connections.php");	  
require_once ("./php/funcoes.php");
require_once ("./php/class.php");	
$label = new InfoSystem;
$layout = new layout;
$layout -> cabecalho();
$layout -> css('.');	
$layout -> js('.');
$layout -> jquery('.');
$layout -> aeroWindow('.');
$layout -> megamenu('.');
$layout -> fancybox('.');
$layout -> toastmessage('.');
$layout -> set_body('','','./images/themes02.jpg');  //$onload,$onscroll,$background   obs: $onresize está no arquivo menu.php
////////////////////////////////////////////////////
//EXECUTAR SOMENTE NO SUBMIT DO USUÁRIO E DA SENHA//
////////////////////////////////////////////////////
if ($_POST){
	if(!(empty($_POST["login"]) AND empty($_POST["password"]))) {
   	   require_once ("./php/sqlInjection.php");
	   
	   ///////////////////////////////////////
	   // Checa nível de acesso ativo  //////
	   //////////////////////////////////////
	$sql ="select na.id_nivel 
			from niveis_acesso AS na
			inner join usuarios AS u on (na.id_nivel = u.id_nivel)
			where u.login = '".$_POST["login"]."' and
				na.data_cancelamento IS NOT NULL";
	$valida_nivel=get_record($sql);
	if ($valida_nivel){
		$aviso="Grupo de acesso desativado.<br/>Entre em contato com o administrador do sistema.";
	} else {
			
	   
	   
	   $campos = array ("login", "nome_usuario","id_nivel","id_usuario");
	   $campos_str="";
	   $campos_session="";
	   for ($x=0;$x<count($campos);$x++){
		  $campos_str .= $campos[$x];
		  $campos_session .= '"'.$campos[$x].'_session"';
		  if($x<(count($campos)-1)){
			 $campos_str .=", ";
			 $campos_session .=", ";
		  }
	   }
	   $sql ="select ".$campos_str." from usuarios
	   where login = '".$_POST["login"]."' and
	   senha = '".md5($_POST["password"])."' AND data_cancelamento is NULL";
	//exit($sql);
	

	
	 $valida_login=get_record($sql);	
	 
	
	//////////////////////////////////////////
	//AUTENTICA O USUARIO CRIANDO AS SESSOES//
	//   E DIRECIONA PARA PÁGINA DE MENU    //
	//////////////////////////////////////////
	
	   if ($valida_login){
		   for ($x=0;$x<count($campos);$x++) 
		   		$_SESSION[$campos[$x]."_session"]=$valida_login[$campos[$x]];	
				
		   $_SESSION[InfoSystem::nome_sistema."_session"] = InfoSystem::nome_sistema;
	
		   require_once ("./php/menu.php");			

		  /* echo '<script>init_menu();</script>';	  */
		   exit('</body></html>');
	   }else{
			$sql ="select ".$campos_str." from usuarios
				where login = '".$_POST["login"]."' and
				senha = '".md5($_POST["password"])."'";
			$valida_login=get_record($sql);
			if ($valida_login){
				$aviso="Usuário desativado.<br/>Entre em contato com o administrador do sistema.";
			} else {
				$aviso="Login ou Senha inválido.";
			}
	   }
	}
	}
}
/////////////////////////////////////
//FIM DO TRECHO DE CHECAGEM DE LOGIN//
/////////////////////////////////////






////////////////////////////////////////////////
//INÍCIO DA PÁGINA INICIAL DE LOGIN DO SISTEMA//
////////////////////////////////////////////////

?>


<link  href="./css/conteudo.css" rel="stylesheet" type="text/css" >

<script>

function _fixPNG() {
   var images = $('img[@src*="png"]'), png;
   images.each(
      function() {
         png = this.src;
         this.src = './images/spacer.gif';
         this.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + png + "')";
      }
   );
}

$(document).ready(
   function () { if ($.browser.msie) _fixPNG(); }
);

window.onload = function (){   
	   var tamanho_browser = window.document.body.clientWidth;
	   var Width = 500;
	   var altura_browser = window.document.body.clientHeight;
	   var Height = 350;	  
	   
	   if (Width > tamanho_browser) Width = tamanho_browser-50;
	   if (Height > altura_browser) Height = altura_browser-80;
	   
       $('#tela_login').AeroWindow({
          WindowTitle:          'Autenticação: <?= InfoSystem::titulo ?>',
          WindowPositionTop:    'center',     /* Posible are pixels or 'center' */
          WindowPositionLeft:   'center',    /* Posible are pixels or 'center' */
          WindowWidth:          Width,
          WindowHeight:         Height,
		  WindowAnimationSpeed:    400,
          WindowAnimation:      'easeOutCubic'        
        }); 
	   parent.document.forms[0].login.focus();
   
}

</script>


<style>
.x-form-field{padding:1px 3px;background:#fff url(./inscricao/images/text-bg.gif) repeat-x 0 0;border:1px solid #B5B8C8;height:15px;}
.x-toolbar{background-color:#557D99;background-position:center;background-repeat:repeat-x;margin:0 2px 0;border:0;background-image:url(./inscricao/images/submenu.png);background-repeat:repeat-x;height:23px;}
table tr td{
 font: bold 0.8em  Verdana, Arial, Helvetica, sans-serif bold; color:#15428b;
}
.aviso {background-color:#FFFFCC;border:1px solid #ccc;color:#F00;font-weight:normal;
}
.btn {
   border:1px solid #999999; background-color:#deecfd;
   border-radius: 5px;
   font-family:Verdana, Arial, Helvetica, sans-serif bold; font-size:12px; font-weight:bold; color:#15428b;
   cursor:pointer;
}
.btn:hover {
   background-color:#15428b;color:#fff;
}
</style>
</head>

<title>IMA Sistemas</title>


<form name="form_login" action="" method='post'>




<div id="tela_login">

<? create_table_extjs('auto','auto',InfoSystem::nome_sistema) ?>  

<table  width="100%" height="100%" border="0" >
	<tr><td align="center"><img src="images/bg_login_bemvindo.jpg" width="100%"></td></tr>
	<tr><td align="center" valign="middle">
      <table align='center' cellpadding='5' cellspacing='1' width='auto' >      
       <tr>
         <td align='center'>

          <table align='center' cellpadding='3' width='auto' border='0'>
<?php
	if (! $em_manutencao) {
?>  
            <tr>
              <td width="30%" align='right'>
                 Login:
              </td>
              <td width="70%" align='left'>  
              <input name="login" type='text' value='' size='15' class='x-form-field' style='height:22px;width:200px;text-transform:lowercase;border-radius: 5px;'></td>
            </tr>

            <tr>
              <td align='right'>
                 Senha:
               </td>
              <td align='left'> <input name="password" type='password' value='' maxlength="32" class='x-form-field' style='height:22px;width:200px;border-radius: 5px;'></td>
            </tr>

            <tr>
              <td height='10' colspan="2">
                <div align="center"></div></td>
            </tr>

            <tr>
              <td colspan="2" align='right'>
                <div align="center">
                  <input type='submit' value='Entrar' class="btn">
                  <input type='button' value='Esqueci minha senha' class="btn" onClick="location.href='./lembrar_senha.php';">
                </div></td>
            </tr>
<?php
	} else {
		$aviso = "<br/>Sistema em manutenção.<br/> Favor tente mais tarde.<br/>&nbsp;";
	}
?>  
            <tr>
              <td colspan="2" align='center' bgcolor='#FFFFCC'>
                <font face='helvetica,arial' size='3' >
                  <b style="color:#f00;"><?=$aviso?></b>
                </font>
              </td>
            </tr>          
          </table>
        </td>
      </tr>
     </table>
    </form>
    </td></tr>
    </table>
    
    
</td>
        <td style="background-image:url(./images/midle_dir_extjs.gif);background-repeat:repeat-y;width:9px;height:3px;";></td>
      </tr>
      <tr>
        <td style="background-image:url(./images/botton_esq_extjs.gif);width:9px;height:8px;"></td>
        <td style="background-image:url(./images/botton_extjs.gif);background-repeat:repeat-x;"></td>
        <td style="background-image:url(./images/botton_dir_extjs.gif);width:9px;height:8px;";></td>
      </tr>
    </table>
    </center>
</div>





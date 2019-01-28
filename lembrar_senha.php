<?
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
$layout -> set_body('document.form_login.login.focus();','','./images/themes02.jpg');

////////////////////////////////////////////////////
//EXECUTAR SOMENTE NO SUBMIT DO USUÁRIO E DA SENHA//
////////////////////////////////////////////////////
if(!(empty($_POST["login"])  )) {   
	  $sql ="select login,senha,nome_usuario,email from usuarios
	  where login = '".$_POST["login"]."'";
	  $valida_login=get_record($sql);

//////////////////////////////////////////
//AUTENTICA O USUARIO CRIANDO AS SESSOES//
//   E DIRECIONA PARA PÁGINA DE MENU    //
//////////////////////////////////////////
		if ($valida_login){
			$nova_senha=substr($valida_login["senha"],1,8);
			$sql = "update usuarios set senha= '".md5($nova_senha)."' where login = '".$_POST["login"]."'";
			update_record($sql);
			$Subject =  InfoSystem::titulo. " - Recuperação de Senha";	  
			
			
			
			$Html = '<html><body bgcolor="#ffffff">				
			<table style="width:100%;" cellpadding="0" cellspacing="0" >		
			<tr >
			<td style="width:38px" rowspan="2" >		
			<img width="38px"   src="'.InfoSystem::url_site.'/images/pmc_brasao_sem_fundo_100x108.png" align="left" border="0"> 
			</td>
			<td>
			<b style="font-size:14px;"> '.InfoSystem::titulo.' </b>
			| <b style="font-size:10px;">'.InfoSystem::subtitulo.'</b><br>
			<b style="font-size:10px;color:#006600;">'.InfoSystem::nome_sistema.'</b><br>			
			</td>
			<td>	
			</td>
			</tr>	
			<tr><td colspan="2"><hr style="border:1px solid #15428B">
			</td></tr>
			<table>';
			$Html .=  'Prezado(a) '.$valida_login["nome_usuario"].',<br><br>';
			$Html .= "Esse e-mail foi enviado em atendimento à sua solicitação de gerar uma nova senha.".'<br>';				
			$Html .= '<br>Seu Login de Usuário é: '.$_POST["login"].'<br>';
			$Html .= 'Sua nova senha é: '.$nova_senha.'<br>';	
			$Html .= '<br>Este e-mail foi gerado automaticamente. Este comunicado contém informações que podem ser confidenciais. Se você não for o destinatário correto deste e-mail, fica notificado que qualquer difusão, distribuição ou cópia desta mensagem ou de seu conteúdo é estritamente proibida. Se receber esta mensagem com erro, exclua imediatamente.<br>';	
			$Html .= '<br><a href="'.InfoSystem::url_site.'">'.InfoSystem::nome_sistema.'</a><br>';	
			$Html .= '</html></body>';	
			
			$EmailRecipient = $valida_login["email"];
			$NameRecipient = "";
			SendMail(InfoSystem::email_sender ,"recuperador de senha",$EmailRecipient,$NameRecipient,$Subject,$Text,$Html,$Arquivo);
			$aviso = "Uma nova senha foi enviada para seu email \\n".$EmailRecipient;	
			echo "<script>alert('".$aviso."');</script>";	
			echo '<script>
			location.href="./index.php"	 
			</script>';
			exit();
		}else{
			  $aviso="Login inválido";
		}
 
}

/////////////////////////////////////
//FIM DO TREXO DE CHECAGEM DE LOGIN//
/////////////////////////////////////

////////////////////////////////////////////////
//INÍCIO DA PÁGINA INICIAL DE LOGIN DO SISTEMA//
////////////////////////////////////////////////

?><head>
<SCRIPT src="js/jquery.js" type=text/javascript></SCRIPT>


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
	   var Width = 700;
	   var altura_browser = window.document.body.clientHeight;
	   var Height = 270;	  
	   
	   if (Width > tamanho_browser) Width = tamanho_browser-50;
	   if (Height > altura_browser) Height = altura_browser-80;	   
       $('#tela_senha').AeroWindow({
          WindowTitle:          'Lembrar Senha: <?= InfoSystem::subtitulo ?>',
          WindowPositionTop:    'center',     /* Posible are pixels or 'center' */
          WindowPositionLeft:   'center',    /* Posible are pixels or 'center' */
          WindowWidth:          Width,
          WindowHeight:         Height,
		  WindowAnimationSpeed:    400,
          WindowAnimation:      'easeOutCubic'        
        }); 
}

</script>

<style>
.x-form-field {
	padding:1px 3px;
	background:#fff url(./inscricao/images/text-bg.gif) repeat-x 0 0;
	border:1px solid #B5B8C8;
	height:15px;
}
.x-toolbar {
	background-color:#557D99;
	background-position:center;
	background-repeat:repeat-x;
	margin:0 2px 0;
	border:0;
	background-repeat:repeat-x;
	height:23px;
}
table tr td {
	font: bold 0.8em Verdana, Arial, Helvetica, sans-serif bold;
	color:#15428b;
}
.aviso {
	background-color:#FFFFCC;
	border:1px solid #ccc;
	color:#F00;
	font-weight:normal;
}
.btn {
	border:1px solid #999999;
	background-color:#deecfd;
	border-radius: 5px;
	font-family:Verdana, Arial, Helvetica, sans-serif bold;
	font-size:12px;
	font-weight:bold;
	color:#15428b;
	cursor:pointer;
}
.btn:hover {
	background-color:#15428b;
	color:#fff;
}
</style>
</head>

<title>IMA Sistemas</title>
<form name="form_login" action="" method='post'>
  <div id="tela_senha"> 
  <? create_table_extjs('auto','auto',InfoSystem::nome_sistema) ?>
  <table width="100%" height="100%" border="0">
    <tr>
      <td align="center" valign="middle"><table align='center' cellpadding='5' cellspacing='1' width='auto' >        
          <tr>
            <td align='center'>
            
            <table align='center' cellpadding='3' width='auto' border='0'>
            
                <tr>
                  <td colspan="2" align='center' style="border:solid 1px #ccc;background-color:#29338c;color:#ffffff;"> Informe seu Login e uma nova Senha ser&aacute; gerada e enviada para seu email</td>
                </tr>
                
   				  <tr>
                  <td height='10' colspan="2"><div align="center"></div></td>
                </tr>
            
                <tr>
                  <td width="20%" align='right'> Login: </td>
                  <td width="80%" align='left'><input name="login" type='text' value='' size='15' class='x-form-field' style='height:22px;width:100%;text-transform:lowercase;border-radius: 5px;' /></td>
                </tr>
           
                <tr>
                  <td colspan="2" align='right'><div align="center">
                      <input type='submit' value='Gerar Nova Senha' class="btn" />
                      <input type='button' value='Voltar' class="btn" onClick="location.href='./index.php';" />
                    </div></td>
                </tr>
                <tr>
                  <td colspan="2" align='center' bgcolor='#FFFFCC'><font face='helvetica,arial' size='3' > <b style="color:#f00;">
                    <?=$aviso?>
                    </b> </font></td>
                </tr>
           
                <tr>
                  <td colspan="2" align='center' bgcolor='#FFFFFF'><?
                     $data = date("d/m/Y");
                     $hora = date("H:i");
                     echo "<b> $msg </b>";
                     echo "<br/><b>Data: $data &nbsp - &nbsp Hora: $hora</b>\n";
                  ?></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
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
</form>

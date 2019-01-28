<? 
session_start();
// ----------------- no cache----------------------------
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT"); 
@header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

require_once ("./php/funcoes.php");
require_once ("./php/class.php");	
require_once ("./php/connections/connections.php");	  
require_once ("./facebook.php");	
include_once ("./php/analyticstracking.php");


//comprimir_PHP_start();
		$layout = new layout;	
		$layout -> animate_menu('.');
		$layout -> css('.');	
		$layout -> js('.');
		$layout -> jquery('.');
		$layout -> aeroWindow('.');
		$layout -> toastmessage('.');
		$layout -> datepicker('.');
		$layout -> clueTip('.');	
		$layout -> fancybox('.');
		//$layout ->bootstrap('.');


require_once ("./base.php");

echo cabecalho_pmc();
echo menu_top();
echo facebook_box();
require_once ("./caixas_flutuantes.php");	 
echo icones_facebook_twitter();

echo banner_top_como_funciona();
?>
<center>  



<h1 style="color:#363945">Nós estamos trabalhando duro para melhorar nossa cidade, e <br>queremos aproximar você, cidadão, deste trabalho.</h1>

<br>
<center>
<?= youtube_embed('_XZNbAvTTTc','440px','260px') ?>
</center>
<br><br>

<img src="./images/etapas.gif" style="border:0px">

<br><br>
<img src="./images/BOXevoce1.png" style="border:0px">
<br><br>
<div style="font-size:18px;height:145px;color:#363945;line-height:35px;">
A Prefeitura publica um desafio para você participar <br>
O processo começa de forma ampla. Na fase de Inspirações, <br>
convidamos você, cidadão, a contribuir com o envio de boas práticas e <br>
inspirações em resposta ao desafio lançado.
</div>

 <br><br>
<img src="./images/BOXevoce2.png" style="border:0px">
<br><br>
<div style="font-size:18px;height:100px;color:#363945;line-height:35px;">
Depois, na fase de Propostas , pedimos que você, cidadão, desenvolva <br>ideias e sugestões próprias, com o foco em  melhorar a realidade <br>atual do desafio lançado. 
</div>   

<h1 style="color:#363945">Com o fim dessa fase, a Prefeitura irá analisar as propostas mais <br>curtidas, comentadas e visitadas em função de: impacto na vida <br>do cidadão e do servidor, viabilidade e a existência ou não de <br>projetos semelhantes em execução.</h1>


 <br><br>
<img src="./images/BOXevoce3.png" style="border:0px">
<br><br>
<div style="font-size:18px;height:115px;color:#363945;line-height:35px;">
Escolheremos, então, 2 a 10 Propostas para a fase de Votação, onde <br>você, cidadão, poderá escolher quais entre essas considera mais <br>importante para o desafio lançado.
</div>   



 <br><br>
<img src="./images/BOXevoce4.png" style="border:0px">
<br><br>
<div style="font-size:18px;height:180px;color:#363945;line-height:35px;">
Quem sabe você não poderá participar da Cerimônia de Encerramento?
<br>
Pelo menos uma das ideias irá para a fase de Execução, que contará <br>com um blog, em que divulgaremos passo a passo o desenvolvimento <br>e a implementação da solução escolhida para o desafio.
<br>

Acompanhe na <a href="comunidade.php">Comunidade</a> quem são os participantes mais ativos. 
</div>   
<h1 style="color:#363945">O resultado do Desafio será divulgado <br>
dia 29 de Outubro!</h1>




<?= botao_quero_participar() ?>
 
 


<br><br><br>


 <table cellpadding="3" cellspacing="3">
   <td rowspan="9" style="border-right:1px solid #363945"> <img src="./images/logo_site.png" style="border:0"> 
   </td>
   <td style="font-size:15px;color:#363945">A Plataforma e-voc&ecirc; &eacute; uma iniciativa de <a href="http://pt.wikipedia.org/wiki/Inovação_aberta" target="_blank"><b style="color:#36C">Inova&ccedil;&atilde;o Aberta (Open Innovation)</b></a>  para servi&ccedil;os</td>
 </tr>
 <tr>
   <td style="font-size:15px;color:#363945">  p&uacute;blicos. &Eacute; uma parceria entre a Prefeitura Municipal de Campinas, IMA - Munic&iacute;pios</td>
 </tr>
 <tr>
   <td style="font-size:15px;color:#363945">Associados, Instituto Tellus e Comunitas para aproximar o cidad&atilde;o das decis&otilde;es que afetam</td>
 </tr>
 <tr>
   <td style="font-size:15px;color:#363945">a todos n&oacute;s.</td>
 </tr>
 <tr>
   <td style="font-size:15px;color:#363945">&nbsp;</td>
 </tr>
 <tr>
   <td style="font-size:15px;color:#363945">Ela utiliza a abordagem da <a href="http://pt.wikipedia.org/wiki/Inovação_aberta" target="_blank"><b style="color:#36C">Inova&ccedil;&atilde;o Aberta</b></a>,  que permite a centenas de pessoas participarem</td>
 </tr>
 <tr>
   <td style="font-size:15px;color:#363945">colaborativamente da solu&ccedil;&atilde;o de um desafio importante para elas, e nada melhor do que usar</td>
 </tr>
 <tr>
   <td style="font-size:15px;color:#363945">isso para ajudar no desenvolvimento da cidade de Campinas.</td>
 </tr>
 </table>
 
 <?= show_logos() ?>

 <?= banner_bottom() ?>

</center>
<iframe frameborder="0" NAME="grid_iframe" WIDTH="1" HEIGHT="1" style="display:none;">No Inlineframes</iframe>
</BODY>
</HTML>
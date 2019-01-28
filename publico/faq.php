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

echo banner_top_faq();
?>
<center>  





<br>

<div style="width:900px;text-align:left;font-size:14px;color:#363945">
<h2 style="color:#363945">PERGUNTAS FREQUENTES</h2>
<br>	
<br>

<p><b>Como posso participar da e-voc�?</b></p>
<p>Para voc� participar � muito f�cil.<a href="como_funciona.php"><b style="color:#36C"> Veja Como Funciona aqui</b></a> e <a href="index.php"><b style="color:#36C"> participe por aqui.</b></a></p>
<br>

<p><b>Quem pode usar minha proposta?</b></p>
<p>Todas as propostas elaboradas na e-voc� [recebem] a  licen�a Creative Commons nos seguintes <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/br/" target="_blank" class="fancyframe"><b style="color:#36C">par�metros</b></a>  </p>
<br>

<p><b>Quais s�o as pol�ticas de privacidade da e-voc�?</b></p>
<p>Leia nossas pol�ticas  <a href="./politicas.htm" target="_blank" class="fancyframe"><b style="color:#36C">aqui.</b></a>   </p>
<br>


<p><b>Por que apenas maiores de 18 anos podem participar?</b></p>
<p>Como a participa��o na e-voc� envolve publicar conte�do, legalmente s� podem se responsabilizar maiores de idades pelas contribui��es. </p>
<br>


<p><b>Qual � a diferen�a entre a e-voc� e o 156?</b></p>
<p>S�o servi�os complementares: enquanto o <b>156</b> � focado em ouvir as reclama��es e opini�es pontuais do cidad�o, oferecendo respostas direcionadas para suas coloca��es, a <b>e-voc�</b> � focada na constru��o coletiva de solu��es para um desafio espec�fico,. </p>
<br>


<p><b>Por que as inspira��es e propostas passam por an�lise pr�via?</b></p>
<p>Fazemos a modera��o para impedir conte�do repetido, conte�do impr�prio para menores de 18 anos ou contribui��es que n�o tenham rela��o com o Desafio ou Fase, como propagandas e incita��es ao �dio. </p>
<br>

<p><b>A e-voc� tem algum tipo de pr�mio?</b></p>
<p>� fundamental que a participa��o cidad� seja motivada pela vontade de fazer uma cidade melhor ao inv�s de algum pr�mio ou benef�cio. O sistema de pontua��o na p�gina de Comunidade serve simplesmente para estimular a participa��o e reconhecer os mais engajados nessa plataforma. </p>
<br>


<p><b>A e-voc� � um canal de den�ncia e reclama��o?</b></p>
<p>N�o, o convite aqui � para que voc�, cidad�o, contribua com inspira��es e propostas para a solu��o dos nossos desafios.</p>
<br>


<p><b>Se tiver problemas ao contribuir, com quem entro em contato?</b></p>
<p>Fale conosco pelo <a href="mailto:campinasevoce@campinas.sp.gov.br"><b style="color:#36C">campinasevoce@campinas.sp.gov.br </b></a>. Estaremos muito contentes em ajud�-lo. </p>
<br>

<p><b>Se eu encontrar um conte�do inapropriado ou que � propriedade de outra pessoa?</b></p>
<p>Entre em contato conosco pelo  <a href="mailto:campinasevoce@campinas.sp.gov.br"><b style="color:#36C">campinasevoce@campinas.sp.gov.br </b></a> e analisaremos o caso. </p>
<br>


<p><b>Quais s�o os crit�rios de ranking na comunidade?</b></p>
<p>Para calcular a pontua��o de cada participante na comunidade os crit�rios e valores s�o:<br>
-	1 Proposta = 1000 pontos<br>
-	1 Inspira��o = 500 pontos<br>
-	1 Curtir = 1 ponto<br>
Quanto mais propostas, inspira��es, e pessoas curtirem suas postagens na plataforma maiores ser�o seus pontos e chances de crescer no ranking.
</p>
<br>

</div>
<?= show_logos() ?>

 <?= banner_bottom() ?>

</center>
<iframe frameborder="0" NAME="grid_iframe" WIDTH="1" HEIGHT="1" style="display:none;">No Inlineframes</iframe>
</BODY>
</HTML>
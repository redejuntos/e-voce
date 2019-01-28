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

<p><b>Como posso participar da e-você?</b></p>
<p>Para você participar é muito fácil.<a href="como_funciona.php"><b style="color:#36C"> Veja Como Funciona aqui</b></a> e <a href="index.php"><b style="color:#36C"> participe por aqui.</b></a></p>
<br>

<p><b>Quem pode usar minha proposta?</b></p>
<p>Todas as propostas elaboradas na e-você [recebem] a  licença Creative Commons nos seguintes <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/br/" target="_blank" class="fancyframe"><b style="color:#36C">parâmetros</b></a>  </p>
<br>

<p><b>Quais são as políticas de privacidade da e-você?</b></p>
<p>Leia nossas políticas  <a href="./politicas.htm" target="_blank" class="fancyframe"><b style="color:#36C">aqui.</b></a>   </p>
<br>


<p><b>Por que apenas maiores de 18 anos podem participar?</b></p>
<p>Como a participação na e-você envolve publicar conteúdo, legalmente só podem se responsabilizar maiores de idades pelas contribuições. </p>
<br>


<p><b>Qual é a diferença entre a e-você e o 156?</b></p>
<p>São serviços complementares: enquanto o <b>156</b> é focado em ouvir as reclamações e opiniões pontuais do cidadão, oferecendo respostas direcionadas para suas colocações, a <b>e-você</b> é focada na construção coletiva de soluções para um desafio específico,. </p>
<br>


<p><b>Por que as inspirações e propostas passam por análise prévia?</b></p>
<p>Fazemos a moderação para impedir conteúdo repetido, conteúdo impróprio para menores de 18 anos ou contribuições que não tenham relação com o Desafio ou Fase, como propagandas e incitações ao ódio. </p>
<br>

<p><b>A e-você tem algum tipo de prêmio?</b></p>
<p>É fundamental que a participação cidadã seja motivada pela vontade de fazer uma cidade melhor ao invés de algum prêmio ou benefício. O sistema de pontuação na página de Comunidade serve simplesmente para estimular a participação e reconhecer os mais engajados nessa plataforma. </p>
<br>


<p><b>A e-você é um canal de denúncia e reclamação?</b></p>
<p>Não, o convite aqui é para que você, cidadão, contribua com inspirações e propostas para a solução dos nossos desafios.</p>
<br>


<p><b>Se tiver problemas ao contribuir, com quem entro em contato?</b></p>
<p>Fale conosco pelo <a href="mailto:campinasevoce@campinas.sp.gov.br"><b style="color:#36C">campinasevoce@campinas.sp.gov.br </b></a>. Estaremos muito contentes em ajudá-lo. </p>
<br>

<p><b>Se eu encontrar um conteúdo inapropriado ou que é propriedade de outra pessoa?</b></p>
<p>Entre em contato conosco pelo  <a href="mailto:campinasevoce@campinas.sp.gov.br"><b style="color:#36C">campinasevoce@campinas.sp.gov.br </b></a> e analisaremos o caso. </p>
<br>


<p><b>Quais são os critérios de ranking na comunidade?</b></p>
<p>Para calcular a pontuação de cada participante na comunidade os critérios e valores são:<br>
-	1 Proposta = 1000 pontos<br>
-	1 Inspiração = 500 pontos<br>
-	1 Curtir = 1 ponto<br>
Quanto mais propostas, inspirações, e pessoas curtirem suas postagens na plataforma maiores serão seus pontos e chances de crescer no ranking.
</p>
<br>

</div>
<?= show_logos() ?>

 <?= banner_bottom() ?>

</center>
<iframe frameborder="0" NAME="grid_iframe" WIDTH="1" HEIGHT="1" style="display:none;">No Inlineframes</iframe>
</BODY>
</HTML>
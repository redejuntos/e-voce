<?

// Funções SQL Injection Adaptadas por Paulo Enok Sawazaki em 20/07/2009. As funções de XSS eu peguei na Web e não sei quem são os autores

// desabilita erros e displays para o hacker não ver respostas do servidor, ativar esse script somente em produção
// colocar um @ antes de conexoes com mysql
error_reporting(false); // Desativa o relatório de todos os erros
ini_set("display_errors", "0"); //Retira o Warning and notice


//---------------------------------------------------------------------------

// verifica se a requisição vem do mesmo servidor, FAVOR desabilitar esse item se precisar receber dados de um webservices em outro servidor ou se é necessário o acesso direto a esse link, por exemplo: se for uma página inicial.
 if  (strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) == false) acessoNaoAutorizado();
 

//---------------------------------------------------------------------------


// Colocar na tag body oncontextmenu = "return false" desabilita o botão direito do mouse
//echo '<body oncontextmenu = "return false" >';


//---------------------------------------------------------------------------

// Pega variaveis e verifica quanto a ataque de SQL Injection
// (Opcional) As variáveis passadas por parâmetros já foram passadas para PHP na função com seus respectivos nomes, não é necessário que você use $_GET, $_POST ou $_REQUEST para pegá-las. Exemplo: Se você estiver recebendo uma vetor por parâmetro, escreva direto $nome_do_vetor[indice], se estiver recebendo uma variavel, escreva $nome_da_variavel. Não precisa escrever $_POST["nome_da_variavel"], pois as atribuições já foram feitas pela função abaixo. Mas o tratamento também foi feito se você quiser usar $_POST ou $_GET.
// Para testar vulnerabilidades em SQL Injection, baixar plug-in do Firefox "SQL Inject ME"

function filter_request($methods, $array) {
	  foreach ($methods as $function) 	
		  $array = array_map($function, $array);		  
	  return $array;
}		

$methods = array('antiSQLInjection','RemoveXSS');
$_GET = filter_request($methods, $_GET);
$_POST = filter_request($methods, $_POST);
$_COOKIE = filter_request($methods, $_COOKIE);
$_REQUEST = filter_request($methods, $_REQUEST);

foreach (array($_REQUEST,$_GET,$_POST,$_COOKIE) as $params)
	foreach ($params as $a => $b) 		
		  		 $$a =  is_array($b)? array_map("antiSQLInjection", $b):antiSQLInjection($b);

function antiSQLInjection($params){
	if (is_array($params)){
		$params = array_map("antiSQLInjection", $params);
		return $params;
	}else{ 
		$params_regex = '/(from|0x|select|like|%0a|%0d|Content-Type|insert|delete|where|union|drop|[ +]or[ +]|show tables|\*|--|\\\\)/';	
		// descomentar linha abaixo para abortar aplicação quando houver tentativa de sqlinjection. Caso deseje, se a abrangência ficar muito grande, e você precisar de uma maior segurança, altere a expressão regular acima.
		 if (preg_match($params_regex, $params)> 0) acessoNaoAutorizado();  
		$params = preg_replace(sql_regcase($params_regex), '',$params);
		$params = trim($params);
		$params = strip_tags($params);
		$params = (get_magic_quotes_gpc()) ? $params : addslashes($params);  
		$params = str_replace("'","&#39",$params); //escape aspas simples
		$params = str_replace('"',"&#34",$params); //escape aspas duplas
		return $params;
	}
}

function acessoNaoAutorizado(){	
// TODO caso queria fazer uma rotina para enviar email para equipe de segurança quando alguem tentar acesso nao autorizado
die("Tentativa de acesso ilegal ou conjunto de caracteres inválido. Seu IP ".$_SERVER['REMOTE_ADDR']." foi gravado, caso tenha esteja com algum problema de acesso, por favor, entre em contato com o administrador do sistema");
}

//checks and removes xss attack strings from variable
function RemoveXSS($val) {
	if (is_array($val)){
		$val = array_map("RemoveXSS", $val);
		return $val;
	}else{ 
			// remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
			// this prevents some character re-spacing such as <java\0script>
			// note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
			$val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);
		
			// straight replacements, the user should never need these since they're normal characters
			// this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
			$search = 'abcdefghijklmnopqrstuvwxyz';
			$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$search .= '1234567890!@#$%^&*()';
			$search .= '~`";:?+/={}[]-_|\'\\';
			for ($i = 0; $i < strlen($search); $i++) {
				// ;? matches the ;, which is optional
				// 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
		
				// &#x0040 @ search for the hex values
				$val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
				// &#00064 @ 0{0,7} matches '0' zero to seven times
				$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
			}
		
			// now the only remaining whitespace attacks are \t, \n, and \r
			$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
			$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
			$ra = array_merge($ra1, $ra2);
		
			$found = true; // keep replacing as long as the previous round replaced something
			while ($found == true) {
				$val_before = $val;
				$_iSize = sizeof($ra);
				for ($i = 0; $i < $_iSize; $i++) {
					$pattern = '/';
					$_iRaSize = strlen($ra[$i]);
					for ($j = 0; $j < $_iRaSize; $j++) {
						if ($j > 0) {
							$pattern .= '(';
							$pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
							$pattern .= '|(&#0{0,8}([9][10][13]);?)?';
							$pattern .= ')?';
						}
						$pattern .= $ra[$i][$j];
					}
					$pattern .= '/i';
					$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
					$val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
					if ($val_before == $val) {
						// no replacements were made, so exit the loop
						$found = false;
					}
				}
			}
			return $val;
	}
}



//---------------- XSS ----------------------------------------------------------

// Previne qualquer possivel ataque XSS por $_GET.
foreach ($_GET as $check_url) {
    if ((eregi("<[^>]*script*\"?[^>]*>", $check_url)) || (eregi("<[^>]*object*\"?[^>]*>", $check_url)) ||
        (eregi("<[^>]*iframe*\"?[^>]*>", $check_url)) || (eregi("<[^>]*applet*\"?[^>]*>", $check_url)) ||
        (eregi("<[^>]*meta*\"?[^>]*>", $check_url)) || (eregi("<[^>]*style*\"?[^>]*>", $check_url)) ||
        (eregi("<[^>]*form*\"?[^>]*>", $check_url)) || (eregi("\([^>]*\"?[^)]*\)", $check_url)) ||
        (eregi("\"", $check_url))) {
    die ();
    }
}
unset($check_url);


?>

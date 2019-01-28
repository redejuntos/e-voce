<?php

session_start();


 //ini_set("display_errors", "0"); //Retira o Warning




$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT"); 
@header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

require_once ("./php/connections/connections.php");
require_once ("./php/funcoes.php");



foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	


//foreach ($_REQUEST as $a => $b){
	//$string .= $a."=".$b."<br>";	
//}



if ( !$_SESSION["id_participante_session"] )   {
	 echo '<script>alert("Ocorreu algum erro na transação. Tente novamente");</script>';	
	 exit();
} 


// nivel em relacao ao diretorio raiz do sistema
$raiz = "./";



$ano = date("Y");
$mes = date("m");

//////////////////////////////////
// Pasta Download
//////////////////////////////////

if(!is_dir("./download")) {
	mkdir("./download", 0755); // 0777 é a permissão/CHMOD = 777
	//echo "Diretório Ano criado com sucesso";
} else {
	//echo "Diretório Ano não criado porque já existe";
}


//////////////////////////////////
// Pasta Download
//////////////////////////////////

if(!is_dir("./download/".$ano)) {
	mkdir("./download/".$ano, 0755); // 0777 é a permissão/CHMOD = 777
	//echo "Diretório Ano criado com sucesso";
} else {
	//echo "Diretório Ano não criado porque já existe";
}


//////////////////////////////////
// Pasta Mes
//////////////////////////////////

if(!is_dir("./download/".$ano."/".$mes)) {
	mkdir("./download/".$ano."/".$mes, 0755); // 0777 é a permissão/CHMOD = 777
	//echo "Diretório Ano criado com sucesso";
} else {
	//echo "Diretório Ano não criado porque já existe";
}


chdir("./download/".$ano."/".$mes);
$diretorio = getcwd(); 

//exit($diretorio) ;
// Settings
//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
//$targetDir = 'uploads';


$targetDir = $diretorio;

$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Get parameters
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

// Clean the fileName for security reasons
$fileName = preg_replace('/[^\w\._]+/', '_', $fileName);

$nome_original = $fileName;

// Make sure the fileName is unique but only if chunking is disabled
//if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
	$ext = strrpos($fileName, '.');
	$fileName_a = substr($fileName, 0, $ext);
	$fileName_b = substr($fileName, $ext);

	$count = 1;	
	
	$chave = $_SESSION["id_participante_session"]."-".substr(md5(uniqid(rand(), true)),0,15);
	
	
	while (file_exists($targetDir . DIRECTORY_SEPARATOR . $chave . '_' . $count . $fileName_b))
		$count++;

	//$fileName = $fileName_a . '_' . $count . $fileName_b;
	
	$fileName = $chave . '_' . $count . $fileName_b;
	 
//}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;




// Create target dir
if (!file_exists($targetDir))
	@mkdir($targetDir);

// Remove old temp files	
if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir))) {
	while (($file = readdir($dir)) !== false) {
		$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

		// Remove temp file if it is older than the max age and is not the current file
		if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
			@unlink($tmpfilePath);
		}
	}

	closedir($dir);
} else
	die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
	

// Look for the content type header
if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
	$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

if (isset($_SERVER["CONTENT_TYPE"]))
	$contentType = $_SERVER["CONTENT_TYPE"];

// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
if (strpos($contentType, "multipart") !== false) {
	if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
		// Open temp file
		$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
		if ($out) {
			// Read binary input stream and append it to temp file
			$in = fopen($_FILES['file']['tmp_name'], "rb");

			if ($in) {
				while ($buff = fread($in, 4096))
					fwrite($out, $buff);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			fclose($in);
			fclose($out);
			@unlink($_FILES['file']['tmp_name']);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
} else {
	// Open temp file
	$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
	if ($out) {
		// Read binary input stream and append it to temp file
		$in = fopen("php://input", "rb");

		if ($in) {
			while ($buff = fread($in, 4096))
				fwrite($out, $buff);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

		fclose($in);
		fclose($out);
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {
	// Strip the temp .part suffix off 
	rename("{$filePath}.part", $filePath);			
	
	
	
	/*

	$sql_ordem = "select ordem,count(*) as total from fotos_ocorrencia WHERE ano= '$ano_ocorrencia' AND id_solicitacao = '$id_solicitacao' order by ordem desc limit 1";
	$rs = $obj_mysql->localizarRegistro($sql_ordem);		
	$ordem = intval($rs["ordem"] + 1);
	$total_fotos_gravadas = $rs["total"];
	*/
	
	
///////////////////////////////////////////////////////////
/// impede que seja gravado mais de 10 fotos caso opção nao esteja habilitada ////////////////////
////////////////////////////////////////////////////////////
/*
    $sql_habilita_fotos = "SELECT habilitar_fotos_adicionais FROM ocorrencias WHERE ano = '$ano_ocorrencia' AND id_solicitacao = '$id_solicitacao' limit 1";
	$rs_habilita_fotos = $obj_mysql->localizarRegistro($sql_habilita_fotos);
	
	if ($rs_habilita_fotos["habilitar_fotos_adicionais"] != 'S'){
		if ($total_fotos_gravadas >= 10){
			  // Não deixa gravar mais de 10 fotos sem habilitar botão de permissão
			  exit(); 
		}
	}*/
	
	
///////////////////////////////////////////////////////////
/// capturar informações exif xmp das fotos ////////////////////
/////////////////////////////////////////////////////////////
/*
$exif = exif_read_data($diretorio. DIRECTORY_SEPARATOR .$fileName, 0, true);	
$DateTimeOriginal = "";
foreach ($exif as $key => $section) 
  	foreach ($section as $name => $val) {		
		//if($name  == "DateTimeOriginal")
			//$DateTimeOriginal = $val;			
			
		if ($key == "GPS"){			
			if ($name == "GPSLatitudeRef")
				$GPSLatitudeRef = $val;			
		
			if ($name == "GPSLatitude")
				$GPSLatitude = DMStoDEC($val[0],$val[1],$val[2],$GPSLatitudeRef);
				
		
			if ($name == "GPSLongitudeRef")
				$GPSLongitudeRef = $val;
		
			if ($name == "GPSLongitude")			
				$GPSLongitude = DMStoDEC($val[0],$val[1],$val[2],$GPSLongitudeRef);
		}else{
			$$name = $val;		
		}
	}*/
///////////////////////////////////////////////////////////////

//	$data_foto = ($DateTimeOriginal != "")?"'".dateTime_format($DateTimeOriginal)."'":"NULL";
	
	
	//////////////////////////////////////////////////////
	/// get localização por CURL
	/////////////////////////////////////////////////////////
	/*
	if (($GPSLatitude)&&($GPSLongitude)){	
		  $apiURL = 'http://maps.google.com/maps/geo?output=xml&q='.$GPSLatitude.",+".$GPSLongitude;
		  $ch = curl_init(); 
		  curl_setopt($ch, CURLOPT_URL,$apiURL);  
		  curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
		  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		  curl_setopt($ch, CURLOPT_TIMEOUT, 3); 
		  $result_curl = curl_exec($ch); // run the whole process 
		  curl_close($ch);  
		  //echo $result;
		  
		  $dom = new DOMDocument('1.0','UTF-8');
		  //$dom = new DOMDocument( "1.0", "ISO-8859-15");
		  //$dom =new DOMDocument('1.0', 'iso-8859-1'); 
		  $dom->loadXML($result_curl);
		  $dom->preserveWhiteSpace = true;
		  
		  $local .= utf8_decode($dom->getElementsByTagName('Placemark')->item(0)->getElementsByTagName('address')->item(0)->nodeValue);
		  //	  $end .= ', '.$dom->getElementsByTagName('Placemark')->item(0)->getElementsByTagName('LocalityName')->item(0)->nodeValue;
		  //	  $end .= ' - '.$dom->getElementsByTagName('Placemark')->item(0)->getElementsByTagName('AdministrativeAreaName')->item(0)->nodeValue;
		  //	  $end .= ' , '.$dom->getElementsByTagName('Placemark')->item(0)->getElementsByTagName('CountryName')->item(0)->nodeValue;
		  //	  $end .= ' , '.$dom->getElementsByTagName('Placemark')->item(0)->getElementsByTagName('PostalCodeNumber')->item(0)->nodeValue.'<br>';
		  
		  unset($dom);
	}
///////////////////////////////////////////////////////////////////////	

	if ($FocalLength){
		$distancia_focal = explode ("/",$FocalLength);
		$distancia_focal = substr($distancia_focal[0]/$distancia_focal[1], 0,4);
	}else{
		$distancia_focal = "";	
	}




	$sql = "INSERT INTO arquivos (id_solicitacao,  ordem,  nome_original, arquivo,  caminho, status,   data_inclusao) 
			VALUES ('$id_solicitacao', NULL, '$nome_original', '$fileName', '../download/$ano/$mes/', '2','".date("Y-m-d H:i:s")."');
			";	
			
	insert_record($sql);
	
	*/

	
	//DEFINE OS PARÂMETROS DA MINIATURA	
	/*

	$largura = 185;
	$altura = 185;		
	//CRIA UMA NOVA IMAGEM									
	$imagem_orig = imagecreatefromjpeg($diretorio. DIRECTORY_SEPARATOR .$fileName);
	//LARGURA
	$pontoX = ImagesX($imagem_orig);
	//ALTURA
	$pontoY = ImagesY($imagem_orig);
	//CRIA O THUMBNAIL
	$imagem_fin = ImageCreateTrueColor($largura, $altura);
	//COPIA A IMAGEM ORIGINAL PARA DENTRO
	imagecopyresampled($imagem_fin, $imagem_orig, 0, 0, 0,0, $largura+1, $altura+1, $pontoX, $pontoY);
	//SALVA A IMAGEM					
	imagejpeg($imagem_fin, $diretorio. DIRECTORY_SEPARATOR ."tb_".$fileName);
	//LIBERA A MEMÓRIA
	imagedestroy($imagem_orig);
	imagedestroy($imagem_fin);	
	*/

	
	
	//////////////////////////////////////////////
	//////// imagem quadrada //////////////////////
	/////////////////////////////////////////////
	
	$image = imagecreatefromjpeg($filePath);
	
	$thumb_width = 185;
	$thumb_height = 185;
	
	$width = imagesx($image);
	$height = imagesy($image);
	
	$original_aspect = $width / $height;
	$thumb_aspect = $thumb_width / $thumb_height;
	
	if ( $original_aspect >= $thumb_aspect ){
	   // If image is wider than thumbnail (in aspect ratio sense)
	   $new_height = $thumb_height;
	   $new_width = $width / ($height / $thumb_height);
	}else{
	   // If the thumbnail is wider than the image
	   $new_width = $thumb_width;
	   $new_height = $height / ($width / $thumb_width);
	}
	
	$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
	
	// Resize and crop
	imagecopyresampled($thumb,
					   $image,
					   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
					   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
					   0, 0,
					   $new_width, $new_height,
					   $width, $height);
	imagejpeg($thumb,  $diretorio. DIRECTORY_SEPARATOR ."tb_".$fileName);

	
	
	
	
	
	
	unlink($fileName ); // apaga arquivo que foi feito upload
	
	

	$sql = "UPDATE participantes SET avatar='"."./download/".$ano."/".$mes."/tb_".$fileName."',
	data_alteracao = '".date("Y-m-d H:i:s")."'  WHERE  
	id_participante='".$_SESSION["id_participante_session"]."' LIMIT 1;
			";	
		//	echo $sql;
	update_record($sql);
	
	
}






// Return JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');




 function DMStoDEC($_deg, $_min, $_sec, $_ref){
            $_array = explode('/', $_deg);
            $_deg = $_array[0]/$_array[1];
            $_array = explode('/', $_min);
            $_min = $_array[0]/$_array[1];
            $_array = explode('/', $_sec);
            $_sec = $_array[0]/$_array[1];

            $_coordinate = $_deg+((($_min*60)+($_sec))/3600);
            /**
             *  + + = North/East
             *  + - = North/West
             *  - - = South/West
             *  - + = South/East        
            */
            if('s' === strtolower($_ref) || 'w' === strtolower($_ref)){
                // Negatify the coordinate
                $_coordinate = 0-$_coordinate;
            }

            return $_coordinate;
 }    
 
 

function dateTime_format($date) {
     $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 5, 2 );
     $thisday =  substr ( $date, 8, 2 );
     return $thisyear."-".$thismonth."-".$thisday." ".substr ( $date, 11 );
}

?>
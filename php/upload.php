<?php

session_start();


 //ini_set("display_errors", "0"); //Retira o Warning




$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT"); 
@header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

require_once ("./connections/connections.php");
require_once ("./funcoes.php");

////////////////////////////
//VERIFICA��O DE SEGURAN�A//
////////////////////////////
verifica_seguranca();


foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	


//foreach ($_REQUEST as $a => $b){
	//$string .= $a."=".$b."<br>";	
//}

// nivel em relacao ao diretorio raiz do sistema
$raiz = "../";



$ano = date("Y");
$mes = date("m");

//////////////////////////////////
// Pasta Download
//////////////////////////////////

if(!is_dir("../publico/download")) {
	mkdir("../publico/download", 0755); // 0777 � a permiss�o/CHMOD = 777
	//echo "Diret�rio Ano criado com sucesso";
} else {
	//echo "Diret�rio Ano n�o criado porque j� existe";
}


//////////////////////////////////
// Pasta Download
//////////////////////////////////

if(!is_dir("../publico/download/".$ano)) {
	mkdir("../publico/download/".$ano, 0755); // 0777 � a permiss�o/CHMOD = 777
	//echo "Diret�rio Ano criado com sucesso";
} else {
	//echo "Diret�rio Ano n�o criado porque j� existe";
}


//////////////////////////////////
// Pasta Mes
//////////////////////////////////

if(!is_dir("../publico/download/".$ano."/".$mes)) {
	mkdir("../publico/download/".$ano."/".$mes, 0755); // 0777 � a permiss�o/CHMOD = 777
	//echo "Diret�rio Ano criado com sucesso";
} else {
	//echo "Diret�rio Ano n�o criado porque j� existe";
}


chdir("../publico/download/".$ano."/".$mes);
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
	
	$chave = "anex-".substr(md5(uniqid(rand(), true)),0,20);
	
	
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
	

}

	// rezise image				
					//DEFINE OS PAR�METROS DA MINIATURA	
						$thumb_largura = 440;
						$thumb_altura = 260;		
						//CRIA UMA NOVA IMAGEM									
						$imagem_orig = imagecreatefromjpeg($filePath);
						//LARGURA						
						$pontoX = ImagesX($imagem_orig);
						//ALTURA
						$pontoY = ImagesY($imagem_orig);
						//CRIA O THUMBNAIL												
						
						if ($pontoX > $pontoY){ // paisagem
							$altura = $thumb_altura;
							$largura = abs($thumb_altura * ($pontoX / $pontoY)  );
						}else{ // retrato
							$altura = abs($thumb_largura * ($pontoY / $pontoX) );
							$largura = $thumb_largura;
						}
						
						$imagem_fin = ImageCreateTrueColor($largura, $altura);
						//COPIA A IMAGEM ORIGINAL PARA DENTRO
						imagecopyresampled($imagem_fin, $imagem_orig, 0, 0, 0,0, $largura+1, $altura+1, $pontoX, $pontoY);
						//SALVA A IMAGEM								
						imagejpeg($imagem_fin, $diretorio . DIRECTORY_SEPARATOR . "tmp".$fileName, 80);
						//LIBERA A MEM�RIA			
						imagedestroy($imagem_orig);
						imagedestroy($imagem_fin);		
						
						$image = imagecreatefromjpeg( $diretorio . DIRECTORY_SEPARATOR . "tmp".$fileName);
						$thumb_width = $thumb_largura;
						$thumb_height = $thumb_altura;
						
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
						imagejpeg($thumb,  $diretorio . DIRECTORY_SEPARATOR . "thumb-".$fileName, 80);
						
						//////////////////////////////////////////////
						//////// imagem quadrada //////////////////////
						/////////////////////////////////////////////
						
						$thumb_width = 140;
						$thumb_height = 140;
						
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
						imagejpeg($thumb,  $diretorio . DIRECTORY_SEPARATOR . "tb-".$fileName, 80);
						
						
						///////////////////////////////////////////
						
						$caminho_arquivo = "download/".$ano."/".$mes."/";
						$arquivo = $fileName;
					//	@unlink("../download/".$fileName);	//foto original
						@unlink($diretorio . DIRECTORY_SEPARATOR . "tmp".$fileName); // 






	if ($id_desafio){
			$add_sql = " id_desafio = '$id_desafio' ";
			$campo = 'id_desafio';
			$value = $id_desafio;
	}
			
	if ($id_topico){
			$add_sql = " id_topico = '$id_topico' ";
			$campo = 'id_topico';
			$value = $id_topico;
	}



$sql = "SELECT ordem+1 AS ordem from anexos where $add_sql  AND youtube_link is NULL order by id_anexo desc limit 1";
$rs = get_record($sql);
$ordem = intval($rs["ordem"]);


	$sql = "INSERT INTO anexos (descricao, $campo, caminho_arquivo, arquivo, ordem, data_inclusao) VALUES ('$nome_original', '$value', '".$caminho_arquivo."', '".$arquivo."','".$ordem."','".date("Y-m-d H:i:s")."');
			";	
	insert_record($sql);




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
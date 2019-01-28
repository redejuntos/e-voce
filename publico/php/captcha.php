<? 
session_start();

// ----------------- no cache----------------------------
$gmtDate = gmdate("D, d M Y H:i:s");header("Expires: {$gmtDate} GMT"); 
header("Last-Modified: {$gmtDate} GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 

// Definir o header como image/png para indicar que esta página contém dados
// do tipo image->PNG
header("Content-type: image/png");

// Criar um novo recurso de imagem a partir de um arquivo
$imagemCaptcha = imagecreatefrompng("../images/captcha.png")
or die("Não foi possível inicializar uma nova imagem");

//Carregar uma nova fonte
$fonteCaptcha = imageloadfont("../gdf/arial.gdf");

// Criar o texto para o captcha
$textoCaptcha = substr(md5(uniqid('')),-9,9);

// Guardar o texto numa variável session
$_SESSION['session_textoCaptcha'] = $textoCaptcha;

// Indicar a cor para o texto
$corCaptcha = imagecolorallocate($imagemCaptcha,0,0,0);

// Escrever a string na cor escolhida
imagestring($imagemCaptcha,$fonteCaptcha,10,0,$textoCaptcha,$corCaptcha);

// Mostrar a imagem captha no formato PNG.
// Outros formatos podem ser usados com imagejpeg, imagegif, imagewbmp, etc.
imagepng($imagemCaptcha);

// Liberar memória
imagedestroy($imagemCaptcha);

?>
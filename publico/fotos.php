<? 
session_start();
// ----------------- no cache----------------------------
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT"); 
@header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

foreach (array($_POST,$_GET) as $params)
	foreach ($params as $a => $b) 		
		  $$a =  is_array($b)? array_map("refreshArrayMap", $b):$b;	

require_once ("./php/funcoes.php");
require_once ("./php/class.php");	
require_once ("./php/connections/connections.php");	  

$layout = new layout;	
$layout -> css('.');
$layout -> js('.');
$layout -> jquery('.');
$layout -> fancybox('.');


?>

<!-- Include Lightbox (Production) ----------------------------------------- -->
	<link type="text/css" rel="stylesheet" media="screen" href="./css/style.css" />    
<!-- ----------------------------------------------------------------------- -->
<style type="text/css">
h4 {
color: #363636;
font-size: 20px;
font-weight: 700;
line-height: 20px;
border-bottom: 1px solid #1a1a1a;
margin:0px 0px 10px 0px;
padding:0px;
}

</style>
<?


$sql = "
		SELECT c.caminho_arquivo, c.arquivo,c.descricao
            FROM anexos AS c 
            WHERE youtube_link  IS NULL
            AND c.id_desafio='".$id_desafio."'           
            ORDER BY c.ordem
		";
		
		

		
  if (numrows($sql)>0){
		$result = return_query($sql);	
		echo '
				<center>
				<div style="width:760px;text-align:justify;line-height: 21px;color:#333;font-family: Helvetica, Arial, Geneva, sans-serif;font-size: 14px;overflow:hidden"><br>';
		echo '<h4>Imagens</h4>';	
		echo '
	
		<table 
		';
		while( $rs = db_fetch_array($result) ){

		

		
		
		echo '<table cellpadding="4" cellspacing="4"><tr>
		
		
					
						<td >			 
						<div class="gallery" style="margin:0px;padding:0px;"   >
						<ul  class="images" style="margin:0px;padding:0px;" > 
						<li class="image" style="margin:0px;padding:0px;" >
						<div style="margin:0px;padding:0px;text-align:center"  >				  			
						<a  href="'.$rs["caminho_arquivo"].$rs["arquivo"].'"  target="_blank" class="fancybox" ><img  src="'.$rs["caminho_arquivo"].'thumb-'.$rs["arquivo"].'" style="width:308px;height:182px;"  align="top" ></a>			  
						</div>			 
						</li>
						</ul>
						</div> 		   
						</td>
		
		
		
		
		<td  style="font-size:14px;">
		'.$rs["descricao"].'
		</td>
		</tr>
		</table>
		
		';
		
		

		}
		echo '
		
		
		</center>';
  }
?>
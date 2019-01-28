<?

class layout {

			function cabecalho(){		
				//echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
				//"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';		
				echo '
					<HEAD>
					<META content="text/html; charset=0x0416" http-equiv=Content-Type>
					<meta http-equiv="Cache-Control" content="no-cache, no-store" />
					<meta http-equiv="Pragma" content="no-cache, no-store" />
					<meta http-equiv="expires" content="Mon, 06 Jan 1990 00:00:01 GMT" />
					<title>IMA Sistemas</title>			
				';
			}
			function js($path){
				/*
				echo '	
				<script src="'.$path.'/js/calendar.js" type="text/javascript"></script>		
				';
				*/
				echo '
				<script src="'.$path.'/js/functions.js" type="text/javascript"></script>	
				<script src="'.$path.'/js/functions_form_validation.js" type="text/javascript"></script>	
				<script src="'.$path.'/js/data.js" type="text/javascript"></script>	
				<script src="'.$path.'/js/time.js" type="text/javascript"></script>		
				<script src="'.$path.'/js/floater.js" type="text/javascript"></script>	
				';
				
			}
			function css($path){
				echo '
				<link  href="'.$path.'/css/conteudo.css" rel="stylesheet" type="text/css" >				
				';
			}
			
			
			
			function clueTip($path){
				echo '
					<!-- clueTip -->
					<script src="'.$path.'/js/jquery.hoverIntent.js" type="text/javascript"></script>
					<script src="'.$path.'/js/jquery.cluetip.js" type="text/javascript"></script>
					<link rel="stylesheet" href="'.$path.'/css/jquery.cluetip.css" type="text/css" />
					';
			}
			
			
			function thickbox($path){
				echo '
						<!-- thickbox -->
						<script type="text/javascript" src="'.$path.'/js/thickbox_3.1.js"></script>
						<link rel="stylesheet" type="text/css" href="'.$path.'/css/thickbox.css" />
						<script type="text/javascript">  
						// Set thickbox loading image
						tb_pathToImage = "'.$path.'/images/loading-thickbox.gif";
						</script>
					';
			}
			
			function animate_menu($path){
				echo '
					  <link rel="stylesheet" href="'.$path.'/css/animated-menu.css"/>
					  <script src="'.$path.'/js/jquery-1.3.js" type="text/javascript"></script>
					  <script src="'.$path.'/js/jquery.easing.1.3.js" type="text/javascript"></script>
					  <script src="'.$path.'/js/animated-menu.js" type="text/javascript"></script>';
			}
			
			
			function jquery($path){
				echo '<script src="'.$path.'/js/jquery-1.5.1.min.js" type="text/javascript"></script>';
			}


			function aeroWindow($path){
				echo '
					<!-- AeroWindow -->
					  <link href="'.$path.'/css/jquery-ui.css" rel="stylesheet" type="text/css"/>    
					  <link href="'.$path.'/css/AeroWindow.css?r=123" rel="stylesheet" type="text/css"/>		
					  <script type="text/javascript" src="'.$path.'/js/jquery-ui-1.8.12.custom.min.js"></script> 
					  <script type="text/javascript" src="'.$path.'/js/jquery.easing.1.3.js"></script>         
					  <script type="text/javascript" src="'.$path.'/js/jquery-AeroWindow.js"></script>
					';
			}
			
			
			function megamenu($path){
				echo '
					<!-- megamenu -->					
					  <script src="'.$path.'/js/jquery.megamenu.js" type="text/javascript"></script>
					  <script type="text/javascript">
					  jQuery(document).ready(function(){
					  jQuery(".megamenu").megamenu();
					  });
					  </script>
					';
			}
			
			
			function datepicker($path){
				echo '
					<!-- datepicker -->    
					  <link type="text/css" href="'.$path.'/css/redmond/jquery-ui-1.8.12.custom.css" rel="stylesheet" />	
					  <link rel="stylesheet" href="'.$path.'/css/layout_widget.css">
					';
			}
			
			function bootstrap($path){
				echo '				
				<link href="'.$path.'/css/bootstrap.css" rel="stylesheet" type="text/css" 
				<link href="'.$path.'/css/bootstrap-responsive.css"" rel="stylesheet" type="text/css"  />
				';	
			}
			

			function toastmessage($path){
				echo '
					<!-- toastmessage -->    
					  <link type="text/css" href="'.$path.'/css/jquery.toastmessage-min.css" rel="stylesheet" />	
					  <script type="text/javascript" src="'.$path.'/js/jquery.toastmessage-min.js"></script>
					';
			}
			
			function spryTabbedPanels($path){
				echo '
					<!-- SpryTabbedPanels -->    
						<script src="'.$path.'/js/SpryTabbedPanels.js" type="text/javascript"></script>
						<link href="'.$path.'/css/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
					';
			}	
			
			
			
			function lighting_box($path){
				echo '
				<script type="text/javascript">
				var GB_ANIMATION = true;
				var GB_overlay_click_close = false;
				</script>
				<link href="'.$path.'/css/greybox.css" rel="stylesheet" type="text/css" media="all" />
				<script type="text/javascript" src="'.$path.'/js/AmiJS.js"></script>
				<script type="text/javascript" src="'.$path.'/js/greybox.js"></script>
				';	
			}
			
			function grey_box(){
				echo '
				<script type="text/javascript">
				var GB_ANIMATION = true;
				var GB_overlay_click_close = false;
				</script>
				<link href="../css/greybox.css" rel="stylesheet" type="text/css" media="all" />
				<script type="text/javascript" src="../js/AmiJS.js"></script>
				<script type="text/javascript" src="../js/floater.js"></script>
				<script type="text/javascript" src="../js/greybox.js"></script>
				';	
			}

			function fancybox($path){
				echo '
				<script type="text/javascript" src="'.$path.'/js/jquery.mousewheel-3.0.4.pack.js"></script>
				<script type="text/javascript" src="'.$path.'/js/jquery.fancybox-1.3.4.pack.js"></script>
				<link rel="stylesheet" type="text/css" href="'.$path.'/css/jquery.fancybox-1.3.4.css" media="screen" />		
				<script>
				$(document).ready(function() {
					$("a.fancybox").fancybox({
						\'overlayShow\'	: false,
						\'transitionIn\'	: \'elastic\',
						\'transitionOut\'	: \'elastic\'
					});		
				});
				</script>		
				';	
			}
			
			

		

			
			function set_body($onload,$onscroll,$background){
				//$onresize está no arquivo menu.php
				echo '
				</HEAD><body onload="'.$onload.'" onscroll="'.$onscroll.'"  background="'.$background.'"  style="background-repeat:no-repeat"  marginheight="0" marginwidth="0" bottommargin="0" rightmargin="0" topmargin="0" leftmargin="0" >		
				';
			}
			
			
			
		function tooltip($path){
				echo '
		<link href="'.$path.'/css/tooltip.css" rel="stylesheet" type="text/css"  />
		<SCRIPT src="'.$path.'/js/event.js" type=text/javascript></SCRIPT>
		<SCRIPT src="'.$path.'/js/urchin.js" type=text/javascript></SCRIPT>
		<SCRIPT src="'.$path.'/js/tooltip.js" type=text/javascript></SCRIPT>
				';			
			}
			
			
		function tooltip_in($id,$conteudo){
			echo '
			<SCRIPT type=text/javascript>
		//<![CDATA[
		
		var '.$id.' = new ToolTip(document.getElementById("'.$id.'"), \''.$conteudo.'\', "tolltip_css", true);
		
		
		setInterval((function(){
			'.$id.' = (new Date).toLocaleString();
			return arguments.callee;
		})(), 1000);
		
		
		//]]>
		</SCRIPT>
		';
			}
	
} // -fim da classe ------------------------------------------------






class menu {
		
		function menu(){ //construtor			
			$this -> load_xml();
		}
		
		function int_vertical_functions_menu(){
			echo '			
				<script>			
				function exibe_menu(aux){
					var obj = document.getElementById(aux);
					var state = obj.style.display;				
					if  (state == "none"){				
							switch (aux){'."\n";				
							foreach ($_SESSION["menu_item"]["item"] as $a){	
							$a=filtro_menu_titulo($a);
							echo 'case "'.$a.'":		
							 $("#'.$a.'").animate({ height: "show", opacity: "show" }, "slow");						
							  break;	'."\n";
							}
							echo '   default:						
									break;	
							}	
					}else{						
							switch (aux){'."\n";				
							foreach ($_SESSION["menu_item"]["item"] as $a){	
							$a=filtro_menu_titulo($a);
							echo 'case "'.$a.'":		
							$("#'.$a.'").animate({ height: "hide", opacity: "hide" }, "slow");
							break;	'."\n";
							}
							echo '   default:						
							break;	
							}		
					}
				}
				</script>	
				';
		}
		
		
		function functions(){
		echo '	
		<link href="./css/menu_vertical.css" rel="stylesheet" type="text/css">	
		<script src="./js/functions.js?t='.date("i_s").'" type="text/javascript"></script>	
		<script src="./js/floater.js" type="text/javascript"></script>	
		';
		}
		
		function menu_inicio(){
		echo ' 
		<div id="table_menu_vertical" style="overflow:hidden">
		<table  border="0" align="left" cellpadding="0" cellspacing="0" style="margin:0;height:0 auto;width:180px;" >
		<tr>
		<td rowspan="2" style="	border: solid #99bbe8 1px;border-radius:5px;cursor:pointer;width:20px;background: #fff url(./images/coluna_blue.gif) repeat-Y center top;" valign="middle" id="menu_lateral" onmouseover="this.style.background = \'url(./images/coluna_blue_on.gif)\';"   onmouseout="this.style.background = \'url(./images/coluna_blue.gif)\';"><div style="width:20px;"><img src="./images/seta_left.gif" style="border:0;cursor:pointer;margin-left:3px;" id="img_seta_menu"></div></td>
		<td  align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif;font-size:9px;background:#003366 url(./images/tb_blue.gif) repeat-X center top;height:15px;width:180px; "><div style="width:165px;float:left;">
		</div><div style="width:15px;height:15px;text-align:right;float:right;"><img id="go_home" src="./images/go_home.gif" style="border:0;cursor:pointer;" ></div>
		</td>
		</tr>	
		
		<tr>		
		<td align="left"  valign="top">		
		<table width="180" border="0" align="left" cellpadding="0" cellspacing="0" class="fonte">

		';
		}
		
		
		
		function superfish(){
		echo '
			  <link rel="stylesheet" type="text/css" href="./css/superfish.css" />	
			  <script language="javascript" src="./js/superfish.js"></script>
			  
			  <script language="javascript">
			  $(document).ready(function() {
				  $("ul.sf-menu").superfish();				 
			  });
			  </script>
		';
		}
		
		
		
		function head(){
		?>

<div style="left:0;top:0;position:absolute;z-index:9999;float:left;width:52px;height:48px;" >
  <ul class="megamenu"   style="top:0;margin:0;padding:0;list-style-type:none"  >
    <li > <a   href="javascript: void(0)"><img src="./images/transparentpixel.gif" style="left:0;top:0;position:absolute;z-index:200;float:left;width:52px;height:48px;border:0;"> </a>
    
      <div style="width:700px;"  id="megamenu_bloco">
      
      
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="1" colspan="3" align="right" style="background-repeat:repeat-x; background-position:bottom;">	
              <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="1" rowspan="2" style="text-align:right" valign="middle" ><img src="./images/menu_logo_over.jpg" width="52" height="69" border="0"  /></td>
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                  <td width="1" align="left" valign="bottom" background="./images/menu_titulo_fundo.jpg" style="background-position:bottom; background-repeat:repeat-x;"><img src="./images/menu_titulo.jpg" width="138" height="41" /></td>
                  <td align="left" valign="middle" background="./images/menu_titulo_fundo.jpg" class="pressione_esc" style="background-position:bottom; background-repeat:repeat-x;">&nbsp;</td>
                  <td align="right" valign="bottom" background="./images/menu_titulo_fundo.jpg" style="background-position:bottom; background-repeat:repeat-x;">
                  <img src="./images/menu_titulo2.jpg" width="8" height="41" /></td>
                </tr>
              </table>
              </td>
          </tr>
          <tr>
            <td bgcolor="#DCE8F7"><img src="./images/separador.png" width="3" height="1" /></td>
            <td bgcolor="#FBFCFE">            
            <table width="700px" border="0" cellspacing="0" cellpadding="0"   >
                <tr>
                  <td valign="top" style="margin:0px;padding:0px;top:0px;">    
                     
<style>

#mega_menu_suspenso  li{
float:left;
padding: 0px 0px 0px 0px;
margin:0px 0px 0px 0px;
width:150px;
display:block;
position:relative;

}

#mega_menu_suspenso  .bloco{
border-left:1px solid #5f7394;
margin:0px 0px 10px 0px;
}


#mega_menu_suspenso  ul {
padding:0px;    
margin:0px 0px 0px 0px;
float: left;
width: 100%;
list-style:none;
font-weight:normal;	

}


#mega_menu_suspenso {
padding:0px 0px 0px 0px;
margin:0px 0px 0px 10px;
width: 700px;
list-style:none;
position: relative;
font-weight: bold;
color: #000000;
display:inline;
font-family:Verdana, Geneva, sans-serif;
font-size:10px;


}

#mega_menu_suspenso li .link{
float: left;
color: #000;
margin:0px 0 5px 0;
padding: 0px 10px 0px 3px;
text-decoration: none;
background-color:#5f7394;
color:#FFF;
font-weight:bold;
border-bottom-right-radius:2em;

}

#mega_menu_suspenso li .sub{
margin:0px 0 0px 10px;
padding:0px;
color: #000;

}


#mega_menu_suspenso li.mega-hover a, #mega_menu_suspenso li a:hover {
background: #e4ebf6;
color: #000;

}



</style>
                  
                  <div style="width:100%;margin:0px 0 70px 20px;height:auto" >
                             
                  <?					
					echo '<ul style="height:auto"  id="mega_menu_suspenso" >';
					$menu_vetor = verifica_acesso('','',1,'');
					
					$menu_vetor[] = "";
					
					for($w=0;$w<count($_SESSION["menu_item"]["item"]);$w++){
						$aux = $_SESSION["menu_item"]["item"][$w];		
						echo '<li class="bloco"><a href="#" class="link">'.$aux.'</a><ul>';	
						for($x=0;$x<count($_SESSION["menu_item"][retirar_acentos($aux)]["titulo"]);$x++){		
							if (in_array($_SESSION["menu_item"][retirar_acentos($aux)]["permission"][$x], $menu_vetor )) {
								$titulo = $_SESSION["menu_item"][retirar_acentos($aux)]["titulo"][$x];
								echo '<li><a href="#"   class="sub" onclick="'.$_SESSION["menu_item"][retirar_acentos($aux)]["onclick"][$x].'">'.$titulo.'</a></li>';
	
						////////////////  sub-item /////////////////////////				
			
							for($h=0;$h<count($_SESSION["menu_subitem"][retirar_acentos($aux)][$titulo]["titulo"]);$h++){								
									if (in_array($_SESSION["menu_subitem"][retirar_acentos($aux)][$titulo]["permission"][$h], $menu_vetor )) {
										$subtitulo = $_SESSION["menu_subitem"][retirar_acentos($aux)][$titulo]["titulo"][$h];
										if ($subtitulo){	
											  echo '<li><a href="#"   class="sub" onclick="'.$_SESSION["menu_subitem"][retirar_acentos($aux)][$titulo]["onclick"][$h].'">&nbsp; &bull; '.$subtitulo.'</a></li>';
										}
									}									
							}	
				
						////////////////////////////////////////////////////
								
								
								
								
								
								
								
								
							}
						}		
						echo '</ul></li>';
					}	
					echo '</ul>';	
				  ?>           
                  
                </div>
                 
                  
                          
                   </td>
                </tr>
              </table>
              </td>
            <td width="1" bgcolor="#DCE8F7"><img src="./images/separador.png" width="4" height="1" /></td>
          </tr>
          <tr>
            <td height="7" colspan="3" align="left" valign="bottom" bgcolor="#DCE8F7"></td>
          <tr>
            <td height="1" colspan="3" align="right" style="background-image:url(./images/menu_visivel_fundo.png);background-repeat:repeat-x;background-position:right" onMouseOver='document.getElementById("megamenu_bloco").style.display="none";;'><img src="./images/menu_visivel.png" width="333" height="8" border="0" />
            </td>
          </tr>	
        </table>
        
        
        
      </div>
    </li>
  </ul>
</div>
<?
		echo '
		<img src="./images/menu_logo.png" align="left" border="0" style="width:52px;left:0;top:0;position:absolute;z-index:2;float:left;width:52px;">
			<table style="width:100%;" border="0" cellpadding="0" cellspacing="0"  id="menu_containers">
			<tr >			
			<td rowspan="2"></td>
			
			<td style="background-image:url(images/menu_centro_ext.jpg);repeat-x;overflow-y:hidden;" colspan="2"  >	
			<div style="margin-left:52px;height:18px;overflow:hidden;">
			<b style="font-size:14px;"> '.InfoSystem::titulo.' </b>
			| <b style="font-size:10px;color:#006600;"> '.InfoSystem::nome_sistema.' </b> | <b style="font-size:10px;">'.InfoSystem::subtitulo.' </b> 
			
			<span style="float:right;font-family:Verdana, Geneva, sans-serif;font-size:10px;">
			<strong >Login: </strong>'. strtoupper($_SESSION["login_session"]).' 			
			</span>
			
			</div>
			
			</td>
			 <td width="1" align="right" valign="top" height="30" style="background-image:url(images/menu_centro_ext.jpg)"><a border="0" href="http://www.ima.sp.gov.br/"  target="_blank" > <img src="./images/menu_direita.jpg" border="0" width="84" height="29" /></a></td>
			</tr>	
			
			<tr><td colspan="3" style="background-image:url(images/menu_centro_botton.png);background-position:top;color:#ffffff;background-repeat:repeat-x;background-color:#517f97" >
			
		
			<div style="text-indent:43px;width:auto;text-align:right;">

				
<img  src="./images/distribuir3.png"  style="cursor:pointer" border="0" onClick="distribuir_windows_in_3_colunas();"    onmouseover="this.src=\'./images/distribuir3_on.png\';"   onmouseout="this.src=\'./images/distribuir3.png\';"   />

<img  src="./images/divisoria_button.png"  style="" border="0"  />

<img  src="./images/emparelhar3.png"  style="cursor:pointer" border="0" onClick="emparelhar_windows_in_3_colunas();"    onmouseover="this.src=\'./images/emparelhar3_on.png\';"   onmouseout="this.src=\'./images/emparelhar3.png\';"   />
					
<img  src="./images/divisoria_button.png"  style="" border="0"  />

<img  src="./images/distribuir.png"  style="cursor:pointer" border="0" onClick="distribuir_windows();"    onmouseover="this.src=\'./images/distribuir_on.png\';"   onmouseout="this.src=\'./images/distribuir.png\';"   />					
					
<img  src="./images/divisoria_button.png"  style="" border="0"  />	

<img  src="./images/emparelhar.png"  style="cursor:pointer" border="0" onClick="emparelhar_windows();"    onmouseover="this.src=\'./images/emparelhar_on.png\';"   onmouseout="this.src=\'./images/emparelhar.png\';"   />
				
<img  src="./images/divisoria_button.png"  style="" border="0"  />

<img  src="./images/cascata.png"  style="cursor:pointer" border="0" onClick="cascade_windows();"    onmouseover="this.src=\'./images/cascata_on.png\';"   onmouseout="this.src=\'./images/cascata.png\';"   />
				
<img  src="./images/divisoria_button.png"  style="" border="0"  />

<img  src="./images/fechar_janelas.png"  style="cursor:pointer" border="0" onClick="close_windows();"   onmouseover="this.src=\'./images/fechar_janelas_on.png\';"   onmouseout="this.src=\'./images/fechar_janelas.png\';"   />
				
<img  src="./images/divisoria_button.png"  style="" border="0"  />

<img src="./images/menu_horizontal_icon.png" style="border:0;cursor:pointer"   onmouseover="this.src=\'./images/menu_horizontal_icon_on.png\';"   onmouseout="this.src=\'./images/menu_horizontal_icon.png\';"    id="example-horizontal"   >

<img  src="./images/divisoria_button.png"  style="" border="0"  />

<img  id="example-vertical"  src="./images/menu_vertical_icon.png" style="border:0;cursor:pointer"    onmouseover="this.src=\'./images/menu_vertical_icon_on.png\';"   onmouseout="this.src=\'./images/menu_vertical_icon.png\';"   >

<img  src="./images/divisoria_button.png"  style="" border="0"  />
				
<img  src="./images/logout.png"  style="cursor:pointer" border="0" onClick="sair();"   onmouseover="this.src=\'./images/logout_on.png\';"   onmouseout="this.src=\'./images/logout.png\';"   />
					
					
					</div>
					
					
			</td></tr>
			</table>				
		';
		}

		
		
		function menu_fim(){
		echo '
		</table></td>	  
		</tr> 
		</table>		
		</div>
		';
		}
		
		
		
				

		
		function fim_title_item(){	
		echo '</table ></td><tr/>';
		
		}
		
		
		function title_item($num,$nome,$id){	  	       		
		echo '
		<tr style="cursor:pointer;" onClick="exibe_menu(\''.retirar_acentos($nome).'\');" >
		<td title="'.$nome.'" class="fundo2" onMouseOver="this.className=\'fundo2on\'" onMouseOut="this.className=\'fundo2\'" >&nbsp;<strong >'.str_replace("_"," ",$nome).'</strong></td>
		</tr>	
		
		<tr><td><table id="'.retirar_acentos($nome).'"  cellpadding="0" cellspacing="0" style="margin-bottom:1px;" >
		';
		}		
		
		function item($nome,$nome_seq,$link){    
		echo '		
        <tr id="'.retirar_acentos($nome_seq).'" style=" cursor:pointer">
        <td>
        <table cellpadding="0" cellspacing="0" style="margin-top:1px;"><tr>       	             
		   <td class="fundo3"  onClick="'.$link.'"  onMouseOver="this.className=\'fundo3on\'" onMouseOut="this.className=\'fundo3\'">&nbsp; '.str_replace("_"," ",$nome).' </td>
           <td class="dir_border"></td>
           </tr>
		 </table>
          </td>
        </tr>		
		';
		}
		
		
		function sub_item_header(){    
			  echo '		
			  <tr style=" cursor:pointer">
			  <td>
			  <table width="180px" cellpadding="0" cellspacing="0" id="descricao" >                        
				<tr>
				  <td style="background:#fff"></td>
				  <td style="background-color:#fff;height:100%;font-family:Verdana, Geneva, sans-serif;font-weight:normal;font-size:10px;">  ';        
		}
		
		function sub_item($nome,$link){    
		echo '					
		 <span style="color: #15428b;">&nbsp;  &bull; </span><a onClick="'.$link.'" > '.str_replace("_"," ",$nome).'</a><br  />
		';
		}
		
		function sub_item_bottom(){    
			  echo '		
				  </td>
			<td style="background-image:url(./images/midle_dir_extjs.gif);background-repeat:repeat-y;width:9px;height:3px;";></td>
		  </tr>
		  <tr>
			<td style="background-image#fff"></td>
			<td style="background-image:url(./images/botton_extjs.gif);background-repeat:repeat-x;"></td>
			<td style="background-image:url(./images/botton_dir_extjs.gif);width:9px;height:8px;";></td>
		  </tr>
		</table>		 
          </td>
        </tr>	 ';        
		}

                  
		
		
		


		function load_xml (){			
				$_SESSION["menu_item"] = array(array(),array());		 
				$_SESSION["menu_subitem"] = array(array(),array(),array());	
				$doc = new DOMDocument();
				//if ($_SESSION["id_nivel_session"] == 1){
					$doc->load( './xml/menu.xml' );
				//}else{
					//$doc->load( './xml/menu2.xml' );
				//}
				$itens = $doc->getElementsByTagName( "item" );				
				foreach( $itens as $item ) {
					$aux = $item->getElementsByTagName( "nome" );
					$nome =utf8_decode( $aux->item(0)->nodeValue );					
					$subitem = $item->getElementsByTagName( "subitem" );					
					$_SESSION["menu_item"]["item"][] =  $nome;					
					foreach ($subitem as $sub){
						$aux = $sub->getElementsByTagName("titulo");
						$titulo = $aux->item(0)->nodeValue;				
						$_SESSION["menu_item"][retirar_acentos($nome)]["titulo"][] =  utf8_decode($titulo);
						$aux = $sub->getElementsByTagName("onclick");
						$onclick = $aux->item(0)->nodeValue;	
						$_SESSION["menu_item"][retirar_acentos($nome)]["onclick"][] =  $onclick;	
						$aux = $sub->getElementsByTagName("permission");
						$permission = $aux->item(0)->nodeValue;	
						$_SESSION["menu_item"][retirar_acentos($nome)]["permission"][] =  $permission;		
						
						///// subitem  //////////////////////////////////
						$sub_itens = $sub->getElementsByTagName("subitem_nivel2");						
						foreach( $sub_itens as $sub_iten) {
							  $aux = $sub_iten->getElementsByTagName("titulo");
							  $subtitulo = $aux->item(0)->nodeValue;				
							  $_SESSION["menu_subitem"][retirar_acentos($nome)][$titulo]["titulo"][] =  utf8_decode($subtitulo);
							  $aux = $sub_iten->getElementsByTagName("onclick");
							  $onclick = $aux->item(0)->nodeValue;	
							  $_SESSION["menu_subitem"][retirar_acentos($nome)][$titulo]["onclick"][] =  $onclick;	
							  $aux = $sub_iten->getElementsByTagName("permission");
							  $permission = $aux->item(0)->nodeValue;	
							  $_SESSION["menu_subitem"][retirar_acentos($nome)][$titulo]["permission"][] =  $permission;				
						}		
						////////////////////////////////////////////////////
						 // echo "$nome - $titulo \n";						 
					}					
				}	
		}
		
		
		
} // -fim da classe ------------------------------------------------








?>

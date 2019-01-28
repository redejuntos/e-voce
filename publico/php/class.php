<?

class layout {

			function cabecalho(){		
				//echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
				//"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';		
				echo '
					<HEAD>					
					<meta http-equiv="Cache-Control" content="no-cache, no-store" />
					<meta http-equiv="Pragma" content="no-cache, no-store" />
					<meta http-equiv="expires" content="Mon, 06 Jan 1990 00:00:01 GMT" />
						
				'; //<meta http-equiv="X-Frame-Options" content="deny">	
			}
			function js($path){
				/*
				echo '
				<script src="'.$path.'/js/functions.js" type="text/javascript"></script>		
				<script src="'.$path.'/js/time.js" type="text/javascript"></script>		
				<script src="'.$path.'/js/data.js" type="text/javascript"></script>		
				<script src="'.$path.'/js/calendar.js" type="text/javascript"></script>		
				';
				*/
				echo '
				<script src="'.$path.'/js/functions.js" type="text/javascript"></script>			
				<script src="'.$path.'/js/data.js" type="text/javascript"></script>	
				<script src="'.$path.'/js/time.js" type="text/javascript"></script>		
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
						<script type="text/javascript" src="'.$path.'/js/thickbox.js"></script>
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
			
			function bootstrap($path){
				echo '				
				<link href="'.$path.'/css/bootstrap.css" rel="stylesheet" type="text/css" 
				<link href="'.$path.'/css/bootstrap-responsive.css"" rel="stylesheet" type="text/css"  />
				';	
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
			
			function datepicker($path){
				echo '
					<!-- datepicker -->    
					  <link type="text/css" href="'.$path.'/css/redmond/jquery-ui-1.8.12.custom.css" rel="stylesheet" />	
					  <link rel="stylesheet" href="'.$path.'/css/layout_widget.css">
					';
			}
			
			function toastmessage($path){
				echo '
					<!-- toastmessage -->    
					  <link type="text/css" href="'.$path.'/css/jquery.toastmessage-min.css" rel="stylesheet" />	
					  <script type="text/javascript" src="'.$path.'/js/jquery.toastmessage-min.js"></script>
					';
			}
			
			
			function flexslider($path){
				echo '
					<!-- toastmessage -->    
					  <link type="text/css" href="'.$path.'/css/flexslider.css" rel="stylesheet" />	
					  <script type="text/javascript" src="'.$path.'/js/jquery.flexslider.js"></script>	
					  <script>
					  $(window).load(function() {
						$(\'.flexslider\').flexslider({
						  animation: "slide",
						  start: function(slider){
							$(\'body\').removeClass(\'loading\');
						  }
						});
					  });  
					  </script>
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
						\'transitionOut\'	: \'none\'
					});		
					
					
					$("a.fancyframe").fancybox({
											   
	
						\'height\'			    : \'95%\',
						\'width\'				: 800,						
						\'fitToView\'           : false,
						  autoSize              : true,						
						\'autoScale\'			: true,
					   	closeClick              : true,
						openEffect              : \'fade\',
						closeEffect             : \'fade\',
						padding     : 0,
						\'transitionIn\'		: \'none\',
						\'transitionOut\'		: \'none\',
						\'type\'				: \'iframe\'
					});
					
					
					
				});
				


				
				
				</script>		
				';	
			}
			
			

		

			
			function body_onload($onload,$onscroll,$background){
				echo '
				</HEAD><body onload="'.$onload.'" onscroll="'.$onscroll.'" background="'.$background.'"  style="background-repeat:no-repeat"  marginheight="0" marginwidth="0" bottommargin="0" rightmargin="0" topmargin="0" leftmargin="0" >		
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




/////////////////////////////////////////////////////////////////////////////////////////
//////   cadastro projetos /////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////






class menu {
		
		function menu(){ //construtor
			
			$this -> load_xml();
			
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
		
		function cabecalho(){
		echo '	
		<link href="./css/menu_vertical.css" rel="stylesheet" type="text/css">	
		<script src="./js/functions.js" type="text/javascript"></script>	
		<script src="./js/floater.js" type="text/javascript"></script>	
		';
		}
		
		function menu_inicio(){
		echo '
		<table  border="0" align="left" cellpadding="0" cellspacing="0" style="margin:0;height:0 auto;width:180px" >
		<tr>
		<td rowspan="4" style="cursor:pointer;width:20px;background: #fff url(./images/coluna_blue.gif) repeat-Y center top;" valign="middle" id="menu_lateral" onmouseover="this.style.background = \'url(./images/coluna_blue_on.gif)\';"   onmouseout="this.style.background = \'url(./images/coluna_blue.gif)\';"><div style="width:20px;"><img src="./images/seta_left.gif" style="border:0;cursor:pointer;margin-left:3px;" id="img_seta_menu"></div></td>
		<td  align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif;font-size:9px;background:#003366 url(./images/tb_blue.gif) repeat-X center top;height:15px;width:180px; "><div style="width:165px;float:left;">
		</div><div style="width:15px;height:15px;text-align:right;float:right;"><img id="go_home" src="./images/go_home.gif" style="border:0;cursor:pointer;" ></div>
		</td>
		</tr>		
		<tr>		
		<td align="left"  valign="top">		
		<table width="180" border="0" align="left" cellpadding="0" cellspacing="0" class="fonte">
		<tr style="cursor:pointer;"  >
		<td ><div style="font-family:Verdana, Geneva, sans-serif;font-size:10px;overflow:hidden;width:180px;" ><div style="margin:5px 0 5px 0;padding:2px 0 2px 0;background-color:#ffffff;text-align:center;border:1px solid #99bbe8" ><strong >Login de Acesso: </strong><br />'. strtoupper($_SESSION["login_session"]).'</div></div></td>
		</tr>
		';
		}
		

		
		
		function menu_fim(){
		echo '
		<tr style="cursor:pointer" onClick="parent.openAeroWindow(\'alterar_senha\',10,\'center\',450,200,\'Alterar Senha\',\'./php/telas.php?table=usuario&amp;go_to_page=alterar_senha\');" >
		<td class="fundo2" onMouseOver="this.className=\'fundo2on\'" onMouseOut="this.className=\'fundo2\'">&nbsp; Alterar Senha 		  
		</td>
		</tr>


	
		
		<tr style="cursor:pointer" onClick="sair();" >
		<td class="fundo2" onMouseOver="this.className=\'fundo2on\'" onMouseOut="this.className=\'fundo2\'">&nbsp; SAIR		  
		</td>
		</tr>
		
		
		
		</table></td>	  
		</tr> 
		

		</table>
		';
		}
		
		
		
				
		function footer(){
		echo '
		</body>
		</html>	
		';
		}
		
		function fim_title_item(){	
		echo '</table ></td><tr/>';
		
		}
		
		
		function title_item($num,$nome,$id){	  	       		
		echo '
		<tr style="cursor:pointer;" onClick="exibe_menu(\''.$nome.'\');" >
		<td title="'.$nome.'" class="fundo2" onMouseOver="this.className=\'fundo2on\'" onMouseOut="this.className=\'fundo2\'" >&nbsp;<strong >'.str_replace("_"," ",$nome).'</strong></td>
		</tr>	
		
		<tr><td><table id="'.$nome.'"  cellpadding="0" cellspacing="0" style="margin-bottom:1px;" >
		';
		}		
		
		function item($nome,$nome_seq,$link){    
		echo '		
        <tr id="'.$nome_seq.'" style=" cursor:pointer">
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
		


		function load_xml (){			
				$_SESSION["menu_item"] = array(array(),array());		  
				$doc = new DOMDocument();
				if ($_SESSION["id_nivel_session"] == 1){
					$doc->load( './xml/menu.xml' );
				}else{
					$doc->load( './xml/menu2.xml' );
				}
				$itens = $doc->getElementsByTagName( "item" );				
				foreach( $itens as $item ) {
					$aux = $item->getElementsByTagName( "nome" );
					$nome = $aux->item(0)->nodeValue;					
					$subitem = $item->getElementsByTagName( "subitem" );					
					$_SESSION["menu_item"]["item"][] =  utf8_decode($nome);					
					foreach ($subitem as $sub){
						$aux = $sub->getElementsByTagName("titulo");
						$titulo = $aux->item(0)->nodeValue;				
						$_SESSION["menu_item"][$nome]["titulo"][] =  utf8_decode($titulo);
						$aux = $sub->getElementsByTagName("onclick");
						$onclick = $aux->item(0)->nodeValue;	
						$_SESSION["menu_item"][$nome]["onclick"][] =  $onclick;						
						 // echo "$nome - $titulo \n";						 
					}					
				}	
		}
		
		
		
} // -fim da classe ------------------------------------------------








?>

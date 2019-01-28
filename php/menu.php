<?

//ini_set("display_errors", "0"); //Retira o Warning

ini_set( 'error_reporting', E_ALL ^ (E_NOTICE | E_DEPRECATED) ); // mostra todas mensagens exceto notice e deprecated
ini_set( 'display_errors', '1' );

session_start();

$menu = new menu;
$menu -> head();	

?>

<style>
/* override number of coluns */

.sf-menu li {
	text-align:center
}
.sf-menu li li {
	width:auto; 
}


</style>


<script>

function resize_abas(){	
  	    var lista_menu = document.getElementById("lista_menu_horizontal");  
 		var linhas_usadas = Math.floor(parseFloat(lista_menu.clientHeight)/25) ;
		 //25 é o numero de pixels da altura que cada linha do menu é exibido		 
		var abas_principais = lista_menu.childNodes.length;	
		
		//se menu usa mais de uma linha, diminui no calculo do tamanho da aba
		//if (linhas_usadas>2) abas_principais = parseFloat(abas_principais)-linhas_usadas;
		
		var tamanho_aba = (window.document.body.clientWidth - (window.document.body.clientWidth/100 * 5) ) / abas_principais;
			  
		$(".sf-menu li").css("width", tamanho_aba);	
		$(".sf-menu li li").css("width", tamanho_aba);  
		$(".sf-menu li li ul").css("left", tamanho_aba);
		$(".sf-shadow ul").css("width", tamanho_aba);
	  //  alert(tamanho_aba);
 
 		
}





(function($,sr){ // reslve o problema do duplo resize no chrome
  var debounce = function (func, threshold, execAsap) {
      var timeout;
      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null; 
          };
          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);
          timeout = setTimeout(delayed, threshold || 100); 
      };
  }
  // once_resize 
  jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
})(jQuery,'once_resize');


// usage:
$(window).once_resize(function(){  
	if(document.getElementById("table_menu_vertical")){  // se está habilitado em menu verticaL				
			// não redefine abas
	}else{
			resize_abas();	
	}
	responsive_layout();   
});






window.onload = function(){
	var keep_static_value_browser_width = window.document.body.clientWidth;
	resize_abas();
    $("#example-horizontal").click(
		function(){ 
			atualiza_conteudo('./menu_horizontal.php','','POST','handleHttpResponseMenuHorizontal');
		}
	);
	$("#example-vertical").click(
		function() { 
			//$("#example").addClass("sf-vertical");		
			atualiza_conteudo('./menu_vertical.php','','POST','handleHttpResponseMenuVertical');			
		}
	);
}

function handleHttpResponseMenuVertical(){	//para retornar num select
	if (http.readyState == 4) {
		document.getElementById("menu").innerHTML = http.responseText;			
		init_menu();
		reposition_conteiners();
	}
}

function handleHttpResponseMenuHorizontal(){	//para retornar num select
	if (http.readyState == 4) {
		document.getElementById("menu").innerHTML = http.responseText;		
		resize_abas();
		init_menu();
		reposition_conteiners();
		$("ul.sf-menu").superfish();
	}
}

  
</script>



<?
$menu = new menu;
$menu -> superfish();
$menu -> functions();
$menu -> int_vertical_functions_menu();

echo '<div id="menu" style="width:auto;height:0 auto;">';	
 require_once ("./menu_horizontal.php");	
 echo '</div>';
		   		   
?>
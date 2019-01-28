


function emitir_relatorio(form){	

					 
			 
					 
	  if   (form.id_desafio.value == ""){
		 alert("É preciso escolher o desafio");
		 return false;
	  }
					 				 
	//  if (at_least_one){ //envia consulta	  
	  		  // open('','new_window','width='+screen.width+',height='+screen.height+',resizable=yes,scrollbars=yes,statusbar=yes');
			 //  open('','new_window','width='+620+',height='+450+',resizable=yes,scrollbars=yes,statusbar=yes');
			    var myDate = new Date();
		//	parent.openAeroWindow('',80,'center',620,450,'', "php/emitir_relatorio.php?time="+myDate.getTime()+"&data_inicio="+form.data_inicio.value +"&data_fim="+form.data_fim.value);
		
		 if(form.grafico[form.grafico.selectedIndex].value != ""){
			 parent.openAeroWindow('',80,'center',620,450,'', "php/"+form.grafico[form.grafico.selectedIndex].value	+".php?time="+myDate.getTime()+"&id_desafio="+form.id_desafio.value );	
			 parent.distribuir_windows_in_3_colunas();
		 }else{ //todos os graficos
			parent.openAeroWindow('',80,'center',620,450,'', "php/multidepthpie.php?time="+myDate.getTime()+"&id_desafio="+form.id_desafio.value);	
			parent.openAeroWindow('',80,'center',620,450,'', "php/chart_cylinderbar.php?time="+myDate.getTime()+"&id_desafio="+form.id_desafio.value );	
			//parent.openAeroWindow('',80,'center',620,450,'', "php/tempo_solicitacao.php?time="+myDate.getTime()+"&data_inicio="+form.data_inicio.value +"&data_fim="+form.data_fim.value);	
			parent.distribuir_windows_in_3_colunas();
			
		 }		
	//  }else{
		  //alert("É preciso preencher pelo menos um parâmetro para gerar o relatório");
	 // }
}



function adicionar_checklist(form){	
	var myDate = new Date();
	var vetor = new Array ("nome_checklist");	
	var msg= new Array("nome do checklist");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }	  
	  form.target = "grid_iframe";
	  form.action = "operacoes.php?adicionar_checklist=yes"+"&time="+myDate.getTime();
	  form.submit();

}





function check_pergunta(obj,id_solicitacao,id_pergunta,id_opcao){			
		var form = obj.form;
		var id = obj.name.toString().replace("complemento_","");
		
		if (document.getElementById("pergunta_"+id).checked == false){
			alert("É preciso marcar a opção antes de preencher o comentário"); 
			document.getElementById("pergunta_"+id).focus();					
		}
}


function atualiza_complemento(obj,id_solicitacao,id_pergunta,id_opcao,id_empresa){	
		atualiza_conteudo("operacoes.php","update_complemento=yes&id_solicitacao="+id_solicitacao+"&id_pergunta="+id_pergunta+"&id_opcao="+id_opcao+"&id_empresa="+id_empresa+"&value="+ encodeURIComponent(obj.value),"POST",handleHttpQuestion); 		
}


function atualiza_checkbox(obj,id_solicitacao,id_pergunta,id_opcao,id_empresa){	
		if (obj.checked == false){
			var id = obj.id.toString().replace("pergunta_","");	
			//alert(document.getElementById("complemento_"+id));
			if (document.getElementById("complemento_"+id)){
				document.getElementById("complemento_"+id).value = "";					
			}
		}
		atualiza_conteudo("operacoes.php","update_checkbox=yes&id_solicitacao="+id_solicitacao+"&id_pergunta="+id_pergunta+"&id_opcao="+id_opcao+"&id_empresa="+id_empresa+"&value="+obj.checked,"POST",handleHttpQuestion);   		
}

function atualiza_radiobox(obj,id_solicitacao,id_pergunta,id_opcao,id_empresa){	

		var form = obj.form;
		if(obj.checked == true){  // todos os radiobox clicados sao igual a true				
			 for (var x=0;x<form.elements[obj.name].length;x++){
				// alert(form.elements[obj.name][x]);
				// alert(form.elements[obj.name][x].id);
				 var id = form.elements[obj.name][x].id.toString().replace("pergunta_","");	
				  if (document.getElementById("complemento_"+id)){
						  document.getElementById("complemento_"+id).value = "";					
				  }
			 }
		}



		atualiza_conteudo("operacoes.php","update_radiobox=yes&id_solicitacao="+id_solicitacao+"&id_pergunta="+id_pergunta+"&id_opcao="+id_opcao+"&id_empresa="+id_empresa+"&value="+obj.checked,"POST",handleHttpQuestion); 
}


function atualiza_resposta_checklist(resposta, id_solicitacao, id_checklist, id_item_checklist){	
		atualiza_conteudo("operacoes.php","update_resposta_checklist=yes&id_solicitacao="+id_solicitacao+"&id_checklist="+id_checklist+"&id_item_checklist="+id_item_checklist+"&resposta="+resposta,"POST",handleHttpQuestion);   		
}




function set_label(value){	
	var label = document.getElementById("tipo_pessoa_label");
	label.innerHTML = value;	
}



function handleHttpResponseAreaCultural(){//para retornar num select

// dar select na cidade tambem	
	campo_select = document.forms[0].id_modalidade;
	if (http.readyState == 4) {		
		campo_select.options.length = 0;
		results = http.responseText.split("##ajax##");		
		//campo_select.options[0] = new Option( 'selecione', '' );
		for( i = 0; i < results.length-1; i++ ){ 			
			//alert(results[results.length-1]);return false;
			string = trim(results[i]).split( "|" );		
		//	if (trim(string[0])==document.getElementById("id_modalidade").value){
			//	campo_select.options[i] = new Option( string[0], string[1], "", 'selected' );
		//	}else{
				campo_select.options[i] = new Option( string[0], string[1] );
		//	}
		}
	}
}

function confimaPergunta(acao,id,texto){
	var ok;
	ok = confirm(texto);
	if(ok){		
		executa_acao(acao,id);
	}else{
		return false;  
	}
}
  
function confirma_acao(acao,id){
	switch (acao){	
		case "save":			
				var texto = "Já existe um usuário cadastrado com esse nome \nSe continuar com esse procedimento será criado um homônimo para esse usuário.\nTem certeza que deseja criar um homônimo?";
				confimaPergunta(acao,id,texto);
			break;						
		default:
			alert("acao nao declarada");
			break;	
	}		
}

function executa_acao(acao,id){
	switch (acao){
		case "update":		
			document.forms[0].action='./operacoes.php?acao=update&id='+id;
			break;			
		case "save":			
			document.forms[0].action='./operacoes.php?acao=save';
			break;			
		case "savecomo":			
			document.forms[0].action='./operacoes.php?acao=save';
			break;			
		default:
			alert("acao nao declarada");
			break;	
	}	
	document.forms[0].method="POST";
	document.forms[0].target="grid_iframe";
	document.forms[0].submit();
}




function alterar_desafio(form,cod){	
	var myDate = new Date();
	var vetor = new Array ("nome_desafio");	
	var msg= new Array("Nome do Desafio");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }	  
	  form.target = "grid_iframe";
	  form.action = "operacoes.php?alterar_desafio=yes&cod="+cod+"&time="+myDate.getTime();
	  form.submit();
}



				  
				  
function alterar_topico(form,cod){	
	var myDate = new Date();
	var vetor = new Array ("nome_topico","id_desafio");	
	var msg= new Array("Nome do Tópico"," Selecionar Desafio");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }	  
	  form.target = "grid_iframe";
	  form.action = "operacoes.php?alterar_topico=yes&cod="+cod+"&time="+myDate.getTime();
	  form.submit();
}





function adicionar_situacao(form){	
	var myDate = new Date();
	var vetor = new Array ("nome_situacao");	
	var msg= new Array("nome do situacao");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }	  
	  form.target = "grid_iframe";
	  form.action = "operacoes.php?adicionar_situacao=yes"+"&time="+myDate.getTime();
	  form.submit();

}


function alterar_situacao(form,cod){	
	var myDate = new Date();
	var vetor = new Array ("nome_situacao");	
	var msg= new Array("nome do situacao");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }	  
	  form.target = "grid_iframe";
	  form.action = "operacoes.php?alterar_situacao=yes&cod="+cod+"&time="+myDate.getTime();
	  form.submit();

}

function adicionar_pendencia(form){	
	var myDate = new Date();
	var vetor = new Array ("titulo");	
	var msg= new Array("Título");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }	  
	 
	  for (i=0; i < self.frames.length; i++){
			  if (self.frames[i].name.search("Xinha")!=-1){	
				   if  ( 
						( trim(self.frames[i].document.body.innerHTML) ==  "")||
					    ( trim(self.frames[i].document.body.innerHTML) ==  "<br>")
				   ){
						  alert("Faltou conteúdo em Pendência !");				
						  return false;														
				   }
			  }
	  }
	 
	 
	 
	 
	 
	  form.target = "grid_iframe";
	  form.action = "operacoes.php?adicionar_pendencia=yes"+"&time="+myDate.getTime();
	  form.submit();

}


function alterar_profissao(form,cod){	
	var myDate = new Date();
	var vetor = new Array ("nome_profissao");	
	var msg= new Array("nome do profissao");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }	  
	  form.target = "grid_iframe";
	  form.action = "operacoes.php?alterar_profissao=yes&cod="+cod+"&time="+myDate.getTime();
	  form.submit();

}




function adicionar_ocupacao(form){	
	var myDate = new Date();
	var vetor = new Array ("nome_tipo_ocupacao");	
	var msg= new Array("nome da ocupacao");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }	  
	  form.target = "grid_iframe";
	  form.action = "operacoes.php?adicionar_ocupacao=yes"+"&time="+myDate.getTime();
	  form.submit();

}


function alterar_ocupacao(form,cod){	
	var myDate = new Date();
	var vetor = new Array ("nome_tipo_ocupacao");	
	var msg= new Array("nome do ocupacao");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }	  
	  form.target = "grid_iframe";
	  form.action = "operacoes.php?alterar_ocupacao=yes&cod="+cod+"&time="+myDate.getTime();
	  form.submit();

}



function adicionar_objeto(form){	
	var myDate = new Date();
	var vetor = new Array ("nome_objeto");	
	var msg= new Array("nome do objeto");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }	  
	  form.target = "grid_iframe";
	  form.action = "operacoes.php?adicionar_objeto=yes"+"&time="+myDate.getTime();
	  form.submit();

}


function alterar_objeto(form,cod){	
	var myDate = new Date();
	var vetor = new Array ("nome_objeto");	
	var msg= new Array("nome do objeto");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }	  
	  form.target = "grid_iframe";
	  form.action = "operacoes.php?alterar_objeto=yes&cod="+cod+"&time="+myDate.getTime();
	  form.submit();
}








function gerar_relatorio_operacoes(form){	
	var vetor = new Array ("data_inicial", "hora_inicial", "data_final", "hora_final");		
	var msg= new Array("Data Inicial", "Hora Inicial", "Data Final", "Hora Final");				 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou digitar "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }		 
	 
	 
	if (valida_data_relatorio(form.elements["data_inicial"].value,form.elements["data_final"].value)){	 
		form.target = "grid_iframe";
		form.action = "operacoes.php?gerar_relatorio_operacoes=yes";
		form.submit();
	}
}









function get_data_horario(value){
document.getElementById("viagem_info").innerHTML="";
open('ajax_open_data.php?get_data_horario=yes&id_viagem='+value,'action_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');
}

function relatorio_filtro_login(value){
open('ajax_open_data.php?relatorio_filtro_login=yes&id_usuario='+value,'action_iframe','width=1,height=1,resizable=yes,scrollbars=yes,statusbar=yes');
}


  




 
 
 

function handleHttpBairro()//para retornar num select
{	
	for (x=1;x<=1;x++){
		eval('campo_select = document.forms[0].cod_logradouro_ref_'+x+';');
		if (http.readyState == 4) {
			campo_select.options.length = 0;		
			results = http.responseText.split(",");
			campo_select.options[0] = new Option( 'Escolha uma referência', '' );
			for( i = 0; i < results.length-1; i++ ){ 
				string = trim(results[i]).split( "|" );
				//if (trim(string[0])==document.getElementById("subcategoria_value").value){
				//campo_select.options[i] = new Option( string[0], string[1], "", 'selected' );
				//}else{
					campo_select.options[i+1] = new Option( string[0], string[1] );
				//}
			}
		}
	}
	
}

function handleHttpResponse2()//para retornar num select
{
campo_select = document.forms[0].cod_bairro;
if (http.readyState == 4) {
campo_select.options.length = 0;
results = http.responseText.split(",");
for( i = 0; i < results.length-1; i++ )
{ 
string = trim(results[i]).split( "|" );
campo_select.options[i] = new Option( string[0], string[1] );
}
}
}

function handleHttpResponse()//para retornar num select
{
	campo_select = document.forms[0].subcategoria;
	if (http.readyState == 4) {
		campo_select.options.length = 0;
		results = http.responseText.split(",");
		for( i = 0; i < results.length-1; i++ ){ 
			string = trim(results[i]).split( "|" );
			if (trim(string[0])==document.getElementById("subcategoria_value").value){
				campo_select.options[i] = new Option( string[0], string[1], "", 'selected' );
			}else{
				campo_select.options[i] = new Option( string[0], string[1] );
			}
		}
	}
}


function handleHttpResponse_texto() //para retornar texto
{
campo_text = document.forms[0].subcategoria;
if (http.readyState == 4) {
campo_text = http.responseText;
}
}

function pesquisar_dados( name,valor){		

switch (name){
	case "regiao":
		http.open("GET", "ajax_open_data.php?cod_"+name+"=" + valor, true);
		http.onreadystatechange = handleHttpResponse2;
		break;
	case "categoria":	
		http.open("GET", "ajax_open_data.php?cod_"+name+"=" + valor, true);
		http.onreadystatechange = handleHttpResponse;		
		break;
	case "cod_bairro":		
		http.open("GET", "ajax_open_data.php?"+name+"=" + valor, true);
		http.onreadystatechange = handleHttpBairro;		
		break;
	default:
		break	
}
http.send(null);
}


function busca_cep(obj){
	if(obj.value.length == 9){
		var myDate = new Date();
		var str = obj.value.replace("-","");	
	atualiza_conteudo("ajax_open_data.php","busca_cep=yes&cep="+str+"&time="+myDate.getTime(),"GET","handleHttpbuscacep");
	}
}

function handleHttpbuscacep(){ //para retornar texto
        if(http.readyState < 4) {
            //document.getElementById("").innerHTML= "Loading...";
        }		
		
        if (http.readyState == 4) {
                if (http.status ==200) {										
					results = http.responseText.split("#split#");
					document.form_area.endereco.value=(results[0] == "")?"":results[0];
					document.form_area.bairro.value=(results[1] == "")?"":results[1];
					document.form_area.tipo_logradouro.value=(results[2] == "")?"":results[2];
					document.form_area.cod_logradouro.value=(results[3] == "")?"":results[3];
					document.form_area.numero.focus();
                } else {
                   alert("Houve um problema ao obter os dados:\n" + http.statusText);                   
                }
        }
}

function handleHttpCategoria(){//para retornar num select	
	campo_select = document.getElementById("subcategoria");
	
	if (http.readyState == 4) {
		campo_select.options.length = 0;
		//alert(http.responseText);
		results = http.responseText.split("##ajax_split##");			
		
		campo_select.options[0] = new Option( 'selecione', '' );
		for( i = 0; i < results.length-1; i++ ){ 		
			string = trim(results[i]).split( "|" );			
			if (trim(string[0])==document.getElementById("subcategoria_value").value){
				campo_select.options[i+1] = new Option( string[0], string[1], "", 'selected' );
			}else{
				campo_select.options[i+1] = new Option( string[0], string[1] );
			}
		}				
		//value_str=results[i];
		//while (value_str.search("010101") > 0){
			//value_str=value_str.replace("010101",",");
		//}
		//document.getElementById("descricao").innerHTML=value_str;
		//document.getElementById("resultado_busca").style.display="none";
		//document.getElementById("pesquisar").value="";	
		//document.getElementById("pesquisar").focus();	
	}
}
function handleHttpSubcategoria(){			
		if (http.readyState == 4) {			
		//alert(http.responseText);
	//	results = http.responseText;			
	//	document.getElementById("categoria_resultados").innerHTML=results;		
	
		//	results = http.responseText.split(",");			
			//for( i = 0; i < results.length-1; i++ ){ 
				//string = trim(results[i]).split( "|" );
				//if (trim(string[0])==document.getElementById("subcategoria_value").value){
				//campo_select.options[i] = new Option( string[0], string[1], "", 'selected' );
				//}else{
					//campo_select.options[i+1] = new Option( string[0], string[1] );
				//}
			//}
		}	
}

function handleHttpServico(){	//para retornar num select
	campo_select = document.getElementById("categoria");
		if (http.readyState == 4) {
		campo_select.options.length = 0;
		//alert(http.responseText);
		results = http.responseText.split("##ajax_split##");			
		campo_select.options[0] = new Option( 'selecione', '' );
		for( i = 0; i < results.length-1; i++ ){ 		
			string = trim(results[i]).split( "|" );			
			if (trim(string[0])==document.getElementById("subcategoria_value").value){
				campo_select.options[i+1] = new Option( string[0], string[1], "", 'selected' );
			}else{
				campo_select.options[i+1] = new Option( string[0], string[1] );
			}
		}				
		//value_str=results[i];
		//while (value_str.search("010101") > 0){
			//value_str=value_str.replace("010101",",");
		//}
		//document.getElementById("descricao").innerHTML=value_str;
		//document.getElementById("resultado_busca").style.display="none";
		//document.getElementById("pesquisar").value="";	
		//document.getElementById("pesquisar").focus();	
	}	
}


function mostra_edital(n,t){
	  var str_botoes;
	  var x;
	  str_botoes="";
	  for (x=1;x<=t;x++){
		  str_botoes += "edital"+x+",";
	  }
	  str_botoes=str_botoes.slice(0,str_botoes.length-1);
	  esconde(str_botoes);

	  for (x=1;x<=n;x++){	  		  	
		document.getElementById("div_edital"+x).style.display = "";
		document.getElementById("edital"+x).removeAttribute('disabled');
      }	
}		
			

function mostra(n,t){
var str_botoes;
var x;
str_botoes="";
for (x=1;x<=t;x++){
	str_botoes=str_botoes+"anexo"+x+",";
}
str_botoes=str_botoes.slice(0,str_botoes.length-1);
esconde(str_botoes);

	  for (x=1;x<=n;x++){	  		  	
		document.getElementById("div_anexo"+x).style.display = "";
		document.getElementById("anexo"+x).removeAttribute('disabled');
      }
}	

function esconde(str_botoes){	
	   var vetor=str_botoes.split(",");
	  var x;
	  for (x=0;x<vetor.length;x++){	  	
	  	//alert(vetor[x])
		document.getElementById("div_"+ vetor[x]).style.display = "none";
		document.getElementById(vetor[x]).setAttribute('disabled',true);

      }
}		

function handleHttpResponseCidade(){//para retornar num select

	campo_select = document.forms[0].id_municipio_comercial;
	if (http.readyState == 4) {
		campo_select.options.length = 0;
		results = http.responseText.split(",");
		for( i = 0; i < results.length-1; i++ ){			
				string = trim(results[i]).split( "|" );	
				campo_select.options[i] = new Option( string[0], string[1] );		
		}
		
		
		var conteudo = document.createElement('div');
		conteudo.innerHTML=http.responseText;
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}			
	}
}
	

			
			


function handleHttpResponseCampanha(){//para retornar num select

	campo_select = document.forms[0].id_categoria;
	if (http.readyState == 4) {
		campo_select.options.length = 0;
		campo_select.options[0] = new Option( 'Selecione uma Categoria', '' );
		results = http.responseText.split("##ajax_split##");
		for( i = 0; i < results.length-1; i++ ){			
				string = trim(results[i]).split( "|" );	
				campo_select.options[i+1] = new Option( string[0], string[1] );		
		}				
		var conteudo = document.createElement('div');
		conteudo.innerHTML=http.responseText;
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}	
		
		if(document.forms[0].id_subcategoria) {
			document.forms[0].id_subcategoria.options.length = 0;
		}
		if(document.forms[0].id_pergunta) {
			document.forms[0].id_pergunta.options.length = 0;
		}
		document.getElementById("texto_pergunta_opcao").style.display ="none";
		
	}
}







function handleHttpResponseCategoria(){//para retornar num select

	campo_select = document.forms[0].id_subcategoria;
	if (http.readyState == 4) {
		campo_select.options.length = 0;
		campo_select.options[0] = new Option( 'Selecione uma SubCategoria', '' );
		results = http.responseText.split("##ajax_split##");
		for( i = 0; i < results.length-1; i++ ){			
				string = trim(results[i]).split( "|" );	
				campo_select.options[i+1] = new Option( string[0], string[1] );		
		}
		
		
		var conteudo = document.createElement('div');
		conteudo.innerHTML=http.responseText;
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}		
		
		if(document.forms[0].id_pergunta) {
			document.forms[0].id_pergunta.options.length = 0;
		}
		
		document.getElementById("texto_pergunta_opcao").style.display ="none";
	}
}





function handleHttpResponsePerguntas(){//para retornar num select
	campo_select = document.forms[0].id_pergunta;
	if (http.readyState == 4) {
		campo_select.options.length = 0;
		campo_select.options[0] = new Option( 'Selecione uma Pergunta', '' );
		//alert(http.responseText);
		results = http.responseText.split("##ajax_split##");
		for( i = 0; i < results.length-1; i++ ){			
				string = trim(results[i]).split( "|" );	
				campo_select.options[i+1] = new Option( string[0], string[1] );		
		}		
		
		var conteudo = document.createElement('div');
		conteudo.innerHTML=http.responseText;
		
	//	document.getElementById("texto_pergunta_opcao").innerHTML = string[0];
		
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}			
		
		document.getElementById("texto_pergunta_opcao").style.display ="none";
	}
}
function handleHttpResponseOpcoes(){//para retornar num select
	
	if (http.readyState == 4) {
		document.getElementById("texto_pergunta_opcao").style.display ="";
		
		document.getElementById("texto_pergunta_opcao").innerHTML = http.responseText;		
		
		var id_campanha =  document.forms[0].id_campanha.options[document.forms[0].id_campanha.selectedIndex].value;
		
		var id_subcategoria =  document.forms[0].id_subcategoria.options[document.forms[0].id_subcategoria.selectedIndex].value;
		
		var id_categoria =  document.forms[0].id_categoria.options[document.forms[0].id_categoria.selectedIndex].value;
		
		var id_pergunta =  document.forms[0].id_pergunta.options[document.forms[0].id_pergunta.selectedIndex].value;
		
		
		var myDate = new Date();
		document.getElementById("grid").src = "listar.php?table=opcoes&"+'id_campanha='+id_campanha+'&id_categoria='+id_categoria+'&id_subcategoria='+id_subcategoria +'&id_pergunta='+id_pergunta+'&titulo=opcoes&time='+myDate.getTime();

		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}		
	}

}





function handleHttpResponseDesenvolvedor(){//para retornar num select
	if (http.readyState == 4) {
		var conteudo = document.getElementById("descricao_desenvolvedor");
		conteudo.style.display = "";
		conteudo.innerHTML=http.responseText;		
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}			
	}
}


function handleHttpResponseMantenedor(){//para retornar num select
	if (http.readyState == 4) {
		var conteudo = document.getElementById("descricao_mantenedor");
		conteudo.style.display = "";
		conteudo.innerHTML=http.responseText;		
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}			
	}
}


function refreshSoftware(form){
	form.action = '';
	form.submit();
}


  function checkbox_all(form,obj,arrayName){	  

	if(obj.checked){	
		   if (form.elements[arrayName].length==undefined){
			   	   form.elements[arrayName].checked = true;		
				   this.scroll(0,99999999);	   
		   }else{				
			   for(i= 0;i<form.elements[arrayName].length;i++){		
				   form.elements[arrayName][i].checked = true;		
				   this.scroll(0,99999999);
			   }
		   }
	}else{
		   if (form.elements[arrayName].length==undefined){
				   form.elements[arrayName].checked = false;	
				   this.scroll(0,0);		   
		   }else{						
			   for(i= 0;i<form.elements[arrayName].length;i++){
				   form.elements[arrayName][i].checked = false;	
				   this.scroll(0,0);
			   }
		   }
	}  
  }
  

  





function  valida_modalidade(form){	
	var vetor = new Array ("tipo", "standard_title");		
	var msg= new Array("Modalidade", "Título");	
		
	for (x=0;x<vetor.length;x++){	  					
	   	if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			form.elements[vetor[x]].focus();	
			return(0);
		}		
     }	
	 return true;
}


function alterar_modalidade(form){		
	if (valida_modalidade(form)){
		document.frmcadastro.action="operacoes.php?alterar_texto_padrao_modalidade=yes";
		document.frmcadastro.target = "grid_iframe";
		document.frmcadastro.submit();
	}
}
  
  
function incluir_modalidade(form){	
	if (valida_modalidade(form)){
		document.frmcadastro.action="operacoes.php?incluir_texto_padrao_modalidade=yes";
		document.frmcadastro.target = "grid_iframe";
		document.frmcadastro.submit();	
	}
}

 

function handleHttpRefreshMenu(){//para retornar num select
	if (http.readyState == 4) {		
		parent.parent.window.document.getElementById("menu").innerHTML = http.responseText;
		parent.init_menu();
		alert("Ordem da Modalidade Alterada com Sucesso!");	
	}
}


function handleHttpAlteraMenu(){//para retornar num select
	if (http.readyState == 4) {		
		parent.parent.window.document.getElementById("menu").innerHTML = http.responseText;
		parent.init_menu();
		alert("Modalidade Alterada com Sucesso!");	
	}
}

function handleHttpInsereMenu(){//para retornar num select
	if (http.readyState == 4) {		
		parent.parent.window.document.getElementById("menu").innerHTML = http.responseText;
		parent.init_menu();
		alert("Modalidade Inserida com Sucesso!");	
	}
}

function handleHttpExcluirMenu(){//para retornar num select
	if (http.readyState == 4) {		
		parent.parent.window.document.getElementById("menu").innerHTML = http.responseText;
		parent.init_menu();
		//alert("Modalidade Excluída com Sucesso!");	
	}
}



function  valida_evento(form){	
	var vetor = new Array ("id_tipo", "licitacao_nome","nro_licitacao");		
	var msg= new Array("Modalidade", "Título","Nº Licitacao");	
		
	for (x=0;x<vetor.length;x++){	  					
	   	if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			form.elements[vetor[x]].focus();	
			return(0);
		}		
     }	
	if(form.flag_eletronico_presencial){
		if (form.flag_eletronico_presencial.value == ""){
			alert("Faltou Selecionar Tipo da Modalidade");
			form.flag_eletronico_presencial.focus();
			return false;	
		}
	}	 
	 return true;
}




function incluir_evento(form){	
	if (valida_evento(form)){
		form.method = "POST";
		form.action="cadastro.php";
		form.submit();	
	}
}





function alterar_evento(form){	
	if (valida_evento(form)){
		form.method = "POST";
		form.action="alterar_modalidade.php";
		form.submit();	
	}
}





function combo_str(form)  {
   	var combo_str="";
	  
	  
	  if (form.publish.value == ""){
		  alert("Por favor, preencha a data de entrada");	
		  form.publish.focus();
		  return false;	
	  }
	  if (form.expire.value == ""){
		  alert("Por favor, preencha a data de saída");	
		  form.expire.focus();
		  return false;	
	  }
	  
	  if (form.field_reports.length==undefined){
		  combo_str="";
	  }else{
		  for(i= 0;i<form.field_reports.length;i++){
				  if  (form.field_reports[i].checked){					
					  if (combo_str==""){
						  combo_str=form.field_reports[i].value;
					  }else{
						  combo_str=combo_str+","+form.field_reports[i].value;
					  }
				  }
		   }	
	  }
	  
	  form.field_combo_str.value=combo_str;
	  form.action="relatorios.php";
	  
	 form.submit();
}



	function config_advanced(){
		if(document.getElementById("config_advanced").style.display == ""){			
			document.getElementById("config_advanced").style.display = "none";
			document.getElementById("marca_todos").style.display = "none";
		}else{
			document.getElementById("config_advanced").style.display="";
			document.getElementById("marca_todos").style.display ="";
		}
	}
	
	


  
  
function visualizar_anexo(id,form){
		var action_old = form.action;
		var target_old = form.target;	
		obj = document.getElementById(id);		

		form.anexo_view_nome.value = obj.name;	
		
		//var clone_obj = obj.cloneNode(true)
		//clone_obj.id = "clone_"+obj.id;			
		//form.appendChild(clone_obj);	

		form.target = "_blank";
		form.action = "anexo_view.php";
		form.submit();
		form.target = target_old;
		form.action = action_old;
		
}
  
  
  
  

function create_profissional(){
	obj = document;
	var itens = obj.getElementById("tabela_profissional");	
	var total_linhas = obj.getElementById("tabela_profissional").rows.length;//numero de linhas da tabela
			//for (i=0; i<total_linhas; i++){		
				//var line = itens.rows[i].id.toString();	
				//if (line.search("linha")!=-1)		{						
					//aux = line.replace("linha","");	
				//	if (obj.getElementById("linha_"+aux).value==""){				
					//obj.getElementById("show_valor_"+aux).innerHTML='';
				//}
				//alert(total_linhas);
			//}
      var tab = itens.insertRow(total_linhas);
      tab.id = "linha_"+total_linhas;
      var x = tab.insertCell(0);
      x.innerHTML = obj.getElementById("linha_0").innerHTML;

	  obj2 = obj.getElementById("linha_"+total_linhas).getElementsByTagName("input");	
	  
	   for (x=0;x<obj2.length;x++){	 				
			switch (obj2[x].type){
				  case "text":
					  obj2[x].value = "";
					  break;		
	  			  case "file":
					  //no action
					  break;
			      case "hidden":
					  //no action
					  break;
				  default:				  	  
					  break;
			}
	   }
	   
	   
			
	  obj3 = obj.getElementById("linha_"+total_linhas).getElementsByTagName("fieldset");	
		 
	  obj3[1].innerHTML = '<legend style="font-size:9px" >Assinatura</legend> <INPUT TYPE="file" class="input" NAME="assinatura[]"  style="width:300px;height:150px;background-image:url(../images/inserir_assinatura.png);background-repeat:no-repeat;border:0px;cursor:pointer"><input type="hidden" name="imagem_assinatura[]" value="">';
		 
	
	  obj4 = obj.getElementById("linha_"+total_linhas).getElementsByTagName("textarea");	
	  obj4[0].innerHTML = "";
	
	  obj5 = obj.getElementById("linha_"+total_linhas).getElementsByTagName("select");	
	  obj5[0].selectedIndex = 0;
}



  function delete_profissional(){
	  obj = document;
	  var total_linhas = obj.getElementById("tabela_profissional").rows.length;//numero de linhas da tabela
	//  var aux = lnh.replace("linha","");
	
      lnh = total_linhas -1 ;
	  
	  if (lnh == 0){
		  alert("Não é possível apagar todos os profissionais. O preenchimento de pelo menos um profissional é obrigatório !");
		  return false;
	  }
	  
	  var ok;
	  ok = confirm("Confirma Apagar Último Registro de Profissional?");
	  if(ok)	  
		document.getElementById("tabela_profissional").deleteRow(document.getElementById("linha_"+lnh).rowIndex);
	  else
		  return(0);
	       
  }
  
 function delete_yourself(obj){	  
	 if (obj.id == "linha_0"){
		 alert ("Não é Possível apagar o Primeiro Profissional Técnico Vinculado");
		 return false;
	 }else{	 
		  var ok;
		  ok = confirm("Confirma Apagar esse Registro?");
		  if(ok)	  
			document.getElementById("tabela_profissional").deleteRow(obj.rowIndex);
		  else
			  return false;		  
	 }
 }
  
  
  
  
function check_first_professional(){	
	obj = document;
	var itens = obj.getElementById("tabela_profissional");	
	var total_linhas = obj.getElementById("tabela_profissional").rows.length;//numero de linhas da tabela
			for (i=0; i<total_linhas; i++){		
				var line = itens.rows[i].id.toString();	
				if (line.search("linha")!=-1){						
					  aux = line.replace("linha","");							
					  obj2 = obj.getElementById("linha"+aux).getElementsByTagName("input");		
					  //if (aux == "_0"){		
					  		//alert(obj2[3].name);return false;
							var vetor = new Array (obj2[0], obj2[3],obj2[4],obj2[5]);		
							var msg= new Array("Nome Responsável","E-mail","CREA", "CPF");									
							for (x=0;x<vetor.length;x++){	  					
								if(vetor[x].value == ""){	
									alert("É Obrigatório o Preenchimento do "+msg[x] +" do Profissional Vinculado!");
									$('#tabs').tabs('select', 'resp_tec');
									vetor[x].focus();	
									return false;
								}		
							 }		
					//  }
					
					obj3 = obj.getElementById("linha"+aux).getElementsByTagName("select");		
					//alert(obj3[0].selectedIndex );
					if (obj3[0].selectedIndex == 0){
							alert("É Obrigatório Escolher o Titulo Profissional");
							obj3[0].focus();
							return false;
					}
				}				
			}	
	return true;
}



 function alterar_empresa(form,cod){	 
 	var add = "";
 	var myDate = new Date();
	var vetor= new Array("razao_social","cnpj","email");
	var msg= new Array("Razão Social","CNPJ","E-mail");	
	for (x=0;x<vetor.length;x++){	  					
		if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			$('#tabs').tabs('select', 'tabs-1');
			form.elements[vetor[x]].focus();	
			return false;
		}		
	}	
	
	
	if ((form.elements["senha"].value != "")||(form.elements["confirmar_senha"].value != "")){		
			if (paridade_alterar_senha(form)){
				  if (form.senha.value.length < 8){
					  alert("Sua nova senha deve ter pelo menos 8 digitos");
					  $('#tabs').tabs('select', 'tabs-2');
					  form.senha.value="";
					  form.confirmar_senha.value="";
					  form.senha.focus();
					  return false;
				  }else{
						var add = "&alteracao_senha=yes"  
				  }
			}else{
				$('#tabs').tabs('select', 'tabs-2');
				return false;
			}
	}
	
	
	email = form.elements["email"];	
	if (check_mail(email)){		  
		  form.target = "grid_iframe";
		  form.action="operacoes.php?alterar_empresa=yes&cod="+cod+"&time="+myDate.getTime()+add;
		  form.submit();		
	}
 }


  
 function adicionar_empresa(form){	  
	var vetor= new Array("razao_social","nome_fantasia","cnpj","data_fundacao","inscricao_estadual","inscricao_municipal","endereco","numero","cep","bairro","responsavel","cargo","email","telefone","celular");
	var msg= new Array("Razão Social","Nome Fantasia","CNPJ","Data Fundação","Inscrição Estadual","Inscrição Municipal","Endereço","nº","CEP","Bairro","Nome do Contato","Cargo / Função","E-mail","Telefone","Celular");		
	for (x=0;x<vetor.length;x++){	  					
		if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			$('#tabs').tabs('select', 'tabs-1');
			form.elements[vetor[x]].focus();	
			return false;
		}		
	}	 
	 
	 
	var vetor= new Array("senha","confirmar_senha");
	var msg= new Array("Senha de Acesso","Confirmar Senha");		
	for (x=0;x<vetor.length;x++){	  					
		if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			$('#tabs').tabs('select', 'tabs-2');
			form.elements[vetor[x]].focus();	
			return false;
		}		
	}	 
	
		
	if (form.senha.value.length < 8){
		alert("Sua nova senha deve ter pelo menos 8 digitos");
		$('#tabs').tabs('select', 'tabs-2');
		form.senha.value="";
		form.confirmar_senha.value="";
		form.senha.focus();
		return false;
	}
	
	if (paridade_alterar_senha(form)){		
		  email = form.elements["email"];	
		  if (check_mail(email)){				  
			  form.target = "grid_iframe";
			  form.action="operacoes.php?adicionar_empresa=yes";
			  form.submit();	
		  }		
	}
	

 }
 
 
   

 

 
 
 

 

 




 
function salvar_login(form) {
	var x;		
	var vetor= new Array("cpf_cnpj","senha","confirmar_senha","email");
	var msg= new Array("CPF ou CNPJ","Senha","Confirmar sua Senha","E-mail");		
		
	for (x=0;x<vetor.length;x++){	  					
		if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			form.elements[vetor[x]].focus();	
			return(0);
		}		
	}	 
	
	
 	if ( (form.elements["fisica_juridica"][0].checked == false)&& (form.elements["fisica_juridica"][1].checked == false)){
		alert("Faltou Escolher Tipo de Pessoa - CPF ou CNPJ");
		form.elements["fisica_juridica"].focus();
	} 
	
	 
	if (form.senha.value.length < 8){
		alert("Sua nova senha deve ter pelo menos 8 digitos");
		form.value="";
		form.senha.value="";
		form.confirmar_senha.value="";
		form.senha.focus();
		return false;
	}
	
	
	
	email = form.elements["email"];	
	if (check_mail(email)){		   
	   if (paridade_alterar_senha(form)){			   
		 form.action="./php/ajax_open_data.php?cadastro_senha=yes"; 			
		 form.method="post";  
		 form.target = "grid_iframe";
		 form.submit();  
	   }
	}	
 } 
 
 

 
 function lembrar_senha_submit(form) {
	var x;		
	var vetor= new Array("email","cpf_cnpj");
	var msg= new Array("E-mail","CPF ou CNPF");		
	
		  
	for (x=0;x<vetor.length;x++){	  					
		if(form.elements[vetor[x]].value == ""){				
			alert("Faltou "+msg[x] +"!");
			form.elements[vetor[x]].focus();	
			return(0);
		}		
	}	 
   
	   form.action="./php/operacoes.php?lembrar_senha=yes"; 			  
			   		 
		 form.method="post";  
		 form.target = "lembrar_senha_iframe";
		 form.submit();  
 } 

 

function busca_proprietario(form){	
	if (form.cpf_cnpj.value){		
		atualiza_conteudo("operacoes.php","busca_proprietario=yes&cod="+form.cpf_cnpj.value+"&id_solicitacao="+form.id_solicitacao.value+"&fisica_juridica="+getRadioValue(form.fisica_juridica),"POST","handleHttpproprietario");	
	}else{
		alert("Preencha Primeiro o CPF / CNPJ");
		form.cpf_cnpj.focus();
	}
}




function delete_project_label(obj,e){	
	if(e.keyCode == 8){		
  			setTimeout(function() { 
  							  document.getElementById("project_label").innerHTML = obj.value;		
							}, 300);	
	}	
}


function set_project_label(obj,e){		
	  			setTimeout(function() { 
  							  document.getElementById("project_label").innerHTML = obj.value;		
							}, 300);	
}


function fechar_projeto(){	
	var container = parent.window.document.getElementById("Containerincluir_solicitacao");		  
	container.style.display =  "none";
}




function alterar_solicitacoes(form,msg){		
	 form.action="./operacoes.php?alterar_solicitacao=yes&msg="+msg; 			
	 form.method="post";  
	 form.target = "grid_iframe";
	 form.submit();	 		
}
 



 


 



function salvar_checklist(form){	
	obj = document;
	var preenchido = false;
	var itens = obj.getElementById("tabela_checklist");	
	var total_linhas = obj.getElementById("tabela_checklist").rows.length;//numero de linhas da tabela
			for (i=0; i<total_linhas; i++){		
				var line = itens.rows[i].id.toString();	
				if (line.search("linha")!=-1){						
					  aux = line.replace("linha","");							
					  obj2 = obj.getElementById("linha"+aux).getElementsByTagName("input");								
					  		if ((obj2[0].checked == true)||(obj2[1].checked == true)||(obj2[2].checked == true)||(obj2[3].checked == true)){
									var preenchido = true;
							}
							
							
							if  ((obj2[0].checked == true)&& (obj2[1].checked == false) && (obj2[2].checked == false) && (obj2[3].checked == false) ){								
									alert("Escolha Sim ou Não ou Não se aplica para o item ´"+obj2[0].parentNode.nextSibling.innerHTML+"´ que foi marcado como verificado");
									obj2[1].focus();
									return false;
							}			
				}				
			}	
	if (preenchido){	
	
			if  ( (form.id_situacao.value == 5)||(form.id_situacao.value == 6) ){				
						if  (form.id_situacao.value == 6) { 
							//analise concluida
							document.getElementById("tabs-doc").style.display = "";
							document.getElementById("documentos_title").style.display = "";
							$('#tabs').tabs('select', 'tabs-doc');							
							alert("Selecione os documentos necessários"); 										
						}else{
							// correções					
							
						}				
				//  
			}else{
				alert ("Você não alterou a situação do Projeto, para enviar email é preciso que a situção da análise esteja concluída.");
				//  var ok = confirm("Você não alterou a situação do Projeto, para enviar email é preciso que a situção da análise esteja concluída.");
				//  if(ok){}					
			}
	
	
			var myDate = new Date();
			form.target = "grid_iframe";	
			form.action = "operacoes.php?salvar_checklist=yes&time="+myDate.getTime();
			form.submit();
	}else{
			alert("É preciso preencher pelo menos um item para salvar o checklist");	
	}
}

function salvar_documentos(form){	
	var myDate = new Date();
	form.target = "grid_iframe";	
	form.action = "operacoes.php?salvar_documentos=yes&time="+myDate.getTime();
	form.submit();	
}





function envia_dados_email(form){
	
	var vetor = new Array ("email","assunto");		
	var msg= new Array("Email", "Assunto");		
		 
	for (x=0;x<vetor.length;x++){	
		var aux = form.elements[vetor[x]].value;		
	   	if (aux == ""){				
			alert("Faltou "+msg[x] +" !");		
			form.elements[vetor[x]].focus();	
			return false;
		}		
     }		 	 

	form.target = "grid_iframe";
	form.action = "operacoes.php?envia_email=yes";
	form.submit();
		
}

 


function ver_planta_original(){
	location.href=document.getElementById("planta_original").href;
}



function emitir_boletos_vencidos(form){	
	  for (x = 0; x < form.length; x++ ) 	  
			if ((form[x].type == "text")||(form[x].type == "select-one"))
				if(form[x].value != "")
					 var at_least_one = true;		
					 
	  if  (  (form.data_inicio.value == "")&&(form.data_fim.value != "")||(form.data_inicio.value != "")&&(form.data_fim.value == "")  ){
		  alert("É preciso preencher a Data Inicial e Final para consultar por Período");
		  return false;
	  }
					 				 
	  if (at_least_one){ //envia consulta	  
	  		   open('','new_window_boletos','width='+screen.width+',height='+screen.height+',resizable=yes,scrollbars=yes,statusbar=yes');
			   var myDate = new Date();
			   form.method = "POST";
			   form.target = "new_window_boletos";
			   form.action = "listar_boletos_vencidos.php?time="+myDate.getTime();
			   form.submit();	
	  }else{
		  alert("É preciso preencher pelo menos um parâmetro para gerar o relatório");
	  }
}

function executa_filtro_consulta(form){	
	  for (x = 0; x < form.length; x++ ) 	  
			if ((form[x].type == "text")||(form[x].type == "select-one"))
				if(form[x].value != "")
					 var at_least_one = true;		
					 
	  if  (  (form.data_inicio.value == "")&&(form.data_fim.value != "")||(form.data_inicio.value != "")&&(form.data_fim.value == "")  ){
		  alert("É preciso preencher a Data Inicial e Final para consultar por Período");
		  return false;
	  }
					 				 
	  if (at_least_one){ //envia consulta	  
			   var myDate = new Date();
			   form.method = "POST";
			   form.target = "iframe_aerosolicitacoes";
			   form.action = "listar.php?table=solicitacoes&time="+myDate.getTime();
			   form.submit();	
			   var container = parent.window.document.getElementById("Containerfiltro_consulta_form");		  
			   container.style.display =  "none";
	  }else{
		  alert("É preciso preencher pelo menos um parâmetro para gerar o relatório");
	  }
}


function finalizar_questionario(form,id_questionario,id_solicitacao){
	var myDate = new Date();	
	var pergunta_obrigatoria= form.id_pergunta_array.value.split(",");	
 
	for (var y=0;y<pergunta_obrigatoria.length;y++){								
		 var el = form.elements["pergunta_"+pergunta_obrigatoria[y]] ;	

		 if (el.length > 1){ // radiobox, checkbox
				for (j=0;j<el.length;j++){	
					var field_type = el[j].type.toLowerCase();								
				}							 
		 }else{
			 var field_type = el.type.toLowerCase();
		 }
			
		  var at_least_one = 0;
		  switch (field_type){
				case "text":	
					if (el.value==""){
						alert("Faltou preencher questão obrigatória:\n -"+document.getElementById("label_pergunta_"+pergunta_obrigatoria[y]).innerHTML);	
						el.focus();	
						return false;				  
					} 
					break;				
				case "textarea":	
				   break;						  
				case "radio":	 
					   for (var w=0;w<el.length;w++){ 									   			
								if(el[w].checked == true){ 
								  at_least_one = 1;
								}
					   }
					   if (!at_least_one){
						   alert("Faltou preencher questão obrigatória:\n -"+document.getElementById("label_pergunta_"+pergunta_obrigatoria[y]).innerHTML);
						   el[0].focus();
						   return false;
					   }
					break;
				case "checkbox":	
					   for (var w=0;w<el.length;w++){ 
								if(el[w].checked == true){ 
								  at_least_one = 1;
								}
					   }
					   if (!at_least_one){
						   alert("Faltou preencher questão obrigatória:\n -"+document.getElementById("label_pergunta_"+pergunta_obrigatoria[y]).innerHTML);
						   el[0].focus();
						   return false;
					   }
					break;
				case "select-one":
					break;	
				case "select-multi":								  
					break;	  
				default:
					break;
		  }
	}
					
	var ok;
	
	if (id_questionario == 1) {
		ok = confirm("Após Finalizar, não será mais possível alterar as respostas. Confirma?");
	} else {
		ok = true;
	}
	
	ok = true;
  	if(ok){		
		  form.target = "grid_iframe";
		  form.action = "operacoes.php?finalizar_questionario=yes&id_questionario="+id_questionario+"&id_solicitacao="+id_solicitacao+"&time="+myDate.getTime();
		  form.submit();
    }				  
}




function incluir_nova_solicitacao(id_empresa){		  
	  	atualiza_conteudo("operacoes.php","incluir_nova_solicitacao=yes&id_empresa="+id_empresa,"POST",handleHttpIncluirNovaSolicitacao); 
}

function handleHttpIncluirNovaSolicitacao(){//para retornar num select
	if (http.readyState == 4) {		
		if(http.responseText){					
			var myDate = new Date();		  
			var window_opener = parent.parent.window.document.getElementById("iframe_aerosolicitacoes");
			window_opener.src = window_opener.src+"&"+myDate.getTime();	
			alert(http.responseText);			
		}else{
			alert('Já existe solicitação ativa para essa empresa, favor cancelar ou finalizar a solicitação atual');			
		}
		var scripts = conteudo.getElementsByTagName("script");
		for(i = 0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);
		}
		
		return false;
	}
}



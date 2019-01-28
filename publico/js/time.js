function evita_letra(tecla){
     if (tecla.keyCode < 45 || tecla.keyCode > 57 || tecla.keyCode == 47 || tecla.keyCode == 45 || tecla.keyCode == 46)  
          tecla.returnValue = false;  
}
function FormataHora(campo,obj,teclapres){
	var tecla = teclapres.keyCode;
	vr = obj.value;
	vr = vr.replace( ":", "" );
	tam = vr.length + 1;
	
	if ( tecla != 9 && tecla != 8 ){
		if ( tam > 2 && tam < 5 ){
			obj.value = vr.substr( 0, tam - 2  ) + ':' + vr.substr( tam - 2, tam );
		}
	}
	
}


function Mascara_Hora(obj){ 
	if (obj.value.length == 2){ 
		obj.value += ':';
	} 
	//if (hora01.length == 5){ 
	//Verifica_Hora(); 
	//} 
} 


function testa_hora(hora, obj, campo){ // função complementar para testar a validade da data
	if(!is_hora(hora)){
		alert('Digite uma hora válida');
		obj.value = '';
		obj.focus();
		return false;
	}else{
		return true;	
	}
}

function is_hora(horas, formname, campo){
	var hora, minuto;
	var retval = false;
	hora = horas.substring(0,2);
	minuto = horas.substring(3,5)
	if(hora < 24 && minuto < 60)
		retval = true;
	
	return retval;
}
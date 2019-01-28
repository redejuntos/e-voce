// JavaScript Document


function distribuir_windows_in_3_colunas(){
	var el = document.getElementsByTagName("DIV");	
	var time = 0;
	var coluna= 1;
	var add_height = 0;	add_height1 = 0;	add_height2 = 0;	add_width2 = 0;add_height3 = 0;	add_width3 = 0;
	for (var y in el){	
		if(y != el[y].id.toString()){ // corrige bug do firefox	
			if(el[y].id){
				  if( el[y].id.toString().indexOf("Container") == 0){					  
						var id = el[y].id;					
						if (el[y].childNodes[0].style.display != "none"){
							time++;		
							
							switch (coluna){
								  case "1": 	 //coluna da esquerda								  
									  add_height = add_height1;
									  add_width = '0';			
									  add_width2 = el[y].childNodes[0].style.width;	
									  add_height1  += parseFloat(el[y].childNodes[0].style.height.replace("px",""));
									  break;
								  case "2":   //coluna do meio
									  add_height = add_height2;
									  add_width = add_width2;	
									  add_width3 = el[y].childNodes[0].style.width + add_width2;
									  add_height2  += parseFloat(el[y].childNodes[0].style.height.replace("px",""));	
									  break;
								  case "3"://coluna da direita
									  add_height = add_height3;
									  add_width = add_width3;	
									  add_height3  += parseFloat(el[y].childNodes[0].style.height.replace("px",""));	
									  break;
								  default:
									  break;
							}
							if (coluna <=2){
								coluna++;
							}else{
								coluna =1;
							}					
							set_distribuir_windows(id,time,add_width,add_height);
							
						}
				  }	
			}
		}
	}	
}
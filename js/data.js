
var isNav4 = false, isNav5 = false, isIE4 = false
var strSeperator = "/"; 
var vDateType = 3; 

var vYearType = 4; 
var vYearLength = 2; 
var err = 0; 
if(navigator.appName == "Netscape") {
	if (navigator.appVersion < "5") {
		isNav4 = true;
		isNav5 = false;
	}
else if (navigator.appVersion > "4") {
		isNav4 = false;
		isNav5 = true;
	}
}else {
	isIE4 = true;
}


function newDataValidate(obj) {
// regular expression to match required date format
    var reDate = /(?:0[1-9]|[12][0-9]|3[01])\/(?:0[1-9]|1[0-2])\/(?:19|20\d{2})/;
    if(obj.value != '' && !reDate.test(obj.value)) {
    		alert("Data Inválida: " + obj.value+"\nPor favor, digite novamente");
			obj.value = "";
     	    obj.focus();
            return false;	  
    }
	return true;
}



function DateFormat(vDateName, vDateValue, e, dateCheck, dateType) {
	vDateType = dateType;
	if (vDateValue == "~") {
		alert("AppVersion = "+navigator.appVersion+" \nNav. 4 Version = "+isNav4+" \nNav. 5 Version = "+isNav5+" \nIE Version = "+isIE4+" \nYear Type = "+vYearType+" \nDate Type = "+vDateType+" \nSeparator = "+strSeperator);
		vDateName.value = "";
		vDateName.focus();
		return true;
	}
	var whichCode = (document.all) ?  e.keyCode:e.which ;
		//alert(whichCode);
		alert(e.which);
	
	if (vDateValue.length > 8 && isNav4) {
		if ((vDateValue.indexOf("-") >= 1) || (vDateValue.indexOf("/") >= 1))
		return true;
	}
	var alphaCheck = " abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/-";
	if (alphaCheck.indexOf(vDateValue) >= 1) {
		if (isNav4) {
			vDateName.value = "";
			vDateName.focus();
			vDateName.select();
			return false;
		} else {
			vDateName.value = vDateName.value.substr(0, (vDateValue.length-1));
			return false;
		}
	}

	if (whichCode == 8)
		return false;
	else {
	var strCheck = '47,48,49,50,51,52,53,54,55,56,57,58,59,95,96,97,98,99,100,101,102,103,104,105,65,67,86,17';//67,86,17 foram adicionados para permitir Ctrl C + Ctrl V em 15/02/2007
	
	if (strCheck.indexOf(whichCode) != -1) {
	if (isNav4) {
	if (((vDateValue.length < 6 && dateCheck) || (vDateValue.length == 7 && dateCheck)) && (vDateValue.length >=1)) {
		alert("Data Invalida!\nPor Favor Re-Digite");
		vDateName.value = "";
		vDateName.focus();
		vDateName.select();
		return false;
	}
	if (vDateValue.length == 6 && dateCheck) {
	var mDay = vDateName.value.substr(2,2);
	var mMonth = vDateName.value.substr(0,2);
	var mYear = vDateName.value.substr(4,4)
	if (mYear.length == 2 && vYearType == 4) {
	var mToday = new Date();
	var checkYear = mToday.getFullYear() + 30; 
	var mCheckYear = '20' + mYear;
	if (mCheckYear >= checkYear)
	mYear = '19' + mYear;
	else
	mYear = '20' + mYear;
	}
	var vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
	if (!dateValid(vDateValueCheck)) {
	alert("Data Invalida!\nPor Favor Re-Digite");
	vDateName.value = "";
	vDateName.focus();
	vDateName.select();
	return false;
	}
	return true;
	}
	else {
	if (vDateValue.length >= 8  && dateCheck) {
	if (vDateType == 1)
	{
	var mDay = vDateName.value.substr(2,2);
	var mMonth = vDateName.value.substr(0,2);
	var mYear = vDateName.value.substr(4,4)
	vDateName.value = mMonth+strSeperator+mDay+strSeperator+mYear;
	}
	if (vDateType == 2)
	{
	var mYear = vDateName.value.substr(0,4)
	var mMonth = vDateName.value.substr(4,2);
	var mDay = vDateName.value.substr(6,2);
	vDateName.value = mYear+strSeperator+mMonth+strSeperator+mDay;
	}
	if (vDateType == 3)
	{
	var mMonth = vDateName.value.substr(2,2);
	var mDay = vDateName.value.substr(0,2);
	var mYear = vDateName.value.substr(4,4)
	vDateName.value = mDay+strSeperator+mMonth+strSeperator+mYear;
	}
	var vDateTypeTemp = vDateType;
	vDateType = 1;
	var vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
	if (!dateValid(vDateValueCheck)) {
	alert("Data Invalida!\nPor Favor Re-Digite");
	vDateType = vDateTypeTemp;
	vDateName.value = "";
	vDateName.focus();
	vDateName.select();
	return false;
	}
	vDateType = vDateTypeTemp;
	return true;
	}
	else {
	if (((vDateValue.length < 8 && dateCheck) || (vDateValue.length == 9 && dateCheck)) && (vDateValue.length >=1)) {
	alert("Data Invalida!\nPor Favor Re-Digite");
	vDateName.value = "";
	vDateName.focus();
	vDateName.select();
	return false;
			 }
		  }
	   }
	}
	else {
	if (((vDateValue.length < 8 && dateCheck) || (vDateValue.length == 9 && dateCheck)) && (vDateValue.length >=1)) {
	alert("Data Invalida!\nPor Favor Re-Digite");
	vDateName.value = "";
	vDateName.focus();
	return true;
	}
	if (vDateValue.length >= 8 && dateCheck) {
	if (vDateType == 1)
	{
	var mMonth = vDateName.value.substr(0,2);
	var mDay = vDateName.value.substr(3,2);
	var mYear = vDateName.value.substr(6,4)
	}
	if (vDateType == 2)
	{
	var mYear = vDateName.value.substr(0,4)
	var mMonth = vDateName.value.substr(5,2);
	var mDay = vDateName.value.substr(8,2);
	}
	if (vDateType == 3)
	{
	var mDay = vDateName.value.substr(0,2);
	var mMonth = vDateName.value.substr(3,2);
	var mYear = vDateName.value.substr(6,4)
	}
	if (vYearLength == 4) {
	if (mYear.length < 4) {
	alert("Data Invalida!\nPor Favor Re-Digite");
	vDateName.value = "";
	vDateName.focus();
	return true;
	   }
	}
	var vDateTypeTemp = vDateType;
	vDateType = 1;
	var vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
	if (mYear.length == 2 && vYearType == 4 && dateCheck) {
	var mToday = new Date();
	var checkYear = mToday.getFullYear() + 30; 
	var mCheckYear = '20' + mYear;
	if (mCheckYear >= checkYear)
	mYear = '19' + mYear;
	else
	mYear = '20' + mYear;
	vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
	if (vDateTypeTemp == 1)
	vDateName.value = mMonth+strSeperator+mDay+strSeperator+mYear;
	if (vDateTypeTemp == 3)
	vDateName.value = mDay+strSeperator+mMonth+strSeperator+mYear;
	} 
	if (!dateValid(vDateValueCheck)) {
	alert("Data Invalida!\nPor Favor Re-Digite");
	vDateType = vDateTypeTemp;
	vDateName.value = "";
	vDateName.focus();
	return true;
	}
	vDateType = vDateTypeTemp;
	return true;
	}
	else {
	if (vDateType == 1) {
	if (vDateValue.length == 2) {
	vDateName.value = vDateValue+strSeperator;
	}
	if (vDateValue.length == 5) {
	vDateName.value = vDateValue+strSeperator;
	   }
	}
	if (vDateType == 2) {
	if (vDateValue.length == 4) {
	vDateName.value = vDateValue+strSeperator;
	}
	if (vDateValue.length == 7) {
	vDateName.value = vDateValue+strSeperator;
	   }
	} 
	if (vDateType == 3) {
	if (vDateValue.length == 2) {
	vDateName.value = vDateValue+strSeperator;
	}
	if (vDateValue.length == 5) {
	vDateName.value = vDateValue+strSeperator;
	   }
	}
	return true;
	   }
	}
	if (vDateValue.length == 10&& dateCheck) {
	if (!dateValid(vDateName)) {
	
	alert("Data Invalida!\nPor Favor Re-Digite");
	vDateName.focus();
	vDateName.select();
	   }
	}
	return false;
	}
	else {
	if (isNav4) {
	vDateName.value = "";
	vDateName.focus();
	vDateName.select();
	return false;
	}
	else
	{
		if (document.all)vDateName.value = vDateName.value.substr(0, (vDateValue.length-1));
	return false;
			 }
		  }
	   }
}


function dateValid(objName) {
var strDate;
var strDateArray;
var strDay;
var strMonth;
var strYear;
var intday;
var intMonth;
var intYear;
var booFound = false;
var datefield = objName;
var strSeparatorArray = new Array("-"," ","/",".");
var intElementNr;
var strMonthArray = new Array(12);
strMonthArray[0] = "Jan";
strMonthArray[1] = "Feb";
strMonthArray[2] = "Mar";
strMonthArray[3] = "Apr";
strMonthArray[4] = "May";
strMonthArray[5] = "Jun";
strMonthArray[6] = "Jul";
strMonthArray[7] = "Aug";
strMonthArray[8] = "Sep";
strMonthArray[9] = "Oct";
strMonthArray[10] = "Nov";
strMonthArray[11] = "Dec";
strDate = objName;
if (strDate.length < 1) {
return true;
}
for (intElementNr = 0; intElementNr < strSeparatorArray.length; intElementNr++) {
if (strDate.indexOf(strSeparatorArray[intElementNr]) != -1) {
strDateArray = strDate.split(strSeparatorArray[intElementNr]);
if (strDateArray.length != 3) {
err = 1;
return false;
}
else {
strDay = strDateArray[0];
strMonth = strDateArray[1];
strYear = strDateArray[2];
}
booFound = true;
   }
}
if (booFound == false) {
if (strDate.length>5) {
strDay = strDate.substr(0, 2);
strMonth = strDate.substr(2, 2);
strYear = strDate.substr(4);
   }
}
if (strYear.length == 2) {
strYear = '20' + strYear;
}
strTemp = strDay;
strDay = strMonth;
strMonth = strTemp;
intday = parseInt(strDay, 10);
if (isNaN(intday)) {
err = 2;
return false;
}
intMonth = parseInt(strMonth, 10);
if (isNaN(intMonth)) {
for (i = 0;i<12;i++) {
if (strMonth.toUpperCase() == strMonthArray[i].toUpperCase()) {
intMonth = i+1;
strMonth = strMonthArray[i];
i = 12;
   }
}
if (isNaN(intMonth)) {
err = 3;
return false;
   }
}
intYear = parseInt(strYear, 10);
if (isNaN(intYear)) {
err = 4;
return false;
}
if (intMonth>12 || intMonth<1) {
err = 5;
return false;
}
if ((intMonth == 1 || intMonth == 3 || intMonth == 5 || intMonth == 7 || intMonth == 8 || intMonth == 10 || intMonth == 12) && (intday > 31 || intday < 1)) {
err = 6;
return false;
}
if ((intMonth == 4 || intMonth == 6 || intMonth == 9 || intMonth == 11) && (intday > 30 || intday < 1)) {
err = 7;
return false;
}
if (intMonth == 2) {
if (intday < 1) {
err = 8;
return false;
}
if (LeapYear(intYear) == true) {
if (intday > 29) {
err = 9;
return false;
   }
}
else {
if (intday > 28) {
err = 10;
return false;
      }
   }
}
//valida_data();
return true;
}
function LeapYear(intYear) {
if (intYear % 100 == 0) {
if (intYear % 400 == 0) { return true; }
}
else {
if ((intYear % 4) == 0) { return true; }
}
return false;
}



function subtrai_data(data1,data2){  //formato BR
	
	var ano1 = data1.toString().substring(6,10);
	var mes1 = data1.toString().substring(3,5);
	var dia1 = data1.toString().substring(0,2);
	
	var ano2 = data2.toString().substring(6,10);
	var mes2 = data2.toString().substring(3,5);
	var dia2 = data2.toString().substring(0,2);
	
	var SECOND = 1000;
	var MINUTE = SECOND * 60;
	var HOUR = MINUTE * 60;
	var DAY = HOUR * 24;
	
	//var data1dif = ano1 + mes1 + dia1;
	//var data2dif = ano2 + mes2 + dia2;
	var data1dif = Date.UTC(ano1,(mes1-1),dia1);
	var data2dif = Date.UTC(ano2,(mes2-1),dia2);
	
	/*
	if (data1dif > data2dif){
	alert("A data planejada deve ser menor que a data executada");
	return 0;
	}
	*/	
	var difParc = data2dif - data1dif; 
	var dif = Math.round(difParc/DAY);
	//alert(dif); //calcula diferença de dias	
	//////////////////// calcula dias uteis /////////////
	//var data1c = new Date(ano1,(mes1 - 1),dia1);
	//var data2c = new Date(ano2,(mes2 - 1),dia2);
	
	//var cont = 0;
	//var c = 0;
	//var x = 1;
	
	//for(i=0;i < dif;i++){ 
		//if((data1c.getDay() == 0)||(data1c.getDay() == 6)){
			//cont += 1;
		//}
		//c = parseInt(data1c.getDate()) + x;
	//	data1c.setDate(c);
	//}
	//alert(cont); //numero de sabados e domingos
	
	return (dif); //retorna a difença completa das datas

}

function valida_data(){
	var data1=document.forms[0].data_nascimento.value;
	var data2=document.forms[0].data_atual.value;
	var dif = subtrai_data(data1,data2);
	
	if (dif == 0){
		alert("Data Inválida\nInforme Corretamente");
		document.forms[0].data_nascimento.value = "";
		document.forms[0].data_nascimento.focus();
		return false;
	}
	if (dif < 0){
		alert("Data Inválida\nInforme Corretamente");
		document.forms[0].data_nascimento.value = "";
		document.forms[0].data_nascimento.focus();
		return false;
	}	
	
	
}
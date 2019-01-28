function formatDate(argDate) {
  var tmpYear  = String(argDate.getFullYear());
  var tmpMonth = String(argDate.getMonth()+1);
  var tmpDate  = String(argDate.getDate());

  tmpDate  = ((tmpDate.length==1)? '0':'')  + String(tmpDate);
  tmpMonth = ((tmpMonth.length==1)? '0':'') + String(tmpMonth);
 
  return(tmpDate +"/"+ tmpMonth +"/"+ tmpYear);
}

function getDayLabel(argNum) {
  switch(argNum) {
    case 0: return('Dom'); case 1: return('Seg'); case 2: return('Ter');
    case 3: return('Qua'); case 4: return('Qui'); case 5: return('Sex');
    case 6: return('Sab');
  }
}



function getMonthLabel(argNum) {
  switch(argNum) {
    case 0: return('Janeiro');    case 1:  return('Fevereiro');  case 2:  return('Março');
    case 3: return('Abril');      case 4:  return('Maio');       case 5:  return('Junho');
    case 6: return('Julho');       case 7:  return('Agosto');  case 8:  return('Setembro');  
    case 9: return('Outubro');    case 10: return('Novembro');  case 11: return('Dezembro');
  }
}
function setSelected(argSelBoxRef, argValue) {
  for (var z=0; z<argSelBoxRef.options.length; z++) 
    argSelBoxRef.options[z].selected = (argSelBoxRef.options[z].value == argValue);
}

function showPrevYear() {
  var yearSel = document.getElementById('selYear');

  useMonth = document.getElementById('selMonth').value;
  useYear  = yearSel.value;
  useYear--;
  if (useYear < minYear) useYear = maxYear;
  setSelected(yearSel, useYear);
  writeDate(); 
}

function showNextYear() {
  var yearSel = document.getElementById('selYear');

  useMonth = document.getElementById('selMonth').value;
  useYear  = yearSel.value;
  useYear++;
  if (useYear > maxYear) useYear = minYear;
  setSelected(yearSel, useYear);
  writeDate(); 
}

function showPrevMonth() {
  var monthSel = document.getElementById('selMonth');

  useYear = document.getElementById('selYear').value;
  useMonth  = monthSel.value;
  useMonth--;
  if (useMonth < minMonth) {
    showPrevYear();
    useMonth = maxMonth;
  }
  setSelected(monthSel, useMonth);
  writeDate(); 
}

function showNextMonth() {
  var monthSel = document.getElementById('selMonth');

  useYear = document.getElementById('selYear').value;
  useMonth  = monthSel.value;
  useMonth++;
  if (useMonth > maxMonth) {
    showNextYear();
    useMonth = minMonth;
  }
  setSelected(monthSel, useMonth);
  writeDate(); 
}

function showToday() {
  var monthSel = document.getElementById('selMonth');
  var yearSel = document.getElementById('selYear');
  useMonth = today.getMonth();
  useYear  = today.getFullYear();
  setSelected(monthSel, useMonth);
  setSelected(yearSel, useYear);
  writeDate(); 
}

function writeDate()
{
  var tdextra='';
  var stylecls='';
  var oneDay = 86400000; // horario normal

  var countDate = new Date( useYear, useMonth, 1);
  countDate = new Date( countDate.valueOf() - ( countDate.getDay() * oneDay) ); 

  hT = '';
  hT+= '<table border=0>';
  for (var r=0; r<7; r++) {
    hT += '<tr>';
    for (var c=0; c<7; c++) {
      if (r==0) {
	   tdextra = 'class="weekDays" align="center"';
       cell = getDayLabel(c); 
      }
      else {
        if (countDate.getMonth() == useMonth )
          stylecls = ( ((countDate.getDate()     == today.getDate()     ) && 
                        (countDate.getFullYear() == today.getFullYear() ) &&
                        (countDate.getMonth()    == today.getMonth()    ) )? 'rightday' : 'rightmonth' );
        else 
          stylecls = 'wrongmonth';
        cell = '&nbsp;' + countDate.getDate() + '&nbsp;';
        tdextra = 'class="' + stylecls + '" onclick="sendData(\'' + formatDate(countDate) + '\');"  align=right';
      }
            
      hT += '<td ' + tdextra + '>' + cell + '</td>';     
      if (r!=0) countDate = new Date(countDate.valueOf() + oneDay );
	  
if (countDate.getMonth()==1){ // se estiver no mes de fevereiro
	if (countDate.toString().search("Feb 11") >= 0){ // se estiver no mes de fevereiro
		var oneDay = 90000000;  // horario de verao
	}else{
		var oneDay = 86400000; // horario normal
	}
}
	  
    }
    hT += '</tr>';
  }
  hT+= '</table>';
  document.getElementById('calendar').innerHTML = hT;
}

// ************************* Programmed by sOul- ************
// setDateToday to some element;
// Use: writeToday (formName,elementName);
//***********************************************************
function writeToday(formName, elementName, nextElement){
	var tmpObj = eval("document." +formName+ "." +elementName);
	if (tmpObj.value == "") {
		var today = new Date();
		var tmpDay =  String(today.getDate());
		var tmpMonth = String(today.getMonth()+ 1); 
		var tmpYear = String(today.getFullYear()); 
    	tmpDay  = ((tmpDay.length==1)? '0':'')  + String(tmpDay);
		tmpMonth = ((tmpMonth.length==1)? '0':'') +  String(tmpMonth);
		var tmpDate = tmpDay +"/"+ tmpMonth +"/"+ tmpYear;
		tmpObj.value = tmpDate;
	} else {
		return;
	}
}
//************************* Programmed by sOul- ************
// isNumber -> USE: 
// NewWindow (
// 	myPage (string url)
//  myName	(string titel)
//	Width	(integer breedte)
//	Height (integer hoogte)
//	Scroll (yes/no)
//	Resizable (yes/no)	 
//	);
//**********************************************************
function NewWindow(myPage, myName, Width, Height, Scroll, Resizable) {
	var winTop = ((screen.height - Height) / 2);
	var winLeft= ((screen.width - Width) / 2);
	winProps = 'top=' +winTop+ ',left=' +winLeft+ ',height=' +Height+ ',width=' +Width+ ',Scrollbars=' +Scroll+ ',Resizable=' +Resizable+ ';'
	Win = window.open(myPage, myName, winProps);
		
		if (parseInt(navigator.appVersion) >= 4) { 
			Win.window.focus(); //set focus to the window
		}
}

function CloseCalandar() {
	try {
		Win.close();
	} catch(e) {}
}
function ValidCharsDate(sText) {
  var ValidChars = "0123456789/";
  var Valid = true;
  var Char;
  var NewText = "";
  
  for (i = 0; i < sText.length && Valid == true; i++) {
    Char = sText.charAt(i);
    if (ValidChars.indexOf(Char) == -1) {
      //Valid = false;
    } else {
      NewText = NewText + Char;
    }
  }
  return NewText;
}

function ValidCharsAlpha(sText) {
  var ValidChars = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ- ";
  var Valid = true;
  var Char;
  var NewText = "";
  
  for (i = 0; i < sText.length && Valid == true; i++) {
    Char = sText.charAt(i);
    if (ValidChars.indexOf(Char) == -1) {
      //Valid = false;
    } else {
      NewText = NewText + Char;
    }
  }
  return NewText;
}

function ValidCharsEmail(sText) {
  var ValidChars = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890@._";
  var Valid = true;
  var Char;
  var NewText = "";
  
  for (i = 0; i < sText.length && Valid == true; i++) {
    Char = sText.charAt(i);
    if (ValidChars.indexOf(Char) == -1) {
      //Valid = false;
    } else {
      NewText = NewText + Char;
    }
  }
  return NewText;
}

function ValidCharsAddress(sText) {
  var ValidChars = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890-.,# ";
  var Valid = true;
  var Char;
  var NewText = "";
  
  for (i = 0; i < sText.length && Valid == true; i++) {
    Char = sText.charAt(i);
    if (ValidChars.indexOf(Char) == -1) {
      //Valid = false;
    } else {
      NewText = NewText + Char;
    }
  }
  return NewText;
}

function ValidCharsAlphaNumeric(sText) {
  var ValidChars = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890 ";
  var Valid = true;
  var Char;
  var NewText = "";
  
  for (i = 0; i < sText.length && Valid == true; i++) {
    Char = sText.charAt(i);
    if (ValidChars.indexOf(Char) == -1) {
      //Valid = false;
    } else {
      NewText = NewText + Char;
    }
  }
  return NewText;
}

function ValidCharsNumber(sText) {
  var ValidChars = "0123456789";
  var Valid = true;
  var Char;
  var NewText = "";
  
  for (i = 0; i < sText.length && Valid == true; i++) {
    Char = sText.charAt(i);
    if (ValidChars.indexOf(Char) == -1) {
      //Valid = false;
    } else {
      NewText = NewText + Char;
    }
  }
  return NewText;
}

function ValidCharsPhone(sText) {
  var ValidChars = "0123456789()Ll/TtOo ";
  var Valid = true;
  var Char;
  var NewText = "";
  
  for (i = 0; i < sText.length && Valid == true; i++) {
    Char = sText.charAt(i);
    if (ValidChars.indexOf(Char) == -1) {
      //Valid = false;
    } else {
      NewText = NewText + Char;
    }
  }
  return NewText;
}

function checkValues() {
  if (document.getElementById('disposition').value=='') {
    alert('Please select a disposition.');
    return false;
  }
  if (document.getElementById('disposition').value=='Verified') {
    if (document.getElementById('clfirstname').value=='') {
      alert('Required field missing.');
      document.getElementById('clfirstname').focus();
      return false;
    } else if (document.getElementById('cllastname').value=='') {
      alert('Required field missing.');
      document.getElementById('cllastname').focus();
      return false;
    } else if (document.getElementById('tin').value=='') {
      alert('Required field missing.');
      document.getElementById('tin').focus();
      return false;
    } else if (document.getElementById('tinstatus').innerHTML!='') {
      alert('TIN is a unique ID and cannot have duplicates.');
      document.getElementById('tin').focus();
      return false;
    } else if(
        document.getElementById('chinabank').checked==false && 
        document.getElementById('eastwestbank').checked==false &&
        document.getElementById('metrobank').checked==false &&
        document.getElementById('rcbc').checked==false &&
        document.getElementById('maybank').checked==false
      ) {
      alert('Select a card to apply.');
      document.getElementById('cardchoices').focus();
      return false;
    }
  }
}

function checkPasswords() {
  if (document.getElementById('oldpass').value=='') {
    alert('Missing required field.');
    document.getElementById('oldpass').focus();
    return false;
  } else if (document.getElementById('newpass').value=='') {
    alert('Missing required field.');
    document.getElementById('newpass').focus();
    return false;
  } else if (document.getElementById('newpassrepeat').value=='') {
    alert('Missing required field.');
    document.getElementById('newpassrepeat').focus();
    return false;
  } else if (document.getElementById('newpass').value!=document.getElementById('newpassrepeat').value) {
    alert('New passwords do not match.');
    document.getElementById('newpass').focus();
    return false;
  } else if (document.getElementById('newpassrepeat').value.length<8) {
    alert('Password should be at least 8 characters.');
    document.getElementById('newpass').focus();
    return false;
  }
}

function checkSearch() {
  if (document.getElementById('searchname').value=='') {
    document.getElementById('status').value='Missing required field.';
    document.getElementById('searchname').focus();
    return false;
  } else if (document.getElementById('searchname').value.length<5) {
    document.getElementById('status').value='Search item must contain at least 5 characters.';
    document.getElementById('searchname').focus();
    return false;
  } else {
    document.getElementById('status').value='';
  }
}

function checkSearchTL() {
  if ((document.getElementById('searchname').value=='') && (document.getElementById('searchtin').value=='') && (document.getElementById('searchemail').value=='')){
    document.getElementById('status').value='Please specify a search value.';
    return false;
  } else if ((document.getElementById('searchname').value.length<5) && (document.getElementById('searchtin').value.length<9) && (document.getElementById('searchemail').value.length<6)) {
    document.getElementById('status').value='Minimum characters for search field is not met.';
    return false;
  } else {
    document.getElementById('status').value='';
  }
}

function checkReferal() {
  if (document.getElementById('referalname').value=='') {
    document.getElementById('status').value='Missing required field.';
    document.getElementById('referalname').focus();
    return false;
  } else if (document.getElementById('referalcontact').value.length<7) {
    document.getElementById('status').value='Contact number must contain at least 7 digits.';
    document.getElementById('referalcontact').focus();
    return false;
  } else {
    document.getElementById('status').value='';
  }
}

function searchMobile() {
  if ((document.getElementById("mobilephone").value.length==10) && (document.getElementById("mobilephone").value.substring(0,1)=='9')) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        document.getElementById("cpstatus").innerHTML = xhttp.responseText;
      }
    };
    mobile = document.getElementById("mobilephone").value.substring(0,10);
    leadid = document.getElementById("leadid").value;
    url = "scripts/agent/checkmobile.php?mobile=" + mobile + "&id=" + leadid;
    xhttp.open("POST", url, true);
    xhttp.send();
  }
}

function searchTin() {
  if ((document.getElementById("tin").value.length==9)) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        document.getElementById("tinstatus").innerHTML = xhttp.responseText;
      }
    };
    tin = document.getElementById("tin").value.substring(0,10);
    leadid = document.getElementById("leadid").value;
    url = "scripts/agent/checktin.php?tin=" + tin + "&id=" + leadid;
    xhttp.open("POST", url, true);
    xhttp.send();
  }
}

function getMobileMsg() {
  if(xmlhttp.readyState==4) {
    document.getElementById('cpstatus').innerHTML=xmlhttp.responseText;
  }
}

function Dial() {
  var contact = document.getElementById("selectednum").value;
  var leadid = document.getElementById("leadid").value;
  var exten = document.getElementById("exten").value;
  var host = document.getElementById("host").value;
  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=getMsg('callstatus');
  url = "scripts/agent/dialout.php?ext=" + exten + "&num=" + contact + "&hostadd=" + host + "&appid=" + leadid;
  xmlhttp.open("POST",url,true);
  xmlhttp.send(null);
}

function getMsg(controlname) {
  if(xmlhttp.readyState==4) {
    document.getElementById(controlname).innerHTML=xmlhttp.responseText;
  }
}

function showcallhistory(leadid,cname) {
  //alert('history'+ leadid);
  window.open ("scripts/agent/callhistory.php?leadid=" + leadid + "&cname=" + cname, "callhistory","location=1,status=1,scrollbars=0,resizable=0,width=800,height=600");
}

function showreferals(leadid,cname,userid) {
  //alert('referals'+ leadid);
  window.open ("scripts/agent/referal.php?leadid=" + leadid + "&cname=" + cname  + "&userid=" + userid, "referals","location=1,status=1,scrollbars=0,resizable=0,width=800,height=600");
}

function checkDate(that,truedate,currdate) {

	tmpdate = truedate;
	var tmp,i,vardate;
	y = tmpdate.search('/'); 
	tmp = true;
	vardate = '';
	
	//alert(y);
	if (y == 1 || y == 2) {
		varmm = tmpdate.substring(0,y);
		//alert(varmm);
		//mm = checkmonth (varmm);
		if (isNaN(varmm)) tmp = false;
		else {
			
			if (varmm>0 && varmm<=12) {
				//alert (varmm+' - ok');
				if (varmm < 10 && y == 1) vardate = '0'+varmm+'/';
				else vardate = varmm+'/'; 
				//alert (vardate);
				tmpdate = tmpdate.substring(y+1,tmpdate.length);
				y = tmpdate.search('/');
				varyy = tmpdate.substring(y+1,tmpdate.length);
				//alert (varyy);
				
				if (isNaN(varyy)) tmp = false;
				else {
					if (varyy.length == 2 && varyy>=0 && varyy<=99)
						varyy = '20'+varyy;
					else  {
						if (varyy.length == 4 && varyy>=1900 && varyy<=9999) {
							varyy = varyy;
						}
						else tmp=false;
					}	
					if (tmp) {
						var monarr = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
						// check for leap year
						if (((parseInt(varyy) % 4 == 0) && (parseInt(varyy) % 100 != 0)) || (parseInt(varyy) % 400 == 0)) monarr[1] = "29";
						vardd = tmpdate.substring(0,y);
						if (isNaN(vardd)) tmp = false;
						else {
							if (vardd <= monarr[varmm-1] && vardd>0) {
								//varyy = varyy.substring(2,varyy.length);
								vardate = vardate + vardd + '/' + varyy;
							}
							else tmp = false;
						}
					}
				}
				
			}	
			
			else { 
				tmp = false;
				//alert (varmm+' - not ok');
			}
		
		}
	}
	
	else {
		tmp = false;
	}
	
	if (tmp==false) {
		//alert('Please enter a valid date. \nFormat is MM/DD/YYYY.');
		that.value = "";
	}
	else
		that.value = vardate;
	
}

//format 
function checkSpecialCharacter(that){
    if(/^[a-zA-Z0-9 ]*$/.test(that.value) == false) {
        alert('No special characters allowed for this field.');
        that.value="";
        return false;
    }
    return true;
}

function isAlphaNumericOnly(e){
  var key;
  document.all ? key=e.keycode : key=e.which;
  return((key>47 && key<58)||(key>64 && key<91)||(key>96 && key<123)|| key==32 || key==8 || key==9);
}

function inputLimiter(e) {
    var AllowableCharacters = '';
    AllowableCharacters='1234567890 ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    var k = document.all?parseInt(e.keyCode): parseInt(e.which);
    if (k!=13 && k!=8 && k!=0){
        if ((e.ctrlKey==false) && (e.altKey==false)) {
        return (AllowableCharacters.indexOf(String.fromCharCode(k))!=-1);
        } else {
        return true;
        }
    } else {
        return true;
    }
}

function isAlphaNumeric(e){ // Alphanumeric only 58,45,44,39,46,64,40,41,35,38
    var key;
    document.all ? key=e.keycode : key=e.which;
    return((key>47 && key<58)||(key>64 && key<91)||(key>96 && key<123)||key==0 || key==8 || key==20 || key==32
            || (key>=44 && key<=46) || (key>=38 && key<=41) || key==64 || key==58 || key==35 || key==38 || key==59 || key==47); //this row is for special chars
 }

//format inputted amount to currency
function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num))
    num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num*100+0.50000000001);
    cents = num%100;
    num = Math.floor(num/100).toString();
    if(cents<10)
    cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
    num = num.substring(0,num.length-(4*i+3))+','+
    num.substring(num.length-(4*i+3));
    return (((sign)?'':'-') + num + '.' + cents);
}

//check if inputted amount is positive
function isAmountPositive(amount){
    amount = amount.toString().replace(/\$|\,/g,'');//.replace(',','');
    if (parseFloat(amount) <= 0 && isFinite(amount)) { 
        //alert('Please enter positive value');
        return false;
    } else return true;
}

//Keypress, accept only numbers
function isNumberKey(evt){
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

 return true;
}

//Remove comma from amount input
function stripComma(tmp) {
	var tmp1,i;
	tmp1='';
	for(i=0; i<=tmp.length; i++) {
		if (tmp.charAt(i)!=',') {
			tmp1=tmp1+tmp.charAt(i);
		}
	}	
	return tmp1;
}
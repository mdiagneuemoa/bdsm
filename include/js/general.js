/*********************************************************************************

 ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/

//Utility Functions

var gValidationCall='';

if (document.all)

	var browser_ie=true

	else if (document.layers)

		var browser_nn4=true

		else if (document.layers || (!document.all && document.getElementById))

			var browser_nn6=true

			var gBrowserAgent = navigator.userAgent.toLowerCase();

function set_returnName(user_id, user_name, fldname) {

	fieldName = window.opener.document.getElementById(fldname).value= user_name;


}

function hideSelect()
{
	var oselect_array = document.getElementsByTagName('SELECT');
	for(var i=0;i<oselect_array.length;i++)
	{
		oselect_array[i].style.display = 'none';
	}
}

function showSelect()
{
	var oselect_array = document.getElementsByTagName('SELECT');
	for(var i=0;i<oselect_array.length;i++)
	{
		oselect_array[i].style.display = 'block';
	}
}
function getObj(n,d) {

	var p,i,x; 

	if(!d)

		d=document;


	if(n != undefined)
	{
		if((p=n.indexOf("?"))>0&&parent.frames.length) {

			d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);

		}
	}



	if(!(x=d[n])&&d.all)

		x=d.all[n];

	if(typeof x == 'string'){
		x=null;
	}

	for(i=0;!x&&i<d.forms.length;i++)

		x=d.forms[i][n];



	for(i=0;!x&&d.layers&&i<d.layers.length;i++)

		x=getObj(n,d.layers[i].document);



	if(!x && d.getElementById)

		x=d.getElementById(n);



	return x;

}



function getOpenerObj(n) {

	return getObj(n,opener.document)

}


function findPosX(obj) {

	var curleft = 0;

	if (document.getElementById || document.all) {

		while (obj.offsetParent) {

			curleft += obj.offsetLeft

			obj = obj.offsetParent;

		}

	} else if (document.layers) {

		curleft += obj.x;

	}



	return curleft;

}



function findPosY(obj) {

	var curtop = 0;



	if (document.getElementById || document.all) {

		while (obj.offsetParent) {

			curtop += obj.offsetTop

			obj = obj.offsetParent;

		}

	} else if (document.layers) {

		curtop += obj.y;

	}



	return curtop;

}



function clearTextSelection() {

	if (browser_ie) document.selection.empty();

	else if (browser_nn4 || browser_nn6) window.getSelection().removeAllRanges();

}

//Setting cookies
function set_cookie ( name, value, exp_y, exp_m, exp_d, path, domain, secure )
{
	var cookie_string = name + "=" + escape ( value );

	if (exp_y) //delete_cookie(name)
	{
		var expires = new Date ( exp_y, exp_m, exp_d );
		cookie_string += "; expires=" + expires.toGMTString();
	}

	if (path) cookie_string += "; path=" + escape ( path );
	if (domain) cookie_string += "; domain=" + escape ( domain );
	if (secure) cookie_string += "; secure";

	document.cookie = cookie_string;
}

//Retrieving cookies
function get_cookie(cookie_name)
{
	var results = document.cookie.match(cookie_name + '=(.*?)(;|$)');
	if (results) return (unescape(results[1]));
	else return null;
}

//Delete cookies 
function delete_cookie( cookie_name )
{
	var cookie_date = new Date ( );  // current date & time
	cookie_date.setTime ( cookie_date.getTime() - 1 );
	document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
}
//End of Utility Functions



function emptyCheck(fldName,fldLabel, fldType) {
	var currObj = getObj(fldName);

	if (fldType=="text") {
		if (currObj.value.replace(/^\s+/g, '').replace(/\s+$/g, '').length==0) {
			alert(fldLabel+" "+alert_arr.CANNOT_BE_EMPTY)
			currObj.focus()
			return false
		}
		else{
			return true
		}
	} else if((fldType == "textarea")  
			&& (typeof(FCKeditorAPI)!=='undefined' && FCKeditorAPI.GetInstance(fldName) !== 'undefined')) { 
		var textObj = FCKeditorAPI.GetInstance(fldName); 
		var textValue = textObj.EditorDocument.body.innerHTML; 
		if (trim(textValue) == '' || trim(textValue) == '<br>') { 
			alert(fldLabel+alert_arr.CANNOT_BE_NONE); 
			return false; 
		} else{ 
			return true; 
		} 
	} 
	// hodar crm pour tester les fichiers joints
	else if(fldType == "file")  
	{
		if (currObj.form[currObj.name + '_hidden'].value=='')
			validateFilename(currObj);
		else	
		{	
			//currObj.value=currObj.form[currObj.name + '_hidden'].value;
			return true;
		}	
	}
	else{
		if (trim(currObj.value) == '') {
			alert(fldLabel+" "+alert_arr.CANNOT_BE_NONE)
			return false
		} else 
			return true
	}
}



function patternValidate(fldName,fldLabel,type) {
	var currObj=getObj(fldName)
	
	if (fldName.toUpperCase() == "DATELIVRAISON") 
	{
		type = "Date";
	}
	if (type.toUpperCase()=="YAHOO") //Email ID validation
	{
		//yahoo Id validation
		var re=new RegExp(/^[a-z0-9]([a-z0-9_\-\.]*)@([y][a][h][o][o])(\.[a-z]{2,3}(\.[a-z]{2}){0,2})$/)
	}
	if (type.toUpperCase()=="EMAIL") //Email ID validation
	{
		/*changes made to fix -- ticket#3278 & ticket#3461
		  var re=new RegExp(/^.+@.+\..+$/)*/
		//Changes made to fix tickets #4633, #5111  to accomodate all possible email formats
		var re=new RegExp(/^[a-zA-Z0-9]+([\_\-\.]*[a-zA-Z0-9]+[\_\-]?)*@[a-zA-Z0-9]+([\_\-]?[a-zA-Z0-9]+)*\.+([\-\_]?[a-zA-Z0-9])+(\.?[a-zA-Z0-9]+)*$/)
	}

	if (type.toUpperCase()=="DATE") {//DATE validation 
		//YMD
		//var reg1 = /^\d{2}(\-|\/|\.)\d{1,2}\1\d{1,2}$/ //2 digit year
		//var re = /^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/ //4 digit year

		//MYD
		//var reg1 = /^\d{1,2}(\-|\/|\.)\d{2}\1\d{1,2}$/ 
		//var reg2 = /^\d{1,2}(\-|\/|\.)\d{4}\1\d{1,2}$/ 

		//DMY
		//var reg1 = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{2}$/ 
		//var reg2 = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/

		switch (userDateFormat) {
		case "yyyy-mm-dd" : 
			var re = /^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/
			break;
		case "mm-dd-yyyy" : 
		case "dd-mm-yyyy" : 
			var re = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/								
		}
	}

	if (type.toUpperCase()=="TIME") {//TIME validation
		var re = /^\d{1,2}\:\d{1,2}$/
	}
	//Asha: Remove spaces on either side of a Email id before validating
	if (type.toUpperCase()=="EMAIL" || type.toUpperCase() == "DATE") currObj.value = trim(currObj.value);	
	/*if (!re.test(currObj.value)) {
		alert(alert_arr.ENTER_VALID + fldLabel  + " ("+type+")");
		currObj.focus()
		return false
	}*/
	else return true
}

function TelFaxValidate(fldName,fldLabel) {

	var expregTel = new RegExp(/^\(?(00|00 |\+|\+ )?([0-9]{2} [0-9]{1}\)? |[0-9]{3}\)? |[0-9]{3}\)?)[0-9]{7,9}/);
	var currObj=getObj(fldName)

	if (!expregTel.test(currObj.value)) {
		alert(alert_arr.ENTER_VALID +" "+fldLabel);
		currObj.focus()
		return false
	}
	else return true
}


function splitDateVal(dateval) {
	var datesep;
	var dateelements = new Array(3);

	if (dateval.indexOf("-")>=0) datesep="-"
		else if (dateval.indexOf(".")>=0) datesep="."
			else if (dateval.indexOf("/")>=0) datesep="/"

				switch (userDateFormat) {
				case "yyyy-mm-dd" : 
					dateelements[0]=dateval.substr(dateval.lastIndexOf(datesep)+1,dateval.length) //dd
					dateelements[1]=dateval.substring(dateval.indexOf(datesep)+1,dateval.lastIndexOf(datesep)) //mm
					dateelements[2]=dateval.substring(0,dateval.indexOf(datesep)) //yyyyy
					break;
				case "mm-dd-yyyy" : 
					dateelements[0]=dateval.substring(dateval.indexOf(datesep)+1,dateval.lastIndexOf(datesep))
					dateelements[1]=dateval.substring(0,dateval.indexOf(datesep))
					dateelements[2]=dateval.substr(dateval.lastIndexOf(datesep)+1,dateval.length)
					break;
				case "dd-mm-yyyy" : 
					dateelements[0]=dateval.substring(0,dateval.indexOf(datesep))
					dateelements[1]=dateval.substring(dateval.indexOf(datesep)+1,dateval.lastIndexOf(datesep))
					dateelements[2]=dateval.substr(dateval.lastIndexOf(datesep)+1,dateval.length)
				}

	return dateelements;
}

function compareDates(date1,fldLabel1,date2,fldLabel2,type) {
	var ret=true
	switch (type) {
	case 'L'	:	if (date1>=date2) {//DATE1 VALUE LESS THAN DATE2
		alert(fldLabel1+ alert_arr.SHOULDBE_LESS +fldLabel2)
		ret=false
	}
	break;
	case 'LE'	:	if (date1>date2) {//DATE1 VALUE LESS THAN OR EQUAL TO DATE2
		alert(fldLabel1+alert_arr.SHOULDBE_LESS_EQUAL+fldLabel2)
		ret=false
	}
	break;
	case 'E'	:	if (date1!=date2) {//DATE1 VALUE EQUAL TO DATE
		alert(fldLabel1+alert_arr.SHOULDBE_EQUAL+fldLabel2)
		ret=false
	}
	break;
	case 'G'	:	if (date1<=date2) {//DATE1 VALUE GREATER THAN DATE2
		alert(fldLabel1+alert_arr.SHOULDBE_GREATER+fldLabel2)
		ret=false
	}
	break;	
	case 'GE'	:	if (date1<date2) {//DATE1 VALUE GREATER THAN OR EQUAL TO DATE2
		alert(fldLabel1+" "+alert_arr.SHOULDBE_GREATER_EQUAL+" "+fldLabel2)
		ret=false
	}
	break;
	}

	if (ret==false) return false
	else return true
}

function dateTimeValidate(dateFldName,timeFldName,fldLabel,type) {
	if(patternValidate(dateFldName,fldLabel,"DATE")==false)
		return false;
	dateval=getObj(dateFldName).value.replace(/^\s+/g, '').replace(/\s+$/g, '') 

	var dateelements=splitDateVal(dateval)

	dd=dateelements[0]
	                mm=dateelements[1]
	                                yyyy=dateelements[2]

	                                                  if (dd<1 || dd>31 || mm<1 || mm>12 || yyyy<1 || yyyy<1000) {
	                                                	  alert(alert_arr.ENTER_VALID+fldLabel)
	                                                	  getObj(dateFldName).focus()
	                                                	  return false
	                                                  }

	if ((mm==2) && (dd>29)) {//checking of no. of days in february month
		alert(alert_arr.ENTER_VALID+fldLabel)
		getObj(dateFldName).focus()
		return false
	}

	if ((mm==2) && (dd>28) && ((yyyy%4)!=0)) {//leap year checking
		alert(alert_arr.ENTER_VALID+fldLabel)
		getObj(dateFldName).focus()
		return false
	}

	switch (parseInt(mm)) {
	case 2 : 
	case 4 : 
	case 6 : 
	case 9 : 
	case 11 :	if (dd>30) {
		alert(alert_arr.ENTER_VALID+fldLabel)
		getObj(dateFldName).focus()
		return false
	}	
	}

	if (patternValidate(timeFldName,fldLabel,"TIME")==false)
		return false

		var timeval=getObj(timeFldName).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
		var hourval=parseInt(timeval.substring(0,timeval.indexOf(":")))
		var minval=parseInt(timeval.substring(timeval.indexOf(":")+1,timeval.length))
		var currObj=getObj(timeFldName)

		if (hourval>23 || minval>59) {
			alert(alert_arr.ENTER_VALID+fldLabel)
			currObj.focus()
			return false
		}

	var currdate=new Date()
	var chkdate=new Date()

	chkdate.setYear(yyyy)
	chkdate.setMonth(mm-1)
	chkdate.setDate(dd)
	chkdate.setHours(hourval)
	chkdate.setMinutes(minval)

	if (type!="OTH") {
		if (!compareDates(chkdate,fldLabel,currdate,"current date & time",type)) {
			getObj(dateFldName).focus()
			return false
		} else return true;
	} else return true;
}

function dateTimeComparison(dateFldName1,timeFldName1,fldLabel1,dateFldName2,timeFldName2,fldLabel2,type) {
	var dateval1=getObj(dateFldName1).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	var dateval2=getObj(dateFldName2).value.replace(/^\s+/g, '').replace(/\s+$/g, '')

	var dateelements1=splitDateVal(dateval1)
	var dateelements2=splitDateVal(dateval2)

	dd1=dateelements1[0]
	                  mm1=dateelements1[1]
	                                    yyyy1=dateelements1[2]

	                                                        dd2=dateelements2[0]
	                                                                          mm2=dateelements2[1]
	                                                                                            yyyy2=dateelements2[2]

	                                                                                                                var timeval1=getObj(timeFldName1).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	                                                                                                                var timeval2=getObj(timeFldName2).value.replace(/^\s+/g, '').replace(/\s+$/g, '')

	                                                                                                                var hh1=timeval1.substring(0,timeval1.indexOf(":"))
	                                                                                                                var min1=timeval1.substring(timeval1.indexOf(":")+1,timeval1.length)

	                                                                                                                var hh2=timeval2.substring(0,timeval2.indexOf(":"))
	                                                                                                                var min2=timeval2.substring(timeval2.indexOf(":")+1,timeval2.length)

	                                                                                                                var date1=new Date()
	var date2=new Date()		

	date1.setYear(yyyy1)
	date1.setMonth(mm1-1)
	date1.setDate(dd1)
	date1.setHours(hh1)
	date1.setMinutes(min1)

	date2.setYear(yyyy2)
	date2.setMonth(mm2-1)
	date2.setDate(dd2)
	date2.setHours(hh2)
	date2.setMinutes(min2)

	if (type!="OTH") {
		if (!compareDates(date1,fldLabel1,date2,fldLabel2,type)) {
			getObj(dateFldName1).focus()
			return false
		} else return true;
	} else return true;
}

function dateValidate(fldName,fldLabel,type) {
	if(patternValidate(fldName,fldLabel,"DATE")==false)
		return false;
	dateval=getObj(fldName).value.replace(/^\s+/g, '').replace(/\s+$/g, '') 

	var dateelements=splitDateVal(dateval)

	dd=dateelements[0]
	                mm=dateelements[1]
	                                yyyy=dateelements[2]

	                                                  if (dd<1 || dd>31 || mm<1 || mm>12 || yyyy<1 || yyyy<1000) {
	                                                	  alert(alert_arr.ENTER_VALID+fldLabel)
	                                                	  getObj(fldName).focus()
	                                                	  return false
	                                                  }

	if ((mm==2) && (dd>29)) {//checking of no. of days in february month
		alert(alert_arr.ENTER_VALID+fldLabel)
		getObj(fldName).focus()
		return false
	}

	if ((mm==2) && (dd>28) && ((yyyy%4)!=0)) {//leap year checking
		alert(alert_arr.ENTER_VALID+fldLabel)
		getObj(fldName).focus()
		return false
	}

	switch (parseInt(mm)) {
	case 2 : 
	case 4 : 
	case 6 : 
	case 9 : 
	case 11 :	if (dd>30) {
		alert(alert_arr.ENTER_VALID+fldLabel)
		getObj(fldName).focus()
		return false
	}	
	}

	var currdate=new Date()
	var chkdate=new Date()

	chkdate.setYear(yyyy)
	chkdate.setMonth(mm-1)
	chkdate.setDate(dd)

	if (type!="OTH") {
		if (!compareDates(chkdate,fldLabel,currdate,"current date",type)) {
			getObj(fldName).focus()
			return false
		} else return true;
	} else return true;
}

function dateComparison(fldName1,fldLabel1,fldName2,fldLabel2,type) {
	var dateval1=getObj(fldName1).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	var dateval2=getObj(fldName2).value.replace(/^\s+/g, '').replace(/\s+$/g, '')

	var dateelements1=splitDateVal(dateval1)
	var dateelements2=splitDateVal(dateval2)

	dd1=dateelements1[0]
	                  mm1=dateelements1[1]
	                                    yyyy1=dateelements1[2]

	                                                        dd2=dateelements2[0]
	                                                                          mm2=dateelements2[1]
	                                                                                            yyyy2=dateelements2[2]

	                                                                                                                var date1=new Date()
	var date2=new Date()		

	date1.setYear(yyyy1)
	date1.setMonth(mm1-1)
	date1.setDate(dd1)		

	date2.setYear(yyyy2)
	date2.setMonth(mm2-1)
	date2.setDate(dd2)

	if (type!="OTH") {
		if (!compareDates(date1,fldLabel1,date2,fldLabel2,type)) {
			getObj(fldName1).focus()
			return false
		} else return true;
	} else return true
}

function timeValidate(fldName,fldLabel,type) {
	if (patternValidate(fldName,fldLabel,"TIME")==false)
		return false

		var timeval=getObj(fldName).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
		var hourval=parseInt(timeval.substring(0,timeval.indexOf(":")))
		var minval=parseInt(timeval.substring(timeval.indexOf(":")+1,timeval.length))
		var currObj=getObj(fldName)

		if (hourval>23 || minval>59) {
			alert(alert_arr.ENTER_VALID+fldLabel)
			currObj.focus()
			return false
		}

	var currtime=new Date()
	var chktime=new Date()

	chktime.setHours(hourval)
	chktime.setMinutes(minval)

	if (type!="OTH") {
		if (!compareDates(chktime,fldLabel1,currtime,"current time",type)) {
			getObj(fldName).focus()
			return false
		} else return true;
	} else return true
}

function timeComparison(fldName1,fldLabel1,fldName2,fldLabel2,type) {
	var timeval1=getObj(fldName1).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	var timeval2=getObj(fldName2).value.replace(/^\s+/g, '').replace(/\s+$/g, '')

	var hh1=timeval1.substring(0,timeval1.indexOf(":"))
	var min1=timeval1.substring(timeval1.indexOf(":")+1,timeval1.length)

	var hh2=timeval2.substring(0,timeval2.indexOf(":"))
	var min2=timeval2.substring(timeval2.indexOf(":")+1,timeval2.length)

	var time1=new Date()
	var time2=new Date()		

	//added to fix the ticket #5028
	if(fldName1 == "time_end" && (getObj("due_date") && getObj("date_start")))
	{
		var due_date=getObj("due_date").value.replace(/^\s+/g, '').replace(/\s+$/g, '')
		var start_date=getObj("date_start").value.replace(/^\s+/g, '').replace(/\s+$/g, '')
		dateval1 = splitDateVal(due_date);
		dateval2 = splitDateVal(start_date);

		dd1 = dateval1[0];
		mm1 = dateval1[1];
		yyyy1 = dateval1[2];

		dd2 = dateval2[0];
		mm2 = dateval2[1];
		yyyy2 = dateval2[2];

		time1.setYear(yyyy1)
		time1.setMonth(mm1-1)
		time1.setDate(dd1)

		time2.setYear(yyyy2)
		time2.setMonth(mm2-1)
		time2.setDate(dd2)

	}
	//end

	time1.setHours(hh1)
	time1.setMinutes(min1)

	time2.setHours(hh2)
	time2.setMinutes(min2)
	if (type!="OTH") {	
		if (!compareDates(time1,fldLabel1,time2,fldLabel2,type)) {
			getObj(fldName1).focus()
			return false
		} else return true;
	} else return true;
}

function numValidate(fldName,fldLabel,format,neg) {
	var val=getObj(fldName).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	if (format!="any") {
		if (isNaN(val)) {
			var invalid=true
		} else {
			var format=format.split(",")
			var splitval=val.split(".")
			if (neg==true) {
				if (splitval[0].indexOf("-")>=0) {
					if (splitval[0].length-1>format[0])
						invalid=true
				} else {
					if (splitval[0].length>format[0])
						invalid=true
				}
			} else {
				if (val<0)
					invalid=true
					else if (format[0]==2 && splitval[0]==100 && (!splitval[1] || splitval[1]==0))
						invalid=false
						else if (splitval[0].length>format[0])
							invalid=true
			}
			if (splitval[1])
				if (splitval[1].length>format[1])
					invalid=true
		}
		if (invalid==true) {
			alert(alert_arr.INVALID+fldLabel)
			getObj(fldName).focus()
			return false
		} else return true
	} else {
		// changes made -- to fix the ticket#3272
		var splitval=val.split(".")
		var arr_len = splitval.length;
		var len = 0;
		if(fldName == "probability" || fldName == "commissionrate")
		{
			if(arr_len > 1)
				len = splitval[1].length;
			if(isNaN(val))
			{
				alert(alert_arr.INVALID+fldLabel)
				getObj(fldName).focus()
				return false
			}
			else if(splitval[0] > 100 || len > 3 || (splitval[0] >= 100 && splitval[1] > 0))
			{
				alert( fldLabel + alert_arr.EXCEEDS_MAX);
				return false;
			}
		}
		else if(splitval[0]>18446744073709551615)
		{
			alert( fldLabel + alert_arr.EXCEEDS_MAX);
			return false;
		}


		if (neg==true)
			var re=/^(-|)(\d)*(\.)?\d+(\.\d\d*)*$/
					else
						var re=/^(\d)*(\.)?\d+(\.\d\d*)*$/
	}

	//for precision check. ie.number must contains only one "."	
	var dotcount=0;
	for (var i = 0; i < val.length; i++)
	{   
		if (val.charAt(i) == ".")
			dotcount++;
	}	

	if(dotcount>1)
	{
		alert(alert_arr.INVALID+fldLabel)
		getObj(fldName).focus()
		return false;
	}

	if (!re.test(val)) {
		alert(alert_arr.INVALID+fldLabel)
		getObj(fldName).focus()
		return false
	} else return true
}


function intValidate(fldName,fldLabel) {
	var val=getObj(fldName).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	if (isNaN(val) || (val.indexOf(".")!=-1 && fldName != 'potential_amount' && fldName != 'list_price')) 
	{
		alert(alert_arr.INVALID+fldLabel)
		getObj(fldName).focus()
		return false
	} 
	else if((fldName != 'employees' || fldName != 'noofemployees') && (val < -2147483648 || val > 2147483647))
	{
		alert(fldLabel +alert_arr.OUT_OF_RANGE);
		return false;
	}
	else if((fldName == 'employees' || fldName != 'noofemployees') && (val < 0 || val > 2147483647))
	{
		alert(fldLabel +alert_arr.OUT_OF_RANGE);
		return false;
	}
	else
	{
		return true
	}
}

function numConstComp(fldName,fldLabel,type,constval) {
	var val=parseFloat(getObj(fldName).value.replace(/^\s+/g, '').replace(/\s+$/g, ''))
	constval=parseFloat(constval)

	var ret=true
	switch (type) {
	case "L"  : if (val>=constval) {
		alert(fldLabel+alert_arr.SHOULDBE_LESS+constval)
		ret=false
	}
	break;
	case "LE" :	if (val>constval) {
		alert(fldLabel+alert_arr.SHOULDBE_LESS_EQUAL+constval)
		ret=false
	}
	break;
	case "E"  :	if (val!=constval) {
		alert(fldLabel+alert_arr.SHOULDBE_EQUAL+constval)
		ret=false
	}
	break;
	case "NE" : if (val==constval) {
		alert(fldLabel+alert_arr.SHOULDNOTBE_EQUAL+constval)
		ret=false
	}
	break;
	case "G"  :	if (val<=constval) {
		alert(fldLabel+alert_arr.SHOULDBE_GREATER+constval)
		ret=false
	}
	break;
	case "GE" : if (val<constval) {
		alert(fldLabel+alert_arr.SHOULDBE_GREATER_EQUAL+constval)
		ret=false
	}
	break;
	}

	if (ret==false) {
		getObj(fldName).focus()
		return false
	} else return true;
}

/* To get only filename from a given complete file path */
function getFileNameOnly(filename) {
	var onlyfilename = filename;
	// Normalize the path (to make sure we use the same path separator)
	var filename_normalized = filename.replace(/\\/g, '/');
	if(filename_normalized.lastIndexOf("/") != -1) {
		onlyfilename = filename_normalized.substring(filename_normalized.lastIndexOf("/") + 1);
	}
	return onlyfilename;
}

/* Function to validate the filename */
function validateFilename(form_ele) {

	// Modif hodar crm le nom du fichier ne doit pas être vide
	//if (form_ele.value == '') return true;
	//var value = getFileNameOnly(form_ele.value);
	
	var ul = document.getElementById('fileList');
		while (ul.hasChildNodes()) {
				ul.removeChild(ul.firstChild);
			}
			for (var i = 0; i < form_ele.files.length; i++) {
				var li = document.createElement("li");
				li.innerHTML = form_ele.files[i].name;
				ul.appendChild(li);
			}
			if(!ul.hasChildNodes()) {
				var li = document.createElement("li");
				li.innerHTML = 'No Files Selected';
				ul.appendChild(li);
			}
	
	if (form_ele.value == '') 
	{
		alert(alert_arr.LBL_FILENAME_EMPTY_ERR);
		form_ele.style.backgroundColor = err_bg_color;
		return false;
	}
	var value = getFileNameOnly(form_ele.value);

	// Color highlighting logic
	var err_bg_color = "#FFAA22";

	if (typeof(form_ele.bgcolor) == "undefined") {
		form_ele.bgcolor = form_ele.style.backgroundColor;
	}

	// Validation starts here
	var valid = true;

	/* Filename length is constrained to 255 at database level */
	if (value.length > 255) {
		alert(alert_arr.LBL_FILENAME_LENGTH_EXCEED_ERR);
		valid = false;
	}

	if (!valid) {
		form_ele.style.backgroundColor = err_bg_color;
		return false;
	}
	form_ele.style.backgroundColor = form_ele.bgcolor;
	form_ele.form[form_ele.name + '_hidden'].value = value;
	return true;
}

/*
function formIsValidable(){

	if(formValidate())
	{
		getObj('enable_recurring') 
	}
	return true;
}
 */
function formValidate(){
	return doformValidation('');
}

function massEditFormValidate(){
	return doformValidation('mass_edit');
}

function doformValidation(edit_type) {
	//Validation for Portal User

	/*if(gVTModule == 'Contacts' && gValidationCall != 'tabchange')
	{
		//if existing portal value = 0, portal checkbox = checked, ( email field is not available OR  email is empty ) then we should not allow -- OR --
		//if existing portal value = 1, portal checkbox = checked, ( email field is available     AND email is empty ) then we should not allow
		if(edit_type=='')
		{
			if((getObj('existing_portal').value == 0 && getObj('portal').checked && (getObj('email') == null || trim(getObj('email').value) == '')) ||
			    getObj('existing_portal').value == 1 && getObj('portal').checked && getObj('email') != null && trim(getObj('email').value) == '')
			{
				alert(alert_arr.PORTAL_PROVIDE_EMAILID);
				return false;
			}
		}
		else
		{
			if(getObj('portal').checked && getObj('portal_mass_edit_check').checked && (getObj('email') == null || trim(getObj('email').value) == '' || getObj('email_mass_edit_check').checked==false))
			{
				alert(alert_arr.PORTAL_PROVIDE_EMAILID);
				return false;
			}
			if((getObj('email') != null && trim(getObj('email').value) == '' && getObj('email_mass_edit_check').checked) && !(getObj('portal').checked==false && getObj('portal_mass_edit_check').checked))
			{
				alert(alert_arr.EMAIL_CHECK_MSG);
				return false;
			}
		}
	}*/
	
	
	if(gVTModule == 'SalesOrder') {
		if(edit_type == 'mass_edit') {
			if (getObj('enable_recurring_mass_edit_check') != null 
					&& getObj('enable_recurring_mass_edit_check').checked
					&& getObj('enable_recurring') != null) {
				if(getObj('enable_recurring').checked && (getObj('recurring_frequency') == null 
						|| trim(getObj('recurring_frequency').value) == '--None--' || getObj('recurring_frequency_mass_edit_check').checked==false)) {
					alert(alert_arr.RECURRING_FREQUENCY_NOT_PROVIDED);
					return false;
				}
				if(getObj('enable_recurring').checked == false && getObj('recurring_frequency_mass_edit_check').checked
						&& getObj('recurring_frequency') != null && trim(getObj('recurring_frequency').value) !=  '--None--') {
					alert(alert_arr.RECURRING_FREQNECY_NOT_ENABLED);
					return false;
				}	
			}
		} else if(getObj('enable_recurring') != null && getObj('enable_recurring').checked && 
				(getObj('recurring_frequency') == null || getObj('recurring_frequency').value == '--None--')) {
			alert(alert_arr.RECURRING_FREQUENCY_NOT_PROVIDED);
			return false;
		}
	}
	for (var i=0; i<fieldname.length; i++) {
		if(edit_type == 'mass_edit') {
			if(fieldname[i]!='salutationtype')	
				var obj = getObj(fieldname[i]+"_mass_edit_check");
			if(obj == null || obj.checked == false) continue;
		}
		if(getObj(fieldname[i]) != null)
		{
			var type=fielddatatype[i].split("~")
			if (type[1]=="M") {
				if (!emptyCheck(fieldname[i],fieldlabel[i],getObj(fieldname[i]).type))
					return false;
			}
			switch (type[0]) {
			case "O"  : break;
			case "V"  : if (getObj(fieldname[i]) != null && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
			{	 
				if (fieldname[i]=="phone" || fieldname[i]=="fax" || fieldname[i]=="mobile")
					if (!TelFaxValidate(fieldname[i],fieldlabel[i]))
						return false
			}	
			break;
			case "C"  : break;
			case "DT" :
				if (getObj(fieldname[i]) != null && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
				{	 
					if (type[1]=="M")
						if (!emptyCheck(fieldname[2],fieldlabel[i],getObj(type[2]).type))
							return false

							if(typeof(type[3])=="undefined") var currdatechk="OTH"
								else var currdatechk=type[3]

								                          if (!dateTimeValidate(fieldname[i],type[2],fieldlabel[i],currdatechk))
								                        	  return false
								                        	  if (type[4]) {
								                        		  if (!dateTimeComparison(fieldname[i],type[2],fieldlabel[i],type[5],type[6],type[4]))
								                        			  return false

								                        	  }
				}		
				break;
			case "D"  :
				if (getObj(fieldname[i]) != null && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
				{	
					if(typeof(type[2])=="undefined") var currdatechk="OTH"
						else var currdatechk=type[2]

						                          if (!dateValidate(fieldname[i],fieldlabel[i],currdatechk))
						                        	  return false
						                        	  if (type[3]) {
						                        		  if (!dateComparison(fieldname[i],fieldlabel[i],type[4],type[5],type[3]))
						                        			  return false
						                        	  }
				}	
				break;
			case "T"  :
				if (getObj(fieldname[i]) != null && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
				{	 
					if(typeof(type[2])=="undefined") var currtimechk="OTH"
						else var currtimechk=type[2]

						                          if (!timeValidate(fieldname[i],fieldlabel[i],currtimechk))
						                        	  return false
						                        	  if (type[3]) {
						                        		  if (!timeComparison(fieldname[i],fieldlabel[i],type[4],type[5],type[3]))
						                        			  return false
						                        	  }
				}
				break;
			case "I"  :
				if (getObj(fieldname[i]) != null && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
				{	
					if (getObj(fieldname[i]).value.length!=0)
					{
						if (!intValidate(fieldname[i],fieldlabel[i]))
							return false
							if (type[2]) {
								if (!numConstComp(fieldname[i],fieldlabel[i],type[2],type[3]))
									return false
							}
					}
				}
				break;
			case "N"  :
			case "NN" :
				if (getObj(fieldname[i]) != null && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
				{
					if (getObj(fieldname[i]).value.length!=0)
					{
						if (typeof(type[2])=="undefined") var numformat="any"
							else var numformat=type[2]
							                        if(type[0]=="NN")
							                        {
							                        	if (!numValidate(fieldname[i],fieldlabel[i],numformat,true))
							                        		return false
							                        }
							                        else if (!numValidate(fieldname[i],fieldlabel[i],numformat))
							                        	return false
							                        	if (type[3]) {
							                        		if (!numConstComp(fieldname[i],fieldlabel[i],type[3],type[4]))
							                        			return false
							                        	}
					}
				}
				break;
			case "E"  :
				if (getObj(fieldname[i]) != null && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
				{
					if (getObj(fieldname[i]).value.length!=0)
					{
						var etype = "EMAIL"
							if(fieldname[i] == "yahooid" || fieldname[i] == "yahoo_id")
							{
								etype = "YAHOO";
							}
						if (!patternValidate(fieldname[i],fieldlabel[i],etype))
							return false;
					}
				}
				break;
			}
			//start Birth day date validation
			if(fieldname[i] == "birthday" && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0 )
			{
				var now =new Date()
				var currtimechk="OTH"
					var datelabel = fieldlabel[i]
					                           var datefield = fieldname[i]
					                                                     var datevalue =getObj(datefield).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
					                                                     if (!dateValidate(fieldname[i],fieldlabel[i],currdatechk))
					                                                     {
					                                                    	 getObj(datefield).focus()
					                                                    	 return false
					                                                     }
					                                                     else
					                                                     {
					                                                    	 datearr=splitDateVal(datevalue);
					                                                    	 dd=datearr[0]
					                                                    	            mm=datearr[1]
					                                                    	                       yyyy=datearr[2]
					                                                    	                                    var datecheck = new Date()
					                                                    	 datecheck.setYear(yyyy)
					                                                    	 datecheck.setMonth(mm-1)
					                                                    	 datecheck.setDate(dd)
					                                                    	 if (!compareDates(datecheck,datelabel,now,"Current Date","L"))
					                                                    	 {
					                                                    		 getObj(datefield).focus()
					                                                    		 return false
					                                                    	 }
					                                                     }
			}
			//End Birth day	
		}

	}
	if(gVTModule == 'Contacts')
	{
		if(getObj('imagename'))
		{
			if(getObj('imagename').value != '')
			{
				var image_arr = new Array();
				image_arr = (getObj('imagename').value).split(".");
				var image_ext = image_arr[1].toLowerCase();
				if(image_ext ==  "jpeg" || image_ext ==  "png" || image_ext ==  "jpg" || image_ext ==  "pjpeg" || image_ext ==  "x-png" || image_ext ==  "gif")
				{
					return true;
				}
				else
				{
					alert(alert_arr.LBL_WRONG_IMAGE_TYPE);
					return false;
				}
			}
		}
	}

	if(gVTModule == 'Candidats')
	{
		if(getObj('dipmoyenne'))
		{
			if(parseFloat(getObj('dipmoyenne').value) < 14)
			{
				alert("Votre moyenne du dernier diplome doit \352tre sup\351rieure ou \351gale \340 14 pour pouvoir postuler!!!");
					return false;
			}
		}
	}
	
	if(gVTModule == 'Candidats')
	{
		if(getObj('etab1formduree'))
		{
			if(parseInt(getObj('etab1formduree').value) > 12)
			{
				alert("La dur\351e de la formation ne peut exc\351der 12 mois!!!");
					return false;
			}
		}
	}
	
	if(gVTModule == 'Candidats')
	{
		if(getObj('etab2formduree'))
		{
			if(getObj('etab2formduree').value !="" && parseInt(getObj('etab2formduree').value) > 12)
			{
				alert("La dur\351e de la formation ne peut exc\351der 12 mois!!!");
					return false;
			}
		}
	}
	
	
	
	//added to check Start Date & Time,if Activity Status is Planned.//start
	for (var j=0; j<fieldname.length; j++)
	{
		if(getObj(fieldname[j]) != null)
		{
			if(fieldname[j] == "date_start" || fieldname[j] == "task_date_start" )
			{
				var datelabel = fieldlabel[j]
				                           var datefield = fieldname[j]
				                                                     var startdatevalue = getObj(datefield).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
			}
			if(fieldname[j] == "time_start" || fieldname[j] == "task_time_start")
			{
				var timelabel = fieldlabel[j]
				                           var timefield = fieldname[j]
				                                                     var timeval=getObj(timefield).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
			}
			if(fieldname[j] == "eventstatus" || fieldname[j] == "taskstatus")
			{
				var statusvalue = getObj(fieldname[j]).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
				var statuslabel = fieldlabel[j++]
			}
		}
	}
	if(statusvalue == "Planned")
	{
		var dateelements=splitDateVal(startdatevalue)

		var hourval=parseInt(timeval.substring(0,timeval.indexOf(":")))
		var minval=parseInt(timeval.substring(timeval.indexOf(":")+1,timeval.length))


		dd=dateelements[0]
		                mm=dateelements[1]
		                                yyyy=dateelements[2]

		                                                  var chkdate=new Date()
		chkdate.setYear(yyyy)
		chkdate.setMonth(mm-1)
		chkdate.setDate(dd)
		chkdate.setMinutes(minval)
		chkdate.setHours(hourval)
		if(!comparestartdate(chkdate)) return false;
	}//end

	return true
}

function clearId(fldName) {

	var currObj=getObj(fldName)	

	currObj.value=""

}

function comparestartdate(chkdate)
{
	var datObj = [];
	var ajxdate = "test";
	var url = "module=Calendar&action=CalendarAjax&file=CalendarCommon&fieldval="+ajxdate
	var currdate = new Date();
	new Ajax.Request(
			'index.php',
			{
				queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody:url,
				onComplete: function(response)
				{
					datObj = eval(response.responseText);
					currdate.setFullYear(datObj[0].YEAR)
					currdate.setMonth(datObj[0].MONTH-1)
					currdate.setDate(datObj[0].DAY)
					currdate.setHours(datObj[0].HOUR)
					currdate.setMinutes(datObj[0].MINUTE)
				}
			}
	);
	return compareDates(chkdate,alert_arr.START_DATE_TIME,currdate,alert_arr.DATE_SHOULDNOT_PAST,"GE");
}

function showCalc(fldName) {
	var currObj=getObj(fldName)
	openPopUp("calcWin",currObj,"/crm/Calc.do?currFld="+fldName,"Calc",170,220,"menubar=no,toolbar=no,location=no,status=no,scrollbars=no,resizable=yes")
}

function showLookUp(fldName,fldId,fldLabel,searchmodule,hostName,serverPort,username) {
	var currObj=getObj(fldName)

	//var fldValue=currObj.value.replace(/^\s+/g, '').replace(/\s+$/g, '')

	//need to pass the name of the system in which the server is running so that even when the search is invoked from another system, the url will remain the same

	openPopUp("lookUpWin",currObj,"/crm/Search.do?searchmodule="+searchmodule+"&fldName="+fldName+"&fldId="+fldId+"&fldLabel="+fldLabel+"&fldValue=&user="+username,"LookUp",500,400,"menubar=no,toolbar=no,location=no,status=no,scrollbars=yes,resizable=yes")
}

function openPopUp(winInst,currObj,baseURL,winName,width,height,features) {
	var left=parseInt(findPosX(currObj))
	var top=parseInt(findPosY(currObj))

	if (window.navigator.appName!="Opera") top+=parseInt(currObj.offsetHeight)
	else top+=(parseInt(currObj.offsetHeight)*2)+10

	if (browser_ie)	{
		top+=window.screenTop-document.body.scrollTop
		left-=document.body.scrollLeft
		if (top+height+30>window.screen.height) 
			top=findPosY(currObj)+window.screenTop-height-30 //30 is a constant to avoid positioning issue
			if (left+width>window.screen.width) 
				left=findPosX(currObj)+window.screenLeft-width
	} else if (browser_nn4 || browser_nn6) {
		top+=(scrY-pgeY)
		left+=(scrX-pgeX)
		if (top+height+30>window.screen.height) 
			top=findPosY(currObj)+(scrY-pgeY)-height-30
			if (left+width>window.screen.width) 
				left=findPosX(currObj)+(scrX-pgeX)-width
	}

	features="width="+width+",height="+height+",top="+top+",left="+left+";"+features
	eval(winInst+'=window.open("'+baseURL+'","'+winName+'","'+features+'")')
}

var scrX=0,scrY=0,pgeX=0,pgeY=0;

if (browser_nn4 || browser_nn6) {
	document.addEventListener("click",popUpListener,true)
}

function popUpListener(ev) {
	if (browser_nn4 || browser_nn6) {
		scrX=ev.screenX
		scrY=ev.screenY
		pgeX=ev.pageX
		pgeY=ev.pageY
	}
}

function toggleSelect(state,relCheckName) {
	if (getObj(relCheckName)) {
		if (typeof(getObj(relCheckName).length)=="undefined") {
			getObj(relCheckName).checked=state
		} else {
			for (var i=0;i<getObj(relCheckName).length;i++)
				getObj(relCheckName)[i].checked=state
		}
	}
}

function toggleSelectAll(relCheckName,selectAllName) {
	if (typeof(getObj(relCheckName).length)=="undefined") {
		getObj(selectAllName).checked=getObj(relCheckName).checked
	} else {
		var atleastOneFalse=false;
		for (var i=0;i<getObj(relCheckName).length;i++) {
			if (getObj(relCheckName)[i].checked==false) {
				atleastOneFalse=true
				break;
			}
		}
		getObj(selectAllName).checked=!atleastOneFalse
	}
}
//added for show/hide 10July
function expandCont(bn)
{
	var leftTab = document.getElementById(bn);
	leftTab.style.display = (leftTab.style.display == "block")?"none":"block";
	img = document.getElementById("img_"+bn);
	img.src=(img.src.indexOf("images/toggle1.gif")!=-1)?"themes/images/toggle2.gif":"themes/images/toggle1.gif";
	set_cookie_gen(bn,leftTab.style.display)

}

function setExpandCollapse_gen()
{
	var x = leftpanelistarray.length;
	for (i = 0 ; i < x ; i++)
	{
		var listObj=getObj(leftpanelistarray[i])
		var tgImageObj=getObj("img_"+leftpanelistarray[i])
		var status = get_cookie_gen(leftpanelistarray[i])

		if (status == "block") {
			listObj.style.display="block";
			tgImageObj.src="themes/images/toggle2.gif";
		} else if(status == "none") {
			listObj.style.display="none";
			tgImageObj.src="themes/images/toggle1.gif";
		}
	}
}

function toggleDiv(id) {

	var listTableObj=getObj(id)

	if (listTableObj.style.display=="block") 
	{
		listTableObj.style.display="none"
	}else{
		listTableObj.style.display="block"
	}
	//set_cookie(id,listTableObj.style.display)
}

//Setting cookies
function set_cookie_gen ( name, value, exp_y, exp_m, exp_d, path, domain, secure )
{
	var cookie_string = name + "=" + escape ( value );

	if ( exp_y )
	{
		var expires = new Date ( exp_y, exp_m, exp_d );
		cookie_string += "; expires=" + expires.toGMTString();
	}

	if ( path )
		cookie_string += "; path=" + escape ( path );

	if ( domain )
		cookie_string += "; domain=" + escape ( domain );

	if ( secure )
		cookie_string += "; secure";

	document.cookie = cookie_string;
}

//Retrieving cookies
function get_cookie_gen ( cookie_name )
{
	var results = document.cookie.match ( cookie_name + '=(.*?)(;|$)' );

	if ( results )
		return ( unescape ( results[1] ) );
	else
		return null;
}

//Delete cookies 
function delete_cookie_gen ( cookie_name )
{
	var cookie_date = new Date ( );  // current date & time
	cookie_date.setTime ( cookie_date.getTime() - 1 );
	document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
}
//end added for show/hide 10July

/** This is Javascript Function which is used to toogle between
 * assigntype user and group/team select options while assigning owner to entity.
 */
function toggleAssignType(currType)
{
	if (currType=="U")
	{
		getObj("assign_user").style.display="block"
			getObj("assign_team").style.display="none"
	}
	else
	{
		getObj("assign_user").style.display="none"
			getObj("assign_team").style.display="block"
	}
}
//to display type of address for google map
function showLocateMapMenu()
{
	getObj("dropDownMenu").style.display="block"
		getObj("dropDownMenu").style.left=findPosX(getObj("locateMap"))
		getObj("dropDownMenu").style.top=findPosY(getObj("locateMap"))+getObj("locateMap").offsetHeight
}


function hideLocateMapMenu(ev)
{
	if (browser_ie)
		currElement=window.event.srcElement
		else if (browser_nn4 || browser_nn6)
			currElement=ev.target

			if (currElement.id!="locateMap")
				if (getObj("dropDownMenu").style.display=="block")
					getObj("dropDownMenu").style.display="none"
}
/*
 * javascript function to display the div tag
 * @param divId :: div tag ID
 */
function show(divId)
{
	if(getObj(divId))
	{
		var id = document.getElementById(divId);

		id.style.display = 'inline';
	}
}

/*
 * javascript function to display the div tag
 * @param divId :: div tag ID
 */
function showBlock(divId)
{
	var id = document.getElementById(divId);
	id.style.display = 'block';
}


/*
 * javascript function to hide the div tag
 * @param divId :: div tag ID
 */
function hide(divId)
{

	var id = document.getElementById(divId);

	id.style.display = 'none';

}
function fnhide(divId)
{

	var id = document.getElementById(divId);

	id.style.display = 'none';
}

function fnLoadValues(obj1,obj2,SelTab,unSelTab,moduletype,module){


	var oform = document.forms['EditView'];
	oform.action.value='Save';	
	//global variable to check the validation calling function to avoid validating when tab change
	gValidationCall = 'tabchange'; 

	/*var tabName1 = document.getElementById(obj1);
	var tabName2 = document.getElementById(obj2);
	var tagName1 = document.getElementById(SelTab);
	var tagName2 = document.getElementById(unSelTab);
	if(tabName1.className == "dvtUnSelectedCell")
		tabName1.className = "dvtSelectedCell";
	if(tabName2.className == "dvtSelectedCell")
		tabName2.className = "dvtUnSelectedCell"; 

	tagName1.style.display='block';
	tagName2.style.display='none';*/
	gValidationCall = 'tabchange'; 

	// if((moduletype == 'inventory' && validateInventory(module)) ||(moduletype == 'normal') && formValidate())	
	// if(formValidate())
	// {	
	var tabName1 = document.getElementById(obj1);

	var tabName2 = document.getElementById(obj2);

	var tagName1 = document.getElementById(SelTab);

	var tagName2 = document.getElementById(unSelTab);

	if(tabName1.className == "dvtUnSelectedCell")

		tabName1.className = "dvtSelectedCell";

	if(tabName2.className == "dvtSelectedCell")

		tabName2.className = "dvtUnSelectedCell";   
	tagName1.style.display='block';

	tagName2.style.display='none';
	// }

	gValidationCall = ''; 	
}

function fnCopy(source,design){

	document.getElementById(source).value=document.getElementById(design).value;

	document.getElementById(source).disabled=true;

}

function fnClear(source){

	document.getElementById(source).value=" ";

	document.getElementById(source).disabled=false;

}

function fnCpy(){

	var tagName=document.getElementById("cpy");

	if(tagName.checked==true){   
		fnCopy("shipaddress","address");

		fnCopy("shippobox","pobox");

		fnCopy("shipcity","city");

		fnCopy("shipcode","code");

		fnCopy("shipstate","state");

		fnCopy("shipcountry","country");

	}

	else{

		fnClear("shipaddress");

		fnClear("shippobox");

		fnClear("shipcity");

		fnClear("shipcode");

		fnClear("shipstate");

		fnClear("shipcountry");

	}

}
function fnDown(obj){
	var tagName = document.getElementById(obj);
	var tabName = document.getElementById("one");
	if(tagName.style.display == 'none'){
		tagName.style.display = 'block';
		tabName.style.display = 'block';
	}
	else{
		tabName.style.display = 'none';
		tagName.style.display = 'none';
	}
}

/*
 * javascript function to add field rows
 * @param option_values :: List of Field names
 */
var count = 0;
var rowCnt = 1;
function fnAddSrch(option_values,criteria_values){

	var tableName = document.getElementById('adSrc');

	var prev = tableName.rows.length;

	var count = prev;

	var row = tableName.insertRow(prev);

	if(count%2)

		row.className = "dvtCellLabel";

	else

		row.className = "dvtCellInfo";

	var colone = row.insertCell(0);

	var coltwo = row.insertCell(1);

	var colthree = row.insertCell(2);

	colone.innerHTML="<select id='Fields"+count+"' name='Fields"+count+"' onchange=\"updatefOptions(this, 'Condition"+count+"')\" class='detailedViewTextBox'>"+option_values+"</select>";

	coltwo.innerHTML="<select id='Condition"+count+"' name='Condition"+count+"' class='detailedViewTextBox'>"+criteria_values+"</select> ";

	colthree.innerHTML="<input type='text' id='Srch_value"+count+"' name='Srch_value"+count+"' class='detailedViewTextBox'>";

}

function totalnoofrows()
{
	var tableName = document.getElementById('adSrc');
	document.basicSearch.search_cnt.value = tableName.rows.length;
}

/*
 * javascript function to delete field rows in advance search
 * @param void :: void
 */
function delRow()
{

	var tableName = document.getElementById('adSrc');

	var prev = tableName.rows.length;

	if(prev > 1)

		document.getElementById('adSrc').deleteRow(prev-1);

}

function fnVis(obj){

	var profTag = document.getElementById("prof");

	var moreTag = document.getElementById("more");

	var addrTag = document.getElementById("addr");


	if(obj == 'prof'){

		document.getElementById('mnuTab').style.display = 'block';

		document.getElementById('mnuTab1').style.display = 'none';

		document.getElementById('mnuTab2').style.display = 'none';

		profTag.className = 'dvtSelectedCell';

		moreTag.className = 'dvtUnSelectedCell';

		addrTag.className = 'dvtUnSelectedCell';

	}


	else if(obj == 'more'){

		document.getElementById('mnuTab1').style.display = 'block';

		document.getElementById('mnuTab').style.display = 'none';

		document.getElementById('mnuTab2').style.display = 'none';

		moreTag.className = 'dvtSelectedCell';

		profTag.className = 'dvtUnSelectedCell';

		addrTag.className = 'dvtUnSelectedCell';

	}


	else if(obj == 'addr'){

		document.getElementById('mnuTab2').style.display = 'block';

		document.getElementById('mnuTab').style.display = 'none';

		document.getElementById('mnuTab1').style.display = 'none';

		addrTag.className = 'dvtSelectedCell';

		profTag.className = 'dvtUnSelectedCell';

		moreTag.className = 'dvtUnSelectedCell';

	}

}

function fnvsh(obj,Lay){
	var tagName = document.getElementById(Lay);
	var leftSide = findPosX(obj);
	var topSide = findPosY(obj);
	tagName.style.left= leftSide + 175 + 'px';
	tagName.style.top= topSide + 'px';
	tagName.style.visibility = 'visible';
}

function fnvshobj(obj,Lay){
	var tagName = document.getElementById(Lay);
	var leftSide = findPosX(obj);
	var topSide = findPosY(obj);
	var maxW = tagName.style.width;
	var widthM = maxW.substring(0,maxW.length-2);
	if(Lay == 'editdiv') 
	{
		leftSide = leftSide - 225;
		topSide = topSide - 125;
	}else if(Lay == 'transferdiv')
	{
		leftSide = leftSide - 10;
		topSide = topSide;
	}
	var IE = document.all?true:false;
	if(IE)
	{
		if($("repposition1"))
		{
			if(topSide > 1200)
			{
				topSide = topSide-250;
			}
		}
	}

	var getVal = eval(leftSide) + eval(widthM);
	if(getVal  > document.body.clientWidth ){
		leftSide = eval(leftSide) - eval(widthM);
		tagName.style.left = leftSide + 34 + 'px';
	}
	else
		tagName.style.left= leftSide + 'px';
	tagName.style.top= topSide + 'px';
	tagName.style.display = 'block';
	tagName.style.visibility = "visible";
}

function posLay(obj,Lay){
	var tagName = document.getElementById(Lay);
	var leftSide = findPosX(obj);
	var topSide = findPosY(obj);
	var maxW = tagName.style.width;
	var widthM = maxW.substring(0,maxW.length-2);
	var getVal = eval(leftSide) + eval(widthM);
	if(getVal  > document.body.clientWidth ){
		leftSide = eval(leftSide) - eval(widthM);
		tagName.style.left = leftSide + 'px';
	}
	else
		tagName.style.left= leftSide + 'px';
	tagName.style.top= topSide + 'px';
}

function fninvsh(Lay){
	var tagName = document.getElementById(Lay);
	tagName.style.visibility = 'hidden';
	tagName.style.display = 'none';
}

function fnvshNrm(Lay){
	var tagName = document.getElementById(Lay);
	tagName.style.visibility = 'visible';
	tagName.style.display = 'block';
}

function cancelForm(frm)
{
	window.history.back();
}

function trim(str)
{
	var s = str.replace(/\s+$/,'');
	s = s.replace(/^\s+/,'');
	return s;
}

function clear_form(form)
{
	for (j = 0; j < form.elements.length; j++)
	{
		if (form.elements[j].type == 'text' || form.elements[j].type == 'select-one')
		{
			form.elements[j].value = '';
		}
	}
}

function ActivateCheckBox()
{
	var map = document.getElementById("saved_map_checkbox");
	var source = document.getElementById("saved_source");

	if(map.checked == true)
	{
		source.disabled = false;
	}
	else
	{
		source.disabled = true;
	}
}

//wipe for Convert Lead  

function fnSlide2(obj,inner)
{
	var buff = document.getElementById(obj).height;
	closeLimit = buff.substring(0,buff.length);
	menu_max = eval(closeLimit);
	var tagName = document.getElementById(inner);
	document.getElementById(obj).style.height=0 + "px"; menu_i=0;
	if (tagName.style.display == 'none')
		fnexpanLay2(obj,inner);
	else
		fncloseLay2(obj,inner);
}

function fnexpanLay2(obj,inner)
{
	// document.getElementById(obj).style.display = 'run-in';
	var setText = eval(closeLimit) - 1;
	if (menu_i<=eval(closeLimit))
	{
		if (menu_i>setText){document.getElementById(inner).style.display='block';}
		document.getElementById(obj).style.height=menu_i + "px";
		setTimeout(function() { fnexpanLay2(obj,inner); },5);
		menu_i=menu_i+5;
	}
}

function fncloseLay2(obj,inner)
{
	if (menu_max >= eval(openLimit))
	{
		if (menu_max<eval(closeLimit)){document.getElementById(inner).style.display='none';}
		document.getElementById(obj).style.height=menu_max +"px";
		setTimeout(function() { fncloseLay2(obj,inner); }, 5);
		menu_max = menu_max -5;
	}
}

function addOnloadEvent(fnc){
	if ( typeof window.addEventListener != "undefined" )
		window.addEventListener( "load", fnc, false );
	else if ( typeof window.attachEvent != "undefined" ) {
		window.attachEvent( "onload", fnc );
	}
	else {
		if ( window.onload != null ) {
			var oldOnload = window.onload;
			window.onload = function ( e ) {
				oldOnload( e );
				window[fnc]();
			};
		}
		else
			window.onload = fnc;
	}
}
function InternalMailer(record_id,field_id,field_name,par_module,type) {
	var url;
	switch(type) {
	case 'record_id':
		url = 'index.php?module=Emails&action=EmailsAjax&internal_mailer=true&type='+type+'&field_id='+field_id+'&rec_id='+record_id+'&fieldname='+field_name+'&file=EditView&par_module='+par_module;//query string field_id added for listview-compose email issue
		break;
	case 'email_addy':
		url = 'index.php?module=Emails&action=EmailsAjax&internal_mailer=true&type='+type+'&email_addy='+record_id+'&file=EditView';
		break;

	}

	var opts = "menubar=no,toolbar=no,location=no,status=no,resizable=yes,scrollbars=yes";
	openPopUp('xComposeEmail',this,url,'createemailWin',830,662,opts);
}

function fnHide_Event(obj){
	document.getElementById(obj).style.visibility = 'hidden';
}
function ReplyCompose(id,mode)
{
	url = 'index.php?module=Emails&action=EmailsAjax&file=EditView&record='+id+'&reply=true';

	openPopUp('xComposeEmail',this,url,'createemailWin',820,689,'menubar=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=yes');	
}
function OpenCompose(id,mode) 
{
	switch(mode)
	{		
	case 'edit':
		url = 'index.php?module=Emails&action=EmailsAjax&file=EditView&record='+id;
		break;
	case 'create':
		url = 'index.php?module=Emails&action=EmailsAjax&file=EditView';
		break;
	case 'forward':
		url = 'index.php?module=Emails&action=EmailsAjax&file=EditView&record='+id+'&forward=true';
		break;
	case 'Invoice':
		url = 'index.php?module=Emails&action=EmailsAjax&file=EditView&attachment='+mode+'.pdf';
		break;
	case 'PurchaseOrder':
		url = 'index.php?module=Emails&action=EmailsAjax&file=EditView&attachment='+mode+'.pdf';
		break;
	case 'SalesOrder':
		url = 'index.php?module=Emails&action=EmailsAjax&file=EditView&attachment='+mode+'.pdf';
		break;
	case 'Quote':
		url = 'index.php?module=Emails&action=EmailsAjax&file=EditView&attachment='+mode+'.pdf';
		break; 
	case 'Documents':
		url = 'index.php?module=Emails&action=EmailsAjax&file=EditView&attachment='+id+'';
		break;
	case 'print':
		url = 'index.php?module=Emails&action=EmailsAjax&file=PrintEmail&record='+id+'&print=true'; 	 			
	}
	openPopUp('xComposeEmail',this,url,'createemailWin',820,689,'menubar=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=yes');
}

//Function added for Mass select in Popup - Philip
function SelectAll(mod,parmod)
{
	if(document.selectall.selected_id != undefined)
	{
		x = document.selectall.selected_id.length;
		var y=0;
		if(parmod != 'Calendar')
		{
			var module = window.opener.document.getElementById('RLreturn_module').value
			var entity_id = window.opener.document.getElementById('RLparent_id').value
			var parenttab = window.opener.document.getElementById('parenttab').value
		}
		idstring = "";
		namestr = "";

		if ( x == undefined)
		{

			if (document.selectall.selected_id.checked)
			{
				idstring = document.selectall.selected_id.value;
				if(parmod == 'Calendar')
					namestr = document.getElementById('calendarCont'+idstring).innerHTML;
				y=1;
			}
			else
			{
				alert(alert_arr.SELECT);
				return false;
			}
		}
		else
		{
			y=0;
			for(i = 0; i < x ; i++)
			{
				if(document.selectall.selected_id[i].checked)
				{
					idstring = document.selectall.selected_id[i].value +";"+idstring;
					if(parmod == 'Calendar')
					{
						idval = document.selectall.selected_id[i].value;
						namestr = document.getElementById('calendarCont'+idval).innerHTML+"\n"+namestr;
					}
					y=y+1;
				}
			}
		}
		if (y != 0)
		{
			document.selectall.idlist.value=idstring;
		}
		else
		{
			alert(alert_arr.SELECT);
			return false;
		}
		if(confirm(alert_arr.ADD_CONFIRMATION+y+alert_arr.RECORDS))
		{
			if(parmod == 'Calendar')
			{
				//this blcok has been modified to provide delete option for contact in Calendar
				idval = window.opener.document.EditView.contactidlist.value;
				if(idval != '')
				{
					var avalIds = new Array();
					avalIds = idstring.split(';');

					var selectedIds = new Array();	
					selectedIds = idval.split(';');

					for(i=0; i < (avalIds.length-1); i++)
					{
						var rowFound=false;
						for(k=0; k < selectedIds.length; k++)
						{
							if (selectedIds[k]==avalIds[i])
							{
								rowFound=true;
								break;
							}

						}
						if(rowFound != true)
						{
							idval = idval+';'+avalIds[i];
							window.opener.document.EditView.contactidlist.value = idval;
							var str=document.getElementById('calendarCont'+avalIds[i]).innerHTML;
							window.opener.addOption(avalIds[i],str);
						}
					}
				}
				else
				{
					window.opener.document.EditView.contactidlist.value = idstring;
					var temp = new Array();
					temp = namestr.split('\n');

					var tempids = new Array();
					tempids = idstring.split(';');

					for(k=0; k < temp.length; k++)
					{
						window.opener.addOption(tempids[k],temp[k]);
					}
				}
				//end
			}
			else
			{
				opener.document.location.href="index.php?module="+module+"&parentid="+entity_id+"&action=updateRelations&destination_module="+mod+"&idlist="+idstring+"&parenttab="+parenttab;
			}
			self.close();
		}
		else
		{
			return false;
		}
	}
}
function ShowEmail(id)
{
	url = 'index.php?module=Emails&action=EmailsAjax&file=DetailView&record='+id;
	openPopUp('xComposeEmail',this,url,'createemailWin',820,695,'menubar=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=yes');
}

var bSaf = (navigator.userAgent.indexOf('Safari') != -1);
var bOpera = (navigator.userAgent.indexOf('Opera') != -1);
var bMoz = (navigator.appName == 'Netscape');
function execJS(node) {
	var st = node.getElementsByTagName('SCRIPT');
	var strExec;
	for(var i=0;i<st.length; i++) {
		if (bSaf) {
			strExec = st[i].innerHTML;
		}
		else if (bOpera) {
			strExec = st[i].text;
		}
		else if (bMoz) {
			strExec = st[i].textContent;
		}
		else {
			strExec = st[i].text;
		}
		try {
			eval(strExec);
		} catch(e) {
			alert(e);
		}
	}
}

//Function added for getting the Tab Selected Values (Standard/Advanced Filters) for Custom View - Ahmed
function fnLoadCvValues(obj1,obj2,SelTab,unSelTab){

	var tabName1 = document.getElementById(obj1);

	var tabName2 = document.getElementById(obj2);

	var tagName1 = document.getElementById(SelTab);

	var tagName2 = document.getElementById(unSelTab);

	if(tabName1.className == "dvtUnSelectedCell")

		tabName1.className = "dvtSelectedCell";

	if(tabName2.className == "dvtSelectedCell")

		tabName2.className = "dvtUnSelectedCell";   
	tagName1.style.display='block';

	tagName2.style.display='none';

}


//Drop Dwon Menu


function fnDropDown(obj,Lay){
	var tagName = document.getElementById(Lay);
	var leftSide = findPosX(obj);
	var topSide = findPosY(obj);
	var maxW = tagName.style.width;
	var widthM = maxW.substring(0,maxW.length-2);
	var getVal = eval(leftSide) + eval(widthM);
	if(getVal  > document.body.clientWidth ){
		leftSide = eval(leftSide) - eval(widthM);
		tagName.style.left = leftSide + 34 + 'px';
	}
	else
		tagName.style.left= leftSide + 'px';
	tagName.style.top= topSide + 28 +'px';
	tagName.style.display = 'block';
}

function fnShowDrop(obj){
	document.getElementById(obj).style.display = 'block';
}

function fnHideDrop(obj){
	document.getElementById(obj).style.display = 'none';
}

function getCalendarPopup(imageid,fieldid,dateformat)
{
	Calendar.setup ({
		inputField : fieldid, ifFormat : dateformat, showsTime : false, button : imageid, singleClick : true, step : 1
	});
}

//Added to check duplicate account creation

function AjaxDuplicateValidate(module,fieldname,oform)
{
	var fieldvalue = encodeURIComponent(getObj(fieldname).value);
	if(fieldvalue == '')
	{
		alert(alert_arr.ACCOUNTNAME_CANNOT_EMPTY);
		return false;	
	}
	var url = "module="+module+"&action="+module+"Ajax&file=Save&"+fieldname+"="+fieldvalue+"&dup_check=true";
	new Ajax.Request(
			'index.php',
			{queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody:url,
				onComplete: function(response) {
				var str = response.responseText
				if(str.indexOf('SUCCESS') > -1)
				{
					oform.submit();
				}else
				{
					alert(str);
				}
			}
			}
	);
}

/**to get SelectContacts Popup
check->to check select options enable or disable
 *type->to differentiate from task
 *frmName->form name*/

function selectContact(check,type,frmName)
{
	if($("single_accountid"))
	{
		var potential_id = '';
		if($("potential_id"))
			potential_id = frmName.potential_id.value;
		account_id = frmName.account_id.value;
		if(potential_id != '')
		{
			record_id = potential_id;
			module_string = "&parent_module=Potentials";
		}	
		else
		{
			record_id = account_id;
			module_string = "&parent_module=Accounts";
		}
		if(record_id != '')
			window.open("index.php?module=Contacts&action=Popup&html=Popup_picker&popuptype=specific&form=EditView"+module_string+"&relmod_id="+record_id,"test","width=640,height=602,resizable=0,scrollbars=0");
		else
			window.open("index.php?module=Contacts&action=Popup&html=Popup_picker&popuptype=specific&form=EditView","test","width=640,height=602,resizable=0,scrollbars=0");	
	}
	else if(($("parentid")) && type != 'task')
	{
		if(getObj("parent_type")){
			rel_parent_module = frmName.parent_type.value;
			record_id = frmName.parent_id.value;
			module = rel_parent_module.split("&");	
			if(record_id != '' && module[0] == "Leads")
			{
				alert(alert_arr.CANT_SELECT_CONTACTS);
			}
			else
			{
				if(check == 'true')
					search_string = "&return_module=Calendar&select=enable&popuptype=detailview&form_submit=false";
				else
					search_string="&popuptype=specific";
				if(record_id != '')
					window.open("index.php?module=Contacts&action=Popup&html=Popup_picker&form=EditView"+search_string+"&relmod_id="+record_id+"&parent_module="+module[0],"test","width=640,height=602,resizable=0,scrollbars=0");
				else
					window.open("index.php?module=Contacts&action=Popup&html=Popup_picker&form=EditView"+search_string,"test","width=640,height=602,resizable=0,scrollbars=0");

			}
		}else{
			window.open("index.php?module=Contacts&action=Popup&html=Popup_picker&return_module=Calendar&select=enable&popuptype=detailview&form=EditView&form_submit=false","test","width=640,height=602,resizable=0,scrollbars=0");
		}
	}
	else if(($("contact_name")) && type == 'task')
	{
		var formName = frmName.name;
		var task_recordid = '';
		if(formName == 'EditView')
		{
			if($("parent_type"))
			{
				task_parent_module = frmName.parent_type.value;
				task_recordid = frmName.parent_id.value;
				task_module = task_parent_module.split("&");
				popuptype="&popuptype=specific";
			}
		}
		else
		{
			if($("task_parent_type"))
			{
				task_parent_module = frmName.task_parent_type.value;
				task_recordid = frmName.task_parent_id.value;
				task_module = task_parent_module.split("&");
				popuptype="&popuptype=toDospecific";
			}
		}
		if(task_recordid != '' && task_module[0] == "Leads" )
		{
			alert(alert_arr.CANT_SELECT_CONTACTS);
		}
		else
		{
			if(task_recordid != '')
				window.open("index.php?module=Contacts&action=Popup&html=Popup_picker"+popuptype+"&form="+formName+"&task_relmod_id="+task_recordid+"&task_parent_module="+task_module[0],"test","width=640,height=602,resizable=0,scrollbars=0");
			else	
				window.open("index.php?module=Contacts&action=Popup&html=Popup_picker&popuptype=specific&form="+formName,"test","width=640,height=602,resizable=0,scrollbars=0");
		}

	}
	else
	{
		window.open("index.php?module=Contacts&action=Popup&html=Popup_picker&popuptype=specific&form=EditView","test","width=640,height=602,resizable=0,scrollbars=0");
	}
}
//to get Select Potential Popup
function selectPotential()
{
	var record_id='';
	if (document.EditView.account_id) // si id du compte n'hésiste pas
	{
		record_id= document.EditView.account_id.value;
	}	
	if(record_id != '')
		window.open("index.php?module=Potentials&action=Popup&html=Popup_picker&popuptype=specific_potential_account_address&form=EditView&relmod_id="+record_id+"&parent_module=Accounts","test","width=640,height=602,resizable=0,scrollbars=0");
	else
		window.open("index.php?module=Potentials&action=Popup&html=Popup_picker&popuptype=specific_potential_account_address&form=EditView","test","width=640,height=602,resizable=0,scrollbars=0");
}
//to select Quote Popup
function selectQuote()
{
	var record_id= document.EditView.account_id.value;
	if(record_id != '')
		window.open("index.php?module=Quotes&action=Popup&html=Popup_picker&popuptype=specific&form=EditView&relmod_id="+record_id+"&parent_module=Accounts","test","width=640,height=602,resizable=0,scrollbars=0");

	else
		window.open("index.php?module=Quotes&action=Popup&html=Popup_picker&popuptype=specific&form=EditView","test","width=640,height=602,resizable=0,scrollbars=0");
}
//to get select SalesOrder Popup
function selectSalesOrder()
{
	var record_id= document.EditView.account_id.value;
	if(record_id != '')
		window.open("index.php?module=SalesOrder&action=Popup&html=Popup_picker&popuptype=specific&form=EditView&relmod_id="+record_id+"&parent_module=Accounts","test","width=640,height=602,resizable=0,scrollbars=0");
	else
		window.open("index.php?module=SalesOrder&action=Popup&html=Popup_picker&popuptype=specific&form=EditView","test","width=640,height=602,resizable=0,scrollbars=0");
}

function checkEmailid(parent_module,emailid,yahooid)
{
	var check = true;
	if(emailid == '' && yahooid == '')
	{
		alert(alert_arr.LBL_THIS+parent_module+alert_arr.DOESNOT_HAVE_MAILIDS);
		check=false;
	}
	return check;
}

function calQCduedatetime()
{
	var datefmt = document.QcEditView.dateFormat.value;
	var type = document.QcEditView.activitytype.value;
	var dateval1=getObj('date_start').value.replace(/^\s+/g, '').replace(/\s+$/g, '');
	var dateelements1=splitDateVal(dateval1);
	dd1=parseInt(dateelements1[0],10);
	mm1=dateelements1[1];
	yyyy1=dateelements1[2];
	var date1=new Date();
	date1.setYear(yyyy1);
	date1.setMonth(mm1-1,dd1+1);
	var yy = date1.getFullYear();
	var mm = date1.getMonth() + 1;
	var dd = date1.getDate();
	var date = document.QcEditView.date_start.value;
	var starttime = document.QcEditView.time_start.value;
	if (!timeValidate('time_start',' Start Date & Time','OTH'))
		return false;
	var timearr = starttime.split(":");
	var hour = parseInt(timearr[0],10);
	var min = parseInt(timearr[1],10);
	dd = _2digit(dd);
	mm = _2digit(mm);
	var tempdate = yy+'-'+mm+'-'+dd;
	if(datefmt == '%d-%m-%Y')
		var tempdate = dd+'-'+mm+'-'+yy;
	else if(datefmt == '%m-%d-%Y')
		var tempdate = mm+'-'+dd+'-'+yy;
	if(type == 'Meeting')
	{
		hour = hour + 1;
		if(hour == 24)
		{
			hour = 0;
			date =  tempdate;
		}
		hour = _2digit(hour);
		min = _2digit(min);
		document.QcEditView.due_date.value = date;
		document.QcEditView.time_end.value = hour+':'+min;
	}
	if(type == 'Call')
	{
		if(min >= 55)
		{
			min = min%55;
			hour = hour + 1;
		}else min = min + 5;
		if(hour == 24)
		{
			hour = 0;
			date =  tempdate;
		}
		hour = _2digit(hour);
		min = _2digit(min);
		document.QcEditView.due_date.value = date;
		document.QcEditView.time_end.value = hour+':'+min;
	}

}

function _2digit( no ){
	if(no < 10) return "0" + no;
	else return "" + no;
}

function confirmdelete(url)
{
	if(confirm(alert_arr.ARE_YOU_SURE))
	{
		document.location.href=url;
	}
}

//function modified to apply the patch ref : Ticket #4065
function valid(c,type)
{
	if(type == 'name')
	{
		return (((c >= 'a') && (c <= 'z')) ||((c >= 'A') && (c <= 'Z')) ||((c >= '0') && (c <= '9')) || (c == '.') || (c == '_') || (c == '-') || (c == '@') );
	}
	else if(type == 'namespace')
	{
		return (((c >= 'a') && (c <= 'z')) ||((c >= 'A') && (c <= 'Z')) ||((c >= '0') && (c <= '9')) || (c == '.')||(c==' ') || (c == '_') || (c == '-') );
	}
}
//end

function CharValidation(s,type)
{
	for (var i = 0; i < s.length; i++)
	{
		if (!valid(s.charAt(i),type))
		{
			return false;
		}
	}
	return true;
}


/** Check Upload file is in specified format(extension).
 * @param fldname -- name of the file field
 * @param fldLabel -- Lable of the file field
 * @param filter -- List of file extensions to allow. each extension must be seperated with a | sybmol.
 * Example: upload_filter("imagename","Image", "jpg|gif|bmp|png") 
 * @returns true -- if the extension is IN  specified extension.
 * @returns false -- if the extension is NOT IN specified extension.
 *
 * NOTE: If this field is mandatory,  please call emptyCheck() function before calling this function.
 */

function upload_filter(fldName, filter)
{
	var currObj=getObj(fldName)
	if(currObj.value !="")
	{
		var file=currObj.value;
		var type=file.split(".");
		var valid_extn=filter.split("|");	

		if(valid_extn.indexOf(type[type.length-1]) == -1)
		{
			alert(alert_arr.PLS_SELECT_VALID_FILE+valid_extn)
			currObj.focus();
			return false;
		}
	}	
	return true

}

function validateUrl(name)
{
	var Url = getObj(name);
	var wProtocol;

	var oRegex = new Object();
	oRegex.UriProtocol = new RegExp('');
	oRegex.UriProtocol.compile( '^(((http|https|ftp|news):\/\/)|mailto:)', 'gi' );
	oRegex.UrlOnChangeProtocol = new RegExp('') ;
	oRegex.UrlOnChangeProtocol.compile( '^(http|https|ftp|news)://(?=.)', 'gi' );

	wUrl = Url.value;
	wProtocol=oRegex.UrlOnChangeProtocol.exec( wUrl ) ;
	if ( wProtocol )
	{
		wUrl = wUrl.substr( wProtocol[0].length );
		Url.value = wUrl;
	}
}

function LTrim( value )
{

	var re = /\s*((\S+\s*)*)/;
	return value.replace(re, "$1");

}

function selectedRecords(module,category)
{
	var allselectedboxes = document.getElementById("allselectedboxes");
	var idstring  =  (allselectedboxes == null)? '' : allselectedboxes.value;
	if(idstring != '')
		window.location.href="index.php?module="+module+"&action=ExportRecords&parenttab="+category+"&idstring="+idstring;
	else
		window.location.href="index.php?module="+module+"&action=ExportRecords&parenttab="+category;
	return false;
}

function record_export(module,category,exform,idstring)
{
	var searchType = document.getElementsByName('search_type');
	var exportData = document.getElementsByName('export_data');
	for(i=0;i<2;i++){
		if(searchType[i].checked == true)
			var sel_type = searchType[i].value;
	}
	for(i=0;i<3;i++){
		if(exportData[i].checked == true)
			var exp_type = exportData[i].value;
	}
	new Ajax.Request(
			'index.php',
			{queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: "module="+module+"&action=ExportAjax&export_record=true&search_type="+sel_type+"&export_data="+exp_type+"&idstring="+idstring,
				onComplete: function(response) {
				if(response.responseText == 'NOT_SEARCH_WITHSEARCH_ALL')
				{
					$('not_search').style.display = 'block';
					$('not_search').innerHTML="<font color='red'><b>"+alert_arr.LBL_NOTSEARCH_WITHSEARCH_ALL+" "+module+"</b></font>";
					setTimeout(hideErrorMsg1,6000);

					exform.submit();
				}
				else if(response.responseText == 'NOT_SEARCH_WITHSEARCH_CURRENTPAGE')
				{
					$('not_search').style.display = 'block';
					$('not_search').innerHTML="<font color='red'><b>"+alert_arr.LBL_NOTSEARCH_WITHSEARCH_CURRENTPAGE+" "+module+"</b></font>";
					setTimeout(hideErrorMsg1,7000);

					exform.submit();
				}
				else if(response.responseText == 'NO_DATA_SELECTED')
				{	
					$('not_search').style.display = 'block';	
					$('not_search').innerHTML="<font color='red'><b>"+alert_arr.LBL_NO_DATA_SELECTED+"</b></font>";
					setTimeout(hideErrorMsg1,3000);
				}
				else if(response.responseText == 'SEARCH_WITHOUTSEARCH_ALL')
				{
					if(confirm(alert_arr.LBL_SEARCH_WITHOUTSEARCH_ALL))
					{
						exform.submit();
					}					
				}
				else if(response.responseText == 'SEARCH_WITHOUTSEARCH_CURRENTPAGE')
				{
					if(confirm(alert_arr.LBL_SEARCH_WITHOUTSEARCH_CURRENTPAGE))
					{
						exform.submit();
					}
				}
				else
				{
					exform.submit(); 
				}
			}
			}
	);

}


function hideErrorMsg1()
{
	$('not_search').style.display = 'none';
}

//Replace the % sign with %25 to make sure the AJAX url is going wel.
function escapeAll(tagValue)
{
	//return escape(tagValue.replace(/%/g, '%25'));
	if(default_charset.toLowerCase() == 'utf-8')
		return encodeURIComponent(tagValue.replace(/%/g, '%25'));
	else
		return escape(tagValue.replace(/%/g, '%25'));
}

function removeHTMLFormatting(str) {
	str = str.replace(/<([^<>]*)>/g, " ");
	str = str.replace(/&nbsp;/g, " ");
	return str;
}
function get_converted_html(str)
{
	var temp = str.toLowerCase();
	if(temp.indexOf('<') != '-1' || temp.indexOf('>') != '-1')
	{
		str = str.replace(/</g,'&lt;');
		str = str.replace(/>/g,'&gt;');
	}
	if( temp.match(/(script).*(\/script)/))
	{
		str = str.replace(/&/g,'&amp;');
	}
	else if(temp.indexOf('&') != '-1')
	{
		str = str.replace(/&/g,'&amp;');
	}
	return str;
}
//To select the select all check box(if all the items are selected) when the form loads.
function default_togglestate(obj_id)
{
	var all_state=true;
	if (typeof(getObj(obj_id).length)=="undefined") 
	{
		var state=getObj(obj_id).checked;
		if (state == false)
		{
			all_state=false;
		}


	} 
	else
	{
		for (var i=0;i<(getObj(obj_id).length);i++)
		{
			var state=getObj(obj_id)[i].checked;
			if (state == false)
			{
				all_state=false;
				break;
			}
		}
	}
	getObj("selectall").checked=all_state;

}

//for select  multiple check box in multiple pages for Campaigns related list:

function rel_check_object(sel_id,module)
{
	var selected;
	var select_global=new Array();
	var cookie_val=get_cookie(module+"_all");
	if(cookie_val == null)
		selected=sel_id.value+";";
	else
		selected=trim(cookie_val);
	select_global=selected.split(";");
	var box_value=sel_id.checked;
	var id= sel_id.value;
	var duplicate=select_global.indexOf(id);
	var size=select_global.length-1;
	var result="";
	if(box_value == true)
	{
		if(duplicate == "-1")
		{
			select_global[size]=id;
		}

		size=select_global.length-1;
		var i=0;
		for(i=0;i<=size;i++)
		{
			if(trim(select_global[i])!='')
				result=select_global[i]+";"+result;
		}
		rel_default_togglestate(module);

	}
	else
	{
		if(duplicate != "-1")

			select_global.splice(duplicate,1)

			size=select_global.length-1;
		var i=0;
		for(i=size;i>=0;i--)
		{
			if(trim(select_global[i])!='')
				result=select_global[i]+";"+result;
		}
		getObj(module+"_selectall").checked=false;

	}
	set_cookie(module+"_all",result);
}

//Function to select all the items in the current page for Campaigns related list:.
function rel_toggleSelect(state,relCheckName,module) {
	if (getObj(relCheckName)) {
		if (typeof(getObj(relCheckName).length)=="undefined") {
			getObj(relCheckName).checked=state
		} else
		{
			for (var i=0;i<getObj(relCheckName).length;i++)
			{
				getObj(relCheckName)[i].checked=state
				rel_check_object(getObj(relCheckName)[i],module)
			}
		}
	}
}
//To select the select all check box(if all the items are selected) when the form loads for Campaigns related list:.
function rel_default_togglestate(module)
{
	var all_state=true;
	if(getObj(module+"_selected_id"))
	{
		if (typeof(getObj(module+"_selected_id").length)=="undefined")
		{		     
			var state=getObj(module+"_selected_id").checked;
			if (state == false)
				all_state=false;

		}
		else{

			for (var i=0;i<(getObj(module+"_selected_id").length);i++)
			{
				var state=getObj(module+"_selected_id")[i].checked;
				if (state == false)
					all_state=false;
			}
		}
		getObj(module+"_selectall").checked=all_state;
	}
}
//To clear all the checked items in all the pages for Campaigns related list:
function clear_checked_all(module)
{
	var cookie_val=get_cookie(module+"_all");
	if(cookie_val != null)
		delete_cookie(module+"_all");
	//Uncheck all the boxes in current page..
	if (typeof(getObj(module+"_selected_id").length)=="undefined")
		getObj(module+"_selected_id").checked=false;
	else{

		for (var i=0;i<getObj(module+"_selected_id").length;i++)
		{
			getObj(module+"_selected_id")[i].checked=false;
		}
	}
	getObj(module+"_selectall").checked=false;

}

function toggleSelect_ListView(state,relCheckName) {
	if (getObj(relCheckName)) {
		if (typeof(getObj(relCheckName).length)=="undefined") {
			getObj(relCheckName).checked=state;
			check_object(getObj(relCheckName))
		} else {
			for (var i=0;i<getObj(relCheckName).length;i++)
			{
				getObj(relCheckName)[i].checked=state
				check_object(getObj(relCheckName)[i])
			}
		}
	}
}
function gotourl(url)
{
	document.location.href=url;
}

//Function to display the element with id given by showid and hide the element with id given by hideid
function toggleShowHide(showid, hideid)
{
	var show_ele = document.getElementById(showid);
	var hide_ele = document.getElementById(hideid);
	if(show_ele != null) 
		show_ele.style.display = "inline";
	if(hide_ele != null) 
		hide_ele.style.display = "none";
}

/******************************************************************************/
/* Activity reminder Customization: Setup Callback */
function ActivityReminderProgressIndicator(show) {
	if(show) $("status").style.display = "inline";
	else $("status").style.display = "none";
}

function ActivityReminderSetupCallback(cbmodule, cbrecord) { 
	if(cbmodule && cbrecord) {

		ActivityReminderProgressIndicator(true);
		new Ajax.Request(
				'index.php',
				{queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody:"module=Calendar&action=CalendarAjax&ajax=true&file=ActivityReminderSetupCallbackAjax&cbmodule="+ 
					encodeURIComponent(cbmodule) + "&cbrecord=" + encodeURIComponent(cbrecord),
					onComplete: function(response) {
					$("ActivityReminder_callbacksetupdiv").innerHTML=response.responseText;

					ActivityReminderProgressIndicator(false);

				}});
	}
}

function ActivityReminderSetupCallbackSave(form) {
	var cbmodule = form.cbmodule.value;   
	var cbrecord = form.cbrecord.value;
	var cbaction = form.cbaction.value;

	var cbdate   = form.cbdate.value;
	var cbtime   = form.cbhour.value + ":" + form.cbmin.value;

	if(cbmodule && cbrecord) {
		ActivityReminderProgressIndicator(true);

		new Ajax.Request("index.php", 
				{ queue:{position:"end", scope:"command"}, method:"post", 
			postBody:"module=Calendar&action=CalendarAjax&ajax=true&file=ActivityReminderSetupCallbackAjax" + 
			"&cbaction=" + encodeURIComponent(cbaction) +
			"&cbmodule="+ encodeURIComponent(cbmodule) + 
			"&cbrecord=" + encodeURIComponent(cbrecord) + 
			"&cbdate=" + encodeURIComponent(cbdate) + 
			"&cbtime=" + encodeURIComponent(cbtime),
			onComplete:function (response) {ActivityReminderSetupCallbackSaveProcess(response.responseText);}}); 
	}
}
function ActivityReminderSetupCallbackSaveProcess(message) {
	ActivityReminderProgressIndicator(false);
	$('ActivityReminder_callbacksetupdiv_lay').style.display='none';
}

function ActivityReminderPostponeCallback(cbmodule, cbrecord) { 
	if(cbmodule && cbrecord) {

		ActivityReminderProgressIndicator(true);
		new Ajax.Request("index.php", 
				{ queue:{position:"end", scope:"command"}, method:"post", 
			postBody:"module=Calendar&action=CalendarAjax&ajax=true&file=ActivityReminderSetupCallbackAjax&cbaction=POSTPONE&cbmodule="+ 
			encodeURIComponent(cbmodule) + "&cbrecord=" + encodeURIComponent(cbrecord), 
			onComplete:function (response) {ActivityReminderPostponeCallbackProcess(response.responseText);}}); 
	}
}
function ActivityReminderPostponeCallbackProcess(message) {
	ActivityReminderProgressIndicator(false);
}
/* END */

/* ActivityReminder Customization: Pool Callback */
var ActivityReminder_regcallback_timer;

var ActivityReminder_callback_delay = 40 * 1000; // Milli Seconds
var ActivityReminder_autohide = false; // If the popup should auto hide after callback_delay?

var ActivityReminder_popup_maxheight = 75;

var ActivityReminder_callback;
var ActivityReminder_timer;
var ActivityReminder_progressive_height = 2; // px
var ActivityReminder_popup_onscreen = 2 * 1000; // Milli Seconds (should be less than ActivityReminder_callback_delay)

var ActivityReminder_callback_win_uniqueids = new Object();

function ActivityReminderCallback() { 
	if(ActivityReminder_regcallback_timer) {
		window.clearTimeout(ActivityReminder_regcallback_timer);
		ActivityReminder_regcallback_timer = null;
	}
	new Ajax.Request("index.php", 
			{ queue:{position:"end", scope:"command"}, method:"post", 
		postBody:"module=Calendar&action=CalendarAjax&file=ActivityReminderCallbackAjax&ajax=true", 
		onComplete:function (response) {ActivityReminderCallbackProcess(response.responseText);}}); 
}
function ActivityReminderCallbackProcess(message) {
	ActivityReminder_callback = document.getElementById("ActivityRemindercallback");
	if(ActivityReminder_callback == null) return;

	var winuniqueid = 'ActivityReminder_callback_win_' + (new Date()).getTime();
	if(ActivityReminder_callback_win_uniqueids[winuniqueid]) {
		winuniqueid += "-" + (new Date()).getTime();
	}
	ActivityReminder_callback_win_uniqueids[winuniqueid] = true;

	var ActivityReminder_callback_win = document.createElement("span");
	ActivityReminder_callback_win.id  = winuniqueid;
	ActivityReminder_callback.appendChild(ActivityReminder_callback_win);

	ActivityReminder_callback_win.innerHTML = message; 
	ActivityReminder_callback_win.style.height = "0px"; 
	ActivityReminder_callback_win.style.display = ""; 
	if(message != "") ActivityReminderCallbackRollout(ActivityReminder_popup_maxheight, ActivityReminder_callback_win); 
	else { ActivityReminderCallbackReset(0, ActivityReminder_callback_win); }
}
function ActivityReminderCallbackRollout(z, ActivityReminder_callback_win) {
	ActivityReminder_callback_win = $(ActivityReminder_callback_win);

	if (ActivityReminder_timer) { window.clearTimeout(ActivityReminder_timer); } 
	if (parseInt(ActivityReminder_callback_win.style.height) < z) { 
		ActivityReminder_callback_win.style.height = parseInt(ActivityReminder_callback_win.style.height) + ActivityReminder_progressive_height + "px"; 
		ActivityReminder_timer = setTimeout("ActivityReminderCallbackRollout(" + z + ",'" + ActivityReminder_callback_win.id + "')", 1); 
	} else { 
		ActivityReminder_callback_win.style.height = z + "px"; 
		if(ActivityReminder_autohide) ActivityReminder_timer = setTimeout("ActivityReminderCallbackRollin(1,'" + ActivityReminder_callback_win.id + "')", ActivityReminder_popup_onscreen);
		else ActivityReminderRegisterCallback(ActivityReminder_callback_delay);
	} 
}
function ActivityReminderCallbackRollin(z, ActivityReminder_callback_win) {
	ActivityReminder_callback_win = $(ActivityReminder_callback_win);

	if (ActivityReminder_timer) { window.clearTimeout(ActivityReminder_timer); } 
	if (parseInt(ActivityReminder_callback_win.style.height) > z) { 
		ActivityReminder_callback_win.style.height = parseInt(ActivityReminder_callback_win.style.height) - ActivityReminder_progressive_height + "px"; 
		ActivityReminder_timer = setTimeout("ActivityReminderCallbackRollin(" + z + ",'" + ActivityReminder_callback_win.id + "')", 1); 
	} else { 
		ActivityReminderCallbackReset(z, ActivityReminder_callback_win);
	} 
}
function ActivityReminderCallbackReset(z, ActivityReminder_callback_win) {
	ActivityReminder_callback_win = $(ActivityReminder_callback_win);

	if(ActivityReminder_callback_win) {
		ActivityReminder_callback_win.style.height = z + "px"; 
		ActivityReminder_callback_win.style.display = "none";
	} 
	if(ActivityReminder_timer) {
		window.clearTimeout(ActivityReminder_timer);
		ActivityReminder_timer = null;
	}
	ActivityReminderRegisterCallback(ActivityReminder_callback_delay);
}
function ActivityReminderRegisterCallback(timeout) {
	if(timeout == null) timeout = 1;
	if(ActivityReminder_regcallback_timer == null) {
		ActivityReminder_regcallback_timer = setTimeout("ActivityReminderCallback()", timeout);
	}
}

//added for finding duplicates
function movefields() 
{
	availListObj=getObj("availlist")
	selectedColumnsObj=getObj("selectedCol")
	for (i=0;i<selectedColumnsObj.length;i++) 
	{

		selectedColumnsObj.options[i].selected=false
	}

	movefieldsStep1();
}

function movefieldsStep1()
{

	availListObj=getObj("availlist")
	selectedColumnsObj=getObj("selectedCol")	
	document.getElementById("selectedCol").style.width="164px";
	var count=0;
	for(i=0;i<availListObj.length;i++)
	{
		if (availListObj.options[i].selected==true) 
		{
			count++;
		}

	}
	var total_fields=count+selectedColumnsObj.length;	
	if (total_fields >4 )
	{
		alert(alert_arr.MAX_RECORDS)
		return false
	}		
	if (availListObj.options.selectedIndex > -1)
	{
		for (i=0;i<availListObj.length;i++) 
		{
			if (availListObj.options[i].selected==true) 
			{
				var rowFound=false;
				for (j=0;j<selectedColumnsObj.length;j++) 
				{
					selectedColumnsObj.options[j].value==availListObj.options[i].value;
					if (selectedColumnsObj.options[j].value==availListObj.options[i].value) 
					{
						var rowFound=true;
						var existingObj=selectedColumnsObj.options[j];
						break;
					}
				}

				if (rowFound!=true) 
				{
					var newColObj=document.createElement("OPTION")
					newColObj.value=availListObj.options[i].value
					if (browser_ie) newColObj.innerText=availListObj.options[i].innerText
					else if (browser_nn4 || browser_nn6) newColObj.text=availListObj.options[i].text
					selectedColumnsObj.appendChild(newColObj)
					newColObj.selected=true
				} 
				else 
				{
					existingObj.selected=true
				}
				availListObj.options[i].selected=false
				movefieldsStep1();
			}
		}
	}
}

function selectedColClick(oSel)
{
	if (oSel.selectedIndex == -1 || oSel.options[oSel.selectedIndex].disabled == true)
	{
		alert(alert_arr.NOT_ALLOWED_TO_EDIT);
		oSel.options[oSel.selectedIndex].selected = false;	
	}
}	

function delFields() 
{
	selectedColumnsObj=getObj("selectedCol");
	selected_tab = $("dupmod").value;
	if (selectedColumnsObj.options.selectedIndex > -1)
	{
		for (i=0;i < selectedColumnsObj.options.length;i++) 
		{
			if(selectedColumnsObj.options[i].selected == true)
			{
				if(selected_tab == 4)
				{
					if(selectedColumnsObj.options[i].innerHTML == "Last Name")
					{
						alert(alert_arr.DEL_MANDATORY);
						del = false;
						return false;
					}
					else
						del = true;

				}
				else if(selected_tab == 7)
				{
					if(selectedColumnsObj.options[i].innerHTML == "Last Name" || selectedColumnsObj.options[i].innerHTML == "Company")
					{
						alert(alert_arr.DEL_MANDATORY);
						del = false;
						return false;
					}
					else
						del = true;
				}
				else if(selected_tab == 6)
				{
					if(selectedColumnsObj.options[i].innerHTML == "Account Name")
					{
						alert(alert_arr.DEL_MANDATORY);
						del = false;
						return false;
					}
					else
						del = true;
				}
				else if(selected_tab == 14)
				{
					if(selectedColumnsObj.options[i].innerHTML == "Product Name")
					{
						alert(alert_arr.DEL_MANDATORY);
						del = false;
						return false;
					}
					else
						del = true;
				}
				if(del == true)
				{
					selectedColumnsObj.remove(i);
					delFields();
				}
			}
		}
	}
}

function moveFieldUp() 
{
	selectedColumnsObj=getObj("selectedCol")
	var currpos=selectedColumnsObj.options.selectedIndex
	var tempdisabled= false;
	for (i=0;i<selectedColumnsObj.length;i++) 
	{
		if(i != currpos)
			selectedColumnsObj.options[i].selected=false
	}
	if (currpos>0) 
	{
		var prevpos=selectedColumnsObj.options.selectedIndex-1

		if (browser_ie) 
		{
			temp=selectedColumnsObj.options[prevpos].innerText
			tempdisabled = selectedColumnsObj.options[prevpos].disabled;
			selectedColumnsObj.options[prevpos].innerText=selectedColumnsObj.options[currpos].innerText
			selectedColumnsObj.options[prevpos].disabled = false;
			selectedColumnsObj.options[currpos].innerText=temp
			selectedColumnsObj.options[currpos].disabled = tempdisabled;     
		} 
		else if (browser_nn4 || browser_nn6) 
		{
			temp=selectedColumnsObj.options[prevpos].text
			tempdisabled = selectedColumnsObj.options[prevpos].disabled;
			selectedColumnsObj.options[prevpos].text=selectedColumnsObj.options[currpos].text
			selectedColumnsObj.options[prevpos].disabled = false;
			selectedColumnsObj.options[currpos].text=temp
			selectedColumnsObj.options[currpos].disabled = tempdisabled;
		}
		temp=selectedColumnsObj.options[prevpos].value
		selectedColumnsObj.options[prevpos].value=selectedColumnsObj.options[currpos].value
		selectedColumnsObj.options[currpos].value=temp
		selectedColumnsObj.options[prevpos].selected=true
		selectedColumnsObj.options[currpos].selected=false
	}

}

function moveFieldDown() 
{
	selectedColumnsObj=getObj("selectedCol")
	var currpos=selectedColumnsObj.options.selectedIndex
	var tempdisabled= false;
	for (i=0;i<selectedColumnsObj.length;i++) 
	{
		if(i != currpos)
			selectedColumnsObj.options[i].selected=false
	}
	if (currpos<selectedColumnsObj.options.length-1)	
	{
		var nextpos=selectedColumnsObj.options.selectedIndex+1

		if (browser_ie) 
		{	
			temp=selectedColumnsObj.options[nextpos].innerText
			tempdisabled = selectedColumnsObj.options[nextpos].disabled;
			selectedColumnsObj.options[nextpos].innerText=selectedColumnsObj.options[currpos].innerText
			selectedColumnsObj.options[nextpos].disabled = false;
			selectedColumnsObj.options[nextpos];

			selectedColumnsObj.options[currpos].innerText=temp
			selectedColumnsObj.options[currpos].disabled = tempdisabled;
		}
		else if (browser_nn4 || browser_nn6) 
		{
			temp=selectedColumnsObj.options[nextpos].text
			tempdisabled = selectedColumnsObj.options[nextpos].disabled;
			selectedColumnsObj.options[nextpos].text=selectedColumnsObj.options[currpos].text
			selectedColumnsObj.options[nextpos].disabled = false;
			selectedColumnsObj.options[nextpos];
			selectedColumnsObj.options[currpos].text=temp
			selectedColumnsObj.options[currpos].disabled = tempdisabled;
		}
		temp=selectedColumnsObj.options[nextpos].value
		selectedColumnsObj.options[nextpos].value=selectedColumnsObj.options[currpos].value
		selectedColumnsObj.options[currpos].value=temp

		selectedColumnsObj.options[nextpos].selected=true
		selectedColumnsObj.options[currpos].selected=false
	}
}

function lastImport(module,req_module)
{
	var module_name= module;
	var parent_tab= document.getElementById('parenttab').value;
	if(module == '')
	{
		return false;
	}
	else

		//alert("index.php?module="+module_name+"&action=lastImport&req_mod="+req_module+"&parenttab="+parent_tab);
		window.open("index.php?module="+module_name+"&action=lastImport&req_mod="+req_module+"&parenttab="+parent_tab,"lastImport","width=750,height=602,menubar=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=yes");
}

function merge_fields(selectedNames,module,parent_tab)
{

	var select_options=document.getElementsByName(selectedNames);
	var x= select_options.length;
	var req_module=module;
	var num_group=$("group_count").innerHTML;
	var pass_url="";
	var flag=0;
	//var i=0;		
	var xx = 0;
	for(i = 0; i < x ; i++)
	{
		if(select_options[i].checked)
		{
			pass_url = pass_url+select_options[i].value +","
			xx++
		}
	}
	var tmp = 0
	if ( xx != 0)
	{

		if(xx > 3)
		{
			alert(alert_arr.MAX_THREE)
			return false;
		}
		if(xx > 0)
		{
			for(j=0;j<num_group;j++)
			{
				flag = 0
				var group_options=document.getElementsByName("group"+j);
				for(i = 0; i < group_options.length ; i++)
				{
					if(group_options[i].checked)
					{
						flag++
					}
				}
				if(flag > 0)
					tmp++;
			}
			if (tmp > 1)
			{
				alert(alert_arr.SAME_GROUPS)
				return false;
			}
			if(xx <2)
			{
				alert(alert_arr.ATLEAST_TWO)
				return false;
			}

		}			

		window.open("index.php?module="+req_module+"&action=ProcessDuplicates&mergemode=mergefields&passurl="+pass_url+"&parenttab="+parent_tab,"Merge","width=750,height=602,menubar=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=yes");	
	}
	else
	{
		alert(alert_arr.ATLEAST_TWO);			
		return false;
	}		
}

function delete_fields(module)
{
	var select_options=document.getElementsByName('del');
	var x=select_options.length;
	var xx=0;
	url_rec="";

	for(var i=0;i<x;i++)
	{
		if(select_options[i].checked)
		{
			url_rec=url_rec+select_options[i].value +","
			xx++
		}	
	}			
	if($("current_action"))
		cur_action = $("current_action").innerHTML		
		if (xx == 0)
		{
			alert(alert_arr.SELECT);
			return false;
		} 
	var alert_str = alert_arr.DELETE + xx +alert_arr.RECORDS;
	if(module=="Accounts")
		alert_str = alert_arr.DELETE_ACCOUNT + xx +alert_arr.RECORDS;
	if(confirm(alert_str))
	{
		$("status").style.display="inline";
		new Ajax.Request(
				'index.php',
				{queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody:"module="+module+"&action="+module+"Ajax&file=FindDuplicateRecords&del_rec=true&ajax=true&return_module="+module+"&idlist="+url_rec+"&current_action="+cur_action+"&"+dup_start,
					onComplete: function(response) {
					$("status").style.display="none";
					$("duplicate_ajax").innerHTML= response.responseText;
				}
				}
		);
	}
	else
		return false;	
}



function validate_merge(module)
{
	var check_var=false;
	var check_lead1=false;
	var check_lead2=false;	

	var select_parent=document.getElementsByName('record');
	var len = select_parent.length;
	for(var i=0;i<len;i++)
	{
		if(select_parent[i].checked)
		{
			var check_parentvar=true;
		}
	}
	if (check_parentvar!=true)
	{
		alert(alert_arr.Select_one_record_as_parent_record);
		return false;
	}
	return true;
}		

function select_All(fieldnames,cnt,module)
{
	var new_arr = Array();
	new_arr = fieldnames.split(",");
	var len=new_arr.length;
	for(i=0;i<len;i++)
	{
		var fld_names=new_arr[i]
		                      var value=document.getElementsByName(fld_names)
		                      var fld_len=document.getElementsByName(fld_names).length;
		for(j=0;j<fld_len;j++)
		{
			value[cnt].checked='true'
				//	alert(value[j].checked)
		}	

	}
}

function selectAllDel(state,checkedName)
{
	var selectedOptions=document.getElementsByName(checkedName);
	var length=document.getElementsByName(checkedName).length;
	if(typeof(length) == 'undefined')
	{
		return false;
	}	
	for(var i=0;i<length;i++)
	{
		selectedOptions[i].checked=state;
	}	
}

function selectDel(ThisName,CheckAllName)
{
	var ThisNameOptions=document.getElementsByName(ThisName);
	var CheckAllNameOptions=document.getElementsByName(CheckAllName);
	var len1=document.getElementsByName(ThisName).length;
	var flag = true;
	if (typeof(document.getElementsByName(ThisName).length)=="undefined")
	{
		flag=true;
	}
	else 
	{
		for (var j=0;j<len1;j++) 
		{
			if (ThisNameOptions[j].checked==false)
			{
				flag=false
				break;
			}
		}
	}
	CheckAllNameOptions[0].checked=flag
}

//Added for page navigation in duplicate-listview
var dup_start = "";
function getDuplicateListViewEntries_js(module,url)
{
	dup_start = url;
	$("status").style.display="block";
	new Ajax.Request(
			'index.php',
			{queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody:"module="+module+"&action="+module+"Ajax&file=FindDuplicateRecords&ajax=true&"+dup_start,
				onComplete: function(response) {
				$("status").style.display="none";
				$("duplicate_ajax").innerHTML = response.responseText;
			}
			}
	);
}

/* End */

//Added after 5.0.4 for Documents Module
function positionDivToCenter(targetDiv)
{
	//Gets the browser's viewport dimension
	getViewPortDimension();
	//Gets the Target DIV's width & height in pixels using parseInt function
	divWidth =(parseInt(document.getElementById(targetDiv).style.width))/2;
	divHeight=(parseInt(document.getElementById(targetDiv).style.height))/2;
	//calculate horizontal and vertical locations relative to Viewport's dimensions
	mx = parseInt(XX/2)-parseInt(divWidth);
	my = parseInt(YY/3)-parseInt(divHeight);
	//Prepare the DIV and show in the center of the screen.
	document.getElementById(targetDiv).style.left=mx+"px";
	document.getElementById(targetDiv).style.top=my+"px";
}

function getViewPortDimension()
{
	if(!document.all)
	{
		XX = self.innerWidth;
		YY = self.innerHeight;
	}
	else if(document.all)
	{
		XX = document.documentElement.clientWidth;
		YY = document.documentElement.clientHeight;  
	}
}

function toggleTable(id) {

	var listTableObj=getObj(id);
	if(listTableObj.style.display=="none")
	{
		listTableObj.style.display="";
	}
	else 
	{
		listTableObj.style.display="none";
	}
	//set_cookie(id,listTableObj.style.display)
}

function FileAdd(obj,Lay,return_action){
	fnvshobj(obj,Lay);	
	window.frames['AddFile'].document.getElementById('divHeader').innerHTML="Add file";
	window.frames['AddFile'].document.FileAdd.return_action.value=return_action;
	positionDivToCenter(Lay);
}

function dldCntIncrease(fileid)
{
	new Ajax.Request(
			'index.php',
			{queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'action=DocumentsAjax&mode=ajax&file=SaveFile&module=Documents&file_id='+fileid+"&act=updateDldCnt",
				onComplete: function(response) {
			}
			}
	);
}
//End Documents Module

//asterisk integration :: starts

/**
 * this function gets the dimension of a node
 * @param node - the node whose dimension you want
 * @return height and width in array format
 */
function getDimension(node){
	var ht = node.offsetHeight;
	var wdth = node.offsetWidth;
	var nodeChildren = node.getElementsByTagName("*");
	var noOfChildren = nodeChildren.length;
	for(var index =0;index<noOfChildren;++index){
		ht = Math.max(nodeChildren[index].offsetHeight, ht);
		wdth = Math.max(nodeChildren[index].offsetWidth,wdth);
	}
	return {x: wdth,y: ht};
}

/**
 * this function accepts a number and displays a div stating that there is an outgoing call
 * then it calls the number
 * @param number - the number to be called
 */
function startCall(number){
	div = document.getElementById('OutgoingCall').innerHTML;					
	outgoingPopup = _defPopup();
	outgoingPopup.content = div;
	outgoingPopup.displayPopup(outgoingPopup.content);

	//var ASTERISK_DIV_TIMEOUT = 6000;
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'action=UsersAjax&mode=ajax&file=StartCall&module=Users&number='+number,
				onComplete: function(response) {
				if(response.responseText == ''){
					//successfully called
				}else{
					alert(response.responseText);
				}
			}
			}
	);
}
//asterisk integration :: ends

//added for tooltip manager
function ToolTipManager(){
	var state = false;
	var divName = '__VT_tooltip';
	/**
	 * this function creates the tooltip div and adds the information to it
	 * @param string text - the text to be added to the tooltip
	 */
	function tip(node, text){
		state=true;
		var div = document.getElementById(divName)
		if(!div){
			div = document.createElement('div');
			div.id = divName;
			div.style.position = 'absolute';
			if(typeof div.style.opacity == "string"){
				div.style.opacity = 0.8;
			}
			div.className = "tooltipClass";
		}

		div.innerHTML = text;
		document.body.appendChild(div);
		div.style.display = "block";
		positionTooltip(node, divName);
	}

	/**
	 * this function removes the tooltip div
	 */
	function unTip(nodelay){
		state=false;
		var div = document.getElementById(divName);
		if(typeof nodelay != 'undefined' && nodelay){
			div.style.display = "none";
		}else{
			setTimeout(function(){	
				if(!state){
					div.style.display = "none";
				}
			}, 700);
		}
	}

	/**
	 * this function is used to position the tooltip div
	 * @param string obj - the id of the element where the div has to appear
	 * @param object div - the div which contains the info
	 */
	function positionTooltip(obj,div){
		var tooltip = document.getElementById(div);
		var leftSide = findPosX(obj);
		var topSide = findPosY(obj);
		var dimensions = getDimension(tooltip);
		var widthM = dimensions.x;
		var getVal = eval(leftSide) + eval(widthM);
		var tooltipDimensions = getDimension(obj);
		var tooltipWidth = tooltipDimensions.x;

		if(getVal  > document.body.clientWidth ){
			leftSide = eval(leftSide) - eval(widthM);
			tooltip.style.left = leftSide + 'px';
		}else{
			leftSide = eval(leftSide) + eval(tooltipWidth)+10;
			tooltip.style.left = leftSide + 'px';
		}

		var heightTooltip = dimensions.y;
		var bottomSide = eval(topSide) + eval(heightTooltip);
		if(bottomSide > document.body.clientHeight){
			topSide = topSide - (bottomSide - document.body.clientHeight) - 10;
		}else{
			topSide = eval(topSide) - eval(heightTooltip)/2;
			if(topSide<0){
				topSide = 10;
			}
		}
		tooltip.style.top= topSide + 'px';
	}

	return {tip:tip, untip:unTip};
}
if(!tooltip){
	var tooltip = ToolTipManager();
}
//tooltip manager changes end

//Added for Documents module
function changeDldType(type){
	if(type != null && type.value == 'I'){
		document.getElementById('external').style.display="none";
		document.getElementById('internal').style.display="block";
	} else{
		document.getElementById('external').style.display="block";
		document.getElementById('internal').style.display="none";
	}
}


function checkAll(){
	var spanObj=document.getElementById('spanid');
	var spanObjHidden=document.getElementById('spanHidden');
	if(document.getElementById('tous').checked)
	{
		spanObj.innerHTML='';
		spanObjHidden.innerHTML='<input type="hidden" onblur="this.className="detailedViewTextBox"" onfocus="this.className="detailedViewTextBoxOn"" class="detailedViewTextBox" tabindex="6" value="1000" name="popimpactee" id="popimpactee"/>';
	}
	else
	{
		spanObj.innerHTML='<input type="text" onblur="this.className="detailedViewTextBox"" onfocus="this.className="detailedViewTextBoxOn"" class="detailedViewTextBox" tabindex="6" value="" name="popimpactee" id="popimpactee"/>';
		spanObjHidden.innerHTML='';
	}
}
function checkAllBis(){
	var spanObj=document.getElementById('spanid');
	var spanObjHidden=document.getElementById('spanHidden');
	if(document.getElementById('tous').checked)
	{
		//spanObj.innerHTML='';
		spanObjHidden.innerHTML='<input type="hidden" onblur="this.className="detailedViewTextBox"" onfocus="this.className="detailedViewTextBoxOn"" class="detailedViewTextBox" tabindex="6" value="1000" name="popimpactee" id="popimpactee"/>';
	}
	else
	{
		spanObj.innerHTML='<input type="text" onblur="this.className="detailedViewTextBox"" onfocus="this.className="detailedViewTextBoxOn"" class="detailedViewTextBox" tabindex="6" value="" name="popimpactee" id="popimpactee"/>';
		//spanObjHidden.innerHTML='';
	}
}
function displayTraitementById(id , nbTab){
	
	for(var index = 0; index <= nbTab; index++ ){
		var idTab='tab_'+ index ;
		var tabObji=document.getElementById(idTab);
		tabObji.style.display="none";
	}
	var tabObjToShow=document.getElementById(id);
	tabObjToShow.style.display="block";
}

function confirmPriseEnMain(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_PRISE_EN_MAIN_DEMANDE;
	else
		msg = alert_arr.CONFIRMER_PRISE_EN_MAIN_INCIDENT;
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}

function confirmRelance(module, dateRelance) {
	var msg;
	if (module == 'Demandes') {
		if(dateRelance == '') {
			msg = alert_arr.CONFIRMER_RELANCER_DEMANDE;
		}
		else {
			msg = alert_arr.DATE_DERNIERE_RELANCE + dateRelance + '. \n' + alert_arr.CONFIRMER_RELANCER_DEMANDE_A_NOUVEAU;
		}
	}
	else {
		if(dateRelance == '') {
			msg = alert_arr.CONFIRMER_RELANCER_INCIDENT;
		}
		else {
			msg = alert_arr.DATE_DERNIERE_RELANCE + dateRelance + '.  \n' + alert_arr.CONFIRMER_RELANCER_INCIDENT_A_NOUVEAU;
		}
	}
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}

function isTimeValide(timeObj) {
	
	if(timeObj != undefined) {
		var time = timeObj.value;
		if(time == '') {
			//alert(alert_arr.INCIDENT_INVALIDE_TIME);	
			alert("Veuillez renseigner l\'heure au format hh:mm ");	
			return false;
		} 
		else {
			var time_val = time.split(':');
			if (time_val.length != 2) {
				//alert(alert_arr.INCIDENT_INVALIDE_TIME);	
				alert("Veuillez renseigner l\'heure au format hh:mm ");	
				return false;
			}
			else {
				if (isNaN(parseInt(time_val[0])) == true || isNaN(parseInt(time_val[1])) == true) {
					//alert(alert_arr.INCIDENT_INCORRECT_TIME);	
					alert("Veuillez renseigner une heure correcte au format hh:mm ");	
					return false;
				}
				else {
					if (parseInt(time_val[0]) < 0 || parseInt(time_val[0]) > 23 || parseInt(time_val[1]) < 0 || parseInt(time_val[1]) > 59) {
						//alert(alert_arr.INCIDENT_INCORRECT_TIME);	
						alert("Veuillez renseigner une heure correcte au format hh:mm ");	
						return false;
					}
					else {
						return true;
					}
				}
			}
		}
	}
	else {
		return true;
	}
}

function isDateValide(dateObj) {
	
	if(dateObj != undefined) {
		var date = dateObj.value;
		if(date == '') {
			//alert(alert_arr.INCIDENT_INVALIDE_TIME);	
			alert("Veuillez renseigner la date au format dd-mm-aaaa ");	
			return false;
		} 
		else {
			var date_val = date.split('-');
			if (date_val.length != 3) {
				//alert(alert_arr.INCIDENT_INVALIDE_TIME);	
				alert("Veuillez renseigner la date au format dd-mm-aaaa ");	
				return false;
			}
			else {
				if (isNaN(parseInt(date_val[0])) == true || isNaN(parseInt(date_val[1])) == true || isNaN(parseInt(date_val[2])) == true) {
					//alert(alert_arr.INCIDENT_INCORRECT_TIME);	
					alert("Veuillez renseigner une date correcte au format dd-mm-aaaa ");	
					return false;
				}
				else {
					if (parseInt(date_val[0]) < 0 || parseInt(date_val[0]) > 31 || parseInt(date_val[1]) < 0 || parseInt(date_val[1]) > 12 || parseInt(date_val[2]) < 0) {
						//alert(alert_arr.INCIDENT_INCORRECT_TIME);	
						alert("Veuillez renseigner une date correcte au format dd-mm-aaaa ");	
						return false;
					}
					else {
						return true;
					}
				}
			}
		}
	}
	else {
		return true;
	}
}

function isDateTimeCorrect(dateObj, time_startObj, dateTraitement) {
	if(dateObj != undefined) {
		var dateTime = new Date(0);
		var currentDate = new Date(); 
		
		var date = dateObj.value;
		var time = time_startObj.value;
		
		var date_val = date.split('-');
		var time_val = time.split(':');

//		dateTime.setDate(parseInt(date_val[0]));
//		dateTime.setMonth(parseInt(date_val[1]) -1);
//		dateTime.setFullYear(parseInt(date_val[2]));
//		dateTime.setHours(parseInt(time_val[0]));
//		dateTime.setMinutes(parseInt(time_val[1]));
//		dateTime.setSeconds(0);
		
		dateTime.setDate(date_val[0]);
		dateTime.setMonth(date_val[1] -1);
		dateTime.setFullYear(date_val[2]);
		
		dateTime.setHours(time_val[0]);
		dateTime.setMinutes(time_val[1]);
		dateTime.setSeconds(0);
		//alert("datecour="+currentDate);
		//if(dateObj.name == 'heuredebut_relle') {
		//	if(dateTime >= currentDate) {
		//		alert("La date de d\351but r\351elle de l\'incident doit \352tre ant\351rieure \340 la date courrante !!! ");	
		//		return false;
		//	}
		//}	
		//if(dateObj.name == 'heurefin_relle') {
		//	if(dateTime >= currentDate) {
		//		alert("La date de fin r\351elle de l\'incident doit \352tre ant\351rieure \340 la date courrante !!! ");	
		//		return false;
		//	}
		//}	
	}

	return true;
}

function isPopImpacteeValide(popImpacteeObj) {
	if(popImpacteeObj != undefined) {
		var popImpactee = popImpacteeObj.value;
		popImpactee = trim(popImpactee);

		if (popImpactee == '') {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			//alert("Veuillez renseigner la population impact\351e au format entier !!! ");
			alert("Veuillez renseigner la population impact\351e !!! ");	
			return false;
		}
		else if (isNaN(popImpactee) == true) {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			//alert("Veuillez renseigner la population impact\351e au format entier !!! ");
			alert("La population impact\351e doit \352tre un nombre !!! ");
			return false;
		}
		else if(parseInt(popImpactee) <= 0) {
			//alert(alert_arr.INCIDENT_INVALIDE_POPIMPACTEE);	
			alert("La population impact\351e doit \352tre un nombre > 0 !!! ");
			return false;
		} 
		else {
			return true;
		}
	}
	else {
		return true;
	}
}

function isFieldsFormValide(form) {
	var typeIncidentObj = form.typeincident;
	var campagneObj = form.campagne;
	var popImpacteeObj = form.popimpactee;
	var modeFonctionnementObj = form.modefonctionnement;
	var extensionObj = form.extension;
	var heuredebut_relleObj = form.heuredebut_relle;
	var time_startObj = form.time_start;

	var typeDemandeObj = form.typedemande;
	
	var chargeMissionObj = form.matricule;
	var natmissionObj = form.natmission;
	var budgetObj = form.budget;
	var sourcefinObj = form.sourcefin;
	var codebudgetObj = form.codebudget;
	var comptenatObj = form.comptenat;
	
	/*if(chargeMissionObj != undefined) {
		var chargeMission = chargeMissionObj.value;
		if (chargeMission == '' || isNaN(chargeMission) == true) {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			alert("Veuillez choisir le charge de mission!!! ");
			return false;
		}
	}*/
	/*
	if(natmissionObj != undefined) {
		var natmission = natmissionObj.value;
		if (natmission == '' || isNaN(natmission) == true) {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			alert("Veuillez choisir la nature de la mission !!! ");
			return false;
		}
	}
	
	if(budgetObj != undefined) {
		var budget = budgetObj.value;
		if (budget == '' || isNaN(budget) == true) {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			alert("Veuillez choisir le type de budget !!! ");
			return false;
		}
	}
	
	if(sourcefinObj != undefined) {
		var sourcefin = sourcefinObj.value;
		if (sourcefin == '' || isNaN(sourcefin) == true) {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			alert("Veuillez choisir la source de financement !!! ");
			return false;
		}
	}
	
	if(codebudgetObj != undefined) {
		var codebudget = codebudgetObj.value;
		if (codebudget == '' || isNaN(codebudget) == true) {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			alert("Veuillez choisir le code budgetaire !!! ");
			return false;
		}
	}
	
	if(comptenatObj != undefined) {
		var comptenat = comptenatObj.value;
		if (comptenat == '' || isNaN(comptenat) == true) {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			alert("Veuillez choisir le compte nature !!! ");
			return false;
		}
	}
	*/
	if(typeIncidentObj != undefined) {
		var typeIncident = typeIncidentObj.value;
		if (typeIncident == '' || isNaN(typeIncident) == true) {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			alert("Veuillez choisir le type de l\'incident !!! ");
			return false;
		}
	}
	
	/*if(typeDemandeObj != undefined) {
		var typeDemande = typeDemandeObj.value;
		if (typeDemande == '' || isNaN(typeDemande) == true) {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			alert("Veuillez choisir le type de la demande !!! ");
			return false;
		}
	}*/

	if(campagneObj != undefined) {
		var campagne = campagneObj.value;
		if (campagne == '' || isNaN(campagne) == true) {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			alert("Veuillez choisir la campagne !!! ");
			return false;
		}
	}

	if (!isPopImpacteeValide(popImpacteeObj))
		return false;

	if(modeFonctionnementObj != undefined) {
		var modeFonctionnement = modeFonctionnementObj.value;
		if (modeFonctionnement == '') {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			alert("Veuillez choisir le mode de fonctionnement !!! ");
			return false;
		}
	}
	
	if(extensionObj != undefined) {
		var extension = extensionObj.value;

		if(extension == '' || isNaN(extension) == true) {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			alert("Veuillez renseigner l\'extension !!! ");
			return false;
		}
		if(isNaN(extension) == true) {
			//alert(alert_arr.INCIDENT_INCORRECT_POPIMPACTEE);
			alert("Veuillez renseigner l\'extension au format num\351rique !!! ");
			return false;
		}
		if(parseInt(extension) <= 0) {
			//alert(alert_arr.INCIDENT_INVALIDE_POPIMPACTEE);	
			alert("Veuillez renseigner une extension correcte !!! ");
			return false;
		} 
	}

	if (!isDateValide(heuredebut_relleObj))
		return false;
	
	if (!isTimeValide(time_startObj))
		return false;
	
	if (!isDateTimeCorrect(heuredebut_relleObj, time_startObj, ''))
		return false;
	
	return true;
}

function isFormTraitementValide(form) {

	var causeObj = form.cause;
	var heurefin_relleObj = form.heurefin_relle;
	var time_startObj = form.time_start;

	
	if(causeObj != undefined) {
		var cause = causeObj.value;
		
		if(cause == '') {
			//alert(alert_arr.INCIDENT_INCORRECT_CAUSE);
			alert("Veuillez renseigner la cause de l\'incident !!! ");
			return false;
		} 
		if(trim(cause) == '' || trim(cause) == '<br>') {
			//alert(alert_arr.INCIDENT_INCORRECT_CAUSE);
			alert("Veuillez renseigner la cause de l\'incident !!! ");
			return false;
		} 
	}

	if (!isDateValide(heurefin_relleObj))
		return false;
	
	if (!isTimeValide(time_startObj))
		return false;
	
	if (!isDateTimeCorrect(heurefin_relleObj, time_startObj, ''))
		return false;
	
	return true;
}

function getinfosprojet()
{
	var projectid = document.getElementById('projetid').value;
	//alert("test getinfosprojet");
	var dossier=Array[6];
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Conventions&action=ConventionsAjax&mode=ajax&file=ConventionUtils&requete=getinfosprojet&parenttab=Conventions&projectid='+projectid,
				onComplete: function(response) {
				resp= response.responseText;
				//dossier =resp.split('§§');
				//alert(resp);
				dossier =JSON.parse(resp);
				document.getElementById('organeid').value=dossier.organeid;
				document.getElementById('organe').value=dossier.organe;
				document.getElementById('politiqueid').value=dossier.politiqueid;
				document.getElementById('politique').value=dossier.politique;
				document.getElementById('programmeid').value=dossier.programmeid;
				document.getElementById('programme').value=dossier.programme;
				document.getElementById('organe').readOnly=true;
				document.getElementById('organe').style.width="300px";
				document.getElementById('politique').readOnly=true;
				document.getElementById('programme').readOnly=true;
			}
			}	
	);
}

function getinfosagent()
{
	var matricule = document.getElementById('matricule').value;
	//alert("test getinfosprojet :"+matricule);
	var dossier=Array[6];
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Demandes&action=DemandesAjax&mode=ajax&file=DemandesUtils&requete=getinfosagent&parenttab=Demandes&matricule='+matricule,
				onComplete: function(response) {
				resp= response.responseText;
				//dossier =resp.split('§§');
				alert(resp);
				dossier =JSON.parse(resp);
				document.getElementById('fonction').value=dossier.fonction;
				
			}
			}	
	);
}

function getdirectionresp()
{
	var matricule = document.getElementById('matdirecteur').value;
	//alert(matricule);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Demandes&action=DemandesAjax&mode=ajax&file=DemandeUtils&requete=getdirectionresp&parenttab=Demandes&matricule='+matricule,
				onComplete: function(response) {
				resp= response.responseText;
				document.getElementById('codedirection').value=resp;
				
			}
			}	
	);
}


function getfoncagent()
{
	var matricule = document.getElementById('matricule').value;
	//alert(matricule);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Demandes&action=DemandesAjax&mode=ajax&file=DemandeUtils&requete=getfonctionagent&parenttab=Demandes&matricule='+matricule,
				onComplete: function(response) {
				resp= response.responseText;
				document.getElementById('fonction').value=resp;
				
			}
			}	
	);
	//getBudgetsByAgentDepart();
}

function getBudgetsByAgentDepart()
{
	var matricule=document.getElementById("matricule").options[document.getElementById("matricule").selectedIndex].value;

	//alert("matricule="+matricule);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Demandes&action=DemandesAjax&mode=ajax&file=DemandeUtils&requete=getBudgetsByAgentDepart&matricule='+matricule,
				onComplete: function(response) {
				//resp = response.responseText;
				//alert("resp="+resp);
				budgets= JSON.parse(response.responseText);
				//alert("dep="+departements);
				var html = '';
				var selectdep = document.getElementById("codebudget");
				document.getElementById("codebudget").options.length = 0;
				selectdep.options[selectdep.options.length]= new Option("Choisir un code budgetaire...","");

				for(var i=0;i<budgets.length;i++)
				{					
					selectdep.options[selectdep.options.length]= new Option(budgets[i],budgets[i]);
				}
			}
			}	
	);
}

function getBudgetsByAgentDepart2()
{
	var matricule=document.getElementById("matricule").options[document.getElementById("matricule").selectedIndex].value;

	//alert("matricule="+matricule);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Demandes&action=DemandesAjax&mode=ajax&file=DemandeUtils&requete=getBudgetsByAgentDepart&matricule='+matricule,
				onComplete: function(response) {
				//resp = response.responseText;
				//alert("resp="+resp);
				budgets= JSON.parse(response.responseText);
				//alert("dep="+departements);
				var html = '';
				var selectdep = document.getElementById("codebudget2");
				document.getElementById("codebudget2").options.length = 0;
				selectdep.options[selectdep.options.length]= new Option("Choisir un code budgetaire...","");

				for(var i=0;i<budgets.length;i++)
				{					
					selectdep.options[selectdep.options.length]= new Option(budgets[i],budgets[i]);
				}
			}
			}	
	);
}

function getBudgetsByAgentDepart3()
{
	var matricule=document.getElementById("matricule").options[document.getElementById("matricule").selectedIndex].value;

	//alert("matricule="+matricule);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Demandes&action=DemandesAjax&mode=ajax&file=DemandeUtils&requete=getBudgetsByAgentDepart&matricule='+matricule,
				onComplete: function(response) {
				//resp = response.responseText;
				//alert("resp="+resp);
				budgets= JSON.parse(response.responseText);
				//alert("dep="+departements);
				var html = '';
				var selectdep = document.getElementById("codebudget3");
				document.getElementById("codebudget3").options.length = 0;
				selectdep.options[selectdep.options.length]= new Option("Choisir un code budgetaire...","");

				for(var i=0;i<budgets.length;i++)
				{					
					selectdep.options[selectdep.options.length]= new Option(budgets[i],budgets[i]);
				}
			}
			}	
	);
}

function getBudgetsByAgentDepart4()
{
	var matricule=document.getElementById("matricule").options[document.getElementById("matricule").selectedIndex].value;

	//alert("matricule="+matricule);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Demandes&action=DemandesAjax&mode=ajax&file=DemandeUtils&requete=getBudgetsByAgentDepart&matricule='+matricule,
				onComplete: function(response) {
				//resp = response.responseText;
				//alert("resp="+resp);
				budgets= JSON.parse(response.responseText);
				//alert("dep="+departements);
				var html = '';
				var selectdep = document.getElementById("codebudget4");
				document.getElementById("codebudget4").options.length = 0;
				selectdep.options[selectdep.options.length]= new Option("Choisir un code budgetaire...","");

				for(var i=0;i<budgets.length;i++)
				{					
					selectdep.options[selectdep.options.length]= new Option(budgets[i],budgets[i]);
				}
			}
			}	
	);
}

function getBudgetsByAgentDepart5()
{
	var matricule=document.getElementById("matricule").options[document.getElementById("matricule").selectedIndex].value;

	//alert("matricule="+matricule);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Demandes&action=DemandesAjax&mode=ajax&file=DemandeUtils&requete=getBudgetsByAgentDepart&matricule='+matricule,
				onComplete: function(response) {
				//resp = response.responseText;
				//alert("resp="+resp);
				budgets= JSON.parse(response.responseText);
				//alert("dep="+departements);
				var html = '';
				var selectdep = document.getElementById("codebudget5");
				document.getElementById("codebudget5").options.length = 0;
				selectdep.options[selectdep.options.length]= new Option("Choisir un code budgetaire...","");

				for(var i=0;i<budgets.length;i++)
				{					
					selectdep.options[selectdep.options.length]= new Option(budgets[i],budgets[i]);
				}
			}
			}	
	);
}
function saveaddprofin()
{
	var numconvention = document.getElementById('numconvention').value;
	var libelleprodfin = document.getElementById('libelleprodfin').value;
	var montantprodfin = document.getElementById('montantprodfin').value;
	var dateeffetprodfin = document.getElementById('jscal_field_dateeffetprodfin').value;
	var dateprodfin = document.getElementById('jscal_field_dateprodfin').value;
	
	if (libelleprodfin=='')
	{
		alert("Veillez saisir un libelle!!!");
		document.getElementById('libelleprodfin').focus();
		return false;
	}
	 if(!(parseFloat(montantprodfin) == parseInt(montantprodfin)) || isNaN(montantprodfin))
	{
		alert("Veillez saisir un montant valide (sans espace) !!!");
		document.getElementById('montantprodfin').focus();
		return false;

	}
	var regex = /^[0-9]{2}\-[0-9]{2}\-[0-9]{4}$/;
	if (!regex.test(dateeffetprodfin))
	{ 
		alert("Format Date Effet non valide !!!");
		return false;
	}
	if (!regex.test(dateprodfin))
	{ 
		alert("Format Date Saisie non valide !!!");
		return false;
	}
	//alert(numconvention+' - '+libelleprodfin+' - '+montantprodfin+' - '+dateeffetprodfin+' - '+dateeffetprodfin);
	var prodfinvalues = {numconvention: numconvention, libelleprodfin: libelleprodfin, montantprodfin: montantprodfin, dateprodfin: dateprodfin, dateeffetprodfin: dateeffetprodfin};
	var jsonStringProdfin = JSON.stringify(prodfinvalues);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Conventions&action=ConventionsAjax&mode=ajax&file=ConventionUtils&requete=saveprodfin&parenttab=Conventions&prodfinvalues='+jsonStringProdfin,
				onComplete: function(response) {
				resp= response.responseText;
				alert(resp);
				document.getElementById('libelleprodfin').value="";
				document.getElementById('montantprodfin').value="";
				document.getElementById('jscal_field_dateeffetprodfin').value="";
				document.getElementById('jscal_field_dateprodfin').value="";
	
				divaddprodfin.style.display="none";
			}
			}	
	);
}

function deleteprofin(idprodfin)
{
	if(confirm("Etes-vous certain de vouloir supprimer ce Produit Fianncier?"))
	{

		new Ajax.Request(
				'index.php',
				{	queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody: 'module=Conventions&action=ConventionsAjax&mode=ajax&file=ConventionUtils&requete=delprodfin&parenttab=Conventions&idprodfin='+idprodfin,
					onComplete: function(response) {
					//resp= response.responseText;
					location.reload();
					
					}
				}	
		);
	}
	else	
	{
		return false;
	}
}

function goengagement(iddemande)
{
	if(confirm("Etes-vous sur de vouloir creer l'engagement?"))
	{

		new Ajax.Request(
				'index.php',
				{	queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody: 'module=OrdresMission&action=OrdresMissionAjax&mode=ajax&file=CreateEngagement&record='+iddemande,
					onComplete: function(response) {
					resp= response.responseText;
					alert(resp);
					location.reload();
					}
				}	
		);
	}
	else	
	{
		return false;
	}
}


function deleteCRExecution(idexecution)
{
	if(confirm("Etes-vous certain de vouloir supprimer ce compte rendu?"))
	{
		alert("idexecution="+idexecution);
		new Ajax.Request(
				'index.php',
				{	queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody: 'module=Conventions&action=ConventionsAjax&mode=ajax&file=ConventionUtils&requete=delcrexecution&parenttab=Conventions&idexecution='+idexecution,
					onComplete: function(response) {
					//resp= response.responseText;
					location.reload();
					
					}
				}	
		);
	}
	else	
	{
		return false;
	}	
}

function addprofin()
{
	var divaddprodfin = document.getElementById('divaddprodfin');
	divaddprodfin.style.display="block";
	document.getElementById('libelleprodfin').focus();
}
function canceladdprofin()
{
	var divaddprodfin = document.getElementById('divaddprodfin');
	
	document.getElementById('libelleprodfin').value="";
	document.getElementById('montantprodfin').value="";
	document.getElementById('jscal_field_dateeffetprodfin').value="";
	document.getElementById('jscal_field_dateprodfin').value="";
	
	divaddprodfin.style.display="none";

}
function calculDeltaFin()
{
	var bailleursrate = document.getElementById('bailleursrate').value;

  if((parseFloat(bailleursrate) == parseInt(bailleursrate)) && !isNaN(bailleursrate) && bailleursrate>0 && bailleursrate<=100)
  {
	document.getElementById('bailleursrate2').value=100-bailleursrate;
  }
  else
  {
	alert("Le pourcentage de financement doit être un entier entre 0 et 100!!!");
	document.getElementById('bailleursrate').focus();
  }
}

function isbeneficiaireMOD()
{
  if (document.getElementById('beneficiaire_ismod').checked) 
  {
      document.getElementById('agenceexecution').value = document.getElementById('beneficiaire').value;	
	  document.getElementById('modlist').disabled =true;
  } 
  else 
  {
      document.getElementById('agenceexecution').value = "";	
	  document.getElementById('modlist').disabled =false;

  }
}
function getMOD()
{
	var valeur = document.getElementById('modlist').options[document.getElementById('modlist').selectedIndex].value;;
  if (valeur!='000') 
  {
      document.getElementById('agenceexecution').value = valeur;
  } 
  else 
  {
      document.getElementById('agenceexecution').value = "";	

  }
}

function getdepartement()
{
	var organeid=document.getElementById("affectorgane").options[document.getElementById("affectorgane").selectedIndex].value;

	//alert("organeid="+organeid);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Agentuemoa&action=AgentuemoaAjax&mode=ajax&file=AgentUtils&requete=getdepartementsOrgane&parenttab=Tiers&organeid='+organeid,
				onComplete: function(response) {
				departements= JSON.parse(response.responseText);
				//alert("dep="+departements);
				var html = '';
				for(var i=0;i<departements.length;i++)
				{
					//alert("dep="+departements[i]);
					var dep = departements[i].split(":");
					var selectdep = document.getElementById("affectdepartement");
					$('#affectdepartement').append(new Option('"'+dep[0]+'"','"'+dep[1]+'"'));
					//alert("dep="+dep[1]+" - "+dep[0]);
					//selectdep.innerHTML( '<option value="'+dep[0]+'">'+dep[1]+'</option>' );
				}
			}
			}	
	);
}
/*
function changenbenfants()
{
	
  var nbenf = nombreenfants.options[nombreenfants.selectedIndex].value;
  switch (nbenf)
  {
	case '0' : document.getElementById('linkaddenf1').style.display='none';break;
	case '1' : document.getElementById('linkaddenf1').style.display='block';document.getElementById('linkaddenf2').style.display='none';break;
	case '2' : document.getElementById('linkaddenf1').style.display='block';document.getElementById('linkaddenf2').style.display='block';document.getElementById('linkaddenf3').style.display='none';break;
	case '3' : document.getElementById('linkaddenf1').style.display='block';document.getElementById('linkaddenf2').style.display='block';document.getElementById('linkaddenf3').style.display='block';document.getElementById('linkaddenf4').style.display='none';break;
	case '4' : document.getElementById('linkaddenf1').style.display='block';document.getElementById('linkaddenf2').style.display='block';document.getElementById('linkaddenf3').style.display='block';document.getElementById('linkaddenf4').style.display='block';document.getElementById('linkaddenf5').style.display='none';break;
	case '5' : document.getElementById('linkaddenf1').style.display='block';document.getElementById('linkaddenf2').style.display='block';document.getElementById('linkaddenf3').style.display='block';document.getElementById('linkaddenf4').style.display='block';document.getElementById('linkaddenf5').style.display='block';document.getElementById('linkaddenf6').style.display='none';break;
	
  }
}
*/
function changenbenfants()
{
	
  var nbenf = nombreenfants.options[nombreenfants.selectedIndex].value;
  switch (nbenf)
  {
	case '0' : EnfantAgent1cancel();break;
	case '1' : EnfantAgent1display();EnfantAgent2cancel();break;
	case '2' : EnfantAgent1display();EnfantAgent2display();EnfantAgent3cancel();break;
	case '3' : EnfantAgent1display();EnfantAgent2display();EnfantAgent3display();EnfantAgent4cancel();break;
	case '4' : EnfantAgent1display();EnfantAgent2display();EnfantAgent3display();EnfantAgent4display();EnfantAgent5cancel();break;
	case '5' : EnfantAgent1display();EnfantAgent2display();EnfantAgent3display();EnfantAgent3display();EnfantAgent5display();EnfantAgent6cancel();break;
	
  }
}
/*
function changesituationfamiliale()
{
	
  var sitfam = situationfamiliale.options[situationfamiliale.selectedIndex].value;
  
  switch (sitfam)
  {
	case 'C' :  document.getElementById('linkaddconjoint').style.display='none';break;
	case 'D' :  document.getElementById('linkaddconjoint').style.display='none';break;
	case 'V' : document.getElementById('linkaddconjoint').style.display='none';break;
	case 'M' : document.getElementById('linkaddconjoint').style.display='block';break;
	default  : document.getElementById('linkaddconjoint').style.display='none';break;
	
  }
}*/
function changesituationfamiliale()
{
	
  var sitfam = situationfamiliale.options[situationfamiliale.selectedIndex].value;
  
  switch (sitfam)
  {
	case 'C' :  ConjointAgentcancel();break;
	case 'D' :  ConjointAgentcancel();break;
	case 'V' : ConjointAgentcancel();break;
	case 'M' : ConjointAgentdisplay();break;
	default  : ConjointAgentcancel();break;
	
  }
}
function banque2display()
{
	document.getElementById('banque2header').style.display= 'table-row';
	document.getElementById('banque2fields_0').style.display= 'table-row';
	document.getElementById('banque2fields_1').style.display= 'table-row';
	document.getElementById('banque2fields_2').style.display= 'table-row';
	document.getElementById('banque2fields_3').style.display= 'table-row';
	document.getElementById('banque2fields_4').style.display= 'table-row';
	document.getElementById('banque2fields_5').style.display= 'table-row';
//	document.getElementById('btnbanqueAgent2display').style.display= 'none';

}
function banque3display()
{
	document.getElementById('banque3header').style.display= 'table-row';
	document.getElementById('banque3fields_0').style.display= 'table-row';
	document.getElementById('banque3fields_1').style.display= 'table-row';
	document.getElementById('banque3fields_2').style.display= 'table-row';
	document.getElementById('banque3fields_3').style.display= 'table-row';
	document.getElementById('banque3fields_4').style.display= 'table-row';
	document.getElementById('banque3fields_5').style.display= 'table-row';
}
function banque2cancel()
{
	document.getElementById('banque2header').style.display= 'none';
	document.getElementById('banque2fields_0').style.display= 'none';
	document.getElementById('banque2fields_1').style.display= 'none';
	document.getElementById('banque2fields_2').style.display= 'none';
	document.getElementById('banque2fields_3').style.display= 'none';
	document.getElementById('banque2fields_4').style.display= 'none';
	document.getElementById('banque2fields_5').style.display= 'none';
	
	 document.getElementById('nombanque2').value = "";	
     document.getElementById('paysbanque2').value = "";	
     document.getElementById('codebanque2').value = "";	
     document.getElementById('nomagence2').value = "";	
     document.getElementById('codeguichet2').value = "";	
     document.getElementById('libellecompte2').value = "";	
     document.getElementById('numerocompte2').value = "";	
     document.getElementById('clerib2').value = "";	
     document.getElementById('devisecompte2').value = "";	
     document.getElementById('codeswift2').value = "";	
     document.getElementById('ribfile2').value = "";	

	 document.getElementById('nombanque3').value = "";	
     document.getElementById('paysbanque3').value = "";	
     document.getElementById('codebanque3').value = "";	
     document.getElementById('nomagence3').value = "";	
     document.getElementById('codeguichet3').value = "";	
     document.getElementById('libellecompte3').value = "";	
     document.getElementById('numerocompte3').value = "";	
     document.getElementById('clerib3').value = "";	
     document.getElementById('devisecompte3').value = "";	
     document.getElementById('codeswift3').value = "";	
     document.getElementById('ribfile3').value = "";	
	
	document.getElementById('banque3header').style.display= 'none';
	document.getElementById('banque3fields_0').style.display= 'none';
	document.getElementById('banque3fields_1').style.display= 'none';
	document.getElementById('banque3fields_2').style.display= 'none';
	document.getElementById('banque3fields_3').style.display= 'none';
	document.getElementById('banque3fields_4').style.display= 'none';
	document.getElementById('banque3fields_5').style.display= 'none';

}
function banque3cancel()
{
	document.getElementById('banque3header').style.display= 'none';
	document.getElementById('banque3fields_0').style.display= 'none';
	document.getElementById('banque3fields_1').style.display= 'none';
	document.getElementById('banque3fields_2').style.display= 'none';
	document.getElementById('banque3fields_3').style.display= 'none';
	document.getElementById('banque3fields_4').style.display= 'none';
	
	 document.getElementById('nombanque3').value = "";	
     document.getElementById('paysbanque3').value = "";	
     document.getElementById('codebanque3').value = "";	
     document.getElementById('nomagence3').value = "";	
     document.getElementById('codeguichet3').value = "";	
     document.getElementById('libellecompte3').value = "";	
     document.getElementById('numerocompte3').value = "";	
     document.getElementById('clerib3').value = "";	
     document.getElementById('devisecompte3').value = "";	
     document.getElementById('codeswift3').value = "";

}
function addprofin()
{
	var divaddprodfin = document.getElementById('divaddprodfin');
	divaddprodfin.style.display="block";
	document.getElementById('libelleprodfin').focus();
}


function banqueAgent2display()
{
	document.getElementById('banqueAgent2header').style.display= 'table-row';
	document.getElementById('banqueAgent2fields_0').style.display= 'table-row';
	document.getElementById('banqueAgent2fields_1').style.display= 'table-row';
	document.getElementById('banqueAgent2fields_2').style.display= 'table-row';
	document.getElementById('banqueAgent2fields_3').style.display= 'table-row';
	document.getElementById('banqueAgent2fields_4').style.display= 'table-row';
	document.getElementById('banqueAgent2fields_5').style.display= 'table-row';

}


function banqueAgent2cancel()
{
	document.getElementById('banqueAgent2header').style.display= 'none';
	document.getElementById('banqueAgent2fields_0').style.display= 'none';
	document.getElementById('banqueAgent2fields_1').style.display= 'none';
	document.getElementById('banqueAgent2fields_2').style.display= 'none';
	document.getElementById('banqueAgent2fields_3').style.display= 'none';
	document.getElementById('banqueAgent2fields_4').style.display= 'none';
	document.getElementById('banqueAgent2fields_5').style.display= 'none';

	document.getElementById('banqueAgent3header').style.display= 'none';
	document.getElementById('banqueAgent3fields_0').style.display= 'none';
	document.getElementById('banqueAgent3fields_1').style.display= 'none';
	document.getElementById('banqueAgent3fields_2').style.display= 'none';
	document.getElementById('banqueAgent3fields_3').style.display= 'none';
	document.getElementById('banqueAgent3fields_4').style.display= 'none';
	document.getElementById('banqueAgent3fields_5').style.display= 'none';	
	
	document.getElementById('banqueAgent4header').style.display= 'none';
	document.getElementById('banqueAgent4fields_0').style.display= 'none';
	document.getElementById('banqueAgent4fields_1').style.display= 'none';
	document.getElementById('banqueAgent4fields_2').style.display= 'none';
	document.getElementById('banqueAgent4fields_3').style.display= 'none';
	document.getElementById('banqueAgent4fields_4').style.display= 'none';
	document.getElementById('banqueAgent4fields_5').style.display= 'none';	
	
	document.getElementById('banqueAgent5header').style.display= 'none';
	document.getElementById('banqueAgent5fields_0').style.display= 'none';
	document.getElementById('banqueAgent5fields_1').style.display= 'none';
	document.getElementById('banqueAgent5fields_2').style.display= 'none';
	document.getElementById('banqueAgent5fields_3').style.display= 'none';
	document.getElementById('banqueAgent5fields_4').style.display= 'none';
	document.getElementById('banqueAgent5fields_5').style.display= 'none';
	
	
	document.getElementById('categoriecoordonneesbancaire2').style.display= 'none';
	document.getElementById('destinataire2').style.display= 'none';
	document.getElementById('codebanque2').style.display= 'none';
	document.getElementById('codeagence2').style.display= 'none';
	document.getElementById('numcompte2').style.display= 'none';
	document.getElementById('clerib2').style.display= 'none';
	document.getElementById('iban2').style.display= 'none';
	document.getElementById('modedepaiement2').style.display= 'none';
	document.getElementById('devise2').style.display= 'none';
	document.getElementById('repartition2').style.display= 'none';
	document.getElementById('ribfile2').style.display= 'none';
	
	document.getElementById('categoriecoordonneesbancaire3').style.display= 'none';
	document.getElementById('destinataire3').style.display= 'none';
	document.getElementById('codebanque3').style.display= 'none';
	document.getElementById('codeagence3').style.display= 'none';
	document.getElementById('numcompte3').style.display= 'none';
	document.getElementById('clerib3').style.display= 'none';
	document.getElementById('iban3').style.display= 'none';
	document.getElementById('modedepaiement3').style.display= 'none';
	document.getElementById('devise3').style.display= 'none';
	document.getElementById('repartition3').style.display= 'none';
	document.getElementById('ribfile3').style.display= 'none';
	
	document.getElementById('categoriecoordonneesbancaire4').style.display= 'none';
	document.getElementById('destinataire4').style.display= 'none';
	document.getElementById('codebanque4').style.display= 'none';
	document.getElementById('codeagence4').style.display= 'none';
	document.getElementById('numcompte4').style.display= 'none';
	document.getElementById('clerib4').style.display= 'none';
	document.getElementById('iban4').style.display= 'none';
	document.getElementById('modedepaiement4').style.display= 'none';
	document.getElementById('devise4').style.display= 'none';
	document.getElementById('repartition4').style.display= 'none';
	document.getElementById('ribfile4').style.display= 'none';
	
	document.getElementById('categoriecoordonneesbancaire5').style.display= 'none';
	document.getElementById('destinataire5').style.display= 'none';
	document.getElementById('codebanque5').style.display= 'none';
	document.getElementById('codeagence5').style.display= 'none';
	document.getElementById('numcompte5').style.display= 'none';
	document.getElementById('clerib5').style.display= 'none';
	document.getElementById('iban5').style.display= 'none';
	document.getElementById('modedepaiement5').style.display= 'none';
	document.getElementById('devise5').style.display= 'none';
	document.getElementById('repartition5').style.display= 'none';
	document.getElementById('ribfile5').style.display= 'none';
	
}


function banqueAgent3display()
{
	document.getElementById('banqueAgent3header').style.display= 'table-row';
	document.getElementById('banqueAgent3fields_0').style.display= 'table-row';
	document.getElementById('banqueAgent3fields_1').style.display= 'table-row';
	document.getElementById('banqueAgent3fields_2').style.display= 'table-row';
	document.getElementById('banqueAgent3fields_3').style.display= 'table-row';
	document.getElementById('banqueAgent3fields_4').style.display= 'table-row';
	document.getElementById('banqueAgent3fields_5').style.display= 'table-row';

}


function banqueAgent3cancel()
{

	document.getElementById('banqueAgent3header').style.display= 'none';
	document.getElementById('banqueAgent3fields_0').style.display= 'none';
	document.getElementById('banqueAgent3fields_1').style.display= 'none';
	document.getElementById('banqueAgent3fields_2').style.display= 'none';
	document.getElementById('banqueAgent3fields_3').style.display= 'none';
	document.getElementById('banqueAgent3fields_4').style.display= 'none';
	document.getElementById('banqueAgent3fields_5').style.display= 'none';	
	
	document.getElementById('banqueAgent4header').style.display= 'none';
	document.getElementById('banqueAgent4fields_0').style.display= 'none';
	document.getElementById('banqueAgent4fields_1').style.display= 'none';
	document.getElementById('banqueAgent4fields_2').style.display= 'none';
	document.getElementById('banqueAgent4fields_3').style.display= 'none';
	document.getElementById('banqueAgent4fields_4').style.display= 'none';
	document.getElementById('banqueAgent4fields_5').style.display= 'none';	
	
	document.getElementById('banqueAgent5header').style.display= 'none';
	document.getElementById('banqueAgent5fields_0').style.display= 'none';
	document.getElementById('banqueAgent5fields_1').style.display= 'none';
	document.getElementById('banqueAgent5fields_2').style.display= 'none';
	document.getElementById('banqueAgent5fields_3').style.display= 'none';
	document.getElementById('banqueAgent5fields_4').style.display= 'none';
	document.getElementById('banqueAgent5fields_5').style.display= 'none';
	
	document.getElementById('categoriecoordonneesbancaire3').style.display= 'none';
	document.getElementById('destinataire3').style.display= 'none';
	document.getElementById('codebanque3').style.display= 'none';
	document.getElementById('codeagence3').style.display= 'none';
	document.getElementById('numcompte3').style.display= 'none';
	document.getElementById('clerib3').style.display= 'none';
	document.getElementById('iban3').style.display= 'none';
	document.getElementById('modedepaiement3').style.display= 'none';
	document.getElementById('devise3').style.display= 'none';
	document.getElementById('repartition3').style.display= 'none';
	document.getElementById('ribfile3').style.display= 'none';
	
	document.getElementById('categoriecoordonneesbancaire4').style.display= 'none';
	document.getElementById('destinataire4').style.display= 'none';
	document.getElementById('codebanque4').style.display= 'none';
	document.getElementById('codeagence4').style.display= 'none';
	document.getElementById('numcompte4').style.display= 'none';
	document.getElementById('clerib4').style.display= 'none';
	document.getElementById('iban4').style.display= 'none';
	document.getElementById('modedepaiement4').style.display= 'none';
	document.getElementById('devise4').style.display= 'none';
	document.getElementById('repartition4').style.display= 'none';
	document.getElementById('ribfile4').style.display= 'none';
	
	document.getElementById('categoriecoordonneesbancaire5').style.display= 'none';
	document.getElementById('destinataire5').style.display= 'none';
	document.getElementById('codebanque5').style.display= 'none';
	document.getElementById('codeagence5').style.display= 'none';
	document.getElementById('numcompte5').style.display= 'none';
	document.getElementById('clerib5').style.display= 'none';
	document.getElementById('iban5').style.display= 'none';
	document.getElementById('modedepaiement5').style.display= 'none';
	document.getElementById('devise5').style.display= 'none';
	document.getElementById('repartition5').style.display= 'none';
	document.getElementById('ribfile5').style.display= 'none';
	
}

function banqueAgent4display()
{
	document.getElementById('banqueAgent4header').style.display= 'table-row';
	document.getElementById('banqueAgent4fields_0').style.display= 'table-row';
	document.getElementById('banqueAgent4fields_1').style.display= 'table-row';
	document.getElementById('banqueAgent4fields_2').style.display= 'table-row';
	document.getElementById('banqueAgent4fields_3').style.display= 'table-row';
	document.getElementById('banqueAgent4fields_4').style.display= 'table-row';
	document.getElementById('banqueAgent4fields_5').style.display= 'table-row';

}


function banqueAgent4cancel()
{

	
	document.getElementById('banqueAgent4header').style.display= 'none';
	document.getElementById('banqueAgent4fields_0').style.display= 'none';
	document.getElementById('banqueAgent4fields_1').style.display= 'none';
	document.getElementById('banqueAgent4fields_2').style.display= 'none';
	document.getElementById('banqueAgent4fields_3').style.display= 'none';
	document.getElementById('banqueAgent4fields_4').style.display= 'none';
	document.getElementById('banqueAgent4fields_5').style.display= 'none';	
	
	document.getElementById('banqueAgent5header').style.display= 'none';
	document.getElementById('banqueAgent5fields_0').style.display= 'none';
	document.getElementById('banqueAgent5fields_1').style.display= 'none';
	document.getElementById('banqueAgent5fields_2').style.display= 'none';
	document.getElementById('banqueAgent5fields_3').style.display= 'none';
	document.getElementById('banqueAgent5fields_4').style.display= 'none';
	document.getElementById('banqueAgent5fields_5').style.display= 'none';
	

	document.getElementById('categoriecoordonneesbancaire4').style.display= 'none';
	document.getElementById('destinataire4').style.display= 'none';
	document.getElementById('codebanque4').style.display= 'none';
	document.getElementById('codeagence4').style.display= 'none';
	document.getElementById('numcompte4').style.display= 'none';
	document.getElementById('clerib4').style.display= 'none';
	document.getElementById('iban4').style.display= 'none';
	document.getElementById('modedepaiement4').style.display= 'none';
	document.getElementById('devise4').style.display= 'none';
	document.getElementById('repartition4').style.display= 'none';
	document.getElementById('ribfile4').style.display= 'none';
	
	document.getElementById('categoriecoordonneesbancaire5').style.display= 'none';
	document.getElementById('destinataire5').style.display= 'none';
	document.getElementById('codebanque5').style.display= 'none';
	document.getElementById('codeagence5').style.display= 'none';
	document.getElementById('numcompte5').style.display= 'none';
	document.getElementById('clerib5').style.display= 'none';
	document.getElementById('iban5').style.display= 'none';
	document.getElementById('modedepaiement5').style.display= 'none';
	document.getElementById('devise5').style.display= 'none';
	document.getElementById('repartition5').style.display= 'none';
	document.getElementById('ribfile5').style.display= 'none';
	
}

function banqueAgent5display()
{
	document.getElementById('banqueAgent5header').style.display= 'table-row';
	document.getElementById('banqueAgent5fields_0').style.display= 'table-row';
	document.getElementById('banqueAgent5fields_1').style.display= 'table-row';
	document.getElementById('banqueAgent5fields_2').style.display= 'table-row';
	document.getElementById('banqueAgent5fields_3').style.display= 'table-row';
	document.getElementById('banqueAgent5fields_4').style.display= 'table-row';
	document.getElementById('banqueAgent5fields_5').style.display= 'table-row';

}


function banqueAgent5cancel()
{

	
	document.getElementById('banqueAgent5header').style.display= 'none';
	document.getElementById('banqueAgent5fields_0').style.display= 'none';
	document.getElementById('banqueAgent5fields_1').style.display= 'none';
	document.getElementById('banqueAgent5fields_2').style.display= 'none';
	document.getElementById('banqueAgent5fields_3').style.display= 'none';
	document.getElementById('banqueAgent5fields_4').style.display= 'none';
	document.getElementById('banqueAgent5fields_5').style.display= 'none';
	
	document.getElementById('categoriecoordonneesbancaire5').style.display= 'none';
	document.getElementById('destinataire5').style.display= 'none';
	document.getElementById('codebanque5').style.display= 'none';
	document.getElementById('codeagence5').style.display= 'none';
	document.getElementById('numcompte5').style.display= 'none';
	document.getElementById('clerib5').style.display= 'none';
	document.getElementById('iban5').style.display= 'none';
	document.getElementById('modedepaiement5').style.display= 'none';
	document.getElementById('devise5').style.display= 'none';
	document.getElementById('repartition5').style.display= 'none';
	document.getElementById('ribfile5').style.display= 'none';
	
}


function ConjointAgentdisplay()
{
	document.getElementById('donnesconjointheader').style.display= 'table-row';
	document.getElementById('conjointAgentfields_0').style.display= 'table-row';
	document.getElementById('conjointAgentfields_1').style.display= 'table-row';
	document.getElementById('conjointAgentfields_2').style.display= 'table-row';
	document.getElementById('conjointAgentfields_3').style.display= 'table-row';
	document.getElementById('conjointAgentfields_4').style.display= 'table-row';
	document.getElementById('conjointAgentfields_5').style.display= 'table-row';
	document.getElementById('conjointAgentfields_6').style.display= 'table-row';
	document.getElementById('conjointAgentfields_7').style.display= 'table-row';

}


function ConjointAgentcancel()
{
	document.getElementById('donnesconjointheader').style.display= 'none';
	document.getElementById('conjointAgentfields_0').style.display= 'none';
	document.getElementById('conjointAgentfields_1').style.display= 'none';
	document.getElementById('conjointAgentfields_2').style.display= 'none';
	document.getElementById('conjointAgentfields_3').style.display= 'none';
	document.getElementById('conjointAgentfields_4').style.display= 'none';
	document.getElementById('conjointAgentfields_5').style.display= 'none';
	document.getElementById('conjointAgentfields_6').style.display= 'none';
	document.getElementById('conjointAgentfields_7').style.display= 'none';

		
	document.getElementById('conjointcivilite').style.display= 'none';
	document.getElementById('conjointnom').style.display= 'none';
	document.getElementById('conjointnomjeunefille').style.display= 'none';
	document.getElementById('conjointprenoms').style.display= 'none';
	document.getElementById('conjointsexe').style.display= 'none';
	document.getElementById('conjointdatenaissance').style.display= 'none';
	document.getElementById('conjointlieunaissance ').style.display= 'none';
	document.getElementById('conjointpaysnaissance').style.display= 'none';
	document.getElementById('conjointetat').style.display= 'none';
	document.getElementById('conjointnationalite').style.display= 'none';
	document.getElementById('conjointscolouapprent').style.display= 'none';
	document.getElementById('conjointcapitaldeces').style.display= 'none';
	document.getElementById('conjointdatedeces').style.display= 'none';
	document.getElementById('conjointacharge').style.display= 'none';
	document.getElementById('conjointnumcigna').style.display= 'none';
	document.getElementById('conjointsaloucom').style.display= 'none';
		
			
}

function EnfantAgent1display()
{
	document.getElementById('donneesenfant1header').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_0').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_1').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_2').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_3').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_4').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_5').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_6').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_7').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_8').style.display= 'table-row';

}

function EnfantAgent1cancel()
{
	
	document.getElementById('donneesenfant1header').style.display= 'none';
	document.getElementById('enfantAgent1fields_0').style.display= 'none';
	document.getElementById('enfantAgent1fields_1').style.display= 'none';
	document.getElementById('enfantAgent1fields_2').style.display= 'none';
	document.getElementById('enfantAgent1fields_3').style.display= 'none';
	document.getElementById('enfantAgent1fields_4').style.display= 'none';
	document.getElementById('enfantAgent1fields_5').style.display= 'none';	
	document.getElementById('enfantAgent1fields_6').style.display= 'none';	
	document.getElementById('enfantAgent1fields_7').style.display= 'none';	
	document.getElementById('enfantAgent1fields_8').style.display= 'none';	
	
	document.getElementById('donneesenfant2header').style.display= 'none';
	document.getElementById('enfantAgent2fields_0').style.display= 'none';
	document.getElementById('enfantAgent2fields_1').style.display= 'none';
	document.getElementById('enfantAgent2fields_2').style.display= 'none';
	document.getElementById('enfantAgent2fields_3').style.display= 'none';
	document.getElementById('enfantAgent2fields_4').style.display= 'none';
	document.getElementById('enfantAgent2fields_5').style.display= 'none';	
	document.getElementById('enfantAgent2fields_6').style.display= 'none';	
	document.getElementById('enfantAgent2fields_7').style.display= 'none';	
	document.getElementById('enfantAgent2fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant3header').style.display= 'none';
	document.getElementById('enfantAgent3fields_0').style.display= 'none';
	document.getElementById('enfantAgent3fields_1').style.display= 'none';
	document.getElementById('enfantAgent3fields_2').style.display= 'none';
	document.getElementById('enfantAgent3fields_3').style.display= 'none';
	document.getElementById('enfantAgent3fields_4').style.display= 'none';
	document.getElementById('enfantAgent3fields_5').style.display= 'none';	
	document.getElementById('enfantAgent3fields_6').style.display= 'none';	
	document.getElementById('enfantAgent3fields_7').style.display= 'none';	
	document.getElementById('enfantAgent3fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant4header').style.display= 'none';
	document.getElementById('enfantAgent4fields_0').style.display= 'none';
	document.getElementById('enfantAgent4fields_1').style.display= 'none';
	document.getElementById('enfantAgent4fields_2').style.display= 'none';
	document.getElementById('enfantAgent4fields_3').style.display= 'none';
	document.getElementById('enfantAgent4fields_4').style.display= 'none';
	document.getElementById('enfantAgent4fields_5').style.display= 'none';	
	document.getElementById('enfantAgent4fields_6').style.display= 'none';	
	document.getElementById('enfantAgent4fields_7').style.display= 'none';	
	document.getElementById('enfantAgent4fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant5header').style.display= 'none';
	document.getElementById('enfantAgent5fields_0').style.display= 'none';
	document.getElementById('enfantAgent5fields_1').style.display= 'none';
	document.getElementById('enfantAgent5fields_2').style.display= 'none';
	document.getElementById('enfantAgent5fields_3').style.display= 'none';
	document.getElementById('enfantAgent5fields_4').style.display= 'none';
	document.getElementById('enfantAgent5fields_5').style.display= 'none';	
	document.getElementById('enfantAgent5fields_6').style.display= 'none';	
	document.getElementById('enfantAgent5fields_7').style.display= 'none';	
	document.getElementById('enfantAgent5fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant6header').style.display= 'none';
	document.getElementById('enfantAgent6fields_0').style.display= 'none';
	document.getElementById('enfantAgent6fields_1').style.display= 'none';
	document.getElementById('enfantAgent6fields_2').style.display= 'none';
	document.getElementById('enfantAgent6fields_3').style.display= 'none';
	document.getElementById('enfantAgent6fields_4').style.display= 'none';
	document.getElementById('enfantAgent6fields_5').style.display= 'none';	
	document.getElementById('enfantAgent6fields_6').style.display= 'none';	
	document.getElementById('enfantAgent6fields_7').style.display= 'none';	
	document.getElementById('enfantAgent6fields_8').style.display= 'none';
	
	document.getElementById('enfant1civilite').style.display= 'none';
	document.getElementById('enfant1nom').style.display= 'none';
	document.getElementById('enfant1nomjeunefille').style.display= 'none';
	document.getElementById('enfant1prenoms').style.display= 'none';
	document.getElementById('enfant1sexe').style.display= 'none';
	document.getElementById('enfant1datenaissance').style.display= 'none';
	document.getElementById('enfant1lieunaissance ').style.display= 'none';
	document.getElementById('enfant1paysnaissance').style.display= 'none';
	document.getElementById('enfant1etat').style.display= 'none';
	document.getElementById('enfant1nationalite').style.display= 'none';
	document.getElementById('enfant1scolouapprent').style.display= 'none';
	document.getElementById('enfant1capitaldeces').style.display= 'none';
	document.getElementById('enfant1datedeces').style.display= 'none';
	document.getElementById('enfant1nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant1acharge').style.display= 'none';
	document.getElementById('enfant1numcigna').style.display= 'none';
	document.getElementById('enfant1saloucom').style.display= 'none';
	
	document.getElementById('enfant2civilite').style.display= 'none';
	document.getElementById('enfant2nom').style.display= 'none';
	document.getElementById('enfant2nomjeunefille').style.display= 'none';
	document.getElementById('enfant2prenoms').style.display= 'none';
	document.getElementById('enfant2sexe').style.display= 'none';
	document.getElementById('enfant2datenaissance').style.display= 'none';
	document.getElementById('enfant2lieunaissance ').style.display= 'none';
	document.getElementById('enfant2paysnaissance').style.display= 'none';
	document.getElementById('enfant2etat').style.display= 'none';
	document.getElementById('enfant2nationalite').style.display= 'none';
	document.getElementById('enfant2scolouapprent').style.display= 'none';
	document.getElementById('enfant2capitaldeces').style.display= 'none';
	document.getElementById('enfant2datedeces').style.display= 'none';
	document.getElementById('enfant2nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant2acharge').style.display= 'none';
	document.getElementById('enfant2numcigna').style.display= 'none';
	document.getElementById('enfant2saloucom').style.display= 'none';
	
	document.getElementById('enfant3civilite').style.display= 'none';
	document.getElementById('enfant3nom').style.display= 'none';
	document.getElementById('enfant3nomjeunefille').style.display= 'none';
	document.getElementById('enfant3prenoms').style.display= 'none';
	document.getElementById('enfant3sexe').style.display= 'none';
	document.getElementById('enfant3datenaissance').style.display= 'none';
	document.getElementById('enfant3lieunaissance ').style.display= 'none';
	document.getElementById('enfant3paysnaissance').style.display= 'none';
	document.getElementById('enfant3etat').style.display= 'none';
	document.getElementById('enfant3nationalite').style.display= 'none';
	document.getElementById('enfant3scolouapprent').style.display= 'none';
	document.getElementById('enfant3capitaldeces').style.display= 'none';
	document.getElementById('enfant3datedeces').style.display= 'none';
	document.getElementById('enfant3nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant3acharge').style.display= 'none';
	document.getElementById('enfant3numcigna').style.display= 'none';
	document.getElementById('enfant3saloucom').style.display= 'none';
	
	document.getElementById('enfant4civilite').style.display= 'none';
	document.getElementById('enfant4nom').style.display= 'none';
	document.getElementById('enfant4nomjeunefille').style.display= 'none';
	document.getElementById('enfant4prenoms').style.display= 'none';
	document.getElementById('enfant4sexe').style.display= 'none';
	document.getElementById('enfant4datenaissance').style.display= 'none';
	document.getElementById('enfant4lieunaissance ').style.display= 'none';
	document.getElementById('enfant4paysnaissance').style.display= 'none';
	document.getElementById('enfant4etat').style.display= 'none';
	document.getElementById('enfant4nationalite').style.display= 'none';
	document.getElementById('enfant4scolouapprent').style.display= 'none';
	document.getElementById('enfant4capitaldeces').style.display= 'none';
	document.getElementById('enfant4datedeces').style.display= 'none';
	document.getElementById('enfant4nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant4acharge').style.display= 'none';
	document.getElementById('enfant4numcigna').style.display= 'none';
	document.getElementById('enfant4saloucom').style.display= 'none';
	
	document.getElementById('enfant5civilite').style.display= 'none';
	document.getElementById('enfant5nom').style.display= 'none';
	document.getElementById('enfant5nomjeunefille').style.display= 'none';
	document.getElementById('enfant5prenoms').style.display= 'none';
	document.getElementById('enfant5sexe').style.display= 'none';
	document.getElementById('enfant5datenaissance').style.display= 'none';
	document.getElementById('enfant5lieunaissance ').style.display= 'none';
	document.getElementById('enfant5paysnaissance').style.display= 'none';
	document.getElementById('enfant5etat').style.display= 'none';
	document.getElementById('enfant5nationalite').style.display= 'none';
	document.getElementById('enfant5scolouapprent').style.display= 'none';
	document.getElementById('enfant5capitaldeces').style.display= 'none';
	document.getElementById('enfant5datedeces').style.display= 'none';
	document.getElementById('enfant5nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant5acharge').style.display= 'none';
	document.getElementById('enfant5numcigna').style.display= 'none';
	document.getElementById('enfant5saloucom').style.display= 'none';
	
	document.getElementById('enfant6civilite').style.display= 'none';
	document.getElementById('enfant6nom').style.display= 'none';
	document.getElementById('enfant6nomjeunefille').style.display= 'none';
	document.getElementById('enfant6prenoms').style.display= 'none';
	document.getElementById('enfant6sexe').style.display= 'none';
	document.getElementById('enfant6datenaissance').style.display= 'none';
	document.getElementById('enfant6lieunaissance ').style.display= 'none';
	document.getElementById('enfant6paysnaissance').style.display= 'none';
	document.getElementById('enfant6etat').style.display= 'none';
	document.getElementById('enfant6nationalite').style.display= 'none';
	document.getElementById('enfant6scolouapprent').style.display= 'none';
	document.getElementById('enfant6capitaldeces').style.display= 'none';
	document.getElementById('enfant6datedeces').style.display= 'none';
	document.getElementById('enfant6nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant6acharge').style.display= 'none';
	document.getElementById('enfant6numcigna').style.display= 'none';
	document.getElementById('enfant6saloucom').style.display= 'none';
			
}


function EnfantAgent1display()
{
	document.getElementById('donneesenfant1header').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_0').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_1').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_2').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_3').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_4').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_5').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_6').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_7').style.display= 'table-row';
	document.getElementById('enfantAgent1fields_8').style.display= 'table-row';

}

function EnfantAgent1cancel()
{
	
	document.getElementById('donneesenfant1header').style.display= 'none';
	document.getElementById('enfantAgent1fields_0').style.display= 'none';
	document.getElementById('enfantAgent1fields_1').style.display= 'none';
	document.getElementById('enfantAgent1fields_2').style.display= 'none';
	document.getElementById('enfantAgent1fields_3').style.display= 'none';
	document.getElementById('enfantAgent1fields_4').style.display= 'none';
	document.getElementById('enfantAgent1fields_5').style.display= 'none';	
	document.getElementById('enfantAgent1fields_6').style.display= 'none';	
	document.getElementById('enfantAgent1fields_7').style.display= 'none';	
	document.getElementById('enfantAgent1fields_8').style.display= 'none';	
	
	document.getElementById('donneesenfant2header').style.display= 'none';
	document.getElementById('enfantAgent2fields_0').style.display= 'none';
	document.getElementById('enfantAgent2fields_1').style.display= 'none';
	document.getElementById('enfantAgent2fields_2').style.display= 'none';
	document.getElementById('enfantAgent2fields_3').style.display= 'none';
	document.getElementById('enfantAgent2fields_4').style.display= 'none';
	document.getElementById('enfantAgent2fields_5').style.display= 'none';	
	document.getElementById('enfantAgent2fields_6').style.display= 'none';	
	document.getElementById('enfantAgent2fields_7').style.display= 'none';	
	document.getElementById('enfantAgent2fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant3header').style.display= 'none';
	document.getElementById('enfantAgent3fields_0').style.display= 'none';
	document.getElementById('enfantAgent3fields_1').style.display= 'none';
	document.getElementById('enfantAgent3fields_2').style.display= 'none';
	document.getElementById('enfantAgent3fields_3').style.display= 'none';
	document.getElementById('enfantAgent3fields_4').style.display= 'none';
	document.getElementById('enfantAgent3fields_5').style.display= 'none';	
	document.getElementById('enfantAgent3fields_6').style.display= 'none';	
	document.getElementById('enfantAgent3fields_7').style.display= 'none';	
	document.getElementById('enfantAgent3fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant4header').style.display= 'none';
	document.getElementById('enfantAgent4fields_0').style.display= 'none';
	document.getElementById('enfantAgent4fields_1').style.display= 'none';
	document.getElementById('enfantAgent4fields_2').style.display= 'none';
	document.getElementById('enfantAgent4fields_3').style.display= 'none';
	document.getElementById('enfantAgent4fields_4').style.display= 'none';
	document.getElementById('enfantAgent4fields_5').style.display= 'none';	
	document.getElementById('enfantAgent4fields_6').style.display= 'none';	
	document.getElementById('enfantAgent4fields_7').style.display= 'none';	
	document.getElementById('enfantAgent4fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant5header').style.display= 'none';
	document.getElementById('enfantAgent5fields_0').style.display= 'none';
	document.getElementById('enfantAgent5fields_1').style.display= 'none';
	document.getElementById('enfantAgent5fields_2').style.display= 'none';
	document.getElementById('enfantAgent5fields_3').style.display= 'none';
	document.getElementById('enfantAgent5fields_4').style.display= 'none';
	document.getElementById('enfantAgent5fields_5').style.display= 'none';	
	document.getElementById('enfantAgent5fields_6').style.display= 'none';	
	document.getElementById('enfantAgent5fields_7').style.display= 'none';	
	document.getElementById('enfantAgent5fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant6header').style.display= 'none';
	document.getElementById('enfantAgent6fields_0').style.display= 'none';
	document.getElementById('enfantAgent6fields_1').style.display= 'none';
	document.getElementById('enfantAgent6fields_2').style.display= 'none';
	document.getElementById('enfantAgent6fields_3').style.display= 'none';
	document.getElementById('enfantAgent6fields_4').style.display= 'none';
	document.getElementById('enfantAgent6fields_5').style.display= 'none';	
	document.getElementById('enfantAgent6fields_6').style.display= 'none';	
	document.getElementById('enfantAgent6fields_7').style.display= 'none';	
	document.getElementById('enfantAgent6fields_8').style.display= 'none';
	
	document.getElementById('enfant1civilite').style.display= 'none';
	document.getElementById('enfant1nom').style.display= 'none';
	document.getElementById('enfant1nomjeunefille').style.display= 'none';
	document.getElementById('enfant1prenoms').style.display= 'none';
	document.getElementById('enfant1sexe').style.display= 'none';
	document.getElementById('enfant1datenaissance').style.display= 'none';
	document.getElementById('enfant1lieunaissance ').style.display= 'none';
	document.getElementById('enfant1paysnaissance').style.display= 'none';
	document.getElementById('enfant1etat').style.display= 'none';
	document.getElementById('enfant1nationalite').style.display= 'none';
	document.getElementById('enfant1scolouapprent').style.display= 'none';
	document.getElementById('enfant1capitaldeces').style.display= 'none';
	document.getElementById('enfant1datedeces').style.display= 'none';
	document.getElementById('enfant1nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant1acharge').style.display= 'none';
	document.getElementById('enfant1numcigna').style.display= 'none';
	document.getElementById('enfant1saloucom').style.display= 'none';
	
	document.getElementById('enfant2civilite').style.display= 'none';
	document.getElementById('enfant2nom').style.display= 'none';
	document.getElementById('enfant2nomjeunefille').style.display= 'none';
	document.getElementById('enfant2prenoms').style.display= 'none';
	document.getElementById('enfant2sexe').style.display= 'none';
	document.getElementById('enfant2datenaissance').style.display= 'none';
	document.getElementById('enfant2lieunaissance ').style.display= 'none';
	document.getElementById('enfant2paysnaissance').style.display= 'none';
	document.getElementById('enfant2etat').style.display= 'none';
	document.getElementById('enfant2nationalite').style.display= 'none';
	document.getElementById('enfant2scolouapprent').style.display= 'none';
	document.getElementById('enfant2capitaldeces').style.display= 'none';
	document.getElementById('enfant2datedeces').style.display= 'none';
	document.getElementById('enfant2nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant2acharge').style.display= 'none';
	document.getElementById('enfant2numcigna').style.display= 'none';
	document.getElementById('enfant2saloucom').style.display= 'none';
	
	document.getElementById('enfant3civilite').style.display= 'none';
	document.getElementById('enfant3nom').style.display= 'none';
	document.getElementById('enfant3nomjeunefille').style.display= 'none';
	document.getElementById('enfant3prenoms').style.display= 'none';
	document.getElementById('enfant3sexe').style.display= 'none';
	document.getElementById('enfant3datenaissance').style.display= 'none';
	document.getElementById('enfant3lieunaissance ').style.display= 'none';
	document.getElementById('enfant3paysnaissance').style.display= 'none';
	document.getElementById('enfant3etat').style.display= 'none';
	document.getElementById('enfant3nationalite').style.display= 'none';
	document.getElementById('enfant3scolouapprent').style.display= 'none';
	document.getElementById('enfant3capitaldeces').style.display= 'none';
	document.getElementById('enfant3datedeces').style.display= 'none';
	document.getElementById('enfant3nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant3acharge').style.display= 'none';
	document.getElementById('enfant3numcigna').style.display= 'none';
	document.getElementById('enfant3saloucom').style.display= 'none';
	
	document.getElementById('enfant4civilite').style.display= 'none';
	document.getElementById('enfant4nom').style.display= 'none';
	document.getElementById('enfant4nomjeunefille').style.display= 'none';
	document.getElementById('enfant4prenoms').style.display= 'none';
	document.getElementById('enfant4sexe').style.display= 'none';
	document.getElementById('enfant4datenaissance').style.display= 'none';
	document.getElementById('enfant4lieunaissance ').style.display= 'none';
	document.getElementById('enfant4paysnaissance').style.display= 'none';
	document.getElementById('enfant4etat').style.display= 'none';
	document.getElementById('enfant4nationalite').style.display= 'none';
	document.getElementById('enfant4scolouapprent').style.display= 'none';
	document.getElementById('enfant4capitaldeces').style.display= 'none';
	document.getElementById('enfant4datedeces').style.display= 'none';
	document.getElementById('enfant4nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant4acharge').style.display= 'none';
	document.getElementById('enfant4numcigna').style.display= 'none';
	document.getElementById('enfant4saloucom').style.display= 'none';
	
	document.getElementById('enfant5civilite').style.display= 'none';
	document.getElementById('enfant5nom').style.display= 'none';
	document.getElementById('enfant5nomjeunefille').style.display= 'none';
	document.getElementById('enfant5prenoms').style.display= 'none';
	document.getElementById('enfant5sexe').style.display= 'none';
	document.getElementById('enfant5datenaissance').style.display= 'none';
	document.getElementById('enfant5lieunaissance ').style.display= 'none';
	document.getElementById('enfant5paysnaissance').style.display= 'none';
	document.getElementById('enfant5etat').style.display= 'none';
	document.getElementById('enfant5nationalite').style.display= 'none';
	document.getElementById('enfant5scolouapprent').style.display= 'none';
	document.getElementById('enfant5capitaldeces').style.display= 'none';
	document.getElementById('enfant5datedeces').style.display= 'none';
	document.getElementById('enfant5nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant5acharge').style.display= 'none';
	document.getElementById('enfant5numcigna').style.display= 'none';
	document.getElementById('enfant5saloucom').style.display= 'none';
	
	document.getElementById('enfant6civilite').style.display= 'none';
	document.getElementById('enfant6nom').style.display= 'none';
	document.getElementById('enfant6nomjeunefille').style.display= 'none';
	document.getElementById('enfant6prenoms').style.display= 'none';
	document.getElementById('enfant6sexe').style.display= 'none';
	document.getElementById('enfant6datenaissance').style.display= 'none';
	document.getElementById('enfant6lieunaissance ').style.display= 'none';
	document.getElementById('enfant6paysnaissance').style.display= 'none';
	document.getElementById('enfant6etat').style.display= 'none';
	document.getElementById('enfant6nationalite').style.display= 'none';
	document.getElementById('enfant6scolouapprent').style.display= 'none';
	document.getElementById('enfant6capitaldeces').style.display= 'none';
	document.getElementById('enfant6datedeces').style.display= 'none';
	document.getElementById('enfant6nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant6acharge').style.display= 'none';
	document.getElementById('enfant6numcigna').style.display= 'none';
	document.getElementById('enfant6saloucom').style.display= 'none';
			
}


function EnfantAgent2display()
{
	document.getElementById('donneesenfant2header').style.display= 'table-row';
	document.getElementById('enfantAgent2fields_0').style.display= 'table-row';
	document.getElementById('enfantAgent2fields_1').style.display= 'table-row';
	document.getElementById('enfantAgent2fields_2').style.display= 'table-row';
	document.getElementById('enfantAgent2fields_3').style.display= 'table-row';
	document.getElementById('enfantAgent2fields_4').style.display= 'table-row';
	document.getElementById('enfantAgent2fields_5').style.display= 'table-row';
	document.getElementById('enfantAgent2fields_6').style.display= 'table-row';
	document.getElementById('enfantAgent2fields_7').style.display= 'table-row';
	document.getElementById('enfantAgent2fields_8').style.display= 'table-row';

}

function EnfantAgent2cancel()
{
	
	document.getElementById('donneesenfant2header').style.display= 'none';
	document.getElementById('enfantAgent2fields_0').style.display= 'none';
	document.getElementById('enfantAgent2fields_1').style.display= 'none';
	document.getElementById('enfantAgent2fields_2').style.display= 'none';
	document.getElementById('enfantAgent2fields_3').style.display= 'none';
	document.getElementById('enfantAgent2fields_4').style.display= 'none';
	document.getElementById('enfantAgent2fields_5').style.display= 'none';	
	document.getElementById('enfantAgent2fields_6').style.display= 'none';	
	document.getElementById('enfantAgent2fields_7').style.display= 'none';	
	document.getElementById('enfantAgent2fields_8').style.display= 'none';	
	
	document.getElementById('donneesenfant3header').style.display= 'none';
	document.getElementById('enfantAgent3fields_0').style.display= 'none';
	document.getElementById('enfantAgent3fields_1').style.display= 'none';
	document.getElementById('enfantAgent3fields_2').style.display= 'none';
	document.getElementById('enfantAgent3fields_3').style.display= 'none';
	document.getElementById('enfantAgent3fields_4').style.display= 'none';
	document.getElementById('enfantAgent3fields_5').style.display= 'none';	
	document.getElementById('enfantAgent3fields_6').style.display= 'none';	
	document.getElementById('enfantAgent3fields_7').style.display= 'none';	
	document.getElementById('enfantAgent3fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant4header').style.display= 'none';
	document.getElementById('enfantAgent4fields_0').style.display= 'none';
	document.getElementById('enfantAgent4fields_1').style.display= 'none';
	document.getElementById('enfantAgent4fields_2').style.display= 'none';
	document.getElementById('enfantAgent4fields_3').style.display= 'none';
	document.getElementById('enfantAgent4fields_4').style.display= 'none';
	document.getElementById('enfantAgent4fields_5').style.display= 'none';	
	document.getElementById('enfantAgent4fields_6').style.display= 'none';	
	document.getElementById('enfantAgent4fields_7').style.display= 'none';	
	document.getElementById('enfantAgent4fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant5header').style.display= 'none';
	document.getElementById('enfantAgent5fields_0').style.display= 'none';
	document.getElementById('enfantAgent5fields_1').style.display= 'none';
	document.getElementById('enfantAgent5fields_2').style.display= 'none';
	document.getElementById('enfantAgent5fields_3').style.display= 'none';
	document.getElementById('enfantAgent5fields_4').style.display= 'none';
	document.getElementById('enfantAgent5fields_5').style.display= 'none';	
	document.getElementById('enfantAgent5fields_6').style.display= 'none';	
	document.getElementById('enfantAgent5fields_7').style.display= 'none';	
	document.getElementById('enfantAgent5fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant6header').style.display= 'none';
	document.getElementById('enfantAgent6fields_0').style.display= 'none';
	document.getElementById('enfantAgent6fields_1').style.display= 'none';
	document.getElementById('enfantAgent6fields_2').style.display= 'none';
	document.getElementById('enfantAgent6fields_3').style.display= 'none';
	document.getElementById('enfantAgent6fields_4').style.display= 'none';
	document.getElementById('enfantAgent6fields_5').style.display= 'none';	
	document.getElementById('enfantAgent6fields_6').style.display= 'none';	
	document.getElementById('enfantAgent6fields_7').style.display= 'none';	
	document.getElementById('enfantAgent6fields_8').style.display= 'none';
	
	document.getElementById('enfant2civilite').style.display= 'none';
	document.getElementById('enfant2nom').style.display= 'none';
	document.getElementById('enfant2nomjeunefille').style.display= 'none';
	document.getElementById('enfant2prenoms').style.display= 'none';
	document.getElementById('enfant2sexe').style.display= 'none';
	document.getElementById('enfant2datenaissance').style.display= 'none';
	document.getElementById('enfant2lieunaissance ').style.display= 'none';
	document.getElementById('enfant2paysnaissance').style.display= 'none';
	document.getElementById('enfant2etat').style.display= 'none';
	document.getElementById('enfant2nationalite').style.display= 'none';
	document.getElementById('enfant2scolouapprent').style.display= 'none';
	document.getElementById('enfant2capitaldeces').style.display= 'none';
	document.getElementById('enfant2datedeces').style.display= 'none';
	document.getElementById('enfant2nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant2acharge').style.display= 'none';
	document.getElementById('enfant2numcigna').style.display= 'none';
	document.getElementById('enfant2saloucom').style.display= 'none';
	
	document.getElementById('enfant3civilite').style.display= 'none';
	document.getElementById('enfant3nom').style.display= 'none';
	document.getElementById('enfant3nomjeunefille').style.display= 'none';
	document.getElementById('enfant3prenoms').style.display= 'none';
	document.getElementById('enfant3sexe').style.display= 'none';
	document.getElementById('enfant3datenaissance').style.display= 'none';
	document.getElementById('enfant3lieunaissance ').style.display= 'none';
	document.getElementById('enfant3paysnaissance').style.display= 'none';
	document.getElementById('enfant3etat').style.display= 'none';
	document.getElementById('enfant3nationalite').style.display= 'none';
	document.getElementById('enfant3scolouapprent').style.display= 'none';
	document.getElementById('enfant3capitaldeces').style.display= 'none';
	document.getElementById('enfant3datedeces').style.display= 'none';
	document.getElementById('enfant3nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant3acharge').style.display= 'none';
	document.getElementById('enfant3numcigna').style.display= 'none';
	document.getElementById('enfant3saloucom').style.display= 'none';
	
	document.getElementById('enfant4civilite').style.display= 'none';
	document.getElementById('enfant4nom').style.display= 'none';
	document.getElementById('enfant4nomjeunefille').style.display= 'none';
	document.getElementById('enfant4prenoms').style.display= 'none';
	document.getElementById('enfant4sexe').style.display= 'none';
	document.getElementById('enfant4datenaissance').style.display= 'none';
	document.getElementById('enfant4lieunaissance ').style.display= 'none';
	document.getElementById('enfant4paysnaissance').style.display= 'none';
	document.getElementById('enfant4etat').style.display= 'none';
	document.getElementById('enfant4nationalite').style.display= 'none';
	document.getElementById('enfant4scolouapprent').style.display= 'none';
	document.getElementById('enfant4capitaldeces').style.display= 'none';
	document.getElementById('enfant4datedeces').style.display= 'none';
	document.getElementById('enfant4nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant4acharge').style.display= 'none';
	document.getElementById('enfant4numcigna').style.display= 'none';
	document.getElementById('enfant4saloucom').style.display= 'none';
	
	document.getElementById('enfant5civilite').style.display= 'none';
	document.getElementById('enfant5nom').style.display= 'none';
	document.getElementById('enfant5nomjeunefille').style.display= 'none';
	document.getElementById('enfant5prenoms').style.display= 'none';
	document.getElementById('enfant5sexe').style.display= 'none';
	document.getElementById('enfant5datenaissance').style.display= 'none';
	document.getElementById('enfant5lieunaissance ').style.display= 'none';
	document.getElementById('enfant5paysnaissance').style.display= 'none';
	document.getElementById('enfant5etat').style.display= 'none';
	document.getElementById('enfant5nationalite').style.display= 'none';
	document.getElementById('enfant5scolouapprent').style.display= 'none';
	document.getElementById('enfant5capitaldeces').style.display= 'none';
	document.getElementById('enfant5datedeces').style.display= 'none';
	document.getElementById('enfant5nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant5acharge').style.display= 'none';
	document.getElementById('enfant5numcigna').style.display= 'none';
	document.getElementById('enfant5saloucom').style.display= 'none';
	
	document.getElementById('enfant6civilite').style.display= 'none';
	document.getElementById('enfant6nom').style.display= 'none';
	document.getElementById('enfant6nomjeunefille').style.display= 'none';
	document.getElementById('enfant6prenoms').style.display= 'none';
	document.getElementById('enfant6sexe').style.display= 'none';
	document.getElementById('enfant6datenaissance').style.display= 'none';
	document.getElementById('enfant6lieunaissance ').style.display= 'none';
	document.getElementById('enfant6paysnaissance').style.display= 'none';
	document.getElementById('enfant6etat').style.display= 'none';
	document.getElementById('enfant6nationalite').style.display= 'none';
	document.getElementById('enfant6scolouapprent').style.display= 'none';
	document.getElementById('enfant6capitaldeces').style.display= 'none';
	document.getElementById('enfant6datedeces').style.display= 'none';
	document.getElementById('enfant6nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant6acharge').style.display= 'none';
	document.getElementById('enfant6numcigna').style.display= 'none';
	document.getElementById('enfant6saloucom').style.display= 'none';
			
}


function EnfantAgent3display()
{
	document.getElementById('donneesenfant3header').style.display= 'table-row';
	document.getElementById('enfantAgent3fields_0').style.display= 'table-row';
	document.getElementById('enfantAgent3fields_1').style.display= 'table-row';
	document.getElementById('enfantAgent3fields_2').style.display= 'table-row';
	document.getElementById('enfantAgent3fields_3').style.display= 'table-row';
	document.getElementById('enfantAgent3fields_4').style.display= 'table-row';
	document.getElementById('enfantAgent3fields_5').style.display= 'table-row';
	document.getElementById('enfantAgent3fields_6').style.display= 'table-row';
	document.getElementById('enfantAgent3fields_7').style.display= 'table-row';
	document.getElementById('enfantAgent3fields_8').style.display= 'table-row';

}

function EnfantAgent3cancel()
{
	
	document.getElementById('donneesenfant3header').style.display= 'none';
	document.getElementById('enfantAgent3fields_0').style.display= 'none';
	document.getElementById('enfantAgent3fields_1').style.display= 'none';
	document.getElementById('enfantAgent3fields_2').style.display= 'none';
	document.getElementById('enfantAgent3fields_3').style.display= 'none';
	document.getElementById('enfantAgent3fields_4').style.display= 'none';
	document.getElementById('enfantAgent3fields_5').style.display= 'none';	
	document.getElementById('enfantAgent3fields_6').style.display= 'none';	
	document.getElementById('enfantAgent3fields_7').style.display= 'none';	
	document.getElementById('enfantAgent3fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant4header').style.display= 'none';
	document.getElementById('enfantAgent4fields_0').style.display= 'none';
	document.getElementById('enfantAgent4fields_1').style.display= 'none';
	document.getElementById('enfantAgent4fields_2').style.display= 'none';
	document.getElementById('enfantAgent4fields_3').style.display= 'none';
	document.getElementById('enfantAgent4fields_4').style.display= 'none';
	document.getElementById('enfantAgent4fields_5').style.display= 'none';	
	document.getElementById('enfantAgent4fields_6').style.display= 'none';	
	document.getElementById('enfantAgent4fields_7').style.display= 'none';	
	document.getElementById('enfantAgent4fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant5header').style.display= 'none';
	document.getElementById('enfantAgent5fields_0').style.display= 'none';
	document.getElementById('enfantAgent5fields_1').style.display= 'none';
	document.getElementById('enfantAgent5fields_2').style.display= 'none';
	document.getElementById('enfantAgent5fields_3').style.display= 'none';
	document.getElementById('enfantAgent5fields_4').style.display= 'none';
	document.getElementById('enfantAgent5fields_5').style.display= 'none';	
	document.getElementById('enfantAgent5fields_6').style.display= 'none';	
	document.getElementById('enfantAgent5fields_7').style.display= 'none';	
	document.getElementById('enfantAgent5fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant6header').style.display= 'none';
	document.getElementById('enfantAgent6fields_0').style.display= 'none';
	document.getElementById('enfantAgent6fields_1').style.display= 'none';
	document.getElementById('enfantAgent6fields_2').style.display= 'none';
	document.getElementById('enfantAgent6fields_3').style.display= 'none';
	document.getElementById('enfantAgent6fields_4').style.display= 'none';
	document.getElementById('enfantAgent6fields_5').style.display= 'none';	
	document.getElementById('enfantAgent6fields_6').style.display= 'none';	
	document.getElementById('enfantAgent6fields_7').style.display= 'none';	
	document.getElementById('enfantAgent6fields_8').style.display= 'none';
	
	document.getElementById('enfant3civilite').style.display= 'none';
	document.getElementById('enfant3nom').style.display= 'none';
	document.getElementById('enfant3nomjeunefille').style.display= 'none';
	document.getElementById('enfant3prenoms').style.display= 'none';
	document.getElementById('enfant3sexe').style.display= 'none';
	document.getElementById('enfant3datenaissance').style.display= 'none';
	document.getElementById('enfant3lieunaissance ').style.display= 'none';
	document.getElementById('enfant3paysnaissance').style.display= 'none';
	document.getElementById('enfant3etat').style.display= 'none';
	document.getElementById('enfant3nationalite').style.display= 'none';
	document.getElementById('enfant3scolouapprent').style.display= 'none';
	document.getElementById('enfant3capitaldeces').style.display= 'none';
	document.getElementById('enfant3datedeces').style.display= 'none';
	document.getElementById('enfant3nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant3acharge').style.display= 'none';
	document.getElementById('enfant3numcigna').style.display= 'none';
	document.getElementById('enfant3saloucom').style.display= 'none';
	
	document.getElementById('enfant4civilite').style.display= 'none';
	document.getElementById('enfant4nom').style.display= 'none';
	document.getElementById('enfant4nomjeunefille').style.display= 'none';
	document.getElementById('enfant4prenoms').style.display= 'none';
	document.getElementById('enfant4sexe').style.display= 'none';
	document.getElementById('enfant4datenaissance').style.display= 'none';
	document.getElementById('enfant4lieunaissance ').style.display= 'none';
	document.getElementById('enfant4paysnaissance').style.display= 'none';
	document.getElementById('enfant4etat').style.display= 'none';
	document.getElementById('enfant4nationalite').style.display= 'none';
	document.getElementById('enfant4scolouapprent').style.display= 'none';
	document.getElementById('enfant4capitaldeces').style.display= 'none';
	document.getElementById('enfant4datedeces').style.display= 'none';
	document.getElementById('enfant4nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant4acharge').style.display= 'none';
	document.getElementById('enfant4numcigna').style.display= 'none';
	document.getElementById('enfant4saloucom').style.display= 'none';
	
	document.getElementById('enfant5civilite').style.display= 'none';
	document.getElementById('enfant5nom').style.display= 'none';
	document.getElementById('enfant5nomjeunefille').style.display= 'none';
	document.getElementById('enfant5prenoms').style.display= 'none';
	document.getElementById('enfant5sexe').style.display= 'none';
	document.getElementById('enfant5datenaissance').style.display= 'none';
	document.getElementById('enfant5lieunaissance ').style.display= 'none';
	document.getElementById('enfant5paysnaissance').style.display= 'none';
	document.getElementById('enfant5etat').style.display= 'none';
	document.getElementById('enfant5nationalite').style.display= 'none';
	document.getElementById('enfant5scolouapprent').style.display= 'none';
	document.getElementById('enfant5capitaldeces').style.display= 'none';
	document.getElementById('enfant5datedeces').style.display= 'none';
	document.getElementById('enfant5nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant5acharge').style.display= 'none';
	document.getElementById('enfant5numcigna').style.display= 'none';
	document.getElementById('enfant5saloucom').style.display= 'none';
	
	document.getElementById('enfant6civilite').style.display= 'none';
	document.getElementById('enfant6nom').style.display= 'none';
	document.getElementById('enfant6nomjeunefille').style.display= 'none';
	document.getElementById('enfant6prenoms').style.display= 'none';
	document.getElementById('enfant6sexe').style.display= 'none';
	document.getElementById('enfant6datenaissance').style.display= 'none';
	document.getElementById('enfant6lieunaissance ').style.display= 'none';
	document.getElementById('enfant6paysnaissance').style.display= 'none';
	document.getElementById('enfant6etat').style.display= 'none';
	document.getElementById('enfant6nationalite').style.display= 'none';
	document.getElementById('enfant6scolouapprent').style.display= 'none';
	document.getElementById('enfant6capitaldeces').style.display= 'none';
	document.getElementById('enfant6datedeces').style.display= 'none';
	document.getElementById('enfant6nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant6acharge').style.display= 'none';
	document.getElementById('enfant6numcigna').style.display= 'none';
	document.getElementById('enfant6saloucom').style.display= 'none';
			
}


function EnfantAgent4display()
{
	document.getElementById('donneesenfant4header').style.display= 'table-row';
	document.getElementById('enfantAgent4fields_0').style.display= 'table-row';
	document.getElementById('enfantAgent4fields_1').style.display= 'table-row';
	document.getElementById('enfantAgent4fields_2').style.display= 'table-row';
	document.getElementById('enfantAgent4fields_3').style.display= 'table-row';
	document.getElementById('enfantAgent4fields_4').style.display= 'table-row';
	document.getElementById('enfantAgent4fields_5').style.display= 'table-row';
	document.getElementById('enfantAgent4fields_6').style.display= 'table-row';
	document.getElementById('enfantAgent4fields_7').style.display= 'table-row';
	document.getElementById('enfantAgent4fields_8').style.display= 'table-row';

}

function EnfantAgent4cancel()
{
	
	document.getElementById('donneesenfant4header').style.display= 'none';
	document.getElementById('enfantAgent4fields_0').style.display= 'none';
	document.getElementById('enfantAgent4fields_1').style.display= 'none';
	document.getElementById('enfantAgent4fields_2').style.display= 'none';
	document.getElementById('enfantAgent4fields_3').style.display= 'none';
	document.getElementById('enfantAgent4fields_4').style.display= 'none';
	document.getElementById('enfantAgent4fields_5').style.display= 'none';	
	document.getElementById('enfantAgent4fields_6').style.display= 'none';	
	document.getElementById('enfantAgent4fields_7').style.display= 'none';	
	document.getElementById('enfantAgent4fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant5header').style.display= 'none';
	document.getElementById('enfantAgent5fields_0').style.display= 'none';
	document.getElementById('enfantAgent5fields_1').style.display= 'none';
	document.getElementById('enfantAgent5fields_2').style.display= 'none';
	document.getElementById('enfantAgent5fields_3').style.display= 'none';
	document.getElementById('enfantAgent5fields_4').style.display= 'none';
	document.getElementById('enfantAgent5fields_5').style.display= 'none';	
	document.getElementById('enfantAgent5fields_6').style.display= 'none';	
	document.getElementById('enfantAgent5fields_7').style.display= 'none';	
	document.getElementById('enfantAgent5fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant6header').style.display= 'none';
	document.getElementById('enfantAgent6fields_0').style.display= 'none';
	document.getElementById('enfantAgent6fields_1').style.display= 'none';
	document.getElementById('enfantAgent6fields_2').style.display= 'none';
	document.getElementById('enfantAgent6fields_3').style.display= 'none';
	document.getElementById('enfantAgent6fields_4').style.display= 'none';
	document.getElementById('enfantAgent6fields_5').style.display= 'none';	
	document.getElementById('enfantAgent6fields_6').style.display= 'none';	
	document.getElementById('enfantAgent6fields_7').style.display= 'none';	
	document.getElementById('enfantAgent6fields_8').style.display= 'none';
	
		
	document.getElementById('enfant4civilite').style.display= 'none';
	document.getElementById('enfant4nom').style.display= 'none';
	document.getElementById('enfant4nomjeunefille').style.display= 'none';
	document.getElementById('enfant4prenoms').style.display= 'none';
	document.getElementById('enfant4sexe').style.display= 'none';
	document.getElementById('enfant4datenaissance').style.display= 'none';
	document.getElementById('enfant4lieunaissance ').style.display= 'none';
	document.getElementById('enfant4paysnaissance').style.display= 'none';
	document.getElementById('enfant4etat').style.display= 'none';
	document.getElementById('enfant4nationalite').style.display= 'none';
	document.getElementById('enfant4scolouapprent').style.display= 'none';
	document.getElementById('enfant4capitaldeces').style.display= 'none';
	document.getElementById('enfant4datedeces').style.display= 'none';
	document.getElementById('enfant4nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant4acharge').style.display= 'none';
	document.getElementById('enfant4numcigna').style.display= 'none';
	document.getElementById('enfant4saloucom').style.display= 'none';
	
	document.getElementById('enfant5civilite').style.display= 'none';
	document.getElementById('enfant5nom').style.display= 'none';
	document.getElementById('enfant5nomjeunefille').style.display= 'none';
	document.getElementById('enfant5prenoms').style.display= 'none';
	document.getElementById('enfant5sexe').style.display= 'none';
	document.getElementById('enfant5datenaissance').style.display= 'none';
	document.getElementById('enfant5lieunaissance ').style.display= 'none';
	document.getElementById('enfant5paysnaissance').style.display= 'none';
	document.getElementById('enfant5etat').style.display= 'none';
	document.getElementById('enfant5nationalite').style.display= 'none';
	document.getElementById('enfant5scolouapprent').style.display= 'none';
	document.getElementById('enfant5capitaldeces').style.display= 'none';
	document.getElementById('enfant5datedeces').style.display= 'none';
	document.getElementById('enfant5nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant5acharge').style.display= 'none';
	document.getElementById('enfant5numcigna').style.display= 'none';
	document.getElementById('enfant5saloucom').style.display= 'none';
	
	document.getElementById('enfant6civilite').style.display= 'none';
	document.getElementById('enfant6nom').style.display= 'none';
	document.getElementById('enfant6nomjeunefille').style.display= 'none';
	document.getElementById('enfant6prenoms').style.display= 'none';
	document.getElementById('enfant6sexe').style.display= 'none';
	document.getElementById('enfant6datenaissance').style.display= 'none';
	document.getElementById('enfant6lieunaissance ').style.display= 'none';
	document.getElementById('enfant6paysnaissance').style.display= 'none';
	document.getElementById('enfant6etat').style.display= 'none';
	document.getElementById('enfant6nationalite').style.display= 'none';
	document.getElementById('enfant6scolouapprent').style.display= 'none';
	document.getElementById('enfant6capitaldeces').style.display= 'none';
	document.getElementById('enfant6datedeces').style.display= 'none';
	document.getElementById('enfant6nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant6acharge').style.display= 'none';
	document.getElementById('enfant6numcigna').style.display= 'none';
	document.getElementById('enfant6saloucom').style.display= 'none';
			
}


function EnfantAgent5display()
{
	document.getElementById('donneesenfant5header').style.display= 'table-row';
	document.getElementById('enfantAgent5fields_0').style.display= 'table-row';
	document.getElementById('enfantAgent5fields_1').style.display= 'table-row';
	document.getElementById('enfantAgent5fields_2').style.display= 'table-row';
	document.getElementById('enfantAgent5fields_3').style.display= 'table-row';
	document.getElementById('enfantAgent5fields_4').style.display= 'table-row';
	document.getElementById('enfantAgent5fields_5').style.display= 'table-row';
	document.getElementById('enfantAgent5fields_6').style.display= 'table-row';
	document.getElementById('enfantAgent5fields_7').style.display= 'table-row';
	document.getElementById('enfantAgent5fields_8').style.display= 'table-row';

}

function EnfantAgent5cancel()
{
	
	document.getElementById('donneesenfant5header').style.display= 'none';
	document.getElementById('enfantAgent5fields_0').style.display= 'none';
	document.getElementById('enfantAgent5fields_1').style.display= 'none';
	document.getElementById('enfantAgent5fields_2').style.display= 'none';
	document.getElementById('enfantAgent5fields_3').style.display= 'none';
	document.getElementById('enfantAgent5fields_4').style.display= 'none';
	document.getElementById('enfantAgent5fields_5').style.display= 'none';	
	document.getElementById('enfantAgent5fields_6').style.display= 'none';	
	document.getElementById('enfantAgent5fields_7').style.display= 'none';	
	document.getElementById('enfantAgent5fields_8').style.display= 'none';
	
	document.getElementById('donneesenfant6header').style.display= 'none';
	document.getElementById('enfantAgent6fields_0').style.display= 'none';
	document.getElementById('enfantAgent6fields_1').style.display= 'none';
	document.getElementById('enfantAgent6fields_2').style.display= 'none';
	document.getElementById('enfantAgent6fields_3').style.display= 'none';
	document.getElementById('enfantAgent6fields_4').style.display= 'none';
	document.getElementById('enfantAgent6fields_5').style.display= 'none';	
	document.getElementById('enfantAgent6fields_6').style.display= 'none';	
	document.getElementById('enfantAgent6fields_7').style.display= 'none';	
	document.getElementById('enfantAgent6fields_8').style.display= 'none';
	
	document.getElementById('enfant5civilite').style.display= 'none';
	document.getElementById('enfant5nom').style.display= 'none';
	document.getElementById('enfant5nomjeunefille').style.display= 'none';
	document.getElementById('enfant5prenoms').style.display= 'none';
	document.getElementById('enfant5sexe').style.display= 'none';
	document.getElementById('enfant5datenaissance').style.display= 'none';
	document.getElementById('enfant5lieunaissance ').style.display= 'none';
	document.getElementById('enfant5paysnaissance').style.display= 'none';
	document.getElementById('enfant5etat').style.display= 'none';
	document.getElementById('enfant5nationalite').style.display= 'none';
	document.getElementById('enfant5scolouapprent').style.display= 'none';
	document.getElementById('enfant5capitaldeces').style.display= 'none';
	document.getElementById('enfant5datedeces').style.display= 'none';
	document.getElementById('enfant5nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant5acharge').style.display= 'none';
	document.getElementById('enfant5numcigna').style.display= 'none';
	document.getElementById('enfant5saloucom').style.display= 'none';
	
	document.getElementById('enfant6civilite').style.display= 'none';
	document.getElementById('enfant6nom').style.display= 'none';
	document.getElementById('enfant6nomjeunefille').style.display= 'none';
	document.getElementById('enfant6prenoms').style.display= 'none';
	document.getElementById('enfant6sexe').style.display= 'none';
	document.getElementById('enfant6datenaissance').style.display= 'none';
	document.getElementById('enfant6lieunaissance ').style.display= 'none';
	document.getElementById('enfant6paysnaissance').style.display= 'none';
	document.getElementById('enfant6etat').style.display= 'none';
	document.getElementById('enfant6nationalite').style.display= 'none';
	document.getElementById('enfant6scolouapprent').style.display= 'none';
	document.getElementById('enfant6capitaldeces').style.display= 'none';
	document.getElementById('enfant6datedeces').style.display= 'none';
	document.getElementById('enfant6nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant6acharge').style.display= 'none';
	document.getElementById('enfant6numcigna').style.display= 'none';
	document.getElementById('enfant6saloucom').style.display= 'none';
			
}

function EnfantAgent6display()
{
	document.getElementById('donneesenfant6header').style.display= 'table-row';
	document.getElementById('enfantAgent6fields_0').style.display= 'table-row';
	document.getElementById('enfantAgent6fields_1').style.display= 'table-row';
	document.getElementById('enfantAgent6fields_2').style.display= 'table-row';
	document.getElementById('enfantAgent6fields_3').style.display= 'table-row';
	document.getElementById('enfantAgent6fields_4').style.display= 'table-row';
	document.getElementById('enfantAgent6fields_5').style.display= 'table-row';
	document.getElementById('enfantAgent6fields_6').style.display= 'table-row';
	document.getElementById('enfantAgent6fields_7').style.display= 'table-row';
	document.getElementById('enfantAgent6fields_8').style.display= 'table-row';

}

function EnfantAgent6cancel()
{
	
	document.getElementById('donneesenfant6header').style.display= 'none';
	document.getElementById('enfantAgent6fields_0').style.display= 'none';
	document.getElementById('enfantAgent6fields_1').style.display= 'none';
	document.getElementById('enfantAgent6fields_2').style.display= 'none';
	document.getElementById('enfantAgent6fields_3').style.display= 'none';
	document.getElementById('enfantAgent6fields_4').style.display= 'none';
	document.getElementById('enfantAgent6fields_5').style.display= 'none';	
	document.getElementById('enfantAgent6fields_6').style.display= 'none';	
	document.getElementById('enfantAgent6fields_7').style.display= 'none';	
	document.getElementById('enfantAgent6fields_8').style.display= 'none';
	
		
	document.getElementById('enfant6civilite').style.display= 'none';
	document.getElementById('enfant6nom').style.display= 'none';
	document.getElementById('enfant6nomjeunefille').style.display= 'none';
	document.getElementById('enfant6prenoms').style.display= 'none';
	document.getElementById('enfant6sexe').style.display= 'none';
	document.getElementById('enfant6datenaissance').style.display= 'none';
	document.getElementById('enfant6lieunaissance ').style.display= 'none';
	document.getElementById('enfant6paysnaissance').style.display= 'none';
	document.getElementById('enfant6etat').style.display= 'none';
	document.getElementById('enfant6nationalite').style.display= 'none';
	document.getElementById('enfant6scolouapprent').style.display= 'none';
	document.getElementById('enfant6capitaldeces').style.display= 'none';
	document.getElementById('enfant6datedeces').style.display= 'none';
	document.getElementById('enfant6nometprenomsmereenfant').style.display= 'none';
	document.getElementById('enfant6acharge').style.display= 'none';
	document.getElementById('enfant6numcigna').style.display= 'none';
	document.getElementById('enfant6saloucom').style.display= 'none';
			
}


/*************************** MODULE DEMANDE INFORMATIQUE 08-09-2016 ************************************************/


function demande2display()
{
	document.getElementById('demande2header').style.display= 'table-row';
	document.getElementById('demande2fields_0').style.display= 'table-row';
	document.getElementById('demande2fields_1').style.display= 'table-row';
	document.getElementById('demande2fields_2').style.display= 'table-row';
	document.getElementById('demande2fields_3').style.display= 'table-row';


}

function demande2cancel()
{
	
	document.getElementById('typedemande2').value="";
	document.getElementById('quantite2').value="";
	document.getElementById('justifdemande2').value="";
	document.getElementById('desc2').value="";

	document.getElementById('demande2header').style.display= 'table-row';
	document.getElementById('demande2fields_0').style.display= 'table-row';
	document.getElementById('demande2fields_1').style.display= 'table-row';
	document.getElementById('demande2fields_2').style.display= 'table-row';
	document.getElementById('demande2fields_3').style.display= 'table-row';
	
	demande3cancel();
	demande4cancel();
	demande5cancel();
}


function demande3display()
{
	document.getElementById('demande3header').style.display= 'table-row';
	document.getElementById('demande3fields_0').style.display= 'table-row';
	document.getElementById('demande3fields_1').style.display= 'table-row';
	document.getElementById('demande3fields_2').style.display= 'table-row';
	document.getElementById('demande3fields_3').style.display= 'table-row';

}

function demande3cancel()
{
	
	document.getElementById('typedemande3').value="";
	document.getElementById('quantite3').value="";
	document.getElementById('justifdemande3').value="";
	document.getElementById('desc3').value="";
	
	document.getElementById('demande3header').style.display= 'none';
	document.getElementById('demande3fields_0').style.display= 'none';
	document.getElementById('demande3fields_1').style.display= 'none';
	document.getElementById('demande3fields_2').style.display= 'none';
	document.getElementById('demande3fields_3').style.display= 'none';

	demande4cancel();
}


function demande4display()
{
	document.getElementById('demande4header').style.display= 'table-row';
	document.getElementById('demande4fields_0').style.display= 'table-row';
	document.getElementById('demande4fields_1').style.display= 'table-row';
	document.getElementById('demande4fields_2').style.display= 'table-row';
	document.getElementById('demande4fields_3').style.display= 'table-row';


}

function demande4cancel()
{
	
	document.getElementById('typedemande4').value="";
	document.getElementById('quantite4').value="";
	document.getElementById('justifdemande4').value="";
	document.getElementById('desc4').value="";
	
	document.getElementById('demande4header').style.display= 'none';
	document.getElementById('demande4fields_0').style.display= 'none';
	document.getElementById('demande4fields_1').style.display= 'none';
	document.getElementById('demande4fields_2').style.display= 'none';
	document.getElementById('demande4fields_3').style.display= 'none';

	
	demande5cancel();
				
}


function demande5display()
{
	document.getElementById('demande5header').style.display= 'table-row';
	document.getElementById('demande5fields_0').style.display= 'table-row';
	document.getElementById('demande5fields_1').style.display= 'table-row';
	document.getElementById('demande5fields_2').style.display= 'table-row';
	document.getElementById('demande5fields_3').style.display= 'table-row';
}

function demande5cancel()
{
	
	document.getElementById('typedemande5').value="";
	document.getElementById('quantite5').value="";
	document.getElementById('justifdemande5').value="";
	document.getElementById('desc5').value="";
	
	document.getElementById('demande5header').style.display= 'none';
	document.getElementById('demande5fields_0').style.display= 'none';
	document.getElementById('demande5fields_1').style.display= 'none';
	document.getElementById('demande5fields_2').style.display= 'none';
	document.getElementById('demande5fields_3').style.display= 'none';

}

/*************************** MODULE CANDIDAT BOURSE ONLINE 07-02-2017 ************************************************/


function etab2display()
{
	document.getElementById('etab2header').style.display= 'table-row';
	document.getElementById('etab2fields_0').style.display= 'table-row';
	document.getElementById('etab2fields_1').style.display= 'table-row';
	document.getElementById('etab2fields_2').style.display= 'table-row';
	document.getElementById('etab2fields_3').style.display= 'table-row';
	document.getElementById('etab2fields_4').style.display= 'table-row';
	document.getElementById('etab2fields_5').style.display= 'table-row';
	document.getElementById('etab2fields_6').style.display= 'table-row';
	document.getElementById('etab2fields_7').style.display= 'table-row';
	document.getElementById('etab2fields_8').style.display= 'table-row';
	//alert("display etab2");


}

function etab2cancel()
{
	
	/*document.getElementById('etab2ville').value="";
	document.getElementById('etab2pays').value="";
	document.getElementById('justifdemande2').value="";
	document.getElementById('desc2').value="";*/

	document.getElementById('etab2header').style.display= 'none';
	document.getElementById('etab2fields_0').style.display= 'none';
	document.getElementById('etab2fields_1').style.display= 'none';
	document.getElementById('etab2fields_2').style.display= 'none';
	document.getElementById('etab2fields_3').style.display= 'none';
	document.getElementById('etab2fields_4').style.display= 'none';
	document.getElementById('etab2fields_5').style.display= 'none';
	document.getElementById('etab2fields_6').style.display= 'none';
	document.getElementById('etab2fields_7').style.display= 'none';
	document.getElementById('etab2fields_8').style.display= 'none';
	
	etab3cancel();
}


function etab3display()
{
	document.getElementById('etab3header').style.display= 'table-row';
	document.getElementById('etab3fields_0').style.display= 'table-row';
	document.getElementById('etab3fields_1').style.display= 'table-row';
	document.getElementById('etab3fields_2').style.display= 'table-row';
	document.getElementById('etab3fields_3').style.display= 'table-row';
	document.getElementById('etab3fields_4').style.display= 'table-row';
	document.getElementById('etab3fields_5').style.display= 'table-row';
	document.getElementById('etab3fields_6').style.display= 'table-row';
	document.getElementById('etab3fields_7').style.display= 'table-row';
	document.getElementById('etab3fields_8').style.display= 'table-row';

}

function etab3cancel()
{
	
	/*document.getElementById('typedemande3').value="";
	document.getElementById('quantite3').value="";
	document.getElementById('justifdemande3').value="";
	document.getElementById('desc3').value="";*/
	
	document.getElementById('etab3header').style.display= 'none';
	document.getElementById('etab3fields_0').style.display= 'none';
	document.getElementById('etab3fields_1').style.display= 'none';
	document.getElementById('etab3fields_2').style.display= 'none';
	document.getElementById('etab3fields_3').style.display= 'none';
	document.getElementById('etab3fields_4').style.display= 'none';
	document.getElementById('etab3fields_5').style.display= 'none';
	document.getElementById('etab3fields_6').style.display= 'none';
	document.getElementById('etab3fields_7').style.display= 'none';
	document.getElementById('etab3fields_8').style.display= 'none';

}

/* ******************************************************** NOMADE ********************************************* */
function lignebudget2display()
{
	//getBudgetsByAgentDepart2();
	
	document.getElementById('lignebudget2header').style.display= 'table-row';
	document.getElementById('lignebudget2fields_0').style.display= 'table-row';
	document.getElementById('lignebudget2fields_1').style.display= 'table-row';
	document.getElementById('lignebudget2fields_2').style.display= 'table-row';
	document.getElementById('lignebudget2fields_3').style.display= 'table-row';
	
	
}


function lignebudget2cancel()
{

	
	document.getElementById('lignebudget2header').style.display= 'none';
	document.getElementById('lignebudget2fields_0').style.display= 'none';
	document.getElementById('lignebudget2fields_1').style.display= 'none';
	document.getElementById('lignebudget2fields_2').style.display= 'none';
	document.getElementById('lignebudget2fields_3').style.display= 'none';
	
}

function lignebudget3display()
{
	//getBudgetsByAgentDepart3();
	
	document.getElementById('lignebudget3header').style.display= 'table-row';
	document.getElementById('lignebudget3fields_0').style.display= 'table-row';
	document.getElementById('lignebudget3fields_1').style.display= 'table-row';
	document.getElementById('lignebudget3fields_2').style.display= 'table-row';
	document.getElementById('lignebudget3fields_3').style.display= 'table-row';
	
	
}


function lignebudget3cancel()
{

	
	document.getElementById('lignebudget3header').style.display= 'none';
	document.getElementById('lignebudget3fields_0').style.display= 'none';
	document.getElementById('lignebudget3fields_1').style.display= 'none';
	document.getElementById('lignebudget3fields_2').style.display= 'none';
	document.getElementById('lignebudget3fields_3').style.display= 'none';
	
}


function lignebudget4display()
{
	//getBudgetsByAgentDepart4();
	
	document.getElementById('lignebudget4header').style.display= 'table-row';
	document.getElementById('lignebudget4fields_0').style.display= 'table-row';
	document.getElementById('lignebudget4fields_1').style.display= 'table-row';
	document.getElementById('lignebudget4fields_2').style.display= 'table-row';
	document.getElementById('lignebudget4fields_3').style.display= 'table-row';
	
	
}


function lignebudget4cancel()
{

	
	document.getElementById('lignebudget4header').style.display= 'none';
	document.getElementById('lignebudget4fields_0').style.display= 'none';
	document.getElementById('lignebudget4fields_1').style.display= 'none';
	document.getElementById('lignebudget4fields_2').style.display= 'none';
	document.getElementById('lignebudget4fields_3').style.display= 'none';
	
}


function lignebudget5display()
{
	//getBudgetsByAgentDepart5();
	
	document.getElementById('lignebudget5header').style.display= 'table-row';
	document.getElementById('lignebudget5fields_0').style.display= 'table-row';
	document.getElementById('lignebudget5fields_1').style.display= 'table-row';
	document.getElementById('lignebudget5fields_2').style.display= 'table-row';
	document.getElementById('lignebudget5fields_3').style.display= 'table-row';

	
}


function lignebudget5cancel()
{

	
	document.getElementById('lignebudget5header').style.display= 'none';
	document.getElementById('lignebudget5fields_0').style.display= 'none';
	document.getElementById('lignebudget5fields_1').style.display= 'none';
	document.getElementById('lignebudget5fields_2').style.display= 'none';
	document.getElementById('lignebudget5fields_3').style.display= 'none';
	
}


function justif2display()
{
	document.getElementById('justif2header').style.display= 'table-row';
	document.getElementById('justif2fields_0').style.display= 'table-row';
	document.getElementById('justif2fields_1').style.display= 'table-row';

}


function justif2cancel()
{

	
	document.getElementById('justif2header').style.display= 'none';
	document.getElementById('justif2fields_0').style.display= 'none';
	document.getElementById('justif2fields_1').style.display= 'none';

	
}

function soumettreDemande(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_SOUMISSION_DEMANDE;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function soumettreDemandeDCPC(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_SOUMISSION_DEMANDE_DCPC;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function soumettreDemandeCJ(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_SOUMISSION_DEMANDE_CJ;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function soumettreDemandeDC(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_SOUMISSIONDC_DEMANDE;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function soumettreDemandeHorsDelai(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_SOUMISSION_HORSDELAI_DEMANDE;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function soumettreDemandeHorsBudget(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_SOUMISSION_HORSBUDGET_DEMANDE;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function remettreDemande(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_REMETTREENPREPA_DEMANDE;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function AnnulerDemande(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_ANNULER_DEMANDE;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}

function CreerEngagement(module) {
	var msg;
	if (module == 'OrdresMission')
		msg = alert_arr.CONFIRMER_CREATION_ENGAGEMENT;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}

function AnnulerMission(module) {
	var msg;
	if (module == 'OrdresMission')
		msg = alert_arr.CONFIRMER_ANNULER_MISSION;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function RejeterDemande(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_REJETER_DEMANDE;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function AnnulerMission(module) {
	var msg;
	if (module == 'OrdresMission')
		msg = alert_arr.CONFIRMER_ANNULER_MISSION;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function ViserDemande(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_ACCEPTER_DEMANDE;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function MettreOMgenereDemande(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_REMETTREOMGENERE_DEMANDE;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function RemettreasigneDemande(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_REMETTREASIGNE_DEMANDE;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function PourCorrectionDemande(module) {
	var msg;
	if (module == 'Demandes')
		msg = alert_arr.CONFIRMER_TOBECORRECTED_DEMANDE;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}

function modifierDecompte(iddemande) {
	var msg;
	//alert("Modification de la decompte="+iddemande);
	//document.getElementById('divdecompteview').style.display= 'none';
	document.getElementById('divdecompteedit').style.display= 'block';

}

function AnnulermodifierDecompte(iddemande) {
	var msg;
	//alert("Modification de la decompte="+iddemande);
	document.getElementById('divdecompteedit').style.display= 'none';

}
function saveModifDecompte(module) {
	var msg;
	//alert("Modification de la decompte="+iddemande);
	//document.getElementById('divdecompteview').style.display= 'none';
	//document.getElementById('divdecompteedit').style.display= 'block';
	var msg;
	if (module == 'OrdresMission')
		msg = alert_arr.CONFIRMER_SAVEMODIFDECOMPTE_DEMANDE;
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}

function trajet1display()
{
	document.getElementById('trajet1header').style.display= 'table-row';
	document.getElementById('trajet1fields_0').style.display= 'table-row';
	document.getElementById('trajet1fields_1').style.display= 'table-row';
	document.getElementById('trajet1fields_2').style.display= 'table-row';
	document.getElementById('trajet1fields_3').style.display= 'table-row';

}


function trajet1cancel()
{

	
	document.getElementById('trajet1header').style.display= 'none';
	document.getElementById('trajet1fields_0').style.display= 'none';
	document.getElementById('trajet1fields_1').style.display= 'none';
	document.getElementById('trajet1fields_2').style.display= 'none';
	document.getElementById('trajet1fields_3').style.display= 'none';
	
}

function trajet2display()
{
	document.getElementById('trajet2header').style.display= 'table-row';
	document.getElementById('trajet2fields_0').style.display= 'table-row';
	document.getElementById('trajet2fields_1').style.display= 'table-row';


}


function trajet2cancel()
{

	document.getElementById('trajet2date').value= '';
	document.getElementById('trajet2depart').value= '';
	document.getElementById('trajet2arrivee').value= '';

	document.getElementById('trajet2header').style.display= 'none';
	document.getElementById('trajet2fields_0').style.display= 'none';
	document.getElementById('trajet2fields_1').style.display= 'none';
	
}

function trajet3display()
{
	document.getElementById('trajet3header').style.display= 'table-row';
	document.getElementById('trajet3fields_0').style.display= 'table-row';
	document.getElementById('trajet3fields_1').style.display= 'table-row';

}


function trajet3cancel()
{

	document.getElementById('trajet3date').value= '';
	document.getElementById('trajet3depart').value= '';
	document.getElementById('trajet3arrivee').value= '';
	
	document.getElementById('trajet3header').style.display= 'none';
	document.getElementById('trajet3fields_0').style.display= 'none';
	document.getElementById('trajet3fields_1').style.display= 'none';
	document.getElementById('trajet3fields_2').style.display= 'none';
	document.getElementById('trajet3fields_3').style.display= 'none';
	
}


function trajet4display()
{
	document.getElementById('trajet4header').style.display= 'table-row';
	document.getElementById('trajet4fields_0').style.display= 'table-row';
	document.getElementById('trajet4fields_1').style.display= 'table-row';

}


function trajet4cancel()
{

	document.getElementById('trajet4date').value= '';
	document.getElementById('trajet4depart').value= '';
	document.getElementById('trajet4arrivee').value= '';
	
	document.getElementById('trajet4header').style.display= 'none';
	document.getElementById('trajet4fields_0').style.display= 'none';
	document.getElementById('trajet4fields_1').style.display= 'none';

}

function trajet5display()
{
	document.getElementById('trajet5header').style.display= 'table-row';
	document.getElementById('trajet5fields_0').style.display= 'table-row';
	document.getElementById('trajet5fields_1').style.display= 'table-row';

}


function trajet5cancel()
{

	document.getElementById('trajet5date').value= '';
	document.getElementById('trajet5depart').value= '';
	document.getElementById('trajet5arrivee').value= '';
	
	document.getElementById('trajet5header').style.display= 'none';
	document.getElementById('trajet5fields_0').style.display= 'none';
	document.getElementById('trajet5fields_1').style.display= 'none';
	
}

function trajet6display()
{
	document.getElementById('trajet6header').style.display= 'table-row';
	document.getElementById('trajet6fields_0').style.display= 'table-row';
	document.getElementById('trajet6fields_1').style.display= 'table-row';

}


function trajet6cancel()
{

	document.getElementById('trajet6date').value= '';
	document.getElementById('trajet6depart').value= '';
	document.getElementById('trajet6arrivee').value= '';
	
	document.getElementById('trajet6header').style.display= 'none';
	document.getElementById('trajet6fields_0').style.display= 'none';
	document.getElementById('trajet6fields_1').style.display= 'none';
	
}

function trajet7display()
{
	document.getElementById('trajet7header').style.display= 'table-row';
	document.getElementById('trajet7fields_0').style.display= 'table-row';
	document.getElementById('trajet7fields_1').style.display= 'table-row';

}


function trajet7cancel()
{

	document.getElementById('trajet7date').value= '';
	document.getElementById('trajet7depart').value= '';
	document.getElementById('trajet7arrivee').value= '';
	
	document.getElementById('trajet7header').style.display= 'none';
	document.getElementById('trajet7fields_0').style.display= 'none';
	document.getElementById('trajet7fields_1').style.display= 'none';

}

function trajet8display()
{
	document.getElementById('trajet8header').style.display= 'table-row';
	document.getElementById('trajet8fields_0').style.display= 'table-row';
	document.getElementById('trajet8fields_1').style.display= 'table-row';

}


function trajet8cancel()
{

	document.getElementById('trajet8date').value= '';
	document.getElementById('trajet8depart').value= '';
	document.getElementById('trajet8arrivee').value= '';
	
	document.getElementById('trajet8header').style.display= 'none';
	document.getElementById('trajet8fields_0').style.display= 'none';
	document.getElementById('trajet8fields_1').style.display= 'none';
	
}
/* *************************************** FIN NOMADE ********************************************************************** */

function traiterDemande()
{
	document.getElementById('statutdem').style.display= 'block';
	document.getElementById('statutdem2').style.display= 'block';
	document.getElementById('statutdem3').style.display= 'block';
	document.getElementById('statutdem4').style.display= 'block';
	document.getElementById('statutdem5').style.display= 'block';
	document.getElementById('savetraitbut').style.display= 'block';
}
function verifSaveTraitement()
{
	var statutdemande = document.getElementById('statutdemande').value;
	var statutdemande2 = document.getElementById('statutdemande2').value;
	var statutdemande3 = document.getElementById('statutdemande3').value;
	var statutdemande4 = document.getElementById('statutdemande4').value;
	var statutdemande5 = document.getElementById('statutdemande5').value;
	var demandeid = document.getElementById('demandeid').value;
	var demandeticket = document.getElementById('demandeticket').value;
	
	if (statutdemande==0 && statutdemande2==0 && statutdemande3==0 && statutdemande4==0 && statutdemande5==0)
	{
		alert("Aucun article s\351lectionn\351!!! Veiller saisir choisir les articles \340 livrer");
		return false;
	}
		if (statutdemande==1)
		{
			var descarticle1 = document.getElementById('descarticle1').value;
			var numserie1 = document.getElementById('numserie1').value;
			var comment1 = document.getElementById('comment1').value;
			if(descarticle1=="")
			{
				alert("Veiller saisir la description du 1er article livr\351 !!!!");
				document.getElementById('descarticle1').focus();

				return false;
			}
			if(numserie1=="")
			{
				alert("Veiller saisir le num\351ro de s\351rie du 1er article livr\351 !!!!");
				document.getElementById('numserie1').focus();
				return false;
			}
			
		}
		if (statutdemande2==1)
		{
			var descarticle2 = document.getElementById('descarticle2').value;
			var numserie2 = document.getElementById('numserie2').value;
			var comment2 = document.getElementById('comment2').value;
			if(descarticle2=="")
			{
				alert("Veiller saisir la description du 2eme article livr\351 !!!!");
				document.getElementById('descarticle2').focus();

				return false;
			}
			if(numserie2=="")
			{
				alert("Veiller saisir le num\351ro de s\351rie du 2eme article livr\351 !!!!");
				document.getElementById('numserie2').focus();
				return false;
			}
		}	
		if (statutdemande3==1)
		{
			var descarticle3 = document.getElementById('descarticle3').value;
			var numserie3 = document.getElementById('numserie3').value;
			var comment3 = document.getElementById('comment3').value;
			if(descarticle3=="")
			{
				alert("Veiller saisir la description du 3eme article livr\351 !!!!");
				document.getElementById('descarticle3').focus();

				return false;
			}
			if(numserie3=="")
			{
				alert("Veiller saisir le num\351ro de s\351rie du 3eme article livr\351 !!!!");
				document.getElementById('numserie3').focus();
				return false;
			}
			
		}
		if (statutdemande4==1)
		{
			var descarticle4 = document.getElementById('descarticle4').value;
			var numserie4 = document.getElementById('numserie4').value;
			var comment4 = document.getElementById('comment4').value;
			if(descarticle4=="")
			{
				alert("Veiller saisir la description du 4eme article livr\351 !!!!");
				document.getElementById('descarticle4').focus();

				return false;
			}
			if(numserie4=="")
			{
				alert("Veiller saisir le num\351ro de s\351rie du 4eme article livr\351 !!!!");
				document.getElementById('numserie4').focus();
				return false;
			}
			
		}
		if (statutdemande5==1)
		{
			var descarticle5 = document.getElementById('descarticle5').value;
			var numserie5 = document.getElementById('numserie5').value;
			var comment5 = document.getElementById('comment5').value;
			if(descarticle5=="")
			{
				alert("Veiller saisir la description du 5eme article livr\351 !!!!");
				document.getElementById('descarticle5').focus();

				return false;
			}
			if(numserie5=="")
			{
				alert("Veiller saisir le num\351ro de s\351rie du 5eme article livr\351 !!!!");
				document.getElementById('numserie5').focus();
				return false;
			}
			
		}
		
	return true;
}
function showformtraintement1()
{
	if (document.getElementById('statutdemande').value==1)
	{
		document.getElementById('headtraitement1').style.display= 'table-row';
		document.getElementById('info1traitement1').style.display= 'table-row';
		document.getElementById('info2traitement1').style.display= 'table-row';
		document.getElementById('descarticle1').focus();

	}
	else
		{
		document.getElementById('headtraitement1').style.display= 'none';
		document.getElementById('info1traitement1').style.display= 'none';
		document.getElementById('info2traitement1').style.display= 'none';

	}
}
function showformtraintement2()
{
	if (document.getElementById('statutdemande2').value==1)
	{
		document.getElementById('headtraitement2').style.display= 'table-row';
		document.getElementById('info1traitement2').style.display= 'table-row';
		document.getElementById('info2traitement2').style.display= 'table-row';
		document.getElementById('descarticle2').focus();

	}
	else
		{
		document.getElementById('headtraitement2').style.display= 'none';
		document.getElementById('info1traitement2').style.display= 'none';
		document.getElementById('info2traitement2').style.display= 'none';

	}
}
function showformtraintement3()
{
	if (document.getElementById('statutdemande3').value==1)
	{
		document.getElementById('headtraitement3').style.display= 'table-row';
		document.getElementById('info1traitement3').style.display= 'table-row';
		document.getElementById('info2traitement3').style.display= 'table-row';
		document.getElementById('descarticle3').focus();

	}
	else
		{
		document.getElementById('headtraitement3').style.display= 'none';
		document.getElementById('info1traitement3').style.display= 'none';
		document.getElementById('info2traitement3').style.display= 'none';

	}
}
function showformtraintement4()
{
	if (document.getElementById('statutdemande4').value==1)
	{
		document.getElementById('headtraitement4').style.display= 'table-row';
		document.getElementById('info1traitement4').style.display= 'table-row';
		document.getElementById('info2traitement4').style.display= 'table-row';
		document.getElementById('descarticle4').focus();

	}
	else
		{
		document.getElementById('headtraitement4').style.display= 'none';
		document.getElementById('info1traitement4').style.display= 'none';
		document.getElementById('info2traitement4').style.display= 'none';

	}
}
function showformtraintement5()
{
	if (document.getElementById('statutdemande5').value==1)
	{
		document.getElementById('headtraitement5').style.display= 'table-row';
		document.getElementById('info1traitement5').style.display= 'table-row';
		document.getElementById('info2traitement5').style.display= 'table-row';
		document.getElementById('descarticle5').focus();

	}
	else
		{
		document.getElementById('headtraitement5').style.display= 'none';
		document.getElementById('info1traitement5').style.display= 'none';
		document.getElementById('info2traitement5').style.display= 'none';

	}
}




/* ------------------------------------------------------------------
A set of simple functions to demonstrate AjaxServerResponseHander
------------------------------------------------------------------- */

function submitForm(formName) {
	var dataString=new FormData(document.forms.namedItem(formName));
	AjaxServerResponseHander.postForm(dataString, 'ajax.php');
}


function sendPostData(){
	var dataString='target=popUp';
	AjaxServerResponseHander.postData(dataString, 'ajax.php');
}


function clearContent(id) {
	var cont = document.getElementById(id);  
	if(cont.childNodes.length){
		cont.removeChild(cont.childNodes[0]);
	}
}


function cleanHTML(id) {
	var element=document.getElementById(id);
	if(element!=null){
		element.innerHTML='';
	}
}


/*
 values for pos argument in function appendHTML():

 <!-- beforebegin -->
 <p>
 <!-- afterbegin -->
 foo
 <!-- beforeend -->
 </p>
 <!-- afterend -->

 @param id - id of the html element where we want to append html code
 @param pos - position where we want to append html code (see above for the values)
 @param html - html code
*/
function appendHTML(id, pos, html) {
	document.getElementById(id).insertAdjacentHTML(pos, html);
}


function showHide(id, show, display) {
	var ht=document.getElementById(id);
	if(show==1){
		ht.style.display=display;
	}
	else{
		ht.style.display='none';
	}
	return
}

function setStyle(id, attribute, style) {
	document.getElementById(id).style[attribute]=style;
}


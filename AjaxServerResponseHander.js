/*********************************************************************
* AjaxServerResponseHander                                           *
*                                                                    *
* Version: 1.0                                                       *
* Date:    17-08-2020                                                *
* Author:  Dan Machado                                               *
*                                                                    *
**********************************************************************/

var AjaxServerResponseHander=(function(){
	var objectEvent={
		handlers:{},
		addEventHandler:function(evt,ck){
			this.handlers[evt]=this.handlers[evt] || [];
			this.handlers[evt].push(ck);
		},
		fire:function(evt){
			var a=false;
			for(var i in this.handlers[evt]){
				this.handlers[evt][i].apply(null, Array.prototype.slice.call(arguments, 1));
				a=true;
			}
			return a;
		},
	};

	var module=Object.create(objectEvent);

	(function(){
		var debuggerFunction=function(strData){};
		module.debug=function(strData){
			debuggerFunction(strData);
		};

		function resolveResponse(jsonStr) {
			var result=0, element=null;
			var jsonResp=JSON.parse(jsonStr);
	
			if(typeof jsonResp.textResponse!=='undefined') {
				for(var id in jsonResp.textResponse) {
					element=document.getElementById(id);
					if(jsonResp.textResponse.hasOwnProperty(id) && element!=null) {
						element.innerHTML=jsonResp.textResponse[id];
					}
					else{
						module.debug('Document does not have any element with ID: ' +id);
					}
				}
			}

			if(typeof jsonResp.Functions!=='undefined') {
				for(var functionName in jsonResp.Functions) {
					if(jsonResp.Functions.hasOwnProperty(functionName)) {
						var fnction=window;
						var parts=functionName.split('.');
						for(var i=0; i<parts.length; i++){
							fnction=fnction[parts[i]];
						}
						
						if(typeof fnction==='function') {
							for(var i=0; i<jsonResp.Functions[functionName].length; i++) {
								fnction.apply(null, jsonResp.Functions[functionName][i]);
							}
						}
						else{
							module.debug(functionName +' is undefined');
						}
					}
				}
			}
		};

		var xmlHttp=(function(){
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...
				return function(){
					return new XMLHttpRequest();
				}
			}else if (window.ActiveXObject) { // IE
				try {
					new ActiveXObject('Msxml2.XMLHTTP');
					return function(){
						return new ActiveXObject('Msxml2.XMLHTTP');
					}
				}
				catch(err){
					try {
						new ActiveXObject('Microsoft.XMLHTTP');
						return function(){
							return new ActiveXObject('Microsoft.XMLHTTP');
						}
					}
					catch(err) {
						try {
							new ActiveXObject("MSXML2.XMLHTTP.3.0");
							return function(){
								return new ActiveXObject("MSXML2.XMLHTTP.3.0");
							}
						}
						catch(err) {
							module.debug('Bad ajax object!!');
						}
					}
				}
			}
		})();

		function postRequest(dataString, url, cntTypeHeader){
			var xhttp=xmlHttp();
			xhttp.onreadystatechange = function(){
				if(xhttp.readyState == 4){
					if(xhttp.status == 200) {
						resolveResponse(xhttp.responseText);
						//module.fire('success200');
					} 
					else{
						if(!module.fire('statusCode:'+xhttp.status)){
							module.debug('Server responded with status code: '+xhttp.status);
						}
					}
				}
			};

			try{
				xhttp.open("POST", url, true);
				if(cntTypeHeader==='Content-type'){
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				}
				xhttp.send(dataString);
			}
			catch(err){
				module.debug(err);
			}
		};
	
		module.submitForm=function(formName, url){
			postRequest(new FormData(document.forms.namedItem(formName)), url, 'no-header');
		};

		module.postData=function(dataString, url){
			postRequest(dataString, url, 'Content-type');
		};
		
		module.setDebugger=function(callback){
			if(typeof callback==='function'){
				debuggerFunction=callback;
			}
			else{
				debuggerFunction=function(strData){};
			}
		};

		module.addServerFailHandler=function(statusCode, callback){
			module.addEventHandler(statusCode, callback);
		};
		/*
		module.onSuccess=function(callback){
			module.addEventHandler('success200', callback);
		};*/

	})();

	return module;
})();

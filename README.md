# Ajax Server Response Hander

It has two components (one frontend and one backend) to make ajax requests and handle
server responses.

# Background

Many developers rely on jquery to make ajax calls to the server. And soon they
find themselves writing code like
```
$("button").click(function(){
  $.ajax({url: "demo_test.php", success: function(result){
    $("#div1").html(result);
  }});
});
```
then later another ajax call is made to the same script but the response should be handled
by another callback function
```
$("button").click(function(){
  $.ajax({url: "demo_test.php", success: function(result){
    //do something more crazy...
  }});
});
```
one ends defining one for each possible callback function! And then nothing is reusable.

Ajax Server Response Hander proposes a different approach: let the server tell the client
what to do with the response and let the client resolve the response. After all, it is
the server who knows the result of a request before the client does.

This solution is achieved as follows:
   - frontend: reusable functions and modules to manipulate the elements of the website,
   - backend: integrate in the response the names of javascript functions to be called by the browser to resolve the response.

# Documentation AjaxResponse

**AjaxResponse::functionCall(string $func, array $params)**

*Description:*

   add function and its parameters to the response.

*Parameters:*

func

   the name of a javascript function that needs to be called by the client.

params

   array for the parameters for the function func.
   
**AjaxResponse::innerHTML(string $id, string $data)**

*Description:*

   add an client document element id and its content to the response.
   
*Parameters:*

id

   id of an document element of the website

data

   the content that needs to be set inside of the element with id id. 


**AjaxResponse::pushBuffer()**

*Description*

   flushes response of the server as a json string.

**AjaxResponse::init()**

*Description*

   send the output buffer to the browser at the end of the request.
   
# Documentation AjaxServerResponseHander

**AjaxServerResponseHander.submitForm(string formName, string url)**

*Description*

   submit a html form (via ajax call) via a POST request asynchronously.

*Parameters:*

formName

   the value of the name attribute for the form to be submitted.
   
url

   the url to send the post request.

**AjaxServerResponseHander.postData(string dataString, string url)**

*Description*

   post arbitrary string of attributes and values via a POST request asynchronously.

*Parameters:*

dataString

   string of the form: "attr_1=val_1&attr_2=val_2...", some values need to be url encoded with encodeURIComponent.
   
url

   url to send the post request.
	
**AjaxServerResponseHander.setDebugger(function callback)**

*Description*

   set a callback function to inspect error of failures of the request/response.

*Parameters:*

callback

   a function that accepts a parameter which value can be:
     - the flushed buffer from the server (not the actual response) will be printed using console.log.
     - error failure of the ajax request
     - string

**AjaxServerResponseHander.addServerFailHandler(string statusResponse, callback)**

*Description*

   set callback functions to be executed when the server responds with a status code other than
   200.

*Parameters:*

statusResponse

   a string of the form 'statusCode:codeNumber', for example: 'statusCode:400', 'statusCode:500'.

callback

   a function to be called when the server responds with a particular status code other than 200.

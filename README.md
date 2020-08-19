# Ajax Server Response Hander

It is a two components (one frontend and one backend) to make ajax request and handle
server response.

# Background

Many developers rely on jquery to make ajax calls to the server. And soon they
find themselve writing code like
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
what to do with the response and let the client resolves the response. After all, it is
the server who knows the result of a request before the client does.

This solution is achieved as follows:
   - frontend: reusable functions and modules to manipulate the elements of the website,
   - backend: integrate in the response the javascript functions to be used to interprete the response

# Documentation AjaxResponse

**AjaxResponse::functionCall(string $func, array $params)**

*Description:*

   Add function and its parameters to the response.

*Parameters:*

func

   the name of a javascript function that needs to be called by the client.

params

   array for the parameters for the function func.
   
**AjaxResponse::innerHTML(string $id, string $data)**

*Description:*

   Add and client element id and its content to the response.
   
*Parameters:*

id

   id of an document element in the website

data

   the content that need to be set inside of the element with id id. 


**AjaxResponse::pushBuffer()**

*Description*

   flushes response of the server as a json string.

**AjaxResponse::init()**

*Description*

   initialize the response and set and function to be called if the script fails.
   
# Documentation AjaxServerResponseHander

**AjaxServerResponseHander.postForm(dataString, url)**

*Description*


**AjaxServerResponseHander.postData(dataString, url)**
		
**AjaxServerResponseHander.setDebug(_quiet)**

**AjaxServerResponseHander.addHandler(statusResponse, callback)**


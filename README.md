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

# How to use it

**Frontend**

example.html

    <html>
    <head>
       <!-- here is where the magic happens -->
       <script type="text/javascript" src="AjaxServerResponseHander.min.js"></script>

       <!-- include your javascript functions, modules -->
       <script type="text/javascript" src="javascript_libraries.js"></script>
       <script type="text/javascript" src="more_javascript_libraries.js"></script>
       
       <!-- more stuff -->

       <script>
          // set debugger on if needed
          AjaxServerResponseHander.setDebugger(function(data){
	         console.log(data);
          });

          // add as many callback functions needed to handle different server status code
          // other than 200

          AjaxServerResponseHander.addServerFailHandler('statusCode:500', function(){
	         alert('Please try again latter.');
          });

          AjaxServerResponseHander.addServerFailHandler('statusCode:404', function(){
             alert('Page not found.');
          });

       </script>
       </head>	
       <body>

         <!-- html stuff here -->

        <script>
          // maybe more javascript stuff here
        </script>
        </body>
        </html>

**Backend**

The target for the ajax call should look like:

    <?php
    include 'ajax_response_class.php';
    AjaxResponse::init(true);

    var_dump($_POST);

    echo "this too\n";

     // some actions are executed here as a part of the login procedure
    // when they are done we set the response

    AjaxResponse::functionCall('fomeFunction', array('param1', param2));
    AjaxResponse::innerHTML('some_ID', 'Hello!');

    // remember anything that is not set via AjaxResponse will be push to the browser and capture
    // by AjaxServerResponseHander::debug method if a callback is set
    echo 'in authentication part';

    // we do some calculations
    $x=123 * 123;
    AjaxResponse::innerHTML('result_content', $x);
    AjaxResponse::functionCall('anotherFunction', array());// no parameters

    // but if you still want to inspect for debugging purposes 
    $y=123*123+456+6756/123;
    echo 'calculations OK!';

    // We send the response... this just need to be called ONCE!
    // and at the end.
    AjaxResponse::pushBuffer();

    ?>



# Documentation AjaxResponse

   With this class the server send the response as a JSON string (therefore the header 'Content-Type: application/json' is sent):
```
{
   'textResponse':{id_1:val_1, id_2:val_2,....}, 
	'Functions':{'functionName1':{{parameters1}}, 'functionName2':{{parameters2}},...}
}
```
Every attribute in Functions is the name of a javascript defined function in the client side. 

**AjaxResponse::init(boolean $debug)**

*Description:*

   turns output buffering on so any the output is stored in an internal buffer.
   
*Parameters:*

debug
   
   if it is true, the contents of the internal buffer is set as value for the
   attribute AjaxServerResponseHander.debug of the response so AjaxServerResponseHander can
   use it for debugging if it has set a callback function (see [AjaxServerResponseHander](#documentation-ajaxServerResponseHander)).

**AjaxResponse::functionCall(string $func, array $params)**

*Description:*

   add function and its parameters to the response.

*Parameters:*

func

   the name of a javascript function that needs to be called by the client. The same function
   can be added multiple times as it is needed.

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

# Donations?

If you are using this for the company you work for, they are getting the money, you are 
getting the medals and I am getting nothing! Is that fair?

It does cost NOTHING to push the star button at the top.










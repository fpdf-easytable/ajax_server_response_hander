# Ajax Server Response Hander

It is a two components (one frontend and backend) to make ajax request and handle
server response.

# Background

Many developers they rely on jquery for make ajax request to the server. And soon you
find in writing code like
```
$("button").click(function(){
  $.ajax({url: "demo_test.txt", success: function(result){
    $("#div1").html(result);
  }});
});
```
all over the place, one for each possible callback function! And then nothing is reusable code.


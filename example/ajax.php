<?php

/* ------------------------------------------------------------------
A set of simple functions to demonstrate AjaxServerResponseHander
------------------------------------------------------------------- */

include 'ajax_response_class.php';

/*
The following will be pushed to the browser and captured by 
AjaxServerResponseHander::debug method if a callback is set
*/

var_dump($_POST);



if(isset($_POST['target'])){
	if($_POST['target']=='authentication'){
		if($_POST['user_name'] && $_POST['pswd']){
			// do some actions are executed here as a part of the login procedure
			// when they are done we set the response
			AjaxResponse::functionCall('cleanHTML', array('authentication_fail'));
			AjaxResponse::functionCall('showHide', array('loginForm', 0));
			AjaxResponse::functionCall('showHide', array('authentication_response', 1, 'block'));
			AjaxResponse::innerHTML('authentication_response', 'Login successful!');
			$html='<br/>User name: '.$_POST['user_name'].'<br/>Password: '.$_POST['pswd'];
			AjaxResponse::functionCall('appendHTML', array('authentication_response', 'beforeend', $html));

			// anything that is not set via AjaxResponse will be push to the browser and capture
			// by AjaxServerResponseHander::debug method if a callback is set (see example.html source code)
			echo 'in authentication part';
		}
		else{
			AjaxResponse::innerHTML('authentication_fail', 'User Name or Password do not match!');
			AjaxResponse::functionCall('showHide', array('authentication_fail', 1, 'block'));
		}
	}
	elseif($_POST['target']=='popUp'){
		// we do some calculations
		$x=123 * 123;
		AjaxResponse::innerHTML('popup_title', 'Server response');
		AjaxResponse::innerHTML('popup_content', 'Greetings!');
		AjaxResponse::innerHTML('no_ID', 'No element with this id!!');
		AjaxResponse::functionCall('appendHTML', array('popup_content', 'beforeend', '<br/>123x123= '. $x));
		AjaxResponse::functionCall('setStyle', array('popup_content', 'width', '200px'));
		AjaxResponse::functionCall('popUpAPI.display', array());
	}
	elseif($_POST['target']=='doTax'){
		// if there is not action to be reported to the browser
		// then no method of AjaxResponse is called.
		$x=123+345+567+45;
	}
	else{
		// but if you still want to inspect for debugging purposes 
		$y=123*123+456+6756/123;
		echo 'calculations OK!';
	}
}


//###################################################################
// We send the response... this just need to be called ONCE!
// and at the end.

AjaxResponse::pushBuffer();


?>
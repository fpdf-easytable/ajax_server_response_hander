<?php

/* ------------------------------------------------------------------
A set of simple functions to demonstrate AjaxServerResponseHander
------------------------------------------------------------------- */

include 'ajax_response_class.php';

var_dump($_POST);

if(isset($_POST['target'])){
	if($_POST['target']=='authentication'){
		if($_POST['user_name'] && $_POST['pswd']){
			AjaxResponse::functionCall('cleanHTML', array('authentication_fail'));
			AjaxResponse::functionCall('showHide', array('loginForm', 0));
			AjaxResponse::functionCall('showHide', array('authentication_response', 1, 'block'));
			AjaxResponse::innerHTML('authentication_response', 'Login successful!');
			AjaxResponse::functionCall('appendHTML', array('authentication_response', 'beforeend', 
			'<br/>User name: '.$_POST['user_name'].'<br/>Password: '.$_POST['pswd']));
		}
		else{
			AjaxResponse::innerHTML('authentication_fail', 'User Name or Password do not match!');
			AjaxResponse::functionCall('showHide', array('authentication_fail', 1, 'block'));
		}
	}
	elseif($_POST['target']=='popUp'){
		AjaxResponse::innerHTML('popup_title', 'Server response');
		AjaxResponse::innerHTML('popup_content', 'Greetings!');
		AjaxResponse::functionCall('appendHTML', array('popup_content', 'beforeend', '<br/>123x123= '));
		AjaxResponse::functionCall('setStyle', array('popup_content', 'width', '200px'));
		AjaxResponse::functionCall('popUpAPI.display', array());
	}
}


//###################################################################

AjaxResponse::pushBuffer();


?>

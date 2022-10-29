<?php
/*********************************************************************
* AjaxResponse class                                                 *
*                                                                    *
* Version: 1.0                                                       *
* Date:    17-08-2020                                                *
* Author:  Dan Machado                                               *
* Require  php 6 or above                                            *
**********************************************************************/

class AjaxResponse
{	
	private static $response=array(
			'textResponse'=>array(), 
			'Functions'=>array()
			);

/**/public static function init($debug=false){
/*	  */if($debug){
/*      */ob_start(function($buffer){
/*         */AjaxResponse::functionCall('AjaxServerResponseHander.debug', array($buffer));
/*         *///AjaxResponse::flushBuffer();
/*         */header('Content-Type: application/json');		
/*         */echo json_encode(self::$response);
/*      */});
/*   */}
/*   */else{
/*      */ob_start();
/*   */}
/**/}

/**/public static function pushBuffer(){
/*   */ob_end_flush();
/*   */ob_clean();
/*   */ob_start();
/*   */header('Content-Type: application/json');		
/*   */echo json_encode(self::$response);
/*   */ob_end_flush();
/**/}

/**/public static function flushBuffer(){
/*   */header('Content-Type: application/json');		
/*   */echo json_encode(self::$response);
/**/}

	public static function innerHTML($id, $data=''){
		if(is_array($id)){
			foreach($id as $k=>$v){
				self::$response['textResponse'][$k]=$v;
			}
		}
		else{
			self::$response['textResponse'][$id]=$data;
		}
	}

	public static function functionCall($func, $params){
		/*
		README: the value for the function to be called 
		(self::$response['Functions']['my_javascript_func'])
		needs to be an array because sometimes we need to apply the same
		function multiple times with different parameters.
		*/
		if(!isset(self::$response['Functions'][$func])){
			self::$response['Functions'][$func]=array();
		}
		
		self::$response['Functions'][$func][]=$params;
	}
}

//####################################################################


?>
<?php

// Handle apropiate response message for distinct responses
function responseHandler($httpStatusCode = 200, $httpStatusMsg = null, $body = null)
{
	if($httpStatusCode >= 400)
	{
		$body = json_encode(
    	array(
    		"error" => array(
      		"code" => $httpStatusCode,
      		"message" => $body
      	)
      )
    );
	}
	// https://stackoverflow.com/a/23190950
	$phpSapiName    = substr(php_sapi_name(), 0, 3);
	if ($phpSapiName == 'cgi' || $phpSapiName == 'fpm') {
	    header('Status: '.$httpStatusCode.' '.$httpStatusMsg);
	    echo $body;
	    exit();
	} else {
	    $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
	    header($protocol.' '.$httpStatusCode.' '.$httpStatusMsg);
	    echo $body;
	    exit();
	}
}
?>

<?php 
/*
	POST /oauth2/v3/token HTTP/1.1
	Host: www.googleapis.com
	Content-Type: application/x-www-form-urlencoded

	code=4/P7q7W91a-oMsCeLvIaQm6bTrgtp7&
	client_id=8819981768.apps.googleusercontent.com&
	client_secret={client_secret}&
	redirect_uri=https://oauth2-login-demo.appspot.com/code&
	grant_type=authorization_code 
	*/

/*
	$fp = fsockopen('example.com', 80);

	$vars = array(
	    'hello' => 'world'
	);
	$content = http_build_query($vars);

	fwrite($fp, "POST /reposter.php HTTP/1.1\r\n");
	fwrite($fp, "Host: example.com\r\n");
	fwrite($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
	fwrite($fp, "Content-Length: ".strlen($content)."\r\n");
	fwrite($fp, "Connection: close\r\n");
	fwrite($fp, "\r\n");

	fwrite($fp, $content); */

if (isset($_GET, $_GET['code']))
{
	$code 			= $_GET['code'];
	$client_id 		= "21405845197-pne4huqon7ql3jr3g7mm34j8v1o08cao.apps.googleusercontent.com";
	$client_secret 	= "2FsF68EW4wyn4a1EpOR2Sadu";
	$redirect_uri 	= "http://localhost/actioner/dataacquire.php";
	$grant_type 	= "authorization_code";

	$vars = array(
		'code' 			=> $code, 
		'client_id' 	=> $client_id, 
		'client_secret' => $client_secret, 
		'redirect_uri' 	=> $redirect_uri,
		'grant_type' 	=> $grant_type,
		);

	$encoded_vars 	= http_build_query($vars);

	$fp = fsockopen("ssl://www.googleapis.com", 443, $errno, $errstr, 60);
	if (!$fp) {
	    echo "ERR: $errstr ($errno)<br />\n";
	} else {
	    $out = 	"POST /oauth2/v3/token HTTP/1.1\r\n";
	    $out .= "Host: www.googleapis.com\r\n";
	    $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
	    $out .= "Content-Length: ".strlen($encoded_vars)."\r\n";
	    $out .= "Connection: Close\r\n";
	    $out .= "\r\n";
	    $out .= $encoded_vars."\r\n\r\n";

	    fwrite($fp, $out);
	    $response = '';
	    
	    while (!feof($fp)) {
	        $response .= fgets($fp);
	    } 
	    fclose($fp);
	    $response = preg_split('/\r\n\r\n/', $response);

	    echo "<pre>";
	    if (isset($response[1])) {
	    	// get contentent from response body
	    	$content = $response[1];
	    	$content = json_decode($content);
	    	if (isset($content->access_token))
	    	{

	    	}
	    	elseif (isset($content->error)) {

	    	}
	    } else {
	    	echo $response[0];
	    	echo "\r\nno response body";
	    }
	    echo "\r\n--eo";
	    echo "</pre>";
	}
} else {
	echo "<pre>no get vars.</pre>\r\n";
}



/* EOF */
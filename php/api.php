<?php

$startTime = microtime(TRUE);

// enable gzip and output buffering
if(!ob_start("ob_gzhandler"))
	ob_start();

session_start();

include 'config/config.php';

// auto include class files
function moduleLoader($className)
{
	include 'classes/'.$className.'.php';
}

spl_autoload_register('moduleLoader');

try
{
	if(isset($_POST['params']))
		$params = $_POST['params'];
	else
		$params = array();
	
	$callTimes['dbConnect'] = microtime(TRUE);
	$db = new Database('mysql:host='.DB_SERVER.';dbname='.DB_NAME, DB_USER,DB_PASS);  
	
	$callTimes['dbConnect'] = microtime(TRUE) - $callTimes['dbConnect'];

	$call = $_POST['call'];
	
	if($call) // verifyUser($params)
	{
		// tokenize into two parts,ie Users.load will become array([0]=>"User",[1]=>"load")
		$explode = explode(".",$call);

		$class = new $explode[0];
		
		$callTimes['innerCall'] = microtime(TRUE);
		
		$retval = $class->$explode[1]($params);
		
		$callTimes['innerCall'] = microtime(TRUE) - $callTimes['innerCall'];

		$db = null;
		
		echo json_encode($retval);
	}
	else
	{
		echo 'error-no call';
	}
	
}
catch(PDOException $e) 
{
    // mail error,userId,call and params
    $params = json_decode($_POST['params'],TRUE);
	$call = $_POST['call'];
    $crash = array("params"=>$params,"call"=>$call,"error message"=>$e->getMessage(),"trace"=>$e->getTrace());
    mail("barisusakli@gmail.com", "API Exception",Util::json_format(json_encode($crash)));	  
    echo $e->getMessage();  
} 

function verifyUser($params)
{
	
	GLOBAL $db;
	
	$clientIP = $_SERVER['REMOTE_ADDR'];
	$clientSessionID = session_id();
	$userId = $params['userId'];
	
	$sth = $db->prepare("SELECT userId FROM users_sessions WHERE sessionId=:clientSessionID AND IPaddress=:clientIP AND deleted='0'");
	$sth->bindParam(':clientSessionID',$clientSessionID);
	$sth->bindParam(':clientIP',$clientIP);
	$sth->execute();
	
	$row = $sth->fetch();
	if (is_array($row) && count($row) > 0 && $clientSessionID != '' && MAINTENANCE==FALSE)
	{
		return true;
	}
	
	// check user permissions now, this allows users with permissions to run game locally 
	$sth = $db->prepare("SELECT userId,permissions FROM users WHERE userId=:userId");
	$sth->bindParam(':userId',$userId);
	$sth->execute();
	$row = $sth->fetch();
	if($row)
	{
		if($row['permissions'] > 0)
			return true;
	}
	
	return false;		
}


?>
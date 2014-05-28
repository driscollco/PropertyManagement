<?php
@session_start();// start a session

// setup db connection
$dbhost  = 'db4free.net';   // database host
$dbname  = 'kucps5950pm';  	// database name
$dbuser  = 'keanu';   		// database username 
$dbpass  = 'keanuse';   	// database password

$link = mysqli_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysqli_select_db($link, $dbname) or die(mysql_error());

function get($link, $query)
{
	$result = mysqli_query($link,$query);
	$rows = mysqli_fetch_array($result,MYSQLI_ASSOC);
	return $rows;
}

function getResultSet($link, $query)
{
	$array_result = array();
	$result = mysqli_query($link,$query);
	while($rows = mysqli_fetch_assoc($result))
	{
		$array_result[] = $rows;			
	};
	return $array_result;
}

function insert($link,$query)
{
	mysqli_query($link,$query);
	return $result;
}

function update($link, $query)
{
	$result = mysqli_query($link,$query);
	return $result;
}



?>

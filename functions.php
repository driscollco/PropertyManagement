<?php
require_once "db.php";

// query our mysql database found in db.php
function queryMysql($query)
{
	global $link;
    $result = mysqli_query($link, $query) or die(mysql_error());
	
	return $result;
}

// sanitize a string collected from the user to prevent SQL injections
function sanitizeString($var)
{
	global $link;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return mysqli_real_escape_string($link,$var);
}
?>
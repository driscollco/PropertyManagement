<?php
	require_once('db.php');
	$spot = $_REQUEST['spot'];
	$expires ="'".$_REQUEST['expire']."'";
	update($link, "UPDATE user_spot SET expire = $expires WHERE spotID = $spot");
?>
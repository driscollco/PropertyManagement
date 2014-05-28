<?php
	require_once('db.php');
	$userID = $_REQUEST['userID'];
	$nameOnCard = "'".$_REQUEST['nameOnCard']."'";
	$cardNumber = "'".$_REQUEST['cardNum']."'";
	$cvc = "'".$_REQUEST['cvc']."'";
	$expMonth = "'".$_REQUEST['expMonth']."'";
	$expYear = "'".$_REQUEST['expYear']."'";
	$cardType = $_REQUEST['cardType'];

	insert($link, "INSERT INTO user_card VALUES(0, $cardType, $userID, $cardNumber, $cvc, $nameOnCard, $expYear, $expMonth );");

?>

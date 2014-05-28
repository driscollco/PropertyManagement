<?php
	require_once('db.php');
	$userID = $_REQUEST['userID'];
	$paymentType = "'".$_REQUEST['paymentType']."'";
	$billingID = $_REQUEST['billingID'];
	$amount = $_REQUEST['amount'];
	$paymentDate = "'".date("Y-m-d")."'";

	insert($link, "INSERT INTO payment VALUES(0, $userID, (SELECT paymentTypeID FROM payment_type WHERE name = $paymentType), $billingID, $paymentDate, $amount );");

?>

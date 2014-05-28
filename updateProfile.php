<?php
	require_once('db.php');
	$userID = $_REQUEST['userID'];
	$firstName = "'".$_REQUEST['firstName']."'";
	$lastName = "'".$_REQUEST['lastName']."'";
	$email = "'".$_REQUEST['emailAddress']."'";
	$phone = "'".$_REQUEST['phone']."'";
	$parkingAutoPayment = $_REQUEST['parkingAutoPayment'];
	$rentAutoPayment = $_REQUEST['rentAutoPayment'];
	if(!isset($_REQUEST['rentCard'])) $rentCard = $_REQUEST['rentCard']; else $rentCard = 'NULL';
	if(!isset($_REQUEST['parkingCard'])) $parkingCard = $_REQUEST['parkingCard']; else $parkingCard = 'NULL';

	echo $userID;
	echo $firstName;
	echo $lastName;
	echo $email;
	echo $phone;
	echo $parkingAutoPayment;
	echo $rentAutoPayment;

	update($link, "UPDATE users SET first = $firstName, last = $lastName, email = $email, phone = $phone, autopay_rent = $rentAutoPayment, autopay_parking = $parkingAutoPayment, rent_card = $rentCard, parking_card = $parkingCard  WHERE userID = $userID;");
		//update($link, "UPDATE parking_spot SET autorenew = $parkingAutoRenew WHERE spotID = ")
	update($link, "UPDATE login SET email = $email WHERE userID = $userID;");

	?>
<?php
	require_once('db.php');
	$card = $_REQUEST['card'];
	$results = get($link, "SELECT PT.name, U.nameOnCard, U.number, U.security, U.expYear, U.expMonth FROM user_card U LEFT JOIN payment_type PT ON PT.paymentTypeID = U.paymentTypeID WHERE U.userCardID = $card ");
	echo json_encode($results);
?>
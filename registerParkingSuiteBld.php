<?php
	require_once('db.php');

	$userID = $_REQUEST['id'];
	$buildingID = $_REQUEST['building'];
	$spotID = $_REQUEST['spot'];
	$lotID = $_REQUEST['lot'];
	$suite ="'". $_REQUEST['suite']. "'";
	$license = "'".$_REQUEST['license']."'";
	$state = "'".$_REQUEST['state']."'";
	$expire = "'".date(('Y-m-d'), strtotime('+1 year'))."'";

	$today = date(('Y-m-d'), strtotime('+1 month'));

	insert($link, "INSERT INTO user_building VALUES($buildingID, $userID)");
	update($link, "UPDATE user_spot SET userID = $userID, license = $license, state = $state, expire = $expire WHERE spotID = $spotID AND lotID = $lotID");
	update($link, "UPDATE building_suite SET userID = $userID WHERE buildingID = $buildingID AND suite = $suite");
	insert($link, "INSERT INTO billing (userID, billingAmountID, billingDate) VALUES($userID, 1, '$today'),($userID, 2, '$today')");

?>
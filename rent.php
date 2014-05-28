<DOCTYPE! html>
<html>
<head>
	<title>Rent Information</title>
<link rel="stylesheet" type="text/css" href="css/rent.css">
<script text="text/javascript">
function sortBy()
{
	var building = document.getElementById('building');
	var status = document.getElementById('status');
	var search = document.getElementById('search');

	console.log(building.options[building.selectedIndex].text);
	console.log(status.options[status.selectedIndex].value);
	console.log(search.value);
	
	window.open("rent.php?building="+building.options[building.selectedIndex].text 
		+ "&status="+status.options[status.selectedIndex].value
		+"&search="+search.value, "_self");

}


function loadData() {
		<?php

		require_once('db.php');
		$GLOBALS['getBuilding'] = $_REQUEST['building'];
		$GLOBALS['getStatus'] = $_REQUEST['status'];
		$GLOBALS['getSearch'] = $_REQUEST['search'];

		$GLOBALS['buildings'] = getResultSet($link,"SELECT name, buildingID FROM building");

		if(strlen($getSearch) > 0)
		{
			$GLOBALS['tenantList'] = getResultSet($link,"SELECT U.userID, U.first, U.last FROM users U WHERE U.first LIKE '%".$getSearch."%' OR U.last LIKE '%".$getSearch."%'");
		}
		else
		{
			$GLOBALS['tenantList'] = getResultSet($link,"SELECT U.userID, U.first, U.last FROM users U ");
		}
		?>
}
</script>
		
</head>
<body onLoad="loadData()">
<?php require_once('template.php'); ?> 


<div id="pageTitle">
	<h2>Rent Status</h2>
</div>

<div id= "RentView">
<table id="searchTable">
	<tr>
		<td>Building <select id="building">
			<option>All</option>
			<?php foreach($buildings as $building) 
			{ 
				echo "<option value='".$building['buildingID']."'>".$building['name']."</option>";
			}
			?></select></td>
		<td>Status: <select id="status">
			<option>All</option>
			<option>Paid</option>
			<option>Not Paid</option></td>
	</tr>
	<tr id="SearchRow">
		<td colspan="2">Search: <input type="text" width="200px" id="search"></input></td>
		<td><button type="button" onclick="sortBy()">GO</button></td>
	</tr>
</table>

<br />
<table border="1" id="tenantsTable" class="displayTable">
	<tr>
		<td class="tableHeader">ID</td>
		<td class="tableHeader">Name</td>
		<td class="tableHeader">Status</td>
		<td class="tableHeader">Balance</td>
	</tr>
	<?php
		$rowsNotAdded = 0;
		foreach ($tenantList as $tenant) 
		{
			$id = $tenant['userID'];
			$billArray = get($link,
				"SELECT SUM(price) as bills FROM billing_amount BA 
				LEFT JOIN billing B ON B.billingAmountID = BA.billingAmountID
				WHERE B.userID = $id AND BA.name = 'Rent';");

			$paymentArray = get($link,
				"SELECT SUM(amount) as payments FROM payment P
				LEFT JOIN billing B ON B.billingID = P.billingID
				LEFT JOIN billing_amount BA ON BA.billingAmountID = B.billingAmountID
				WHERE B.userID = $id AND BA.name = 'Rent';");

			$userBuildingArray = getResultSet($link, 
				"SELECT B.name FROM user_building UB 
				LEFT JOIN building B ON B.buildingID = UB.buildingID 
				WHERE UB.userID = $id");

				$counter = 0;
				$buildingFitsCriteria = FALSE;
				$statusIsPaid = FALSE;
				foreach ($userBuildingArray as $ub) 
				{
					$buildingName = $ub['name'];
					if($getBuilding == "All" or $getBuilding == $buildingName)
					{
						$buildingFitsCriteria = TRUE;
					}

					

					if($counter != count($userBuildingArray)-1)
					{
						$buildingName .= ", ";
					}
					$counter++;
				}

				if($getStatus == "Paid" or $getStatus == "All")
				{
					if(($billArray['bills']-$paymentArray['payments']) <= 0 or $getStatus == "All")
					{
						$statusIsPaid = TRUE;
					}
				}



			if($buildingFitsCriteria and $statusIsPaid)
			{
				echo "<tr>";
				echo "<td><a href='rentpayment.php?id=".$tenant['userID']."'>".$tenant['userID']."</a></td>";
				echo "<td>".$tenant['first']." ".$tenant['last']."</td>";
				echo "<td";
				if($statusIsPaid == TRUE)
					echo " bgcolor='green'>PAID";
				else
					echo " bgcolor='red'>NOT PAID";
				echo "</td>";
				echo "<td>$".number_format(($billArray['bills']-$paymentArray['payments']),2)."</td>";
				echo "</tr>";
			}
			else
			{
				$rowsNotAdded++;
			}
		}

		if(count($tenantList) == $rowsNotAdded)
		{
			echo "<tr>";
			echo "<td colspan='5'> No tenants match the criteria</td>";
			echo "</tr>";
		}
	?>
	
</table>
</div>

</body>
</html>
<?php
require_once("functions.php");
/* 
use this template to start building your pages
simply go to file->save as-> and enter your file name
then add and modify as needed
*/

// you can start writing your php code here

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Parking Information</title>
<!-- this stylesheet is for the header -->
<link rel="stylesheet" type="text/css" href="css/system_header_styles.css">

<!-- this stylesheet is for the container write your css in this file: main_system_styles.css -->
<link rel="stylesheet" type="text/css" href="css/main_system_styles.css">
<link rel="stylesheet" type="text/css" href="css/parking.css">


<script text="text/javascript">
function sortBy() 
{
var building = document.getElementById('building');
var status = document.getElementById('status');
var search = document.getElementById('search');

window.open("parking.php?building="+building.options[building.selectedIndex].text
+"&status="+status.options[status.selectedIndex].value
+"&search="+search.value,"_self");

}

function loadProfile() 
{
<?php
	require_once("db.php");
	$getBuilding = $_REQUEST['building'];
	$getStatus = $_REQUEST['status'];
	$getSearch = $_REQUEST['search'];

	$GLOBALS['buildings'] =getResultSet($link,"SELECT name,buildingID FROM building");
	if(strlen($getSearch) > 0)
	{
		$parkingQuery = "select u.userID as id, u.first as first, u.last as last, s.license as license, p.lotID as p_lot, s.spotID as p_spot
										from  user_spot s
										LEFT JOIN users u ON u.userID=s.userID
										LEFT JOIN parking_lot p ON p.lotID=s.lotID
										WHERE u.first LIKE '%".$getSearch."%' OR u.last LIKE '%".$getSearch."%' AND s.userID IS NOT NULL";
	}
	else
	{

		

		$parkingQuery = "select u.userID as id, u.first as first, u.last as last, s.license as license, p.lotID as p_lot, s.spotID as p_spot
		from  user_spot s
		LEFT JOIN users u ON u.userID=s.userID
		LEFT JOIN parking_lot p ON p.lotID=s.lotID
		WHERE s.userID IS NOT NULL";

	}

	$GLOBALS['parking']=getResultSet($link,$parkingQuery);
?>
}
</script>

</head>

<body>
	<!-- this div wraps the header on the top of the page -->
	<div id="wrapSystemHeader">
        <div id="header">
            <ul><!-- these are the links that are displayed in the header bar, modify as needed -->
                <li class="businessServices"><a href="Finance.php">Finance</a></li>                                  	
                <li class="businessServices"><a href="maintenance.php">Maintenance</a></li>
                <li class="businessServices"><a href="parking.php?building=All&status=All&search=">Parking</a></li>
                <li class="businessServices"><a href="rent.php?building=All&status=All&search=">Rent</a></li>
            </ul>
            <!-- the log out icon -->
            <a href="logout.php"><img title="Log out" id="key_icon" src="graphics/key_icon.png" width="16" height="32" /></a>
        </div>
    </div>
	
<div id="pageTitle">
	<h2>Parking Status</h2>
</div>

<div id= "ParkingView">
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
		<td colspan="2">Search Name: <input type="text" width="200px" id="search"></input></td>
		<td><button type="button" onclick="sortBy()">GO</button></td>
	</tr>
</table>
         <br /> 
      
      <table border="1" id="parkingTable" class="displayTable">
          <tr>
			  <td class="tableHeader">ID</td>
              <td class="tableHeader">First Name</td>
              <td class="tableHeader">Last Name</td>
              <td class="tableHeader">Lot</td>
              <td class="tableHeader">Spot</td>
              <td class="tableHeader">License</td>
              <td class="tableHeader">Balance</td>
              <td class="tableHeader">Status</td>
          </tr>
		  <tr>
          <?php
          $rowsNotAdded = 0;
		  foreach($parking as $spot)
		  {
			  $id = $spot['id'];
				$billArray = get($link,
					"SELECT SUM(price) as bills FROM billing_amount BA 
					LEFT JOIN billing B ON B.billingAmountID = BA.billingAmountID
					WHERE B.userID = $id AND BA.name = 'Parking';");

				$paymentArray = get($link,
					"SELECT SUM(amount) as payments FROM payment P
					LEFT JOIN billing B ON B.billingID = P.billingID
					LEFT JOIN billing_amount BA ON BA.billingAmountID = B.billingAmountID
					WHERE B.userID = $id AND BA.name = 'Parking';");
				
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
		          echo "<td><a href='parkingpayment.php?id=$id'>".$spot['id'].'</a></td>';
				  echo '<td>'.$spot['first'].'</td>';
		          echo '<td>'.$spot['last'].'</td>';
				  echo '<td>'.$spot['p_lot'].'</td>';
				  echo '<td>'.$spot['p_spot'].'</td>';
				  echo '<td>'.$spot['license'].'</td>';
				  echo '<td>$ '.number_format(($billArray['bills']-$paymentArray['payments']),2).'</td>';		
				  echo "<td ";  
				  if($statusIsPaid == TRUE)
						echo " bgcolor='green'>PAID";
					else
						echo " bgcolor='red'>NOT PAID";
					echo "</td>";
				}
				else
				{
					$rowsNotAdded++;
				}
				echo "</tr>";
		  }

		  if(count($parking) == $rowsNotAdded)
			{
				echo "<tr>";
				echo "<td colspan='9'> No tenants match the criteria</td>";
				echo "</tr>";
			}
			?> 

		</tr>
		
      </table>
</div>     
</body>
</html>

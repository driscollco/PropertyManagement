
<!doctype html>
<html>
<head>
<script text="text/javascript">
function loadProfile()
{
	<?php
		require_once('db.php');
		$GLOBALS['parkingInfo'] = get($link, "
		Select U.first, U.last, P.spotID, PA.paymentDate, PA.amount, PL.lotID, BD.name as buildingName FROM users U
		LEFT JOIN parking_spot P ON P.userID = U.userID
		LEFT JOIN parking_lot PL ON PL.lotID = P.lotID
		LEFT JOIN building BD ON BD.buildingID = PL.buildingID
		LEFT JOIN payment PA ON PA.userID = P.userID
		LEFT JOIN billing B ON B.billingID = PA.billingID
		LEFT JOIN billing_amount BA ON BA.billingAmountID = B.billingAmountID
		WHERE P.userID = 1 AND B.billingAmountID = 2;");
		
		$GLOBALS['balance'] = get($link,
		"SELECT sum(BA.price) - sum(P.amount) as Balance
		FROM payment P
		LEFT JOIN billing B ON B.billingID = P.billingID
		LEFT JOIN billing_amount BA ON BA.billingAmountID = B.billingAmountID
		LEFT JOIN users U ON P.userID = U.userid
		WHERE U.userID = 1 AND BA.billingAmountID = 2;");
	
	
	?>
}
</script>
<meta charset="utf-8">
<title>Parking Payments</title>
<!-- this stylesheet is for the header -->
<link rel="stylesheet" type="text/css" href="css/system_header_styles.css">

<!-- this stylesheet is for the container write your css in this file: main_system_styles.css -->
<link rel="stylesheet" type="text/css" href="css/main_system_styles.css">

<style>
#pageTitle
{
	width:30%;
	margin: 0 auto;
}

table.ex1
{
	border-collapse:separate;
	border-spacing:1px;
	padding-top: 0px;
	
}
table.ex2
{
	border-collapse:separate;
	border-spacing:1px;
}

#balanceTable
{
	width:200px;
}

#paymentTable td
{
	width:150px;
}

#paymentView
{
	padding-top: 20px;
	width: 60%;
	margin:0 auto;
}

</style>
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
	<h2>Parking Payment History</h2>
</div>

    <div id="paymentView">
	 <table id="balanceTable" border="1" align="center" class="displayTable">
			<tr>
                <td class="tableHeader">Name</td>
                <td class="tableHeader">Balance Due</td>
            </tr>
            <tr>
                <td><?php echo $parkingInfo['first']." ".$parkingInfo['last']?></td>
                <?php  
				if($balance['Balance'] < 0)
				{
					echo '<td bgcolor="#00FF00">'.$balance['Balance'].'</td>';
				}
				else
				{
					echo '<td bgcolor="#FF0000">'.$balance['Balance'].'</td>';
				}
				
				?>
            </tr>
      
            
        </table>
      
        <table id="paymentTable" border="1" align="center">
            <tr>
            <br>
                <td class="tableHeader">Date</td>
                <td class="tableHeader">Payment Amount</td>
                <td class="tableHeader">Building</td>
                <td class="tableHeader">Lot</td>
                <td class="tableHeader">Spot</td>
            </tr>
            </br>
            <tr>
                <td><?php echo $parkingInfo['paymentDate']?></td>
                <td>$<?php echo $parkingInfo['amount']?></td>
                <td><?php echo $parkingInfo['buildingName']?></td>
                <td><?php echo $parkingInfo['lotID']?></td>
                <td><?php echo $parkingInfo['spotID']?></td>
            </tr>
        </table>    
    
    </div>
</body>
</html>
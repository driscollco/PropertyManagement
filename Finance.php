<?php
require_once("functions.php");

?>
<!doctype html>
<html>
	<title> Finanace</title>
<head>
	
<meta charset="utf-8">
<title>Page Title</title>
<!-- this stylesheet is for the header -->
<link rel="stylesheet" type="text/css" href="css/system_header_styles.css">

<!-- this stylesheet is for the container write your css in this file: main_system_styles.css -->
<link rel="stylesheet" type="text/css" href="css/main_system_styles.css">
<link rel="stylesheet" type="text/css" href="css/finance.css">

<script type="text/javascript">
	function returnDate(){
		var now = new Date(); // this returns the amount of milliseconds since 1/1/1970, which is how we'll get the current date
		var month = now.getMonth()+1; // just to get the month, all we do is use the date object we've initialized, and call the getMonth function. But, because the months are indexed to 0 (meaning months are numbered 0-11), we have to add 1
		var day = now.getDate(); // get the day
		var year = now.getYear(); // get the year
		
		return month + "/" + day + "/" + year;
		
	}
	function displayDate() {
		document.getElementById("demo").innerHTML = returnDate();
	}
	
	function loadProfile()
	{
		<?php
			require_once('db.php');
			$GLOBALS['salaryExpense'] = get($link, "SELECT SUM(amount) as SalarySum FROM employee_salary E LEFT JOIN salary S ON S.salaryID = E.salaryID;");
            $GLOBALS['utilityExpense'] = get($link, "SELECT SUM(price) as UtilitySum FROM utility U;");
            $GLOBALS['maintenanceExpense'] = get($link, "SELECT SUM(M.price) as MaintenanceSum FROM maintenance_report R LEFT JOIN maintenance M ON M.maintenanceID = R.maintenanceID;");
            $GLOBALS['totalExpense'] = $salaryExpense['SalarySum'] + $utilityExpense['UtilitySum'] + $maintenanceExpense['MaintenanceSum'];
 
            $GLOBALS['parkingRev'] = get($link, 
                "Select sum(P.amount) as ParkingSum from payment P
                LEFT JOIN billing B ON B.billingID = P.billingID
                LEFT JOIN billing_amount BA ON BA.billingAmountID = B.billingAmountID 
                WHERE BA.name = 'Parking';");

            $GLOBALS['rentRev'] = get($link, 
                "Select sum(P.amount) as RentSum from payment P
                LEFT JOIN billing B ON B.billingID = P.billingID
                LEFT JOIN billing_amount BA ON BA.billingAmountID = B.billingAmountID 
                WHERE BA.name = 'Rent';");

            $GLOBALS['totalRev'] = $parkingRev['ParkingSum'] + $rentRev['RentSum'];
    	?>
	}
	</script>
	

</head>
<body onload="loadProfile()">


	<!-- this div wraps the header on the top of the page -->
	<div id="wrapSystemHeader" >
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
 
    <div id="container" align="center"> 
        <!-- Place your html code here -->
        <h2 style="margin: 0; padding: 0;">Financial Services</h2>
       </br >
     <!-- <div style="background-image:url('./graphics/fresh_snow.png'); height: 800px; width: 400px; border: 1px solid black;" >-->
      	<div id="fin" align="center">
      		
         <table id = "table" align="left">
         	<tr id="tr">
         		<th id="th" > Expenses</th>
         		<th id="th">  Cost($/month)</th>
         	</tr>
 
         	<tr id="tr">
         		<td id="td">Salary</td>
         		<td id="td"><?php echo '$'.$salaryExpense['SalarySum']; ?></td> 
         	</tr>
         	
         	<tr id="tr">
         		<td id="td">Maintenance</td> 
         		<td id="td"><?php echo '$'.$maintenanceExpense['MaintenanceSum']; ?></td>
         	</tr>
         	
         	<tr id="td">
         		<td id="td">Security</td>
         		<td id="td">$ 3,000.00</td>
         	</tr>
         	<tr id="td">
         		<td id="td">Utilites</td>
         		<td id="td"><?php echo '$'.$utilityExpense['UtilitySum']; ?></td>
         	</tr>
         </table>
        
         
         <table id ="table">
         	<tr id="tr">
         		<th id="th"> Revenue/Income</th>
         		<th id="th">Amount($/month)</th>
         	</tr>
         	
         	<tr id="tr">
         		<td id="td">Rent</td>
         		<td id="td"><?php echo '$'.$rentRev['RentSum']; ?></td>
         	</tr>
         	
         	<tr id="tr"> 
         		<td id="td">Parking</td> 
         		<td id="td"><?php echo '$'.$parkingRev['ParkingSum']; ?></td>
         	</tr>
         </table>
        <table id="table">
        	<tr id="tr"> 
        		<th id="tr">
        			Total <br>Revenue($)
        			</th>
        				<td id="td"><?php echo '$'.$totalRev; ?></td>
        	</tr>
        	<tr id="tr"> 
        		<th id="tr">
        			Total <br>Expenses($)
        			</th>
                    <?php $totalExpense = 3000 + $utilityExpense['UtilitySum'] + $maintenanceExpense['MaintenanceSum'] + $salaryExpense['SalarySum']; ?>
        				<td id="td"><?php echo '$'.number_format($totalExpense,2); ?></td>
        	</tr>
        </table>
        
       
      </div>


    
    
</body>
</html>
<?php
require_once("functions.php");
/* 
use this template to start building your pages
simply go to file->save as-> and enter your file name
then add and modify as needed
*/

// you can start writing your php code here

$userid = 1;//$_SESSION['userid'];

//$sql = "SELECT BA.price FROM billing_amount;"
$sql2 = "SELECT * FROM users WHERE userid = '$userid'";

$result = queryMysql($sql2);
$rec = mysqli_fetch_assoc($result);
//$GLOBALS['building'] = get($link, $sql);
?>

<!doctype html>
<html>
<head>
  <script text="text/javascript">
function loadProfile()
{
  <?php
    require_once('db.php');
    $GLOBALS['rentInfo'] = get($link, "
    Select U.suite, U.first, U.last, P.spotID, PA.paymentDate, PA.amount, PL.lotID, BD.name as buildingName FROM users U
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
<title>Rent Payments</title>
<!-- this stylesheet is for the header -->
<link rel="stylesheet" type="text/css" href="css/system_header_styles.css">

<!-- this stylesheet is for the container write your css in this file: main_system_styles.css -->
<link rel="stylesheet" type="text/css" href="css/main_system_styles.css">
</head>

<body>
	<!-- this div wraps the header on the top of the page -->
	<div id="wrapSystemHeader">
        <div id="header">
            <ul><!-- these are the links that are displayed in the header bar, modify as needed -->
               <!-- <li class="businessServices"><a href="#">Finance</a></li> -->
                <li class="businessServices"><a href="#">Maintenance</a></li>
                <li class="businessServices"><a href="#">Parking</a></li>
                <li class="businessServices"><a href="#">Rent</a></li>                               
            </ul>
            <!-- the log out icon -->
            <a href="logout.php"><img title="Log out" id="key_icon" src="graphics/key_icon.png" width="16" height="32" /></a>
        </div>
    </div>
    
    <div id="container">
      <h2 align="center">Rent Payment History</h2>
   <table width="400px" height="100px" border="3" align="center">
      <tr>
            <br>
                <td>Name</td>
                <td>Balance Due</td>
            </tr>
            </br>
            <tr>
            <br>
                <td><?php echo $rentInfo['first']." ".$rentInfo['last']?></td>
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


<style>

#tenantInfo td
{
    width: 200px;
}
#sortBy
{
    padding-top: 5px;
}

#rentPaymentList
{
border:1px solid black;
margin-top: 30px;
}
th
{
background-color:#0B2161;
color:white;
}
</style>
</head>


<?php

echo "<center><table id='rentPaymentList' width='500' cellpadding='2' cellspacing='2' border='1'></center>";


echo "<tr>
      <th>Date</th>
      <th>Payment Amount</th>
      <th>Building</th>
      <th>Unit</th>
      </tr>";

echo "<tr><td>Jan</td><td>$200</td><td>$0.00</td><td>1</td><td>100</td><td>Active</td></tr>";
echo "<tr><td>Feb</td><td>$100</td><td>$50</td><td>2</td><td>301</td><td>Active</td></tr>";
echo "<tr><td>Mrch</td><td>$300</td><td>$20</td><td>3</td><td>402</td><td>NotActive</td></tr>";
echo "<tr><td>April</td><td>$500</td><td>$0.00</td><td>4</td><td>111</td><td>Active</td></tr>";
echo "<tr><td>May</td><td>$200</td><td>$0.00</td><td>5</td><td>222</td><td>NotActive</td></tr>";
echo "<tr><td>June</td><td>$100</td><td>$10</td><td>6</td><td>521</td><td>Active</td></tr>";
echo "<tr><td>Jan</td><td>$400</td><td>$0.00</td><td>7</td><td>621</td><td>Active</td></tr>";
echo "<tr><td>Dec</td><td>$500</td><td>$40</td><td>8</td><td>332</td><td>NotActive</td></tr>";
echo "<tr><td>Feb</td><td>$200</td><td>$0.00</td><td>5</td><td>242</td><td>Active</td></tr>";
echo "<tr><td>Sep</td><td>$100</td><td>$80</td><td>2</td><td>512</td><td>Active</td></tr>";
echo "<tr><td>Aug</td><td>$500</td><td>$0.00</td><td>1</td><td>943</td><td>NotActive</td></tr>";
echo "<tr><td>July</td><td>$300</td><td>$0.00</td><td>5</td><td>145</td><td>Active</td></tr>";
echo "<tr><td>Jan</td><td>$200</td><td>$0.00</td><td>4</td><td>176</td><td>Active</td></tr>";


echo "</table>";

?> 
        
    
    </div> 

</body>
</html>
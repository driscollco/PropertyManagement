<html>
<head>
	<!--<link href="css/main_styles.css" rel="stylesheet" type="text/css">-->
	<link href="css/tenant_profile_styles.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>	
	<script text="text/javascript">
	function loadProfile() {
		<?php
		require_once('db.php');
		$GLOBALS['stateList']  = array(
	    'AL',
	    'AK',
	    'AZ',
	    'AR',
	    'CA',
	    'CO',
	    'CT',
	    'DE',
	    'DC',
	    'FL',
	    'GA',
	    'HI',
	    'ID',
	    'IL',
	    'IN',
	    'IA',
	    'KS',
	    'KY',
	    'LA',
	    'ME',
	    'MD',
	    'MA',
	    'MI',
	    'MN',
	    'MS',
	    'MO',
	    'MT',
	    'NE',
	    'NV',
	    'NH',
	    'NJ',
	    'NM',
	    'NY',
	    'NC',
	    'ND',
	    'OH',
	    'OK',
	    'OR',
	    'PA',
	    'RI',
	    'SC',
	    'SD',
	    'TN',
	    'TX',
	    'UT',
	    'VT',
	    'VA',
	    'WA',
	    'WV',
	    'WI',
	    'WY'
	);
		?>
	}

	function renew()
	{
		var todaysDate = new Date();

		var spot = document.getElementById('autoRenew');
		console.log((todaysDate.getFullYear()+1) + "-" + (todaysDate.getMonth()+1) + "-" + todaysDate.getDate());
		console.log(spot.value);
		xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
		    	var currentdate = new Date();
		    	
		    	document.getElementById('saveText').innerHTML = "last updated on " + (currentdate.getMonth()+1) + "/" + currentdate.getDate() + " at " + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();

                document.getElementById('expires').innerHTML = (todaysDate.getFullYear()+1) + "-" + (todaysDate.getMonth()+1) + "-" + todaysDate.getDate();
                document.getElementById('expires').fontcolor('green');
                document.getElementById('autoRenew').visibility = "none";
		    }
		  }

		xmlhttp.open("GET","renew.php?spot="+spot.value+"&expire="+(todaysDate.getFullYear()+1) + "-" + (todaysDate.getMonth()+1) + "-" + todaysDate.getDate(),true);
		xmlhttp.send();
	}

	function updateProfile()
	{

		var userID = document.getElementById('userID');
		var firstName = document.getElementById('firstName');
		var lastName = document.getElementById('lastName');
		var emailAddress = document.getElementById('emailAddress');
		var phone = document.getElementById('phone');
		var address = document.getElementById('address');
		var address2 = document.getElementById('address2');
		var suite = document.getElementById('suite');
		var city = document.getElementById('city');
		var zip = document.getElementById('zip');
		var state = document.getElementById('state');
		var parkingAutoPayment = document.getElementById('parkingAutoPayment');
		var rentAutoPayment = document.getElementById('rentAutoPayment');
		var parkingCard = document.getElementById('parkingCard');
		var rentCard = document.getElementById('rentCard');
		var parkingAutoPaymentValue = 0;
		var rentAutoPaymentValue = 0;
		var rentValue;
		var parkingValue;

		var errors = new Array();

		if($('#firstName').val().length == 0) errors.push('Invalid First Name');
		if($('#lastName').val().length == 0) errors.push('Invalid Last Name');
		if($('#emailAddress').val().length == 0) errors.push('Invalid Email Address');
		if($('#phone').val().length == 0) errors.push('Invalid Phone #');
	


		if(rentAutoPayment.checked)
		{
			rentAutoPaymentValue = 1;
			if(rentCard.value.length == 0)
				errors.push("Invalid credit card");
		}

		if(parkingAutoPayment.checked)
		{
			parkingAutoPaymentValue = 1;
			if(parkingCard.value.length == 0)
				errors.push("Invalid credit card");
		}

		if(parkingCard.selectedIndex == -1)
			parkingValue = "";
		else
			parkingValue = parkingCard.options[parkingCard.selectedIndex].value;

		if(rentCard.selectedIndex == -1)
			rentValue = "";
		else
			rentValue = rentCard.options[rentCard.selectedIndex].value;

		if(errors.length == 0)
		{
			xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    	var currentdate = new Date();
			    	//location.reload();
			    	document.getElementById('saveText').innerHTML = "last saved on " + (currentdate.getMonth()+1) + "/" + currentdate.getDate() + " at " + currentdate.getHours() + ":"  
	                + (currentdate.getMinutes()<10?'0':'') + currentdate.getMinutes() + ":" 
	                + currentdate.getSeconds();
			    }
			  }

			xmlhttp.open("GET","updateProfile.php?firstName="+ firstName.value +
				"&lastName=" + lastName.value +
				"&emailAddress=" + emailAddress.value +
				"&phone=" + phone.value +
				"&parkingAutoPayment=" + parkingAutoPaymentValue +
				"&rentAutoPayment=" + rentAutoPaymentValue +
				"&rentCard=" + rentValue +
				"&parkingCard=" + parkingValue +
				"&userID=" + userID.value 
				,true);
			xmlhttp.send();
		}
		else
		{
			var err = "";
			for(var i = 0; i < errors.length; i++)
			{
				err += errors[i] + "<br />";
			}

			$('#errorList').html(err);
			$('#errorList').css("color", "Red");
		}
		

		//location.reload();

	}
	</script>
</head>
<body onload="loadProfile()">
<div id="header">
    <?php require_once("showRegistered.php"); ?>
</div><!-- END header -->

<?php
	$GLOBALS['userInfo'] = get($link,"SELECT first, last, address, address2, suite, city, state, zip, U.email, phone, autopay_rent, autopay_parking, rent_card, parking_card FROM users U, login L WHERE U.userID = $userid");
	$GLOBALS['parkingInfo'] = getResultSet($link, "SELECT spotID, license, expire FROM user_spot WHERE userID = $userid");
	$GLOBALS['myCards'] = getResultSet($link, "SELECT C.userCardID, P.name, C.number FROM user_card C LEFT JOIN payment_type P ON C.paymentTypeID = P.paymentTypeID WHERE C.userID = $userid");
	$GLOBALS['suites'] = getResultSet($link, "SELECT suite FROM building_suite WHERE userID = $userid");
	$GLOBALS['buildingInfo'] = getResultSet($link, "SELECT B.address, B.city, B.state, B.zip FROM building B LEFT JOIN user_building UB ON UB.buildingID = B.buildingID WHERE UB.userID = $userid");
?>

<input type="hidden" id="userID" value="<?php echo $userid;?>">

<div id="pageTitle">
	<h2>Tenant Profile</h2>
	<label id="errorList"></label>
</div>

<div id="personalInformation">
<h3>Personal Information<h2>
<table>
	<tr>
	<td>First Name:</td>
	<td>Last Name:</td>
	<td>Email:</td>
	<td>Phone:</td>
	</tr>
	
	<tr>
	<td><input id="firstName" type="text" value="<?php echo $userInfo['first'];?>" onkeyup="this.value=this.value.replace(/[^a-zA-Z]/,'')" /></td>
	<td><input id="lastName" type="text"  value="<?php echo $userInfo['last'];?>" onkeyup="this.value=this.value.replace(/[^a-zA-Z]/,'')"/></td>
	<td><input id="emailAddress" type="text" value="<?php echo $userInfo['email'];?>" /></td>
	<td><input id="phone" maxlength="11" size="11" type="text" value="<?php echo $userInfo['phone'];?>" onkeyup="this.value=this.value.replace(/[^\d]/,'')"/></td>
	</tr>
	
	<tr>
	<td colspan="2">Address:</td>
	<td colspan="2">Address 2: (optional)</td>
	</tr>
	
	<tr>
	<td colspan="2" bgcolor="#bdbdbd"><!--<input id="address" class="address" type="text" value="--><?php //echo $userInfo['address'];
	echo $buildingInfo[0]['address'].", ".$buildingInfo[0]['city']."., ".$buildingInfo[0]['state'].", ".$buildingInfo[0]['zip'];
	?><!--"/>--></td>
	<td colspan="2" bgcolor="#bdbdbd"><!--<input id="address2" class="address" type="text" value="--><?php 
	//echo $userInfo['address2'];
	if(isset($buildingInfo[1]))
	echo $buildingInfo[1]['address'].", ".$buildingInfo[1]['city']."., ".$buildingInfo[1]['state'].", ".$buildingInfo[1]['zip'];
	?><!--"/>--></td>
	</tr>
	
	<tr>
	<td>Suite:</td>
	<!--<td>City:</td>
	<td>State:</td>
	<td>Zip:</td>-->
	</tr>
	
	<tr>
	<!--<td><input id="suite" type="text" value="<?php //echo $userInfo['suite'];?>"/></td>-->
	<td>
		<?php echo $userInfo['suite'];
			foreach ($suites as $suite) 
			{
				echo $suite['suite']." ";
			}
		?>
	</td>
	
	</tr>
	
</table>
</div>

<div id="parking">
<h3>Parking</h3>
<table>
	<tr>
	<td>License:</td>
	<td>Expires:</td>
	</tr>
	
	<?php 
	foreach ($parkingInfo as $spot)
	{
		$sp = $spot['spotID'];
		$currentDate = strtotime(date("Y-m-d"));
		$dateDiff = strtotime($spot['expire']) - $currentDate;
		echo '<tr>';
		echo '<td>'.$spot['license'].'</td>';
		
		//echo '<td>Auto Renew <input id="parkingAutoRenew" type="checkbox" name="autorenewparking"';
		//if( $parkingInfo['autorenew'] == '1'){  echo 'checked = "yes"'; }
		//echo '></td>';
		if(ceil(($dateDiff)/86400) <= 30)
		{
			echo '<td id="expires"><font color="#FF0000">'.$spot['expire'].'</font></td>';
			echo "<td><button value='$sp' id='autoRenew' type='button' onclick='renew()'>Renew</button></td>";

		}
		else
		{
			echo '<td id="expires"><font color="#00FF00">'.$spot['expire'].'</font></td>';

		}
		echo '</tr>';
	
	}
	?>
</table>

<h3>Auto Payment</h3>
<table>
	<tr>
		<td>Rent</td>
		<td><input id="rentAutoPayment" type="checkbox" name="checkbox" value="value" <?php if($userInfo['autopay_rent'] == '1'){  echo 'checked = "yes"'; }?>></td>
		<td>Card: <select id="rentCard"><?php foreach($myCards as $cards){ $currCard = $cards['userCardID']; if($cards['userCardID'] == $userInfo['rent_card']){ echo "<option selected='selected' value='$currCard'>".$cards['name']."-".$cards['number'].'</option>'; } else { echo "<option value='$currCard'>".$cards['name']."-".$cards['number'].'</option>';}}?></select></td>
	</tr>
	<tr>
		<td>Parking</td>
		<td><input id="parkingAutoPayment" type="checkbox" name="checkbox" value="value" <?php if($userInfo['autopay_parking'] == '1'){  echo 'checked = "yes"'; }?>></td>
		<td>Card: <select id="parkingCard"><?php foreach($myCards as $cards){ $currCard = $cards['userCardID'];  if($cards['userCardID'] == $userInfo['parking_card']){ echo "<option selected='selected' value='$currCard'>".$cards['name']."-".$cards['number'].'</option>'; } else { echo "<option value='$currCard'>".$cards['name']."-".$cards['number'].'</option>';}}?></select></td>
	</tr>
</table>
</div>


<div id="tenantButtons">
<table>
<tr>
<td><button type="button" onclick="updateProfile()">Save</button></td>
<td><label id="saveText"></label></td>
</tr>
</table>
</div>
</body>
</html>
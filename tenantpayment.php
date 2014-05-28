<html>
<head>
	<!--<link href="css/main_styles.css" rel="stylesheet" type="text/css">-->
	<link href="css/tenant_payment_styles.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script language="javascript" type="text/javascript">


	function reloadWithSort()
	{
		var sort = document.getElementById('sortBy');

		window.location.href = "tenantpayment.php?sort="+sort.options[sort.selectedIndex].text;

	}

	function cardSelected()
	{
		var cardSelection = document.getElementById('presetCard');

		console.log(cardSelection.options[cardSelection.selectedIndex].value);

		if(cardSelection.options[cardSelection.selectedIndex].value >  -1)
		{

			 $.ajax({                                      
		      url: 'getCardInfo.php?card='+cardSelection.options[cardSelection.selectedIndex].value,                   
		      data: "",                        		                                       
		      dataType: 'json',                      
		      success: function(data) {     
		        var name = data.name;              
		        var nameOnCard = data.nameOnCard;         
		        var number = data.number;
		        var security = data.security;
		        var year = data.expYear;
		        var month = data.expMonth;
	
		        $('#cardType').text(name);
		        $('#nameOnCard').text(nameOnCard);
		        $('#cardNumber').text(number);
		        $('#cvc').text(security); 
		        $('#exp').text(month + "/" + year);
		      } 
		    });
		}

	}

	function submitPayment()
	{
		var amount = document.getElementById('enterAmount').value;
		var userID = document.getElementById('userID').value;

		if($('#presetCard>option:selected').text().length > 0 && $('#billID').text().trim().length > 0 && amount.length > 0)
		{

			xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    	alert('Payment Successfull!');
			    }
			  }

			xmlhttp.open("GET","submitPayment.php?userID="+ userID +
				"&paymentType=" + $('#cardType').text() +
				"&billingID=" + $('#billID').text().trim() +
				"&amount=" + amount
				,true);
			xmlhttp.send();


		}
		else
		{

			if($('#presetCard>option:selected').text().length == 0)
			{
				alert('Please select a credit card');
			}

			if($('#billID').text().trim().length == 0)
			{
				alert('Please select a bill to pay');

			}

			if(amount.length == 0)
			{
				alert('Please enter an amount');
			}

		}
		

	}

	function amountChange()
	{
		$('#amount').text("$" + document.getElementById('enterAmount').value);
	}

	function addCard()
	{
		var userID = document.getElementById('userID').value;
		var nameOnCard = document.getElementById('cardName').value;
		var cardNumber = document.getElementById('cardNum').value;
		var cvc = document.getElementById('cardCvc').value;
		var expMonth = $('#expMonth').val();
		var expYear = $('#expYear').val();
		var cardType = $('#addCardType').val();

		
		var currentdate = new Date();

		if(nameOnCard.length > 0 && cardNumber.length > 0 && cvc.length > 0 && cardType > 0)
		{
			xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    	
			    	alert('Credit card added!');
			    	location.reload();
			    }
			  }

			xmlhttp.open("GET","addCard.php?nameOnCard="+ nameOnCard +
				"&cardNum=" + cardNumber +
				"&cvc=" + cvc +
				"&expMonth=" + expMonth +
				"&expYear=" + expYear +
				"&userID=" + userID +
				"&cardType=" + cardType
				,true);
			xmlhttp.send();

		}
		else
		{
			var errors = "";
			var errorList = new Array();
			if(nameOnCard.length == 0)
			{
				errorList.push("Invalid NAME");
			}

			if(cardNumber.length == 0 || cardNumber.length < 16)
			{
				errorList.push("Invalid CARD #");
			}

			if(cvc.length == 0)
			{
				errorList.push("Invalid CVC #");
			}

			if(cardType <= 0)
			{
				errorList.push("Invalid CARD TYPE");
			}

			for(var i=0; i < errorList.length; i++) {
			 	errors += errorList[i] + "<br />";
			}
			$('#addCardError').html(errors);
			$('#addCardError').css('color','red');



		}
	}

	function billChange()
	{
		$('#billID').text($('input[name=billSelect]:checked').val());
	}
	</script>
</head>
<body>
<div id="header">
    <?php require_once("showRegistered.php"); ?>
</div><!-- END header -->

<input type="hidden" id="userID" value="<?php echo $userid;?>">
<?php
		$billingInfoQuery = 
		"SELECT B.billingID, A.name, B.billingDate
		FROM billing B 
		LEFT JOIN billing_amount A ON B.billingAmountID = A.billingAmountID 
		WHERE B.userID = $userid";

		if($_GET['sort'] == "Rent")
		{
			$billingInfoQuery .= " AND A.name = 'Rent'";
		}
		elseif ($_GET['sort'] == "Parking") 
		{
			$billingInfoQuery .= " AND A.name = 'Parking'";
		}

		@$GLOBALS['rentPayments'] = get($link, "SELECT SUM(P.amount) AS RPAY FROM payment P
			LEFT JOIN billing B ON B.billingID = P.billingID 
			LEFT JOIN billing_amount BA = BA.billingAmountID = B.billingAmountID
			WHERE BA.name = 'Rent' AND P.userID = $userid");
		
		@$GLOBALS['parkingPayments'] = get($link, "SELECT SUM(P.amount) AS PPAY FROM payment P
			LEFT JOIN billing B ON B.billingID = P.billingID 
			LEFT JOIN billing_amount BA = BA.billingAmountID = B.billingAmountID
			WHERE BA.name = 'Parking' AND P.userID = $userid");

		$GLOBALS['rentBill'] = get($link, "SELECT SUM(BA.price) AS RBILL FROM billing B 
			LEFT JOIN billing_amount BA ON BA.billingAmountID = B.billingAmountID 
			WHERE BA.name = 'Rent' AND B.userID = $userid");
		$GLOBALS['parkingBill'] = get($link, "SELECT SUM(BA.price) AS PBILL FROM billing B 
			LEFT JOIN billing_amount BA ON BA.billingAmountID = B.billingAmountID 
			WHERE BA.name = 'Parking' AND B.userID = $userid");

		$rentPayments = 0;
		$parkingPayments = 0;

		if(isset($rentPayments['RPAY']))
			$rentPayments = $rentPayments['RPAY'];

		if(isset($parkingPayments['PPAY']))
			$parkingPayments = $parkingPayments['PPAY'];


		$GLOBALS['rentAmount'] = $rentBill['RBILL'] - $rentPayments;
		$GLOBALS['parkingAmount'] = $parkingBill['PBILL'] - $parkingPayments;
		
		$GLOBALS['paymentTypes'] = getResultSet($link, "SELECT name FROM billing_amount;");
		$GLOBALS['myCards'] = getResultSet($link, "SELECT C.userCardID, P.name, C.number FROM user_card C LEFT JOIN payment_type P ON C.paymentTypeID = P.paymentTypeID WHERE C.userID = $userid");
		$GLOBALS['billingInfo'] = getResultSet($link, $billingInfoQuery);
		$GLOBALS['cardtypes'] = getResultSet($link, "SELECT paymentTypeID, name FROM payment_type WHERE name <> 'Cash';");
		?>

<div id="pageTitle">
	<h2>Make Payment</h2>
</div>
<div id="paymentList">
<table>
	<tr>
		<td colspan="2"><h3>Select Bill From Billing List</h3></td>
	</tr>
</table>
<table>
	<tr>
		<td>Sort By:</td>
		<td><select id ="sortBy" onchange="reloadWithSort()"><option></option><option>All</option><?php foreach($paymentTypes as $payment){ echo '<option value="'.$payment['name'].'">'.$payment['name'].'</option>';}?></select></td>
	</tr>
</table>

<table border="0" id="paymentListTable" class="displayTable" >
	<tr>
		<td class="tableHeader">&nbsp;</td>
		<td class="tableHeader">Billing ID</td>
		<td class="tableHeader">Type</td>
		<td class="tableHeader">Due Date</td>
		<td class="tableHeader">Amount</td>
	</tr>
	<?php 
	$counter = 0; 
	if(count($billingInfo) > 0)
	{

		foreach($billingInfo as $billing)
			{ 
				$counter++;
				if($counter == 1)
				{
					if($billing['name'] == "Rent")
					{
						if($rentAmount != '')
						{
							echo '<tr><td><input id="billing" onchange="billChange()" name="billSelect" type="radio" value="'.$billing['billingID'].'" checked></td><td>'.$billing['billingID'].'</td> <td>'.$billing['name'].'</td> <td>'.$billing['billingDate'].'</td> <td>$'.$rentAmount.'</td></tr>';
						}
						else
						{
							echo '<tr><td><input id="billing" onchange="billChange()" name="billSelect" type="radio" value="'.$billing['billingID'].'" checked></td><td>'.$billing['billingID'].'</td> <td>'.$billing['name'].'</td> <td>'.$billing['billingDate'].'</td> <td>$0</td></tr>';
						}
					}
					else
					{
						if($parkingAmount != '')
						{
							echo '<tr><td><input id="billing" onchange="billChange()" name="billSelect" type="radio" value="'.$billing['billingID'].'" checked></td><td>'.$billing['billingID'].'</td> <td>'.$billing['name'].'</td> <td>'.$billing['billingDate'].'</td> <td>$'.$parkingAmount.'</td></tr>';
						}
						else
						{
							echo '<tr><td><input id="billing" onchange="billChange()" name="billSelect" type="radio" value="'.$billing['billingID'].'" checked></td><td>'.$billing['billingID'].'</td> <td>'.$billing['name'].'</td> <td>'.$billing['billingDate'].'</td> <td>$0</td></tr>';
						}
					}			
				}
				else
				{
					if($billing['name'] == "Rent")
					{
						if($rentAmount != '')
						{
							echo '<tr><td><input id="billing" onchange="billChange()" name="billSelect" type="radio" value="'.$billing['billingID'].'"></td><td>'.$billing['billingID'].'</td> <td>'.$billing['name'].'</td> <td>'.$billing['billingDate'].'</td> <td>$'.$rentAmount.'</td></tr>';
						}
						else
						{
							echo '<tr><td><input id="billing" onchange="billChange()" name="billSelect" type="radio" value="'.$billing['billingID'].'"></td><td>'.$billing['billingID'].'</td> <td>'.$billing['name'].'</td> <td>'.$billing['billingDate'].'</td> <td>$0</td></tr>';
						}
					}
					else
					{
						if($parkingAmount != '')
						{
							echo '<tr><td><input id="billing" onchange="billChange()" name="billSelect" type="radio" value="'.$billing['billingID'].'"></td><td>'.$billing['billingID'].'</td> <td>'.$billing['name'].'</td> <td>'.$billing['billingDate'].'</td> <td>$'.$parkingAmount.'</td></tr>';
						}
						else
						{
							echo '<tr><td><input id="billing" onchange="billChange()" name="billSelect" type="radio" value="'.$billing['billingID'].'"></td><td>'.$billing['billingID'].'</td> <td>'.$billing['name'].'</td> <td>'.$billing['billingDate'].'</td> <td>$0</td></tr>';
						}
					}
				}
			}
	}
	else
	{
		echo '<tr><td colspan="5">No active bills</td></tr>';
	}
	
	?>

</table>
</div>

<div id="submitPayment">
<table>
	<tr>
		<td colspan="2"><h3>Select Credit Card</h3></td>
	</tr>
	<tr>
		<td>Credit Card:</td>
		<td><select id="presetCard" name="presetCard" onchange="cardSelected()"><option value="-1"></option>
			<?php foreach($myCards as $cards)
			{
				$cardNum = "*****".substr($cards['number'], -4); 
				echo '<option value="'.$cards['userCardID'].'">'.$cards['name']." - ".$cardNum.'</option>';
			}
			?></select></td>
	</tr>
	<tr>
		<td>Amount</td>
		<td>$<input id="enterAmount" type="number" min="0.01" step="0.01" onchange="amountChange()"></input></td>
	</tr>
</table>

</div>

<div id="addCard">
<table>
	<tr>
		<td colspan="2"><h3>Add New Card</h3></td>
	</tr>

	<tr>
		<td colspan="2">Card Type <select id="addCardType">
			<?php 
				foreach ($cardtypes as $company) 
				{
					echo '<option value="'.$company['paymentTypeID'].'"">'.$company['name'].'</option>';
				}
			?>
		</select></td>
	</tr>
	<tr id="enterCard2">
		<td>Name on card:</td>
	</tr>
	<tr>
		<td class="paymentRow"><input id="cardName" onkeyup="this.value=this.value.replace(/[^a-zA-Z\s]/,'')" type="text" maxlength="25" size="25"></input></td>
	</tr>
	<tr id="enterCard3">
		<td>Card number:</td>
	</tr>
	<tr>		
		<td class="paymentRow"><input id="cardNum" onkeyup="this.value=this.value.replace(/[^\d]/,'')" type="text" maxlength="16" size="16"></input></td>
	</tr>
	<tr id="enterCard4">
		<td>CVC</td>
	</tr>
	<tr>
		<td class="paymentRow"><input id="cardCvc" onkeyup="this.value=this.value.replace(/[^\d]/,'')" type="text" maxlength="3" size="3"></input></td>
	</tr>
	<tr>
		<td>Exp. Date</td>
	</tr>
	<tr id="enterCard5">
		<td class="paymentRow"><select id="expMonth">
			<?php 
				for($i = 1; $i <= 12; $i++)
					{ 
						echo '<option>'.sprintf("%02s",$i).'</option>';
					}?></select>/<select id="expYear">
					<?php 
					if(date('m') == 12)
						$i = date(('Y'),strtotime("+1 year"));
					else
						$i = date('Y');

					for($i; $i < date('Y')+6; $i++){ echo '<option>'.$i.'</option>';}?></select></td>
	</tr>
	<tr>
		<td><label id="addCardError"></label><td>
	</tr>
</table>
<button type="button" onclick="addCard()">Add Card</button>
</div>

<div id="confirmPayment">
<table border="0" class="displayTable" id="confirmTable">
	<tr>
		<td colspan="2" class="tableHeader">Confirm Payment</td>
	</tr>
	<tr>
		<td class="tableHeader">Bill ID</td>
		<td><label class="confirmCardInfo" id="billID"><i>
			<?php  if(count($billingInfo)>0)
					{
						echo $billingInfo[0]['billingID'];
					}

						 ?></i></label></td>
	</tr>
	<tr>
		<td class="tableHeader">Card Type</td>
		<td><label class="confirmCardInfo" id="cardType" name="cardType"><i>Please select a card</i></label></td>
	</tr>
	<tr>
		<td class="tableHeader">Name on card</td>
		<td><label class="confirmCardInfo" id="nameOnCard" name="nameOnCard"><i>Please select a card</i></label></td>
	</tr>
	<tr>
		<td class="tableHeader">Credit Card #</td>
		<td><label class="confirmCardInfo" id="cardNumber" name="cardNumber"><i>Please select a card</i></label></td>
	</tr>
	<tr>
		<td class="tableHeader">CVC</td>
		<td><label class="confirmCardInfo" id="cvc" name="cvc"><i>Please select a card</i></label></td>
	</tr>
	<tr>
		<td class="tableHeader">Exp.</td>
		<td><label class="confirmCardInfo" id="exp" name="exp"><i>Please select a card</i></label></td>
	</tr>
	<tr>
		<td class="tableHeader">Amount</td>
		<td><label class="confirmCardInfo" id="amount" name="exp"><i>Please enter an amount</i></label></td>
	</tr>
	<tr>
		<td class="tableHeader">Payment For</td>
		<td><label class="confirmCardInfo"><i>
			<?php  
				if(count($billingInfo) > 0)
				{
					echo $billingInfo[0]['name'];
				}
			?></i></label></td>
	</tr>
	<tr>
		<td class="tableHeader">For Month</td>
		<td><label class="confirmCardInfo"><i>
			<?php  
				if(count($billingInfo) > 0)
				{
					echo date("F", strtotime($billingInfo[0]['billingDate']));
				}
			 ?></i></label></td>
	</tr>
</table>
<button type="button" onclick="submitPayment()">Submit payment</button>
</div>
	<script text="text/javascript">

		document.getElementById("presetCard").selectedIndex = -1;

	</script>
</body>
</html>
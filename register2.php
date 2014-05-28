<?php
require_once("functions.php");
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


$userid = $_SESSION['user_id'];
$message = "";



function registerPart2($building, $suite, $parking)
{
	global $userid;
	$result = true;
	
	$sql = "INSERT INTO user_building VALUES ('$building','$userid')";
	$result = queryMysql($sql);
	
	if($result) {
		$sql = "UPDATE user_spot SET suite = '$suite' WHERE userid = '$userid'";
		$result = queryMysql($sql);
	}
	
	if($result) {
		$sql = "INSERT INTO parking_spot VALUES ('$parking','$userid','1','1','ABC321','2014-11-07','0')";
		//$result = queryMysql($sql);
	}
}

if(isset($_POST['buildingSelect'])  && isset($_POST['suiteSelect']) && isset($_POST['parkingSelect'])) {
	
	//$message = "building: ".$_POST['buildingSelect']." suite: ".$_POST['suiteSelect']." parking: ".$_POST['parkingSelect']." userid: ".$userid;
	
	registerPart2($_POST['buildingSelect'], $_POST['suiteSelect'], $_POST['parkingSelect']);
	
	//header("Location: confirmRegistration.php");
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Register</title>
<link href="css/main_styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>	
	<script text="text/javascript">
function buildingChanged()
{
	var buildingSelected = document.getElementById('buildingSelect');
	        console.log(buildingSelected.options[buildingSelected.selectedIndex].value);

	$.ajax({                                      
      url: 'getUnits.php?id='+buildingSelected.options[buildingSelected.selectedIndex].value,                   
      data: "",                        		                                       
      dataType: 'json',                      
      success: function(data) {  
        var units = "<option></option>";
        var spots = "<option></option>";

        $.each(data,function(index,item){
		       units += "<option>" + item.suite + "</option>";

           if(item.lotID !== undefined)
        		spots += "<option name='"+item.lotID+"' value='"+item.spotID+"'>Lot -" + item.lotID + " Spot -" + item.spotID + "</option>";
		   });

        $('#suiteSelect').html(units);
       	$('#parkingSelect').html(spots);
      } 
    });
}

function register()
{
    var userID = document.getElementById('userid');
    var building = document.getElementById('buildingSelect');
    var spot = document.getElementById('parkingSelect');
    var suite = document.getElementById('suiteSelect');
    var license = document.getElementById('license');
    var state = document.getElementById('stateSelect');
   /*console.log("USER ID " +userID.value);
    console.log("Building " + building.options[building.selectedIndex].value);
    console.log("SPOT " + spot.options[spot.selectedIndex].value);
    console.log("LOT " + spot.options[spot.selectedIndex].getAttribute("name"));
    console.log("Suite " + suite.options[suite.selectedIndex].value);
    console.log("State " + state.options[state.selectedIndex].value);
    console.log("License " + license.value);*/

    if(spot.selectedIndex == 0 || building.selectedIndex == 0 || suite.selectedIndex == 0)
    {
  
      $('#errorMsg').html('ERROR - Please select a Building, Parking Spot, and Suite');
      $('#errorMsg').css('color','red');

      if(license.value.length < 4)
        $('#errorMsg').append('<br /> ERROR - Invalid License Plate #');
    }
    else
    {
        if(license.value.length > 4)
        {      
          xmlhttp=new XMLHttpRequest();
          xmlhttp.onreadystatechange=function()
            {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
              {
                window.open("tenantprofile.php","_self");
              }
            }

          xmlhttp.open("GET","registerParkingSuiteBld.php?id="+ userID.value +
            "&building=" + building.options[building.selectedIndex].value +
            "&state=" + state.options[state.selectedIndex].value +
            "&license=" + license.value +
            "&spot=" + spot.options[spot.selectedIndex].value +
            "&lot=" + spot.options[spot.selectedIndex].getAttribute("name") +
            "&suite=" + suite.options[suite.selectedIndex].value
            ,true);
          xmlhttp.send();
        }
        else
        {
          $('#errorMsg').html('ERROR - Invalid License Plate #');
          $('#errorMsg').css('color','red');
        }
    }

}
</script>
</head>
<body>

	<?php
		$GLOBALS['buildings'] = getResultSet($link, "SELECT buildingID, name FROM building;");
		$GLOBALS['buildingCount'] = array();
	?>

	<div id="container">
    	<div id="header">
        	<?php require_once("navigation.php"); ?>
        </div><!-- END header -->
        
        <input type="hidden" id="userid" value="<?php echo $userid; ?>">

        <div id="content">
        	<h1 id="registrationHeader">Property Management Registration</h1>

        	<div id="wrapRegister2">
            <br />
            <label id="errorMsg"></label>
            <br />
        		<label>Building</label>
        		<select id="buildingSelect" name="buildingSelect" onchange="buildingChanged()">
        			<option></option>
  						<?php
  						foreach ($buildings as $building) 
  						{
  							$buildingID = $building['buildingID'];
  							$count = get($link, "SELECT COUNT(suite) as COUNT FROM building_suite WHERE userID IS NULL AND buildingID = $buildingID");

  							if($count['COUNT'] > 0)
  								echo "<option value='".$building['buildingID']."'>".$building['name']."</option>";					
  						}
  						?>
            	</select>

              	<label>Suite</label>
        		<select id="suiteSelect" name="suiteSelect">
        			<?php
  						/*foreach ($availableUnits as $unit) 
  						{
  							echo "<option value='".$unit['suite']."'>".$unit['suite']."</option>";					
  						}*/
  					?>
  				</select>

                <label>Parking Spot</label>
        		<select id="parkingSelect" name="parkingSelect">
  						<?php
  						/*foreach ($availableSpots as $spot) 
  						{
  							echo "<option value='".$spot['spotID']."'>Lot -".$spot['lotID']." Spot -".$spot['spotID']."</option>";					
  						}*/
  						?>
              	</select><br/>

                <br />
                <label>License #:</label>
                <input type="text" id="license"></input>
                <select id="stateSelect">
                  <?php
                  for($i = 0; $i < count($stateList); $i++)
                  {
                      echo "<option value=$stateList[$i]> $stateList[$i] </option>";
                  }
                  ?>
                </select>
                <br />
                <button type="button" value="Register" id="register2Submit" onclick="register()">Go</button><br/>
                <span id="r2Message"><?php if($message != "") {echo $message;} ?></span>
            </div>
                        
        </div><!-- END content -->
    	
        <div id="footer">
            <?php require_once("footer.php"); ?>
        </div><!-- END footer -->
    </div><!-- END container -->

<!--<script src="javascript/jquery-1.10.2.js"></script>  -->
<script src="javascript/access_control_scripts.js"></script>
<!--<script src="javascript/register2.js"></script>-->
</body>
</html>
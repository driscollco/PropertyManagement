<?php require_once("functions.php"); ?>

<html>
<head>
		<link href="css/tenant_maintenance_styles.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script language="javascript" type="text/javascript">
    var selectedReport;
    function submitNewReport()
    {
    	var building = document.getElementById('newReportBuilding');
    	var problem = document.getElementById('newReportProblem');
    	var comment = document.getElementById('newReportComment');

    	console.log(building.options[building.selectedIndex].value);
    	console.log(problem.options[problem.selectedIndex].value);
    	console.log($('#newReportComment').text());
    }

    function newReport()
    {
    	if(document.getElementById('reportRadio').checked)
    	{
    		document.getElementById('fileNewReport').style.display = 'block';
    		document.getElementById('reportFeedback').style.display = 'none';

    	}
    	else
    	{
    		document.getElementById('fileNewReport').style.display = 'none';
    		document.getElementById('reportFeedback').style.display = 'block';
    		selectedReport = $('input[name=reportType]:checked').attr('id');
    	}
    }

    function submitNewReport()
    {
    	var buildingID = document.getElementById('newReportBuilding');
    	var suite = document.getElementById('newReportSuite');
    	var problem = document.getElementById('newReportProblem');
    	var comment = document.getElementById('abc').value;
    	var userID = document.getElementById('userID').value;
    	console.log(buildingID.options[buildingID.selectedIndex].value);
    	console.log(suite.options[suite.selectedIndex].value);
    	console.log(problem.options[problem.selectedIndex].value);
    	console.log(userID);
    	console.log(comment);
    	
    	if(comment)
    	{
			xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    	window.open("tenantmaintenances.php","_self");
			    }
			  }

			xmlhttp.open("GET","fileMaintenanceReport.php?building="+ buildingID.options[buildingID.selectedIndex].value +
				"&suite=" + suite.options[suite.selectedIndex].value +
				"&comment=" + comment +
				"&user=" + userID +
				"&problem=" + problem.options[problem.selectedIndex].value
				,true);
			xmlhttp.send();


    	}
    	else
    	{
    		alert('empty');
    	}

    }

    function submitFeedback()
    {
    	var feedback = document.getElementById('feedbackComment').value;

    	if(feedback)
    	{
			xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    	window.open("tenantmaintenances.php","_self");
			    }
			  }

			xmlhttp.open("GET","submitFeedback.php?feedback="+ feedback +
				"&report=" + selectedReport
				,true);
			xmlhttp.send();


    	}
    	else
    	{
    		alert('empty');
    	}

    }

    function deleteMaintenance(element)
    {
    	var id = element.id;
    	xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
		    	window.open("tenantmaintenances.php","_self");
		    }
		  }

		xmlhttp.open("GET","deleteMaintenance.php?id="+ id
			,true);
		xmlhttp.send();
    }
	</script>



</head>
<body>

<div id="header">
    <?php require_once("showRegistered.php"); ?>
</div>
<input type="hidden" id="userID" value="<?php echo $userid;?>">

<?php
	require_once('db.php');
	$GLOBALS['buildings'] =	getResultSet($link, "SELECT name, buildingID FROM building;");
	$GLOBALS['maintenanceTypes'] =	getResultSet($link, "SELECT name, maintenanceID FROM maintenance;");
	$GLOBALS['reports'] = getResultSet($link,
		"SELECT B.name as BuildingName, MR.unit, MR.reportDate, M.name as MaintenanceName, MR.description, MS.statusName, MR.maintenanceReportID, MR.feedback
		FROM maintenance_report MR 
		LEFT JOIN building B ON B.buildingID = MR.buildingID 
		LEFT JOIN maintenance M ON M.maintenanceID = MR.maintenanceID 
		LEFT JOIN maintenance_status MS ON MS.maintenanceStatusID = MR.maintenanceStatusID 
		WHERE MR.userID = $userid
		ORDER BY MR.maintenanceReportID DESC");
	$GLOBALS['suites'] = getResultSet($link, "SELECT suite FROM users WHERE userID = $userid");
?>




<div id="pageTitle">
	<h2>Maintenance Reports</h2>
</div>

<div id="filedMaintenanceReports">
<h3>Filed Maintenance Reports</h3>

<table border="0" class="displayTable">
	<tr>
		<td class="tableHeader">&nbsp;</td>
		<td class="tableHeader">Report</td>
		<td class="tableHeader">Building</td>
		<td class="tableHeader">Suite</td>
		<td class="tableHeader">Date</td>
		<td class="tableHeader">Problem</td>
		<td class="tableHeader">Description</td>
		<td class="tableHeader">Feedback</td>
		<td class="tableHeader">Status</td>
		<td class="tableHeader">&nbsp;</td>
	</tr>
	<?php
	foreach ($reports as $report) 
	{
		echo "<tr>";
		echo "<td><input type='radio' id='".$report['maintenanceReportID']."' name='reportType' onchange='newReport()'></input></td>";
		echo "<td>".$report['maintenanceReportID']."</td>";
		echo "<td>".$report['BuildingName']."</td>";
		echo "<td>".$report['unit']."</td>";
		echo "<td>".$report['reportDate']."</td>";
		echo "<td>".$report['MaintenanceName']."</td>";
		echo "<td>".$report['description']."</td>";
		echo "<td>".$report['feedback']."</td>";
		echo "<td>".$report['statusName']."</td>";
		echo "<td><img src='graphics/delete.png' id='".$report['maintenanceReportID']."' onclick='deleteMaintenance(this)' /></td>";
		echo "</tr>";
	}
	?>
	<tr>
		<td><input type="radio" id="reportRadio" name="reportType" onchange="newReport()" checked="checked"></input></td>
		<td colspan="8">File New Report</td>
	</tr>
</table>

	<div id="fileNewReport">
	<h3>File new report</h3>
<table>
	<tr>
		<td>Building 
			<select id="newReportBuilding">
				<?php
				foreach($buildings as $building)
				{
					echo "<option value='".$building['buildingID']."'>".$building['name']."</option>";
				}
				?>

			</select></td>
		<td class="reportRow">Suite <select id="newReportSuite">
			<?php
			foreach ($suites as $suite) 
			{
				echo "<option value='".$suite['suite']."'>".$suite['suite']."</option>";
			}
			?>

		</select></td>
	</tr>
	<tr>
		<td class="reportRow">Problem <select id="newReportProblem">
				<?php
					foreach($maintenanceTypes as $maintenanceType)
					{
						echo "<option value='".$maintenanceType['maintenanceID']."'>".$maintenanceType['name']."</option>";
					}
				?>
		</select></td>
	</tr>
	<tr>
		<td colspan="2">Comment</td>
	</tr>
	<tr>
		<td class="reportRow" colspan="2" rows="10" cols="50"><textarea id="abc"></textarea></td>
	</tr>
	<tr>
		<td><button type="button" onclick="submitNewReport()">Submit</button></td>
		<td>&nbsp;</td>
	</tr>
</table>
</div>
<div id="reportFeedback">
<h3>Feedback</h3>

<table>
	<tr>
		<td>Comments:</td>
	</tr>
	<tr>
		<td class="reportRow"><textarea rows="10" cols="50" id="feedbackComment"></textarea></td>
	</tr>
</table>

<table>
	<tr>
		<td><button type="button" onclick="submitFeedback()">Submit Feedback</button></td>
	</tr>
</table>
	</div>
</div>

</body>
</html>
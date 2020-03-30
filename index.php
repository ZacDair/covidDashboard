
<!DOCTYPE html>
<html lang="en">
<head>
    <title>COVID 19 Live Dashboard</title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="A live dashboard showing the most recent statistics around the Covid19/Coronavirus outbreak."/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
 <!-- <span class="w3-bar-item w3-right">Logo</span> -->
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s8 w3-bar">
      <span>Welcome</span><br>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Coronavirus Overview</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-dashboard"></i> Live Dashboard</a>
   <!-- <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-eye fa-fw"></i>  FAQ</a> -->
  </div>
</nav>
<style>
.tHead{
	position:sticky;
	top:0;
	background-color: #f1f1f1!important;
	z-index: 5;
}
</style>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5 id="lastUpdated"><b><i class="fa fa-dashboard"></i> Live Dashboard</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"></div>
        <div class="w3-right">
          <h3 id="totalCases"></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total Cases</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"></div>
        <div class="w3-right">
          <h3 id="recoveredCount"></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total Recovered Cases</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-text-white w3-padding-16">
        <div class="w3-left"></div>
        <div class="w3-right">
          <h3 id="deathCount"></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total Deaths</h4>
    </div>
  </div>
  <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"></div>
        <div class="w3-right">
          <h3 id="activeInfected"></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total Active Infections</h4>
      </div>
    </div>
  </div>
  <div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-third">
       <!-- <h5>Region Heatmap coming soon...</h5> -->
        <!-- <img src="#" style="width:100%" alt="Heatmap"> -->
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Active Case Breakdown</h5>
    <p>Total Active Cases</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-green" style="width:100%" id="activeCaseBar"></div>
    </div>

    <p>Mild Cases</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-orange" style="width:0%" id="mildCaseBar"></div>
    </div>

    <p>Serious or Critical Cases</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-red" style="width:%" id="seriousCaseBar"></div>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Individual Country Statistics</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white" id="countryTable">
      	<tr>
        <td class="tHead">Country Name</td>
        <td class="tHead">Total Cases</td>
	<td class="tHead">Total Deaths</td>
	<td class="tHead">Total Recovered</td>
	<td class="tHead">Active Cases</td>
	<td class="tHead">Critical Cases</td>
	<td class="tHead">New Cases</td>
	<td class="tHead">New Deaths</td>
	<td class="tHead">Total Cases/1M Pop</td>
      	</tr>
      <tr></tr>
    </table><br>
  </div>
  <hr>
  <!-- Footer -->
  <footer class="w3-container w3-padding-16 w3-light-grey">
    <h4>More Info</h4>
    <p>Created By Zac Dair 11/03/2020</p>
    <p>Our figures are based on statistics from various sources such as United Nations Population Division, World Health Organization (WHO), Food and Agriculture Organization (FAO), International Monetary Fund (IMF), and World Bank.</p>
  </footer>

  <!-- End page content -->
</div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}

//Edit general stats
function updateTextGeneral(id, data){
	var element = document.getElementById(id);
	element.innerHTML = element.innerHTML+" "+data.toLocaleString();
}

//Populate Table
function insertIntoTable(id, var0, var1, var2, var3, var4, var5, var6, var7, var8){
	var tableRef = document.getElementById(id).getElementsByTagName('tbody')[0];
	var newRow   = tableRef.insertRow();
	var data = [var0, var1, var2, var3, var4, var5, var6, var7, var8];
	// Insert a cells
	var index = 0;
	for (x of data){
	    if(x === "???"){
		x = " ";
	    }
	    var newCell  = newRow.insertCell(index);
	    // Appened our values into the cell
	    var newText = document.createTextNode(x);
	    newCell.appendChild(newText);
	    index = index + 1;
	}
}

function updateTime(id, data){
	var element = document.getElementById(id);
	element.innerHTML = element.innerHTML+"&nbsp&nbsp Last Updated: "+data;
}

function updateStatBars(id, data){
	var element = document.getElementById(id);
	element.innerHTML = data.toLocaleString();

}

function updateSmallBars(id, total, data){
	var element = document.getElementById(id);
	var percentage = (data/total)*100;
	element.style.width = percentage+"%";
	element.innerHTML = data.toLocaleString()+"&nbsp&nbsp("+percentage.toLocaleString()+"%)"
}
</script>
<?php
require_once("db_connection.php");
$conn = OpenCon();

//Get General Data
$query = ("Select * From  generalData where uploadedTime = (select max(uploadedTime) from generalData where id = generalData.id) order by uploadedTime desc;");
$res = $conn->query($query);
if($res->num_rows < 1){
    echo "No Data found";
}
else{
    while($row = $res->fetch_assoc()){
        $totalCount = $row["totalCount"];
        $deathCount = $row["deathCount"];
        $recoveredCount = $row["recoveredCount"];
        $activeInfectedCount = $row["activeInfectedCount"];
        $mildCaseCount = $row["mildCaseCount"];
        $criticalCaseCount = $row["criticalCaseCount"];
        $uploadedTime = $row["uploadedTime"];
    }
    echo "<script>";
    echo "updateTextGeneral('totalCases', $totalCount);";
    echo "updateTextGeneral('deathCount', $deathCount);";
    echo "updateTextGeneral('recoveredCount', $recoveredCount);";
    echo "updateTextGeneral('activeInfected', $activeInfectedCount);";
    echo "updateTime('lastUpdated', '$uploadedTime');";
    echo "updateStatBars('activeCaseBar', $activeInfectedCount);";
    echo "updateSmallBars('mildCaseBar', $activeInfectedCount, $mildCaseCount);";
    echo "updateSmallBars('seriousCaseBar', $activeInfectedCount, $criticalCaseCount);"; 
    echo "</script>";
    echo "<p>Data last Updated: ".$uploadedTime."</p>";
}
$tableQuery = ("Select * from countryData where left(uploadedTime, 16) = (select max(left(uploadedTime, 16))as uploadedTime from countryData) order by left(uploadedTime,16) desc;");
$tableRes = $conn->query($tableQuery);
if($tableRes->num_rows < 1){
    echo "No Data found";
}
else{
    while($rows = $tableRes->fetch_assoc()){
	$var0 = $rows["countryName"];
	$var1 = $rows["totalCases"];
	$var2 = $rows["totalDeaths"];
	$var3 = $rows["totalRecovered"];
	$var4 = $rows["activeCases"];
	$var5 = $rows["seriousCases"];
	$var6 = $rows["newCases"];
 	$var7 = $rows["newDeaths"];
	$var8 = $rows["tot"];
	$uploadedTime = $rows["uploadedTime"];
	echo "<script>";
	echo "insertIntoTable('countryTable','$var0','$var1','$var2','$var3','$var4','$var5','$var6','$var7','$var8');";
	echo "</script>";
    }
}
closeCon($conn);
?>
</body>
</html>


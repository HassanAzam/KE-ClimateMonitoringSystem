<?php
session_start();
if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
}
else
{
?>
<?php
	$status = file_get_contents("url_to_get_status_script");
	$t = file_get_contents("url_to_get_threshold_Script");
	$threshold = array();
	$threshold = explode(",",$t);
	
	$pos = strpos($status,"->");
	$APIkey = "KY25YJRLZISG8HMV";
	$deviceName = "KFRL Node";
	$cid = "72632";
	
	
?>
<!DOCTYPE html>
<html>

	<head>
		<title>Climate Monitoring System</title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	
	
	
	<body>
		<div id="wrapper">
		
		<header>
		
		</header>
		
			<div id="list" class="l">
			
			<div class="h1">Select Device</div>
			
			<ul class="list">
				<a href="node1.php"><li class="orange">Node A</li></a>
				<a href="node2.php"><li class="blue">Node B</li></a>
				
				<br>
				<br>
				<br>
				
				<a href="logout.php"><li style="background-color:#333;">Logout</li></a>
			</ul>
			
			
			</div>
		
		
		
			<div id="cp" class="l">
			
				<div class="box" style="width:99%;">
				<h1 class="info blue"> Device Name : <?php echo $deviceName; ?> <span class="r">API Key : <span id="apikey"><?php echo $APIkey; ?></span></span></h1>
				
				
				</div>
			
				<div class="box" style="width:99%;">
				
				<div class="accordion" style="background-color:#f69513;">Graph</div>
					<div class="panel show" style="padding:0;">
				
					<iframe id='jail' class="graph" src="http://api.thingspeak.com/channels/<?php echo $cid; ?>/charts/1?width=780&height=250&results=10&dynamic=true&color=blue&yaxis=Temp%20%C2%B0C&xaxis=Time&title=Temperature" ></iframe>
					</br>
					<div id="graphbuttons">
					<button type="button" onclick="jail('http://api.thingspeak.com/channels/<?php echo $cid; ?>/charts/1?width=780&height=250&results=10&dynamic=true&color=Blue&yaxis=Temp%20%C2%B0C&xaxis=Time&title=Temperature')">Temperature</button>
					<button type="button" onclick="jail('http://api.thingspeak.com/channels/<?php echo $cid; ?>/charts/2?width=780&height=250&results=10&dynamic=true&color=Green&yaxis=Humid&xaxis=Time&title=Humidity')">Humidity</button>
					<button type="button" onclick="jail('http://api.thingspeak.com/channels/<?php echo $cid; ?>/charts/3?width=780&height=250&results=10&dynamic=true&color=Yellow&yaxis=LDR&xaxis=Time&title=Light%20Intensity')">Light Intensity</button>
					</div>
					
					</div>
				</div>
			
				<div class="box l">
				<div class="accordion" style="background-color:#1593d4;">Connected Devices</div>
					<div class="panel">
						<p>Following are the devices connected to node:</p>
						<ul id="devices">
							<li><div class="accordion" style="margin-bottom:0;">Buzzer</div>
								<div class="panel" style="">
									<p style="font-size:14px;">Buzzer will be switched on when Light Intensity value exceeds LDR threshold.</p>
									<!-- status table -->
									<table>
										<thead>
											<tr>
											  <th>Status</th>
											  <th id="device1-status"><?php echo substr($status,$pos+3,1) ; ?></th>
											  
											</tr>
										</thead>
										  <tbody>
											
											
										  </tbody>
										</table>
								</div>
							</li>
							
							
						</ul>
					</div>
				</div>
			
				
				<div class="box l" style="margin-left:10px;">
				<div class="accordion" style="background-color:#a3d637;">Threshold Settings</div>
					<div class="panel">
						<p>View or Change Threshold values for following properties : </p>
						
						
						
						<table>
										<thead>
											<tr>
											  <th>LDR Threshold</th>
											  <th id="device1-status"><?php echo $threshold[0]; ?></th>
											  
											</tr>
											<tr>
											  <th>Temperature Threshold</th>
											  <th id="device1-status"><?php echo $threshold[1]; ?></th>
											  
											</tr>
											<tr>
											  <th>Humidity Threshold</th>
											  <th id="device1-status"><?php echo $threshold[2]; ?></th>
											  
											</tr>
										</thead>
										  <tbody>
											
											
										  </tbody>
										</table>
						<!-- threshold change form -->
						
						<form action=thresholdscript.php method=get >

<input type="hidden" name="cid" value="<?php echo $cid; ?>">
<input type="hidden" name="page" value="node1.php">
<br>
LDR Threshold : <input type=range id=a name="ldr" value=350 min=0 max=700 onchange="updateLDRInput(this.value);">
=   <output id="ldr" name=ldr for=a></output>
<br>
Humidity Threshold : <input type=range id=b name="hum" value=45 min=15 max=75 onchange="updateHUMInput(this.value);">
=   <output id="hum" name=hum for=a></output>
<br>
Temperature Threshold : <input type=range id=c name="temp" value=26 min=15 max=50 onchange="updateTempInput(this.value);">
=   <output id="temp" name="temp" for=a></output>
<br>
<input type="submit" name="submit"/>
</form>
			<!-- threshold change form ends -->			
					</div>
				</div>
				
				<div class="clear">
				</div>
				
			
				<div class="box l">
				<div class="accordion">Recent Tweets</div>
					<div class="panel">
						<h6>We can also setup tweets for mobile notifications</h6>
					</div>
				</div>
			
				
			
			
			</div>
			
		
		</div>
		
		<script>
		function jail(loc) {
			document.getElementById('jail').src = loc;
		}
		
		/* Toggle between adding and removing the "active" and "show" classes when the user clicks on one of the "Section" buttons. The "active" class is used to add a background color to the current button when its belonging panel is open. The "show" class is used to open the specific accordion panel */
			var acc = document.getElementsByClassName("accordion");
			
			var i;

			for (i = 0; i < acc.length; i++) {
				acc[i].onclick = function(){
				console.log(acc[i]);
				this.classList.toggle("active");
				this.nextElementSibling.classList.toggle("show");
				}
			}
			
			/*
			Threshold form script
			*/
					
		
			document.getElementById('ldr').value = document.getElementById('a').value;
			document.getElementById('hum').value = document.getElementById('b').value;
			document.getElementById('temp').value = document.getElementById('c').value;
				
			function updateLDRInput(val) {
			  document.getElementById('ldr').value=val; 
			}
				
				function updateHUMInput(val) {
			  document.getElementById('hum').value=val; 
			}
				
				function updateTempInput(val) {
			  document.getElementById('temp').value=val; 
			} 

			
			/*
			function display(id,text)
			{
				document.getElementById(id).innerHTML = text;
			}
			
			function httpGetStatus(theUrl, display)
			{
				console.log("Hello");
				var xmlHttp = new XMLHttpRequest();
				xmlHttp.onreadystatechange = function() { 
					if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
						display("device1-status",xmlHttp.responseText);
				}
				xmlHttp.open("GET", theUrl, true); // true for asynchronous 
				xmlHttp.send(null);
			}
			
			httpGetStatus("url_to_get_status_script");*/
			
			
	</script>
	</body>

</html>
<?php
}
?>
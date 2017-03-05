<?php

include "conscript.php";

	$val = $_GET['ldr'];
	$Temp = $_GET['temp'];
	$Hum = $_GET['hum'];
	$channel_id = $_GET['cid'];
	$url = $_GET['page'];

$query = "UPDATE node_status SET ldr='$val',Temp='$Temp',Hum='$Hum' WHERE channel_id='$channel_id'";

	$q = "UPDATE node_info SET ldr_threshold='$val',temp_threshold='$Temp',hum_threshold='$Hum' WHERE channel_id='$channel_id'";


if ($conn->query($query) === TRUE )
	echo "Successsfully updated ldr thresh in node_status";
else
	echo "Error in ldr threshold in node_status<br> " . $conn->error;

if ($conn->query($q) === TRUE )
	echo "Successsfully updated ldr thresh in node_info";
else
	echo "Error in ldr threshold  in node_info <br> " . $conn->error;

$conn->close();

header('Location: ../climatedemo/'.$url);

?>
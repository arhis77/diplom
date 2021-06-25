<?php
	$str_get = $_GET["email"];
	
	 
	$mysqli = new mysqli('127.0.0.1', 'arhis77_bduction', 'VX6vm9zw', 'arhis77_bduction');
	 
	$arrChartData[] = array();
	 
	$sql = "SELECT first_name, last_name FROM `abduction` where id='$str_get' ";
	$res = $mysqli->query($sql) or trigger_error($mysqli->error."[$sql]");
	while($row = $res->fetch_assoc())
	{
	    $arrChartData[] = $row;
	}
	 
	foreach ( $arrChartData as $i=>$array )
	{
	    if ( $i>0)
	    {
	        echo $array['first_name'].$array['last_name'].'<br>';
	    }
	};
?>
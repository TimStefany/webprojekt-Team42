<?php
	include_once 'userdata.php';
	$db    = new PDO( $dsn, $dbuser, $dbpass, $option );
	$query = $db->prepare(
		"SELECT `topic_name` FROM `topics` WHERE 1");
	$query->execute();
	$arrData = array();
    while($row = $query->fetch())
    //$arrData[] = $row['topic_name'];
	//print_r($arrData);
	echo "'" . $row['topic_name']. "'" . "," . "\n";

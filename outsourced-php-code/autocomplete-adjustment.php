<?php
	/*###########################################################################################################
                Hier werden alle Topics aus der Datenbank geholt und in folgende Form gebracht:
	  'ActionScript',
      'AppleScript',
      'Asp',
            ###########################################################################################################*/
	include_once 'userdata.php';
	$db    = new PDO( $dsn, $dbuser, $dbpass, $option );
	$query = $db->prepare(
		"SELECT `topic_name` FROM `topics` WHERE 1" );
	$query->execute();
	$arrData = array();
	while ( $row = $query->fetch() )
	{
		echo "'" . $row['topic_name'] . "'" . "," . "\n";
	}
?>
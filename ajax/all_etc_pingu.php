<?php
	$location1 = $_SERVER['DOCUMENT_ROOT']. 'wp-content/wp-config.php';
	$location2 = $_SERVER['DOCUMENT_ROOT']. '/wp-config.php';
	if($location2 != '')
	{
		require_once ($location2);
	}
	elseif($location1 != '')
	{
		require_once ($location1);
	}
?>
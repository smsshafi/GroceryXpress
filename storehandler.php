<?php

include 'authheader.php';
include 'etc.php';
if (isset($_GET['edit']) && $_GET['edit'] == 1)
{
	foreach ($_POST as $key => $value)
	{
		if ($value=="undefined")
		{
			$_POST[$key] = "";
		}
	}
	$message = UpdateStore($_POST);
	$success = ($message == 1)? "1": "";
	$message = ($message == 1)? "Successfully updated store information.": $message;
	
	echo '<div id="cMessage">'.$message.'</div>';
	echo '<div id="cSuccess">'.$success.'</div>';
}

if (isset($_GET['get']) && $_GET['get'] == 1)
{
	if ($_POST['id'] != "")
	{
		$id = $_POST['id'];
		$data = GetStoreFromID($id);
		if (mysql_num_rows($data) == 0) 
		{
			echo '<div id="cMessage">Sorry, but we could not find this information in the database!</div>';
			echo '<div id="cSuccess"></div>';		
		}
		else
		{
			echo sqlrow2xml($data);
		}
	}
	else
	{
		echo '<div id="cMessage">Sorry, but an unexpected error occured. No ID was provided to query the database!</div>';
		echo '<div id="cSuccess"></div>';		
	}
}

if (isset($_GET['getlist']) && $_GET['getlist'] == 1)
{
	$stores = GetStores();
	echo '<option value="">Please select one...</option>';
	while ($row = mysql_fetch_assoc($stores))
	{
        //echo $row['id'];

		echo '<option value="'.$row['id'].'">'.GetStoreNameFromID($row['id']).' - '.GetStoreCityFromID($row['id']).' - '.GetStoreAddressFromID($row['id']).'</option>';
	} 
}

if (isset($_GET['delete']) && $_GET['delete'] == 1)
{
	if ($_POST['id'] != "")
	{
		$id = $_POST['id'];
		$message = DeleteStoreFromID($id);
		
		$success = ($message == 1)? "1": "";
		$message = ($message == 1)? "The store has been removed from the database.": $message;
		
		echo '<div id="cMessage">'.$message.'</div>';
		echo '<div id="cSuccess">'.$success.'</div>';
	}
	else
	{
		echo '<div id="cMessage">Sorry, but an unexpected error occured. No ID was provided to query the database!</div>';
		echo '<div id="cSuccess"></div>';		
	}
	
}

if (isset($_GET['add']) && $_GET['add'] == 1)
{

		if (array_key_exists('id', $_POST))
		{
			unset ($_POST['id']);
		}

		foreach ($_POST as $key => $value)
		{
			if ($value=="undefined")
			{
				$_POST[$key] = "";
			}
		}
		$message = (AddStore($_POST));
		$success = ($message == 1)? "1": "";
		$message = ($message == 1)? "The store has been successfully added.": $message;
		
		echo '<div id="cMessage">'.$message.'</div>';
		echo '<div id="cSuccess">'.$success.'</div>';

}


?>


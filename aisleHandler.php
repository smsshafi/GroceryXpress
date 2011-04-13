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
    $_POST['store_id'] = $_GET['store_id'];
	$message = UpdateAisle($_POST);
	$success = ($message == 1)? "1": "";
	$message = ($message == 1)? "Successfully updated aisle information.": $message;
	
	echo '<div id="cMessage">'.$message.'</div>';
	echo '<div id="cSuccess">'.$success.'</div>';
}

if (isset($_GET['get']) && $_GET['get'] == 1)
{
	if ($_POST['id'] != "")
	{
		$id = $_POST['id'];
		$courseData = GetAisleFromID($id);
		if (mysql_num_rows($courseData) == 0) 
		{
			echo '<div id="cMessage">Sorry, but we could not find this information in the database!</div>';
			echo '<div id="cSuccess"></div>';		
		}
		else
		{
			echo sqlrow2xml($courseData);
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
	$aisles = GetAislesFromStoreID($_GET['store_id']);
	echo '<option value="">Please select one...</option>';
	while ($row = mysql_fetch_assoc($aisles))
	{
		echo '<option value="'.$row['id'].'">'.$row['number']." - ". $row['name'].'</option>';
	} 
}

if (isset($_GET['delete']) && $_GET['delete'] == 1)
{
	if ($_POST['id'] != "")
	{
		$id = $_POST['id'];
		$message = DeleteAisleFromID($id);
		
		$success = ($message == 1)? "1": "";
		$message = ($message == 1)? "The aisle has been removed from the database.": $message;
		
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
	if ($_POST['name'] != "")
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
        $_POST['store_id'] = $_GET['store_id'];
		$message = (AddAisle($_POST));	
		$success = ($message == 1)? "1": "";
		$message = ($message == 1)? "The aisle has been successfully added.": $message;
		
		echo '<div id="cMessage">'.$message.'</div>';
		echo '<div id="cSuccess">'.$success.'</div>';
	}
	else
	{
		echo '<div id="cMessage">Sorry, but an unexpected error occured. No ID was provided to query the database!</div>';
		echo '<div id="cSuccess"></div>';
	}
}

?>



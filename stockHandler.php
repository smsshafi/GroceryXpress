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
	$message = UpdateStock($_POST);
	$success = ($message == 1)? "1": "";
	$message = ($message == 1)? "Successfully updated stock information.": $message;
	
	echo '<div id="cMessage">'.$message.'</div>';
	echo '<div id="cSuccess">'.$success.'</div>';
}

if (isset($_GET['get']) && $_GET['get'] == 1)
{
	if ($_POST['id'] != "")
	{
		$id = $_POST['id'];
		$data = GetStockFromID($id);
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
	$stocks = GetStockFromStoreID($_GET['store_id']);
	echo '<option value="">Please select one...</option>';
	while ($row = mysql_fetch_assoc($stocks))
	{
		echo '<option value="'.$row['id'].'">'.GetProductTitleFromID($row['product_id']).' - '.GetAisleNameFromID($row['aisle_id']).'</option>';
	} 
}

if (isset($_GET['delete']) && $_GET['delete'] == 1)
{
	if ($_POST['id'] != "")
	{
		$id = $_POST['id'];
		$message = DeleteStockFromID($id);
		
		$success = ($message == 1)? "1": "";
		$message = ($message == 1)? "The stock has been removed from the database.": $message;
		
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
	if ($_POST['product_id'] != "" || $_POST['aisle_id'] != "")
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
		$message = (AddStock($_POST));
		$success = ($message == 1)? "1": "";
		$message = ($message == 1)? "The product has been successfully added.": $message;
		
		echo '<div id="cMessage">'.$message.'</div>';
		echo '<div id="cSuccess">'.$success.'</div>';
	}
	else
	{
		echo '<div id="cMessage">Sorry, but an unexpected error occured. No ID was provided to query the database!</div>';
		echo '<div id="cSuccess"></div>';
	}
}

if (isset($_GET['updateimage']) && $_GET['updateimage'] == 1)
{
    $image_path = GetProductImageFromID($_GET['product_id']);
    echo '<img id="crudimage" class="crudimage" 
						src="'. $image_path .'" alt="No image available" style="border: solid"/>';
}


?>


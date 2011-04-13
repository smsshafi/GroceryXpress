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
    $products = json_decode($_POST['pickedproducts'], true);
	if (array_key_exists('pickedproducts', $_POST))
	{
		unset ($_POST['pickedproducts']);
	}
	$message = UpdateRecipe($_POST, $products['pickedproducts']);
	$success = ($message == 1)? "1": "";
	$message = ($message == 1)? "Successfully updated recipe information.": $message;
	
	echo '<div id="cMessage">'.$message.'</div>';
	echo '<div id="cSuccess">'.$success.'</div>';
}

if (isset($_GET['get']) && $_GET['get'] == 1)
{
	if ($_POST['id'] != "")
	{
		$id = $_POST['id'];
		$data = GetRecipeFromID($id);
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
	$recipes = GetRecipes();
	echo '<option value="">Please select one...</option>';
	while ($row = mysql_fetch_assoc($recipes))
	{
		echo '<option value="'.$row['id'].'">'.GetRecipeNameFromID($row['id']).'</option>';
	} 
}

if (isset($_GET['getrecipelist']) && $_GET['getrecipelist'] == 1)
{
    $recipeList = GetRecipeListFromID($_GET['recipe_id']);
	while ($row = mysql_fetch_assoc($recipeList))
	{
		echo '<option value="'.$row['product_id'].'">'.GetProductTitleFromID($row['product_id']).'</option>';
	}
}
if (isset($_GET['delete']) && $_GET['delete'] == 1)
{
	if ($_POST['id'] != "")
	{
		$id = $_POST['id'];
		$message = DeleteRecipeFromID($id);
		
		$success = ($message == 1)? "1": "";
		$message = ($message == 1)? "The recipe has been removed from the database.": $message;
		
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
        $products = json_decode($_POST['pickedproducts'], true);
        if (array_key_exists('pickedproducts', $_POST))
		{
			unset ($_POST['pickedproducts']);
		}
		$message = (AddRecipe($_POST, $products['pickedproducts']));
		$success = ($message == 1)? "1": "";
		$message = ($message == 1)? "The recipe has been successfully added.": $message;
		
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


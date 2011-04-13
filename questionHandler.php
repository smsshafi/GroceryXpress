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
	$_POST['set_id'] = $_GET['set_id'];
	$message = UpdateQuestion($_POST);
	$success = ($message == 1)? "1": "";
	$message = ($message == 1)? "Successfully updated question information.": $message;
	
	echo '<div id="cMessage">'.$message.'</div>';
	echo '<div id="cSuccess">'.$success.'</div>';
}

if (isset($_GET['get']) && $_GET['get'] == 1)
{
	if ($_POST['id'] != "")
	{
		$id = $_POST['id'];
		$data = GetQuestionFromID($id);
		if (mysql_num_rows($data) == 0) 
		{
			echo '<div id="cMessage">Sorry, but we could not find information pertaining to this question in the database.</div>';
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
	$id = GetFirstQuestionID($_GET['set_id']);
	echo '<option value="">Please select one...</option>';
	while ($id != 0)
	{
		$result = GetQuestionFromID($id);
		$row = mysql_fetch_assoc($result);
		echo '<option value="'.$row['id'].'">'.$row['questions'].'</option>';
		$id = GetNextQuestionID($id);
	}
}

if ($_GET['getlistdivs'] == 1)
{
	$id = GetFirstQuestionID($_GET['set_id']);
	$count = 1;
	while ($id != 0)
	{
		$result = GetQuestionFromID($id);
		$row = mysql_fetch_assoc($result);
		echo '		<div class="questionBox">
					<div class="questionNumber">'.$count.'</div>
					<div class="questionText">'.$row['questions'].'</div>
					<div class="updownright">
						<button id="up_'.$row['id'].'" class="btnmakeover btnup btnstandalone"></button>
						<button id="down_'.$row['id'].'"class="btnmakeover btndown btnstandalone"></button>
					</div>
					<div class="clearboth"></div>
				</div>';
		$id = GetNextQuestionID($id);
		$count++;
	}
}

if (isset($_GET['promote']) && $_GET['promote'] == 1)
{
	PromoteQuestion($_POST['id']);
}

if (isset($_GET['demote']) && $_GET['demote'] == 1)
{
	PromoteQuestion(GetNextQuestionID($_POST['id']));
}

if (isset($_GET['delete']) && $_GET['delete'] == 1)
{
	if ($_POST['id'] != "")
	{
		$id = $_POST['id'];
		$message = (DeleteQuestionFromID($id));	
		$success = ($message == 1)? "1": "";
		$message = ($message == 1)? "The question has been removed from the database.": $message;
		
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
	if ($_POST['questions'] != "")
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
		$_POST['set_id'] = $_GET['set_id'];
		$message = (AddQuestion($_POST));	
		$success = ($message == 1)? "1": "";
		$message = ($message == 1)? "The question has been successfully added.": $message;
		
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

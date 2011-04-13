<?php include 'authheader.php'; ?>

<?php
	$redirect = 0;
	include 'etc.php';
	$message = '';
	if ($_POST['questions'] != "")
	{
		if ($_POST['delete'] != "")
		{
			if (DeleteQuestion($_POST['questions']))
			{
				$message = 'Question deleted!';
			}
			else $message = 'Delete failed!';
		}
		
		if ($_POST['edit'] != "")
		{
			$redirect = 1;
		}
	}
?>

<html>
<head>
<title>Modify Questions</title>

<script src="common.js"></script>
<script type="text/javascript">

function ValidateAdd()
{
	if(CheckEmpty('questions'))
	{
		alert('You must enter a question.');
	}
	document.frm_add.submit();
}

<?php
	if ($redirect)
	{
		echo 'window.location = "/editcritique.php?qid='.$_POST['questions'].'";';
	}
	
?>

</script>
</head>
<body>

<form id="frm_delete" name="frm_delete" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table>
	<tr>
		<td>Please select a question:</td>
		<td>
			<select id="questions" name="questions">
			<?php
				$resultSet = GetQuestionResultSet();
				$count = 0;
				while ($row = mysql_fetch_assoc($resultSet))
				{					
					++$count;
			?>
					<option value="<?php echo $row['id']; ?>"><?php echo $count.' - '.$row['questions']; ?></option>
			<?php
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td>
		 	<input id="edit" name="edit" type="submit" value="Edit"/><br/><br/>
			<input id="delete" name="delete" type="submit" value="Delete"/>
		</td>
	</tr>
	<tr><td><?php echo $message; ?></td></tr>
</table>
</form>
<a href="./controlpanel.php">Back to Previous Page</a>
<?php include 'logoutform.php'; ?>

</body>
</html>

<?php include 'authheader.php'; ?>

<?php
	include 'etc.php';
	$message = '';
	
	if ($_POST['shown'] == "on") {$_POST['shown'] = "1";} else {$_POST['shown'] = "0";}
	
	if ($_GET['qid'] != "") $_POST['qid'] = $_GET['qid'];
	
	if ($_POST['questions'] != "" && $_POST['qid'] != "")
	{
		if(EditQuestion($_POST['qid'], $_POST['questions'], $_POST['type'], $_POST['shown']))
		{
			$message = 'Your question has been edited successfully.';
		}
		else
		{
			$message = 'Error editing data.';
		}
	}
	
	if ($_POST['qid'] != "")
	{
		$question = GetQuestionFromID($_POST['qid']);
		$type = GetQuestionTypeFromID($_POST['qid']);
		$shown = GetQuestionShownFromID($_POST['qid']);
	}
?>

<html>
<head>
<title>Edit Question</title>
</head>
<script src="common.js"></script>
<script type="text/javascript">

function ValidateEdit()
{
	if(CheckEmpty('questions'))
	{
		alert('You cannot have a blank field.');
	}
	document.frm_edit.submit();
}

</script>
<body>
<form id="frm_edit" name="frm_edit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" id="qid" name="qid" value="<?php echo $_POST['qid']; ?>"/>
<table>
	<tr>
		<td colspan="2"><?php echo $message; ?></td>
	</tr>
	<tr>
		<td>Question</td><td><input type="text" id="questions" name="questions" value="<?php echo $question; ?>" size="56"/></td>
	</tr>
	<tr>
		<td>Question Type</td>
		<td>
			<select id="type" name="type">
				<option value="m" <?php if($type == "m") echo ' selected = "selected" ' ;?>>Multiple Choice</option>
				<option value="d" <?php if($type == "d") echo ' selected = "selected" ' ;?>> Descriptive</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Shown</td>
		<td><input type="checkbox" id="shown" name="shown" <?php if ($shown == 1) echo ' checked = "Yes" '; ?>/></td>
	</tr>
	<tr><td colspan="2"><?php echo $message; ?></td></tr>
	<tr>
		<td><input type="button" id="update" name="update" value="Update" onClick="ValidateEdit()"/></td>
	</tr>
</table>
</form>
<a href="./editdeletecritique.php">Back to Previous Page</a>
<?php include 'logoutform.php'; ?>

</body>
</html>

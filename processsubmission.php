<?php include 'studentauthheader.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include 'etc.php'; ?>
<?php $page_title = 'Submission'; ?>
<?php echo $sDocType; ?>
<?php
	$result = ProcessSubmission($_POST, $_SESSION['uwid'], $_GET['crit_id']); 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $sCssFile.$sAllJs; ?>
		<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	</head>
	<body>
		<div class="content">
			<?php include 'uwheader.php';
			
				if ($result == 'success')
				{
					echo 'Your submission has successfuly been received. Thank you for taking the time to complete the critique.';
				}
				else
				{
					echo $result;
				}	
			?> 
			<?php include 'studentpreviousPage.php' ?>
		</div>
		<div id="responseContainer" class="hidden"></div> 
	</body>
</html>



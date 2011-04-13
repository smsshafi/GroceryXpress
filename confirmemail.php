<?php include_once 'etc.php'; ?>
<?php
    session_start();
    if (isset($_POST['email']) && $_POST['email'] != "")
    {
        $_GET['id'] = AddUser($_POST);
    }
	elseif (isset($_POST['confirm']) and $_POST['confirm'] != "") {
		$result = ActivateUser($_POST['confirm']);
		$error = false;
		if ($result) {
            $_SESSION['logintype'] = 'regular';
			$_SESSION['uwid'] = GetUserEmailFromID($result);
			$_SESSION['firstname'] = GetUserFirstNameFromID($result);
			$_SESSION['userid'] = $result;
			header("Location: ./useraccount.php");
        }
		else
        {
			$error = true;
        }
    }

?>
<?php include 'siteconfig.php'; ?>
<?php $page_title = 'Confirm E-mail Address'; ?>
<?php echo $sDocType; ?>

    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
    
	<?php echo $sCssFile.$sAllJs; ?>
	<script type="text/javascript">

		$(document).ready(function(){
            <?php
            if (isset($error) && $error) {
			?>
				showNotification("The confirmation code you entered is invalid. Please make	sure that you correctly copied it off the email that we sent you.", 0);
            <?php
            }
			?>
	
		})
	</script>
</head>

<body>
	<?php include('regularheader.php'); ?>
	<div class="content"> 
		<div class="fullcolumn">
			<h1>Confirmation Code</h1>
			<p>
			</p>
		
			<form id="frm_confirm" name="frm_confirm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<table class="formtable">
					<tr>
						<td colspan="4">To confirm that your email address is 
				valid, we have e-mailed you a confirmation code. Please check 
				your inbox and enter the 
				confirmation code into the box below to complete the sign up
				process.</td>
					</tr>
					<tr>
						<td><br/></td>
					</tr>
					<tr>
						<td>
							<label for="confirm">Confirmation Code: </label>
							<input type="text" name="confirm" 
							id="confirm"/>&nbsp;<input type="submit" 
							value="Continue" class="btnmakeover btnyes"/></td>
						<td></td>
						<td>
						</td>
					</tr>
					<tr>
						
					</tr>
				</table>
			</form>
		</div>
	</div>
</body>
</html>

<?php
	session_start();
	if (isset($_SESSION['uwid']) && $_SESSION['uwid'] != "" && $_SESSION['logintype'] == 'admin')
	{
		header('location: ./controlpanel.php');
	}
	
	if (isset($_SESSION['uwid']) && $_SESSION['uwid'] != "" && $_SESSION['logintype'] == 'student')
	{
		header('location: ./index.php');
	}
?>

<?php $page_title = 'Administrative Access'; ?>
<?php include 'siteconfig.php'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	<?php echo $sAdminCssFile.$sAllJs; ?>
	<script type="text/javascript">

		$(document).ready(function(){

			$("#log_in").click(function(event){
				event.preventDefault();
				var mandatoryFieldIds = new Array ("email", "password"); 
				if (CheckEmptyGroup(mandatoryFieldIds))
				{
					alert('You must fill up all mandatory fields.');
				}
				else
				{
					$.post('adminloginhandler.php?login=1',
					{
						email: $("#email").attr('value'),
						password: $("#password").attr('value')
					},
					function(response){
						if(response != "Success\n"){
							$("div.message").html(response);
							$("div.message").fadeIn("slow");
						}
						else
						{
							window.location = "./controlpanel.php";
						}
					})
				}
			})
		})
	</script>
</head>

<body>
	<div class="content">
	<?php include 'uwheader.php'; ?>
	<p class="pagetitle"><?php echo $page_title; ?></p>
	<form id="frm_login">
		<fieldset class="loginform">
			<legend>Log In</legend>
				<p>
					<label for="email">Email:</label><br/>
					<input style="width: 250px" type="text" id="email" name="email"/>
				</p>
				<p>
					<label for="password">Password:</label><br/>
					<input style="width: 250px" type="password" id="password" name="password"/>	
				</p>
			<input type="submit" id="log_in" class="btnlogin hugebutton btnmakeover" value="Log In"/>
		</fieldset>
	</form>
	<a href="index.php">Regular users click here</a>
	<div class="message errorMessage"></div>
	</div>
</body>
</html>

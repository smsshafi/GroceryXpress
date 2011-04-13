<?php include 'authheader.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php $page_title = 'Change Password'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $sAdminCssFile.$sAllJs; ?>
		<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
		<script type="text/javascript">
		
			$(document).ready(function(){

				$("#changepass").click(function(event){

					event.preventDefault();
					var mandatoryFieldIds = new Array ("oldpassword", "newpassword", "renewpassword"); 
					if (CheckEmptyGroup(mandatoryFieldIds))
					{
						alert('You must fill up all fields.');
					}
					else
					{
						$("div#message").fadeOut("slow", function(){
						$.post('changepasswordhandler.php?change=1',
						{
							oldpassword: $("#oldpassword").attr('value'),
							newpassword: $("#newpassword").attr('value'),
							renewpassword: $("#renewpassword").attr('value')
						},
						function(response){
							if(response != "Password has been successfully changed.\n\n"){
								$("div#message").html(response);
								$("div#message").fadeIn("slow");
								$("div#message").addClass("errorMessage");
							}
							else
							{
								$("div#message").removeClass("errorMessage");
								$("div#message").html(response);
								$("div#message").fadeIn("slow");
							}
						})
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
		<div class="changepassword centered">
			<form id="changePassword" name="changePassword">
				<p>
				<label for="oldpassword">Old Password:</label><br/>
				<input id="oldpassword" type="password"/>
				</p>
				<p>
				<label for="newpassword">New Password:</label><br/>
				<input id="newpassword" type="password"/>
				</p>
				<p>
				<label for="renewpassword">Retype New Password:</label><br/>
				<input id="renewpassword" type="password"/>
				</p>
				<input type="submit" id="changepass" class="btnchangepass btnmakeover" value="Change Password"/>
			</form>
			<p/>
			<div id="message" class="message"></div>
		</div>
		<?php include 'previousPage.php'; ?>
	</div>
	
	</body>
</html>




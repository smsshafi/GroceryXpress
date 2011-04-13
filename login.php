<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>
<?php
    session_start();
    if (isset($_SESSION['uwid']) && $_SESSION['uwid'] != "" && isset($_SESSION['logintype']) && $_SESSION['logintype'] == 'regular') {
        header("Location: ./storecatalog.php");
    }
    $error_msg = "";
    if (isset($_POST['email']) && $_POST['email'] != "" && isset($_POST['password']) && $_POST['password'] != "") {
        $response = AuthenticateRegularUser($_POST['email'], $_POST['password']);

        if ($response['error'] == false) {
            $_SESSION['logintype'] = 'regular';
			$_SESSION['uwid'] = $_POST['email'];
			$_SESSION['userid'] = GetUserIDFromEmail($_POST['email']);
            $_SESSION['firstname'] = GetUserFirstNameFromID($_SESSION['userid']);
            header("Location: ./storecatalog.php");
        }
    }
?>
<?php $page_title = 'Login'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	<?php echo $sCssFile.$sAllJs; ?>
	<script type="text/javascript">

		$(document).ready(function(){
            <?php
            if (isset($response['error']) && $response['error'] == true) {
                ?>
                    showNotification("<?php echo $response['message']; ?>", 0);
                    <?php

            }
            ?>
            $('#email').focus();
            $('#signup').click(function(){
                window.location = 'signup.php';
            })

            $('#login').click(function(event){
                $('.signuperrorbox').hide();
                event.preventDefault();
                if (CheckEmpty('email') || CheckEmpty('password')) {
                    showNotification("Please fill up the email and password fields.", 0);
                }
                else if(!IsValidEmail('email')) {
                    showNotification("Please enter a valid email address.", 0);
                }
                else {
                    $('#loginerrorbox').hide();
                    $('#frm_signin').submit();
                }

            })
    
		})
	</script>
</head>

<body>
	<?php include('regularheader.php'); ?>
	<div class="content"> 
		<div class="leftcolumn" style="height: 300px;">
			<h1>Existing User? Sign In</h1>
            <h2>Enter your credentials</h2>
			<form id="frm_signin" name="frm_signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<table class="formtable" style="margin-left: 18px; margin-right: 18px;">
					<tr>
						<td class="formlabel" style="text-align: left">E-mail:</td>
						<td style="width: 100%"><input style="width: 96%" id="email" name="email" type="text"/></td>
						
					</tr>
					<tr>
						<td class="formlabel" style="text-align: left">Password:</td>
						<td><input style="width: 96%" id="password" name="password" 
							type="password"/></td>
						
					</tr>
                    <tr>
                        
                        <td colspan="2">
						</td>
                        
                    </tr>
					


				</table>
        <p style="margin: 20px;">
        <input id="login" name="login" type="submit" 
						value="Log In" style="width: 360px; position: absolute; top: 200px;"/>
        </p>
			</form>
        
            <div id="loginerrorbox" class="signuperrorbox hidden" style="position: relative; float: none; width: auto; top: 0; padding: 10px;">
            </div>
		</div>
		<div class="rightcolumn" style="height: 300px; width: 398.5px;">
			<h1>New User? Sign Up</h1>
			<h2>Benefits of Signing Up</h2>
			<p>You get to do lots of cool stuff like create a shopping list from home and calculate your optimal walking path through the grocery store to minimize calories burnt during shopping.</p>
			<p><input type="button" name="signup" 
				id="signup" value="Sign up now!" style="width: 360px; position: absolute; top: 199.5px;"/></p>
		</div>
	</div>
</body>
</html>

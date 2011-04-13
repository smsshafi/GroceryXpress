	<div class="header">
		<?php
		if (isset($_SESSION['uwid']) && $_SESSION['uwid'] !="" && $_SESSION['logintype'] == 'admin')
		{
			$logoutId = 'logoutlink';
            $logoutLink = 'adminlogout.php';
        

		?>
			
		<div class="loginuser"><?php echo $_SESSION['uwid'].' | ';?>  <a href="<?php echo $logoutLink?>">Log Out</a></div>

		<?php
		}
		?>

		<!-- <div class="uwlogowrapper"><a target="_blank" 
        href="http://www.uwaterloo.ca"><img class="uwlogo" 
        src="images/UWlogo.gif" alt="UW logo"/></a></div>-->
		<div class="textheading"><img src="<?php echo $sLogoPath?>" alt="<?php echo $sTitle; 
            ?>"/></div>
	</div>

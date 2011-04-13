	<div class="header">
		<?php
		if (isset($_SESSION['uwid']) && $_SESSION['uwid'] !="")
		{
			$logoutId = (($_SESSION['logintype'] == 'admin')?'logoutlink':'');
			switch($_SESSION['logintype']) {
				case 'admin':
					$logoutLink = 'adminlogout.php';
					break;
				case 'student':
					$logoutLink = 'studentlogout.php';
					break;
				default:
					$logoutLink = '#';
			}

		?>
			

		<?php
		}
		?>

		<div class="uwlogowrapper"><a target="_blank" href="http://www.uwaterloo.ca"><img class="uwlogo" src="images/UWlogo.gif" alt="UW logo"/></a></div>
		<div class="textheading"><?php echo $sTitle; ?></div>
	</div>


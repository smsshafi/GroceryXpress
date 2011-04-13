<?php include 'notification.php'; ?>

<?php
$pages = array( "Home"              => array( "url" => "$sWebRoot/index.php",
                                              "secure" => false
                                              ),
                "Flyer"             => array( "url" => "$sWebRoot/flyer.php",
                                              "secure" => false
                                              ),
				"Recipes"           => array( "url" => "$sWebRoot/recipes.php",
                                              "secure" => false
                                              ),
                "Store Catalog"     => array( "url" => "$sWebRoot/storecatalog.php",
                                              "secure" => false
                                              ),
				"Contact Us"        => array( "url" => "$sWebRoot/contactus.php",
											  "secure" => false
                                              ),
                "Shopping List"     => array( "url" => "$sWebRoot/shoppinglist.php",
                                              "secure" => true
                                              )
				);
?>
<div class="header">
		<a href="<?php echo $sWebRoot; ?>">
			<img class="logo" src="<?php echo $sLogoPath; ?>" 
			alt="GroceryXpress" title="GroceryXpress"/>
		</a>
		<div class="metanav">
			<ul>
				<?php
					 if (isset($logged_in) && $logged_in) {
                ?>
				<li><a class="rightmenuitem" href="regularlogout.php">Sign Out</a></li>
				<li><a class="rightmenuitem" href="useraccount.php">My Account</a></li>
				<br/><li class="currentuser">Signed in as 
					<?php echo $_SESSION['firstname']; ?>
				</li>
				<?php
                     }
					 else
                     {
                ?>
				<li><a class="rightmenuitem" href="login.php">Sign In</a></li>
				<li><a class="rightmenuitem" href="signup.php">Register</a></li>
				<?php
                     }
                ?>
			</ul>
		</div>
		<ul class="topnav">
			<?php
				 foreach ($pages as $title => $info) {
					 if ($info['secure']) {
                         if (isset($logged_in) && $logged_in) {
							 
                             if (basename($_SERVER['PHP_SELF']) == basename($info['url'])) {
                                 echo '<li><a class="selectedtab" href="'.$info['url'].'">'.$title.'</a></li>';
                             }
							 else
                             {
                                 echo '<li><a href="'.$info['url'].'">'.$title.'</a></li>';
                             }
                         }
                     }
					 else
                     {
                         if (basename($_SERVER['PHP_SELF']) == basename($info['url'])) {
							 echo '<li><a class="selectedtab" href="'.$info['url'].'">'.$title.'</a></li>';
						 }
						 else
						 {
							 echo '<li><a href="'.$info['url'].'">'.$title.'</a></li>';
						 }
                     }
                 }
				 ?>
		</ul>
	</div>

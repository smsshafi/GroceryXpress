<?php include 'authheader.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include 'etc.php'; ?>
<?php $page_title = 'Control Panel'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $sAdminCssFile.$sAllJs; ?>
		<script type="text/javascript">
			$(document).ready(function(){

				$('#viewResults').click(function(){
					if ($('#masterDropDown').attr('value'))
					{
						window.location = 'viewresults.php?id=' + $('#masterDropDown').attr('value');
					}
				})
			})
			
		</script>
		<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	</head>
	<body>
		<div class="content">
			<?php include 'uwheader.php'; ?>
			<p class="pagetitle"><?php echo $page_title; ?></p>
			
			<?php if (IsAdmin($_SESSION['uwid']))
			{
			?>	
			<fieldset class="crud bigfield configure">
				<legend>Configure</legend>
				<p class="profoptionitem">
					<a href="addcategories.php">Categories</a>
				</p>
				<p class="profoptionitem">
				
					<a href="addsubcategories.php">Sub Categories</a>
				</p>
				<p class="profoptionitem">
					<a href="addproduct.php">Products</a>
				</p>
				<p class="profoptionitem">
					<a href="addrecipe.php">Recipes</a>
				</p>
				<p class="profoptionitem">
					<a href="addstores.php">Stores</a>
				</p>
				<p class="profoptionitem">
					<a href="pickstoreforaisles.php">Aisles</a>
				</p>
				<p class="profoptionitem">
					<a href="pickstoreforstocks.php">Stocks</a>
				</p>
			</fieldset>
			<?php
			}
			?>
			<br/>
			<fieldset class="crud bigfield configure">
				<legend>Personal Options</legend>
				<p class="profoptionitem">
					<a href="changepassword.php">Change Password</a>
				</p>
			</fieldset>
		</div>
		<div id="responseContainer" class="hidden"></div> 
	</body>
</html>

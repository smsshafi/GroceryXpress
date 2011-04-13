<?php include 'regularloginoptionalheader.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>

<?php $page_title = 'Recipes'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	<?php echo $sCssFile.$sAllJs; ?>
	<script type="text/javascript">
        <?php
            if (isset($logged_in) && $logged_in == true) {
		?>
                var user_id=<?php if (isset($_SESSION['userid']) && $_SESSION['userid'] != "") {echo $_SESSION['userid'];} ?>;
        <?php
            }
            ?>
	    $(document).ready(function(){
        })
	</script>
</head>

<body>
	<?php include('regularheader.php'); ?>
	<div class="content"> 
		
		<div class="fullcolumn">
			<div style="width: 25%; border-style: solid; border-width: 0px 1px 0px 0px; border-color: #B0B1BA; margin-bottom: -26px;">
				<h1>Categories</h1>
					<ul style="padding: 5px 5px 130px 9px; list-style-type: none">
					<?php
						 $result = GetRecipeCategories();
						 while ($row = mysql_fetch_assoc($result)) {
							 echo '<li style="padding-bottom: 10px"><a href="findrecipe.php?category='.urlencode($row['category']).'&amp;page=1">'.$row['category'].' ('.$row["count"].')</a></li>';
						 }
					?>
					</ul>
			</div>
			<div style="width: 600px; top: 0px; right: 0px; left: 200px; position: absolute; padding-bottom: 20px;">
				<h1>Find A Recipe</h1>
				<div style="padding-left: 10px;">
					<form id="frm_search" name="frm_search" method="GET" action="findrecipe.php">
						<label for="search"></label>
						 <input type="text" name="search" 
						id="search" style="width: 300px;"/> <input type="submit"
						id="do_search"
						value="Find"/> <br/><i>Example: Skillet Salmon</i>
						<input class="hidden" name="page" id="page" type="text" 
						value="1"/>
					</form>	
				</div>
				
			</div>
			<div class="featuredrecipes">
				<h1>Featured Recipes</h1>

				<?php
                    $result = GetFeaturedRecipes(1);
                     
					$context = "featuredrecipes";
					include 'recipelist.php';
                ?>
				
			</div>
		</div> 
	</div> 
</body>
</html>

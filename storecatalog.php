<?php include 'regularloginoptionalheader.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>

<?php $page_title = 'Store Catalog'; ?>
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
	<?php include('message.php');?>
	<?php include('regularheader.php'); ?>
	<div class="content"> 
		
		<div class="fullcolumn" style="padding-bottom: 0px;">
			<div style="width: 25%; border-right: 1px solid;">
				<h1>Categories</h1>
					<ul style="padding: 5px 5px 26px 9px; height: 590px;">
					<?php
						 $result = GetCategories();
						 while ($row = mysql_fetch_assoc($result)) {
							 echo '<li style="padding-bottom: 13px; list-style-type: none;"><a href="findproduct.php?category='.urlencode($row['name']).'&amp;page=1">'.$row['name'].' ('.$row["count"].') </a></li>';
						 }
					?>
					</ul>
			</div>
			<div style="width: 600px; top: 0px; right: 0px; left: 200px; position: absolute; padding-bottom: 20px;">
				<h1>Find A Product</h1>
				<div style="padding: 10px;">
					<form id="frm_search" name="frm_search" method="GET" action="findproduct.php">
						<label for="search"></label>
						 <input type="text" name="search" 
						id="search" style="width: 300px;"/> <input type="submit"
						id="do_search"
						value="Find"/> <br/><i>Example: Butter</i>
						<input class="hidden" name="page" id="page" type="text" 
						value="1"/>
					</form>	
				</div>
			</div>
			<div class="featuredproducts">
				<h1>Featured Products</h1>
				<?php
					 if (isset($_SESSION['userid']) && $_SESSION['userid'] != "") {
                         $result = GetFeaturedProducts(4, $logged_in, $_SESSION['userid']);
                     }
					 else
                     {
						 $result = GetFeaturedProducts(4);
                     }
					 $context = "featuredproducts";
					 include 'productlist.php';
                ?>
                </div>
            </div> 
        </div> 
    </body>
</html>

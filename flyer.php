<?php include 'regularloginoptionalheader.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>

<?php $page_title = 'Flyer'; ?>
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
		
		<div class="fullcolumn" style="padding-bottom: 10px;">
			
			<div class="">
				<h1>Flyer</h1>
				<?php
					 if (isset($_SESSION['userid']) && $_SESSION['userid'] != "") {
                         $result = GetFeaturedProducts(8, $logged_in, $_SESSION['userid']);
                     }
					 else
                     {
						 $result = GetFeaturedProducts(8);
                     }
					 $context = "featuredproducts";
					 include 'flyerlist.php';
                ?>
                </div>
            </div> 
        </div> 
    </body>
</html>

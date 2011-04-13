<?php include 'regularloginoptionalheader.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>

<?php
	 if (!isset($_GET['id']) || $_GET['id'] == "") {
		 header("location: ./recipes.php");
     }

	 $recipe_row = GetRecipeFromID($_GET['id']);
	 if (mysql_num_rows($recipe_row) == 0) {
         header("location: ./recipes.php");
     }
	 $recipe_data = mysql_fetch_assoc($recipe_row);
 ?>

<?php $page_title = $recipe_data['name']; ?>
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
        $(document).ready(function(){
        	if (($('td[class="tdadd"]').length) == 0) {
                $('#remove_recipe').show();
        		$('#add_recipe').hide();
                }

        	$('#add_recipe').click(function(){
                $("td[class='tdupdate'] .slincrement").click();
                $("td[class='tdadd'] .sladd").click();
        		$('#remove_recipe').show();
        		$('#add_recipe').hide();
                })
        
        	$('#remove_recipe').click(function(){
        		$("td[class='tdupdate'] .sldecrement").click();
                    $('#remove_recipe').hide();
        		$('#add_recipe').show();
                })
                                
        })
    <?php
        }
        else {
    ?>

    <?php    	
        }
    ?>
	    
	</script>
</head>

<body>
	<?php include('message.php'); ?>
	<?php include('regularheader.php'); ?>
	<div class="content"> 
		<div class="fullcolumn">
			
				<h1><?php echo $page_title; ?></h1>
			<div class="maindiv" style="padding-left: 40px; padding-right: 40px;">
				
				<table class="recipe_main" style="width: 100%">
					<tr>
						<td style="width: 35%;" rowspan="4"><img style="border: 2px solid"
						src="<?php echo $recipe_data['image']; ?>" alt="<?php 
						echo $recipe_data['name']; ?>"/></td>
						<td style="width: 65%"><b><?php echo 
						$recipe_data['name']; ?></b></td>
					</tr>
					<tr>
						
						<td>Category: <?php echo 
						$recipe_data['category']; ?></td>
					</tr>
					<tr>
						
						<td>Preparation Time: <?php echo 
						$recipe_data['prep_time']; ?></td>
					</tr>
					<tr>
						
						<td>Serves: <?php echo 
						$recipe_data['serves']; ?></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: justify"><?php echo 
						nl2br(htmlspecialchars($recipe_data['directions'])); ?></td>
					</tr>
				</table>
				<p>The following products are needed for this recipe: 
				<?php
				if ($logged_in) {
				?>	
				
					<input type="button" class="btnmakeover btnadd" value="Add Recipe to Cart" id="add_recipe" name="add_recipe"/>
					<input type="button" class="btnmakeover btndelete hidden" value="Remove Recipe from Cart" id="remove_recipe" name="remove_recipe"/>
				<?php
				} 
				?>
				</p>
				<?php
					 if ($logged_in) {
						 $result = GetProductsInRecipe($_GET['id'], $_SESSION['userid']);
					 }
					 else
                     {
                         $result = GetProductsInRecipe($_GET['id']);
                     }
					 
                     $context = "search";
                     include 'productlist.php';
				?>
			</div>		
			
			
		</div> 
	</div> 
</body>
</html>

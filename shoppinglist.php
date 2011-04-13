<?php include 'regularloginheader.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>

<?php $page_title = 'Shopping List'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	<?php echo $sCssFile.$sAllJs; ?>
	<script type="text/javascript">
        var user_id=<?php if (isset($_SESSION['userid']) && $_SESSION['userid'] != "") {echo $_SESSION['userid'];} ?>;

        function showAdd(selector) {
            var selectorid = selector.attr('id');
			var selectoridsplit = selectorid.split("_");
			var product_id = selectoridsplit[1];
			var divid = "div_"+product_id;
			$('#'+divid).slideUp(function(){
                $.post('shoppinglisthandler.php?shopping_list_count=1', {user_id: user_id}, function(response){
                             response_json = eval('(' + response + ')');
                             if (response_json.shopping_list_count == '0') {
                                 $('div#searchdiv').slideDown();
                                 $('.subtotaldiv').hide();
                             }
                        })
            });
            
        }

        function UpdateSubTotal() {
            $.post('shoppinglisthandler.php?updatesubtotal=1', {user_id: user_id}, function(response_json) {
                $('.subtotal').html(response_json.subtotal);
            }, "json");
        }
        
		$(document).ready(function(){
			$.post('shoppinglisthandler.php?shopping_list_count=1', {user_id: user_id}, function(response){
                response_json = eval('(' + response + ')');
                if (response_json.shopping_list_count == '0') {
                    $('.subtotaldiv').hide();
                }
           })

           $('.btncheck').click(function(){
        	   product_id = $(this).attr('id').split("_")[1];
        	   $('#slremove_' + product_id).click();
           })
		})
        
	</script>
</head>

<body>
	<?php include('message.php');?>
	<?php include('regularheader.php'); ?>
	<div class="content"> 
		<div class="fullcolumn">
			<h1><?php echo $page_title; ?></h1>
			<div class="subtotaldiv" style="padding-left: 10px;">
			<p>Subtotal: <span class="subtotal"><?php echo Currencize(GetSubTotal($_SESSION['userid'])); ?></span></p>
			</div>
			<?php
				$result = GetShoppingList($_SESSION['userid']);
				$hide_search = "";
				if (mysql_num_rows($result) != 0) {
                    $context = "search"; 
					$hide_search = "hidden";
                    include 'productlistcheck.php';
                }
				?>

				<div id="searchdiv" style="padding: 10px;" class="<?php echo 
				$hide_search; ?>">
					<p>Your shopping list is currently empty.</p>
					<form id="frm_search" name="frm_search" method="GET" action="findproduct.php">
						<label for="search"></label>
						 <input type="text" name="search" 
						id="search" style="width: 600px;"/> <input type="submit"
						id="do_search"
						value="Find"/> <br/><i>Example: Butter</i>
						<input class="hidden" name="page" id="page" type="text" 
						value="1"/>
					</form>	
				</div>
				<div class="subtotaldiv" style="padding-left: 10px;">
				<p>Subtotal: <span class="subtotal"><?php echo Currencize(GetSubTotal($_SESSION['userid'])); ?></span></p>
				</div>
			
			
		</div>
	</div>
</body>
</html>

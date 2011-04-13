<?php
	if (!isset($_GET['store_id']))
	{
		header("location: ./pickstoreforstock.php");
	}
?>
<?php include 'masteradminonly.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>
<?php $page_title = 'Modify Stocks'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $sAdminCssFile.$sAllJs; ?>
		<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
		<script type="text/javascript">
			
			function GenerateFormTableMapping( )
			{
				return {
					id: $('#masterDropDown').attr('value'),
					product_id: $('#xproduct_id').attr('value'), 
					aisle_id: $('#xaisle_id').attr('value'),
					aisle_position: $('#xaisle_position').attr('value') || '0',
					quantity: $('#xquantity').attr('value')
				};
			}

			function PopulateDropDowns()
			{
				PopulateProducts();
				PopulateAisles();
			}

			function PopulateProducts()
			{
				$('#xproduct_id').load('productHandler.php?getlist=1');
			}

            function PopulateAisles()
			{
				$('#xaisle_id').load('aisleHandler.php?getlist=1&store_id=<?php echo $_GET['store_id']; ?>');
			}

			function PopulateReturnURL(id)
			{
				if (!id)
				{
					id = $('#masterDropDown').attr('value'); 
				}
				
				$('#returnURL').attr('value', '<?php echo $_SERVER['PHP_SELF']; ?>' + '?id=' + id + '&store_id=<?php echo $_GET['store_id']; ?>');
			}

            function UpdateProductImage()
            {
				$('div.insidecrudleft').load('stockHandler.php?updateimage=1&product_id=' + $('#xproduct_id').attr('value'));
            }

            function ResetImage()
            {
				$('img#crudimage').attr('src', 'images/addstock.png');
            }
	
			$(document).ready(function(){
			
				PopulateDropDowns();
				var requestHandler = 'stockHandler.php';
				var mandatoryFieldIds = new Array('xproduct_id', 'xaisle_id');
				var currentEditRequest = "<?php if (isset($_GET['id'])) {echo $_GET['id'];}?>";
				var addRequest = "<?php if (isset($_GET['add'])) {echo $_GET['add'];}?>";
                var extrarequest = "&store_id=<?php echo $_GET['store_id']; ?>";

				$(document).ajaxStart(function(){
					AjaxStart();
				});

				$(document).ajaxSuccess(function(){
					AjaxSuccess();
				});

				$(document).ajaxError(function(){
					AjaxError();
				});

				RepopulateMasterDropDown(requestHandler, currentEditRequest, extrarequest);

				InitializeAdd();
				
				$('#masterDropDown').change(function () {
					MasterDropDownChange($(this).attr('value'), requestHandler, PopulateReturnURL, UpdateProductImage);
				})

				$('#edit').click(function(){
					GenericEdit(mandatoryFieldIds, requestHandler, null, extrarequest);
				})
				
				$('#delete').click(function(){
					$.blockUI({ message: $('#question'), css: { width: '275px' } });
				})

				$('#yes').click(function(){
					GenericDelete(requestHandler, extrarequest);
                    InitializeAdd();
                    ResetImage();
				})
		
				$('#no').click($.unblockUI);
				
				$('#showAdd').click(function(){
					InitializeAdd();
					ResetImage();
				})

				$('#add').click(function(){
					GenericAdd(mandatoryFieldIds, requestHandler, null, extrarequest);
                    ResetImage();
				})
			
				// Handles forwarding to other pages
				$('a.modify').click(function(event){
					event.preventDefault();
					if ($(this).siblings('select:first').attr('value'))
					{
						var id = $(this).siblings('select:first').attr('value');
						var url = $(this).attr('href');
						$('#frm_returnURL').attr('action', url + '?id=' + id);
						$('#frm_returnURL').submit();
					}
					else
					{
						window.location = $(this).attr('href') + '?add=1';
					}
				})

				if (currentEditRequest)
				{
					MasterDropDownChange(currentEditRequest, requestHandler, UpdateProductImage);  //pre-select requested value if started in edit mode
					PopulateReturnURL(currentEditRequest);
				}

				if (addRequest)
				{
					InitializeAdd();
				}

				$('#xproduct_id').change(function(){
					UpdateProductImage();
                })

                function ResetImage()
                {
    				$('img#crudimage').attr('src', 'images/addstocks.png');
    				$('#ximage').attr('value', '');
                }
                
			})
			
		</script>
	</head>
	<body>
	<div class="content">
		<?php include 'uwheader.php'; ?>
		<p class="pagetitle"><?php echo $page_title." for ".GetStoreNameFromID($_GET['store_id'])." at ".GetStoreAddressFromID($_GET['store_id']); ?></p>
		<form class="hidden" id="frm_returnURL" action="" method="post">
			<input type="text" id="returnURL" name="returnURL"/>
		</form>
		<form id="frm_editdelete">
			<fieldset class="crud">
				<legend>What would you like to do?</legend>
				<input type="button" id="showAdd" class="btnadd btnmakeover" 
				value="Add a new stock"/>
				<label for="masterDropDown">or modify an existing 
					stock:</label>
				<select id="masterDropDown" class="masterDropDown">
				</select>
			</fieldset>
			<div id="slidingInformation" class="nopadding">	
				<fieldset id="changer" class="crud">
					<legend>Stock Information</legend>
					<div class="insidecrudleft">
						<img id="crudimage" class="crudimage" 
						src="images/addstocks.png" alt="No image available" 
						style="border: solid"/>
					</div>
					<div class="insidecrudright">
						<p>
							<label for="xproduct_id">Product:</label><br/>
							<select id="xproduct_id" style="max-width: 390px">
							</select>
							<a class="modify" 
							href="addproduct.php">Add/Edit</a>
						</p>
						<p>
							<label for="xaisle_id">Aisle:</label><br/>
							<select id="xaisle_id">
							</select>
							<a class="modify" 
							href="addaisles.php">Add/Edit</a>
						</p>
						<p>
							<label for="xaisle_position">Position:</label><br/>
							<select id="xaisle_position">
								<option value=""></option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
							</select>
						</p>
						<p>	
							<label for="xquantity">Quantity:</label><br/>
							<input type="text" id="xquantity" name="xquantity"/>
						</p>
					</div>
					<div class="insidecrudbottom">
						<input type="button" id="add" class="btnadd btnmakeover" 
						value="Add this stock"/> <input type="button" 
						id="edit" class="btnedit btnmakeover" 
						value="Save Changes"/> <input type="button" id="delete" 
						class="btndelete btnmakeover" 
						value="Delete this stock"/>
						<div class="messageWrapper">
							<div href="#message" id="message" class="message"></div>
						</div>
					</div>
				</fieldset>
			</div>
			
			<div id="responseContainer" class="hidden"></div>

			<div id="question" class="hidden"> 
				<div class="dialogbox">Are you sure you want to delete this 
				stock?</div> <input type="button" id="yes" 
				class="btnyes btnmakeover" value="Yes" /> <input type="button" 
				id="no" class="btnno btnmakeover" value="No" /> 
			</div>
			<div id="hit" class="hidden"></div> 

		</form>
		<?php include 'previousPage.php'; ?>
	</div>
	
	</body>
</html>



<?php include 'masteradminonly.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php $page_title = 'Modify Products'; ?>
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
					title: $('#xtitle').attr('value'), 
					category_id: $('#xcategory_id').attr('value'), 
					subcategory_id: $('#xsubcategory_id').attr('value'),
					description: $('#xdescription').attr('value'),
					image: $('img#crudimage').attr('src'),
					price: $('#xprice').attr('value'),
					saleprice: $('#xsaleprice').attr('value')
				};
			}

			function PopulateDropDowns()
			{
				PopulateCategories();
				PopulateSubCategories();	
			}

			function PopulateCategories()
			{
				$('#xcategory_id').load('categoryHandler.php?getlist=1');
			}
			
			function PopulateSubCategories()
			{
				$('#xsubcategory_id').load('subcategoryHandler.php?getlist=1');
			}

			function PopulateReturnURL(id)
			{
				if (!id)
				{
					id = $('#masterDropDown').attr('value'); 
				}
				
				$('#returnURL').attr('value', '<?php echo $_SERVER['PHP_SELF']; ?>' + '?id=' + id);
			}

            function UpdateProductImage()
            {
				if ($('div#responseContainer div.ximage').html() == "")
                {
                    $('div#slidingInformation img').attr('src','images/addproduct.png');
                }
				else
                {
                    $('div#slidingInformation img').attr('src', $('div#responseContainer div.ximage').html());
                }
            }

            function ResetImage()
            {
				$('img#crudimage').attr('src', 'images/addproduct.png');
				$('#ximage').attr('value', '');
            }
	
			$(document).ready(function(){
			
				PopulateDropDowns();
				var requestHandler = 'productHandler.php';
				var mandatoryFieldIds = new Array('xsubcategory_id', 'xcategory_id', 'xtitle');
				var currentEditRequest = "<?php if (isset($_GET['id'])) {echo $_GET['id'];}?>";
				var addRequest = "<?php if (isset($_GET['add'])) {echo $_GET['add'];}?>";

				$(document).ajaxStart(function(){
					AjaxStart();
				});

				$(document).ajaxSuccess(function(){
					AjaxSuccess();
				});

				$(document).ajaxError(function(){
					AjaxError();
				});

				RepopulateMasterDropDown(requestHandler, currentEditRequest);

				InitializeAdd();
				
				$('#masterDropDown').change(function () {
					ClearFormFields();
					MasterDropDownChange($(this).attr('value'), requestHandler, PopulateReturnURL, UpdateProductImage);
				})

				$('#edit').click(function(){
					GenericEdit(mandatoryFieldIds, requestHandler);
				})
				
				$('#delete').click(function(){
					$.blockUI({ message: $('#question'), css: { width: '275px' } });
				})

				$('#yes').click(function(){
					GenericDelete(requestHandler);
					InitializeAdd();
				})
		
				$('#no').click($.unblockUI);
				
				$('#showAdd').click(function(){
					InitializeAdd();
					ResetImage();
				})

				$('#add').click(function(){
					GenericAdd(mandatoryFieldIds, requestHandler);
					ResetImage();
				})
			
				// Handles forwarding to other pages with POST request
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
                
				init();

                $('form#file_upload_form').attr('target', 'upload_target');

				$('#ximage').change(function(){
					
                });
            
			})

		function init() {
			document.getElementById("file_upload_form").onsubmit=function() {
    			document.getElementById("file_upload_form").target = "upload_target";
    			document.getElementById("upload_target").onload = uploadDone; //This function should be called when the iframe has compleated loading
    				// That will happen when the file is completely uploaded and the server has returned the data we need.
			}
		}

        function uploadDone() { //Function will be called when iframe is loaded
    	
        	var ret = frames['upload_target'].document.getElementsByTagName("body")[0].innerHTML;
        	var data = eval("("+ret+")"); //Parse JSON
        	
        	if(data.success) { //This part happens when the image gets uploaded.
    			$('#crudimage').attr('src','images/products/' + data.file_name);
        	}
        	else if(data.failure) { //Upload failed - show user the reason.
        		alert("Upload Failed: " + data.failure);
        	}	
        }
    			
		</script>
	</head>
	<body>
	<div class="content">
		<?php include 'uwheader.php'; ?>
		<p class="pagetitle"><?php echo $page_title; ?></p>
		<form class="hidden" id="frm_returnURL" action="" method="post">
			<input type="text" id="returnURL" name="returnURL"/>
		</form>
		
			<fieldset class="crud">
				<legend>What would you like to do?</legend>
				<input type="button" id="showAdd" class="btnadd btnmakeover" value="Add a new product"/>
				<label for="masterDropDown">or modify an existing 
					product:</label><br/>
				<select id="masterDropDown" class="masterDropDown" style="width: 100%; max-width: 100%;">
				</select>
			</fieldset>
			<div id="slidingInformation" class="nopadding">	
				<fieldset id="changer" class="crud">
					<legend>Product Information</legend>
					<form id="frm_editdelete">
					<div class="insidecrudleft">
						<img id="crudimage" class="crudimage" 
						src="images/addproduct.png" alt="No image available" 
						style="border: solid"/>
					</div>
					<div class="insidecrudright">
						<p>	
							<label for="xtitle">Title:</label><br/>
							<input type="text" id="xtitle" name="xtitle" 
							style="width: 90%"/>
							</p>
						<p>
							<label for="xcategory_id">Category:</label><br/>
							<select id="xcategory_id">
							</select>
							<a class="modify" 
							href="addcategories.php">Add/Edit</a>
						</p>

						<p>
							<label for="xsubcategory_id">Sub-Category</label><br/>
							<select id="xsubcategory_id">
							</select>
							<a class="modify" 
							href="addsubcategories.php">Add/Edit</a>
						</p>
						<p>
							<label for="xdescription">Description</label><br/> 
							<textarea id="xdescription" rows="6" cols="40"></textarea>
						</p>
						<p>
							<label for="xprice">Regular Price</label><br/>
							<input id="xprice" name="xprice" type="text"/>
						</p>
						<p>
							<label for="xsaleprice">Sale Price</label><br/>
							<input id="xsaleprice" name="xsaleprice" 
							type="text"/>
						</p>
						</form>
						<p>
							<form id="file_upload_form" name="file_upload_form" method="post" enctype="multipart/form-data" action="upload.php">
								<label for="ximage">Image</label><br/> 
								<input type="file" id="ximage" 
								name="ximage"></input> 
								<input type="submit" name="action" 
								value="Upload" style="border: 2px outset white;
								padding: 1px 7px 1px 7px; font-family: arial"/><br/>
								<iframe class="hidden" id="upload_target" name="upload_target" src="" style="width:100px;height:100px;border:1px solid #ccc;"></iframe>
							</form>
						</p>
						
					</div>
					<div class="insidecrudbottom">
						<input type="button" id="add" class="btnadd btnmakeover" 
						value="Add this product"/> <input type="button" 
						id="edit" class="btnedit btnmakeover" 
						value="Save Changes"/> <input type="button" id="delete" 
						class="btndelete btnmakeover" 
						value="Delete this product"/>
						<div class="messageWrapper">
							<div href="#message" id="message" class="message"></div>
						</div>
					</div>
				</fieldset>
			</div>
			
			<div id="responseContainer" class="hidden"></div>

			<div id="question" class="hidden"> 
				<div class="dialogbox">Are you sure you want to delete this 
				product?</div> <input type="button" id="yes" 
				class="btnyes btnmakeover" value="Yes" /> <input type="button" 
				id="no" class="btnno btnmakeover" value="No" /> 
			</div>
			<div id="hit" class="hidden"></div> 

		
		<?php include 'previousPage.php'; ?>
	</div>
	
	</body>
</html>



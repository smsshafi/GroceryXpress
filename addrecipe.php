<?php include 'masteradminonly.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php $page_title = 'Modify Recipes'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	
		<?php echo $sAdminCssFile.$sAllJs; ?>
		<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
		<script type="text/javascript">
			
			function GenerateFormTableMapping( )
			{
                var productsjson = new Object;
				productsjson.pickedproducts = new Array;
                $('#xpickedproduct').children().each(function(){
                    productsjson.pickedproducts.push($(this).attr('value'));
                })
                var productsjsonstring = JSON.stringify(productsjson)

                var returnstring = {
					id: $('#masterDropDown').attr('value'),
					name: $('#xname').attr('value'), 
					image: $('img#crudimage').attr('src'),
					directions: $('#xdirections').attr('value'),
					prep_time: $('#xprep_time').attr('value'),
					serves: $('#xserves').attr('value'),
					category: $('#xcategory').attr('value'),
                    pickedproducts: productsjsonstring
				};
                
				return returnstring;
			}

			function PopulateDropDowns()
			{
				PopulateProducts();	
			}

            function PopulateProducts()
			{
				$('#xproduct').load('productHandler.php?getlist=1');
			}

			function PopulateReturnURL(id)
			{
				if (!id)
				{
					id = $('#masterDropDown').attr('value'); 
				}
				
				$('#returnURL').attr('value', '<?php echo $_SERVER['PHP_SELF']; ?>' + '?id=' + id);
			}

            function UpdateRecipeImage()
            {
				if ($('div#responseContainer div.ximage').html() == "")
                {
                    $('div#slidingInformation img').attr('src','images/addrecipe.png');
                }
				else
                {
                    $('div#slidingInformation img').attr('src', $('div#responseContainer div.ximage').html());
                }
            }

            function ResetImage()
            {
				$('img#crudimage').attr('src', 'images/addrecipe.png');
				$('#ximage').attr('value', '');
            }

            function ResetRecipeList() {
                $('#xpickedproduct').children().remove();
            }

            function CheckEmptyProductList() {
				if ($('#xpickedproduct').children().length == 0)
                {
					alert("You have at least one product as an ingredient for the recipe.");
					return true;
                }
				return false;
            }
	
			$(document).ready(function(){
			
				PopulateDropDowns();
				var requestHandler = 'recipehandler.php';
				var mandatoryFieldIds = new Array('xname');
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
                    ResetRecipeList();
                    MasterDropDownChange($(this).attr('value'), requestHandler, PopulateReturnURL, UpdateRecipeImage);
					if ($(this).attr('value'))
                    {
                        $('#xpickedproduct').load(requestHandler+'?getrecipelist=1&recipe_id=' + $('#masterDropDown').attr('value'));
                    }
				})

				$('#edit').click(function(){
					if (!CheckEmptyProductList())
                    {
                        GenericEdit(mandatoryFieldIds, requestHandler);
                    }
				})
				
				$('#delete').click(function(){
					$.blockUI({ message: $('#question'), css: { width: '275px' } });
				})

				$('#yes').click(function(){
					GenericDelete(requestHandler);
					InitializeAdd();
                    ResetRecipeList();
					ResetImage();
				})
		
				$('#no').click($.unblockUI);
				
				$('#showAdd').click(function(){
					InitializeAdd();
					ResetImage();
					ResetRecipeList();
				})

				$('#add').click(function(){
                    if (!CheckEmptyProductList())
                    {
    					GenericAdd(mandatoryFieldIds, requestHandler);
    					ResetImage();
                        ResetRecipeList();
                    }
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
					MasterDropDownChange(currentEditRequest, requestHandler, UpdateRecipeImage);  //pre-select requested value if started in edit mode
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

				$('#addproduct').click(function(){
                    var id = $('#xproduct').attr('value');
					if (id)
                    {
						var existingProduct = $('#xpickedproduct option[value="'+id+'"]');
						
						if (existingProduct.size() == 0)
                        {
                            var name = $('#xproduct option[value=' + id + ']').html();
                            $('#xpickedproduct').append('<option value="' + id + '">' + name + '</option>');
                        }
                    }
                })

				$('#removeproduct').click(function(){
                    var id = $('#xpickedproduct').attr('value');
					$('#xpickedproduct option[value='+id+']').remove();
                })
            
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
    			$('#crudimage').attr('src','images/recipes/' + data.file_name);
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
				<input type="button" id="showAdd" class="btnadd btnmakeover" 
				value="Add a new recipe"/>
				<label for="masterDropDown">or modify an existing 
					recipe:</label>
				<select id="masterDropDown" class="masterDropDown" style="">
				</select>
			</fieldset>
			<div id="slidingInformation" class="nopadding">	
				<fieldset id="changer" class="crud">
					<legend>Recipe Information</legend>
					<form id="frm_editdelete">
						<div class="insidecrudleft" style="text-align: left";>
						<p>	
							<label for="xtitle">Name:</label><br/>
							<input type="text" id="xname" name="xname" 
							style="width: 90%"/>
						</p>
						<p>	
							<label for="xprep_time">Preparation Time: (e.g.	1/2 
								hour, or 10 minutes)
							</label><br/> <input type="text" id="xprep_time" 
							name="xprep_time" style="width: 90%"/>
						</p>
						<p>	
							<label for="xserves">Serves:
							</label><input type="text" id="xserves" 
							name="xserves" style="width: 5%"/> people
						</p>
						<p>	
							<label for="xcategory">Category:</label><br/>
							<select id="xcategory" name="xcategory" 
							style="width: 90%">
								<option value="Signature Recipes">Signature 
									Recipes</option>
								<option value="Light Recipes">Light
									Recipes</option>
								<option value="Main Meals">Main Meals</option>
								<option value="Desserts">Desserts</option>
								<option value="Breakfasts">Breakfasts</option>
								<option value="Snacks and Appetizers">Snacks 
									and Appetizers</option>
							</select>
						</p>
						<p>	
							<label for="xproduct">Product:</label><br/>
							<select id="xproduct" name="xproduct" 
							style="width: 90%">
								
							</select>
							<input type="button" id="addproduct" 
								name="addproduct" class="btnadd btnmakeover" 
								value="Add"/>
						</p>
						<p>	
							<label for="xpickedproduct">In this 
								recipe:</label><br/>
							<select size="5" id="xpickedproduct" name="xpickedproduct" 
							style="width: 90%">
							</select>
							<input type="button" id="removeproduct" 
								name="removeproduct" 
								class="btndelete btnmakeover" value="Remove"/>

						</p>

						
						<p>
							<label for="xdirections">Directions</label><br/> 
							<textarea id="xdirections" rows="6" cols="40"></textarea>
						</p>
						
						</form>
						<p>
							<form id="file_upload_form" name="file_upload_form" method="post" enctype="multipart/form-data" action="upload_recipe.php">
								<label for="ximage">Image</label><br/> 
								<input type="file" id="ximage" 
								name="ximage"></input> 
								<input type="submit" name="action" 
								value="Upload" style="border: 2px outset white;
								padding: 1px 7px 1px 7px; font-family: arial"/><br 
								/>
								<iframe class="hidden" id="upload_target" name="upload_target" src="" style="width:100px;height:100px;border:1px solid #ccc;"></iframe>
							</form>
						</p>
						
					</div>
						<div class="insidecrudright" style="text-align: left">
						<img id="crudimage" class="crudimage" 
						src="images/addrecipe.png" 
						alt="No image available" 
						style="border: solid; float: left;"/>
					</div>
					<div class="insidecrudbottom">
						<input type="button" id="add" class="btnadd btnmakeover" 
						value="Add this Recipe"/> <input type="button" 
						id="edit" class="btnedit btnmakeover" 
						value="Save Changes"/> <input type="button" id="delete" 
						class="btndelete btnmakeover" 
						value="Delete this recipe"/>
						<div class="messageWrapper">
							<div href="#message" id="message" class="message"></div>
						</div>
					</div>
					
					
				</fieldset>
			</div>
			
			<div id="responseContainer" class="hidden"></div>

			<div id="question" class="hidden"> 
				<div class="dialogbox">Are you sure you want to delete this 
				recipe?</div> <input type="button" id="yes" 
				class="btnyes btnmakeover" value="Yes" /> <input type="button" 
				id="no" class="btnno btnmakeover" value="No" /> 
			</div>
			<div id="hit" class="hidden"></div> 

		
		<?php include 'previousPage.php'; ?>
	</div>
	
	</body>
</html>



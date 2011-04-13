<?php include 'masteradminonly.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php $page_title = 'Modify Courses'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $sCssFile.$sAllJs; ?>
		<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
		<script type="text/javascript">
			
			function GenerateFormTableMapping( )
			{
				return {id: 		$("#masterDropDown").attr('value'), 
					course_number: 	$("#xcourse_number").attr('value'), 
					name: 		$("#xname").attr('value')};
			}

			$(document).ready(function(){
			
				var requestHandler = "courseHandler.php";
				var mandatoryFieldIds = new Array("xcourse_number", "xname");
				var currentEditRequest = "<?php if (isset($_GET['id'])) {echo $_GET['id'];} ?>";
				var addRequest = "<?php if (isset($_GET['add'])) {echo $_GET['add'];} ?>";

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

				$("#add").hide();
				
				$('#masterDropDown').change(function () {
					MasterDropDownChange($(this).attr('value'), requestHandler);
				})

				$("#edit").click(function(){
					GenericEdit(mandatoryFieldIds, requestHandler);
				})
				
				$("#delete").click(function(){
					$.blockUI({ message: $('#question'), css: { width: '275px' } });
				})

				$('#yes').click(function(){
					GenericDelete(requestHandler);
				})
		
				$('#no').click($.unblockUI);
				
				$("#showAdd").click(function(){
					InitializeAdd();
				})

				$("#add").click(function(){
					GenericAdd(mandatoryFieldIds, requestHandler);
				})

				if (currentEditRequest)
				{
					MasterDropDownChange(currentEditRequest, requestHandler);
				}

				if (addRequest)
				{
					InitializeAdd(requestHandler);
				}
			})
			
		</script>
	</head>
	<body>
	<div class="content">
		<?php include 'uwheader.php'; ?>
		<p class="pagetitle"><?php echo $page_title; ?></p>
		<div class="messageWrapper">
			<div id="message" class="message"></div>
		</div>
		<form id="frm_editdelete">
			<fieldset class="crud">
				<legend>What would you like to do?</legend>
				<input type="button" id="showAdd" class="btnadd btnmakeover" value="Add a new course"/>
				<label for="masterDropDown">or modify an existing course:</label>
				<select id="masterDropDown" class="masterDropDown">
				</select>
			</fieldset>
			<div id="slidingInformation" class="nopadding hidden">	
				<fieldset class="crud">
					<legend>Course Information</legend>
					<div class="insidecrudleft">
						<img class="crudimage" src="images/addcourse.png" alt="No image available"/>
					</div>
					<div class="insidecrudright">
						<p>
						<label for="xcourse_number">Course Number:</label><br/>
						<input id="xcourse_number" type="text" value=""/>
						</p>
						
						<p>
						<label for="xname">Course Title:</label><br/>
						<input id="xname" type="text" value=""/>
						</p>
					</div>
				</fieldset>
				<fieldset class="crud optionbuttons">
					<legend>Action to perform</legend>
						<input type="button" id="add" class="btnadd btnmakeover" value="Add this course"/>
						<input type="button" id="edit" class="btnedit btnmakeover" value="Save Changes"/>
						<input type="button" id="delete" class="btndelete btnmakeover" value="Delete this course"/>
				</fieldset>
			</div>
			
			<div id="responseContainer" class="hidden"></div>

			<div id="question" class="hidden"> 
				<div class="dialogbox">Are you sure you want to delete this course?</div> 
				<input type="button" id="yes" class="btnyes btnmakeover" value="Yes" /> 
				<input type="button" id="no" class="btnno btnmakeover" value="No" /> 
			</div> 

		</form>
		<?php include 'previousPage.php'; ?>
	</div>
	
	</body>
</html>


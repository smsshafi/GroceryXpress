<?php include 'masteradminonly.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php $page_title = 'Pick Question Set'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $sCssFile.$sAllJs; ?>
		<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
		<script type="text/javascript">
			
			function GenerateFormTableMapping( )
			{
				return {id: 		$("#masterDropDown").attr('value'), 
					set_name: 		$("#xset_name").attr('value')};
			}

			$(document).ready(function(){
			
				var requestHandler = "setHandler.php";
				var mandatoryFieldIds = new Array("xset_name");
				var currentEditRequest = "<?php if (isset($_GET['id'])) {echo $_GET['id'];} ?>";


				RepopulateMasterDropDown(requestHandler, currentEditRequest);
				
				$('#masterDropDown').change(function () {
					MasterDropDownChange($(this).attr('value'), requestHandler);
				})

				$('#showQuestions').click(function(){
					if ($('#masterDropDown').attr('value'))
					{
						window.location = "orderquestions.php?set_id=" + $('#masterDropDown').attr('value');
					}
				})

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
				<label for="masterDropDown">Question Set: </label>
				<select id="masterDropDown" class="masterDropDown">
				</select>
			
				<input type="button" id="showQuestions" class="btnyes btnmakeover" value="Next"/>
			
			<div id="responseContainer" class="hidden"></div>


		</form>
		<?php include 'previousPage.php'; ?>
	</div>
	
	</body>
</html>


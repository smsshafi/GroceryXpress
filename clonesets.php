<?php include 'masteradminonly.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>
<?php
	if (isset ($_POST['masterDropDown']) && $_POST['masterDropDown'] != "" && isset ($_POST['cloneName']) && $_POST['cloneName'] != "") {
		CloneSet($_POST['masterDropDown'], $_POST['cloneName']);
	}
?>
<?php $page_title = 'Clone Question Set'; ?>
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

				$('#doclone').click(function(){
					if ($('#masterDropDown').attr('value'))
					{
						document.frm_clone.submit();	
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
		<form id="frm_clone" name="frm_clone" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<label for="masterDropDown">Choose the set to clone: </label>
				<select id="masterDropDown" name="masterDropDown" class="masterDropDown">
				</select>
				<br/>
				<label for="cloneName">Name of the cloned set: </label>
				<input type="text" id="cloneName" name="cloneName"/>
				<br/>
			
				<input type="button" id="doclone" class="btnyes btnmakeover" value="Clone"/>
			
			<div id="responseContainer" class="hidden"></div>


		</form>
		<?php include 'previousPage.php'; ?>
	</div>
	
	</body>
</html>


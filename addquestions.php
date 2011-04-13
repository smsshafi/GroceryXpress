<?php
	if (!isset($_GET['set_id']))
	{
		header("location: ./controlpanel.php");
	}
?>
<?php include 'masteradminonly.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>
<?php $page_title = 'Modify Questions'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $sCssFile.$sAllJs; ?>
		<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
		<script type="text/javascript">
			
			function GenerateFormTableMapping( )
			{
				return {id: 		$("#masterDropDown").attr('value'), 
					questions: 	$("#xquestions").attr('value'), 
					type: 		$("#xtype").attr('value'), 
					shown: 		$("#xshown").attr('value'), 
					na: 		$("#xna").attr('value'), 
					left_caption: 	$("#xleft_caption").attr('value'), 
					right_caption: 	$("#xright_caption").attr('value'), 
					cbest: 		$("#xcbest").attr('value'), 
					opt_a: 		$("#xopt_a").attr('value'), 
					opt_b: 		$("#xopt_b").attr('value'), 
					opt_c: 		$("#xopt_c").attr('value'), 
					opt_d: 		$("#xopt_d").attr('value'), 
					opt_e: 		$("#xopt_e").attr('value') 
					};
			}

			function ShowCustomOptions()
			{
				$("div#customoptions").fadeIn("slow");
			}

			function HideCustomOptions()
			{
				$("div#customoptions").fadeOut("slow");
			}

			function ShowCaptions()
			{
				$("#leftcaption, #rightcaption").fadeIn("slow");
			}

			function HideCaptions()
			{
				$("#leftcaption, #rightcaption").fadeOut("slow");
			}

			function ShowCBest()
			{
				$("#cbestwrapper").fadeIn("slow");
			}

			function HideCBest()
			{
				$("#cbestwrapper").fadeOut("slow");
			}
			
			function ShowNA()
			{
				$("#showna").fadeIn("slow");
			}

			function HideNA()
			{
				$("#showna").fadeOut("slow");
			}

			function UpdateCustomOptions()
			{
				if ($("#xtype").attr('value') == 'c') {
					ShowCustomOptions();
					ShowNA();
					ShowCBest();
					ShowCaptions();
				}
				else if ($("#xtype").attr('value') == 'd') {
					HideNA();
					HideCaptions();
					HideCustomOptions();
					HideCBest();
				}
				else if ($("#xtype").attr('value') == 'b') {
					ShowNA();
					HideCBest();
					HideCustomOptions();
					HideCaptions();
				}
				else if ($("#xtype").attr('value') == 'm') {
					HideCustomOptions();
					ShowNA();
					ShowCaptions();
					ShowCBest();
				}
			}

			function SetFormDefaults()
			{
				$("#xcbest").attr('value','0');
				$("#xshown").attr('value','1');
				$("#xtype").attr('value','m');
				$("#xna").attr('value','0');
				UpdateCustomOptions();
			}
			
			$(document).ready(function(){
			
				var requestHandler = "questionHandler.php";
				var mandatoryFieldIds = new Array("xquestions");
				var currentEditRequest = "<?php if (isset($_GET['id'])) {echo $_GET['id'];} ?>";
				var addRequest = "<?php if (isset($_GET['add'])) {echo $_GET['add'];} ?>";
				var extrarequest = "&set_id=<?php echo $_GET['set_id']; ?>";

				RepopulateMasterDropDown(requestHandler, currentEditRequest, extrarequest);

				$("#ignore").click(function(){
					$("#warning").hide();
					$("fieldset.crud").show();

				})

				$(document).ajaxStart(function(){
					AjaxStart();
				});

				$(document).ajaxSuccess(function(){
					AjaxSuccess();
				});

				$(document).ajaxError(function(){
					AjaxError();
				});

				$("#add").hide();
			
				$("#xtype").change(function(){
					UpdateCustomOptions();
				})
	
				$("#masterDropDown").change(function () {
					MasterDropDownChange($(this).attr('value'), requestHandler, 
								UpdateCustomOptions);
				})

				$("#masterDropDown").click(function() {
					$("#questions").children().each(function(){
					$(this).css('width', $("#questions").css('width'));
				});
					
				})
			
				$("#edit").click(function(){
					GenericEdit(mandatoryFieldIds, requestHandler, null, extrarequest);
				})
				
				$("#delete").click(function(){
					$.blockUI({ message: $('#question'), css: { width: '275px' } });
				})

				$('#yes').click(function(){
					GenericDelete(requestHandler, extrarequest);
				})
		
				$('#no').click($.unblockUI);
				
				$("#showAdd").click(function(){
					InitializeAdd();
					SetFormDefaults();
				})

				$("#add").click(function(){
					GenericAdd(mandatoryFieldIds, requestHandler, null, extrarequest);
				})	
		
				if (currentEditRequest)
				{
					GenericDropDownChange(currentEditRequest, requestHandler);
				}

				if (addRequest)
				{
					InitializeAdd();
					SetFormDefaults();
				}
			})
			
		</script>
	</head>
	<body>
	<div class="content">
		<?php include 'uwheader.php'; ?>
		<p class="pagetitle"><?php echo $page_title.' - '.GetSetNameFromID($_GET['set_id']); ?></p>
		<div class="messageWrapper">
			<div id="message" class="message"></div>
		</div>
		<form id="frm_editdelete">
			<?php
				if (IsSetHit($_GET['set_id'])) {
			?>
			<br/>
			<p id="warning" class="redtext">You should not modify this question set since it's already in use. <a href="#" id="ignore">Click here</a> to continue anyways.</p>
			<?php
					$hidden = "hidden";
				}
				else
				{
					$hidden = "";
				}
			?>

			<fieldset class="crud <?php echo $hidden; ?>">
				<legend>What would you like to do?</legend>
				<input type="button" id="showAdd" class="btnadd btnmakeover" value="Add a new question"/>
				<label for="questions">or modify an existing question:</label>
				<select id="masterDropDown" class="masterDropDown">
				</select>
			</fieldset>
			<div id="slidingInformation" class="nopadding hidden">	
				<fieldset class="crud">
					<legend>Question Information</legend>
					<div class="insidecrudright fullWide">
						<p>
							<label for="xquestions">Question:</label><br/>
							<input class="almostFullWide" id="xquestions" type="text" value=""/>
						</p>
						
							<div class="compactfields">
								<label for="xtype">Type</label><br/>
								<select id="xtype">
									<option value="m">Multiple Choice</option>
									<option value="d">Descriptive</option>
									<option value="b">Yes/No</option>
									<option value="c">Custom</option>
								</select>
							</div>
							<div class="hidden compactfields">
								<label for="xshown">Displayed</label><br/>
								<select id="xshown">
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
							</div>
							<div id="showna" class="compactfields">
								<label for="xna">Show N/A</label><br/>
								<select id="xna">
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
							</div>
						
						<p id="cbestwrapper">
							<label for="xcbest">'C' best option</label><br/>
							<select id="xcbest">
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</p>
							<div id="leftcaption" class="compactfields">
								<label for="xleft_caption">Left Caption:</label><br/>
								<input class="smallerinput" id="xleft_caption" type="text" value=""/>
							</div>
						<p id="rightcaption">
							<label for="xright_caption">Right Caption:</label><br/>
							<input class="smallerinput" id="xright_caption" type="text" value=""/>
						</p>
						<div id="customoptions" class="hidden">
							<div class="compactfields">
								
								<label for="xopt_a">Option A:</label><br/>
								<input class="smallerinput" id="xopt_a" type="text" value=""/>
							</div>
							<div class="compactfields">
								<label for="xopt_b">Option B:</label><br/>
								<input class="smallerinput" id="xopt_b" type="text" value=""/>
							</div>
							<div class="compactfields">
								<label for="xopt_c">Option C:</label><br/>
								<input class="smallerinput" id="xopt_c" type="text" value=""/>
							</div>
							<div class="compactfields">
								<label for="xopt_d">Option D:</label><br/>
								<input class="smallerinput" id="xopt_d" type="text" value=""/>
							</div>
							<div class="compactfields">
								<label for="xopt_e">Option E:</label><br/>
								<input class="smallerinput" id="xopt_e" type="text" value=""/>
							</div>
						</div>
					</div>
				</fieldset>
				<fieldset class="crud optionbuttons">
					<legend>Action to perform</legend>
						<input type="button" id="add" class="btnadd btnmakeover" value="Add this question"/>
						<input type="button" id="edit" class="btnedit btnmakeover" value="Save Changes"/>
						<input type="button" id="delete" class="btndelete btnmakeover" value="Delete this question"/>
				</fieldset>
			</div>
			
			<div id="responseContainer" class="hidden"></div>

			<div id="question" class="hidden"> 
				<div class="dialogbox">Are you sure you want to delete this question?</div> 
				<input type="button" id="yes" class="btnyes btnmakeover" value="Yes" /> 
				<input type="button" id="no" class="btnno btnmakeover" value="No" /> 
			</div> 

		</form>
		<?php include 'previousPage.php'; ?>
	</div>
	
	</body>
</html>


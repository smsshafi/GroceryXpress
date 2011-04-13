<?php
	if (!isset($_GET['set_id']))
	{
		header("location: ./controlpanel.php");
	}
?>
<?php include 'masteradminonly.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>
<?php $page_title = 'Modify Question Ordering'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $sCssFile.$sAllJs; ?>
		<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
		<script type="text/javascript">
			

			function BindButtons()
			{
				$("button").click(function(){
					var splitID = ($(this).attr('id').split("_"));
					if (splitID[0] == 'up')
					{
						$.post('questionHandler.php?promote=1', {id: splitID[1]}, function(response){
							//$("#orderQuestions").html(response);
							GetQuestionDivs();
						})
					}
					if (splitID[0] == 'down')
					{
						$.post('questionHandler.php?demote=1', {id: splitID[1]}, function(response){
							//$("#orderQuestions").html(response);
							GetQuestionDivs();
						})
					}
					
				})
			}

			function BindQuestionHover()
			{
				$("div.questionBox").bind("mouseover", function(){
					$(this).addClass("hoverQuestionBox");
				});
				$("div.questionBox").bind("mouseout", function(){
					$(this).removeClass("hoverQuestionBox");
				});
			}

			function GetQuestionDivs()
			{
				$("#orderQuestions").load('questionHandler.php?getlistdivs=1&set_id=<?php echo $_GET['set_id']; ?>', function(){
					BindUI();
					BindButtons();
					BindQuestionHover();
				});
			}		
			
			$(document).ready(function(){
				GetQuestionDivs();
			})	
		</script>
	</head>
	<body>
	<div class="content">
		<?php include 'uwheader.php'; ?>
		<p class="pagetitle"><?php echo $page_title.' - '; echo GetSetNameFromID($_GET['set_id']); ?></p>
		<div class="messageWrapper">
			<div id="message" class="message"></div>
		</div>
		<div id="orderQuestions" class="orderQuestions centered">
		</div>
		<?php include 'previousPage.php'; ?>
	</div>
	
	</body>
</html>



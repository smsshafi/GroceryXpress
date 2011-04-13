<?php include 'docritiqueauthheader.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>
<?php echo $sDocType; ?>
<?php $page_title = 'Fill In'; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $sCssFile.$sAllJs; ?>
		<script type="text/javascript">
			$(document).ready(function(){
					BindUI();
					$("textarea").focus(function(){
						$(this).addClass('focustextarea');
						if ($(this).html() == "Enter your response..." || $(this).attr('value') == 'Enter your response...')
						{
							$(this).html('');
							$(this).attr('value', '');
						}
					})
					$("textarea").blur(function(){
						$(this).removeClass('focustextarea');
						if ($(this).attr('value') == null || $(this).attr('value') == "")
						{
							$(this).attr('value', 'Enter your response...');
							$(this).html('Enter your response...');
						}
					})
					
					$('table.questionTable tr.bottomrow td.choice').click(function(){
						$(this).children("input").attr('checked', 'true');
					})

					$('table.questionTable tr.bottomrow td.choice').mouseover(function(){
						$(this).addClass('hoveredchoice');
					})
					
					$('table.questionTable tr.bottomrow td.choice').mouseout(function(){
						$(this).removeClass('hoveredchoice');
					})
					
					$("#submitcritique").click(function(e){
						e.preventDefault();
						var blankSubmission = true;
						$("textarea").each(function(){
							if ($(this).attr('value') == "Enter your response..." || $(this).html() == "Enter your response...")
							{
								$(this).attr('value', '');
								$(this).html('');
							}
							else
							{
								blankSubmission = false;
							}
						})

						$("form#critique input").each(function(){
							if ($(this).attr('checked') == true)
							{
								blankSubmission = false;
							}
						})

						if (!blankSubmission)
						{
							document.critique.submit();
						}
						else
						{
							alert('You cannot submit a blank critique.');
							$("textarea").each(function(){
								$(this).attr('value', 'Enter your response...');
								$(this).html('Enter your response...');
							})

						}
					})
				});
		</script>
		<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	</head>
	<body>
		<div class="content">
			<?php
				$row = mysql_fetch_assoc(GetCritiqueFromID($_GET['id']));
			?>
			<form id="critique" name="critique" method="post" action="processsubmission.php?crit_id=<?php echo $_GET['id']; ?>">
				<?php include 'uwheader.php'; ?>
				<p class="pagetitle"><?php echo GetCourseNumberFromID($row['course_id'])." - ".GetCourseNameFromID($row['course_id']);?></p>
				Professor: <?php echo GetProfessorNameFromID($row['prof_id']); ?>
				<fieldset class="crud">
				<?php
					$crit_id = $_GET['id'];
					$get_list_rendered = true;
					include 'critiquerenderer.php';
				?>	
				</fieldset>
			</form>
			
			<?php include 'studentpreviousPage.php'; ?>
		</div>
		<div id="responseContainer" class="hidden"></div> 
	</body>
</html>



<?php include 'viewerheader.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>
<?php $page_title = 'Results'; ?>
<?php echo $sDocType; ?>
<?php
	$critique = GetCritiqueFromID($_GET['id']);
	$row = mysql_fetch_assoc($critique);
	$course = GetCourseNumberFromID($row['course_id'])." - ".GetCourseNameFromID($row['course_id']);
	$term =  GetTermIDFromID($row['term_id'])." - ".GetTermNameFromID($row['term_id']);
	$professor = GetProfessorNameFromID($row['prof_id']);
	$enrolled = GetNumberStudentsFromCritiqueID($_GET['id']);
	$hits = GetCritiqueHits($_GET['id']); 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $sCssFile.$sAllJs; ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('fieldset#numericresultcontainer').load('resultsHandler.php?getnumeric=1&id=<?php echo $_GET['id']; ?>', function(){
					
					//Key bindings for show/hide results	
					$('a.resultstoggle').bind('click', function(e){
						e.preventDefault();
						var rownum = $(this).attr('class').split(' ')[1];
						$('tr.' + rownum).toggleClass('hidden');
					})
				});
			})
		</script>
		<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	</head>
	<body>
		<div class="content">
			<?php include 'uwheader.php'; ?>
			<p class="pagetitle"><?php echo $page_title; ?></p>
			<a href="viewresultsprint.php?id=<?php echo $_GET['id']; ?>" target="_blank">Click here for printer friendly version</a>
			<fieldset class="crud">
				<legend>Summary</legend>
				<table class="fullWide leftAlign summary">
					<tr>
						<td>Course: <b><?php echo $course; ?></b></td>
						<td>Students enrolled: <b><?php echo $enrolled; ?></b></td>
					</tr>
					<tr>
						<td>Professor: <b><?php echo $professor; ?></b></td>
						<td>Students participated: <b><?php echo $hits; ?></b></td>
					</tr>
					<tr>
						<td>Term: <b><?php echo $term; ?></b></td>
						<td></td>
					</tr>
				</table>
			</fieldset>	
			<fieldset id="numericresultcontainer" class="crud">
			</fieldset>
			<?php include 'previousPage.php'; ?>
		</div>
		<div id="responseContainer" class="hidden"></div> 
	</body>
</html>


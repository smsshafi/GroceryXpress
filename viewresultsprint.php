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
				$('div#numericresultcontainer').load('resultsprinthandler.php?getnumeric=1&id=<?php echo $_GET['id']; ?>', function(){
					
					//Key bindings for show/hide results	
				});
			})
		</script>
		<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	</head>
	<body>
		<div class="content">
			<?php include 'uwprintheader.php'; ?>
			<p class="pagetitle"><?php echo $page_title; ?></p>
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
			<div id="numericresultcontainer" class="crud">
			</div>
		</div>
		<div id="responseContainer" class="hidden"></div> 
	</body>
</html>



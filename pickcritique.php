<?php include 'authheader.php'; ?>
<html>
<head>
<title>UW Online Course Critique</title>
</head>
<body>

<p>UW Online Course Critique system coming soon!</p>

<form id="pick" name="pick" action="critique.php" method="post">
	<select id="term" name="term">

		<?php
			include 'etc.php';
			$terms = GetTerms();
			while ($row = mysql_fetch_assoc($terms))
			{	
		?>
				<option value="<?php echo $row['id']; ?>"><?php echo $row['term_id']; ?> - <?php echo $row['term_name']; ?></option>
		
		<?php } ?>
	</select>

	<select id="course" name="course">
		<?php
			$courses = GetCourses();
			while ($row = mysql_fetch_assoc($courses))
			{
		?>
				<option value="<?php echo $row['id']; ?>"><?php echo $row['course_number']; ?> - <?php echo $row['name']; ?></option>
		<?php } ?>
		
	</select>
	
	<select id="prof" name="prof">
		<?php
			$prof = GetProfessors();			
			while ($row = mysql_fetch_assoc($prof))
			{
		?>
				<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
		<?php } ?>
		
	</select>
		
	<input type="submit" id="frm_submit" name="frm_submit" value="Submit"/>
</form>

<a href="./controlpanel.php">Back to Previous Page</a>
<?php include 'logoutform.php'; ?>

</body>

</html>
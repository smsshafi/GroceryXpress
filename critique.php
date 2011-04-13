<?php include 'etc.php'; ?>
<html>
<head>
	<title>UW Online Course Critique</title>
</head>
<body>
	<table>
		<tr> 
			<th>Number</th>
			<th>Question</th>
			<th>A</th>
			<th>B</th>
			<th>C</th>
			<th>D</th> 
			<th>E</th>
			<th>Totals</th>
		</tr>
		
		<?php
			$critique_id = GetCritiqueID($_POST['term'],$_POST['course'],$_POST['prof']);
			$result = GetNumberResults($critique_id);
			$count = 1;
			while($row = mysql_fetch_assoc($result))
			{
		?>
		<tr>
			<td><?php echo $count; ?></td>
			<td><?php echo GetQuestionFromID($row['questions']); ?></td>
			<td><?php echo $row['1']; ?></td>
			<td><?php echo $row['2']; ?></td>
			<td><?php echo $row['3']; ?></td>
			<td><?php echo $row['4']; ?></td>
			<td><?php echo $row['5']; ?></td>
		</tr>
		<?php
				$count += 1; 
			}
		?>
	</table>
	<table>
		<tr> 
			<th>Number</th>
			<th>Question</th>
			<th>Answer</th>
		</tr>
		
		<?php
			$critique_id = GetCritiqueID($_POST['term'],$_POST['course'],$_POST['prof']);
			$result = GetTextResults($critique_id);
			$count = 1;
			while($row = mysql_fetch_assoc($result))
			{
		?>
	<tr>
			<td><?php echo $count; ?></td>
			<td><?php echo GetQuestionFromID($row['questions_id']); ?></td>
			<td><?php echo $row['text']; ?></td>
		</tr>
		<?php
				$count += 1; 
			}
		?>
	</table>
	
</body>
</html>


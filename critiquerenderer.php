<?php
session_start();
include 'studentauthheader.php';
include_once 'etc.php';
if ($get_list_rendered)
{
	if (($response = GetCritiquePermissionFromStudentID($crit_id, $_SESSION['uwid'])) != "allowed")
	{
		echo $response; 
		return;
	}
	$id = GetFirstQuestionID(GetSetIDFromCritiqueID($crit_id));
	$count = 1;
	echo 'A <td class="number cbest">*</td> on the top left of a question indicates that \'C\' is the best choice.';
	while ($id != 0)
	{
		$result = GetQuestionFromID($id);
		$row = mysql_fetch_assoc($result);
	?>
				<table class="questionTable">
					<tr class="toprow">
						<?php
							if ($row['cbest'])
							{
								echo '<td class="number cbest">*</td>';
							}
							else
							{
								echo '<td class="number"></td>';
							}
						?>
						<td class="question">Question</td>
						<?php
							
							if ($row['left_caption'] != "" && $row['type'] != 'd' && $row['type'] != 'b')
							{
								echo '<td class="range">Range</td>';
							}
						?>
						<?php
							if ($row['type'] == 'm')
							{
						?>
								<td class="choice">A</td>
								<td class="choice">B</td>
								<td class="choice">C</td>
								<td class="choice">D</td>
								<td class="choice">E</td>
						<?php
							}
							
							if ($row['type'] == 'b')
							{
						?>
								<td class="choice">Yes</td>
								<td class="choice">No</td>
						<?php
							}

							if ($row['type'] == 'c')
							{
								foreach (array($row['opt_a'], $row['opt_b'], 
										$row['opt_c'], $row['opt_d'], $row['opt_e']) as $opt)
								{
									if ($opt != "")
									{
										echo '<td class="choice">'.$opt.'</td>';
									}
								}
							}

							if ($row['type'] == 'd')
							{
								echo '<td class="choice">Response</td>';
							}
						?>
						<?php
							if ($row['right_caption'] != "" && $row['type'] != 'd' && $row['type'] != 'b')
							{
								echo '<td class="range">Range</td>';
							}

							if ($row['type'] != 'd')
							{
								if ($row['na'])
								{
									echo '<td class="choice na">N/A</td>';
								}
								else
								{
									echo '<td class="na"></td>';
								}
							}
						?>
							
					</tr>
					<tr class="bottomrow">
						<td class="number"><?php echo $count; ?></td>
						<td class="question"><?php echo $row['questions']; ?></td>
						<?php
						if ($row['left_caption'] != "" && $row['type'] != 'd' && $row['type'] != 'b')
						{
							echo '<td class="range">'.$row['left_caption'].'</td>';
						}
						
						if ($row['type'] == 'm')
						{
						?>
						<td class="choice"><input type="radio" name="<?php echo $row['id'];?>" value="a"/></td>
						<td class="choice"><input type="radio" name="<?php echo $row['id'];?>" value="b"/></td>
						<td class="choice"><input type="radio" name="<?php echo $row['id'];?>" value="c"/></td>
						<td class="choice"><input type="radio" name="<?php echo $row['id'];?>" value="d"/></td>
						<td class="choice"><input type="radio" name="<?php echo $row['id'];?>" value="e"/></td>
						<?php
						}
							
							if ($row['type'] == 'b')
							{
						?>
								<td class="choice"><input type="radio" name="<?php echo $row['id'];?>" value="a"/></td>
								<td class="choice"><input type="radio" name="<?php echo $row['id'];?>" value="b"/></td>
						<?php
							}

							if ($row['type'] == 'c')
							{
								foreach (array($row['opt_a'] => 'a', 
										$row['opt_b'] => 'b', 
										$row['opt_c'] => 'c', 
										$row['opt_d'] => 'd', 
										$row['opt_e'] => 'e') as $key => $value)
								{
									if ($key != "")
									{
										echo '<td class="choice"><input type="radio" name="'.$row['id'].'" value="'.$value.'"/></td>';
									}
								}
							}

							if ($row['type'] == 'd')
							{
						?>
								<td class="descriptive"><textarea class="descriptive" name="<?php echo $row['id']; ?>">Enter your response...</textarea>
						<?php
							
							}
						
						if ($row['right_caption'] != "" && $row['type'] != 'd' && $row['type'] != 'b')
						{
							echo '<td class="range">'.$row['right_caption'].'</td>';
						}
						?>
						<?php
						if ($row['type'] != 'd')
						{
							if ($row['na'])
							{
						?>
								<td class="choice na"><input type="radio" name="<?php echo $row['id']?>" value="rna"/></td>
						<?php
							}
							else
							{
								echo '<td class="na"></td>';
							}
						}
						?>
	
					</tr>
				</table>
	<?php
		$id = GetNextQuestionID($id);
		$count++;
	}
	echo '<input id="submitcritique" class="btnmakeover hugebutton submitcritique" type="submit" name="submitcritique" value="Submit"/>';

}

?>



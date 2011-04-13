<?php

# Display course title and info on top
# Info includes number of students completed and total students

include 'authheader.php';
include 'etc.php';

function GetPercentageArray($row)
{
	$hits = GetCritiqueHits($_GET['id']);
	foreach ($row as $key => $value)
	{
		if ($key == 'a' ||
			$key == 'b' ||
			$key == 'c' ||
			$key == 'd' ||
			$key == 'e' ||
			$key == 'rna' ||
			$key == 'rnull')
		{
			$percentages["$key"] = number_format(($value / $hits * 100), 2) . "%"; 
		}
	}
	return $percentages;
}

function RenderLeftCaptionHeading($row)
{
	if ($row['left_caption'] != "")
	{
		echo '<td class="range">Range</td>';
	}
}

function RenderChoiceHeadings($row)
{
	if ($row['type'] == 'm')
	{
		echo '<td class="choice">A</td>
		<td class="choice">B</td>
		<td class="choice">C</td>
		<td class="choice">D</td>
		<td class="choice">E</td>';
	}
	
	if ($row['type'] == 'b')
	{
		echo '<td class="choice">Yes</td>
		<td class="choice">No</td>';
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
}

function RenderRightCaptionHeading($row)
{
	if ($row['right_caption'] != "")
	{
		echo '<td class="range">Range</td>';
	}
}

function RenderNullHeading()
{
	echo '<td class="choice">None</td>';
}
function RenderNAHeading($row)
{
	if ($row['na'])
	{
		echo '<td class="choice">N/A</td>';
	}
}

function RenderScoreHeading($row)
{
	if ($row['type'] == 'm')
	{
		echo '<td class="choice">Score</td>';
	}
}

function RenderLeftCaption($row)
{
	if ($row['left_caption'] != "")
	{
		echo '<td class="range">'.$row['left_caption'].'</td>';
	}
}

function RenderRightCaption($row)
{
	if ($row['right_caption'] != "")
	{
		echo '<td class="range">'.$row['right_caption'].'</td>';
	}
}

function RenderChoiceResults($row)
{
	if ($row['type'] == 'm')
	{
		echo '<td class="choice">'.$row['a'].'</td>
			<td class="choice">'.$row['b'].'</td>
			<td class="choice">'.$row['c'].'</td>
			<td class="choice">'.$row['d'].'</td>
			<td class="choice">'.$row['e'].'</td>';
	}
		
		if ($row['type'] == 'b')
		{
			echo '<td class="choice">'.$row['a'].'</td>
				<td class="choice">'.$row['b'].'</td>';
		}

		if ($row['type'] == 'c')
		{
			foreach (array($row['opt_a'] => $row['a'], 
					$row['opt_b'] => $row['b'], 
					$row['opt_c'] => $row['c'], 
					$row['opt_d'] => $row['d'], 
					$row['opt_e'] => $row['e']) as $key => $value)
			{
				if ($key != "")
				{
					echo '<td class="choice">'.$value.'</td>';
				}
			}
		}
}

function RenderNAResults($row)
{
	if ($row['na'])
	{
		echo '<td class="choice">'.$row['rna'].'</td>';
	}
}

function RenderNullResults($row)
{
	echo '<td class="choice">'.$row['rnull'].'</td>';
}

function RenderScoreResults($row)
{
	if ($row['type'] == 'm') {
		echo '<td class="score" rowspan="2">'.$row['score'].'</td>';
	}
}

function RenderCBest($row)
{
	if ($row['cbest'])
	{
		echo '<td><b>Note: Choice C denotes the best option.</b></td>';
	}
	else
	{
		echo '<td></td>';
	}
}

function RenderPercentages($row, $percentages)
{
	if ($row['type'] == 'm')
	{
		echo '<td>'.$percentages['a'].'</td>
			<td>'.$percentages['b'].'</td>
			<td>'.$percentages['c'].'</td>
			<td>'.$percentages['d'].'</td>
			<td>'.$percentages['e'].'</td>';
	}

	if ($row['type'] == 'b')
	{
		echo '<td>'.$percentages['a'].'</td>
			<td>'.$percentages['b'].'</td>';
	}

	if ($row['type'] == 'c')
	{
		foreach (array('a' => $row['opt_a'], 
				'b' => $row['opt_b'], 
				'c' => $row['opt_c'], 
				'd' => $row['opt_d'], 
				'e' => $row['opt_e']) as $key=>$value)
		{
			if ($value)
			{
				echo '<td>'.$percentages["$key"].'</td>';
			}
		}

	}
}

function RenderBlankLeftCaption($row)
{
	if ($row['left_caption'])
	{
		echo '<td></td>';
	}
}

function RenderBlankRightCaption($row)
{
	if ($row['right_caption'])
	{
		echo '<td></td>';
	}
}

function RenderNAPercentages($row, $percentages)
{
	if ($row['na'])
	{
		echo '<td>'.$percentages['rna'].'</td>';
	}
}

function RenderNullPercentages($row, $percentages)
{
	echo '<td>'.$percentages['rnull'].'</td>';
}

if ($_GET['getnumeric'] == 1)
{
	if ($_GET['id'] != "" && IsCritiqueHit($_GET['id']))
	{
		$id = GetFirstQuestionID(GetSetIDFromCritiqueID($_GET['id']));
		$count = 1;
		$hits = GetCritiqueHits($_GET['id']);
		
		while ($id != 0)
		{
			$result = GetResultFromQuestionID($_GET['id'], $id);
		       	if (!($row = mysql_fetch_assoc($result)))
			{
				$result = GetDescriptiveResultFromQuestionID($_GET['id'], $id);
				if ($num_responses = mysql_num_rows($result))
				{
					$responses = array();
					while ($row = mysql_fetch_assoc($result))
					{
						array_push($responses, $row['desr']);
					}
				}
				$result = GetQuestionFromID($id);
				$row = mysql_fetch_assoc($result);
			}	
#print_r($responses);
			if ($row['type'] != 'd')
			{
				$percentages = GetPercentageArray($row);
			}
			?>
				<table class="questionTable">
					<tr class="toprow">
						<td class="number"></td>
						<td class="question">Question</td>
						<?php
						if ($row['type'] != 'd')
						{
							RenderLeftCaptionHeading($row);
							RenderChoiceHeadings($row);
							RenderRightCaptionHeading($row);
							RenderNAHeading($row);
							RenderNullHeading();
							RenderScoreHeading($row);
						}
						else
						{
							echo '<td class="response">Response</td>';
						}
						?>
					</tr>
					<tr class="bottomrow">
						<td class="number"><?php echo $count; ?></td>
						<td class="question"><?php echo $row['questions']; ?></td>
						<?php
						if ($row['type'] != 'd')
						{
							RenderLeftCaption($row);
							RenderChoiceResults($row);
							RenderRightCaption($row);
							RenderNAResults($row);
							RenderNullResults($row);
							RenderScoreResults($row);
						}
						elseif ($num_responses)
						{
							echo '<td class="response">
								<a href="#" class="resultstoggle '.$row['id'].'">
								Show/Hide all '.$num_responses.' responses
								</a>
							      </td>';
						}
						else
						{
							echo '<td class="response">No results available</td>';
						}
						?>
	
					</tr>
					<?php
						if ($row['type'] != 'd')
						{
					?>
					<tr class="percentagerow">
						<td></td>
						<?php
						RenderCBest($row);
						RenderBlankLeftCaption($row);
						RenderPercentages($row, $percentages);
						RenderBlankRightCaption($row);
						RenderNAPercentages($row, $percentages);
						RenderNullPercentages($row, $percentages);
						?>
					</tr>
					<?php
					
						}
						elseif ($num_responses)
						{
							foreach ($responses as $response)
							{
								echo '<tr class="responserow '.$row['id'].' hidden">
									<td colspan="3" class="responseelement">'.nl2br(htmlspecialchars($response)).'</td>
									</tr>';
							}
						}
						
					?>
				</table>
<?php		
			$id = GetNextQuestionID($id);
			$count++;
		}

	}
	elseif ($_GET['id'] != "" && !IsCritiqueHit($_GET['id'])) {
		echo 'No one has completed this critique yet.';
	}
	else
	{
		echo '<div id="cMessage">Sorry, but an unexpected error occured. No ID was provided to query the database!</div>';
		echo '<div id="cSuccess"></div>';
	}
}

?>


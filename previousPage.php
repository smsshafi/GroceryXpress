<?php
	if (!isset($_POST['returnURL']) || $_POST['returnURL'] == "")
	{
		$previousPage = "javascript:javascript:history.go(-1)";
	}
	else
	{
		$previousPage = $_POST['returnURL'];
	}
	
?>
<div class="bottomnavigation">
<a href="<?php echo $previousPage;?>">Previous Page</a>
&nbsp;|&nbsp;
<a href="controlpanel.php">Main Menu</a>
</div>



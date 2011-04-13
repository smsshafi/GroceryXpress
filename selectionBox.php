<?php include 'siteconfig.php'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $sCssFile.$sAllJs; ?>
		<title>Modify Course Information</title>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#myButton").click(function(){
					$("#mySelect").attr('value',$("#myText").attr('value'));
				});
			})
		</script>
	</head>
	<body>
		<select id="mySelect">
			<option value="1">shams</option>
			<option value="2">shafiq</option>
		</select>
		<input type="button" id="myButton" value="Update"/>
		<input type="text" id="myText" value=""/>
	</body>
</html>

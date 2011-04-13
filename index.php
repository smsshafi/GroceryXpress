<?php include 'siteconfig.php'; ?>
<?php include 'regularloginoptionalheader.php'; ?>
<?php $page_title = 'Welcome'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	<?php echo $sCssFile.$sJQueryFile.$sCommonJsFile; ?>
</head>

<body>
	<?php include('regularheader.php'); ?>
		 
	<div class="content"> 
		<img src="<?php echo $sWebRoot.'/';?>images/dummy-content.jpg" style="width: 100%"/>
	</div>
</body>
</html>

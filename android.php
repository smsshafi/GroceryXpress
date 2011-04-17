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
        <a href="https://market.android.com/details?id=com.groceryxpress&feature=search_result">
        <img src="<?php echo $sWebRoot.'/';?>images/android-phone.jpg" style="width: 100%"/>
        </a>
    </div>
</body>
</html>

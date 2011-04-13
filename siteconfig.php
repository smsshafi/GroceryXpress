<?php 
    include 'localsettings.php';
	$sDocType			= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	$sCssFile			= '<link href="'.$sWebRoot.'/default.css" rel="stylesheet" type="text/css" media="screen" />';
	$sCssFile			.= '<link href="'.$sWebRoot.'/defaultprint.css" rel="stylesheet" type="text/css" media="print" />';
    $sCssFile           .= '<link rel="SHORTCUT ICON" href="'.$sImageBasePath.'/g.png">';
	$sCssFile 			.= '<!--[if IE 6]><link href="'.$sWebRoot.'/ie6.css" rel="stylesheet" type="text/css" media="screen" /><![endif]-->';
	$sCssFile			.= '<!--[if IE 7]><link href="'.$sWebRoot.'.ie7.css" rel="stylesheet" type="text/css" media="screen" /><![endif]-->';

    $sAdminCssFile			= '<link href="'.$sWebRoot.'/default-admin.css" rel="stylesheet" type="text/css" media="screen" />';
    $sAdminCssFile          .= '<link rel="SHORTCUT ICON" href="'.$sImageBasePath.'/g.png">';
    $sAdminCssFile			.= '<link href="'.$sWebRoot.'/defaultprint.css" rel="stylesheet" type="text/css" media="print" />';
    $sAdminCssFile 			.= '<!--[if IE 6]><link href="'.$sWebRoot.'/ie6.css" rel="stylesheet" type="text/css" media="screen" /><![endif]-->';
    $sAdminCssFile			.= '<!--[if IE 7]><link href="'.$sWebRoot.'/ie7.css" rel="stylesheet" type="text/css" media="screen" /><![endif]-->';
    
	$sJQueryFile			= '<script type="text/javascript" src="'.$sWebRoot.'/jquery.js"></script>';
	//$sJQueryFormsFile		= '<script type="text/javascript" src="'.$sWebRoot.'/jqueryfield.js"></script>';
	$sJQueryBlockUiFile		= '<script type="text/javascript" src="'.$sWebRoot.'/jqueryblockui.js"></script>';
	$sCommonJsFile			= '<script type="text/javascript" src="'.$sWebRoot.'/common.js"></script>';
    $sNotificationJsFile    = '<script type="text/javascript" src="'.$sWebRoot.'/notification.js"></script>';
    $sShoppingListJsFile    = '<script type="text/javascript" src="'.$sWebRoot.'/shoppinglist.js"></script>';
    $sSearchJsFile          = '<script type="text/javascript" src="'.$sWebRoot.'/search.js"></script>';
    $sMessageJsFile         = '<script type="text/javascript" src="'.$sWebRoot.'/message.js"></script>';
	$sGenericCrudFunctionsJsFile	= '<script type="text/javascript" src="'.$sWebRoot.'/genericCrudFunctions.js"></script>'; 
	$sAjaxFileUploadJsFile		= '<script type="text/javascript" src="'.$sWebRoot.'/ajaxfileupload.js"></script>'; 
	$sAllJs				= $sJQueryFile.$sJQueryBlockUiFile.$sCommonJsFile.$sGenericCrudFunctionsJsFile.$sNotificationJsFile.$sShoppingListJsFile.$sSearchJsFile.$sMessageJsFile;
	$sTitle				= 'GroceryXpress';
	$sMasterAdminLevel		= 1;

    $sGroceryStoreName  = "Neha Groceries";
    $sLogoPath          = $sImageBasePath.'/logo2-small.png';
?>
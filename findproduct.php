<?php include 'regularloginoptionalheader.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>
<?php
    $search = "";
    if (((!isset($_GET['search']) || $_GET['search'] == "") && (!isset($_GET['category']) || $_GET['category'] == "")) || (!isset($_GET['page']) || $_GET['page'] == "")) {
        header("Location: ./storecatalog.php");
    }
    else
    {
        
        $page = 0;
        if (isset($_GET['page']) && $_GET['page'] != "") {
            $page = $_GET['page'];
        }
		
        if (isset($_GET['category']) && $_GET['category'] != "") {
            $num_pages = GetNumSearchPages($_GET['category'], true);
            if (isset($logged_in) && $logged_in == true) {
                $result = SearchCategory($_GET['category'], $page, null, $logged_in, $_SESSION['userid']);
            }
    		else {
                $result = SearchCategory($_GET['category'], $page);
            }
        }
		else {
            $num_pages = GetNumSearchPages($_GET['search']);
			$search = $_GET['search'];
        
    		if (isset($logged_in) && $logged_in == true) {
                $result = SearchProduct($_GET['search'], $page, null, $logged_in, $_SESSION['userid']);
            }
    		else
            {
                $result = SearchProduct($_GET['search'], $page);
            }
        }
        
    }

?>
<?php $page_title = 'Find Product'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	<?php echo $sCssFile.$sAllJs; ?>
	
	<script type="text/javascript">
        <?php if (isset($logged_in) && $logged_in == true) {?>
        var user_id=<?php if (isset($_SESSION['userid']) && $_SESSION['userid'] != "") {echo $_SESSION['userid'];} ?>;
        <?php
            }
	    ?>
		
        
	</script>
</head>

<body>
	<?php include('message.php'); ?>
	<?php include('regularheader.php'); ?>
	
	<div class="content"> 
        <div class="fullcolumn">
				<h1>Find A Product</h1>
				<div style="padding: 10px;">
					<form id="frm_search" name="frm_search" method="GET" action="findproduct.php" style="position: relative;">
						<label for="search"></label>
						 <input type="text" name="search" 
						id="search" style="width: 400px;" value="<?php echo $search; ?>"/> 
						<input type="submit" id="do_search" value="Find"/> 
                        <br/><i>Example: Butter</i> 
						<input class="hidden" name="page" id="page" type="text" 
                        value="1"/>
					</form>	
				</div>
			</div>
		<div class="fullcolumn">
			<h1>Search Results</h1>
            <?php
            if (!mysql_num_rows($result) == 0) {     
                $search_pages =	'<div style="margin: 10px; border: 1px dashed; padding-left: 10px; font-size: 110%;">Page: &nbsp;';
                
                $counter = 0;
                
                while ($num_pages > 0) {
                    $class = "";
                    $num_pages--;
                    $counter++;
                    if (isset($_GET['category']) && $_GET['category'] != "") {
                        $url = $_SERVER['PHP_SELF'].'?category='.urlencode($_GET['category']).'&page='.$counter;
                    }
                    if (isset($_GET['search']) && $_GET['search'] != "") {
                        $url = $_SERVER['PHP_SELF'].'?search='.$_GET['search'].'&page='.$counter;
                    }
                    
                    if ($_GET['page'] == $counter) {
                        $class = "currentsearchpage";
                    }
                    $search_pages .= '<a href="'.$url.'" class="'.$class.'">'.$counter.'</a>&nbsp;&nbsp;&nbsp;&nbsp;';
                }
				$search_pages .= '</div>';
                echo $search_pages;
                
                $context = "search";
                include 'productlist.php';

				echo $search_pages;
            }
            else
            {

                echo '<div style="margin-left: 10px; padding-left: 10px;">';

    			if (isset($_GET['category']) && $_GET['category'] != "") {
                    echo '<p>We found nothing under the category '.$_GET['category'].'.</p>';
    			}
    			else {
                
                    echo '<p>We found nothing called '.$_GET['search'].'. Please try 
                        searching for something else.</p>';
                    echo '</div>';
                }
            }
            ?>
            </div> 
        </div> 
    </body>
</html>

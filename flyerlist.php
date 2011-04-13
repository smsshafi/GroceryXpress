<table class="flyertable" style="width: 740px; margin-left: 30px; margin-bottom: 30px;" cellspacing="0">
<?php
if ($result) {
	
	$count = 0;
	echo '<tr>';
    while ($row = mysql_fetch_assoc($result)) {
    	$count++;
    	
    	
        $max_string_length = 200;
        $max_title_length = 30;
        if ($context == 'featuredproducts') {
			$max_string_length = 50;
        }
		if ($context == 'search') {
			$max_string_length = 100000;
        }
        
        $image_url = $row['image'];
        $title = $row['title'];
        $desc = $row['description'];
		$id = $row['id'];
        $quantity = 0;
        $full_title = $title;
        $full_desc = $desc;

		if (isset($row['quantity']) && $row['quantity'] != "") {
            $quantity = $row['quantity'];
        }
		if (isset($row['aisle_name']) && $row['aisle_name'] != "") {
            $aisle_name = $row['aisle_name'];
        }
        if (isset($row['aisle_number']) && $row['aisle_number'] != "") {
            $aisle_number = $row['aisle_number'];
        }
        if (isset($row['stock_aisle_position']) && $row['stock_aisle_position'] != "") {
            $aisle_position = $row['stock_aisle_position'];
        }

        if (isset($row['stock_quantity']) && $row['stock_quantity'] != "") {
            $stock_quantity = $row['stock_quantity'];
        }
        if (strlen($desc) > $max_string_length) {
            $desc = substr($desc, 0, $max_string_length)."...";
        }
        
    	if (strlen($title) > $max_title_length) {
            $title = substr($title, 0, $max_title_length)."...";
        }
        $price = $row['price'];
        $saleprice = $row['saleprice'];
        echo '<td style="width: 50%">';
        include 'productsmallflyer.php';
        echo '</td>';
    	if (($count % 2) == 0) {
    		echo '</tr><tr>';
    	}
    }
}
?>
</table>

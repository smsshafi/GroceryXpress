<?php
if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
        $max_string_length = 200;
        if ($context == 'featuredproducts') {
			$max_string_length = 50;
        }
		if ($context == 'search') {
			$max_string_length = 100000;
        }
        
        $image_url = $row['image'];
        $title = $row['title'];
        $desc = $row['description'];
        $full_title = $title;
        $full_desc = $desc;
		$id = $row['id'];
        $quantity = 0;

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
        $price = $row['price'];
        $saleprice = $row['saleprice'];
        include 'productsmall.php';
    }
}
?>

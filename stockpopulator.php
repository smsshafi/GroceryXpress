<?php

return;
$affected_rows = 0;

function is_odd($num){
    return (is_numeric($num)&($num&1));
}
 
function is_even($num){
    return (is_numeric($num)&(!($num&1)));
}


function ClearAisles($store_id) {
    global $affected_rows;
    $SQLConn = SQLConnect();
    $result = mysql_query("DELETE FROM fydp_aisles WHERE store_id='$store_id'");
    $affected_rows = mysql_affected_rows();
    $error = mysql_error();
    SQLDisconnect($SQLConn);
    if ($error == "") {
        return true;
    }
    return false;

}

function ClearStocks($store_id) {
}

function ClearAllStocks() {
    global $affected_rows;
    $SQLConn = SQLConnect();
    $result = mysql_query("DELETE FROM fydp_stocks");
    $affected_rows = mysql_affected_rows();
    $error = mysql_error();
    SQLDisconnect($SQLConn);
    if ($error == "") {
        return true;
    }
    return false;
}

function ClearAllAisles() {
}

function BuildAislesAddProductsFromCategories($store_id) {
    $categories = GetCategories();
    $num_categories = mysql_num_rows($categories);

    
    $aisle_count = 0;
    while($each_category_row = mysql_fetch_assoc($categories)) {
        $SQLConn = SQLConnect();
        $aisle_count++;

        $aisle_name = $each_category_row['name'];
        $category_id = $each_category_row['id'];
        $result = mysql_query("INSERT INTO fydp_aisles(number, name, store_id) VALUES('$aisle_count', '$aisle_name', '$store_id')");
        $aisle_id = mysql_insert_id();
        if (mysql_error() == "") {
            echo "<br/>Added aisle $aisle_count - $aisle_name";
        }
        else {
            echo "<br/>Failed to build aisles!";
            ClearAisles($store_id);
            return;
        }

        $products = GetProductsFromCategoryID($category_id);
        $num_products = mysql_num_rows($products);
        if ($num_products > 0) {
            while ($each_product_row = mysql_fetch_assoc($products)) {
                $SQLConn = SQLConnect();
                $aisle_position = rand(1,8);
                if ($aisle_count == 1) {
                    while (!is_even($aisle_position)) {
                        $aisle_position = rand(1,8);
                    }
                }
                if ($aisle_count == $num_categories) {
                    while (!is_odd($aisle_position)) {
                        $aisle_position = rand(1,8);
                    }
                }
                
                $product_quantity = rand(3,20);
                $product_id = $each_product_row['id'];
                $result = mysql_query("INSERT INTO fydp_stocks(product_id, store_id, aisle_id, aisle_position, quantity) VALUES('$product_id', '$store_id', '$aisle_id', '$aisle_position', '$product_quantity')");
                if (mysql_error() == "") {
                    echo "-$aisle_position ";
                }
            }
        }
        else
        {
            echo " - No products to add in this aisle!";
        }
    }
}

include 'etc.php';

echo "Stock Populator<br/>";

$stores = GetStores();
ClearAllAisles();

if (is_bool($temp = ClearAllStocks()) && $temp == true)
{
    echo "<br/>Cleared all $affected_rows stocks!<br/>";
}
else
{
    echo "<br/>Failed to clear stocks!<br/>";
    return;
}

while ($each_store_row = mysql_fetch_assoc($stores)) {
    $store_id = $each_store_row['id'];
    echo "<br/>---------------------------------------------------------------------------------------------<br/>";
    echo "<br/>".$each_store_row['name']." at ".$each_store_row['address']."<br/>";
    
    if (is_bool($temp = ClearAisles($store_id)) && $temp == true) { 
        echo "<br/>Cleared all $affected_rows aisles!<br/>";
    }
    BuildAislesAddProductsFromCategories($store_id);

}

?>

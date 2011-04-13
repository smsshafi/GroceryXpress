<?php
    include 'etc.php';
    if (isset($_GET['add']) && $_GET['add'] == 1) {
        $result = AddProductToList($_POST['product_id'], $_POST['user_id']);
        if (is_bool($result) && $result == true) {
            $message = "The product has been succesfully added to your <a href=\"shoppinglist.php\">shopping list</a>.";
            $success = true;
        }
        else
        {
            $message = "Failed to add the product to your <a href=\"shoppinglist.php\">shopping list</a>. ($result)";
            $success = false;
        }
        $response = array('message' => $message, 'success' => $success);
        echo json_encode($response);

    }

    if (isset($_GET['remove']) && $_GET['remove'] == 1) {
        $result = RemoveProductFromList($_POST['product_id'], $_POST['user_id']);
        if (is_bool($result) && $result == true) {
            $message = "The product has been succesfully removed from your <a href=\"shoppinglist.php\">shopping list</a>.";
            $success = true;
        }
        else
        {
            $message = "Failed to remove the product from your <a href=\"shoppinglist.php\">shopping list</a>. ($result)";
            $success = false;
        }
        $response = array('message' => $message, 'success' => $success);
        echo json_encode($response);
    }

    if (isset($_GET['increment']) && $_GET['increment'] == 1) {
        $result = IncrementProductInList($_POST['product_id'], $_POST['user_id']);
        if (is_bool($result) && $result == true) {
            $message = "The product quantity has been updated in your <a href=\"shoppinglist.php\">shopping list</a>.";
            $success = true;
        }
        else
        {
            $message = "Failed to the product quantity in your <a href=\"shoppinglist.php\">shopping list</a>. ($result)";
            $success = false;
        }
        $response = array('message' => $message, 'success' => $success);
        echo json_encode($response);
    }

    if (isset($_GET['decrement']) && $_GET['decrement'] == 1) {
        $result = DecrementProductInList($_POST['product_id'], $_POST['user_id']);
        if (is_bool($result) && $result == true) {
            $message = "The product quantity has been updated in your <a href=\"shoppinglist.php\">shopping list</a>.";
            $success = true;
        }
        else
        {
            $message = "Failed to the product quantity in your <a href=\"shoppinglist.php\">shopping list</a>. ($result)";
            $success = false;
        }
        $response = array('message' => $message, 'success' => $success);
        echo json_encode($response);
    }

    if (isset($_GET['shopping_list_count']) && $_GET['shopping_list_count'] == 1) {
        $result = GetShoppingList($_POST['user_id']);
        $response = array('shopping_list_count' => mysql_num_rows($result));
        echo json_encode($response);
    }
    
    if (isset($_GET['updatesubtotal']) && $_GET['updatesubtotal'] == 1) {
        $result = GetSubTotal($_POST['user_id']);
        $result = Currencize($result);
        $response = array('subtotal' => $result);
        echo json_encode($response);
    }


?>

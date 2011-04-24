<?php
    include_once '../etc.php';
    
    $response['success'] = false;
    
    if (isset($_POST['userid']) && $_POST['userid'] != "" && isset($_POST['product_id']) && $_POST['product_id'] != "") {
        $response['success'] = AddProductToList($product_id, $user_id);
    }
    
    echo json_encode($response);
    

?>
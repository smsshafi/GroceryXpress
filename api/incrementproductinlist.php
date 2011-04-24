<?php
    include_once '../etc.php';
    
    $response['success'] = false;
    
    if (isset($_POST['userid']) && $_POST['userid'] != "" && isset($_POST['product_id']) && $_POST['product_id'] != "") {
        $response['success'] = IncrementProductInList($_POST['product_id'], $_POST['userid'])
    }
    
    echo json_encode($response);
    

?>

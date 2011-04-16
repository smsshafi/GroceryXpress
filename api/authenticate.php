<?php
    include_once '../etc.php';
    if (isset($_POST['email']) && $_POST['email'] != "" && isset($_POST['password']) && $_POST['password'] != "") {
        $response = AuthenticateRegularUser($_POST['email'], $_POST['password'], true);
        if (!$response['error']) {
            $response['userid'] = GetUserIDFromEmail($_POST['email']);
        }
        $json_response = json_encode($response);
        echo $json_response;
    }
    

?>
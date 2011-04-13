<?php
    include 'etc.php';
    if (isset($_GET['findcloseststore']) && $_GET['findcloseststore'] == 1) {
        echo FindNearestStore($_POST['lat'], $_POST['lng']);
    }

    if (isset($_GET['save']) && $_GET['save'] == 1) {
        if (!isset($_POST['subscription']) || $_POST['subscription'] == "" || $_POST['subscription'] == 'false') {
            $_POST['subscription'] = 0;
        }
        else
        {
            $_POST['subscription'] = 1;
        }

        $result = UpdateUser($_POST);
        $response = array();
        if (is_bool($result) && $result == true) {
            $response = array('message' => "Your changes have been saved successfully.", 'success' => true);
        }
        else
        {
            $response = array('message' => $result, 'success' => false);
        }
        echo json_encode($response);
    }

    if (isset($_GET['updatestore']) && $_GET['updatestore'] == 1) {
        $result = UpdateUser($_POST);
    }
?>

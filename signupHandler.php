<?php
    include 'etc.php';

    if (isset($_GET['checkemail']) && $_GET['checkemail'] == 1) {
        if (CheckUniqueUserEmail($_POST['email']))
        {
            echo 'success';
        }
    }

?>

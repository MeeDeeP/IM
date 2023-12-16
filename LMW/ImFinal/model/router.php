<?php
session_start();
 require "backend.php";
if (isset($_POST['choice'])) {
    switch ($_POST['choice']) {
        case 'login':
            $backend = new backend();
            echo $backend->dologin($_POST['username'],$_POST['password']);
            break;
        case 'register':
            $backend = new backend();
            echo $backend->doregister($_POST['userid'],$_POST['firstname'],$_POST['lastname'],$_POST['username'],$_POST['password'],$_POST['address'],$_POST['email'],$_POST['user_role']);
            break;
        case 'update':
            $backend = new backend();
            echo $backend->doupdate($_POST['userid'],$_POST['firstname'],$_POST['lastname'],$_POST['username'],$_POST['address'],$_POST['email'],$_POST['user_role'],$_POST['counterlock']);
        break;
        case 'getuserID':
            $backend = new backend();
            echo $backend->viewUser();
            break;
            case 'student':
                $backend = new backend();
                echo $backend->doupdate($_POST['studid'],$_POST['firstname'],$_POST['lastname'],$_POST['gender'],$_POST['section']);
            break;
    }

}
?>
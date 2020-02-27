<?php
/**
 * Receive Ajax requests and connect to controller
 */
include_once "controller.php";

$controller = new UsersController();

if (!empty($_GET["get_action"])) {
    switch ($_GET["get_action"]) {
        case "list": 
            echo $controller->all(); 
            break;
        case "get": 
            echo $controller->get($_GET["user_id"]);
            break;
        case "delete": 
            echo $controller->delete($_GET["user_id"]);
    }
}

if (!empty($_POST["post_action"])) {
    $first_name = $_POST["first_name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    if (!$first_name || !$surname || !$email || !$username || !$password) {
        die("All fields are required");
    }
    
    if ($_POST["post_action"] == "create") {
        echo $controller->create($first_name, $surname, $email, $username, $password);
    }
    if ($_POST["post_action"] == "update") {
        $user_id = $_POST["user_id"];
        echo $controller->update($first_name, $surname, $email, $username, $password, $user_id);
    }
}
?>
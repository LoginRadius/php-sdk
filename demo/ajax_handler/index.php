<?php

$page = isset($_GET["page"]) ? trim($_GET["page"]) : '';
$action = isset($_POST["action"]) ? trim($_POST["action"]) : '';

if (file_exists($page . '.php')) {
    require_once $page . '.php';
    if (function_exists($action)) {
        echo $action($_REQUEST);
    }
    else {
        echo 'Action not Exist.';
    }
}
<?php
session_start();
header("Content-Type:text/html;charset= utf-8");
require_once("connection.php");
require_once("classes/Meta.php");
require_once("classes/Meta_Admin.php");
require_once("functions.php");

    if ($_GET['option']) {
        $class = clean($_GET['option']);
    } else {
        $class = 'main';
    }
    if (file_exists("classes/" . $class . ".php")) {
        include("classes/" . $class . ".php");
        if (class_exists($class)) {
            $object = new $class;
            $object->get_body();
        } else {
            exit("<p>Неправильные данные для входа</p>");
        }
    } else {
        exit("<p>Неправильный адрес</p>");
    }

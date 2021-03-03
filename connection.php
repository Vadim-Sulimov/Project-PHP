<?php
define("HOST","localhost");
define("USER","root");
define("PASSWORD","root");
define("DB","project");

$db = @mysqli_connect(HOST, USER, PASSWORD, DB) or die('Нет соединения с БД');
mysqli_set_charset($db, 'utf8') or die('Не установлена кодировка соединения');